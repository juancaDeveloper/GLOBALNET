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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'groups.php');

class DJTabsViewThemes extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
	
		$this->addToolbar();
		if (class_exists('JHtmlSidebar')){
			$this->sidebar = JHtmlSidebar::render();
		}
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_DJTABS').' » '.JText::_('COM_DJTABS_THEMES'), 'themes');
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-themes { background-image: url(components/com_djtabs/assets/icon-48-themes.png); }');

		// JSubMenuHelper::addEntry(JText::_('COM_DJTABS_CPANEL'), 'index.php?option=com_djtabs&view=cpanel', false);
        // JSubMenuHelper::addEntry(JText::_('COM_DJTABS_ITEMS'), 'index.php?option=com_djtabs&view=items', false);
		// JSubMenuHelper::addEntry(JText::_('COM_DJTABS_GROUPS'), 'index.php?option=com_djtabs&view=groups', false);
		// JSubMenuHelper::addEntry(JText::_('COM_DJTABS_THEMES'), 'index.php?option=com_djtabs&view=themes', true);
		
		JToolBarHelper::addNew('theme.add','JTOOLBAR_NEW');
		JToolBarHelper::editList('theme.edit','JTOOLBAR_EDIT');
		JToolBarHelper::deleteList('', 'themes.delete','JTOOLBAR_DELETE');
		JToolBarHelper::divider();
		JToolBarHelper::custom('themes.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
		JToolBarHelper::custom('themes.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_djtabs', 550, 500);
		
	}
}