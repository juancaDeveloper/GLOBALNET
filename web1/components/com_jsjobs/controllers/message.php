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

class JSJobsControllerMessage extends JSController {

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

    function savemessage() { //save message
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $Itemid = JRequest::getVar('Itemid');
        $user = JFactory::getUser();
        $uid = $user->id;
        $data = JRequest::get('post');
        $message = $this->getmodel('Message', 'JSJobsModel');
        $return_value = $message->storeMessage($uid);
        if ($return_value == 1)
            JSJOBSActionMessages::setMessage(SAVED, 'message','message');
        elseif ($return_value == 2)
            JSJOBSActionMessages::setMessage('Message saved and waiting for approval', 'message','notice');
        elseif ($return_value == 4)
            JSJOBSActionMessages::setMessage('Unable to send mail', 'message','warning');
        elseif ($return_value == 5)
            JSJOBSActionMessages::setMessage('Job seeker not member system cannot send message', 'message','warning');
        elseif ($return_value == 6)
            JSJOBSActionMessages::setMessage('Employer not member system cannot send message', 'message','warning');
        else
            JSJOBSActionMessages::setMessage('Error in saving message', 'message','error');
        $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=send_message&bd=' . $data['jobid'] . '&rd=' . $data['resumeid'] . '&nav=' . $data['nav'] . '&Itemid=' . $Itemid;
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
    

