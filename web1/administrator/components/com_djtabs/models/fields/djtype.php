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

defined('_JEXEC') or die();
defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');


class JFormFieldDJType extends JFormField {
	
	protected $type = 'DJType';
	
	protected function getInput()
	{
		$types[] = JHTML::_('select.option', 2, JText::_('COM_DJTABS_TYPE_SINGLE_ARTICLE'));
		$types[] = JHTML::_('select.option', 1, JText::_('COM_DJTABS_TYPE_ARTICLE_CATEGORY'));
		$types[] = JHTML::_('select.option', 3, JText::_('COM_DJTABS_TYPE_MODULE_POSITION'));
		$types[] = JHTML::_('select.option', 4, JText::_('COM_DJTABS_TYPE_VIDEO_LINK'));
		
		//if (JComponentHelper::getComponent('com_k2', true)->enabled)
		if(JFile::exists(JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php'))
		{
			$types[] = JHTML::_('select.option', 6, JText::_('COM_DJTABS_TYPE_K2_SINGLE_ARTICLE'));
			$types[] = JHTML::_('select.option', 5, JText::_('COM_DJTABS_TYPE_K2_ARTICLE_CATEGORY'));
		}

		$html = JHTML::_('select.genericlist', $types, $this->name, '', 'value', 'text', $this->value);
		
		return $html;
	}
	
}
?>