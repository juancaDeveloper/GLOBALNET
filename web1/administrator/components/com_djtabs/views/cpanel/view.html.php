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

jimport( 'joomla.application.component.view');
jimport( 'joomla.application.groups');
jimport('joomla.html.pane');

class DJTabsViewCpanel extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->addToolbar();
		if (class_exists('JHtmlSidebar')){
			$this->sidebar = JHtmlSidebar::render();
		}
		
		$version = new JVersion;
		if (version_compare($version->getShortVersion(), '3.0.0', '<')) {
			$tpl = 'legacy';
		}
			
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		    
		JToolBarHelper::title(JText::_('COM_DJTABS').' » '.JText::_('COM_DJTABS_CPANEL'), 'logo');
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-logo { background-image: url(components/com_djtabs/assets/icon-48-logo.png); }');
        
		JToolBarHelper::preferences('com_djtabs', 550, 500);
		
	}
}
