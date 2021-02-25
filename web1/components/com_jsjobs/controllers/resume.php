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

JHTML::_('behavior.calendar');
jimport('joomla.application.component.controller');

class JSJobsControllerResume extends JSController {

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

    function subcategoriesbycatidresume(){
        $catid = JRequest::getVar('catid');
        $showall = JRequest::getVar('showall');
        if($showall=='true'){
            $showall = true;
        }else{
            $showall = false;
        }
        $result = $this->getModel('Resume','JSJobsModel')->subCategoriesByCatIdresume($catid , $showall);
        echo $result;
        JFactory::getApplication()->close();
    }

    function addtofeaturedresumes() {
        $Itemid = JRequest::getVar('Itemid');
        $user = JFactory::getUser();
        $uid = $user->id;
        $common = $this->getmodel('Common', 'JSJobsModel');
        $resumeid = $common->parseId(JRequest::getVar('rd', ''));
        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume->storeFeaturedResume($uid, $resumeid);
        if ($return_value == 1) {
            $configvalue = $this->getmodel('configurations')->getConfigValue('featuredresume_autoapprove');
            if($configvalue != 1){
                JSJOBSActionMessages::setMessage(WAITING_FOR_APPROVAL, 'featuredresume','notice');
            }else{
                JSJOBSActionMessages::setMessage(SAVED, 'featuredresume','message');                
            }
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'featuredresume','error');
        } else if ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'featuredresume','warning');
        } else if ($return_value == 5) {
            JSJOBSActionMessages::setMessage(CAN_NOT_ADD_NEW, 'featuredresume','notice');
        } else if ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'featuredresume','notice');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'featuredresume','error');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function addtogoldresumes() {
        $Itemid = JRequest::getVar('Itemid');
        $user = JFactory::getUser();
        $uid = $user->id;
        $common = $this->getmodel('Common', 'JSJobsModel');
        $resumeid = $common->parseId(JRequest::getVar('rd', ''));
        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume->storeGoldResume($uid, $resumeid);
        if ($return_value == 1) {
            $configvalue = $this->getmodel('configurations')->getConfigValue('goldresume_autoapprove');
            if($configvalue != 1){
                JSJOBSActionMessages::setMessage(WAITING_FOR_APPROVAL, 'goldresume','notice');
            }else{
                JSJOBSActionMessages::setMessage(SAVED, 'goldresume','message');                
            }
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'goldresume','error');
        } else if ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'goldresume','notice');
        } else if ($return_value == 5) {
            JSJOBSActionMessages::setMessage(CAN_NOT_ADD_NEW, 'goldresume','warning');
        } else if ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'goldresume','notice');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'goldresume','error');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function saveresumecomments() { // save resume comments
        $data = array();
        $data['id'] = JRequest::getVar('jobapplyid');
        $data['resumeid'] = JRequest::getVar('resumeid');
        $data['comments'] = JRequest::getVar('comments');
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $jobapply_model = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply_model->storeResumeComments($data);
        if ($return_value == 1){
            $msg['status'] = 'ok';
            $msg['msg'] = JText::_('Resume comments has been saved');
        }
        else{
            $msg['status'] = 'error';
            $msg['msg'] = JText::_('Error in saving resume comments');
        }
        echo json_encode($msg);
        JFactory::getApplication()->close();
    }

    function getresumecomments() {
        $user = JFactory::getUser();
        $jobapplyid = JRequest::getVar('jobapplyid');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $returnvalue = $jobapply->getResumeCommentsAJAX($user->id, $jobapplyid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function saveresumerating() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $ratingid = JRequest::getVar('ratingid');
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $newrating = JRequest::getVar('newrating');
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume->storeResumeRating($uid, $ratingid, $jobid, $resumeid, $newrating);
        echo $return_value;
        JFactory::getApplication()->close();
    }

    function saveresume() {
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest::get('post');
        $return = $this->getModel('resume', 'JSJobsModel')->storeResume( $data );

        if(isset($data['save'])){
            $aliasid = '';
            if($return){
                $aliasid =  $this->getmodel('common')->removeSpecialCharacter($return);
                JSJOBSActionMessages::setMessage(SAVED, 'resume','message');
            }else{
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'resume','error');
            }
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=formresume&nav=29&rd=' . $aliasid . '&Itemid=' . $Itemid;
        }elseif(isset($data['vis_applynow'])){
            if($return){
                JSJOBSActionMessages::setMessage('Application successfully applied', '','message');
            }else{
                JSJOBSActionMessages::setMessage('Error in applying job', '','error');
            }
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs';
        }else{
            if($return){
                JSJOBSActionMessages::setMessage(SAVED, 'resume','message');
            }else{
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'resume','error');
            }
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes';
        }
        $this->setRedirect(JRoute::_($link,false));
    }

    function getresumefiles() {
        $resumeid = JRequest::getVar('resumeid');
        $data_directory = $this->getmodel('configurations')->getConfigValue('data_directory');
        $files = array();
        $resumeModel = $this->getmodel('Resume', 'JSJobsModel');
        $files = $resumeModel->getResumeFilesByResumeId($resumeid);
        // resume form layout class
        require_once JPATH_COMPONENT . '/views/resume/resumeformlayout.php';
        $resumeformlayout = new JSJobsResumeformlayout();
        $data = $resumeformlayout->getResumeFilesLayout($files, $data_directory);
        echo $data;
        JFactory::getApplication()->close();
    }

    function getallresumefiles() {
        $resumeModel = $this->getmodel('Resume', 'JSJobsModel');
        $link = $resumeModel->getAllResumeFiles();
        JFactory::getApplication()->close();
    }

    function deleteresumefiles() {
        $resumeModel = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resumeModel->deleteResumeFile();
        if (!empty($return_value) && $return_value == 1) {
            $msg = JText::_('File Deleted');
        } else {
            $msg = JText::_('Operation Aborted');
        }
        echo $msg;
        JFactory::getApplication()->close();
    }

    function deleteresume() { //delete resume
        JRequest::checkToken('get') OR jexit('Invalid Token');
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $resumeid = $common->parseId(JRequest::getVar('rd', ''));
        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume->deleteResume($resumeid, $uid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'resume','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(IN_USE, 'resume','message');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'resume','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'resume','message');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function getresumedetail() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume->getResumeDetail($uid, $jobid, $resumeid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function postresumeonjomsocial(){
        JRequest::checkToken('get') OR jexit('Invalid Token');
        $isallowed = JSModel::getJSModel('configurations')->getConfigValue('jomsocial_allowpostresume');
        if($isallowed){            
            $resumeid = JRequest::getVar('id',0);
            $res = JSModel::getJSModel('resume')->postResumeOnJomSocial($resumeid);
            if($res){
                JSJOBSActionMessages::setMessage("Resume has been successfully posted on JomSocial", 'resume','message');
            }else{
                JSJOBSActionMessages::setMessage("Resume has not been posted on JomSocial", 'resume','error');
            }
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $Itemid;
        $this->setRedirect($link);
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
    
