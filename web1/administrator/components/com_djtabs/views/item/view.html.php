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

jimport('joomla.application.component.view');
class DJTabsViewItem extends JViewLegacy {
    protected $form;
    protected $item;
    protected $state;

    public function display($tpl = null) {
        // Initialiase variables.

        $this -> form = $this -> get('Form');
        $this -> item = $this -> get('Item');
        $this -> state = $this -> get('State');

/*
        $lang =& JFactory::getLanguage();
		$extension = 'com_content';
		$base_dir = JPATH_ADMINISTRATOR;
		$language_tag = 'en-GB';
		$reload = true;
		$lang->load($extension, $base_dir);
*/
       
        // Check for errors.
        if (count($errors = $this -> get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }

        $this -> addToolbar();
		
		$version = new JVersion;
		if (version_compare($version->getShortVersion(), '3.0.0', '<')) {
			$tpl = 'legacy';
		}
		
        parent::display($tpl);
    }

    protected function addToolbar() {
        JRequest::setVar('hidemainmenu', true);
        $id = 0;
        $user = JFactory::getUser();

        $userId = $user -> get('id');
        $isNew = ($this -> item -> id == 0);

        $text = $isNew ? JText::_('COM_DJTABS_NEW') : JText::_('COM_DJTABS_EDIT');
        JToolBarHelper::title(JText::_('COM_DJTABS_ITEM') . ': <small><small>[ ' . $text . ' ]</small></small>', 'item-add');
        $doc = JFactory::getDocument();
        $doc -> addStyleDeclaration('.icon-48-item-add { background-image: url(components/com_djtabs/assets/icon-48-item-add.png); }');

        // Built the actions for new and existing records.
        if ($isNew) {
            JToolBarHelper::apply('item.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('item.save', 'JTOOLBAR_SAVE');
            JToolBarHelper::custom('item.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
            JToolBarHelper::cancel('item.cancel', 'JTOOLBAR_CANCEL');
        } else {
            // Can't save the record if it's checked out.
            JToolBarHelper::apply('item.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('item.save', 'JTOOLBAR_SAVE');
            JToolBarHelper::custom('item.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

            JToolBarHelper::custom('item.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
            JToolBarHelper::cancel('item.cancel', 'JTOOLBAR_CLOSE');
        }

    }

}
