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

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class DJTabsModelGroup extends JModelAdmin
{
	public function getTable($type = 'Groups', $prefix = 'DJTabsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		jimport('joomla.form.form');

		// Get the form.
		$form = $this->loadForm('com_djtabs.group', 'group', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_djtabs.edit.group.data', array());

		if (empty($data)) {
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('group.id') == 0) {
				$app = JFactory::getApplication();
				$data->set('parent_id', JRequest::getInt('parent_id', $app->getUserState('com_djtabs.groups.filter.group')));
			}
		}

		return $data;
	}
	
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		$table->title		= htmlspecialchars_decode($table->title, ENT_QUOTES);
		$table->alias		= JApplication::stringURLSafe($table->alias);

		if (empty($table->alias)) {
			$table->alias = JApplication::stringURLSafe($table->title);
		}

		if (empty($table->id)) {

			// Set ordering to the last item if not set
			if (empty($table->ordering)) {
				$db = JFactory::getDbo();
				$query = 'SELECT MAX(ordering) FROM #__djtabs_groups';
				if($table->parent_id) $query.= ' WHERE parent_id='. (int) $table->parent_id;
				$db->setQuery($query);
				$max = $db->loadResult();
				
				$table->ordering = $max+1;
			}
		}
	}
	
	protected function getReorderConditions($table)
	{
		$condition = array();
		$condition[] = 'parent_id = '.(int) $table->parent_id;

		return $condition;
	}
	

	public function validate($form, $data, $group = null)
	{
		// Filter and validate the form data.
		//$data = $form->filter($data);
		$return = $form->validate($data, $group);

		// Check for an error.
		if ($return instanceof Exception)
		{
			$this->setError($return->getMessage());
			return false;
		}

		// Check the validation results.
		if ($return === false)
		{
			// Get the validation messages from the form.
			foreach ($form->getErrors() as $message)
			{
				$this->setError(JText::_($message));
			}

			return false;
		}

		return $data;
	}
}
