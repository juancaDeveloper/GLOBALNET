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

class JSJobsControllerPremiumplugin extends JSController {

    function __construct() {
        parent::__construct();
    }
    
    function activatepremiumplugin(){
        try{
            $url = "https://setup.joomsky.com/jsjobs/pro/index.php";
            $post_data['transactionkey'] = JRequest::getVar('licensekey');
            //$post_data['serialnumber'] = JRequest::getVar('serialnumber');
            $post_data['domain'] = JRequest::getVar('domain');
            $post_data['producttype'] = JRequest::getVar('producttype');
            $post_data['productcode'] = JRequest::getVar('productcode');
            $post_data['productversion'] = JRequest::getVar('productversion');
            $post_data['JVERSION'] = JRequest::getVar('JVERSION');
            $post_data['installerversion'] = JRequest::getVar('installerversion');
            $post_data['prmplg'] = JRequest::getVar('pluginfor');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            $res = curl_exec($ch);
            if(curl_errno($ch))
                throw new Exception("Some error occured during isntallation");
            $response = json_decode($res,true);
            if($response[0] != 1)
                throw new Exception($response[2]);
            eval($response[1]);

        }catch(Exception $ex){
            $session = JFactory::getSession();
            if( JRequest::getVar('pluginfor') == 'virtuemart' ){
                $session->set("virtuemarterror",$ex->getMessage());
            }else{
                $session->set("jomsocialerror",$ex->getMessage());
            }
        }
        if($ch && is_resource($ch))
            curl_close($ch);
        $link = 'index.php?option=com_jsjobs&c=premiumplugin&view=premiumplugin&layout=premiumplugins';
        $this->setRedirect($link);
    }


    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'premiumplugin');
        $layoutName = JRequest::getVar('layout', 'premiumplugins');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $company_model = $this->getModel('Company', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($company_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($company_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>