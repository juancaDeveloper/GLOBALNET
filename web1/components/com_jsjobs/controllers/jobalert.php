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

class JSJobsControllerJobAlert extends JSController {

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

    function unsubscribeJobAlertSetting() {
        $data = JRequest::get('post');
        $email = $data['contactemail'];
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $jobalert = $this->getmodel('Jobalert', 'JSJobsModel');
        $return_value = $jobalert->unSubscribeJobAlert($email);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage('Job alert successfully unsubscribed', 'jobalert','message');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage('Incorrect email address', 'jobalert','error');
        } else {
            JSJOBSActionMessages::setMessage('Error While unsubscribing job alert', 'jobalert','error');
        }
        $link = 'index.php?option=com_jsjobs&c=jobalert&view=jobalert&layout=jobalertsetting&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function savejobalertsetting() { //save company
        $data = JRequest:: get('post');
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');

        $Itemid = JRequest::getVar('Itemid');
        $jobalert = $this->getmodel('Jobalert', 'JSJobsModel');
        $return_value = $jobalert->storeJobAlertSetting();
        $link = 'index.php?option=com_jsjobs&c=jobalert&view=jobalert&layout=jobalertsetting&Itemid=' . $Itemid;
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'jobalert','message');
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'jobalert','error');
        } else if ($return_value == 3) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'email','warning');
        } else if ($return_value == 8) {
            JSJOBSActionMessages::setMessage('Error incorrect captcha code', 'jobalert','error');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'jobalert','error');
        }
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

    function sendjobalert() {
        global $mainframe;
        $mainframe = JFactory::getApplication();
        $ck = JRequest::getVar('ck');
        $jobalert_model = $this->getModel('Jobalert', 'JSJobsModel');
        $result = $jobalert_model->sendJobAlertByAlertType($ck);
        echo $result;
        $mainframe->close();
    }

}

?>
    