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

class JSJobsControllerJobapply extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function getresumecomments() {
        $jobapplyid = JRequest::getVar('jobapplyid');
        $jobapply_model = $this->getmodel('Jobapply', 'JSJobsModel');
        $returnvalue = $jobapply_model->getResumeCommentsAJAX($jobapplyid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function mailtocandidate() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $resumeid = JRequest::getVar('resumeid');
        $jobapplyid = JRequest::getVar('jobapplyid');
        $jobapply_model = $this->getmodel('Jobapply', 'JSJobsModel');
        $returnvalue = $jobapply_model->getMailForm($uid, $resumeid, $jobapplyid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function sendtocandidate() {
        $val = json_decode(JRequest::getVar('val'), true);
        $jobapply_model = $this->getmodel('Jobapply', 'JSJobsModel');
        $returnvalue = $jobapply_model->sendToCandidate($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function saveresumecomments() { // save resume comments
        $data = array();
        $data['id'] = JRequest::getVar('jobapplyid');
        $data['resumeid'] = JRequest::getVar('resumeid');
        $data['comments'] = JRequest::getVar('comments');
        $jobapply_model = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply_model->storeResumeComments($data);
        $msg = array();
        if ($return_value == 1) {
            $msg['message'] = JText::_('Resume comments has been saved');
            $msg['saved'] = 'ok';
        } else {
            $msg['message'] = JText::_('Error in saving resume comments');
            $msg['saved'] = 'error';
        }
        $msg = json_encode($msg);
        echo $msg;
        JFactory::getApplication()->close();
    }

    function aappliedresumetabactions() {
        $data = JRequest::get('post');
        $Itemid = JRequest::getVar('Itemid');
        if ($data['tab_action'] == 6)
            $needle_array = json_encode($data);
        $session = JFactory::getSession();
        $session->set('jsjobappliedresumefilter', $needle_array);
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $data['jobid'] . '&ta=' . $data['tab_action'] . '&Itemid=' . $Itemid;
        $this->setRedirect($link);
    }

    function actionresume() { //save shortlist candidate
        $user = JFactory::getUser();
        $uid = $user->id;
        $data = JRequest::get('post');
        $jobid = $data['jobid'];
        $resumeid = $data['resumeid'];
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $jobid;
        $this->setRedirect($link);
    }

    function updateactionstatus() {
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $applyid = JRequest::getVar('applyid');
        $action_status = JRequest::getVar('action_status');
        $jobapply_model = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply_model->updateJobApplyActionStatus($jobid, $resumeid, $applyid, $action_status);
        echo $return_value;
        JFactory::getApplication()->close();
    }

    function saveshortlistcandiate() { //save shortlist candidate
        $session = JFactory::getSession();
        $data = array();
        $Itemid = JRequest::getVar('Itemid');
        $data['action'] = JRequest::getVar('action');
        $data['resumeid'] = JRequest::getVar('resumeid');
        $data['jobid'] = JRequest::getVar('jobid');
        $user = JFactory::getUser();
        $uid = $user->id;
        $jobapply_model = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply_model->storeShortListCandidate($uid, $data);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'shortlistcandidate','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'shortlistcandidate','error');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'shortlistcandidate','warning');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'shortlistcandidate','error');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&rd=' . $data['resumeid'] . '&oi=' . $data['jobid'];
        $this->setRedirect($link);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'jobapply');
        $layoutName = JRequest::getVar('layout', 'jobapply');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $jobapply_model = $this->getModel('Jobapply', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($jobapply_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($jobapply_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>