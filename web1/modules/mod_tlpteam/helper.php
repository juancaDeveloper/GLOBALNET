<?php
/**
 * @version     1.1
 * @package     com_tlpteam
 * @subpackage  mod_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
defined('_JEXEC') or die;

/**
 * Helper for mod_tlpteam
 *
 * @package     com_tlpteam
 * @subpackage  mod_tlpteam
 */
class ModTlpteamHelper {

    /**
     * Retrieve component items
     * @param Joomla\Registry\Registry  &$params  module parameters
     * @return array Array with all the elements
     */
    public static function getLists(&$params) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $category1 = $params->get('category');

        if(!is_array($category1)){
            $category1=array($category1);
        }
        $category = implode(",", $category1);

        $memberID    =  $params->get("member");

        if(!is_array($memberID)){
            $memberID=array($memberID);
        }
        $member = implode(",", $memberID);

        $tlporderby  =  $params->get("mod_orderby",'ordering');
        $tlporder    =  $params->get("mod_order",'asc');

        $multilang = JLanguageMultilang::isEnabled();

        $query
                ->select('a.*,s1.title as skill1,s2.title as skill2,s3.title as skill3,s4.title as skill4,s5.title as skill5')
                ->from('#__tlpteam_team a');

        if($category){
            $query->where("a.state = 1 AND a.department IN($category)");
        }else{
            $query->where('a.state = 1');
        }
        if($member){
            $query->where("a.id IN ($member)");
        }
        // Filter by language
        if ($multilang)
        {
            $query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
        }
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

        $db->setQuery($query, 0, $params->get('mod_membercount'));
        $rows = $db->loadObjectList();
        return $rows;
    }
    
}
