<?php
/**
 * @version     2.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
defined('_JEXEC') or die;

class TlpteamFrontendHelper
{
	
	/**
	* Get category name using category ID
	* @param integer $category_id Category ID
	* @return mixed category name if the category was found, null otherwise
	*/
	public static function getCategoryNameByCategoryId($category_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select('title')
			->from('#__categories')
			->where('id = ' . intval($category_id));

		$db->setQuery($query);
		return $db->loadResult();
	}


	public static function getCategoryName($category_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		JFactory::getLanguage()->getTag();
	 	$multilang=JLanguageMultilang::isEnabled();
	 
		@$department = implode(",", $category_id);

		$query->select('a.id,a.title,a.lft');
		$query->from('#__categories a');
		$query->where('extension = "com_tlpteam"');
		$query->where('a.published = 1');
		// Filter by language
		if ($multilang)
		{
			$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		}
		if($department>0){
			$query->where("a.id IN ($department)");
		}
		$query->order('a.lft');
		//echo $query;
		$db->setQuery($query);
		return $db->loadobjectlist();
	}

	public static function getAllMembers($category_id) {
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;

		$menuparams  = 	$menu->getParams($itemId);

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	
		if(!is_array($category_id)){
            $category_id=array($category_id);
        }
        $department = implode(",", $category_id);

		$memberID 	 = 	$menuparams->get("member");

		if(!is_array($memberID)){
            $memberID=array($memberID);
        }
        $member = implode(",", $memberID);

		$tlporderby	 = 	$menuparams->get("m_orderby",'ordering');
		$tlporder 	 = 	$menuparams->get("m_order",'asc');

		$multilang=JLanguageMultilang::isEnabled();
		$query
                ->select('a.*,s1.title as skill1,s2.title as skill2,s3.title as skill3,s4.title as skill4,s5.title as skill5')
                ->from('#__tlpteam_team a');
        
            $query->where('a.state = 1');

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
        //$query->order('a.ordering ASC');
        if($tlporderby=='rand'){
            $query->order('RAND()');
        }else{  
            $query->order("a.$tlporderby $tlporder");
        }

        $query->join('LEFT', '#__tlpteam_skills AS s1 ON s1.id = a.skill1');
        $query->join('LEFT', '#__tlpteam_skills AS s2 ON s2.id = a.skill2');
        $query->join('LEFT', '#__tlpteam_skills AS s3 ON s3.id = a.skill3');
        $query->join('LEFT', '#__tlpteam_skills AS s4 ON s4.id = a.skill4');
        $query->join('LEFT', '#__tlpteam_skills AS s5 ON s5.id = a.skill5');
		
		$db->setQuery($query);
		$rows=$db->loadobjectlist();

	

		return $rows;
	}

	public static function getAllMembersCount($category_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	
		@$department = implode(",", $category_id);
		$query
             	->select('a.*')
                ->from('#__tlpteam_team a');
        
        if($department>0){
            $query->where('a.state = 1 AND a.department IN ('.$department.')');
        }else{
            $query->where('a.state = 1');
        }
        $query->order('a.ordering ASC');
        //$query->where('a.state = 1 AND ');

		$db->setQuery($query);
		$rows=$db->loadobjectlist();
		//echo count($rows);
		return $rows;
	}

	/**
	 * Get an instance of the named model
	 *
	 * @param string $name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_tlpteam/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_tlpteam/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'TlpteamModel');
		}

		return $model;
	}
}
