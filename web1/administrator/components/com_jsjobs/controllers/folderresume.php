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

class JSJobsControllerFolderresume extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'folderresume','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=folder&view=folder&layout=folders');
    }

    function saveresumefolder() { // save folder
        $data = JRequest::get('post');
        $data['jobid'] = JRequest::getVar('jobid');
        $data['resumeid'] = JRequest::getVar('resumeid');
        $data['applyid'] = JRequest::getVar('applyid');
        $data['folderid'] = JRequest::getVar('folderid');
        $folderresume_model = $this->getmodel('Folderresume', 'JSJobsModel');
        $return_value = $folderresume_model->storeFolderResume($data);
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $data['jobid'];
        $msg = array();
        if ($return_value == 1) {
            $msg['message'] = JText::_('Resume folder has been saved');
            $msg['saved'] = 'ok';
        } elseif ($return_value == 3) {
            $msg['message'] = JText::_('Resume already exist in folder');
            $msg['saved'] = 'error';
        } else {
            $msg['message'] = JText::_('Error in saving resume folder');
            $msg['saved'] = 'error';
        }
        $res = json_encode($msg);
        echo $res;
        JFactory::getApplication()->close();
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'folderresume');
        $layoutName = JRequest::getVar('layout', 'folderresume');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $folderresume_model = $this->getModel('Folderresume', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($folderresume_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($folderresume_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>