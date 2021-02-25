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
class modJSFeaturedResumeHelper{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getData($params){
        $result['logodatarow'] = $params->get('logodatarow',2);
        $result['noofresumes'] = $params->get('noofresumes', 7);
        $result['applicationtitle'] = $params->get('applicationtitle', 1);
        $result['name'] = $params->get('name', 1);
        $result['experience'] = $params->get('experience', 1);
        $result['available'] = $params->get('available', 1);
        $result['gender'] = $params->get('gender', 1);
        $result['nationality'] = $params->get('nationality', 1);
        $result['location'] = $params->get('location', 1);
        $result['category'] = $params->get('category', 1);
        $result['subcategory'] = $params->get('subcategory', 1);
        $result['workpreference'] = $params->get('workpreference', 1);
        $result['resumephoto'] = $params->get('resumephoto', 1);
        $result['posteddate'] = $params->get('posteddate', 1);
        $result['separator'] = $params->get('separator', 1);
        $result['resumesinrow'] = $params->get('resumesinrow',1);
        $result['resumesinrowtab'] = $params->get('resumesinrowtab',1);
        $result['moduleheight'] = $params->get('moduleheight', '400') . 'px';
        $result['resumeheight'] = $params->get('resumeheight', '200') . 'px';
        $result['resumemargintop'] = $params->get('resumemargintop', '10') . 'px';
        $result['resumemarginleft'] = $params->get('resumemarginleft', '10') . 'px';
        $result['photowidth'] = $params->get('photowidth', '200') . 'px';
        $result['photoheight'] = $params->get('photoheight', '50') . 'px';
        $result['datacolumn'] = $params->get('datacolumn', '2');
        if($result['datacolumn'] == 0) $result['datacolumn'] = 1;
        $result['listtype'] = $params->get('listtype', '1');
        $result['title'] = $params->get('title');
        $result['showtitle'] = $params->get('showtitle');
        $result['speedTest'] = $params->get('speed', 5);
        $result['moduleclass_sfx'] = $params->get('moduleclass_sfx', '');
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
        $resumeresult = JSModel::getJSModel('resume')->getFeaturedResumes($result['noofresumes'], true);
        $result['resumes'] = $resumeresult[0];
        $result['dateformat'] = $resumeresult[2];
        $result['data_directory'] = $resumeresult[3];

        return $result;
    }
}