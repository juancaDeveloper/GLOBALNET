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

jimport('joomla.application.component.controller');

class JSJobsControllerFolder extends JSController {

    var $_router_mode_sef = null;

    function __construct() {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        if ($user->guest) { // redirect user if not login
            $link = 'index.php?option=com_user';
            $this->setRedirect($link);
        }
        $router = $app->getRouter();
        if ($router->getMode() == JROUTER_MODE_SEF) {
            $this->_router_mode_sef = 1; // sef true
        } else {
            $this->_router_mode_sef = 2; // sef false
        }

        parent::__construct();
    }

    function savefolder() { // save folder
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $Itemid = JRequest::getVar('Itemid');
        $folder = $this->getmodel('Folder', 'JSJobsModel');
        $return_value = $folder->storeFolder();
        $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=myfolders&Itemid=' . $Itemid;
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'folder','message');
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'folder','error');
            $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=formfolder&Itemid=' . $Itemid;
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'folder','warning');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'folder','error');
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function deletefolder() { //delete folder
        JRequest::checkToken('get') OR jexit('Invalid Token');
        $user = JFactory::getUser();
        $uid = $user->id;

        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $folderid = $common->parseId(JRequest::getVar('fd'));

        $folder = $this->getmodel('Folder', 'JSJobsModel');
        $return_value = $folder->deleteFolder($folderid, $uid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'folder','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'folder','error');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'folder','error');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'folder','error');
        }
        $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=myfolders&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function saveresumefolder() { // save folder
        $data = array();
        $common = $this->getmodel('Common', 'JSJobsModel');
        $data['jobid'] = $common->parseId(JRequest::getVar('jobid'));
        $data['resumeid'] = JRequest::getVar('resumeid');
        $data['applyid'] = JRequest::getVar('applyid');
        $data['folderid'] = JRequest::getVar('folderid');
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $Itemid = JRequest::getVar('Itemid');
        $folderresume = $this->getmodel('Folderresume', 'JSJobsModel');
        $return_value = $folderresume->storeFolderResume($data);
        $msg['status'] = 'error';
        if ($return_value == 1) {
            $msg['msg'] =  JText::_('Resume folder has been saved');
            $msg['status'] = 'ok';
        } elseif ($return_value == 3) {
            $msg['msg'] =  JText::_('Resume already exist in folder');
        } else {
            $msg['msg'] =  JText::_('Error in saving folders');
        }
        echo json_encode($msg);
        JFactory::getApplication()->close();
    }

    function getmyforlders() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $applyid = JRequest::getVar('applyid');
        $server_model = $this->getModel('Server', 'JSJobsModel');
        $returnvalue = $server_model->getMyFoldersAJAX($uid, $jobid, $resumeid, $applyid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function display($cachable = false, $urlparams = false) { // correct employer controller display function manually.
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'default');
        $layoutName = JRequest::getVar('layout', 'default');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>
    
