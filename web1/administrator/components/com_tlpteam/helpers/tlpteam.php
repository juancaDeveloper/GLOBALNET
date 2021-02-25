<?php
/**
 * @version     1.1
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Tlpteam helper.
 */
class TlpteamHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_TLPTEAM_TITLE_TEAMS'),
			'index.php?option=com_tlpteam&view=teams',
			$vName == 'teams'
		);
		JHtmlSidebar::addEntry(
			JText::_('JCATEGORIES') . ' (' . JText::_('COM_TLPTEAM_TITLE_TEAMS') . ')',
			"index.php?option=com_categories&extension=com_tlpteam",
			$vName == 'categories'
		);
		if ($vName=='categories') {
			JToolBarHelper::title('TLP Team Pro: JCATEGORIES (COM_TLPTEAM_TITLE_TEAMS)');
		}
		JHtmlSidebar::addEntry(
			JText::_('COM_TLPTEAM_TITLE_SKILLS'),
			'index.php?option=com_tlpteam&view=skills',
			$vName == 'skills'
		);
		

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_tlpteam';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }



    
        
}

