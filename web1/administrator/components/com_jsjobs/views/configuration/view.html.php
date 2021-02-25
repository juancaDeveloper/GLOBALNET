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
// Options button.
if (JFactory::getUser()->authorise('core.admin', 'com_jsjobs')) {
    JToolBarHelper::preferences('com_jsjobs');
}

class JSJobsViewConfiguration extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'configurations' || $layoutName == 'configurationsemployer' || $layoutName == 'configurationsjobseeker') {
            if ($layoutName == 'configurations')
                $ptitle = JText::_('Configurations');
            elseif ($layoutName == 'configurationsemployer')
                $ptitle = JText::_('Employer Configurations');
            else
                $ptitle = JText::_('Job Seeker Configurations');
            JToolBarHelper::title($ptitle);
            JToolBarHelper::save('configuration.save');
            $result = $this->getJSModel('configuration')->getConfigurationsForForm();
            $this->assignRef('lists', $result[1]);
        }elseif ($layoutName == 'themes') {    //Themes
            JToolBarHelper::title(JText::_('Themes'));
            JToolBarHelper::save('configuration.savetheme');
            JToolBarHelper::cancel('configuration.canceltheme');
            $theme = $this->getJSModel('configuration')->getCurrentTheme();
            $this->assignRef('theme', $theme);
        }elseif($layoutName == 'cronjob'){
            JToolBarHelper::title(JText::_('Cron Job'));
            $ck = $this->getJSModel('configuration')->getCronKey(md5(date('Y-m-d')));
            $this->assignRef('ck', $ck);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }
}
?>