<?php
/**
 * @version     2.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

/**
 * Tlpteam model.
 */
class TlpteamModelTeam extends JModelItem
{

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since    1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('com_tlpteam');

		// Load state from the request userState on edit or from the passed variable on default
		if (JFactory::getApplication()->input->get('layout') == 'edit')
		{
			$id = JFactory::getApplication()->getUserState('com_tlpteam.edit.team.id');
		}
		else
		{
			$id = JFactory::getApplication()->input->get('id');
			JFactory::getApplication()->setUserState('com_tlpteam.edit.team.id', $id);
		}
		$this->setState('team.id', $id);

		// Load the parameters.
		$params       = $app->getParams();
		$params_array = $params->toArray();
		if (isset($params_array['item_id']))
		{
			$this->setState('team.id', $params_array['item_id']);
		}
		$this->setState('params', $params);
	}

	/**
	 * Method to get an ojbect.
	 *
	 * @param    integer    The id of the object to get.
	 *
	 * @return    mixed    Object on success, false on failure.
	 */
	public function &getData($id = null)
	{
		if ($this->_item === null)
		{
			$this->_item = false;

			if (empty($id))
			{
				$id = $this->getState('team.id');
			}

			// Get a level row instance.
			$table = $this->getTable();

			// Attempt to load the row.
			if ($table->load($id))
			{
				// Check published state.
				if ($published = $this->getState('filter.published'))
				{
					if ($table->state != $published)
					{
						return $this->_item;
					}
				}

				// Convert the JTable to a clean JObject.
				$properties  = $table->getProperties(1);
				$this->_item = JArrayHelper::toObject($properties, 'JObject');
			}
			elseif ($error = $table->getError())
			{
				$this->setError($error);
			}
		}

		

			if (isset($this->_item->skill1) && $this->_item->skill1 != '') {
				if(is_object($this->_item->skill1)){
					$this->_item->skill1 = JArrayHelper::fromObject($this->_item->skill1);
				}
				$values = (is_array($this->_item->skill1)) ? $this->_item->skill1 : explode(',',$this->_item->skill1);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title')
							->from('`#__tlpteam_skills`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$this->_item->skill1 = !empty($textValue) ? implode(', ', $textValue) : $this->_item->skill1;

			}

			if (isset($this->_item->skill2) && $this->_item->skill2 != '') {
				if(is_object($this->_item->skill2)){
					$this->_item->skill2 = JArrayHelper::fromObject($this->_item->skill2);
				}
				$values = (is_array($this->_item->skill2)) ? $this->_item->skill2 : explode(',',$this->_item->skill2);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title')
							->from('`#__tlpteam_skills`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$this->_item->skill2 = !empty($textValue) ? implode(', ', $textValue) : $this->_item->skill2;

			}

			if (isset($this->_item->skill3) && $this->_item->skill3 != '') {
				if(is_object($this->_item->skill3)){
					$this->_item->skill3 = JArrayHelper::fromObject($this->_item->skill3);
				}
				$values = (is_array($this->_item->skill3)) ? $this->_item->skill3 : explode(',',$this->_item->skill3);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title')
							->from('`#__tlpteam_skills`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$this->_item->skill3 = !empty($textValue) ? implode(', ', $textValue) : $this->_item->skill3;

			}

			if (isset($this->_item->skill4) && $this->_item->skill4 != '') {
				if(is_object($this->_item->skill4)){
					$this->_item->skill4 = JArrayHelper::fromObject($this->_item->skill4);
				}
				$values = (is_array($this->_item->skill4)) ? $this->_item->skill4 : explode(',',$this->_item->skill4);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title')
							->from('`#__tlpteam_skills`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$this->_item->skill4 = !empty($textValue) ? implode(', ', $textValue) : $this->_item->skill4;

			}

			if (isset($this->_item->skill5) && $this->_item->skill5 != '') {
				if(is_object($this->_item->skill5)){
					$this->_item->skill5 = JArrayHelper::fromObject($this->_item->skill5);
				}
				$values = (is_array($this->_item->skill5)) ? $this->_item->skill5 : explode(',',$this->_item->skill5);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select('title')
							->from('`#__tlpteam_skills`')
							->where('id = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$this->_item->skill5 = !empty($textValue) ? implode(', ', $textValue) : $this->_item->skill5;

			}
		if ( isset($this->_item->created_by) ) {
			$this->_item->created_by_name = JFactory::getUser($this->_item->created_by)->name;
		}

		return $this->_item;
	}

	public function getTable($type = 'Team', $prefix = 'TlpteamTable', $config = array())
	{
		$this->addTablePath(JPATH_ADMINISTRATOR . '/components/com_tlpteam/tables');

		return JTable::getInstance($type, $prefix, $config);
	}

	public function getItemIdByAlias($alias)
	{
		$table = $this->getTable();

		$table->load(array('alias' => $alias));

		return $table->id;
	}

	/**
	 * Method to check in an item.
	 *
	 * @param    integer        The id of the row to check out.
	 *
	 * @return    boolean        True on success, false on failure.
	 * @since    1.6
	 */
	public function checkin($id = null)
	{
		// Get the id.
		$id = (!empty($id)) ? $id : (int) $this->getState('team.id');

		if ($id)
		{

			// Initialise the table
			$table = $this->getTable();

			// Attempt to check the row in.
			if (method_exists($table, 'checkin'))
			{
				if (!$table->checkin($id))
				{
					$this->setError($table->getError());

					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Method to check out an item for editing.
	 *
	 * @param    integer        The id of the row to check out.
	 *
	 * @return    boolean        True on success, false on failure.
	 * @since    1.6
	 */
	public function checkout($id = null)
	{
		// Get the user id.
		$id = (!empty($id)) ? $id : (int) $this->getState('team.id');

		if ($id)
		{

			// Initialise the table
			$table = $this->getTable();

			// Get the current user object.
			$user = JFactory::getUser();

			// Attempt to check the row out.
			if (method_exists($table, 'checkout'))
			{
				if (!$table->checkout($user->get('id'), $id))
				{
					$this->setError($table->getError());

					return false;
				}
			}
		}

		return true;
	}

	public function getCategoryName($id)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('title')
			->from('#__categories')
			->where('id = ' . $id);
		$db->setQuery($query);

		return $db->loadObject();
	}

	public function publish($id, $state)
	{
		$table = $this->getTable();
		$table->load($id);
		$table->state = $state;

		return $table->store();
	}

	public function delete($id)
	{
		$table = $this->getTable();

		return $table->delete($id);
	}

	public function getAliasFieldNameByView($view)
	{
		switch ($view)
		{
			case 'team':
			case 'teamform':
				return 'alias';
			break;
		}
	}
}

