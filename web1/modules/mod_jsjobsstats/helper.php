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
class modJSJobsStatsHelper{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getData($params, $module = array()){
        $result = array();
        $result['jsjobs_display_style'] = 1;
        if(!empty($module) && isset($module->jsjobs_display_style) && $module->jsjobs_display_style != ''){
            $result['jsjobs_display_style'] = $module->jsjobs_display_style;
        }
        $result['title'] = $params->get('title');
        $result['shtitle'] = $params->get('shtitle');
        $result['employer'] = $params->get('employer',1);
        $result['jobseeker'] = $params->get('jobseeker',1);
        $result['jobs'] = $params->get('jobs',1);
        $result['companies'] = $params->get('companies',1);
        $result['activejobs'] = $params->get('activejobs',1);
        $result['resumes'] = $params->get('resumes',1);
        $result['todaystats'] = $params->get('todaystats');
        $result['title'] = $params->get('title');
        $result['showtitle'] = $params->get('showtitle');
        $result['sliding'] = $params->get('sliding', '0');
        $result['consecutivesliding'] = $params->get('consecutivesliding', '0');
        $result['slidingdirection'] = $params->get('slidingdirection', '1'); // 0 = left  , 1=up
        $result['noofcols'] = 1;
        $result['separator'] = $params->get('separator');
        $result['colwidth'] = round(100 / $result['noofcols']);
        $result['itemid'] = JRequest::getVar('Itemid');
        $result['curdate'] = date('Y-m-d H:i:s');
        $color = array();
        $color[1] = $params->get('color1');
        $color[2] = $params->get('color2');
        $color[4] = $params->get('color4');
        $result['color'] = $color;

        /** scs */
        if($params->get('Itemid')) $result['itemid'] = $params->get('Itemid');			
        else $result['itemid'] =  JRequest::getVar('Itemid');

        $lang = JFactory::getLanguage();
        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        
        $componentPath =  'components/com_jsjobs/';
        require_once $componentPath.'JSApplication.php';
        //sce
        
	   $result['stats'] = JSModel::getJSModel('common')->mpGetstats($result['employer'],$result['jobseeker'],$result['jobs'],$result['companies'],$result['activejobs'],$result['resumes']);
        
        return $result;
    }
}