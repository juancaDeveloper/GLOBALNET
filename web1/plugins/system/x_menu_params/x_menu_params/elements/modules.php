<?php
/**
 * @package Sj Megamenu
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Radio List Element
 *
 */
if (class_exists('JFormField')){
	class JFormFieldModules extends JFormField
	{
		/**
		 * Element name
		 *
		 * @access	protected
		 * @var		string
		 */
		protected $type = 'Modules';
		
		function getInput() {
			$db =& JFactory::getDBO();
			$query = "SELECT e.extension_id, a.id, a.title, a.note, a.position, a.module, a.language,a.checked_out, a.checked_out_time, a.published, a.access, a.ordering, a.publish_up, a.publish_down,l.title AS language_title,uc.name AS editor,ag.title AS access_level,MIN(mm.menuid) AS pages,e.name AS name
						FROM `#__modules` AS a
						LEFT JOIN `#__languages` AS l ON l.lang_code = a.language
						LEFT JOIN #__users AS uc ON uc.id=a.checked_out
						LEFT JOIN #__viewlevels AS ag ON ag.id = a.access
						LEFT JOIN #__modules_menu AS mm ON mm.moduleid = a.id
						LEFT JOIN #__extensions AS e ON e.element = a.module
						WHERE (a.published IN (0, 1)) AND a.client_id = 0
						GROUP BY a.id";
			$db->setQuery($query);
			$groups = $db->loadObjectList();
				
			$groupHTML = array();
			if ($groups && count ($groups)) {
				foreach ($groups as $v=>$t){
					$groupHTML[] = JHTML::_('select.option', $t->id, $t->title);
				}
			}
			$lists = JHTML::_('select.genericlist', $groupHTML, "{$this->name}[]", ' multiple="multiple"  size="10" ', 'value', 'text', $this->value);
				
			return $lists;
		}
	}
}