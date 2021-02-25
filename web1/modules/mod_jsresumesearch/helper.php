<?php
/**
 + Created by:  Ahmad Bilal
 * Company:     Buruj Solutions
 + Contact:     www.burujsolutions.com , info@burujsolutions.com
                www.joomsky.com, ahmad@joomsky.com
 * Created on:  Dec 2, 2009
 ^
 + Project:         JS Jobs 
 * File Name:   module/hotjsjobs.php
 ^ 
 * Description: Module for JS Jobs
 ^ 
 * History:     1.0.2 - Nov 27, 2010
 ^ 
 */
class modJSResumeSearchHelper{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getData($params){
        $result['sh_title'] = $params->get('apptitle', 1);
        $result['sh_name'] = $params->get('name', 1);
        $result['sh_nationality'] = $params->get('natinality', 1);
        $result['sh_gender'] = $params->get('gender', 1);
        $result['sh_iamavailable'] = $params->get('iamavailable', 1);
        $result['sh_category'] = $params->get('category', 1);
        $result['sh_subcategory'] = $params->get('subcategory', 1);
        $result['sh_jobtype'] = $params->get('jobtype', 1);
        $result['sh_salaryrange'] = $params->get('salaryrange', 1);
        $result['sh_heighesteducation'] = $params->get('heighesteducation', 1);
        $result['sh_experience'] = $params->get('experience', 1);
        $result['colperrow'] = $params->get('colperrow', 3);
        $result['title'] = $params->get('title');
        $result['showtitle'] = $params->get('showtitle');
        $result['colwidth'] = Round(100 / $result['colperrow'], 1);
        $result['colwidth'] = $result['colwidth'] . '%';
        $result['colcount'] = 1;
        /** scs */
        if($params->get('Itemid')) $result['itemid'] = $params->get('Itemid');          
        else $result['itemid'] =  JRequest::getVar('Itemid');

        $lang = JFactory::getLanguage();
        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        
        $componentPath =  'components/com_jsjobs/';
        require_once $componentPath.'JSApplication.php';
        
        $resumeresult = JSModel::getJSModel('resume')->resumesearch($result['sh_gender'],$result['sh_nationality'],$result['sh_category'],$result['sh_subcategory'],$result['sh_jobtype'],$result['sh_heighesteducation'],$result['sh_salaryrange'],'');
        $result['gender'] = isset($resumeresult[0]) ? $resumeresult[0] : 0;
        $result['nationality'] = isset($resumeresult[1]) ? $resumeresult[1] : 0;
        $result['job_categories'] = isset($resumeresult[2]) ? $resumeresult[2] : 0;
        $result['job_type'] = isset($resumeresult[3]) ? $resumeresult[3] : 0;
        $result['heighest_finisheducation'] = isset($resumeresult[4]) ? $resumeresult[4] : 0;
        $result['salary_range'] = isset($resumeresult[5]) ? $resumeresult[5] : 0;
        $result['currency'] = isset($resumeresult[6]) ? $resumeresult[6] : 0;
        $result['job_subcategories'] = isset($resumeresult[7]) ? $resumeresult[7] : 0;
        $result['expmin'] = isset($resumeresult[8]) ? $resumeresult[8] : 0;
        $result['expmax'] = isset($resumeresult[9]) ? $resumeresult[9] : 0;
            
        return $result;
    }
}