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

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewPremiumplugin extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
        if( $layoutName == 'premiumplugins' ){
            $db = JFactory::getDbo();
            //virtuemart
            $vmEnabled = JComponentHelper::isEnabled('com_virtuemart');
            $jsjobsVmEnabled = file_exists(JPATH_PLUGINS.'/vmextended/jsjobs');
            $query = "SELECT * FROM `#__extensions` WHERE `type`='plugin' AND `element`='jsjobs' AND `folder`='vmextended'";
            eval($this->getJSModel('common')->b64ForDecode($this->getJSModel('configuration')->getConfigValue('vmjsbasic')));
            $db->setQuery($query);
            $vmVerified = $db->loadResult() ? 1 : 0;
            $virtuemart = (object) compact('vmEnabled','jsjobsVmEnabled','vmVerified');

            //jomsocial
            $jmEnabled = JComponentHelper::isEnabled('com_community');
            $jsjobsJmEnabled = file_exists(JPATH_PLUGINS.'/community/jsjobs');
            $query = "SELECT * FROM `#__extensions` WHERE `type`='plugin' AND `element`='jsjobs' AND `folder`='community'";
            eval($this->getJSModel('common')->b64ForDecode($this->getJSModel('configuration')->getConfigValue('jmjsbasic')));
            $db->setQuery($query);
            $jmVerified = $db->loadResult() ? 1 : 0;
            $jomsocial = (object) compact('jmEnabled','jsjobsJmEnabled','jmVerified');

            $versioncode = $this->getJSModel('jsjobs')->getConfigByConfigName('version');
            $versiontype = $this->getJSModel('jsjobs')->getConfigByConfigName('versiontype');
            $writeable = is_writable(JPATH_ROOT.'/tmp');

            $this->assignRef('versioncode', $versioncode);
            $this->assignRef('versiontype', $versiontype);
            $this->assignRef('writeable',$writeable);
            $this->assignRef('virtuemart',$virtuemart);
            $this->assignRef('jomsocial',$jomsocial);
        }
        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('items', $items);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);
        parent::display($tpl);
    }

}
?>