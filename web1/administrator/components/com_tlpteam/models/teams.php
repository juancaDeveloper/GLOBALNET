<?php

/**
 * @version     1.1
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
class TlpteamModelTeams extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.`id`',
                'department', 'a.`department`',
                'name', 'a.`name`',
                'alias', 'a.`alias`',
                'position', 'a.`position`',
                'email', 'a.`email`',
                'phoneno', 'a.`phoneno`',
                'personal_website', 'a.`personal_website`',
                'location', 'a.`location`',
                'profile_image', 'a.`profile_image`',
                'short_bio', 'a.`short_bio`',
                'detail_bio', 'a.`detail_bio`',
                'facebook', 'a.`facebook`',
                'twitter', 'a.`twitter`',
                'linkedin', 'a.`linkedin`',
                'google_plus', 'a.`google_plus`',
                'youtube', 'a.`youtube`',
                'vimeo', 'a.`vimeo`',
                'instagram', 'a.`instagram`',
                'skill1', 'a.`skill1`',
                'skill1_no', 'a.`skill1_no`',
                'skill2', 'a.`skill2`',
                'skill2_no', 'a.`skill2_no`',
                'skill3', 'a.`skill3`',
                'skill3_no', 'a.`skill3_no`',
                'skill4', 'a.`skill4`',
                'skill4_no', 'a.`skill4_no`',
                'skill5', 'a.`skill5`',
                'skill5_no', 'a.`skill5_no`',
                'ordering', 'a.`ordering`',
                'state', 'a.`state`',
                'created_by', 'a.`created_by`',
                'language', 'a.`language`',
                'access', 'a.`access`',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering department
		$this->setState('filter.department', $app->getUserStateFromRequest($this->context.'.filter.department', 'filter_department', '', 'string'));

		//Filtering language
		//Language filters for all languages is a * make it empty
		if (JFactory::getApplication()->input->getVar('filter_language') == '*') {
			JFactory::getApplication()->input->set('filter_language', '');
		}
		$this->setState('filter.language', $app->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '', 'string'));

		//Filtering access
		$this->setState('filter.access', $app->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_tlpteam');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.name', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->from('`#__tlpteam_team` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the category 'department'
		//$query->select('`department`.title AS `department`');
		//$query->join('LEFT', '#__categories AS `department` ON `department`.id = a.`department`');
		// Join over the foreign key 'skill1'
		$query->select('#__tlpteam_skills_1997896.`title` AS skills_title_1997896');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_1997896 ON #__tlpteam_skills_1997896.`id` = a.`skill1`');
		// Join over the foreign key 'skill2'
		$query->select('#__tlpteam_skills_1997921.`title` AS skills_title_1997921');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_1997921 ON #__tlpteam_skills_1997921.`id` = a.`skill2`');
		// Join over the foreign key 'skill3'
		$query->select('#__tlpteam_skills_1997926.`title` AS skills_title_1997926');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_1997926 ON #__tlpteam_skills_1997926.`id` = a.`skill3`');
		// Join over the foreign key 'skill4'
		$query->select('#__tlpteam_skills_1997932.`title` AS skills_title_1997932');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_1997932 ON #__tlpteam_skills_1997932.`id` = a.`skill4`');
		// Join over the foreign key 'skill5'
		$query->select('#__tlpteam_skills_1997940.`title` AS skills_title_1997940');
		$query->join('LEFT', '#__tlpteam_skills AS #__tlpteam_skills_1997940 ON #__tlpteam_skills_1997940.`id` = a.`skill5`');
		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');
		// Join over the access level field 'access'
		$query->select('`access`.title AS `access`');
		$query->join('LEFT', '#__viewlevels AS access ON `access`.id = a.`access`');

        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.`name` LIKE '.$search.'  OR  a.`position` LIKE '.$search.' )');
            }
        }

        

		//Filtering department
		$filter_department = $this->state->get("filter.department");
		if ($filter_department) {
			$query->where("a.`department` = '".$db->escape($filter_department)."'");
		}

		//Filtering language
		$filter_language = $this->state->get("filter.language");
		if ($filter_language) {
			$query->where("a.`language` = '".$db->escape($filter_language)."'");
		}

		//Filtering access
		$filter_access = $this->state->get("filter.access");
		if ($filter_access) {
			$query->where("a.`access` = '".$db->escape($filter_access)."'");
		}


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }
//echo $query;
        return $query;
    }

    public function getItems() {
        $items = parent::getItems();

        foreach ($items as $oneItem) {

        	if (isset($oneItem->department)) {
        		$values = explode(',', $oneItem->department);
        		
        		$textValue = array();
        		foreach ($values as $value){
        			$db = JFactory::getDbo();
        			$query = $db->getQuery(true);
        			$query
        					->select($db->quoteName('title'))
        					->from('`#__categories`')
        					->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)) );
        			$db->setQuery($query);
        			$results = $db->loadObject();
        			if ($results) {
        				$textValue[] = $results->title;
        			}
        		}

        	$oneItem->department = !empty($textValue) ? implode(', ', $textValue) : $oneItem->department;

        	}
        }

		foreach ($items as $oneItem) {

			if (isset($oneItem->skill1)) {
				$values = explode(',', $oneItem->skill1);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$oneItem->skill1 = !empty($textValue) ? implode(', ', $textValue) : $oneItem->skill1;

			}

			if (isset($oneItem->skill2)) {
				$values = explode(',', $oneItem->skill2);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$oneItem->skill2 = !empty($textValue) ? implode(', ', $textValue) : $oneItem->skill2;

			}

			if (isset($oneItem->skill3)) {
				$values = explode(',', $oneItem->skill3);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$oneItem->skill3 = !empty($textValue) ? implode(', ', $textValue) : $oneItem->skill3;

			}

			if (isset($oneItem->skill4)) {
				$values = explode(',', $oneItem->skill4);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$oneItem->skill4 = !empty($textValue) ? implode(', ', $textValue) : $oneItem->skill4;

			}

			if (isset($oneItem->skill5)) {
				$values = explode(',', $oneItem->skill5);

				$textValue = array();
				foreach ($values as $value){
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
							->select($db->quoteName('title'))
							->from('`#__tlpteam_skills`')
							->where($db->quoteName('id') . ' = '. $db->quote($db->escape($value)));
					$db->setQuery($query);
					$results = $db->loadObject();
					if ($results) {
						$textValue[] = $results->title;
					}
				}

			$oneItem->skill5 = !empty($textValue) ? implode(', ', $textValue) : $oneItem->skill5;

			}
		}
        return $items;
    }

}
