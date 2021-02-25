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

class JSJobsControllerCompany extends JSController {

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

    function addtofeaturedcompany() {
        $Itemid = JRequest::getVar('Itemid');
        $user = JFactory::getUser();
        $uid = $user->id;
        $common = $this->getmodel('Common', 'JSJobsModel');
        $companyid = $common->parseId(JRequest::getVar('cd', ''));
        $packageid = JRequest::getVar('pk', '');
        $company = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company->storeFeaturedCompany($uid, $companyid);
        if ($return_value == 1) {
            $configvalue = $this->getmodel('configurations')->getConfigValue('featuredcompany_autoapprove');
            if($configvalue != 1){
                JSJOBSActionMessages::setMessage(WAITING_FOR_APPROVAL, 'featuredcompany','notice');
            }else{
                JSJOBSActionMessages::setMessage(SAVED, 'featuredcompany','message');                
            }
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'featuredcompany','error');
        } else if ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'featuredcompany','warning');
        } else if ($return_value == 5) {
            JSJOBSActionMessages::setMessage(CAN_NOT_ADD_NEW, 'featuredcompany','error');
        } else if ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'featuredcompany','warning');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'featuredcompany','error');
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function addtogoldcompany() {
        $Itemid = JRequest::getVar('Itemid');
        $user = JFactory::getUser();
        $uid = $user->id;
        $common = $this->getmodel('Common', 'JSJobsModel');
        $companyid = $common->parseId(JRequest::getVar('cd', ''));
        $packageid = JRequest::getVar('pk', '');
        $company = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company->storeGoldCompany($uid, $companyid);
        if ($return_value == 1) {
            $configvalue = $this->getmodel('configurations')->getConfigValue('goldcompany_autoapprove');
            if($configvalue != 1){
                JSJOBSActionMessages::setMessage(WAITING_FOR_APPROVAL, 'goldcompany','notice');
            }else{
                JSJOBSActionMessages::setMessage(SAVED, 'goldcompany','message');                
            }
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'goldcompany','error');
        } else if ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'goldcompany','warning');
        } else if ($return_value == 5) {
            JSJOBSActionMessages::setMessage(CAN_NOT_ADD_NEW, 'goldcompany','error');
        } else if ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'goldcompany','warning');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'goldcompany','error');
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function savecompany() { //save company
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $company = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company->storeCompany();
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $Itemid;

        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'company','message');
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'company','error');
            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=' . $Itemid;
        } else if ($return_value == 6) {
            JSJOBSActionMessages::setMessage(FILE_TYPE_ERROR, 'company','warning');
        } else if ($return_value == 5) {
            JSJOBSActionMessages::setMessage(FILE_SIZE_ERROR, 'company','warning');
            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=' . $Itemid;
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'company','error');
            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function deletecompany() { //delete company
        JRequest::checkToken('get') OR jexit('Invalid Token');
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $companyid = $common->parseId(JRequest::getVar('cd', ''));
        $company = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company->deleteCompany($companyid, $uid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'company','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'company','error');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'company','error');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'company','error');
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function postcompanyonjomsocial(){
        JRequest::checkToken('get') OR jexit('Invalid Token');
        $isallowed = JSModel::getJSModel('configurations')->getConfigValue('jomsocial_allowpostcompany');
        if($isallowed){            
            $companyid = JRequest::getVar('id',0);
            $res = JSModel::getJSModel('company')->postCompanyOnJomSocial($companyid);
            if($res){
                JSJOBSActionMessages::setMessage("Company has been successfully posted on JomSocial", 'company','message');
            }else{
                JSJOBSActionMessages::setMessage("Company has not been posted on JomSocial", 'company','error');
            }
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $Itemid;
        $this->setRedirect($link);
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
    
