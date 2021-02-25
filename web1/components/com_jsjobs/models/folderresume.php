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

class JSJobsModelFolderresume extends JSModel {

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

    function resumeFolderValidation($jobid, $resumeid, $folderid) {
        $db = JFactory:: getDBO();
        if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
            return false;
        if ((is_numeric($resumeid) == false) || ($resumeid == 0) || ($resumeid == ''))
            return false;
        if(!is_numeric($folderid)) return false;
        $query = "SELECT COUNT(id) FROM #__js_job_folderresumes
		WHERE jobid = " . $jobid . " AND resumeid =" . $resumeid . " AND folderid = " . $folderid;
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
    }

    function getFolderResumebyFolderId($uid, $folderid, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if (is_numeric($folderid) == false)
            return false;
        $result = array();

        if ($this->_client_auth_key != "") {
            $data['uid'] = $uid;
            $data['folderid'] = $folderid;
            $data['sortby'] = $sortby;
            $data['limit'] = $limit;
            $data['limitstart'] = $limitstart;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $fortask = "getfolderresumebyfolderid";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['folderresume']) AND $return_server_value['folderresume'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Folder Resume";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $result[0] = (object) array();
                $result[1] = 0;
            } else {
                $parse_data = array();
                foreach ($return_server_value['folderresume'] AS $rel_data) {
                    $parse_data[] = (object) $rel_data;
                }
                $result[0] = $parse_data;
                $result[1] = $return_server_value['total'];
            }
        } else {
            if(!is_numeric($folderid)) return false;
            $query = "SELECT COUNT(folderresume.id)
                                FROM `#__js_job_folderresumes` AS folderresume
				JOIN `#__js_job_resume` AS resume ON folderresume.resumeid = resume.id
                                WHERE folderresume.folderid = " . $folderid . "
                                AND resume.published = 1 ";
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total <= $limitstart)
                $limitstart = 0;
            $query = "SELECT fres.jobid AS jobid,apply.comments,apply.id, cat.cat_title ,apply.apply_date, jobtype.title AS jobtypetitle
                            , app.id AS appid, app.first_name, app.last_name,app.photo AS photo, app.email_address, app.jobtype,app.gender
                            ,app.total_experience, app.jobsalaryrange, salary.rangestart, salary.rangeend
                            ,rating.id AS ratingid, rating.rating                            
                            ,country.name AS countryname,state.name AS statename
                            ,city.cityName AS cityname
                            ,CONCAT(app.alias,'-',app.id) AS resumealiasid
                            ,cur.symbol, salarytype.title AS salarytype,exp.title AS exptitle
                            FROM `#__js_job_resume` AS app
                            LEFT JOIN `#__js_job_jobtypes` AS jobtype ON app.jobtype = jobtype.id
                            LEFT JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id
                            JOIN `#__js_job_jobapply` AS apply  ON apply.cvid = app.id
                            LEFT JOIN  `#__js_job_resumerating` AS rating ON (app.id=rating.resumeid AND apply.jobid=rating.jobid)
                            LEFT JOIN  `#__js_job_salaryrange` AS salary ON app.jobsalaryrange=salary.id
                            LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON app.jobsalaryrangetype = salarytype.id
                            LEFT JOIN  `#__js_job_currencies` AS cur ON app.currencyid=cur.id
                            LEFT JOIN  `#__js_job_folderresumes` AS fres ON (app.id=fres.resumeid AND apply.jobid=fres.jobid)
                            LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = app.id LIMIT 1)
                            LEFT JOIN `#__js_job_countries` AS country ON city.countryid  = country.id
                            LEFT JOIN `#__js_job_states` AS state ON city.stateid = state.id
                            LEFT JOIN `#__js_job_experiences` AS exp ON exp.id = app.experienceid
                            WHERE fres.folderid = " . $folderid;
            $db->setQuery($query, $limitstart, $limit);
            $folderresume = $db->loadObjectList();
            $result[0] = $folderresume;
            $result[1] = $total;
        }
        $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(3);
        $fieldsordering = $this->getJSModel('customfields')->parseFieldsOrderingForView($fieldsordering);
        $result[2] = $fieldsordering;
        return $result;
    }

    function storeFolderResume($data) { //store Folder
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $row = $this->getTable('folderresume');
        $curdate = date('Y-m-d H:i:s');
        $data['uid'] = $this->_uid;
        $data['created'] = $curdate;
        if ($this->_client_auth_key != "") {
            if ($data['resumeid']) {
                $db = JFactory::getDBO();
                $query = "SELECT id FROM #__js_job_resume 
				WHERE serverid = " . $data['resumeid'];

                $db->setQuery($query);
                $result = $db->loadResult();
                if (!$result)
                    $is_own_resume = 0;
                else {
                    $is_own_resume = 1;
                    $data['resumeid'] = $result;
                }

                if ($is_own_resume == 1) {
                    $query = "SELECT id FROM #__js_job_jobs 
					WHERE serverid = " . $data['jobid'];

                    $db->setQuery($query);
                    $job_id = $db->loadResult();
                    if ($job_id)
                        $data['jobid'] = $job_id;

                    $query = "SELECT id FROM #__js_job_folders 
					WHERE serverid = " . $data['folderid'];

                    $db->setQuery($query);
                    $folder_id = $db->loadResult();
                    if ($folder_id)
                        $data['folderid'] = $folder_id;
                }
            }
        }else {
            $is_own_resume = 1;
        }
        if ($is_own_resume == 1) {
            $jobid = $data['jobid'];
            $resumeid = $data['resumeid'];
            $folderid = $data['folderid'];

            if ($this->resumeFolderValidation($jobid, $resumeid, $folderid))
                return 3;

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
                return false;
            }
        }
        if ($this->_client_auth_key != "") {
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $job_log_object = $this->getJSModel('log');
            if ($is_own_resume == 1) { // own Resume  
                if ($data['jobid'] != "" AND $data['jobid'] != 0) {
                    $query = "select job.serverid AS serverid 
							From #__js_job_jobs AS job
							WHERE job.id=" . $data['jobid'];
                    //echo 'query'.$query;
                    $db->setQuery($query);
                    $job_serverid = $db->loadResult();
                    if ($job_serverid)
                        $data['jobid'] = $job_serverid;
                    else
                        $data['jobid'] = 0;
                }
                if ($data['resumeid'] != "" AND $data['resumeid'] != 0) {
                    $query = "select resume.serverid AS serverid 
							From #__js_job_resume AS resume
							WHERE resume.id=" . $data['resumeid'];
                    //echo 'query'.$query;
                    $db->setQuery($query);
                    $resume_serverid = $db->loadResult();
                    if ($resume_serverid)
                        $data['resumeid'] = $resume_serverid;
                    else
                        $data['resumeid'] = 0;
                }
                if ($data['folderid'] != "" AND $data['folderid'] != 0) {
                    $query = "select folder.serverid AS serverid 
							From #__js_job_folders AS folder
							WHERE folder.id=" . $data['folderid'];
                    //echo 'query'.$query;
                    $db->setQuery($query);
                    $folder_serverid = $db->loadResult();
                    if ($folder_serverid)
                        $data['folderid'] = $folder_serverid;
                    else
                        $data['folderid'] = 0;
                }
                $data['folderresume_id'] = $row->id;
                $data['authkey'] = $this->_client_auth_key;
                $data['task'] = 'storeownresumefolder';
                $isownresumefolder = 1;
                $data['isownresumefolder'] = $isownresumefolder;
                $return_value = $jsjobsharingobject->store_ResumeFolderSharing($data);
                $job_log_object->log_Store_ResumeFolderSharing($return_value);
            }else {  // server job apply on job sharing 
                $data['authkey'] = $this->_client_auth_key;
                $data['task'] = 'storeserverresumefolder';
                $isownresumefolder = 0;
                $data['isownresumefolder'] = $isownresumefolder;
                $return_value = $jsjobsharingobject->store_ResumeFolderSharing($data);
                $job_log_object->log_Store_ResumeFolderSharing($return_value);
            }
        }
        return true;
    }

}
?>
    
