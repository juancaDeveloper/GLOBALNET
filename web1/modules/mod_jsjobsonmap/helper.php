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
class modJSJobsOnMapHelper{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getData($params){
        $result['noofjobs'] = $params->get('noofjobs', 20);
        $result['category'] = $params->get('category', 1);
        $result['company'] = $params->get('company', 1);
        $result['zoom'] = $params->get('zoom', 10);
        $result['posteddate'] = $params->get('posteddate', 1);
        $result['moduleheight'] = $params->get('moduleheight', '400') . 'px';
        $result['title'] = $params->get('title');
        $result['showtitle'] = $params->get('showtitle');

        /** scs */
        if($params->get('Itemid')) $result['itemid'] = $params->get('Itemid');			
        else $result['itemid'] =  JRequest::getVar('Itemid');

        $lang = JFactory::getLanguage();
        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        
        $componentPath =  'components/com_jsjobs/';
        require_once $componentPath.'JSApplication.php';
        $jobresult = JSModel::getJSModel('job')->getNewestJobsForMap($result['noofjobs']);

        $result['jobs'] = $jobresult[0];
        $result['dateformat'] = $jobresult[2];
        $result['data_directory'] = $jobresult[3];
        $result['config'] = $jobresult[4];

        return $result;
    }
}