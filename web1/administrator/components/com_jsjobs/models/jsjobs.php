<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelJsjobs extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        //$this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function storeServerSerailNumber($data) {
        JRequest::checkToken() or die( 'Invalid Token' );
        $db = JFactory::getDBO();
        if ($data['server_serialnumber']) {
            $query = "UPDATE  `#__js_job_config` SET configvalue='" . $data['server_serialnumber'] . "' WHERE configname='server_serial_number'";
            $db->setQuery($query);
            if (!$db->Query())
                return false;
            else
                return true;
        } else
            return false;
    }

    function getGraphData() {
        $db = JFactory::getDBO();
        $d = array();
        for ($i = 0; $i <= 14; $i++) {
            $d[] = date("Y-m-d", strtotime('-' . $i . ' days'));
        }
        foreach ($d AS $day) {
            $datevar = date('Y-m-d', strtotime($day));
            $query = "SELECT count(id) AS id FROM #__js_job_jobs where DATE(created) =".$db->Quote($datevar);
            $db->setQuery($query);
            $total_jobs_per_day = $db->loadObject();

            $query = "SELECT count(id) AS id FROM `#__js_job_resume` where DATE(created) =".$db->Quote($datevar);
            $db->setQuery($query);
            $total_resume_per_day = $db->loadObject();
            $time_format = strtotime($day);
            $json_format_data[] = array(array($time_format . '000', $total_jobs_per_day->id), array($time_format . '000', $total_resume_per_day->id));
        }

        $json_data = json_encode($json_format_data);
        return $json_data;
    }

    function getTodayStats() {
        $db = JFactory::getDBO();
        $result = array();
        // Total stats
        $query = 'SELECT count(id) AS totalcompanies FROM #__js_job_companies';
        $db->setQuery($query);
        $companies = $db->loadResult();
        $query = 'SELECT count(id) AS totaljobs FROM #__js_job_jobs';
        $db->setQuery($query);
        $jobs = $db->loadResult();
        $query = 'SELECT count(id) AS totalresume FROM #__js_job_resume';
        $db->setQuery($query);
        $resumes = $db->loadResult();
        $curdate = date('Y-m-d');
        $query = "SELECT COUNT(id) AS activejobs FROM `#__js_job_jobs` WHERE DATE(startpublishing) <= ".$db->Quote($curdate)." AND DATE(stoppublishing) >= ".$db->Quote($curdate);
        $db->setQuery($query);
        $activejobs = $db->loadResult();
        $query = 'SELECT count(id) AS appliedjobs FROM #__js_job_jobapply';
        $db->setQuery($query);
        $appliedjobs = $db->loadResult();

        $result['companies'] = $companies;
        $result['jobs'] = $jobs;
        $result['resumes'] = $resumes;
        $result['activejobs'] = $activejobs;
        $result['appliedjobs'] = $appliedjobs;
        // Today Stats
        
        $config = $this->getJSModel('configuration')->getConfigByFor('default');
        $lastdate = date('Y-m-d', strtotime("now -1 month"));

        $query = "SELECT COUNT(id) FROM `#__js_job_jobs` WHERE DATE(created) BETWEEN ".$db->Quote($lastdate)." AND ".$db->Quote($curdate)." AND status = 1";
        $db->setQuery($query);
        $result['totalnewjobs'] = $db->loadResult();
        $query = "SELECT COUNT(id) FROM `#__js_job_companies` WHERE DATE(created) BETWEEN ".$db->Quote($lastdate)." AND ".$db->Quote($curdate)." AND status = 1";
        $db->setQuery($query);
        $result['totalnewcompanies'] = $db->loadResult();
        $query = "SELECT COUNT(id) FROM `#__js_job_resume` WHERE DATE(created) BETWEEN ".$db->Quote($lastdate)." AND ".$db->Quote($curdate)." AND status = 1";
        $db->setQuery($query);
        $result['totalnewresume'] = $db->loadResult();
        $query = "SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE DATE(apply_date) BETWEEN ".$db->Quote($lastdate)." AND ".$db->Quote($curdate);
        $db->setQuery($query);
        $result['totalnewjobapply'] = $db->loadResult();

        //Listings Data
        $curdate = date('Y-m-d');
        $fromdate = date('Y-m-d', strtotime("now -1 month"));
        //$fromdate = date('Y-m-d', strtotime("now -30 days"));
        $result['curdate'] = $curdate;
        $result['fromdate'] = $fromdate;
        $query = "SELECT job.startpublishing AS created
                    FROM `#__js_job_jobs` AS job WHERE DATE(job.startpublishing) >= ".$db->Quote($fromdate)." AND DATE(job.startpublishing) <= ".$db->Quote($curdate)." ORDER BY job.startpublishing";
        $db->setQuery($query);
        $alljobs = $db->loadObjectList();
        $jobs = array();
        foreach($alljobs AS $job){
            $date = date('Y-m-d',strtotime($job->created));
            $jobs[$date] = isset($jobs[$date]) ? ($jobs[$date] + 1) : 1;
        }
        $query = "SELECT company.created
                    FROM `#__js_job_companies` AS company WHERE date(company.created) >= ".$db->Quote($fromdate)." AND date(company.created) <= ".$db->Quote($curdate)." ORDER BY company.created";
        $db->setQuery($query);
        $allcompanies = $db->loadObjectList();
        $companies = array();
        foreach($allcompanies AS $company){
            $date = date('Y-m-d',strtotime($company->created));
            $companies[$date] = isset($companies[$date]) ? ($companies[$date] + 1) : 1;
        }
        $query = "SELECT resume.created
                    FROM `#__js_job_resume` AS resume WHERE date(resume.created) >= ".$db->Quote($fromdate)." AND date(resume.created) <= ".$db->Quote($curdate)."  ORDER BY resume.created";
        $db->setQuery($query);
        $allresume = $db->loadObjectList();
        $resumes = array();
        foreach($allresume AS $resume){
            $date = date('Y-m-d',strtotime($resume->created));
            $resumes[$date] = isset($resumes[$date]) ? ($resumes[$date] + 1) : 1;
        }
        $query = "SELECT job.startpublishing AS created
                    FROM `#__js_job_jobs` AS job WHERE date(job.startpublishing) >= ".$db->Quote($fromdate)." AND date(job.startpublishing) <= ".$db->Quote($curdate)." AND job.status = 1 ORDER BY job.created";
        $db->setQuery($query);
        $allactivejob = $db->loadObjectList();
        $activejobs = array();
        foreach($allactivejob AS $ajob){
            $date = date('Y-m-d',strtotime($ajob->created));
            $activejobs[$date] = isset($activejobs[$date]) ? ($activejobs[$date] + 1) : 1;
        }

        $result['stack_chart_horizontal']['title'] = "['".JText::_('Dates')."','".JText::_('Jobs')."','".JText::_('Companies')."','".JText::_('Resume')."','".JText::_('Active Jobs')."']";
        $result['stack_chart_horizontal']['data'] = '';
        for($i = 30; $i >= 0; $i--){
            $checkdate = JHtml::_('date', strtotime($curdate." -$i days"), $config['date_format']);
            $datadate = date('Y-m-d',strtotime($curdate." -$i days"));
            if($i != 30){
                $result['stack_chart_horizontal']['data'] .= ',';    
            }
            $result['stack_chart_horizontal']['data'] .= "['".$checkdate."',";
            $job = isset($jobs[$datadate]) ? $jobs[$datadate] : 0;
            $company = isset($companies[$datadate]) ? $companies[$datadate] : 0;
            $resume = isset($resumes[$datadate]) ? $resumes[$datadate] : 0;
            $ajob = isset($activejobs[$datadate]) ? $activejobs[$datadate] : 0;
            $result['stack_chart_horizontal']['data'] .= "$job,$company,$resume,$ajob]";
        }

        $result['latestjobs'] = $this->getNewestJobs();
        $result['mostviewcompanioes'] = $this->getMostViewCompanies();
        $result['mostviewjobs'] = $this->getMostViewJobs();
        $result['mostappliedjobs'] = $this->getMostAppliedJobs();
        $result['mostviewresumes'] = $this->getMostViewResumes();

        return $result;
    }

    function getNewestJobs() {
        $db = JFactory::getDBO();
        $query="SELECT job.id,job.title,job.startpublishing,job.stoppublishing,company.name, job.city 
                FROM `#__js_job_jobs` AS job
                JOIN `#__js_job_companies` AS company ON job.companyid=company.id
                ORDER BY job.created DESC
                LIMIT 5";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        return $data;
    }


    function getMostViewCompanies() {
        $db = JFactory::getDBO();
        $query="SELECT comp.id,comp.name,comp.hits,comp.created, comp.city, 
        comp.logofilename,comp.url,comp.city,comp.isfeaturedcompany,comp.isgoldcompany,cat.cat_title
        FROM #__js_job_companies AS comp
        LEFT JOIN #__js_job_categories AS cat on comp.category= cat.id  
        ORDER BY comp.hits DESC
        LIMIT 0,3";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        return $data;
    }

     function getMostViewJobs() {
        $db = JFactory::getDBO();
        $query="SELECT job.id,job.hits,job.title,job.created,cat.cat_title,job.isgoldjob, job.city 
                    ,job.isfeaturedjob,comp.logofilename,comp.id AS companyid,comp.url
                    FROM #__js_job_jobs AS job 
                    JOIN #__js_job_companies AS comp ON job.companyid=comp.id
                    JOIN #__js_job_categories AS cat ON job.jobcategory=cat.id
                    ORDER BY job.hits DESC
                    LIMIT 0,3";
        $db->setQuery($query);

        $data = $db->loadObjectList();
        return $data;
    }

     function getMostAppliedJobs() {
        $db = JFactory::getDBO();
        $query="SELECT COUNT(jobapply.jobid) AS totalapplied,job.id, job.title,job.created, job.city
                    ,comp.logofilename,job.isgoldjob,job.isfeaturedjob,cat.cat_title ,comp.id AS companyid
                    FROM #__js_job_jobapply AS jobapply
                    JOIN #__js_job_jobs AS job ON job.id = jobapply.jobid
                    JOIN #__js_job_categories AS cat ON job.jobcategory = cat.id
                    JOIN #__js_job_companies AS comp ON job.companyid=comp.id
                    GROUP BY jobapply.jobid ORDER BY totalapplied DESC LIMIT 0,3";
        $db->setQuery($query);

        $data = $db->loadObjectList();
        return $data;
    }

     function getMostViewResumes() {
        $db = JFactory::getDBO();
        $query="SELECT resume.id,resume.hits,cat.cat_title,resume.application_title,resume.created,resume.resume,resume.photo,
                edu.title AS heighestfinisheducation,resume.isgoldresume,resume.isfeaturedresume,resumeadrs.address_city as city
                FROM #__js_job_resume AS resume
                JOIN #__js_job_categories AS cat ON resume.job_category = cat.id
                LEFT JOIN #__js_job_resumeaddresses AS resumeadrs ON resume.id = resumeadrs.resumeid
                LEFT JOIN #__js_job_heighesteducation AS edu ON edu.id = resume.heighestfinisheducation
                GROUP BY resume.id
                ORDER BY hits DESC 
                LIMIT 0,3";
        $db->setQuery($query);
        $data = $db->loadObjectList();
        return $data;
}

    function getConcurrentRequestData() {
        $db = JFactory::getDBO();
        $query = "SELECT configname,configvalue FROM `#__js_job_config` WHERE configfor = " . $db->quote('hostdata');
        $db->setQuery($query);
        $result = $db->loadObjectList();
        foreach ($result AS $res) {
            $return[$res->configname] = $res->configvalue;
        }
        return $return;
    }

    function getMultiCityDataForView($id, $for) {
        if (!is_numeric($id))
            return false;
        $db = $this->getDBO();
        $query = "select mcity.id AS id,country.name AS countryName,city.cityName AS cityName,state.name AS stateName";
        switch ($for) {
            case 1:
                $query.=" FROM `#__js_job_jobcities` AS mcity";
                $query.=" LEFT JOIN `#__js_job_jobs` AS job ON mcity.jobid=job.id";
                break;
            case 2:
                $query.=" FROM `#__js_job_companycities` AS mcity";
                $query.=" LEFT JOIN `#__js_job_companies` AS company ON mcity.companyid=company.id";
                break;
        }
        $query.=" LEFT JOIN `#__js_job_cities` AS city ON mcity.cityid=city.id
				  LEFT JOIN `#__js_job_states` AS state ON city.stateid=state.id
				  LEFT JOIN `#__js_job_countries` AS country ON city.countryid=country.id";
        switch ($for) {
            case 1:
                $query.=" where mcity.jobid=" . $id;
                break;
            case 2:
                $query.=" where mcity.companyid=" . $id;
                break;
        }
        $query.=" ORDER BY country.name";
        $db->setQuery($query);
        $cities = $db->loadObjectList();
        $mloc = array();
        $mcountry = array();
        $finalloc = "";
        foreach ($cities AS $city) {
            $mcountry[] = $city->countryName;
        }
        $country_total = array_count_values($mcountry);
        $i = 0;
        foreach ($country_total AS $key => $val) {
            foreach ($cities AS $city) {
                if ($key == $city->countryName) {
                    $i++;
                    if ($val == 1) {
                        $finalloc.="[" . $city->cityName . "," . $key . " ] ";
                        $i = 0;
                    } elseif ($i == $val) {
                        $finalloc.=$city->cityName . "," . $key . " ] ";
                        $i = 0;
                    } elseif ($i == 1)
                        $finalloc.= "[" . $city->cityName . ",";
                    else
                        $finalloc.=$city->cityName . ",";
                }
            }
        }
        return $finalloc;
    }

    function getUserGroups() {
        $db = JFactory::getDBO();
        $query = "SELECT id,title AS name FROM #__usergroups";
        $db->setQuery($query);
        $usergroup = $db->loadObjectList();
        $groups = array();
        $groups[] = array('value' => '', 'text' => JText::_('Select Group'));
        foreach ($usergroup as $row) {
            $groups[] = array('value' => $row->id, 'text' => JText::_($row->name));
        }
        return $groups;
    }

    // Reports Methods
    function getChartColor(){
        $colors =  array('#3366CC','#DC3912','#FF9900','#109618','#990099','#B77322','#8B0707','#AAAA11','#316395','#DD4477','#3B3EAC','#ADD042','#9D98CA','#ED3237','#585570','#4E5A62','#5CC6D0');
        return $colors;
    }

    function getOverallReports(){
        $db = JFactory::getDBO();
        $js_results = array();
        //Line Chart Data
        $curdate = date('Y-m-d');
        $dates = '';
        $fromdate = date('Y-m-d', strtotime("now -1 month"));
        $nextdate = $curdate;
        //Query to get Data
        $query = "SELECT created FROM `#__js_job_jobs` WHERE date(created) >= " .$db->Quote( $fromdate) . " AND date(created) <= " .$db->Quote( $curdate);
        $db->setQuery($query);
        $jobs = $db->loadObjectList();

        $query = "SELECT created FROM `#__js_job_resume` WHERE date(created) >= " .$db->Quote( $fromdate) . " AND date(created) <= " .$db->Quote( $curdate);
        $db->setQuery($query);
        $resume = $db->loadObjectList();

        $query = "SELECT created FROM `#__js_job_companies` WHERE date(created) >= " .$db->Quote( $fromdate) . " AND date(created) <= " .$db->Quote( $curdate);
        $db->setQuery($query);
        $companies = $db->loadObjectList();

        $query = "SELECT apply_date FROM `#__js_job_jobapply` WHERE date(apply_date) >= " .$db->Quote( $fromdate) . " AND date(apply_date) <= " .$db->Quote( $curdate) ;
        $db->setQuery($query);
        $appliedresume = $db->loadObjectList();

        $date_jobs = array();
        $date_companies = array();
        $date_resume = array();
        $date_appliedresume = array();
        foreach ($jobs AS $job) {
            if (!isset($date_jobs[date('Y-m-d', strtotime($job->created))]))
                $date_jobs[date('Y-m-d', strtotime($job->created))] = 0;
            $date_jobs[date('Y-m-d', strtotime($job->created))] = $date_jobs[date('Y-m-d', strtotime($job->created))] + 1;
        }
        foreach ($resume AS $rs) {
            if (!isset($date_resume[date('Y-m-d', strtotime($rs->created))]))
                $date_resume[date('Y-m-d', strtotime($rs->created))] = 0;
            $date_resume[date('Y-m-d', strtotime($rs->created))] = $date_resume[date('Y-m-d', strtotime($rs->created))] + 1;
        }
        foreach ($companies AS $company) {
            if (!isset($date_companies[date('Y-m-d', strtotime($company->created))]))
                $date_companies[date('Y-m-d', strtotime($company->created))] = 0;
            $date_companies[date('Y-m-d', strtotime($company->created))] = $date_companies[date('Y-m-d', strtotime($company->created))] + 1;
        }
        foreach ($appliedresume AS $ar) {
            if (!isset($date_appliedresume[date('Y-m-d', strtotime($ar->apply_date))]))
                $date_appliedresume[date('Y-m-d', strtotime($ar->apply_date))] = 0;
                $date_appliedresume[date('Y-m-d', strtotime($ar->apply_date))] = $date_appliedresume[date('Y-m-d', strtotime($ar->apply_date))] + 1;
        }
        $job_s = 0;
        $company_s = 0;
        $resume_s = 0;
        $appliedresume_s = 0;
        $json_array = "";

        do{
            $year = date('Y',strtotime($nextdate));
            $month = date('m',strtotime($nextdate));
            $month = $month - 1; //js month are 0 based
            $day = date('d',strtotime($nextdate));
            $job_tmp = isset($date_jobs[$nextdate]) ? $date_jobs[$nextdate]  : 0;
            $resume_tmp = isset($date_resume[$nextdate]) ? $date_resume[$nextdate] : 0;
            $company_tmp = isset($date_companies[$nextdate]) ? $date_companies[$nextdate] : 0;
            $appliedresume_tmp = isset($date_appliedresume[$nextdate]) ? $date_appliedresume[$nextdate] : 0;
            $json_array .= "[new Date($year,$month,$day),$job_tmp,$resume_tmp,$company_tmp,$appliedresume_tmp],";
            $job_s += $job_tmp;
            $company_s += $company_tmp;
            $resume_s += $resume_tmp;
            $appliedresume_s += $appliedresume_tmp;
            $nextdate = date('Y-m-d', strtotime($nextdate . " -1 days"));
        }while($nextdate != $fromdate);

        $js_results['totaljobs'] = $job_s;
        $js_results['totalcompany'] = $company_s;
        $js_results['totalresume'] = $resume_s;
        $js_results['totalappliedresume'] = $appliedresume_s;

        $js_results['line_chart_json_array'] = $json_array;

        $query = "SELECT cat.cat_title,(SELECT COUNT(id) FROM `#__js_job_jobs` WHERE jobcategory = cat.id) AS jobs
                    FROM `#__js_job_categories` AS cat 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $jobs = $db->loadObjectList();
        $query = "SELECT cat.cat_title,(SELECT COUNT(id) FROM `#__js_job_companies` WHERE category = cat.id) AS companies                    
                    FROM `#__js_job_categories` AS cat 
                    ORDER BY companies DESC LIMIT 5";
                    $db->setQuery($query);
        $companies = $db->loadObjectList();
        $query = "SELECT cat.cat_title,(SELECT COUNT(id) FROM `#__js_job_resume` WHERE job_category = cat.id) AS resumes 
                    FROM `#__js_job_categories` AS cat 
                    ORDER BY resumes DESC LIMIT 5";
                    $db->setQuery($query);
        $resume = $db->loadObjectList();
        $js_results['catbar1'] = '';
        $js_results['catbar2'] = '';
        $js_results['catpie'] = '';
        $colors = $this->getChartColor();
        for($i = 0;$i < 5;$i++){
            $job = $jobs[$i];
            $company = $companies[$i];
            $resum = $resume[$i];
            $js_results['catbar1'] .= "['". JText::_($job->cat_title) ."', ".$job->jobs.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
            $js_results['catbar2'] .= "['". JText::_($resum->cat_title) ."', ".$resum->resumes.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
            $js_results['catpie'] .= "['". JText::_($company->cat_title) ."', ".$company->companies."],";
        }

        $query = "SELECT city.cityName AS name,(SELECT COUNT(jobid) FROM `#__js_job_jobcities` WHERE cityid = city.id ) AS jobs
                    FROM `#__js_job_cities` AS city 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $jobs = $db->loadObjectList();
        $query = "SELECT city.cityName AS name,(SELECT COUNT(companyid) FROM `#__js_job_companycities` WHERE cityid = city.id) AS companies 
                    FROM `#__js_job_cities` AS city 
                    ORDER BY companies DESC LIMIT 5";
                    $db->setQuery($query);
        $companies = $db->loadObjectList();
        $query = "SELECT city.cityName AS name,(SELECT COUNT(resumeid) FROM `#__js_job_resumeaddresses` WHERE address_city = city.id) AS resumes 
                    FROM `#__js_job_cities` AS city 
                    ORDER BY resumes DESC LIMIT 5";
                    $db->setQuery($query);
        $resume = $db->loadObjectList();
        $js_results['citybar1'] = '';
        $js_results['citybar2'] = '';
        $js_results['citypie'] = '';
        for($i = 0;$i < 5;$i++){
            $job = $jobs[$i];
            $company = $companies[$i];
            $resum = $resume[$i];
            $js_results['citybar1'] .= "['".$job->name."', ".$job->jobs.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
            $js_results['citybar2'] .= "['".$resum->name."', ".$resum->resumes.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
            $js_results['citypie'] .= "['".$company->name."', ".$company->companies."],";
        }

        $query = "SELECT jobtype.title,(SELECT COUNT(jobid) FROM `#__js_job_jobs` WHERE jobtype = jobtype.id ) AS jobs
                    FROM `#__js_job_jobtypes` AS jobtype 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $jobs = $db->loadObjectList();
        $query = "SELECT jobtype.title,(SELECT COUNT(id) FROM `#__js_job_resume` WHERE jobtype = jobtype.id) AS resumes 
                    FROM `#__js_job_jobtypes` AS jobtype 
                    ORDER BY resumes DESC LIMIT 5";
                    $db->setQuery($query);
        $resume = $db->loadObjectList();
        $js_results['jobtypebar1'] = '';
        $js_results['jobtypebar2'] = '';
        for($i = 0;$i < 5;$i++){
            $job = isset($jobs[$i]) ? $jobs[$i] : '';
            $resum = isset($resume[$i]) ? $resume[$i] : '';
            if($job)
                $js_results['jobtypebar1'] .= "['". JText::_($job->title) ."', ".$job->jobs.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
            if($resum)
                $js_results['jobtypebar2'] .= "['". JText::_($resum->title) ."', ".$resum->resumes.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
        }

        return $js_results;
    }

    function getEmployerReports(){
        $db = JFactory::getDBO();
        $js_results = array();
        //Line Chart Data
        $curdate = date('Y-m-d');
        $dates = '';
        $fromdate = date('Y-m-d', strtotime("now -1 month"));
        $nextdate = $curdate;

        $query = "SELECT created FROM `#__js_job_jobs` WHERE date(startpublishing) <= ". $db->Quote($curdate) . " AND date(stoppublishing) >= ".$db->Quote($curdate)." AND date(created) >= ".$db->Quote($fromdate)." AND date(created) <= ".$db->Quote($curdate);
        $db->setQuery($query);
        $jobs = $db->loadObjectList();

        $query = "SELECT apply_date FROM `#__js_job_jobapply` WHERE date(apply_date) >= ".$db->Quote($fromdate)." AND date(apply_date) <= ".$db->Quote($curdate);
        $db->setQuery($query);
        $appliedresume = $db->loadObjectList();

        $query = "SELECT created FROM `#__js_job_jobs` WHERE isgoldjob = 1 AND date(created) >= ".$db->Quote($fromdate)." AND date(created) <= ".$db->Quote($curdate);
        $db->setQuery($query);
        $goldjobs = $db->loadObjectList();

        $query = "SELECT created FROM `#__js_job_jobs` WHERE isfeaturedjob = 1 AND date(created) >= ".$db->Quote($fromdate)." AND date(created) <= ".$db->Quote($curdate);
        $db->setQuery($query);
        $featuredjobs = $db->loadObjectList();

        $date_jobs = array();
        $date_goldjob = array();
        $date_featuredjob = array();
        $date_appliedresume = array();
        foreach ($jobs AS $job) {
            if (!isset($date_jobs[date('Y-m-d', strtotime($job->created))]))
                $date_jobs[date('Y-m-d', strtotime($job->created))] = 0;
            $date_jobs[date('Y-m-d', strtotime($job->created))] = $date_jobs[date('Y-m-d', strtotime($job->created))] + 1;
        }
        foreach ($appliedresume AS $rs) {
            if (!isset($date_appliedresume[date('Y-m-d', strtotime($rs->apply_date))]))
                $date_appliedresume[date('Y-m-d', strtotime($rs->apply_date))] = 0;
            $date_appliedresume[date('Y-m-d', strtotime($rs->apply_date))] = $date_appliedresume[date('Y-m-d', strtotime($rs->apply_date))] + 1;
        }
        foreach ($goldjobs AS $job) {
            if (!isset($date_goldjob[date('Y-m-d', strtotime($job->created))]))
                $date_goldjob[date('Y-m-d', strtotime($job->created))] = 0;
            $date_goldjob[date('Y-m-d', strtotime($job->created))] = $date_goldjob[date('Y-m-d', strtotime($job->created))] + 1;
        }
        foreach ($featuredjobs AS $job) {
            if (!isset($date_featuredjob[date('Y-m-d', strtotime($job->created))]))
                $date_featuredjob[date('Y-m-d', strtotime($job->created))] = 0;
            $date_featuredjob[date('Y-m-d', strtotime($job->created))] = $date_featuredjob[date('Y-m-d', strtotime($job->created))] + 1;
        }

        $job_s = 0;
        $appliedresume_s = 0;
        $goldjob_s = 0;
        $featuredjob_s = 0;
        $json_array = "";

        do{
            $year = date('Y',strtotime($nextdate));
            $month = date('m',strtotime($nextdate));
            $month = $month - 1; //js month are 0 based
            $day = date('d',strtotime($nextdate));
            $job_tmp = isset($date_jobs[$nextdate]) ? $date_jobs[$nextdate]  : 0;
            $appliedresume_tmp = isset($date_appliedresume[$nextdate]) ? $date_appliedresume[$nextdate] : 0;
            $goldjob_tmp = isset($date_goldjob[$nextdate]) ? $date_goldjob[$nextdate] : 0;
            $featuredjob_tmp = isset($date_featuredjob[$nextdate]) ? $date_featuredjob[$nextdate] : 0;
            $json_array .= "[new Date($year,$month,$day),$job_tmp,$appliedresume_tmp,$goldjob_tmp,$featuredjob_tmp],";
            $job_s += $job_tmp;
            $goldjob_s += $goldjob_tmp;
            $featuredjob_s += $featuredjob_tmp;
            $appliedresume_s += $appliedresume_tmp;
            $nextdate = date('Y-m-d', strtotime($nextdate . " -1 days"));
        }while($nextdate != $fromdate);

        $js_results['totaljobs'] = $job_s;
        $js_results['totalgoldjob'] = $goldjob_s;
        $js_results['totalfeaturedjob'] = $featuredjob_s;
        $js_results['totalappliedresume'] = $appliedresume_s;

        $js_results['line_chart_json_array'] = $json_array;

        $query = "SELECT cat.cat_title,(SELECT COUNT(id) FROM `#__js_job_jobs` WHERE jobcategory = cat.id) AS jobs
                    FROM `#__js_job_categories` AS cat 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $jobsbycat = $db->loadObjectList();
        $query = "SELECT company.name,(SELECT COUNT(id) FROM `#__js_job_jobs` WHERE companyid = company.id) AS jobs 
                    FROM `#__js_job_companies` AS company
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $jobsbycompany = $db->loadObjectList();
        $query = "SELECT city.cityName AS name,(SELECT COUNT(id) FROM `#__js_job_jobcities` WHERE cityid = city.id) AS jobs 
                    FROM `#__js_job_cities` AS city 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $jobsbycity = $db->loadObjectList();
        $query = "SELECT jobtype.title,(SELECT COUNT(id) FROM `#__js_job_jobs` WHERE jobtype = jobtype.id) AS jobs 
                    FROM `#__js_job_jobtypes` AS jobtype 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $jobsbytype = $db->loadObjectList();

        $js_results['bar1'] = '';
        $js_results['bar2'] = '';
        $js_results['pie1'] = '';
        $js_results['pie2'] = '';
        $colors = $this->getChartColor();
        for($i = 0;$i < 5;$i++){
            $jobcat = isset($jobsbycat[$i]) ? $jobsbycat[$i] : null;
            $jobcompany = isset($jobsbycompany[$i]) ? $jobsbycompany[$i] : null;
            $jobcity = isset($jobsbycity[$i]) ? $jobsbycity[$i] : null;
            $jobtype = isset($jobsbytype[$i]) ? $jobsbytype[$i] : null;
            if($jobcat)
                $js_results['pie1'] .= "['". JText::_($jobcat->cat_title) ."', ".$jobcat->jobs."],";
            if($jobcompany)
                $js_results['pie2'] .= "['".$jobcompany->name."', ".$jobcompany->jobs."],";
            if($jobcity)
                $js_results['bar1'] .= "['". JText::_($jobcity->name) ."', ".$jobcity->jobs.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
            if($jobtype)
                $js_results['bar2'] .= "['". JText::_($jobtype->title) ."', ".$jobtype->jobs.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
        }
        return $js_results;
    }

    function getJobseekerReports(){
        $db = JFactory::getDBO();
        $js_results = array();
        //Line Chart Data
        $curdate = date('Y-m-d');
        $dates = '';
        $fromdate = date('Y-m-d', strtotime("now -1 month"));
        $nextdate = $curdate;

        $query = "SELECT created FROM `#__js_job_resume` WHERE status = 1 AND date(created) >= ".$db->Quote($fromdate)." AND date(created) <= ".$db->Quote($curdate);
        $db->setQuery($query);
        $resumes = $db->loadObjectList();

        $query = "SELECT apply_date FROM `#__js_job_jobapply` WHERE date(apply_date) >= ".$db->Quote($fromdate)." AND date(apply_date) <= ".$db->Quote($curdate);
        $db->setQuery($query);
        $appliedresume = $db->loadObjectList();

        $query = "SELECT created FROM `#__js_job_resume` WHERE isgoldresume = 1 AND date(created) >= ".$db->Quote($fromdate)." AND date(created) <= ".$db->Quote($curdate);
        $db->setQuery($query);
        $goldresume = $db->loadObjectList();

        $query = "SELECT created FROM `#__js_job_resume` WHERE isfeaturedresume = 1 AND date(created) >= ".$db->Quote($fromdate)." AND date(created) <= ".$db->Quote($curdate);
        $db->setQuery($query);
        $featuredresume = $db->loadObjectList();

        $date_resumes = array();
        $date_goldresume = array();
        $date_featuredresume = array();
        $date_appliedresume = array();
        foreach ($resumes AS $rs) {
            if (!isset($date_resumes[date('Y-m-d', strtotime($rs->created))]))
                $date_resumes[date('Y-m-d', strtotime($rs->created))] = 0;
            $date_resumes[date('Y-m-d', strtotime($rs->created))] = $date_resumes[date('Y-m-d', strtotime($rs->created))] + 1;
        }
        foreach ($appliedresume AS $rs) {
            if (!isset($date_appliedresume[date('Y-m-d', strtotime($rs->apply_date))]))
                $date_appliedresume[date('Y-m-d', strtotime($rs->apply_date))] = 0;
            $date_appliedresume[date('Y-m-d', strtotime($rs->apply_date))] = $date_appliedresume[date('Y-m-d', strtotime($rs->apply_date))] + 1;
        }
        foreach ($goldresume AS $job) {
            if (!isset($date_goldresume[date('Y-m-d', strtotime($job->created))]))
                $date_goldresume[date('Y-m-d', strtotime($job->created))] = 0;
            $date_goldresume[date('Y-m-d', strtotime($job->created))] = $date_goldresume[date('Y-m-d', strtotime($job->created))] + 1;
        }
        foreach ($featuredresume AS $job) {
            if (!isset($date_featuredresume[date('Y-m-d', strtotime($job->created))]))
                $date_featuredresume[date('Y-m-d', strtotime($job->created))] = 0;
            $date_featuredresume[date('Y-m-d', strtotime($job->created))] = $date_featuredresume[date('Y-m-d', strtotime($job->created))] + 1;
        }

        $resume_s = 0;
        $appliedresume_s = 0;
        $goldresume_s = 0;
        $featuredresume_s = 0;
        $json_array = "";

        do{
            $year = date('Y',strtotime($nextdate));
            $month = date('m',strtotime($nextdate));
            $month = $month - 1; //js month are 0 based
            $day = date('d',strtotime($nextdate));
            $resume_tmp = isset($date_resume[$nextdate]) ? $date_resume[$nextdate]  : 0;
            $appliedresume_tmp = isset($date_appliedresume[$nextdate]) ? $date_appliedresume[$nextdate] : 0;
            $goldresume_tmp = isset($date_goldresume[$nextdate]) ? $date_goldresume[$nextdate] : 0;
            $featuredresume_tmp = isset($date_featuredresume[$nextdate]) ? $date_featuredresume[$nextdate] : 0;
            $json_array .= "[new Date($year,$month,$day),$resume_tmp,$appliedresume_tmp,$goldresume_tmp,$featuredresume_tmp],";
            $resume_s += $resume_tmp;
            $goldresume_s += $goldresume_tmp;
            $featuredresume_s += $featuredresume_tmp;
            $appliedresume_s += $appliedresume_tmp;
            $nextdate = date('Y-m-d', strtotime($nextdate . " -1 days"));
        }while($nextdate != $fromdate);

        $js_results['totaljobs'] = $resume_s;
        $js_results['totalgoldjob'] = $goldresume_s;
        $js_results['totalfeaturedjob'] = $featuredresume_s;
        $js_results['totalappliedresume'] = $appliedresume_s;

        $js_results['line_chart_json_array'] = $json_array;

        $query = "SELECT cat.cat_title,(SELECT COUNT(id) FROM `#__js_job_resume` WHERE job_category = cat.id) AS jobs
                    FROM `#__js_job_categories` AS cat 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $resumebycat = $db->loadObjectList();
        $query = "SELECT city.cityName AS name,(SELECT COUNT(id) FROM `#__js_job_resumeaddresses` WHERE address_city = city.id) AS jobs 
                    FROM `#__js_job_cities` AS city 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $resumebycity = $db->loadObjectList();
        $query = "SELECT jobtype.title,(SELECT COUNT(id) FROM `#__js_job_resume` WHERE jobtype = jobtype.id) AS jobs 
                    FROM `#__js_job_jobtypes` AS jobtype 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $resumebytype = $db->loadObjectList();
		$query = "SELECT heighesteducation.title,(SELECT COUNT(id) FROM `#__js_job_resume` WHERE heighestfinisheducation = heighesteducation.id) AS jobs		
                    FROM `#__js_job_heighesteducation` AS heighesteducation 
                    ORDER BY jobs DESC LIMIT 5";
                    $db->setQuery($query);
        $resumebyeducation = $db->loadObjectList();

        $js_results['bar1'] = '';
        $js_results['bar2'] = '';
        $js_results['pie1'] = '';
        $js_results['pie2'] = '';
        $colors = $this->getChartColor();
        for($i = 0;$i < 5;$i++){
            $resumecat = isset($resumebycat[$i]) ? $resumebycat[$i] : null;
            $resumecity = isset($resumebycity[$i]) ? $resumebycity[$i] : null;
            $resumetype = isset($resumebytype[$i]) ? $resumebytype[$i] : null;
            $resumeeducation = isset($resumebyeducation[$i]) ? $resumebyeducation[$i] : null;
            if($resumecat)
                $js_results['pie1'] .= "['". JText::_($resumecat->cat_title) ."', ".$resumecat->jobs."],";
            if($resumecity)
                $js_results['pie2'] .= "['". JText::_($resumecity->name) ."', ".$resumecity->jobs."],";
            if($resumetype)
                $js_results['bar1'] .= "['". JText::_($resumetype->title) ."', ".$resumetype->jobs.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
            if($resumeeducation)
                $js_results['bar2'] .= "['". JText::_($resumeeducation->title) ."', ".$resumeeducation->jobs.", '".$colors[$i]."', '".JText::_('Jobs')."' ],";
        }
        return $js_results;
    }
    //END Reports Methods

    function getStepTwoValidate() {
        $return['admin_dir'] = substr(sprintf('%o', fileperms('components/com_jsjobs')), -3);
        $return['site_dir'] = substr(sprintf('%o', fileperms('../components/com_jsjobs')), -3);
        $return['tmp_dir'] = substr(sprintf('%o', fileperms('../tmp')), -3);
        $db = $this->getDbo();
        $query = 'CREATE TABLE js_test_table(
                    id int,
                    name varchar(255)
                );';
        $db->setQuery($query);
        $return['create_table'] = 0;
        if ($db->query()) {
            $return['create_table'] = 1;
        }
        $query = 'INSERT INTO js_test_table(id,name) VALUES (1,\'Naeem\'),(2,\'Saad\');';
        $db->setQuery($query);
        $return['insert_record'] = 0;
        if ($db->query()) {
            $return['insert_record'] = 1;
        }
        $query = 'UPDATE js_test_table SET name = \'Shoaib Rehmat\' WHERE id = 1;';
        $db->setQuery($query);
        $return['update_record'] = 0;
        if ($db->query()) {
            $return['update_record'] = 1;
        }
        $query = 'DELETE FROM js_test_table;';
        $db->setQuery($query);
        $return['delete_record'] = 0;
        if ($db->query()) {
            $return['delete_record'] = 1;
        }
        $query = 'DROP TABLE js_test_table;';
        $db->setQuery($query);
        $return['drop_table'] = 0;
        if ($db->query()) {
            $return['drop_table'] = 1;
        }
        if($return['tmp_dir'] >= 755){
            if(function_exists('curl_init')){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_URL, 'http://test.setup.joomsky.com/logo.png');
                $fp = fopen('../tmp/logo.png', 'w+');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
                curl_exec ($ch);
                curl_close ($ch);
                fclose($fp);
                $return['file_downloaded'] = 0;
                if(file_exists('../tmp/logo.png')){
                    $return['file_downloaded'] = 1;
                }
            }else{
                $return['file_downloaded'] = 0;
            }
        }else $return['file_downloaded'] = 0;
        return $return;
    }

    function getConfigByConfigName($configname) {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM `#__js_job_config` WHERE configname = " . $db->quote($configname);
        $db->setQuery($query);
        $result = $db->loadObject();
        return $result;
    }

    function getConfigCount() {
        $db = JFactory::getDBO();
        $query = "SELECT COUNT(*) FROM `#__js_job_config` ";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getListTranslations() {
        
        $result = array();
        $result['error'] = false;

        $path = JPATH_ADMINISTRATOR.'/language';

        if( ! is_writeable($path)){
            $result['error'] = JText::_('Dir is not writeable').' '.$path;

        }else{

            if($this->isConnected()){

                $versiontype = $this->getJSModel('jsjobs')->getConfigByConfigName('versiontype');
                $version = $this->getJSModel('jsjobs')->getConfigByConfigName('version');

                $url = "http://www.joomsky.com/translations/api/1.0/index.php";
                $post_data['product'] ='js-jobs-joomla';
                $post_data['domain'] = JURI::root();
                $post_data['producttype'] = $versiontype->configvalue;
                $post_data['productcode'] = 'jsjobs';
                $post_data['productversion'] = $version->configvalue;
                $post_data['JVERSION'] = JVERSION;
                $post_data['method'] = 'getTranslations';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                $response = curl_exec($ch);
                curl_close($ch);

                $result['data'] = $response;
            }else{
                $result['error'] = JText::_('Unable to connect to server');
            }
        }

        $result = json_encode($result);

        return $result;
    }

    function makeLanguageCode($lang_name , $path){

        if( strpos($lang_name, '_') !== false ) {
            $lang_name = str_replace('_', '-', $lang_name);
        }else{
            if($lang_name == 'en'){
                $lang_name = $lang_name.'-'.strtoupper('gb');
            }elseif($lang_name == 'sv'){
                $lang_name = $lang_name.'-'.strtoupper('se');
            }elseif($lang_name == 'ar'){
                $lang_folders = scandir($path);
                $n = count($lang_folders);
                for ($i = 0; $i < $n; $i++) { 
                    if($lang_folders[$i] == 'ar-SA'){
                        $lang_name = $lang_folders[$i];
                        $i = $n;
                    }elseif ($lang_folders[$i] == 'ar-EG'){
                        $lang_name = $lang_folders[$i];
                        $i = $n;
                    }elseif ($lang_folders[$i] == 'ar-AA'){
                        $lang_name = $lang_folders[$i];
                        $i = $n;
                    }
                }
            }else{
                $lang_name = $lang_name.'-'.strtoupper($lang_name);
            }
        }
        return $lang_name;
    }

    function validateAndShowDownloadFileName( $lang_name ){

        if($lang_name == '')
            return '';
        $result = array();
        $path = JPATH_ADMINISTRATOR.'/language';

        $final_name = $this->makeLanguageCode($lang_name , $path);

        $result['error'] = false;
        if( ! file_exists($path)){
            $result['error'] = $lang_name. ' ' . JText::_('Language is not installed');
        }elseif( ! is_writeable($path)){
            $result['error'] = $lang_name. ' ' . JText::_('Language directory is not writeable').': '.$path;
        }else{
            $result['input'] = '<input id="languagecode" class="text_area" type="text" value="'.$final_name.'" name="languagecode">';
            $result['path'] = JText::_('Language code');
        }
        $result = json_encode($result);
        return $result;
    }

    function getLanguageTranslation($lang_name , $language_code){

        $result = array();
        $result['error'] = false;
        $path = JPATH_ADMINISTRATOR.'/language';

        if($lang_name == '' || $language_code == ''){
            $result['error'] = JText::_('Empty values');
            return json_encode($result);
        }
        
        $path = $path.'/'.$language_code;
        $final_path = $path.'/'.$language_code.'.com_jsjobs.ini';


        if( ! file_exists($path)){
            $result['error'] = $lang_name. ' ' . JText::_('Language is not installed');
            return json_encode($result);
        }elseif( ! is_writeable($path)){
            $result['error'] = $lang_name. ' ' . JText::_('Language directory is not writeable').': '.$path;
            return json_encode($result);
        }

        if( ! file_exists($final_path)){
            touch($final_path);
        }

        if( ! is_writeable($final_path)){
            $result['error'] = JText::_('File is not writeable').': '.$final_path;
        }else{

            if($this->isConnected()){

                $version = $this->getJSModel('configuration')->getConfigByFor('version');

                $url = "http://www.joomsky.com/translations/api/1.0/index.php";
                $post_data['product'] ='js-jobs-joomla';
                $post_data['domain'] = JURI::root();
                $post_data['producttype'] = $version['versiontype'];
                $post_data['productcode'] = 'jsjobs';
                $post_data['productversion'] = $version['version'];
                $post_data['JVERSION'] = JVERSION;
                $post_data['translationcode'] = $lang_name;
                $post_data['method'] = 'getTranslationFile';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                $response = curl_exec($ch);
                curl_close($ch);
                $array = json_decode($response, true);

                $ret = $this->writeLanguageFile( $final_path , $array['file']);

                if($ret != false){
                    $url = "http://www.joomsky.com/translations/api/1.0/index.php";
                    $post_data['product'] ='js-jobs-joomla';
                    $post_data['domain'] = JURI::root();
                    $post_data['producttype'] = $version['versiontype'];
                    $post_data['productcode'] = 'jsjobs';
                    $post_data['productversion'] = $version['version'];
                    $post_data['JVERSION'] = JVERSION;
                    $post_data['folder'] = $array['foldername'];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                    $response = curl_exec($ch);
                    curl_close($ch);
                }
                $result['data'] = JText::_('File Downloaded Successfully');
            }else{
                $result['error'] = JText::_('Unable to connect to server');
            }
        }

        $result = json_encode($result);

        return $result;

    }

    function writeLanguageFile( $path , $url ){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_URL, $url);
        $fp = fopen( $path , 'w');

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        if( filesize($path) > 0 ){
            $result = true;
        }else{
            $result = false;
        }

        return $result;
    }

    function isConnected(){
        
        $connected = @fsockopen("www.google.com", 80); 
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;
    }
}
?>
