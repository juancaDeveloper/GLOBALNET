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

class JSJobsControllerReport extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function remove() {
        $report_model = $this->getmodel('Report', 'JSJobsModel');
        $returnvalue = $report_model->deleteReport();
        if ($returnvalue == 1)
            JSJOBSActionMessages::setMessage(DELETED, 'report','message');
        else
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'report','error');
        $this->setRedirect('index.php?option=com_jsjobs&c=age&view=age&layout=ages');
    }

    function exportjobsdata() {
        $report_model = $this->getmodel('Report', 'JSJobsModel');
        $returnvalue = $report_model->exportJobsData();
        die('back in controller');
        if ($returnvalue == 1)
            JSJOBSActionMessages::setMessage(DELETED, 'report','message');
        else
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'report','error');
        $this->setRedirect('index.php?option=com_jsjobs&c=age&view=age&layout=ages');
    }

    function exportcompaniesdata() {
        $report_model = $this->getmodel('Report', 'JSJobsModel');
        $returnvalue = $report_model->exportCompaniesData();
        die('back in controller');
    }

    function exportresumesdata() {
        $report_model = $this->getmodel('Report', 'JSJobsModel');
        $returnvalue = $report_model->exportResumesData();
        die('back in controller');
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'report','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=age&view=age&layout=ages');
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'report');
        $layoutName = JRequest::getVar('layout', 'ages');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $report_model = $this->getModel('Report', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($report_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($report_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }
}
?>