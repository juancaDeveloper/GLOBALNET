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

class JSJobsControllerJobalert extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function editjobalert() {
        JRequest::setVar('layout', 'formjobalert');
        JRequest::setVar('view', 'jobalert');
        JRequest::setVar('c', 'jobalert');
        $this->display();
    }

    function savejobalert() { //save savejobalert
        $data = JRequest:: get('post');
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $Itemid = JRequest::getVar('Itemid');
        $jobalert_model = $this->getmodel('Jobalert', 'JSJobsModel');
        $return_value = $jobalert_model->storeJobAlertSetting();
        $link = 'index.php?option=com_jsjobs&c=jobalert&view=jobalert&layout=jobalert';
        if (is_array($return_value)) {
            if ($return_value['isjobalertstore'] == 1) {
                if ($return_value['status'] == "Job Alert Edit") {
                    $jobalertstatus = "ok";
                } elseif ($return_value['status'] == "Job Alert Add") {
                    $jobalertstatus = "ok";
                }
                $_model = $this->getmodel('', 'JSJobsModel');
                $logarray['uid'] = $model->_uid;
                $logarray['uid'] = $model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Job Alert";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                if (isset($return_value['alertcities'])) {
                    $jobsharing->updateMultiCityServerid($return_value['alertcities'], 'jobalertcities');
                }

                $jobsharing->writeJobSharingLog($logarray);
                $jobsharing->UpdateServerStatus($jobalertstatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'jobalertsetting');
            } elseif ($return_value['isjobalertstore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $jobalertstatus = "Data not post on server";
                } elseif ($return_value['status'] == "Job Alert Saving Error") {
                    $jobalertstatus = "Error Job Alert Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $jobalertstatus = "Authentication Fail";
                }
                $_model = $this->getmodel('', 'JSJobsModel');
                $logarray['uid'] = $model->_uid;
                $logarray['uid'] = $model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Job Alert";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->writeJobSharingLog($logarray);
                $jobsharing->UpdateServerStatus($jobalertstatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'jobalertsetting');
            }
            JSJOBSActionMessages::setMessage(SAVED, 'jobalert','message');
        } else {
            if ($return_value == 1) {
                JSJOBSActionMessages::setMessage(SAVED, 'jobalert','message');
            } else if ($return_value == 2) {
                JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'jobalert','error');
            } else if ($return_value == 3) {
                JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'jobalert','notice');
            } else {
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'jobalert','error');
            }
        }
        $this->setRedirect($link);
    }

    function unsubscribeJobAlertSetting() {
        $data = JRequest::get('post');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $alertid = $cid[0];
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $jobalert_model = $this->getmodel('Jobalert', 'JSJobsModel');
        $return_value = $jobalert_model->unSubscribeJobAlert($alertid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage('You unsubscribe job alert', 'jobalert','message');
        } else {
            JSJOBSActionMessages::setMessage('Error to unsubscribe job alert', 'jobalert','error');
        }
        $link = 'index.php?option=com_jsjobs&c=jobalert&view=jobalert&layout=jobalert';
        $this->setRedirect($link);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'jobalert');
        $layoutName = JRequest::getVar('layout', 'jobalert');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $jobalert_model = $this->getModel('Jobalert', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($jobalert_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($jobalert_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>