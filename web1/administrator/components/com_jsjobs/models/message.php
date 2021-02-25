<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelMessage extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getMessagesbyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "SELECT * FROM #__js_job_messages WHERE id = " . $id;
        $db->setQuery($query);

        $message = $db->loadObject();
        $status = array(
            '0' => array('value' => 0, 'text' => JText::_('Pending')),
            '1' => array('value' => 1, 'text' => JText::_('Approve')),
            '2' => array('value' => -1, 'text' => JText::_('Reject')),);
        $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', $message->status);
        $result[0] = $message;
        $result[1] = $lists;
        return $result;
    }

    function getMessagesbyJobResume($uid, $jobid, $resumeid, $limit, $limitstart) {
        $result = array();
        $db = $this->getDBO();
        if (is_numeric($uid) == false)
            return false;
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($jobid) == false)
            return false;
        if (is_numeric($resumeid) == false)
            return false;
        $listjobconfig = $this->getJSModel('configuration')->getConfigByFor('listjob');
        $query = "SELECT count(message.id)
                        FROM `#__js_job_messages` AS message
                        WHERE message.status = 1 AND message.jobid =" . $jobid . " AND message.resumeid = " . $resumeid;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT message.*, job.title, resume.application_title, resume.first_name, resume.middle_name, resume.last_name, job.uid AS employerid, resume.uid AS jobseekerid
                FROM `#__js_job_messages` AS message
                JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
                WHERE message.status = 1 AND message.jobid =" . $jobid . " AND message.resumeid = " . $resumeid . " ORDER BY  message.created DESC";

        $db->setQuery($query, $limitstart, $limit);
        $messages = $db->loadObjectList();
        $query = "SELECT job.id as jobid, job.uid as employerid, job.title, resume.id as resumeid, resume.uid as jobseekerid, resume.application_title, resume.first_name, resume.middle_name, resume.last_name,company.logofilename AS companylogo,company.id AS companyid
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_resume` AS resume ON resume.id = " . $resumeid . "
                        JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                        WHERE job.id = " . $jobid;
        $db->setQuery($query);
        $summary = $db->loadObject();
        $result[0] = $messages;
        $result[1] = $total;
        $result[3] = $summary;

        return $result;
    }

    function getMessagesbyJobResumes($uid, $jobid, $resumeid) {
        $result = array();
        $db = $this->getDBO();
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($jobid) == false)
            return false;
        if (is_numeric($resumeid) == false)
            return false;
        $status = array(
            '0' => array('value' => 0, 'text' => JText::_('Pending')),
            '1' => array('value' => 1, 'text' => JText::_('Approve')),
            '2' => array('value' => -1, 'text' => JText::_('Reject')),);
        $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', 1);
        $query = "SELECT message.*, job.title, resume.application_title, resume.first_name, resume.middle_name, resume.last_name
                FROM `#__js_job_messages` AS message
                JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
                WHERE message.status = 1 AND message.jobid =" . $jobid . " AND message.resumeid = " . $resumeid . " ORDER BY  message.created DESC";

        $db->setQuery($query);
        $messages = $db->loadObjectList();
        $query = "SELECT job.id as jobid, job.uid as employerid, job.title, resume.id as resumeid, resume.uid as jobseekerid, resume.application_title, resume.first_name, resume.middle_name, resume.last_name
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_resume` AS resume ON resume.id = " . $resumeid . "
                        WHERE job.id = " . $jobid;

        $db->setQuery($query);
        $summary = $db->loadObject();
        $result[0] = $messages;
        $result[1] = $summary;
        $result[2] = $lists;

        return $result;
    }

    function getAllMessages($statusoperator, $employername, $jobseekername,  $status, $conflict , $company, $appname ,$jobtitle, $subject, $limitstart, $limit) {
        $db = JFactory::getDBO();
        //Filters
        if($statusoperator == '='){ // approval queue
            $fquery = ' WHERE message.status '.$statusoperator.' 0 ';
        }else{ // main listing
            $fquery = ' WHERE message.status '.$statusoperator.' 0  AND message.replytoid = 0 ';
        }
        if($employername)
            $fquery .= ' AND LOWER(empuser.name) LIKE ' . $db->Quote('%' . $employername . '%');
        if($jobseekername)
            $fquery .= ' AND LOWER(jsuser.name) LIKE ' . $db->Quote('%' . $jobseekername . '%');
        if(is_numeric($status))
            $fquery .= ' AND message.status = '.$status;
        if(is_numeric($conflict))
            $fquery .= ' AND message.isconflict = '.$conflict;
        if($company)
            $fquery .= ' AND LOWER(company.name) LIKE ' . $db->Quote('%' . $company . '%');
        if($appname)
            $fquery .= ' AND LOWER(resume.application_title) LIKE ' . $db->Quote('%' . $appname . '%');
        if($jobtitle)
            $fquery .= ' AND LOWER(job.title) LIKE ' . $db->Quote('%' . $jobtitle . '%');
        if($subject)
            $fquery .= ' AND LOWER(message.subject) LIKE ' . $db->Quote('%' . $subject . '%');
        
        $lists = array();
        $lists['employername'] = $employername;    
        $lists['jobseekername'] = $jobseekername;    
        $lists['status'] = JHTML::_('select.genericList', $this->getJSModel('common')->getStatus('Select Status'), 'message_status', 'class="inputbox" ', 'value', 'text', $status);
        $lists['conflict'] = JHTML::_('select.genericList', array('0' => array('value' => '', 'text' => JText::_('Conflicted')), '1' => array('value' => 1, 'text' => JText::_('Yes')), '2' => array('value' => 0, 'text' => JText::_('No'))), 'message_conflicted', 'class="inputbox" ' . '', 'value', 'text', $conflict);
        $lists['company'] = $company;    
        $lists['appname'] = $appname;    
        $lists['jobtitle'] = $jobtitle;    
        $lists['subject'] = $subject;

        //Pagination
        $result = array();
        $query = "SELECT COUNT(message.id) FROM `#__js_job_messages` AS message
                LEFT JOIN `#__users` AS empuser ON empuser.id = message.sendby
                LEFT JOIN `#__users` AS jsuser ON jsuser.id = message.sendby
                JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
                JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                ";
        $query .= $fquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT message.*, job.title as jobtitle, resume.application_title, resume.first_name, resume.middle_name, resume.last_name, 
                empuser.name as employername, jsuser.name as jobseekername, company.name as companyname
                FROM `#__js_job_messages` AS message
                LEFT JOIN `#__users` AS empuser ON empuser.id = message.sendby
                LEFT JOIN `#__users` AS jsuser ON jsuser.id = message.sendby
                JOIN `#__js_job_jobs` AS job ON job.id = message.jobid
                JOIN `#__js_job_resume` AS resume ON resume.id = message.resumeid
                JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                ";
        $query .= $fquery;
        $query .= " ORDER BY message.created DESC";        
        $db->setQuery($query, $limitstart, $limit);
        $messages = $db->loadObjectList();

        $result[0] = $messages;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function messageChangeStatus($id, $status) {
        if (is_numeric($id) == false)
            return false;
        if (is_numeric($status) == false)
            return false;
        $db = $this->getDBO();

        $row = $this->getTable('message');
        $row->id = $id;
        $row->status = $status;
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if ($this->_client_auth_key != "") {
            $data_message_approve = array();
            $query = "SELECT serverid FROM #__js_job_messages WHERE id = " . $id;
            $db->setQuery($query);
            $servermessageid = $db->loadResult();
            $data_message_approve['id'] = $servermessageid;
            $data_message_approve['message_id'] = $id;
            $data_message_approve['authkey'] = $this->_client_auth_key;
            $data_message_approve['status'] = $status;
            if ($status == 1)
                $fortask = "messageapprove";
            elseif ($status == -1)
                $fortask = "messagereject";
            $server_json_data_array = json_encode($data_message_approve);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('log');
            if ($status == 1)
                $jsjobslogobject->logMessageChangeStatusPublish($return_value);
            elseif ($status == -1)
                $jsjobslogobject->logMessageChangeStatusUnpublish($return_value);
        }
        return true;
    }

    function storeMessage() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $db = $this->getDBO();
        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $row = $this->getTable('message');
        $data['message'] = $this->getJSModel('common')->getHtmlInput('message');
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 2;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        $returnvalue = $this->sendMessageEmail($row->id);

        if ($this->_client_auth_key != "") {
            $query = "SELECT serverid FROM #__js_job_jobs
                WHERE  id = " . $data['jobid'];
            $db->setQuery($query);
            $server_jobid = $db->loadResult();
            $data['jobid'] = $server_jobid;
            $query = "SELECT serverid FROM #__js_job_resume
                WHERE   id= " . $data['resumeid'];
            $db->setQuery($query);
            $server_resumeid = $db->loadResult();
            $query = "SELECT serverid FROM #__js_job_messages
                WHERE   id= " . $data['id'];
            $db->setQuery($query);
            $server_messageid = $db->loadResult();
            $data['id'] = $server_messageid;
            $data['resumeid'] = $server_resumeid;
            $data['message_id'] = $row->id;
            $data['sendby'] = $row->sendby;
            $data['replytoid'] = $row->replytoid;
            $data['isread'] = $row->isread;
            $data['status'] = $row->status;
            $data['authkey'] = $this->_client_auth_key;
            $data['task'] = 'storemessage';
            $isownresumemessage = 1;
            $data['isownresumemessage'] = $isownresumemessage;
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->storeMessageSharing($data);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logMessageSharing($return_value);
        }
        if ($row->status == 1)
            return true;
        elseif ($row->status == 0)
            return 2;
    }

    function deleteMessages() {
        $db = $this->getDBO();
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('message');
        $deleteall = 1;
        foreach ($cids as $cid) {
            $servermessageid = 0;
            if ($this->_client_auth_key != "") {
                $query = "SELECT message.serverid AS id FROM `#__js_job_messages` AS message WHERE message.id = " . $cid;
                $db->setQuery($query);
                $s_m_id = $db->loadResult();
                $servermessageid = $s_m_id;
            }

            if ($this->messageCanDelete($cid) == true) {

                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
                if ($servermessageid != 0) {
                    $data = array();
                    $data['id'] = $servermessageid;
                    $data['referenceid'] = $cid;
                    $data['uid'] = $this->_uid;
                    $data['authkey'] = $this->_client_auth_key;
                    $data['siteurl'] = $this->_siteurl;
                    $data['task'] = 'deletemessage';
                    $jsjobsharingobject = $this->getJSModel('jobsharing');
                    $return_value = $jsjobsharingobject->deleteMessageSharing($data);
                    $jsjobslogobject = $this->getJSModel('log');
                    $jsjobslogobject->logDeleteMessageSharing($return_value);
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function messageCanDelete($id) {
        if (is_numeric($id) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT 
                    (SELECT COUNT(id) AS total FROM `#__js_job_messages` WHERE  replytoid = " . $id . ") AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function deleteenforceMessages() {
        $db = $this->getDBO();
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('message');
        $deleteall = 1;
        foreach ($cids as $cid) {
            $servermessageid = 0;
            if ($this->_client_auth_key != "") {
                $query = "SELECT message.serverid AS id FROM `#__js_job_messages` AS message WHERE message.id = " . $cid;
                $db->setQuery($query);
                $s_m_id = $db->loadResult();
                $servermessageid = $s_m_id;
            }

            if (true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
                if ($servermessageid != 0) {
                    $data = array();
                    $data['id'] = $servermessageid;
                    $data['referenceid'] = $cid;
                    $data['uid'] = $this->_uid;
                    $data['authkey'] = $this->_client_auth_key;
                    $data['siteurl'] = $this->_siteurl;
                    $data['task'] = 'deletemessage';
                    $jsjobsharingobject = $this->getJSModel('jobsharing');
                    $return_value = $jsjobsharingobject->deleteMessageSharing($data);
                    $jsjobslogobject = $this->getJSModel('log');
                    $jsjobslogobject->logDeleteMessageSharing($return_value);
                }
            } else{
                $deleteall++;
            }
        }

        return $deleteall;
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
            $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = 'message-email'";
            $db->setQuery($query);
            $template = $db->loadObject();
            $msgSubject = $template->subject;
            $msgBody = $template->body;
            $msgSubject = str_replace('{COMPANY_NAME}', $message->companyname, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $message->employername, $msgSubject);
            $userrole = $this->getJSModel('userrole')->getUserRoleByUid($message->sendby);
            if(!$userrole) $userrole=1;// if admin have no role
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
            $config = $this->getJSModel('configuration')->getConfigByFor('email');

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

}

?>