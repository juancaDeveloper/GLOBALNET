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

class JSJobsControllerConfiguration extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function savetheme() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $configuration_model = $this->getmodel('Configuration', 'JSJobsModel');
        $return_value = $configuration_model->storeTheme();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'settings','message');
            $link = 'index.php?option=com_jsjobs';
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'settings','error');
            $link = 'index.php?option=com_jsjobs&c=configuration&view=configuration&layout=themes';
        }
        $this->setRedirect($link);
    }

    function canceltheme() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'settings','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=configuration&view=configuration&layout=themes');
    }

    function save() {
        $layout = JRequest::getVar('layout');
        $configuration_model = $this->getmodel('Configuration', 'JSJobsModel');
        $return_value = $configuration_model->storeConfig();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'settings','message');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'settings','error');
        }
        $this->resetsession();
        $link = 'index.php?option=com_jsjobs&c=configuration&view=configuration&layout=' . $layout;
        $this->setRedirect($link);
    }

    function resetsession() {
        $session = JFactory::getSession();
        $session->clear('jsjobconfig_dft');
        $session->clear('jsjobconfig');
    }

    function makedefaulttheme() { // make default theme
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $defaultid = $cid[0];
        $configuration_model = $this->getmodel('Configuration', 'JSJobsModel');
        $return_value = $configuration_model->makeDefaultTheme($defaultid, 1);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'settings','message');
            $this->resetsession();
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'settings','error');
        }
        $link = 'index.php?option=com_jsjobs&c=configuration&view=configuration&layout=themes';
        $this->setRedirect($link);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'configuration');
        $layoutName = JRequest::getVar('layout', 'configuration');
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