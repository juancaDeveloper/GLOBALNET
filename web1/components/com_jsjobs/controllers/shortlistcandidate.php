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

class JSJobsControllerShortListCandiate extends JSController {

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

    function saveshortlistcandiate() {
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $data = array();
        $Itemid = JRequest::getVar('Itemid');
        $data['action'] = JRequest::getVar('action');
        $data['resumeid'] = JRequest::getVar('resumeid');
        $data['jobid'] = JRequest::getVar('jobid');
        $user = JFactory::getUser();
        $uid = $user->id;
        if ($data['action'] == 1) {
            $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
            $return_value = $jobapply->storeShortListCandidate($uid, $data);
            if (is_array($return_value)) {
                if ($return_value['isshortlistcandidatesstore'] == 1) {
                    if ($return_value['status'] == "Shortlistcandidates Sucessfully") {
                        $servershortlistcandidates = "ok";
                    }
                    $logarray['uid'] = $uid;
                    $logarray['referenceid'] = $return_value['referenceid'];
                    $logarray['eventtype'] = $return_value['eventtype'];
                    $logarray['message'] = $return_value['message'];
                    $logarray['event'] = "Shortlistcandidates";
                    $logarray['messagetype'] = "Sucessfully";
                    $logarray['datetime'] = date('Y-m-d H:i:s');
                    $jobsharing->write_JobSharingLog($logarray);
                    $jobsharing->Update_ServerStatus($servershortlistcandidates, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'shortlistcandidates');
                } elseif ($return_value['isshortlistcandidatesstore'] == 0) {
                    if ($return_value['status'] == "Data Empty") {
                        $servershortlistcandidates = "Data not post on server";
                    } elseif ($return_value['status'] == "Shortlistcandidates Saving Error") {
                        $servershortlistcandidates = "Error Shortliscandidates Saving";
                    } elseif ($return_value['status'] == "Auth Fail") {
                        $servershortlistcandidates = "Authentication Fail";
                    }
                    $logarray['uid'] = $uid;
                    $logarray['referenceid'] = $return_value['referenceid'];
                    $logarray['eventtype'] = $return_value['eventtype'];
                    $logarray['message'] = $return_value['message'];
                    $logarray['event'] = "Shortliscandidates";
                    $logarray['messagetype'] = "Error";
                    $logarray['datetime'] = date('Y-m-d H:i:s');
                    $serverid = 0;
                    $jobsharing->write_JobSharingLog($logarray);
                    $jobsharing->Update_ServerStatus($servershortlistcandidates, $logarray['referenceid'], $serverid, $logarray['uid'], 'shortlistcandidates');
                }                
                $msg = JText::_('Candidate successfully shortlisted');
                $msgtype = 'message';
            } else {
                if ($return_value == 1){
                    $msg = JText::_('Candidate successfully shortlisted');
                    $msgtype = 'message';
                }elseif ($return_value == 2){
                    $msg = JText::_('Please fill all required fields');
                    $msgtype = 'error';
                }elseif ($return_value == 3){
                    $msg = JText::_('This candidate is already shortlisted');
                    $msgtype = 'notice';
                }else{
                    $msg = JText::_($return_value . 'Error in saving candidate in shortlist');
                    $msgtype = 'error';
                }
            }
            echo $msg;
            JFactory::getApplication()->close();
        }elseif ($data['action'] == 2) { // send message
            $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=send_message&bd=' . $data['jobid'] . '&rd=' . $data['resumeid'] . '&nav=30&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link ,false),$msgtype);
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
    