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

class JSJobsControllerPaymentmethodconfiguration extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function savepaymentconf() {
        $paymentmethodconfiguration_model = $this->getmodel('Paymentmethodconfiguration', 'JSJobsModel');
        $return_value = $paymentmethodconfiguration_model->storePaymentConfig();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'paymentmethodconfiguration','message');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'paymentmethodconfiguration','error');
        }
        $link = 'index.php?option=com_jsjobs&c=paymentmethodconfiguration&view=paymentmethodconfiguration&layout=paymentmethodconfig';
        $this->setRedirect($link);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'paymentmethodconfiguration');
        $layoutName = JRequest::getVar('layout', 'paymentmethodconfiguration');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $paymentmethodconfiguration_model = $this->getModel('Paymentmethodconfiguration', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($paymentmethodconfiguration_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($paymentmethodconfiguration_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>