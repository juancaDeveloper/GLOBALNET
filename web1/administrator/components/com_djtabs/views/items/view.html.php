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

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'groups.php');

class DJTabsViewItems extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		$groups = new DJTabsModelGroups();
		$this->group_options	= $groups->getSelectOptions(true);
		
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
		JToolBarHelper::title(JText::_('COM_DJTABS').' » '.JText::_('COM_DJTABS_ITEMS'), 'items');
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-items { background-image: url(components/com_djtabs/assets/icon-48-items.png); }');
		$par = JComponentHelper::getParams( 'com_djtabs' );
		
		// JSubMenuHelper::addEntry(JText::_('COM_DJTABS_CPANEL'), 'index.php?option=com_djtabs&view=cpanel', false);
        // JSubMenuHelper::addEntry(JText::_('COM_DJTABS_ITEMS'), 'index.php?option=com_djtabs&view=items', true);
		// JSubMenuHelper::addEntry(JText::_('COM_DJTABS_GROUPS'), 'index.php?option=com_djtabs&view=Groups', false);
		// JSubMenuHelper::addEntry(JText::_('COM_DJTABS_THEMES'), 'index.php?option=com_djtabs&view=themes', false);
			
		JToolBarHelper::addNew('item.add','JTOOLBAR_NEW');
		JToolBarHelper::editList('item.edit','JTOOLBAR_EDIT');
		JToolBarHelper::deleteList('', 'items.delete','JTOOLBAR_DELETE');
		JToolBarHelper::divider();
		JToolBarHelper::custom('items.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
		JToolBarHelper::custom('items.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_djtabs', 550, 500);
		if($par->get('thumbnails',0)){
			JToolBarHelper::divider();
			JToolBarHelper::custom('items.purgeThumbs', 'trash', 'trash','COM_DJTABS_PURGE_THUMBS', false);
			JToolBarHelper::custom('items.resmushThumbs', 'wand', 'wand','COM_DJTABS_RESMUSH_THUMBS', false);
		}	
	}
}