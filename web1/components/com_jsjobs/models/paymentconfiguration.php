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
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest::getVar('option', 'com_jsjobs');

class JSJobsModelPaymentConfiguration extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getIdealPayment() {
        $db = $this->getDBO();
        $query = "SELECT payment.* FROM `#__js_job_paymentmethodconfig` AS payment 
				WHERE payment.configfor='ideal'";
        $db->setQuery($query);
        $config = $db->loadObjectList();
        foreach ($config AS $conf) {
            $return[$conf->configfor][$conf->configname] = $conf->configvalue;
        }
        return $return;
    }

    function getPaymentMethodsConfig() {
        $db = $this->getDBO();
        $query = "SELECT payment.* FROM `#__js_job_paymentmethodconfig` AS payment WHERE payment.configname LIKE 'isenabled_%' OR payment.configname LIKE 'title_%'";
        $db->setQuery($query);
        $config = $db->loadObjectList();
        foreach ($config AS $conf) {
            $return[$conf->configfor][$conf->configname] = $conf->configvalue;
        }
        return $return;
    }

}
?>
    
