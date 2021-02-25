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

require_once(dirname(__FILE__).DS.'..'.DS.'groups.php');

class JFormFieldDJGroup extends JFormField {
	
	protected $type = 'DJGroup';
	
	protected function getInput()
	{
		$attr = ''; 

		$attr .= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$attr .= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		
		$disable_default = ($this->element['disable_default'] == 'true') ? true : false;
		$disable_self = ($this->element['disable_self'] == 'true') ? true : false;
		
		$groups = new DJTabsModelGroups();
		$options = $groups->getSelectOptions($disable_default, $disable_self);
    	
		$html = JHTML::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value);
		
		return ($html);
		
	}
}
?>