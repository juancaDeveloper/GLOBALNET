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

class JSJobsControllerCompany extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function companyenforcedelete() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $companyid = $cid[0];
        $user = JFactory::getUser();
        $uid = $user->id;
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->companyEnforceDelete($companyid, $uid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'company','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'company','error');
            $msg = JText::_('Error in deleting company');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'company','error');
        }
        $layout = JRequest::getVar('callfrom','companies');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout='.$layout;
        $this->setRedirect($link);
    }

    function savecompany() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->storeCompany();
        $layout = JRequest::getvar('callfrom','companies');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout='.$layout;
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'company','message');
        } elseif ($return_value == 6) {
            JSJOBSActionMessages::setMessage(SAVED, 'company','message');
            JSJOBSActionMessages::setMessage(FILE_TYPE_ERROR, 'company','warning');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'comapny','error');
            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=formcompany'.JRequest::getVar('id');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'company','error');
        }
        $this->setRedirect($link);
    }    

    function companyapprove() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->companyApprove($companyid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'company','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'company','error');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link);
    }

    function companyreject() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->companyReject($companyid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'company','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'company','error');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link);
    }

    function featuredcompanyapprove() {
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->featuredCompanyApprove($companyid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'featuredcompany','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'featuredcompany','error');

        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link);
    }

    function featuredcompanyreject() {
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->featuredCompanyReject($companyid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'featuredcompany','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'featuredcompany','error');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link);
    }

    function goldcompanyapprove() {
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->goldCompanyApprove($companyid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'goldcompany','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'goldcompany','error');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link);
    }

    function goldcompanyreject() {
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->goldCompanyReject($companyid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'goldcompany','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'goldcompany','error');

        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link);
    }

    function allapprove() {
        $id = JRequest::getVar('id');
        $alltype = JRequest::getVar('alltype');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->allApproveActions($id , $alltype);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'company','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'company','error');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link);
    }

    function allreject() {
        $id = JRequest::getVar('id');
        $alltype = JRequest::getVar('alltype');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->allRejectActions($id , $alltype);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'company','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'company','error');
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue';
        $this->setRedirect($link);
    }

    function savegoldcompany() {
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->storeGoldCompany($companyid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'goldcompany','message');
        } else if ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'goldcompany','error');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'goldcompany','error');
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companies';
        $this->setRedirect($link);
    }

    function removegoldcompany() {
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $returnvalue = $company_model->deleteGoldCompany($companyid);
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'goldcompany','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'goldcompany','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=company&view=company&layout=companies');
    }


    function savefeaturedcompany() {
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $return_value = $company_model->storeFeaturedCompany($companyid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'featuredcompany','message');
        } elseif ($return_value == 6) {
            JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'featuredcompany','error');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'featuredcompany','error');
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companies';
        $this->setRedirect($link);
    }

    function removefeaturedcompany() {
        $companyid = JRequest::getVar('id');
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $returnvalue = $company_model->deleteFeaturedCompany($companyid);
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'featuredcompany','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'featuredcompany','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=company&view=company&layout=companies');
    }

    function addgoldcompanies() {
        JRequest::setVar('layout', 'addtogoldcompanies');
        JRequest::setVar('view', 'company');
        JRequest::setVar('c', 'company');
        $this->display();
    }

    function addfeaturedcompanies() {
        JRequest::setVar('layout', 'addtofeaturedcompanies');
        JRequest::setVar('view', 'company');
        JRequest::setVar('c', 'company');
        $this->display();
    }

    function remove() {
        $company_model = $this->getmodel('Company', 'JSJobsModel');
        $returnvalue = $company_model->deleteCompany();
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'company','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'company','error');
        }
        $layout = JRequest::getVar('callfrom','companies');
        $this->setRedirect('index.php?option=com_jsjobs&c=company&view=company&layout='.$layout);
        
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'company','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=company&view=company&layout=companies');
    }

    function edit() {
        JRequest::setVar('layout', 'formcompany');
        JRequest::setVar('view', 'company');
        JRequest::setVar('c', 'company');
        $layout = JRequest::getVar('callfrom','companies');
        JRequest::setVar('callfrom', $layout);
        $this->display();
    }

    function postcompanyonjomsocial(){
        JRequest::checkToken('get') OR jexit('Invalid Token');
        $companyid = JRequest::getVar('id',0);
        $res = JSModel::getJSModel('company')->postCompanyOnJomSocial($companyid);
        if($res){
            JSJOBSActionMessages::setMessage("Company has been successfully posted on JomSocial", 'company','message');
        }else{
            JSJOBSActionMessages::setMessage("Company has not been posted on JomSocial", 'company','error');
        }
        $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=companies&Itemid=' . $Itemid;
        $this->setRedirect($link);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'company');
        $layoutName = JRequest::getVar('layout', 'companies');
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
