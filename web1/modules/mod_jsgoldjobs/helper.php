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
class modJSGoldJobsHelper{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getData($params){
        $result['noofjobs'] = $params->get('noofjobs', 7);
        $result['category'] = $params->get('category', 1);
        $result['subcategory'] = $params->get('subcategory', 1);
        $result['company'] = $params->get('company', 1);
        $result['jobtype'] = $params->get('jobtype', 1);
        $result['posteddate'] = $params->get('posteddate', 1);
        $result['theme'] = $params->get('theme', 1);
        $result['separator'] = $params->get('separator', 1);
        $result['moduleheight'] = $params->get('moduleheight','400').'px';
        $result['jobsinrow'] = $params->get('jobsinrow',1);
        $result['jobsinrowtab'] = $params->get('jobsinrowtab',1);
        $result['jobfloat'] = $params->get('jobfloat',0);
        $result['location'] = $params->get('location',1);
        $result['jobmargintop'] = $params->get('jobmargintop','10').'px';
        $result['jobmarginleft'] = $params->get('jobmarginleft','10').'px';
        $result['companylogo'] = $params->get('companylogo',1);
        $result['logodatarow'] = $params->get('logodatarow',2);
        $result['datacolumn'] = $params->get('datacolumn',1);
        if($result['datacolumn'] == 0) $result['datacolumn'] = 1;
        $result['listtype'] = $params->get('listtype','1');
        $result['jobheight'] = $params->get('jobheight','200');
        $result['companylogowidth'] = $params->get('companylogowidth','150');
        $result['companylogoheight'] = $params->get('companylogoheight','90');
        $result['moduleclass_sfx'] = $params->get('moduleclass_sfx');

        $color = array();
        $color[1] = $params->get('color1');
        $color[2] = $params->get('color2');
        $color[3] = $params->get('color3');
        $color[4] = $params->get('color4');
        $color[5] = $params->get('color5');
        $color[6] = $params->get('color6');
        $result['color'] = $color;

        $result['title'] = $params->get('title');
        $result['showtitle'] = $params->get('showtitle');
        $result['speedTest'] = $params->get('speed',5);
        /** scs */
        if($params->get('Itemid')) $result['itemid'] = $params->get('Itemid');          
        else $result['itemid'] =  JRequest::getVar('Itemid');

        $lang = JFactory::getLanguage();
        $dump = $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        $componentPath =  'components/com_jsjobs/';
        require_once $componentPath.'JSApplication.php';
        //scs
        $result['sliding'] = $params->get('sliding','0');
        $result['consecutivesliding'] = $params->get('consecutivesliding','0');
        $result['slidingdirection'] = $params->get('slidingdirection','1'); // 0 = left  , 1=up
        //sce
        $jobresult = JSModel::getJSModel('job')->getGoldJobs($result['noofjobs'], $result['theme']);
        $result['jobs'] = $jobresult[0];
        $result['dateformat'] = $jobresult[2];
        $result['data_directory'] = $jobresult[3];

        return $result;
    }
}