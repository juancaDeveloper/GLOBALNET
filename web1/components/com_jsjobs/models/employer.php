<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     https://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest::getVar('option', 'com_jsjobs');

class JSJobsModelEmployer extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_uid = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
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

    function getControlPanelData(){
        $db = $this->getDBO();
        $results = array();
        $localwork = "";
        $user = JFactory::getUser();
        $uid = $user->id;
        $isguest = $user->guest;
        $role = $this->getJSModel('userrole')->getUserRole($uid);
        if($role)
            $role = $role->rolefor; //1 for emp 2 for jobseeker
        $graphfor = false;
        if($isguest){
            $graphfor = 'guest';
        }else{
            if($role == 1)
                $graphfor = 'employer';
        }

        if($uid > 0){
            $query = "SELECT job.id AS jobid,job.title AS jobtitle,cat.cat_title ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                        , app.id AS appid,app.photo, app.application_title, app.first_name, app.last_name
                        ,CONCAT(app.alias,'-',app.id) AS resumealiasid ,app.isgoldresume,app.isfeaturedresume,app.endgolddate,app.endfeaturedate
                        ,city.id AS cityid, experience.title AS experience_title
                        FROM `#__js_job_jobapply` AS apply
                        JOIN `#__js_job_jobs` AS job ON job.id = apply.jobid
                        JOIN `#__js_job_resume` AS app ON apply.cvid = app.id  
                        JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id
                        LEFT JOIN `#__js_job_experiences` AS experience ON app.experienceid = experience.id
                        LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = app.id LIMIT 1 )
                        WHERE job.uid = ".$uid."
                        ORDER BY apply.apply_date DESC LIMIT 3";
            $db->setQuery($query);
            $results['applied_resume'] = $db->loadObjectList();
            $localwork = $results['applied_resume'];
            foreach ($localwork as $row ) {
                $row->location = $this->getJSModel('cities')->getLocationDataForView($row->cityid);
            }
        }    
        $results['applied_resume'] = $localwork;

        $query = "SELECT app.id AS appid,app.first_name, app.last_name, app.photo, app.application_title
                    ,CONCAT(app.alias,'-',app.id) AS resumealiasid ,app.isgoldresume,app.isfeaturedresume,app.endgolddate,app.endfeaturedate
                    ,cat.cat_title ,city.id AS cityid, experience.title AS experience_title
                    FROM `#__js_job_resume` AS app 
                    JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id
                    LEFT JOIN `#__js_job_experiences` AS experience ON app.experienceid = experience.id
                    LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = app.id LIMIT 1 )
                    WHERE app.status = 1 AND app.searchable = 1 ORDER BY app.created DESC LIMIT 3";
        $db->setQuery($query);
        $results['newest_resume'] = $db->loadObjectList();
        $localwork = $results['newest_resume'];
        foreach ($localwork as $row ) {
            $row->location = $this->getJSModel('cities')->getLocationDataForView($row->cityid);
        }
        $results['newest_resume'] = $localwork;

        if($graphfor == 'employer'){
            $results['line_chart'] = $this->getEmployerLatestJobsForLineChart($uid);
            $results['pie_chart'] = $this->getAppliedResumeExperienceForPieChart();
        }elseif($graphfor == 'guest'){
            $results['line_chart'] = $this->getVisitorStatsForLineChart();
        }
        return $results;
    }

    function getEmployerLatestJobsForLineChart($uid){
        if($uid){
            if(!is_numeric($uid)) return false;
        }
        $db = $this->getDBO();
        $date_format = $this->getJSModel('configurations')->getConfigValue('date_format');
        $date_limit = date('Y-m-d',strtotime(date('Y-m-d') . ' -7 days'));
        $date_limit = JHtml::_('date', strtotime(date('Y-m-d')." -7 days"), 'Y-m-d');
        $query = "SELECT job.title,job.id
            FROM `#__js_job_jobs` AS job
            WHERE DATE(job.created) >= '".$date_limit."' AND job.startpublishing <= CURDATE() AND job.stoppublishing > CURDATE() 
            AND job.uid = ".$uid." AND job.status = 1 ORDER BY job.created DESC LIMIT 5";
        $db->setQuery($query);
        $jobs = $db->loadObjectList();
        $noofjobs = COUNT($jobs);

        $graph['graph']['title'] = JText::_('Latest Jobs');
        $graph['line_chart_horizontal']['title'] = "['".JText::_('Date')."'";
        for ($k=0; $k < $noofjobs; $k++) { 
            $graph['line_chart_horizontal']['title'] .= ",'".$jobs[$k]->title."'";
        }
        $graph['line_chart_horizontal']['title'] .= "]";
        if($noofjobs == 0){
            $graph['line_chart_horizontal']['title'] = null;
        }
        $graph['line_chart_horizontal']['data'] = '';
        for ($i = 6; $i >= 0; $i--) {
            $day = date('Y-m-d', strtotime(date('Y-m-d').' -'.$i.' days'));
            $checkdate = JHtml::_('date', strtotime(date('Y-m-d')." -$i days"), $date_format);
            $applied_count = array();
            for ($j=0; $j < $noofjobs; $j++) { 
                $query = "SELECT COUNT(jobapp.id)
                            FROM `#__js_job_jobapply` AS jobapp
                            WHERE DATE(jobapp.apply_date) = '".$day."' 
                            AND jobapp.jobid = ".$jobs[$j]->id;
                $db->setQuery($query);
                $applied_count[$j] = $db->loadResult();
            }
            if($i != 6){
                $graph['line_chart_horizontal']['data'] .= ',';
            }
            $graph['line_chart_horizontal']['data'] .= "['".$checkdate."'";
            for ($k=0; $k < $noofjobs; $k++) { 
                $graph['line_chart_horizontal']['data'] .= ",".$applied_count[$k];
            }
            $graph['line_chart_horizontal']['data'] .= "]";
        }

        return $graph;
    }

    function getVisitorStatsForLineChart(){

        $db = $this->getDBO();

        $graph['graph']['title'] = "";
        $graph['line_chart_horizontal']['title'] = "['".JText::_('Month')."','".JText::_('Jobs')."','".JText::_('Expired Jobs')."','".JText::_('Resumes')."','".JText::_('Resume Applied')."']";
        $graph['line_chart_horizontal']['data'] = '';

        // *Query positions matters
        for ($i=6; $i >=1 ; $i--) {
            $total_res = array();
            $display_date = date('M-Y',strtotime(' -'.$i.' months'));
            $month = date('Y-m',strtotime(' -'.$i.' months'));
            //*
            $query = "SELECT COUNT(id) FROM `#__js_job_jobs` WHERE status = 1 AND startpublishing <= CURDATE() AND stoppublishing > CURDATE()  AND DATE_FORMAT(created, '%Y-%m') = ".$db->Quote($month);
            $db->setQuery($query);
            $total_res[] = $db->loadResult();
            //*
            $query = "SELECT COUNT(id) FROM `#__js_job_jobs` WHERE stoppublishing <= CURDATE() AND DATE_FORMAT(stoppublishing, '%Y-%m') = ".$db->Quote($month);
            $db->setQuery($query);
            $total_res[] = $db->loadResult();
            //*
            $query = "SELECT COUNT(id) FROM `#__js_job_resume` 
                WHERE DATE_FORMAT(created, '%Y-%m') = ".$db->Quote($month);
            $db->setQuery($query);
            $total_res[] = $db->loadResult();

            //*
            $query = "SELECT COUNT(id) FROM `#__js_job_jobapply` 
                WHERE DATE_FORMAT(apply_date, '%Y-%m') = ".$db->Quote($month);
            $db->setQuery($query);
            $total_res[] = $db->loadResult();

            if($i != 6){
                $graph['line_chart_horizontal']['data'] .= ',';
            }
            $graph['line_chart_horizontal']['data'] .= "['".$display_date."'";
            foreach ($total_res as $res) {
                $graph['line_chart_horizontal']['data'] .= ",".$res;
            }
            $graph['line_chart_horizontal']['data'] .= "]";
        }
        return $graph;
    }

    function getAppliedResumeExperienceForPieChart(){
        $db = $this->getDBO();
        $curdate = date('Y-m-d');
        $query = "SELECT COUNT(resume.id) as total,exp.title
                    FROM `#__js_job_resume` AS resume
                    JOIN `#__js_job_experiences` AS exp on exp.id = resume.experienceid
                    WHERE resume.id IN (
                        SELECT distinct cvid FROM `#__js_job_jobapply` AS jobapp
                        JOIN `#__js_job_jobs` AS job ON jobapp.jobid=job.id 
                        WHERE DATE(job.startpublishing) <= DATE(".$db->Quote($curdate).") AND DATE(job.stoppublishing) >= DATE(".$db->Quote($curdate).")
                    )
                    GROUP BY resume.experienceid";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        $graph['graph']['title'] = JText::_('Experience');
        $graph['pie_chart_horizontal']['title'] = JText::_('Applied resume by experience');
        $graph['pie_chart_horizontal']['data'] = '';

        $i= 0;
        foreach($result AS $data){
        $title = $data->title;
            if($i != 0){
                $graph['pie_chart_horizontal']['data'] .= ',';
            }
            $graph['pie_chart_horizontal']['data'] .= " ['".$title."',".$data->total." ] ";
            $i = 1;
        }

        return $graph;
    }

    function getMyStats_Employer($uid) {
        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;

        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        $ispackagerequired = 1;
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }
        if ($newlisting_required_package == 0) {
            $ispackagerequired = 0;
        }


        $db = $this->getDBO();
        $results = array();

        // companies
        $query = "SELECT package.companiesallow,package.jobsallow,package.featuredcompaines
                    ,package.goldcompanies,package.goldjobs,package.featuredjobs
                    FROM #__js_job_paymenthistory AS payment
                    JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
        $db->setQuery($query);
        $packages = $db->loadObjectList();
        if (empty($packages)) {
            $query = "SELECT package.id, package.resumeallow,package.title AS packagetitle, package.packageexpireindays, payment.id AS paymentid
                        , (TO_DAYS( CURDATE() ) - To_days( payment.created ) ) AS packageexpiredays
                       FROM `#__js_job_employerpackages` AS package
                       JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                       WHERE payment.uid = " . $uid . " 
                       AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";

            $query = "SELECT package.id, package.companiesallow,package.jobsallow,package.featuredcompaines
                    ,package.goldcompanies,package.goldjobs,package.featuredjobs
                    FROM #__js_job_paymenthistory AS payment
                    JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $packagedetail = $db->loadObjectList();

            $results[12] = false;
            $results[13] = $packagedetail;

            $query = "SELECT package.resumeallow,package.coverlettersallow,package.featuredresume,package.goldresume
                    FROM #__js_job_employerpackages AS package
                    JOIN #__js_job_paymenthistory AS payment ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND payment.transactionverified = 1 AND payment.status = 1";
            $query = "SELECT package.id, package.companiesallow,package.jobsallow,package.featuredcompaines
                    ,package.goldcompanies,package.goldjobs,package.featuredjobs
                    FROM #__js_job_paymenthistory AS payment
                    JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $packages = $db->loadObjectList();
        }
        $companiesunlimited = 0;
        $unlimitedjobs = 0;
        $unlimitedfeaturedcompaines = 0;
        $unlimitedgoldcompanies = 0;
        $unlimitedgoldjobs = 0;
        $unlimitedfeaturedjobs = 0;
        $jobsallow = 0;
        $companiesallow = 0;
        $goldcompaniesallow = 0;
        $goldjobsallow = 0;
        $featuredcompainesallow = 0;
        $featuredjobsallow = 0;
        if (!empty($packages)) {
            foreach ($packages AS $package) {
                if ($companiesunlimited == 0) {
                    if ($package->companiesallow != -1) {
                        $companiesallow = $companiesallow + $package->companiesallow;
                    } else
                        $companiesunlimited = 1;
                }
                if ($unlimitedjobs == 0) {
                    if ($package->jobsallow != -1) {
                        $jobsallow = $jobsallow + $package->jobsallow;
                    } else
                        $unlimitedjobs = 1;
                }
                if ($unlimitedfeaturedcompaines == 0) {
                    if ($package->featuredcompaines != -1) {
                        $featuredcompainesallow = $featuredcompainesallow + $package->featuredcompaines;
                    } else
                        $unlimitedfeaturedcompaines = 1;
                }
                if ($unlimitedgoldcompanies == 0) {
                    if ($package->goldcompanies != -1) {
                        $goldcompaniesallow = $goldcompaniesallow + $package->goldcompanies;
                    } else
                        $unlimitedgoldcompanies = 1;
                }
                if ($unlimitedgoldjobs == 0) {
                    if ($package->goldjobs != -1) {
                        $goldjobsallow = $goldjobsallow + $package->goldjobs;
                    } else
                        $unlimitedgoldjobs = 1;
                }
                if ($unlimitedfeaturedjobs == 0) {
                    if ($package->featuredjobs != -1) {
                        $featuredjobsallow = $featuredjobsallow + $package->featuredjobs;
                    } else
                        $unlimitedfeaturedjobs = 1;
                }
            }
        }

        //companies
        $query = "SELECT COUNT(company.id) FROM #__js_job_companies AS company WHERE  uid = " . $uid;
        $db->setQuery($query);
        $totalcompanies = $db->loadResult();

        //featured companies
        $query = "SELECT COUNT(id) FROM #__js_job_companies WHERE isfeaturedcompany=1 AND uid = " . $uid;
        $db->setQuery($query);
        $totalfeaturedcompanies = $db->loadResult();

        //featured companies expire
        $query = "SELECT COUNT(com.id) AS total_f_c_expire ,e_p.featuredcompaniesexpireindays 
                    FROM `#__js_job_companies` AS com
                    JOIN `#__js_job_employerpackages` AS e_p ON e_p.id=com.packageid 
                    WHERE DATE_ADD(com.startfeatureddate,INTERVAL e_p.featuredcompaniesexpireindays DAY) < CURDATE()
                    AND com.isfeaturedcompany=1 AND com.uid = " . $uid;
        $db->setQuery($query);
        $result = $db->loadObject();
        $totalfeaturedcompaniesexpire = $result->total_f_c_expire;

        //gold companies
        $query = "SELECT COUNT(id) FROM #__js_job_companies WHERE isgoldcompany=1 AND uid = " . $uid;
        $db->setQuery($query);
        $totalgoldcompanies = $db->loadResult();

        //Gold companies expire
        $query = "SELECT COUNT(com.id) AS total_g_c_expire ,e_p.goldcompaniesexpireindays 
                    FROM `#__js_job_companies` AS com
                    JOIN `#__js_job_employerpackages` AS e_p ON e_p.id=com.packageid 
                    WHERE DATE_ADD(com.startgolddate,INTERVAL e_p.goldcompaniesexpireindays DAY) < CURDATE()
                    AND com.isgoldcompany=1 AND com.uid = " . $uid;
        $db->setQuery($query);
        $result = $db->loadObject();
        $totalgoldcompaniesexpire = $result->total_g_c_expire;

        //jobs
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE uid = " . $uid;
        $db->setQuery($query);
        $totaljobs = $db->loadResult();

        //publishedjob
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE uid = " . $uid . " AND stoppublishing > CURDATE() ";
        $db->setQuery($query);
        $publishedjob = $db->loadResult();

        //expiredjob
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE uid = " . $uid . " AND stoppublishing < CURDATE() ";
        $db->setQuery($query);
        $expiredjob = $db->loadResult();


        //gold jobs
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE isgoldjob=1 AND uid = " . $uid;
        $db->setQuery($query);
        $totalgoldjobs = $db->loadResult();

        //publishedgoldjob
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE uid = " . $uid . " AND isgoldjob=1 AND stoppublishing > CURDATE() ";
        $db->setQuery($query);
        $publishedgoldjob = $db->loadResult();

        //expiregoldjob
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE uid = " . $uid . " AND isgoldjob=1 AND stoppublishing < CURDATE() ";
        $db->setQuery($query);
        $expiregoldjob = $db->loadResult();

        //featured jobs
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE isfeaturedjob=1 AND uid = " . $uid;
        $db->setQuery($query);
        $totalfeaturedjobs = $db->loadResult();

        //publishedfeaturedjob
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE isfeaturedjob=1 AND uid = " . $uid . " AND isfeaturedjob=1 AND stoppublishing > CURDATE() ";
        $db->setQuery($query);
        $publishedfeaturedjob = $db->loadResult();

        //expirefeaturedjob
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE isfeaturedjob=1 AND uid = " . $uid . " AND isfeaturedjob=1 AND stoppublishing < CURDATE() ";
        $db->setQuery($query);
        $expirefeaturedjob = $db->loadResult();


        if ($companiesunlimited == 0)
            $results[0] = $companiesallow;
        elseif ($companiesunlimited == 1)
            $results[0] = -1;
        $results[1] = $totalcompanies;

        if ($unlimitedjobs == 0)
            $results[2] = $jobsallow;
        elseif ($unlimitedjobs == 1)
            $results[2] = -1;
        $results[3] = $totaljobs;
        $results[14] = $publishedjob;
        $results[15] = $expiredjob;

        if ($unlimitedfeaturedcompaines == 0)
            $results[4] = $featuredcompainesallow;
        elseif ($unlimitedfeaturedcompaines == 1)
            $results[4] = -1;
        $results[5] = $totalfeaturedcompanies;

        if ($unlimitedgoldcompanies == 0)
            $results[6] = $goldcompaniesallow;
        elseif ($unlimitedgoldcompanies == 1)
            $results[6] = -1;
        $results[7] = $totalgoldcompanies;

        if ($unlimitedgoldjobs == 0)
            $results[8] = $goldjobsallow;
        elseif ($unlimitedgoldjobs == 1)
            $results[8] = -1;
        $results[9] = $totalgoldjobs;
        $results[16] = $publishedgoldjob;
        $results[17] = $expiregoldjob;

        if ($unlimitedfeaturedjobs == 0)
            $results[10] = $featuredjobsallow;
        elseif ($unlimitedfeaturedjobs == 1)
            $results[10] = -1;
        $results[11] = $totalfeaturedjobs;
        $results[18] = $publishedfeaturedjob;
        $results[19] = $expirefeaturedjob;

        $results[20] = $ispackagerequired;
        $results[21] = $totalgoldcompaniesexpire;
        $results[22] = $totalfeaturedcompaniesexpire;
        return $results;
    }

    function getMultiSelectEdit($id, $for) {
        if (!is_numeric($id))
            return false;
        $db = JFactory::getDbo();
        $config = $this->getJSModel('configurations')->getConfigByFor('default');
        $query = "SELECT city.id AS id,city.latitude, city.longitude, city.cityName AS cname, state.name AS statename, country.name AS countryname ";
        switch ($for) {
            case 1:
                $query .= " FROM `#__js_job_jobcities` AS mcity";
                break;
            case 2:
                $query .= " FROM `#__js_job_companycities` AS mcity";
                break;
            case 3:
                $query .= " FROM `#__js_job_jobalertcities` AS mcity";
                break;
        }
        $query .=" JOIN `#__js_job_cities` AS city on city.id=mcity.cityid
		  JOIN `#__js_job_countries` AS country on city.countryid=country.id
		  LEFT JOIN `#__js_job_states` AS state on city.stateid=state.id";
        switch ($for) {
            case 1:
                $query .= " WHERE mcity.jobid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
            case 2:
                $query .= " WHERE mcity.companyid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
            case 3:
                $query .= " WHERE mcity.alertid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
        }

        $db->setQuery($query);
        $result = $db->loadObjectList();
          switch ($config['defaultaddressdisplaytype']) {
            case 'csc'://City, State, Country
                foreach ($result as $city) {
                    $cityname = JText::_($city->cname);
                    if($city->statename != ''){
                        $cityname .= ','. JText::_($city->statename);
                    }
                    $cityname .= ','. JText::_($city->countryname);
                    $city->name = $cityname;
                }
                break;
            case 'cs'://City, State
                foreach ($result as $city) {
                    $cityname = JText::_($city->cname);
                    if($city->statename != ''){
                        $cityname .= ','. JText::_($city->statename);
                    }
                    $city->name = $cityname;
                }
                
                break;
            case 'cc'://City, Country
                foreach ($result as $city) {
                    $cityname = JText::_($city->cname);
                    $cityname .= ','. JText::_($city->countryname);
                    $city->name = $cityname;
                }
                
                break;
            case 'c'://city by default select for each case
                foreach ($result as $city) {
                    $cityname = JText::_($city->cname);
                    if($city->statename != ''){
                        $cityname .= ','. JText::_($city->statename);
                    }
                    $cityname .= ','. JText::_($city->countryname);
                    $city->name = $cityname;
                }
                break;
        }
        $json_array = json_encode($result);
        if (empty($json_array))
            return null;
        else
            return $json_array;
    }

    function userCanRegisterAsEmployer() {
        $roleconfig = $this->getJSModel('configurations')->getConfigByFor('default');
        if ($roleconfig['showemployerlink'] == 1){
            return true;
        }else{
            return false;
        }
    }

    function isPluginEnabledFunc($val){
        $db = JFactory::getDbo();
        if( preg_match('/.+'.$this->getJSModel('common')->b64ForDecode("YW05dGMyOWphV0Zz").'.+/', $val) ){
            if(!JComponentHelper::isEnabled('com_community'))  return false;
            if(!JPluginHelper::isEnabled('community','jsjobs')) return false;
            if(!$this->getJSModel('configurations')->getConfigValue('isenabled_jomsocial')) return false;
            return $this->getJSModel(VIRTUEMARTJSJOB)->prepareJomSocial();
        }elseif( preg_match('/.+'.$this->getJSModel('common')->b64ForDecode("ZG1seWRIVmxiV0Z5").'.+/', $val) ){
            if(!JComponentHelper::isEnabled('com_virtuemart'))  return false;
            if(!JPluginHelper::isEnabled('vmextended','jsjobs')) return false;
            if(!$this->getJSModel('configurations')->getConfigValue('isenabled_virtuemart')) return false;
            return $this->getJSModel(VIRTUEMARTJSJOB)->prepareVirtueMart();
        }
    }

    function jmsGetStats($userid){
        $db = JFactory::getDbo();
        $query = "SELECT COUNT(id) FROM `#__js_job_companies` WHERE uid=".$userid." AND status=1";
        $db->setQuery($query);
        $ncompany = $db->loadResult();
        $query = "SELECT COUNT(id) FROM `#__js_job_jobs` WHERE uid=".$userid." AND status=1";
        $db->setQuery($query);
        $njob = $db->loadResult();
        return compact('ncompany','njob');
    }

    function jmGetJobs($userid,$limit=-1){
        $db = JFactory::getDbo();
        $query = "SELECT job.id,job.title,jobtype.title AS jobtype,jobstatus.title AS jobstatus,job.companyid,
        CONCAT(job.alias,'-',job.id) jobaliasid,company.name AS company,company.logofilename
        FROM `#__js_job_jobs` job
        JOIN `#__js_job_companies` AS company ON job.companyid = company.id
        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
        WHERE job.uid=".$userid." AND job.status=1";
        if($limit != -1)
            $query .= ' LIMIT '.$limit;
        $db->setQuery($query);
        $joblist = $db->loadObjectList();
        return $joblist;
    }

    function jmGetCompanies($userid,$limit=-1){
        $db = JFactory::getDbo();
        $query = "SELECT company.id,company.name,category.cat_title AS category,company.city,company.logofilename,
        CONCAT(company.alias,'-',company.id) AS companyaliasid
        FROM `#__js_job_companies` company
        JOIN `#__js_job_categories` category ON company.category = category.id
        WHERE company.uid=".$userid." AND company.status=1";
        if($limit != -1)
            $query .= ' LIMIT '.$limit;
        $db->setQuery($query);
        $companylist = $db->loadObjectList();
        return $companylist;
    }

    function jmGetCompanyJobs($userid,$companyid,$limit=-1){
        $db = JFactory::getDbo();
        $query = "SELECT job.id,job.title,jobtype.title AS jobtype,jobstatus.title AS jobstatus,CONCAT(job.alias,'-',job.id) jobaliasid
        FROM `#__js_job_jobs` job
        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
        WHERE job.uid=".$userid." AND job.companyid=".$companyid." AND job.status=1";
        if($limit != -1)
            $query .= ' LIMIT '.$limit;
        $db->setQuery($query);
        $joblist = $db->loadObjectList();
        return $joblist;   
    }

    function jmGetCompanyIds($userid){
        $db = JFactory::getDbo();
        $query = "SELECT id FROM `#__js_job_companies` company WHERE company.uid=".$userid." AND company.status=1";
        $db->setQuery($query);
        $companyidlist = $db->loadColumn();
        return $companyidlist;   
    }
}
?>
