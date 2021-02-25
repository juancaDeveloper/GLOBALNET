<?php
/**
 * @version     2.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Tlpteam records.
 */
class TlpteamModelTeams extends JModelList
{

	/**
	 * Constructor.
	 *
	 * @param    array    An optional associative array of configuration settings.
	 *
	 * @see        JController
	 * @since      1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				                'id', 'a.id',
                'department', 'a.department',
                'name', 'a.name',
                'alias', 'a.alias',
                'position', 'a.position',
                'email', 'a.email',
                'phoneno', 'a.phoneno',
                'personal_website', 'a.personal_website',
                'location', 'a.location',
                'profile_image', 'a.profile_image',
                'short_bio', 'a.short_bio',
                'detail_bio', 'a.detail_bio',
                'facebook', 'a.facebook',
                'twitter', 'a.twitter',
                'linkedin', 'a.linkedin',
                'google_plus', 'a.google_plus',
                'youtube', 'a.youtube',
                'vimeo', 'a.vimeo',
                'instagram', 'a.instagram',
                'skill1', 'a.skill1',
                'skill1_no', 'a.skill1_no',
                'skill2', 'a.skill2',
                'skill2_no', 'a.skill2_no',
                'skill3', 'a.skill3',
                'skill3_no', 'a.skill3_no',
                'skill4', 'a.skill4',
                'skill4_no', 'a.skill4_no',
                'skill5', 'a.skill5',
                'skill5_no', 'a.skill5_no',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'language', 'a.language',
                'access', 'a.access',

			);
		}
		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since    1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{


		// Initialise variables.
		$app = JFactory::getApplication();

		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'));
		$this->setState('list.limit', $limit);

		$limitstart = $app->input->getInt('limitstart', 0);
		$this->setState('list.start', $limitstart);

		if ($list = $app->getUserStateFromRequest($this->context . '.list', 'list', array(), 'array'))
		{
			foreach ($list as $name => $value)
			{
				// Extra validations
				switch ($name)
				{
					case 'fullordering':
						$orderingParts = explode(' ', $value);

						if (count($orderingParts) >= 2)
						{
							// Latest part will be considered the direction
							$fullDirection = end($orderingParts);

							if (in_array(strtoupper($fullDirection), array('ASC', 'DESC', '')))
							{
								$this->setState('list.direction', $fullDirection);
							}

							unset($orderingParts[count($orderingParts) - 1]);

							// The rest will be the ordering
							$fullOrdering = implode(' ', $orderingParts);

							if (in_array($fullOrdering, $this->filter_fields))
							{
								$this->setState('list.ordering', $fullOrdering);
							}
						}
						else
						{
							$this->setState('list.ordering', $ordering);
							$this->setState('list.direction', $direction);
						}
						break;

					case 'ordering':
						if (!in_array($value, $this->filter_fields))
						{
							$value = $ordering;
						}
						break;

					case 'direction':
						if (!in_array(strtoupper($value), array('ASC', 'DESC', '')))
						{
							$value = $direction;
						}
						break;

					case 'limit':
						$limit = $value;
						break;

					// Just to keep the default case
					default:
						$value = $value;
						break;
				}

				$this->setState('list.' . $name, $value);
			}
		}

		// Receive & set filters
		if ($filters = $app->getUserStateFromRequest($this->context . '.filter', 'filter', array(), 'array'))
		{
			foreach ($filters as $name => $value)
			{
				$this->setState('filter.' . $name, $value);
			}
		}

		$ordering = $app->input->get('filter_order');
		if (!empty($ordering))
		{
			$list             = $app->getUserState($this->context . '.list');
			$list['ordering'] = $app->input->get('filter_order');
			$app->setUserState($this->context . '.list', $list);
		}

		$orderingDirection = $app->input->get('filter_order_Dir');
		if (!empty($orderingDirection))
		{
			$list              = $app->getUserState($this->context . '.list');
			$list['direction'] = $app->input->get('filter_order_Dir');
			$app->setUserState($this->context . '.list', $list);
		}

		$list = $app->getUserState($this->context . '.list');

		if (empty($list['ordering']))
{
	$list['ordering'] = 'ordering';
}

if (empty($list['direction']))
{
	$list['direction'] = 'asc';
}

		if (isset($list['ordering'])) {
                    $this->setState('list.ordering', $list['ordering']);
                }
                if (isset($list['direction'])) {
                    $this->setState('list.direction', $list['direction']);
                }
                
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return    JDatabaseQuery
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;

		$menuparams  = 	$menu->getParams($itemId);
		$department1 = 	$menuparams->get("category");

		if(!is_array($department1)){
            $department1=array($department1);
        }
        $department = implode(",", $department1);

		$memberID 	 = 	$menuparams->get("member");

		if(!is_array($memberID)){
            $memberID=array($memberID);
        }
        $member = implode(",", $memberID);

		$tlporderby	 = 	$menuparams->get("m_orderby",'ordering');
		$tlporder 	 = 	$menuparams->get("m_order",'asc');

		JFactory::getLanguage()->getTag();

	 	$multilang=JLanguageMultilang::isEnabled();
	
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query
			->select(
				$this->getState(
					'list.select', 'DISTINCT a.*'
				)
			);

		$query->from('`#__tlpteam_team` AS a');

		
	    // Join over the users for the checked out user.
	    $query->select('uc.name AS editor');
	    $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		// Join over the category 'department'
		$query->select('department.title AS department_title');
		$query->join('LEFT', '#__categories AS department ON department.id = a.department');
		// Join over the category 'id'
		$query->select('departmentid.id AS department_id');
		$query->join('LEFT', '#__categories AS departmentid ON departmentid.id = a.department');
		// Join over the foreign key 'skill1'
		$query->select('#__tlpteam_skills_1.title AS skills_title_1');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_1 ON #__tlpteam_skills_1.id = a.skill1');
		// Join over the foreign key 'skill2'
		$query->select('#__tlpteam_skills_2.title AS skills_title_2');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_2 ON #__tlpteam_skills_2.id = a.skill2');
		// Join over the foreign key 'skill3'
		$query->select('#__tlpteam_skills_3.title AS skills_title_3');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_3 ON #__tlpteam_skills_3.id = a.skill3');
		// Join over the foreign key 'skill4'
		$query->select('#__tlpteam_skills_4.title AS skills_title_4');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_4 ON #__tlpteam_skills_4.id = a.skill4');
		// Join over the foreign key 'skill5'
		$query->select('#__tlpteam_skills_5.title AS skills_title_5');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_5 ON #__tlpteam_skills_5.id = a.skill5');
		// Join over the created by field 'created_by'
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		if($department){
			$query->where("a.department IN ($department)");
		}
		if($member){
			$query->where("a.id IN ($member)");
		}

	// Filter by language
		if ($multilang)
		{
			$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		}

		if (!JFactory::getUser()->authorise('core.edit.state', 'com_tlpteam'))
		{
			$query->where('a.state = 1');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('( a.name LIKE '.$search.'  OR  a.position LIKE '.$search.' )');
			}
		}

		//Filtering access
		$filter_access = $this->state->get("filter.access");
		if ($filter_access) {
			$query->where("a.access = '".$db->escape($filter_access)."'");
		}

		// Add the list ordering clause.
		// $orderCol  = $this->state->get('list.ordering');
		// $orderDirn = $this->state->get('list.direction');
		// if ($orderCol && $orderDirn)
		// {
		// 	$query->order($db->escape($orderCol . ' ' . $orderDirn));
		// }
		if($tlporderby=='rand'){
            $query->order('RAND()');
        }else{  
            $query->order("a.$tlporderby $tlporder");
        }

//echo $query;

		return $query;
	}

	public function getItems()
	{
		$items = parent::getItems();


		foreach($items as $item){
	

			if ( isset($item->department) ) {

				// Get the title of that particular template
					$title = TlpteamFrontendHelper::getCategoryNameByCategoryId($item->department);

					// Finally replace the data object with proper information
					$item->department = !empty($title) ? $title : $item->department;
				}

			if (isset($item->skill1) && $item->skill1 != '') {
				if(is_object($item->skill1)){
					$item->skill1 = JArrayHelper::fromObject($item->skill1);
				}
				$values = (is_array($item->skill1)) ? $item->skill1 : explode(',',$item->skill1);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$item->skill1 = !empty($textValue) ? implode(', ', $textValue) : $item->skill1;

			}

			if (isset($item->skill2) && $item->skill2 != '') {
				if(is_object($item->skill2)){
					$item->skill2 = JArrayHelper::fromObject($item->skill2);
				}
				$values = (is_array($item->skill2)) ? $item->skill2 : explode(',',$item->skill2);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$item->skill2 = !empty($textValue) ? implode(', ', $textValue) : $item->skill2;

			}

			if (isset($item->skill3) && $item->skill3 != '') {
				if(is_object($item->skill3)){
					$item->skill3 = JArrayHelper::fromObject($item->skill3);
				}
				$values = (is_array($item->skill3)) ? $item->skill3 : explode(',',$item->skill3);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$item->skill3 = !empty($textValue) ? implode(', ', $textValue) : $item->skill3;

			}

			if (isset($item->skill4) && $item->skill4 != '') {
				if(is_object($item->skill4)){
					$item->skill4 = JArrayHelper::fromObject($item->skill4);
				}
				$values = (is_array($item->skill4)) ? $item->skill4 : explode(',',$item->skill4);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$item->skill4 = !empty($textValue) ? implode(', ', $textValue) : $item->skill4;

			}

			if (isset($item->skill5) && $item->skill5 != '') {
				if(is_object($item->skill5)){
					$item->skill5 = JArrayHelper::fromObject($item->skill5);
				}
				$values = (is_array($item->skill5)) ? $item->skill5 : explode(',',$item->skill5);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = ' . $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$item->skill5 = !empty($textValue) ? implode(', ', $textValue) : $item->skill5;

			}
}

		return $items;
	}

	public function getTotal(){
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;

//
		// $input = JFactory::getApplication()->input;
		// $menuitemid = $input->getInt( 'Itemid' );
		// @$menu = JSite::getMenu();
		$menuparams = $menu->getParams($itemId);
		$department1 = $menuparams->get("category");
		@$department = implode(",", $department1);

		JFactory::getLanguage()->getTag();

	 	$multilang=JLanguageMultilang::isEnabled();
	
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query
			->select(
				$this->getState(
					'list.select', 'DISTINCT a.*'
				)
			);

		$query->from('`#__tlpteam_team` AS a');

		
	    // Join over the users for the checked out user.
	    $query->select('uc.name AS editor');
	    $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
    
		

		if($department>0){
			$query->where("a.department IN ($department)");
		}

	// Filter by language
		if ($multilang)
		{
			$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		}

		$query->where('a.state = 1');

		$db->setQuery($query);
		$rows=$db->loadobjectlist();

		return count($rows);

	}

	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 */
	protected function loadFormData()
	{
		$app              = JFactory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;
		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && !$this->isValidDate($value))
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}
		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_TLPTEAM_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	/**
	 * Checks if a given date is valid and in an specified format (YYYY-MM-DD)
	 *
	 * @param string Contains the date to be checked
	 *
	 */
	private function isValidDate($date)
	{
		return preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $date) && date_create($date);
	}

}
