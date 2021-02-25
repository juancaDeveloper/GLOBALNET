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
class modJSJobsSearchHelper{
    /**
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */    
    public static function getData($params){
        $result['sh_category'] = $params->get('category', 1);
        $result['sh_subcategory'] = $params->get('subcategory', 1);
        $result['sh_jobtype'] = $params->get('jobtype', 1);
        $result['sh_jobstatus'] = $params->get('jobstatus', 1);
        $result['sh_salaryrange'] = $params->get('salaryrange', 1);
        $result['sh_shift'] = $params->get('shift', 1);
        $result['sh_durration'] = $params->get('durration', 1);
        $result['sh_startpublishing'] = $params->get('startpublishing', 1);
        $result['sh_stoppublishing'] = $params->get('stoppublishing', 1);
        $result['sh_company'] = $params->get('company', 1);
        $result['sh_addresses'] = $params->get('addresses', 1);
        $result['colperrow'] = $params->get('colperrow', 3);
        $result['colwidth'] = Round(100 / $result['colperrow'], 1);
        $result['colwidth'] = $result['colwidth'] . '%';
        $result['title'] = $params->get('title');
        $result['showtitle'] = $params->get('showtitle');
        /** scs */
        if($params->get('Itemid')) $result['itemid'] = $params->get('Itemid');			
        else $result['itemid'] =  JRequest::getVar('Itemid');

        $lang = JFactory::getLanguage();
        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        
        $componentPath =  'components/com_jsjobs/';
        require_once $componentPath.'JSApplication.php';
        $jobresult = JSModel::getJSModel('job')->jobsearch($result['sh_category'],$result['sh_subcategory'],$result['sh_company'],$result['sh_jobtype'],$result['sh_jobstatus'],$result['sh_shift'],$result['sh_salaryrange'],'');

        $result['js_dateformat'] = isset($jobresult[0]) ? $jobresult[0] : 0;
        $result['currency'] = isset($jobresult[1]) ? $jobresult[1] : 0;
        $result['job_categories'] = isset($jobresult[2]) ? $jobresult[2] : 0;
        $result['search_companies'] = isset($jobresult[3]) ? $jobresult[3] : 0;
        $result['job_type'] = isset($jobresult[4]) ? $jobresult[4] : 0;
        $result['job_status'] = isset($jobresult[5]) ? $jobresult[5] : 0;
        $result['search_shift'] = isset($jobresult[6]) ? $jobresult[6] : 0;
        $result['salaryrangefrom'] =isset($jobresult[7]) ? $jobresult[7] : 0;
        $result['salaryrangeto'] =isset($jobresult[8]) ? $jobresult[8] : 0;
        $result['salaryrangetypes'] =isset($jobresult[9]) ? $jobresult[9] : 0;
        $result['job_subcategories'] = isset($jobresult[10]) ? $jobresult[10] : 0;
        
        return $result;
    }
}