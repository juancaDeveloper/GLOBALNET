<?php
/**
 * @version 1.0
 * @package DJ-Tabs
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Piotr Dobrakowski - piotr.dobrakowski@design-joomla.eu
 *
 * DJ-Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Tabs. If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die('Restricted access');

class DJTabsAdminHelper
{
	public static function addSubmenu($vName = 'cpanel')
	{
		$app = JFactory::getApplication();
		$version = new JVersion;

		if (version_compare($version->getShortVersion(), '3.0.0', '<')) {
			JSubMenuHelper::addEntry(JText::_('COM_DJTABS_CPANEL'), 'index.php?option=com_djtabs&view=cpanel', $vName=='cpanel');
			JSubMenuHelper::addEntry(JText::_('COM_DJTABS_ITEMS'), 'index.php?option=com_djtabs&view=items', $vName=='items');  
	        JSubMenuHelper::addEntry(JText::_('COM_DJTABS_GROUPS'), 'index.php?option=com_djtabs&view=groups', $vName=='groups');
	        JSubMenuHelper::addEntry(JText::_('COM_DJTABS_THEMES'), 'index.php?option=com_djtabs&view=themes', $vName=='themes');
		} else {
			JHtmlSidebar::addEntry(JText::_('COM_DJTABS_CPANEL'), 'index.php?option=com_djtabs&view=cpanel', $vName=='cpanel');
			JHtmlSidebar::addEntry(JText::_('COM_DJTABS_ITEMS'), 'index.php?option=com_djtabs&view=items', $vName=='items');  
	        JHtmlSidebar::addEntry(JText::_('COM_DJTABS_GROUPS'), 'index.php?option=com_djtabs&view=groups', $vName=='groups');
	        JHtmlSidebar::addEntry(JText::_('COM_DJTABS_THEMES'), 'index.php?option=com_djtabs&view=themes', $vName=='themes');
		}
	}
}

?>