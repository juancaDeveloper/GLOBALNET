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

class JSJobsControllerJob extends JSController {

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

    function addtofeaturedjobs() { //save employer package
        $Itemid = JRequest::getVar('Itemid');
        $user = JFactory::getUser();
        $uid = $user->id;
        $common = $this->getmodel('Common', 'JSJobsModel');
        $jobid = $common->parseId(JRequest::getVar('bd', ''));

        $job = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job->storeFeaturedJobs($uid, $jobid);
        if ($return_value == 1) {
            $configvalue = $this->getmodel('configurations')->getConfigValue('featuredjob_autoapprove');
            if($configvalue != 1){
                JSJOBSActionMessages::setMessage(WAITING_FOR_APPROVAL, 'featuredjob','notice');
            }else{
                JSJOBSActionMessages::setMessage(SAVED, 'featuredjob','message');                
            }
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'featuredjob','error');
        } else if ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_APPROVED, 'job','warning');
        } else if ($return_value == 5) {
            JSJOBSActionMessages::setMessage(CAN_NOT_ADD_NEW, 'featuredjob','warning');
        } else if ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'featuredjob','warning');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'featuredjob','error');
        }   
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;

        $this->setRedirect(JRoute::_($link , false));
    }

    function addtogoldjobs() {
        $Itemid = JRequest::getVar('Itemid');
        $user = JFactory::getUser();
        $uid = $user->id;
        $common = $this->getmodel('Common', 'JSJobsModel');
        $jobid = $common->parseId(JRequest::getVar('bd', ''));
        $job = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job->storeGoldJobs($uid, $jobid);
        if ($return_value == 1) {
            $configvalue = $this->getmodel('configurations')->getConfigValue('goldjob_autoapprove');
            if($configvalue != 1){
                JSJOBSActionMessages::setMessage(WAITING_FOR_APPROVAL, 'goldjob','notice');
            }else{
                JSJOBSActionMessages::setMessage(SAVED, 'goldjob','message');                
            }
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'goldjob','warning');
        } else if ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_APPROVED, 'job','warning');
        } else if ($return_value == 5) {
            JSJOBSActionMessages::setMessage(CAN_NOT_ADD_NEW, 'goldjob','warning');
        } else if ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'goldjob','warning');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'goldjob','error');
        }

        $link = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=myjobs',false);
        $this->setRedirect($link);
    }

    function subcategoriesbycatid(){
        $catid = JRequest::getVar('catid');
        $showall = JRequest::getVar('showall');
        if($showall=='true'){
            $showall = true;
        }else{
            $showall = false;
        }
        $result = $this->getModel('Job','JSJobsModel')->subCategoriesByCatId($catid , $showall);
        echo $result;
        JFactory::getApplication()->close();
    }

    function savejob() { //save job
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $job = $this->getmodel('Job', 'JSJobsModel');

        $return_data = $job->storeJob();
        if ($return_data == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'job','message');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
        } else if ($return_data == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'job','warning');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $Itemid;
        } else if ($return_data == 11) { // start date not in oldate
            JSJOBSActionMessages::setMessage('Start date not old date', 'job','warning');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $Itemid;
        } else if ($return_data == 12) {
            JSJOBSActionMessages::setMessage('Start date can not be less than stop date', 'job','warning');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $Itemid;
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'job','error');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function savejobvisitor() { //save company and job for visitor
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $company = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company->storeCompanyJobForVisitor();
        $link = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=controlpanel&Itemid=' . $Itemid;
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'job','message');
        } elseif ($return_value == 5) {
            JSJOBSActionMessages::setMessage(FILE_SIZE_ERROR, 'job','warning');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob_visitor&Itemid=' . $Itemid;
        } elseif ($return_value == 6) {
            JSJOBSActionMessages::setMessage(FILE_TYPE_ERROR, 'job','warning');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob_visitor&Itemid=' . $Itemid;
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage('Error incorrect captcha code', 'job','warning');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob_visitor&Itemid=' . $Itemid;
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'job','error');
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function deletejob() { //delete job
        JRequest::checkToken('get') OR jexit('Invalid Token');
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $jobid = $common->parseId(JRequest::getVar('bd'));
        $vis_email = JRequest::getVar('email');
        $vis_jobid = $common->parseId(JRequest::getVar('bd'));
        $job = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job->deleteJob($jobid, $uid, $vis_email, $vis_jobid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'job','warning');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(IN_USE, 'job','warning');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'job','warning');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'job','warning');
        }
        if (($vis_email == '') || ($jobid == ''))
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
        else
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&email=' . $vis_email . '&bd=' . $vis_jobid . '&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function mailtocandidate() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $email = JRequest::getVar('email');
        $jobapplyid = JRequest::getVar('jobapplyid');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $returnvalue = $jobapply->getMailForm($uid, $email, $jobapplyid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function getcopyjob() {
        $val = JRequest::getVar('val');
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $job = $this->getmodel('Job', 'JSJobsModel');
        $return_data = $job->getCopyJob($val);
        echo $return_data;
        JFactory::getApplication()->close();
    }

    function sendtocandidate() {
        $val = json_decode(JRequest::getVar('val'), true);
        $emailtemplate = $this->getmodel('Emailtemplate', 'JSJobsModel');
        $returnvalue = $emailtemplate->sendToCandidate($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function quickview() {
        $jobid = JRequest::getVar('jobid', false);
        //$jobid = $this->getModel('Common', 'JSJobsModel')->parseId($jobid);
        $result = $this->getModel('Quickview', 'JSJobsModel')->getJobQuickViewById($jobid);
        echo $result;
        JFactory::getApplication()->close();
    }

    function getnextjobs() {
        $result = $this->getModel('Job', 'JSJobsModel')->getNextJobs();
        echo $result;
        JFactory::getApplication()->close();
    }

    function postjobonjomsocial(){
        JRequest::checkToken('get') OR jexit('Invalid Token');
        $isallowed = JSModel::getJSModel('configurations')->getConfigValue('jomsocial_allowpostjob');
        if($isallowed){            
            $jobid = JRequest::getVar('id',0);
            $res = JSModel::getJSModel('job')->postJobOnJomSocial($jobid);
            if($res){
                JSJOBSActionMessages::setMessage("Job has been successfully posted on JomSocial", 'job','message');
            }else{
                JSJOBSActionMessages::setMessage("Job has not been posted on JomSocial", 'job','error');
            }
        }
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
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
    
