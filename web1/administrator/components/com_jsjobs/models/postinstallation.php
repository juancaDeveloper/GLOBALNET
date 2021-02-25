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

jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelPostInstallation extends JSModel {

    function __construct() {
        parent::__construct();
    }

    function storeConfigurations($data){
        if (empty($data))
            return false;
        $error = false;
        $db = $this->getDBO();
        unset($data['action']);
        unset($data['form_request']);
        foreach ($data as $key => $value) {
            $query = "UPDATE `#__js_job_config` SET `configvalue` = '" . $value . "' WHERE `configname`= '" . $key . "'";
            $db->setQuery($query);
            if (!$db->query()) {
                $error = true;
            }
        }
        if ($error)
            return SAVE_ERROR;
        else
            return SAVED;
    }

    function getConfigurationValues(){
        $db = JFactory::getDBO();
        $query = "SELECT configvalue,configname  FROM `#__js_job_config`";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        $config_array = array();
        foreach ($data as $config) {
            $config_array[$config->configname]=$config->configvalue;
        }
        return $config_array;
	}
}
