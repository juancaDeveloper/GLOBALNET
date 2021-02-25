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

class JSJobsModelFolder extends JSModel {

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

    function getMyFoldersForCombo($uid, $title) {
        if (!is_numeric($uid))
            return false;
        $db = JFactory::getDBO();
        $folders = array();
        if ($this->_client_auth_key != "") {
            $query = "SELECT serverid AS id, name FROM `#__js_job_folders` WHERE status = 1 AND uid = " . $uid . " ORDER BY name ASC ";
        } else {
            $query = "SELECT id, name FROM `#__js_job_folders` WHERE status = 1 AND uid = " . $uid . " ORDER BY name ASC ";
        }

        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }

        if ($title)
            $folders[] = array('value' => JText::_(''), 'text' => $title);
        foreach ($rows as $row) {
            $folders[] = array('value' => $row->id, 'text' => JText::_($row->name));
        }
        return $folders;
    }

    function getMyFolders($uid, $limit, $limitstart) {
        $result = array();
        $db = $this->getDBO();

        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        if ($this->_client_auth_key != "") {
            $data['uid'] = $uid;
            $data['limit'] = $limit;
            $data['limitstart'] = $limitstart;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $fortask = "getmyfolders";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['myfolders']) AND $return_server_value['myfolders'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "My Folders";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $result[0] = array();
                $result[1] = 0;
            } else {
                $parse_data = array();
                foreach ($return_server_value['folderdata'] AS $rel_data) {
                    $parse_data[] = (object) $rel_data;
                }
                $result[0] = $parse_data;
                $result[1] = $return_server_value['total'];
            }
        } else {
            $query = "SELECT count(folder.id)
                        FROM `#__js_job_folders` AS folder
                        WHERE folder.uid = " . $uid;
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total <= $limitstart)
                $limitstart = 0;

            $query = "SELECT folder.id,folder.status,folder.name,CONCAT(folder.alias,'-',folder.id) AS folderaliasid
                        , ( SELECT count(id) FROM `#__js_job_folderresumes` WHERE folder.id = folderid) AS noofresume
                        FROM `#__js_job_folders` AS folder
                        WHERE folder.uid = " . $uid;
            $db->setQuery($query, $limitstart, $limit);
            $result[0] = $db->loadObjectList();
            $result[1] = $total;
        }

        return $result;
    }

    function getFolderDetail($uid, $fid) {
        $result = array();
        $db = $this->getDBO();
        if (is_numeric($uid) == false)
            return false;
        if (!is_numeric($fid))
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        if ($this->_client_auth_key != "") {
            $data['uid'] = $uid;
            $data['fid'] = $fid;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $fortask = "getfolderdetail";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['folderdetail']) AND $return_server_value['folderdetail'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Folder Detail";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $result = (object) array('name' => '', 'decription' => '');
            } else {
                $result = (object) $return_server_value[0];
            }
        } else {
            $query = "SELECT folder.id,folder.status,folder.uid,folder.name,CONCAT(folder.alias,'-',folder.id) AS folderaliasid,folder.decription
                        FROM `#__js_job_folders` AS folder
                        WHERE folder.uid = " . $uid . " AND folder.id = " . $fid;
            $db->setQuery($query);
            $result = $db->loadObject();
        }


        return $result;
    }

    function getFolderbyIdforForm($id, $uid) {
        $db = $this->getDBO();
        if (is_numeric($uid) == false)
            return false;
        if ($this->_client_auth_key != "") {
            $data['uid'] = $uid;
            $data['fid'] = $id;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $fortask = "getfolderbyidforform";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['folderforform']) AND $return_server_value['folderforform'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Folder Form";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $folder = (object) array('name' => '', 'decription' => '', 'created' => '');
            } else {
                if ($return_server_value != false)
                    $folder = (object) $return_server_value[0];
            }
        }else {

            if (($id != '') && ($id != 0)) {
                if (is_numeric($id) == false)
                    return false;
                $query = "SELECT folder.id ,folder.name ,folder.decription
                            ,folder.created ,folder.status
    				FROM `#__js_job_folders` AS folder
    				WHERE folder.id = " . $id;
                    $db->setQuery($query);
                    $folder = $db->loadObject();
            }
        }

        if (isset($folder))
            $result[0] = $folder;
        else
            $result[0] = null;

        if ($id) { // not new
            if (!defined('VALIDATE')) {
                define('VALIDATE', 'VALIDATE');
            }
            $result[1] = VALIDATE;
        } else { // new
            $result[1] = $this->getJSModel('permissions')->checkPermissionsFor("ADD_FOLDER");
            $result[2] = $this->getPackageDetailByUid($uid);
        }

        return $result;
    }

    function getPackageDetailByUid($uid) {
        if (is_numeric($uid) == false)
            return false;
        $db = $this->getDbo();
        $query = "SELECT payment.id AS paymentid, package.id
                    FROM #__js_job_paymenthistory AS payment
                    JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE uid = " . $uid . "
                    AND payment.transactionverified = 1 AND payment.status = 1 ";

        $db->setQuery($query);
        $packages = $db->loadObjectList();
        if (!empty($packages)) {
            foreach ($packages AS $package) {
                $packagedetail[0] = $package->id;
                $packagedetail[1] = $package->paymentid;
            }
        } else {
            $packagedetail[0] = 0;
            $packagedetail[1] = 0;
        }
        return $packagedetail;
    }

    function canAddNewFolder($uid) {
        $db = $this->getDBO();
        if (is_numeric($uid) == false)
            return false;
        $query = "SELECT package.id AS packageid, package.folders, package.packageexpireindays, payment.id AS paymentid, payment.created
                        FROM `#__js_job_employerpackages` AS package
                        JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                        WHERE payment.uid = " . $uid . "
                        AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                        AND payment.transactionverified = 1 AND payment.status = 1";
        $db->setQuery($query);
        $valid_packages = $db->loadObjectList();
        if (empty($valid_packages)) { // user have no valid package
            $query = "SELECT package.id
                       FROM `#__js_job_employerpackages` AS package
                       JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                       WHERE payment.uid = " . $uid . " 
                       AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";

            $db->setQuery($query);
            $packagedetail = $db->loadObjectList();
            if (empty($packagedetail)) { // User have no package
                return NO_PACKAGE;
            } else { // User have packages but are expired
                return EXPIRED_PACKAGE;
            }
        } else { // user have valid pacakge
            $unlimited = 0;
            $folderallow = 0;
            foreach ($valid_packages AS $folder) {
                if ($unlimited == 0) {
                    if ($folder->folders != -1) {
                        $folderallow = $folder->folders + $folderallow;
                    } else {
                        $unlimited = 1;
                    }
                }
            }
            if ($unlimited == 0) { // user doesnot have the unlimited folder package
                if ($folderallow == 0) {
                    return FOLDER_LIMIT_EXCEEDS;
                } //can not add new job
                $query = "SELECT COUNT(folder.id) AS totalfolders
				FROM `#__js_job_folders` AS folder
				WHERE folder.uid = " . $uid;

                $db->setQuery($query);
                $totalfoder = $db->loadResult();

                if ($folderallow <= $totalfoder) {
                    return FOLDER_LIMIT_EXCEEDS;
                } else {
                    return VALIDATE;
                }
            } else { // user have unlimited job package
                return VALIDATE;
            }
        }
    }

    function storeFolder() { //store Folder
        JRequest::checkToken() or die("Invalid Token");
        $row = $this->getTable('folder');
        $db = $this->getDBO();
        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string

        if ($this->_client_auth_key != "") {
            if ($data['id'] != "" AND $data['id'] != 0) {
                $query = "select folder.id AS id 
                            From #__js_job_folders AS folder
                            WHERE folder.serverid=" . $data['id'];

                $db->setQuery($query);
                $folder_id = $db->loadResult();
                if ($folder_id) {
                    $data['id'] = $folder_id;
                    $isownfolder = 1;
                } else
                    $isownfolder = 0;
            }
        }

        if ($data['id'] == '') { // only for new 
            $config = $this->getJSModel('configurations')->getConfigByFor('folder');
            $data['status'] = $config['folder_auto_approve'];
        }
        $data['decription'] = $this->getJSModel('common')->getHtmlInput('decription');
        if (!empty($data['alias']))
            $folderalias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $folderalias = $this->getJSModel('common')->removeSpecialCharacter($data['name']);

        $folderalias = strtolower(str_replace(' ', '-', $folderalias));
        $data['alias'] = $folderalias;

        if ($data['id'] == '') {
            $name = $data['name'];
            $uid = $data['uid'];
            if ($this->folderValidation($name , $uid ))
                return 3;
        }
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
        if ($this->_client_auth_key != "") {
            $db = $this->getDBO();
            $query = "SELECT folder.* FROM `#__js_job_folders` AS folder  
						WHERE folder.id = " . $row->id;
            //echo '<br> SQL '.$query;
            $db->setQuery($query);
            $data_folder = $db->loadObject();
            if ($data['id'] != "" AND $data['id'] != 0) {
                $query = "select folder.serverid AS serverid 
                                From #__js_job_folders AS folder
                                WHERE folder.id=" . $data['id'];
                //echo 'query'.$query;
                $db->setQuery($query);
                $serverfolder_id = $db->loadResult();
                $data_folder->id = $serverfolder_id; // for edit case
            }
            $data_folder->folder_id = $row->id;
            $data_folder->authkey = $this->_client_auth_key;
            $data_folder->task = 'storefolder';
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $return_value = $jsjobsharingobject->store_FolderSharing($data_folder);
            $job_log_object = $this->getJSModel('log');
            $job_log_object->log_Store_FolderSharing($return_value);
        }
        return true;
    }

    function folderValidation($foldername , $uid) {
        $db = JFactory:: getDBO();
        if(!is_numeric($uid))
            return true;
        $query = "SELECT COUNT(id) FROM `#__js_job_folders` WHERE uid = $uid AND name = " . $db->Quote($foldername);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function deleteFolder($folderid, $uid) {
        $row = $this->getTable('folder');
        $db = $this->getDBO();
        $data = JRequest::get('post');
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($folderid) == false)
            return false;
        $serverfolderid = 0;
        if ($this->_client_auth_key != '') {
            $serverfolderid = $folderid;
            $query = "SELECT folder.id AS id FROM `#__js_job_folders` AS folder  
						WHERE folder.serverid = " . $folderid;
            $db->setQuery($query);
            $c_folder_id = $db->loadResult();
            $folderid = $c_folder_id;
        }
        $returnvalue = $this->folderCanDelete($folderid, $uid);
        if ($returnvalue == 1) {
            if (!$row->delete($folderid)) {
                $this->setError($row->getErrorMsg());
                return false;
            }
            if ($serverfolderid != 0) {
                $data = array();
                $data['id'] = $serverfolderid;
                $data['referenceid'] = $folderid;
                $data['uid'] = $this->_uid;
                $data['authkey'] = $this->_client_auth_key;
                $data['siteurl'] = $this->_siteurl;
                $data['task'] = 'deletefolder';
                $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                $return_value = $jsjobsharingobject->delete_FolderSharing($data);
                $job_log_object = $this->getJSModel('log');
                $job_log_object->log_Delete_FolderSharing($return_value);
            }
        } else
            return $returnvalue; // company can not delete	

        return true;
    }

    function folderCanDelete($folderid, $uid) {
        $db = $this->getDBO();
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($folderid) == false)
            return false;
        $result = array();

        $query = "SELECT COUNT(folder.id) FROM `#__js_job_folders` AS folder
					WHERE folder.id = " . $folderid . " AND folder.uid = " . $uid;

        $db->setQuery($query);
        $comtotal = $db->loadResult();


        if ($comtotal > 0) { // this department is same user
            $query = "SELECT COUNT(folderresume.id) FROM `#__js_job_folderresumes` AS folderresume
						WHERE folderresume.folderid = " . $folderid;

            $db->setQuery($query);
            $total = $db->loadResult();

            if ($total > 0)
                return 2;
            else
                return 1;
        } else
            return 3; // 	this department is not of this user
    }

    function canResumeAddintoFolder($uid, $jobid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($jobid) == false)
            return false;
        $db = $this->getDBO();
        if ($this->_client_auth_key != "") {
            $query = "SELECT job.id
                FROM `#__js_job_jobs` AS job 
                WHERE job.serverid = " . $jobid;

            $db->setQuery($query);
            $client_jobid = $db->loadResult();
            if ($client_jobid)
                $jobid = $client_jobid;
        }
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }

        if ($newlisting_required_package == 0) {
            return 1;
        } else {
            $canadd = 0;
            $query = "SELECT package.folders, package.packageexpireindays, payment.created
                FROM `#__js_job_employerpackages` AS package
                JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                JOIN `#__js_job_jobs` AS job ON job.packageid = package.id
                WHERE payment.uid = " . $uid . " AND job.id = " . $jobid;

            $db->setQuery($query);
            $package = $db->loadObject();
            if (isset($package->folders) && $package->folders == -1)
                return 1;
            if (isset($package->folders) && $package->folders > 0)
                return 1;
            else
                return 0;
        }
    }

}
?>
    
