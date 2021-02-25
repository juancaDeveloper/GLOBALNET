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

class JSJobsControllerJob extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function jobenforcedelete() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $jobid = $cid[0];
        $user = JFactory::getUser();
        $uid = $user->id;
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $returnvalue = $job_model->jobEnforceDelete($jobid, $uid);
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'job','message');
        } elseif ($returnvalue == 2) {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'job','error');
        } elseif ($returnvalue == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'job','notice');
        }
        $layout = JRequest::getVar('callfrom','jobs');
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout='.$layout;
        $this->setRedirect($link);
    }

    function jobapprove() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $jobid = JRequest::getVar('id');
        
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->jobApprove($jobid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'job','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'job','error');
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link);
    }

    function jobreject() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $jobid = JRequest::getVar('id');
        
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->jobReject($jobid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'job','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'job','error');
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link);
    }


    function featuredjobapprove() {
        $jobid = JRequest::getVar('id');
        
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->featuredJobApprove($jobid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'featuredjob','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'featuredjob','error');

        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link);
    }

    function featuredjobreject() {
        $jobid = JRequest::getVar('id');
        
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->featuredJobReject($jobid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'featuredjob','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'featuredjob','error');

        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link);
    }

    function goldjobapprove() {
        $jobid = JRequest::getVar('id');
        
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->goldJobApprove($jobid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'goldjob','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'goldjob','error');

        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link);
    }

    function goldjobreject() {
        $jobid = JRequest::getVar('id');
        
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->goldJobReject($jobid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'goldjob','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'goldjob','error');

        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link);
    }

    function allapprove() {
        $id = JRequest::getVar('id');
        $alltype = JRequest::getVar('alltype');
        $job_model = $this->getmodel('job', 'JSJobsModel');
        $return_value = $job_model->allApproveActions($id , $alltype);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'job','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'job','error');
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link);
    }

    function allreject() {
        $id = JRequest::getVar('id');
        $alltype = JRequest::getVar('alltype');
        $job_model = $this->getmodel('job', 'JSJobsModel');
        $return_value = $job_model->allRejectActions($id , $alltype);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'job','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'job','error');
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue';
        $this->setRedirect($link);
    }

    function savegoldjob() {
        $jobid = JRequest::getVar('id');
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->storeGoldJob($jobid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'goldjob','message');
        } elseif ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'goldjob','notice');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'goldjob','error');
        }
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs';
        $this->setRedirect($link);
    }

    function removegoldjob() {
        $jobid = JRequest::getVar('id');
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $returnvalue = $job_model->deleteGoldJob($jobid);
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'goldjob','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'goldjob','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=jobs');
    }

    function savefeaturedjob() {
        $jobid = JRequest::getVar('id');
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job_model->storeFeaturedJob($jobid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'featuredjob','message');
        } elseif ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'featuredjob','notice');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'featuredjob','error');
        }
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs';
        $this->setRedirect($link);
    }

    function removefeaturedjob() {
        $jobid = JRequest::getVar('id');
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $returnvalue = $job_model->deleteFeaturedJob($jobid);
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'featuredjob','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'featuredjob','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=jobs');
    }

    function cancelshortlistcandidates() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'job','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=jobs');
    }

    function savejob() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_data = $job_model->storeJob();
        $layout = JRequest::getVar('callfrom','jobs');
        if ($return_data == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'job','message');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout='.$layout;
            $this->setRedirect($link);
        } elseif ($return_data == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'job','error');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&cid[]='.JRequest::getVar('id');
            $this->setRedirect($link);
        } elseif ($return_data == 12) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'job','error');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob';
            $this->setRedirect($link);
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'job','error');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout='.$layout;
            $this->setRedirect($link);
        }
    }

    function remove() {
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $returnvalue = $job_model->deleteJob();
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'job','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'job','error');
        }
        $layout = JRequest::getVar('callfrom','jobs');
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout='.$layout;
    
        $this->setRedirect($link);
    }

    function getcopyjob() {
        $val = JRequest::getVar('val');
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $job_model = $this->getmodel('Job', 'JSJobsModel');
        $return_data = $job_model->getCopyJob($val);
        echo $return_data;
        JFactory::getApplication()->close();
    }

    function edit() {
        JRequest::setVar('c', 'job');
        JRequest::setVar('view', 'job');
        JRequest::setVar('layout', 'formjob');
        $layout = JRequest::getVar('callfrom','jobs');
        JRequest::setVar('callfrom',$layout);
        $this->display();
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'job','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=jobs');
    }

    function postjobonjomsocial(){
        JRequest::checkToken('get') OR jexit('Invalid Token');        
        $jobid = JRequest::getVar('id',0);
        $res = JSModel::getJSModel('job')->postJobOnJomSocial($jobid);
        if($res){
            JSJOBSActionMessages::setMessage("Job has been successfully posted on JomSocial", 'job','message');
        }else{
            JSJOBSActionMessages::setMessage("Job has not been posted on JomSocial", 'job','error');
        }
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs';
        $this->setRedirect($link);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'job');
        $layoutName = JRequest::getVar('layout', 'job');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $job_model = $this->getModel('Job', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($job_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($job_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>
