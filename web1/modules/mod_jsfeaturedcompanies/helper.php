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
class modJSFeaturedCompaniesHelper{
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
        $result['noofcompanies'] = $params->get('noofjobs', 7);
        $result['category'] = $params->get('category', 1);
        $result['company'] = $params->get('company', 1);
        $result['posteddate'] = $params->get('posteddate', 1);
        $result['theme'] = $params->get('theme', 1);
        $result['logodatarow'] = $params->get('logodatarow',2);
        $result['location'] = $params->get('location', 1);
        $result['moduleheight'] = $params->get('moduleheight','400').'px';
        $result['jobwidth'] = ($params->get('jobwidth','200') - 20).'px';
        $result['jobheight'] = $params->get('jobheight','200').'px';
        $result['jobfloat'] = $params->get('jobfloat',0);
        $result['jobmargintop'] = $params->get('jobmargintop','10').'px';
        $result['jobmarginleft'] = $params->get('jobmarginleft','10').'px';
        $result['resumesinrow'] = $params->get('resumesinrow',1);
        $result['resumesinrowtab'] = $params->get('resumesinrowtab',1);
        $result['companylogo'] = $params->get('companylogo',1);
        $result['companylogowidth'] = $params->get('companylogowidth','200').'px';
        $result['companylogoheight'] = $params->get('companylogoheight','50').'px';
        $result['datacolumn'] = $params->get('datacolumn',1);
        if($result['datacolumn'] == 0) $result['datacolumn'] = 1;
        $result['listtype'] = $params->get('listtype','1');

        $result['title'] = $params->get('title','Popular Companies');
        $result['showtitle'] = $params->get('showtitle');
        $result['description'] = $params->get('description','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.');
        
        $result['speedTest'] = $params->get('speed',5);
        $result['moduleclass_sfx'] = $params->get('moduleclass_sfx');

        $color = array();
        $color[1] = $params->get('color1');
        $color[2] = $params->get('color2');
        $color[3] = $params->get('color3');
        $color[4] = $params->get('color4');
        $color[5] = $params->get('color5');
        $color[6] = $params->get('color6');
        $result['color'] = $color;


        /** scs */
        if($params->get('Itemid')) $result['itemid'] = $params->get('Itemid');			
        else $result['itemid'] =  JRequest::getVar('Itemid');

        $lang = JFactory::getLanguage();
        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        
        $componentPath =  'components/com_jsjobs/';
        require_once $componentPath.'JSApplication.php';
        //scs
        $result['sliding'] = $params->get('sliding','0');
        $result['consecutivesliding'] = $params->get('consecutivesliding','0');
        $result['slidingdirection'] = $params->get('slidingdirection','1'); // 0 = left  , 1=up
        //sce
        $companyresult = JSModel::getJSModel('company')->getFeaturedCompanies($result['noofcompanies'],$result['theme']);
        $result['companies'] = $companyresult[0];
        $result['dateformat'] = $companyresult[2];	
        $result['data_directory'] = $companyresult[3];

        return $result;
    }
}