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

class JSJobsModelFolder extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getFolderbyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT id,name,uid,status,decription,created FROM #__js_job_folders WHERE id = " . $c_id;

        $db->setQuery($query);
        $folders = $db->loadObject();
        $result[0] = $folders;
        $lists = array();
        $status = array(
            '0' => array('value' => 0, 'text' => JText::_('Pending')),
            '1' => array('value' => 1, 'text' => JText::_('Approve')),
            '2' => array('value' => -1, 'text' => JText::_('Reject')),);
        if ($folders) {
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', $folders->status);
        } else {
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', 1);
        }
        $result[1] = $lists;
        return $result;
    }

    function getAllFolders( $datafor, $searchname, $searchempname, $searchstatus , $limitstart, $limit) {
        $db = JFactory::getDBO();
        if($datafor==1){ // 1 Listing
            $fquery = " WHERE folder.status <> 0";
            if($searchstatus || $searchstatus == 0){
                if(is_numeric($searchstatus))
                    $fquery = " WHERE folder.status =".$searchstatus;
            }
        }else{ // 2 Queue
            $fquery = " WHERE folder.status = 0";
        }
        if($searchname){
            $fquery .= " AND folder.name LIKE ".$db->Quote('%'.$searchname.'%');
        }
        if($searchempname){
            $fquery .= " AND company.name LIKE ".$db->Quote('%'.$searchempname.'%');
        }

        $lists = array();
        $lists['searchname'] = $searchname;
        $lists['searchempname'] = $searchempname;
        if($datafor==1)
            $lists['searchstatus'] = JHTML::_('select.genericList', $this->getJSModel('common')->getStatus('Select Status'), 'searchstatus', 'class="inputbox" ', 'value', 'text', $searchstatus);

        $result = array();
        $query = "SELECT COUNT(folder.id) FROM #__js_job_folders AS folder
                LEFT JOIN `#__js_job_companies` AS company ON company.uid = folder.uid ";

        $query .=$fquery.' GROUP BY folder.id';
        $db->setQuery($query);
        $total = $db->loadResult();


        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT folder.id,folder.name,folder.decription,folder.status,company.name as companyname
                , ( SELECT DISTINCT COUNT(fr.id) FROM `#__js_job_folderresumes` AS fr WHERE fr.folderid = folder.id ) AS nor
			FROM `#__js_job_folders` AS folder
            LEFT JOIN `#__js_job_companies` AS company ON company.uid = folder.uid ";
        $query .=$fquery." GROUP BY folder.id";
        $db->setQuery($query, $limitstart, $limit);
        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        $result[2] = $lists;
        
        return $result;
    }


    function getMyFoldersAJAX($jobid, $resumeid, $applyid) {
        if (is_numeric($jobid) == false)
            return false;
        if (is_numeric($resumeid) == false)
            return false;
        $option = 'com_jsjobs';
        $db = $this->getDBO();
        $canview = 0;
        $uid = $this->getJSModel('job')->getUidByJobId($jobid);
        $myfolders = $this->getFoldersForCombo(JText::_('Select Folder'));
        $flag = true;
        if ($myfolders){
            $folders = JHTML::_('select.genericList', $myfolders, 'folderid', 'class="inputbox required" ' . '', 'value', 'text', '');
        }
        else{
            $folders = JText::_('You do not have folders');
            $flag = false;
        }

        $return_value = '<div id="js_job_app_actions">
                            <img class="image_close" onclick="closethisactiondiv();" src="components/com_jsjobs/include/images/act_no.png">
                            <div class="action_folder">
                                <span class="folder_title">
                                    '. JText::_('Folder') .'
                                </span>
                                <span class="folder_combo">
                                    '. $folders .'
                                </span> ';
                            if($flag){
        $return_value .=        '<span class="save_btn">';
        $return_value .=            "<input type='button' class='button' onclick='saveaddtofolder(" . $applyid . "," . $jobid . "," . $resumeid . ")' value='".JText::_('Add')."'>";
        $return_value .=         '</span>';
                            }
        $return_value .=    '</div>
                        </div>';
        return $return_value;
    }

    function getFoldersForCombo($title) {
        $db = JFactory::getDBO();
        $folders = array();

        $query = "SELECT id, name FROM `#__js_job_folders` WHERE status = 1 AND uid = " . $uid . " ORDER BY name ASC ";

        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }

        if ($title)
            $folders[] = array('value' => JText::_(''), 'text' => $title);
        foreach ($rows as $row) {
            $folders[] = array('value' => $row->id, 'text' => $row->name);
        }
        return $folders;
    }

    function storeFolder() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $row = $this->getTable('folder');
        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $data['decription'] = $this->getJSModel('common')->getHtmlInput('decription');
        $name = $data['name'];
        if (!empty($data['alias']))
            $folderalias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $folderalias = $this->getJSModel('common')->removeSpecialCharacter($data['name']);

        $folderalias = strtolower(str_replace(' ', '-', $folderalias));
        $data['alias'] = $folderalias;
        if ($data['id'] == "")
            if ($this->folderValidation($name))
                return 3;
        $returnvalue = 1;
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

            $db->setQuery($query);
            $data_folder = $db->loadObject();
            if ($data['id'] != "" AND $data['id'] != 0) {
                $query = "select folder.serverid AS serverid 
								From #__js_job_folders AS folder
								WHERE folder.id=" . $data['id'];
                $db->setQuery($query);
                $serverfolder_id = $db->loadResult();
                $data_folder->id = $serverfolder_id; // for edit case
            }
            $data_folder->folder_id = $row->id;
            $data_folder->authkey = $this->_client_auth_key;
            $data_folder->task = 'storefolder';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->storeFolderSharing($data_folder);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logStoreFolderSharing($return_value);
        }
        return true;
    }

    function folderValidation($foldername) {
        $db = JFactory:: getDBO();
        $query = "SELECT COUNT(id) FROM #__js_job_folders
		WHERE name = " . $db->Quote($foldername);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function folderChangeStatus($id, $status) {
        if (is_numeric($id) == false)
            return false;
        if (is_numeric($status) == false)
            return false;
        $db = $this->getDBO();

        $row = $this->getTable('folder');
        $row->id = $id;
        $row->status = $status;
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if ($this->_client_auth_key != "") {
            $data_message_approve = array();
            $query = "SELECT serverid FROM #__js_job_folders WHERE id = " . $id;
            $db->setQuery($query);
            $serverfolderid = $db->loadResult();
            $data_folder_approve['id'] = $serverfolderid;
            $data_folder_approve['folder_id'] = $id;
            $data_folder_approve['authkey'] = $this->_client_auth_key;
            $data_folder_approve['status'] = $status;
            if ($status == 1)
                $fortask = "folderapprove";
            elseif ($status == -1)
                $fortask = "folderreject";
            $server_json_data_array = json_encode($data_folder_approve);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('log');
            if ($status == 1)
                $jsjobslogobject->logFolderChangeStatusPublish($return_value);
            elseif ($status == -1)
                $jsjobslogobject->logFolderChangeStatusUnpublish($return_value);
        }
        return true;
    }

    function deleteFolder() { //delete Messages
        $db = $this->getDBO();
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('folder');
        $deleteall = 1;
        foreach ($cids as $cid) {
            $euid = 0; // employer uid
            $serverfolderid = 0;
            if ($this->_client_auth_key != '') {
                $query = "SELECT folder.serverid AS id,folder.uid AS uid FROM `#__js_job_folders` AS folder WHERE folder.id = " . $cid;
                $db->setQuery($query);
                $data = $db->loadObject();
                $serverfolderid = $data->id;
                $euid = $data->uid;
            }

            if ($this->folderCanDelete($cid) == true) {
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
                if ($serverfolderid != 0) {
                    $data = array();
                    $data['id'] = $serverfolderid;
                    $data['referenceid'] = $cid;
                    $data['uid'] = $euid;
                    $data['authkey'] = $this->_client_auth_key;
                    $data['siteurl'] = $this->_siteurl;
                    $data['task'] = 'deletefolder';
                    $jsjobsharingobject = $this->getJSModel('jobsharing');
                    $return_value = $jsjobsharingobject->deleteFolderSharing($data);
                    $jsjobslogobject = $this->getJSModel('log');
                    $jsjobslogobject->logDeleteFolderSharing($return_value);
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function folderCanDelete($id) {
        if (is_numeric($id) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT
                    (SELECT COUNT(id) AS total FROM `#__js_job_folderresumes` WHERE  folderid = " . $id . ") AS total";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function folderEnforceDelete($folderid, $uid) {
        if (is_numeric($folderid) == false)
            return false;
        $db = $this->getDBO();
        $query = "DELETE  folder
                                 FROM `#__js_job_folders` AS folder
                                 WHERE folder.id = " . $folderid;

        $db->setQuery($query);
        if (!$db->query()) {
            return 2; //error while delete folder
        }
        return 1;
    }

    function folderApprove($folderid) {
        if (is_numeric($folderid) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_folders SET status = 1 WHERE id = " . $folderid;
        $db->setQuery($query);
        if (!$db->query())
            return false;
        return;
    }

    function folderReject($folderid) {
        if (is_numeric($folderid) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_folders SET status = -1 WHERE id = " . $folderid;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return;
    }

}

?>
