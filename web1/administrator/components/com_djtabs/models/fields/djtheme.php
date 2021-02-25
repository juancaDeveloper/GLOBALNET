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


class JFormFieldDJTheme extends JFormField {
	
	protected $type = 'DJTheme';
	
	protected function getInput()
	{
		$db = JFactory::getDBO();
		
        $query = 'SELECT * FROM #__djtabs_themes WHERE published=1 ORDER BY ordering, id';
					
        $db -> setQuery($query);
        $themes = $db -> loadObjectList();
		
		//$db->query();
		//$rows_num = $db -> getNumRows();
		$rows_num = count($themes);
		
		$i=0;
		$random_num=rand(1, $rows_num);
		
		$themes_array[] = JHTML::_('select.option',-1,'['.JText::_('COM_DJTABS_DEFAULT_THEME').']');
		
		foreach ($themes as $theme){
			
			$i++;
			
			if ($i==$random_num)
				$themes_array[] = JHTML::_('select.option',0,'»'.JText::_('COM_DJTABS_RANDOM_THEME').'«');
			
			$themes_array[] = JHTML::_('select.option',$theme->id,$theme->title);		
			
		}	
		//echo '<pre>';print_r($themes);die();
		$html = JHTML::_('select.genericlist', $themes_array, $this->name, '', 'value', 'text', $this->value);
		
		return ($html);
		
	}
	
}
?>