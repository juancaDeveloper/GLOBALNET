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

class JSJobsControllerResume extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function getresumedetail() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        //require_once(JPATH_ROOT.'/components/com_jsjobs/models/resume.php');
        //$resume_model = new JSJobsModelResume();
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume_model->getResumeDetail($uid, $jobid, $resumeid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    /* STRAT EXPORT RESUMES */

    function saveresumerating() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $ratingid = JRequest::getVar('ratingid');
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $newrating = JRequest::getVar('newrating');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume_model->storeResumeRating($uid, $ratingid, $jobid, $resumeid, $newrating);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function resumeenforcedelete() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $resumeid = $cid[0];
        $user = JFactory::getUser();
        $uid = $user->id;
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->resumeEnforceDelete($resumeid, $uid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'resume','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'resume','error');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'resume','warning');
        }
        $layout = JRequest::getVar('callfrom','empapps');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout='.$layout;
        
        $this->setRedirect($link);
    }

    function featuredresumeapprove() {
        $resumeid = JRequest::getVar('id');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->featuredResumeApprove($resumeid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'goldresume','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'goldresume','error');

        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function featuredresumereject() {
        $resumeid = JRequest::getVar('id');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->featuredResumeReject($resumeid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'featuredresume','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'featuredresume','error');

        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function goldresumeapprove() {
        $resumeid = JRequest::getVar('id');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->goldResumeApprove($resumeid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'goldresume','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'goldresume','error');

        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function goldresumereject() {
        $resumeid = JRequest::getVar('id');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->goldResumeReject($resumeid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'goldresume','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'goldresume','error');

        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function resumeapprove() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $appid = JRequest::getVar('id');
        
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->empappApprove($appid);

        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'resume','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'resume','error');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function resumereject() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $appid = JRequest::getVar('id');

        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->empappReject($appid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'resume','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'resume','error');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function allapprove() {
        $id = JRequest::getVar('id');
        $alltype = JRequest::getVar('alltype');
        $resume_model = $this->getmodel('resume', 'JSJobsModel');
        $return_value = $resume_model->allApproveActions($id , $alltype);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'resume','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'resume','error');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function allreject() {
        $id = JRequest::getVar('id');
        $alltype = JRequest::getVar('alltype');
        $resume_model = $this->getmodel('resume', 'JSJobsModel');
        $return_value = $resume_model->allRejectActions($id , $alltype);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'resume','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'resume','error');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function saveresume() {
        $data = JRequest::get('post');
        require_once (JPATH_ROOT.'/components/com_jsjobs/models/resume.php');
        $resume_model = new JSJobsModelResume();
        $resumeid = $resume_model->storeResume( $data );
        if(isset($data['save'])){
            if($resumeid){
                JSJOBSActionMessages::setMessage(SAVED, 'resume','message');
            }else{
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'resume','error');
            }
            $link = 'index.php?option=com_jsjobs&c=resume&task=resume.edit&cid[]=' . $resumeid;
        }elseif(isset($data['saveandclose'])){
            if($resumeid){
                JSJOBSActionMessages::setMessage(SAVED, 'resume','message');
            }else{
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'resume','error');
            }
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
        }
        $this->setRedirect(JRoute::_($link,false));
    }

    function remove() { 
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume_model->deleteResume();
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'resume','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'resume','error');
        }
        $layout = JRequest::getVar('callfrom','empapps');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout='.$layout;
        $this->setRedirect($link);
    }

    function savegoldresume() {
        $resumeid = JRequest::getVar('id');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->storeGoldResume($resumeid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'goldresume','message');
        } else if ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'goldresume','notice');
        } else {
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'goldresume','error');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
        $this->setRedirect($link);
    }

    function removegoldresume() {
        $resumeid = JRequest::getVar('id');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume_model->deleteGoldResume($resumeid);
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'goldresume','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'goldresume','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps');
    }

    function savefeaturedresume() {
        $resumeid = JRequest::getVar('id');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->storeFeaturedResume($resumeid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'featuredresume','message');
        } elseif ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'featuredresume','notice');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'featuredresume','error');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
        $this->setRedirect($link);
    }

    function removefeaturedresume() {
        $resumeid = JRequest::getVar('id');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume_model->deleteFeaturedResume($resumeid);
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'featuredresume','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'featuredresume','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps');
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'resume','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps');
    }

    function edit() {
        JRequest::setVar('layout', 'formresume');
        JRequest::setVar('view', 'resume');
        JRequest::setVar('c', 'resume');
        $layout = JRequest::getVar('callfrom','empapps');
        JRequest::setVar('callfrom', $layout);
        $this->display();
    }

    function postresumeonjomsocial(){
        JRequest::checkToken('get') OR jexit('Invalid Token');        
        $resumeid = JRequest::getVar('id',0);
        $res = JSModel::getJSModel('resume')->postResumeOnJomSocial($resumeid);
        if($res){
            JSJOBSActionMessages::setMessage("Resume has been successfully posted on JomSocial", 'resume','message');
        }else{
            JSJOBSActionMessages::setMessage("Resume has not been posted on JomSocial", 'resume','error');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
        $this->setRedirect($link);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'resume');
        $layoutName = JRequest::getVar('layout', 'resume');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }
}
?>
