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

jimport('joomla.application.component.modellist');

class DJTabsModelGroups extends JModelList
{
	private $_ordering = null;
	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'alias', 'a.alias',
				'ordering', 'a.ordering',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'published', 'a.published'
			);
		}

		parent::__construct($config);
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		$group = $this->getUserStateFromRequest($this->context.'.filter.group', 'filter_parent', '');
		$this->setState('filter.group', $group);
		
		// List state information.
		parent::populateState('a.ordering', 'asc');
		
		$this->setState('list.limit', 0);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.published');
		$id	.= ':'.$this->getState('filter.group');
		
		return parent::getStoreId($id);
	}
	
	protected function getListQuery()
	{
		// Create a new query object.	
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);
		$query->from('#__djtabs_groups AS a');
		
		// Join over the categories.
		$query->select('c.title AS parent_title');
		$query->join('LEFT', '#__djtabs_groups AS c ON c.id = a.parent_id');
		
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
		
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		}
		else if ($published === '') {
			$query->where('(a.published = 0 OR a.published = 1)');
		}
		
		// Filter by group state
		$group = $this->getState('filter.group');
		if (is_numeric($group)) {
			$query->where('a.parent_id = ' . (int) $group);
		}
		
		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(a.title LIKE '.$search.' OR a.alias LIKE '.$search.')');
			}
		}
		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		
		if ($orderCol == 'a.ordering' || $orderCol == 'parent_title') {
			$orderCol = 'parent_title '.$orderDirn.', a.ordering';
		}
		$query->order($db->escape($orderCol.' '.$orderDirn));
		
		return $query;
	}
	
	public function getOrdering() {
			
		if(!$this->_ordering) {
			$this->_ordering = parent::getItems();
		}
		
		return $this->_ordering;
	}
	
	public function getItems()
	{


		if(!$this->_ordering) $this->_ordering = parent::getItems();
		//print_r('$this->_ordering'); die();
		$group = $this->getState('filter.group');
		$search = $this->getState('filter.search');
		$published = $this->getState('filter.published');
		if (is_numeric($group) || !empty($search) || is_numeric($published)) {
			foreach($this->_ordering as $key => $item) {
				$item->key = $key;
			}
			
			return $this->_ordering;
			
		} else {		
			$sort_items = $this->getSortedItems($this->_ordering);
		}
		
		//$this->state->set('list.limit',count ($sort_items));
		
		return $sort_items;
	}
	
	private function getSortedItems(&$items, $parent = 0, $level = 0)
	{
		
		$groups = array();
		
		foreach($items as $key => $item) {
			
			if(isset($item->level)) {
				continue;
			}
			if($item->parent_id == $parent) {
				$item->key = $key;
				$item->level = $level;				
				$groups[] = $item;				
				$groups = array_merge($groups, $this->getSortedItems($items, $item->id, $level + 1));								
			}
			 
		}
		
		return $groups;		
	}
	
	public function getSelectOptions ($disable_default = false, $disable_self = false, $self_id = 0){
		
		//djdebug($disable_self);
		
		$this->getState('filter.search');
		$this->setState('filter.search', '');
		$this->getState('filter.published');
		$this->setState('filter.published', '');
		$this->getState('filter.group');
		$this->setState('filter.group', '');
		$this->state->set('list.ordering','a.ordering');
		$this->state->set('list.direction','asc');
		//$this->state->set('list.limit',1000);
		
		
		$options = array();
		//if(!$disable_default) $options[] = JHTML::_('select.option', '0', JText::_('COM_DJTABS_ROOT_group'),'value','text');
    	
		$items = $this->getItems();
		$level = 0;
		$disabled = false;
		if(!$self_id) $self_id = JRequest::getInt('id', null);
				
    	foreach ($items as $item) {
    		$prefix = '';
	    	for ($i = 0; $i < $item->level; $i++) {
	        	$prefix .= ' - ';
	    	}
	    	
			if($disable_self) {
				if($disabled && $item->level <= $level) {
					$disabled = false;
					$disable_self = false;
				} else if($item->id == $self_id) {
					$disabled = true;
					$level = $item->level;
				}
											
			} 
			
    		$options[] = JHTML::_('select.option', $item->id, $prefix . $item->title,'value','text', $disabled);
    	}
		
		return $options;
		
	}
	
}
