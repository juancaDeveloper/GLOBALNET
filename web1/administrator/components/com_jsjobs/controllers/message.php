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

class JSJobsControllerMessage extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function publishmessages() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $message_model = $this->getmodel('Message', 'JSJobsModel');
        $return_value = $message_model->messageChangeStatus($id, 1);
        if ($return_value != 1) {
            JSJOBSActionMessages::setMessage(PUBLISH_ERROR, 'message','error');
        }else{
            JSJOBSActionMessages::setMessage(PUBLISHED, 'message','message');
        }
        $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=messagesqueue';
        $this->setRedirect($link);
    }

    function unpublishmessages() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $id = $cid[0];
        $message_model = $this->getmodel('Message', 'JSJobsModel');
        $return_value = $message_model->messageChangeStatus($id, -1);
        if ($return_value != 1) {
            JSJOBSActionMessages::setMessage(UN_PUBLISH_ERROR, 'message','error');
        }else{
            JSJOBSActionMessages::setMessage(UN_PUBLISHED, 'message','message');
        }
        $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=messagesqueue';
        $this->setRedirect($link);
    }

    function savemessage() { //save message
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $data = JRequest::get('post');
        $sendbyid = $data['sendby'];
        $jobid = $data['jobid'];
        $resumeid = $data['resumeid'];
        $sm = $data['sm'];
        if ($sm == 1) {
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $jobid;
        } elseif ($sm == 3) {
            $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=messages';
        } elseif ($sm == 2) {
            $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=message_history&bd=' . $jobid . '&rd=' . $resumeid . '';
        }
        $message_model = $this->getmodel('Message', 'JSJobsModel');
        $return_value = $message_model->storeMessage();
        if ($return_value == 1)
            JSJOBSActionMessages::setMessage(SAVED, 'message','message');
        elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'message','error');
            $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=sendmessage&cid[]='.JRequest::getVar('id');
        }else{
            JSJOBSActionMessages::setMessage(REJECTED, 'message','error');
        }
        $this->setRedirect($link);
    }

    function savemessages() { //save message
        $session = JFactory::getSession();
        $jobid = $session->get('bd');
        $resumeid = $session->get('rd');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $data = JRequest::get('post');
        $message_model = $this->getmodel('Message', 'JSJobsModel');
        $return_value = $message_model->storeMessage();
        if ($return_value == 1)
            JSJOBSActionMessages::setMessage(SAVED, 'message','message');
        elseif ($return_value == 2)
            JSJOBSActionMessages::setMessage('Message saved and waiting for approval', 'message','notice');
        else
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'message','error');
        $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=messages';
        $this->setRedirect($link);
    }

    function cancelsendmessage() {
        $data = JRequest::get('post');
        $jobid = $data['jobid'];
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'message','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $jobid);
    }

    function cancelmessagehistory() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'message','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=message&view=message&layout=messages');
    }

    function cancel() {
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'message','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=message&view=message&layout=message_history&bd=' . $jobid . '&rd=' . $resumeid . '');
    }

    function edit() {
        JRequest::setVar('layout', 'formmessage');
        JRequest::setVar('sm', JRequest::getVar('sm'));
        JRequest::setVar('view', 'message');
        JRequest::setVar('c', 'message');
        $this->display();
    }

    function remove() {
        $message_model = $this->getmodel('Message', 'JSJobsModel');
        $returnvalue = $message_model->deleteMessages();
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'message','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'message','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=message&view=message&layout=messages');
    }

    function messageenforcedelete() {
        $message_model = $this->getmodel('Message', 'JSJobsModel');
        $returnvalue = $message_model->deleteenforceMessages();
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'message','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'message','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=message&view=message&layout=messages');
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'message');
        $layoutName = JRequest::getVar('layout', 'message');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $message_model = $this->getModel('Message', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($message_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($message_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }
}
?>