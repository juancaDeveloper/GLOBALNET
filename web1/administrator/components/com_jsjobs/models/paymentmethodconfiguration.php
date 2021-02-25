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
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelPaymentmethodconfiguration extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getPaymentMethodsConfig() {
        $db = $this->getDBO();
        $query = "SELECT * FROM `#__js_job_paymentmethodconfig`";
        $db->setQuery($query);
        $paymentmethodconfig = $db->loadObjectList();
        foreach ($paymentmethodconfig AS $configvalue) {
            $config[$configvalue->configname] = $configvalue->configvalue;
        }
        return $config;
    }

    function storePaymentMethodsLinks($packageid, $linkids, $paymentmethodsid, $links, $packagefor) {

        $row = $this->getTable('paymentmethodlinks');

        for ($i = 0; $i < count($paymentmethodsid); $i++) {
            if ((!empty($links[$i])) && ($links[$i] != '')) {
                if (isset($linkids[$i]))
                    $row->id = $linkids[$i];
                else
                    $row->id = '';
                $row->packageid = $packageid;
                $row->paymentmethodid = $paymentmethodsid[$i];
                $row->link = $links[$i];
                $row->packagefor = $packagefor; // 1 for employer package link and 2 for jobseeker package link 

                $row->store();
            }
        }
    }

    function storePaymentConfig() {
        $row = $this->getTable('paymentmethodconfig');
        $data = JRequest::get('post');
        $config = array();
        if (!isset($data['showname_westernunion']))
            $data['showname_westernunion'] = 0;
        if (!isset($data['showcountryname_westernunion']))
            $data['showcountryname_westernunion'] = 0;
        if (!isset($data['showcityname_westernunion']))
            $data['showcityname_westernunion'] = 0;
        if (!isset($data['showaccountinfo_westernunion']))
            $data['showaccountinfo_westernunion'] = 0;

        $db = JFactory::getDbo();
        foreach ($data as $key => $value) {
            $query = "UPDATE `#__js_job_paymentmethodconfig` SET `configvalue` = '" . $value . "' WHERE `configname` = '" . $key . "';";
            $db->setQuery($query);
            $db->query();
        }
        if(isset($data['isenabled_virtuemart'])){
            $query = "UPDATE `#__js_job_config` SET `configvalue` = '".$data['isenabled_virtuemart']."' WHERE `configname` = 'isenabled_virtuemart';";
            $db->setQuery($query);
            $db->query();
        }
        return true;
    }

    function getPaymentMethodLinks($packageid, $packagefor) {
        if (!is_numeric($packageid))
            return false;
        if (!is_numeric($packagefor))
            return false;
        $db = $this->getDBO();
        $query = "SELECT paymentmethod.id AS paymentmethod_id,paymentmethod.title, link.id AS linkid, link.link
						FROM `#__js_job_paymentmethods` AS paymentmethod
						LEFT JOIN `#__js_job_paymentmethodlinks` AS link ON link.paymentmethodid = paymentmethod.id AND link.packageid=" . $packageid . " AND link.packagefor=" . $packagefor . "
						WHERE enable = 1 OR haslink = 1  ";

        $db->setQuery($query);
        $paymentmethods = $db->loadObjectList();
        return $paymentmethods;
    }
    
}

?>
