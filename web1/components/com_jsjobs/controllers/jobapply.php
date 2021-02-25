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

class JSJobsControllerJobApply extends JSController {

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

    function applyjob() {
        $visitorapplyjob = $this->getModel('configurations', 'JSJobsModel')->getConfigValue('visitor_can_apply_to_job');
        if (!JFactory::getUser()->guest || $visitorapplyjob == '0') {
            $jobid = JRequest::getVar('jobid', false);
            $result = $this->getModel('Jobapply', 'JSJobsModel')->applyJob($jobid);
            $array[0] = 'popup';
            $array[1] = $result;
            print_r(json_encode($array));
        } else {
            $link = JRoute::_('index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_apply&bd=' . JRequest::getVar('jobid', false) . '&Itemid=' . JRequest::getVar('Itemid', false) ,false);
            $array[0] = 'redirect';
            $array[1] = $link;
            print_r(json_encode($array));
        }
        JFactory::getApplication()->close();
    }
    
    function canceljobapplyasvisitor(){
        //unset the session 
        $session = JFactory::getSession();
        $session->clear('jsjob_jobapply');
        //redirect to jobs
        $Itemid = JRequest::getVar('Itemid');
        $link = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=jobs&Itemid='.$Itemid ,false);
        echo $link;
        JFactory::getApplication()->close();
    }
    
    function visitorapplyjob(){
        //unset the session 
        $session = JFactory::getSession();
        $visitor = $session->get('jsjob_jobapply');
        $jobid = $visitor['bd'];
        $resumeid = JRequest::getVar('resumeid');
        $this->getModel('jobapply')->visitorJobApply($jobid, $resumeid);
        $session->clear('jsjob_jobapply');
        //redirect to jobs
        $Itemid = JRequest::getVar('Itemid');
        $link = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=jobs&Itemid='.$Itemid ,false);
        echo $link;
        JFactory::getApplication()->close();
    }

    function jobapply() {
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply->jobapply();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage('Application successfully applied', 'jobapply','message');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&uid=' . $uid . '&Itemid=' . $Itemid;
        } else if ($return_value == 3) {
            JSJOBSActionMessages::setMessage('You already apply to this job', 'jobapply','warning');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $Itemid;
        } else if ($return_value == 10) {
            $textvar = JText::_('You can not apply to this job').'.'.JText::_('Your job apply limit exceeds');
            JSJOBSActionMessages::setMessage($textvar, 'jobapply','warning');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $Itemid;
        } else {
            JSJOBSActionMessages::setMessage('Error in applying job', 'jobapply','error');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&uid=' . $uid . '&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function jobapplyajax() {
        $uid = JRequest::getString('uid', 'none');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply->jobapply();
        if ($return_value == 1) {
            $msg = JText::_('Application successfully applied');
        } else if ($return_value == 3) {
            $msg = JText::_('You already apply to this job');
        } else if ($return_value == 10) {
            $msg = JText::_('You can not apply to this job. Your job apply limit exceeds');
        } else {
            $msg = JText::_('Error in applying job');
        }
        echo $msg;
        JFactory::getApplication()->close();
    }

    function updateactionstatus() {
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $applyid = JRequest::getVar('applyid');
        $action_status = JRequest::getVar('action_status');
        $jobseeker_model = $this->getModel('Jobseeker', 'JSJobsModel');
        $employer_model = $this->getModel('Employer', 'JSJobsModel');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply->updateJobApplyActionStatus($jobid, $resumeid, $applyid, $action_status);
        echo $return_value;
        JFactory::getApplication()->close();
    }

    function aappliedresumetabactions() {
        $data = JRequest::get('post');
        $Itemid = JRequest::getVar('Itemid');
        if ($data['tab_action'] == 6)
            $needle_array = json_encode($data);
        $session = JFactory::getSession();
        $session->set('jsjobappliedresumefilter', $needle_array);
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $data['jobid'] . '&ta=' . $data['tab_action'] . '&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
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


