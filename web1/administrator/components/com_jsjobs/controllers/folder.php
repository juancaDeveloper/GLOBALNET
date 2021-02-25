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
jimport('joomla.application.component.controller');

class JSJobsControllerFolder extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function getmyforlders() {
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $applyid = JRequest::getVar('applyid');
        $folder_model = $this->getmodel('Folder', 'JSJobsModel');
        $returnvalue = $folder_model->getMyFoldersAJAX($jobid, $resumeid, $applyid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function folderenforcedelete() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $folderid = $cid[0];
        $user = JFactory::getUser();
        $uid = $user->id;
        $folder_model = $this->getmodel('Folder', 'JSJobsModel');
        $return_value = $folder_model->folderEnforceDelete($folderid, $uid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'folder','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'folder','error');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'folder','notice');
        }
        $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=folders';
        $this->setRedirect($link);
    }

    function folderapprove() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $folderid = $cid[0];
        $folder_model = $this->getmodel('Folder', 'JSJobsModel');
        $return_value = $folder_model->folderApprove($folderid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'folder','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'folder','error');

        $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=foldersqueue';
        $this->setRedirect($link);
    }

    function folderreject() {
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $folderid = $cid[0];
        $folder_model = $this->getmodel('Folder', 'JSJobsModel');
        $return_value = $folder_model->folderReject($folderid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'folder','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'folder','error');

        $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=foldersqueue';
        $this->setRedirect($link);
    }

    function publishfolder() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $folder_model = $this->getmodel('Folder', 'JSJobsModel');
        $return_value = $folder_model->folderChangeStatus($id, 1);
        if ($return_value != 1) {
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'folder','error');
        }else{
            JSJOBSActionMessages::setMessage(APPROVED, 'folder','message');
        }
        $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=foldersqueue';
        $this->setRedirect($link);
    }

    function unpublishfolder() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $folder_model = $this->getmodel('Folder', 'JSJobsModel');
        $return_value = $folder_model->folderChangeStatus($id, -1);
        if ($return_value != 1) {
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'folder','error');
        }else{
            JSJOBSActionMessages::setMessage(REJECTED, 'folder','message');
        }
        $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=foldersqueue';
        $this->setRedirect($link);
    }

    function savefolder() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $folder_model = $this->getmodel('Folder', 'JSJobsModel');
        $return_value = $folder_model->storeFolder();
        $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=folders';
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'folder','message');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'folder','notice');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'folder','error');
            $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=formfolder'.JRequest::getVar('id');
            $this->setRedirect($link);
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'folder','error');
        }
        $this->setRedirect($link);
    }

    function edit() {
        JRequest::setVar('layout', 'formfolder');
        JRequest::setVar('view', 'folder');
        JRequest::setVar('c', 'folder');
        $this->display();
    }

    function remove() {
        $folder_model = $this->getmodel('Folder', 'JSJobsModel');
        $returnvalue = $folder_model->deleteFolder();
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'folder','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'folder','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=folder&view=folder&layout=folders');
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'folder','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=folder&view=folder&layout=folders');
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'folder');
        $layoutName = JRequest::getVar('layout', 'folder');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $folder_model = $this->getModel('Folder', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($folder_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($folder_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>