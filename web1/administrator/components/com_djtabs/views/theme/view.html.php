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
class DjTabsViewTheme extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;
	//protected $plgParams;

	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		
		$document=JFactory::getDocument();
		$document->addScript(JURI::base().'/components/com_djtabs/models/fields/djcolor/jscolor.js');
		$document->addScript(JURI::base().'/components/com_djtabs/assets/themeScript.js');
		
		$version = new JVersion;
		if (version_compare($version->getShortVersion(), '3.0.0', '<')) {
			$tpl = 'legacy';
		}
		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		       
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		//$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo		= true; //ContactHelper::getActions($this->state->get('filter.theme'));

		$text = $isNew ? JText::_( 'COM_DJTABS_NEW' ) : JText::_( 'COM_DJTABS_EDIT' );
		JToolBarHelper::title(   JText::_( 'COM_DJTABS_THEME' ).': <small><small>[ ' . $text.' ]</small></small>', 'theme-add' );
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-theme-add { background-image: url(components/com_djtabs/assets/icon-48-theme-add.png); }');
		
		// Built the actions for new and existing records.
		if ($isNew)  {
			// For new records, check the create permission.
			//if ($canDo->get('core.create')) {
				JToolBarHelper::apply('theme.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('theme.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('theme.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
			//}

			JToolBarHelper::cancel('theme.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			// Can't save the record if it's checked out.
			//if (!$checkedOut) {
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				//if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId)) {
					JToolBarHelper::apply('theme.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('theme.save', 'JTOOLBAR_SAVE');

					// We can save this record, but check the create permission to see if we can return to make a new one.
					//if ($canDo->get('core.create')) {
						JToolBarHelper::custom('theme.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					//}
				//}
			//}

			// If checked out, we can still save
			//if ($canDo->get('core.create')) {
				JToolBarHelper::custom('theme.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			//}

			JToolBarHelper::cancel('theme.cancel', 'JTOOLBAR_CLOSE');
		}

	}

}


