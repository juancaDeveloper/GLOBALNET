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

class JSJobsViewPostInstallation extends JSView
{
	function display($tpl = null)	{
		require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
		JToolBarHelper::title(JText::_('Installation Complete'));
		if($layoutName == 'stepone'){
			JToolBarHelper::title(JText::_('General Settings') );
			$result = $this->getJSModel('postinstallation')->getConfigurationValues();
			$this->assignRef('result', $result);
		}elseif($layoutName == 'steptwo'){
			JToolBarHelper::title(JText::_('Employer Settings') );
			$result = $this->getJSModel('postinstallation')->getConfigurationValues();
			$this->assignRef('result', $result);
		}elseif($layoutName == 'stepthree'){
			JToolBarHelper::title(JText::_('Jobseeker Settings') );
			$result = $this->getJSModel('postinstallation')->getConfigurationValues();
			$this->assignRef('result', $result);
		}elseif($layoutName == 'stepfour'){
			JToolBarHelper::title(JText::_('Sample Data') );
		}else{

		}

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
