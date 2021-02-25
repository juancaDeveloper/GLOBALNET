<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
				www.joomsky.com, ahmad@joomsky.com
 * Created on:	Dec 2, 2009
 ^
 + Project: 		JS Jobs 
 * File Name:	module/hotjsjobs.php
 ^ 
 * Description: Module for JS Jobs
 ^ 
 * History:		1.0.2 - Nov 27, 2010
 ^ 
 */
class modJSJobCategoriesHelper{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getData($params){
        $result['noofcategories'] = $params->get('noofcategories', 7);
        $result['jobsincategory'] = $params->get('jobsincategory', 1);
        $result['allcategories'] = $params->get('allcategories', 0);
        $result['theme'] = $params->get('theme', 1);
        $result['colperrow'] = $params->get('colperrow', 3);
        $result['sliding'] = $params->get('sliding', '1');
        $result['consecutivesliding'] = $params->get('consecutivesliding', '3');
        $result['slidingdirection'] = $params->get('slidingdirection', '1'); // 0 = left  , 1=up
        $result['slidingleftwidth'] = $params->get('slidingleftwidth', '768'); // 0 = left  , 1=up
        $result['colwidth'] = Round(100 / $result['colperrow'], 1);
        $result['colwidth'] = $result['colwidth'] . '%';
        $result['title'] = $params->get('title');
        $result['showtitle'] = $params->get('showtitle');
        $color = array();
        $color[1] = $params->get('color1');
        $color[2] = $params->get('color2');
        $color[3] = $params->get('color3');
        $result['color'] = $color;
        /** scs */
        if($params->get('Itemid')) $result['itemid'] = $params->get('Itemid');			
        else $result['itemid'] =  JRequest::getVar('Itemid');

        $lang = JFactory::getLanguage();
        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        
        $componentPath =  'components/com_jsjobs/';
        require_once $componentPath.'JSApplication.php';
        $jobresult = JSModel::getJSModel('category')->getJobCategories($result['theme']);
        $result['categories'] = $jobresult[0];
        $result['dateformat'] = $jobresult[2];	
        
        return $result;
    }
}