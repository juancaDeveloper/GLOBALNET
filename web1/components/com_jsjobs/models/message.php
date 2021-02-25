<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     https://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest::getVar('option', 'com_jsjobs');

class JSJobsModelMessage extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function canAddMessage($uid) {
        $db = $this->getDBO();
        $returnvalue = array();
        $packagedetail = array();
        if (($uid == 0) || ($uid == '')) {
            return false;
        }
        if(!is_numeric($uid)) return false;
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        $newlisting_required_package = 1;
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }
        if ($newlisting_required_package == 0) {
            return true;
        } else {
            $query = "SELECT role from #__js_job_userroles where uid=" . $uid;
            $db->setQuery($query);
            $isjobseeker = $db->loadResult();
            if ($isjobseeker == 2)
                return true;

            $query = "SELECT package.id, package.messageallow, package.packageexpireindays, payment.id AS paymentid, payment.created
			FROM `#__js_job_employerpackages` AS package
			JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
			WHERE payment.uid = " . $uid . "
			AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
			AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $packages = $db->loadObjectList();
            $allow = 0;
            foreach ($packages AS $package) {
                if ($allow == 0) {
                    if ($package->messageallow == 1) {
                        $allow = true;
                        return true;
                    }
                }
            }
            return $allow;
        }
    }

    function getMessagesbyJobsforJobSeeker($uid, $limit, $limitstart) {
        $result = array();
        $db = $this->getDBO();

        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        $total = 0;
        if ($this->_client_auth_key != "") {
            $fortask = "getmessagesbyjobsforjobseeker";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['uid'] = $uid;
            $data['limit'] = $limit;
            $data['limitstart'] = $limitstart;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['messagejobseeker']) AND $return_server_value['messagejobseeker'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Message By jobseeker";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $result[0] = (object) array();
                $result[1] = 0;
            } else {
                $parse_data = array();
                if (isset($return_server_value['jsmessages']) && is_array($return_server_value['jsmessages'])) {
                    foreach ($return_server_value['jsmessages'] AS $rel_data) {
                        $parse_data[] = (object) $rel_data;
                    }
                }
                $result[0] = $parse_data;
                $result[1] = $return_server_value['total'];
            }
        } else {
            $query = "SELECT message.id
                        FROM `#__js_job_messages` AS message
                        JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                        JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
                        JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                        WHERE resume.uid = " . $uid . " AND message.status = 1
                        GROUP BY message.jobid";
            $db->setQuery($query);
            $totobj = $db->loadObjectList();
            foreach ($totobj as $obj)
                $total++;

            if ($total <= $limitstart)
                $limitstart = 0;

            $query = "SELECT message.id, message.jobid, message.resumeid, job.title, job.created, company.id as companyid, company.name as companyname
                        ,(SELECT COUNT(id) FROM `#__js_job_messages` WHERE sendby != " . $uid . " AND jobid = message.jobid AND isread = 0 AND jobseekerid = " . $uid . ") as unread
                        ,CONCAT(company.alias,'-',companyid) AS companyaliasid
                        ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid
                        ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                        FROM `#__js_job_messages` AS message
                        JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                        JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
                        JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                        WHERE resume.uid = " . $uid . " AND message.status = 1
                        GROUP BY message.jobid
                        ORDER BY message.created DESC ";
            $db->setQuery($query, $limitstart, $limit);
            $messages = $db->loadObjectList();
            $result[0] = $messages;
            $result[1] = $total;
        }

        return $result;
    }

    function getMessagesbyJobs($uid, $limit, $limitstart) {
        $result = array();
        $db = $this->getDBO();

        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        $total = 0;
        if ($this->_client_auth_key != "") {
            $fortask = "getmessagesbyjobs";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['uid'] = $uid;
            $data['limit'] = $limit;
            $data['limitstart'] = $limitstart;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);

            if (isset($return_server_value['messageemployer']) AND $return_server_value['messageemployer'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Message By Employer";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $result[0] = (object) array();
                $result[1] = 0;
            } else {
                $parse_data = array();
                foreach ($return_server_value['empmessages'] AS $rel_data) {
                    $parse_data[] = (object) $rel_data;
                }
                $result[0] = $parse_data;
                $result[1] = $return_server_value['total'];
            }
        } else {
            $query = "SELECT message.id
                        FROM `#__js_job_messages` AS message
                        JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                        JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                        WHERE message.employerid = " . $uid . " AND message.replytoid = 0
                        GROUP BY message.jobid
                        ";
            $db->setQuery($query);
            $totobj = $db->loadObjectList();
            foreach ($totobj as $obj)
                $total++;

            if ($total <= $limitstart)
                $limitstart = 0;

            $query = "SELECT message.id, message.jobid, job.title, job.created, company.id as companyid, company.name as companyname
                        ,(SELECT COUNT(id) FROM `#__js_job_messages` WHERE sendby != " . $uid . " AND isread = 0 AND jobid=message.jobid) as unread
                        ,CONCAT(company.alias,'-',companyid) AS companyaliasid
                        ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                        FROM `#__js_job_messages` AS message
                        JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                        JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                        WHERE message.employerid = " . $uid . " AND message.replytoid = 0
                        GROUP BY message.jobid
                        ORDER BY message.created DESC";
            $db->setQuery($query, $limitstart, $limit);
            $messages = $db->loadObjectList();
            $result[0] = $messages;
            $result[1] = $total;
        }
        return $result;
    }

    function getMessagesbyJob($uid, $jobid, $limit, $limitstart) {
        $result = array();
        $db = $this->getDBO();

        if (is_numeric($jobid) === false)
            return false;
        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        if ($this->_client_auth_key != "") {
            $fortask = "getmessagesbyjob";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['uid'] = $uid;
            $data['jobid'] = $jobid;
            $data['limit'] = $limit;
            $data['limitstart'] = $limitstart;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['messagebyjobs']) AND $return_server_value['messagebyjobs'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Messages By Job";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $result[0] = (object) array();
                $result[1] = 0;
            } else {
                $parse_data = array();
                foreach ($return_server_value['messages'] AS $rel_data) {
                    $parse_data[] = (object) $rel_data;
                }
                $result[0] = $parse_data;
                $result[1] = $return_server_value['total'];
            }
        } else {
            $query = "SELECT count(message.id)
                        FROM `#__js_job_messages` AS message
                        JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                        JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
                        WHERE message.employerid = " . $uid . " AND message.jobid = " . $jobid . " AND message.replytoid = 0
                        GROUP BY message.jobseekerid";
            $db->setQuery($query);

            $msgs = $db->loadObjectList();
            $total = 0;
            foreach ($msgs AS $msg)
                $total++;
            if ($total <= $limitstart)
                $limitstart = 0;

            $query = "SELECT message.id, message.jobid, message.resumeid, job.title, job.created, resume.id as resumeidid, resume.application_title, resume.first_name, resume.middle_name, resume.last_name
                        ,(SELECT COUNT(id) FROM `#__js_job_messages` WHERE jobid = " . $jobid . " AND sendby != " . $uid . " AND isread = 0 AND resume.id = resumeid) as unread
                        ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid, CONCAT(job.alias,'-',job.id) AS jobaliasid
                        FROM `#__js_job_messages` AS message
                        JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                        JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
                        WHERE message.employerid = " . $uid . " AND message.jobid = " . $jobid . " AND message.replytoid = 0
                        GROUP BY message.jobseekerid
                        ORDER BY message.created DESC ";

            $db->setQuery($query, $limitstart, $limit);
            $messages = $db->loadObjectList();
            $result[0] = $messages;
            $result[1] = $total;
        }


        return $result;
    }

    function getMessagesbyJobResume($uid, $jobid, $resumeid, $limit, $limitstart) {
        $result = array();
        $total = 0;
        $db = $this->getDBO();
        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($jobid) == false)
            return false;
        if (is_numeric($resumeid) == false)
            return false;
        $listjobconfig = $this->getJSModel('configurations')->getConfigByFor('listjob');


        if ($this->_client_auth_key != "") {
            $limitstart = $limitstart;
        } else {
            $query = "SELECT count(message.id)
						FROM `#__js_job_messages` AS message
						WHERE message.status = 1 AND message.jobid =" . $jobid . " AND message.resumeid = " . $resumeid;
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total <= $limitstart)
                $limitstart = 0;
            $query = "SELECT message.*, job.title, resume.application_title, resume.first_name, resume.middle_name, resume.last_name, company.logofilename AS companylogo,company.name AS companyname,company.id AS companyid
							FROM `#__js_job_messages` AS message
							JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
							JOIN `#__js_job_companies` AS company ON company.id = job.companyid
							JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
							WHERE message.status = 1 AND message.jobid =" . $jobid . " AND message.resumeid = " . $resumeid . " ORDER BY  message.created DESC";

            $db->setQuery($query, $limitstart, $limit);
            $messages = $db->loadObjectList();
        }
        if ($total > 0)
            $canadd = true;
        else
            $canadd = $this->canAddMessage($uid);

        if ($canadd) {
            if ($this->_client_auth_key != "") {

                $fortask = "getmessagesbyjobresume";
                $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                $data['uid'] = $uid;
                $data['jobid'] = $jobid;
                $data['resumeid'] = $resumeid;
                $data['limitstart'] = $limitstart;
                $data['limit'] = $limit;
                $data['authkey'] = $this->_client_auth_key;
                $data['siteurl'] = $this->_siteurl;
                $encodedata = json_encode($data);
                $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);

                if (isset($return_server_value['messagebyjobresume']) AND $return_server_value['messagebyjobresume'] == -1) { // auth fail 
                    $logarray['uid'] = $this->_uid;
                    $logarray['referenceid'] = $return_server_value['referenceid'];
                    $logarray['eventtype'] = $return_server_value['eventtype'];
                    $logarray['message'] = $return_server_value['message'];
                    $logarray['event'] = "Message By jobs Resume";
                    $logarray['messagetype'] = "Error";
                    $logarray['datetime'] = date('Y-m-d H:i:s');
                    $jsjobsharingobject->write_JobSharingLog($logarray);
                } else {
                    $summary = array();
                    $parse_data = array();
                    foreach ($return_server_value['messages'] AS $rel_data) {
                        $parse_data[] = (object) $rel_data;
                    }
                    $messages = $parse_data;
                    $total = $return_server_value['total'];
                    if (isset($return_server_value['summery']['summery']))
                        $summary = (object) $return_server_value['summery']['summery'];
                }
            }else {
                    $query = "SELECT job.title, resume.application_title, resume.first_name, resume.middle_name
                            , resume.last_name, company.logofilename AS companylogo
                            ,company.name AS companyname,company.id AS companyid,job.id AS jobid
                            ,resume.id AS resumeid,resume.uid AS jobseekerid ,company.uid AS employerid
                            FROM `#__js_job_jobs` AS job
                            JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                            JOIN `#__js_job_resume` AS resume ON resume.id = " . $resumeid . "
                            WHERE job.id = " . $jobid;
                $db->setQuery($query);
                $summary = $db->loadObject();
            }
        }
        //Update the isread field
        $query = "UPDATE `#__js_job_messages` SET isread = 1 WHERE sendby != ".$uid." AND jobid = ".$jobid." AND resumeid = ".$resumeid;
        $db->setQuery($query);
        $db->query();
        $result[0] = $messages;
        $result[1] = $total;
        $result[2] = $canadd;
        if (isset($summary))
            $result[3] = $summary;

        return $result;
    }

    function storeMessage($uid) {
        JRequest::checkToken() or die( 'Invalid Token' );
        $db = JFactory::getDBO();
        $data = JRequest::get('post');
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($data['resumeid']) == false)
            return false;
        if (is_numeric($data['jobid']) == false)
            return false;
        if (is_numeric($uid) == false)
            return false;
        $row = $this->getTable('message');
        $return_status = false;

        if ($this->_client_auth_key != "") {

            // check job and resume local or not 
            $isownjob = 0;
            $isownresume = 0;
            $query = "SELECT id FROM #__js_job_jobs
			WHERE  serverid = " . $data['jobid'];
            $db->setQuery($query);
            $client_jobid = $db->loadResult();
            if ($client_jobid)
                $isownjob = 1;

            $query = "SELECT id FROM #__js_job_resume
			WHERE  serverid = " . $data['resumeid'];
            $db->setQuery($query);
            $client_resumeid = $db->loadResult();
            if ($client_resumeid)
                $isownresume = 1;

            $user = JFactory::getUser();
            $data['sendby'] = $user->id;

            if ($isownresume == 1 && $isownjob == 1) { //store message local
                $serverids['jobid'] = $data['jobid'];
                $serverids['resumeid'] = $data['resumeid'];
                $data['jobid'] = $client_jobid;
                $data['resumeid'] = $client_resumeid;
                $returnvalue = $this->messageValidation($data['jobid'], $data['resumeid']);
                if ($returnvalue != 1)
                    return $returnvalue;

                $config = $this->getJSModel('configurations')->getConfigByFor('messages');
                $data['status'] = $config['message_auto_approve'];
                $conflict = $this->checkString($data['subject'] . $data['message']);
                if ($conflict[0] == false) {
                    $data['status'] = $config['conflict_message_auto_approve'];
                    $data['isconflict'] = 1;
                    $data['conflictvalue'] = $conflict[1];
                }
                $row = $this->getJSModel('jobapply')->storeRowObject($data, $row, false);
                if ($row == false)
                    return false;
                $returnvalue = $this->sendMessageEmail($row->id);
                $data['jobid'] = $serverids['jobid'];
                $data['resumeid'] = $serverids['resumeid'];
            }
            // send data to server 
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $job_log_object = $this->getJSModel('log');
            $data['message_id'] = isset($row->id) ? $row->id : 0;
            $data['replytoid'] = isset($row->id) ? $row->replytoid : 0;
            $data['isread'] = isset($row->id) ? $row->isread : 0;
            $data['status'] = isset($row->id) ? $row->status : 1;
            $data['task'] = isset($row->id) ? 'storeownmessage' : 'storeservermessage';
            $data['isownresumemessage'] = isset($row->id) ? 1 : 0;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['task'] = 'storeownmessage';
            $isownresumemessage = 1;
            $data['isownresumemessage'] = $isownresumemessage;
            $return_value = $jsjobsharingobject->store_MessageSharing($data);
            $job_log_object->log_Store_MessageSharing($return_value);
            $return_status = $return_value['ismessagestore'];
        }else { // localy store data 
            $data['message'] = $this->getJSModel('common')->getHtmlInput('message');
            $returnvalue = $this->messageValidation($data['jobid'], $data['resumeid']);
            if ($returnvalue != 1)
                return $returnvalue;
            $config = $this->getJSModel('configurations')->getConfigByFor('messages');
            $data['status'] = $config['message_auto_approve'];
            $conflict = $this->checkString($data['subject'] . $data['message']);
            if ($conflict[0] == false) {
                $data['status'] = $config['conflict_message_auto_approve'];
                $data['isconflict'] = 1;
                $data['conflictvalue'] = $conflict[1];
            }
            $user = JFactory::getUser();
            $data['sendby'] = $user->id;
            $row = $this->getJSModel('jobapply')->storeRowObject($data, $row, false);
            if ($row == false)
                return false;
            $return_status = $row->status;
            $returnvalue = $this->sendMessageEmail($row->id);
        }
        if ($return_status == 1) {
            if (isset($returnvalue)) {
                if ($returnvalue == 1)
                    return true;
                else
                    return 4;
            }else {
                return true;
            }
        } elseif ($return_status == 0)
            return 2;
    }

    function checkString($message) {
        $email_pattern = '/[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)*\@[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)+/';
        $domain_pattern = '@^(?:http://)?([^/]+)@i';
        $regex = '/(?:1(?:[. -])?)?(?:\((?=\d{3}\)))?([2-9]\d{2})(?:(?<=\(\d{3})\))? ?(?:(?<=\d{3})[.-])?([2-9]\d{2})[. -]?(\d{4})(?: (?i:ext)\.? ?(\d{1,5}))?/';
        $retrun = array();
        preg_match($email_pattern, $message, $email);
        if ($email[0] != '') {
            $return[0] = false;
            $return[1] = $email[0];
            return $return;
        }

        preg_match($domain_pattern, $message, $matches);
        $host = $matches[1];
        preg_match('/[^.]+\.[^.]+$/', $host, $matches);
        if ($matches[0] != '') {
            $return[0] = false;
            $return[1] = $matches[0];
            return $return;
        }

        preg_match($regex, $message, $phone);
        if ($phone[0] != '') {
            $return[0] = false;
            $return[1] = $phone[0];
            return $return;
        }
        $return[0] = true;
        return $return;
    }

    function sendMessageEmail($messageid) {
        $db = $this->getDBO();
        if ((is_numeric($messageid) == false) || ($messageid == 0) || ($messageid == ''))
            return false;
        $query = "SELECT job.title as jobtitle
                        , resume.application_title as resumetitle, resume.email_address as jobseekeremail
                        , company.name as companyname, company.contactemail as employeremail
                        , message.subject, message.message, message.employerid, message.sendby
						,concat(resume.first_name, resume.last_name) AS jobseekername 
						,company.contactname as employername
                    FROM `#__js_job_messages` AS message
                    JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                    JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
                    JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                    WHERE message.id = " . $messageid;
        $db->setQuery($query);
        $message = $db->loadObject();
        if ($message) {
            $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = 'message-email'";
            $db->setQuery($query);
            $template = $db->loadObject();
            $msgSubject = $template->subject;
            $msgBody = $template->body;
            $msgSubject = str_replace('{COMPANY_NAME}', $message->companyname, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $message->employername, $msgSubject);
            $userrole = $this->getJSModel('userrole')->getUserRoleByUid($message->sendby);
            if ($userrole == 1) { // send by employer
                $msgBody = str_replace('{NAME}', $message->jobseekername, $msgBody);
                $msgBody = str_replace('{SENDER_NAME}', $message->employername, $msgBody);
                $to = $message->jobseekeremail;
            } else {
                $msgBody = str_replace('{NAME}', $message->employername, $msgBody);
                $msgBody = str_replace('{SENDER_NAME}', $message->jobseekername, $msgBody);
                $to = $message->employeremail;
            }
            $msgBody = str_replace('{JOB_TITLE}', $message->jobtitle, $msgBody);
            $msgBody = str_replace('{COMPANY_NAME}', $message->companyname, $msgBody);
            $msgBody = str_replace('{RESUME_TITLE}', $message->resumetitle, $msgBody);
            $msgBody = str_replace('{SUBJECT}', $message->subject, $msgBody);
            $msgBody = str_replace('{MESSAGE}', $message->message, $msgBody);

            $config = $this->getJSModel('configurations')->getConfigByFor('email');

            $message = JFactory::getMailer();
            $sender = array($config['mailfromaddress'], $config['mailfromname']);
            $message->setSender($sender);
            if(!empty($to)){
                $message->addRecipient($to); //to email
                //$message->addBCC($bcc);
                $message->setSubject($msgSubject);
                $message->setBody($msgBody);
                $message->IsHTML(true);
                $sent = $message->send();
            }
            return 1;
        } else {
            return 4;
        }
    }

    function messageValidation($jobid, $resumeid) {
        if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
            return false;
        if ((is_numeric($resumeid) == false) || ($resumeid == 0) || ($resumeid == ''))
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT resume.uid FROM #__js_job_resume AS resume WHERE resume.id = " . $resumeid;
        $db->setQuery($query);
        $resume = $db->loadObject();
        if (isset($resume)) {
            if ($resume->uid)
                $returnvalue = 1;
            else
                return 5;
        } else
            return 5;

        $query = "SELECT job.uid FROM #__js_job_jobs AS job WHERE job.id = " . $jobid;
        $db->setQuery($query);
        $job = $db->loadObject();
        if (isset($job)) {
            if ($job->uid)
                $returnvalue = 1;
            else
                return 6;
        } else
            return 6;

        return $returnvalue;
    }

}
?>
    
