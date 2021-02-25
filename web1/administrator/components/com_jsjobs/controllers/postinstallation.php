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

defined('_JEXEC') or die('Not Allowed');

jimport('joomla.application.component.controller');

class JSJobsControllerPostInstallation extends JSController {

    function __construct() {
        parent::__construct();
    }

    function save() {
      JSession::checkToken('post') or jexit(JText::_('JINVALID_TOKEN'));
      $data = JRequest::get('post');
      $callfrom = $data['step'];
      if($callfrom == 4){
        $insertsampledata = $data['sampledata'];
        $createmenu = $data['importmenu'];
        $result = $this->getJSController('installer')->installSampleData($insertsampledata,$createmenu);
      }else{
        $result = $this->getmodel('postinstallation','JSJobsModel')->storeConfigurations($data);
      }
      $link = 'index.php?option=com_jsjobs&c=postinstallation&layout=steptwo';
      if ($result == SAVED) {
        if ($callfrom == 2) {
          $link = 'index.php?option=com_jsjobs&c=postinstallation&layout=stepthree';
        }elseif ($callfrom == 3) {
          $link = 'index.php?option=com_jsjobs&c=postinstallation&layout=stepfour';
        }elseif ($callfrom == 4) {
          $link = 'index.php?option=com_jsjobs&c=postinstallation&layout=settingcomplete';
        } 
      }else{
        $link = 'index.php?option=com_jsjobs&c=postinstallation&layout='.$data['layout'];
      }
      $this->setRedirect($link);
    }
    
    function display($cachable = false, $urlparams = false) {
      $document = JFactory::getDocument();
      $viewName = JRequest::getVar('view', 'postinstallation');
      $layoutName = JRequest::getVar('layout', 'stepone');
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
