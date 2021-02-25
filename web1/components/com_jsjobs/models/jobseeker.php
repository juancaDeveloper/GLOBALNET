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

class JSJobsModelJobSeeker extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getControlPanelData(){
        $db = $this->getDBO();
        $results = array();
        $user = JFactory::getUser();
        $uid = $user->id;
        $isguest = $user->guest;
        $role = $this->getJSModel('userrole')->getUserRole($uid);
        if($role)
            $role = $role->rolefor; //1 for emp 2 for jobseeker


        $localwork = "";
        if((!$isguest) AND $role == 2) {
            $query = "SELECT job.id AS jobid,job.title AS jobtitle,cat.cat_title,job.isgoldjob,job.isfeaturedjob,CONCAT(job.alias,'-',job.id) AS jobaliasid
                        , app.id AS appid,app.photo, app.application_title, app.email_address
                        , apply.action_status,city.id AS cityid
                        FROM `#__js_job_jobapply` AS apply
                        JOIN `#__js_job_jobs` AS job ON job.id = apply.jobid
                        JOIN `#__js_job_resume` AS app ON app.id = apply.cvid
                        JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id
                        LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = apply.cvid LIMIT 1 )
                        
                        WHERE app.uid = ".$uid." ORDER BY apply.apply_date DESC LIMIT 3";
            $db->setQuery($query);
            $results['applied_resume'] = $db->loadObjectList();
            $localwork = $results['applied_resume'];

            foreach ($localwork as $row ) {
                $row->location = $this->getJSModel('cities')->getLocationDataForView($row->cityid);
            }
        }
        $results['applied_resume'] = $localwork;
        

        $criteria = "";
        if((!$isguest) AND $role == 2) {
            $query ="SELECT job_category,jobtype,job_subcategory FROM `#__js_job_resume` WHERE uid = $uid AND status = 1 ORDER BY created DESC LIMIT 1";
            $db->setQuery($query);
            $resume = $db->loadObject();

            $resume_categoryid = null;
            $resume_subcategoryid = null;
            $resume_jobtypeid = null;
            $subquery = "";

            if(!empty($resume)){
                $resume_categoryid = $resume->job_category;
                $resume_subcategoryid = $resume->job_subcategory;
                $resume_jobtypeid = $resume->jobtype;
            }
            if($resume_categoryid){
                $subquery = " AND job.jobcategory = ".$resume_categoryid;
                $criteria = "&cat=".$resume_categoryid;
            }   
            if($resume_subcategoryid){
                $subquery .= " AND job.subcategoryid = ".$resume_subcategoryid;
                $criteria .= "&jobsubcat=".$resume_subcategoryid;
            }   
            if($resume_jobtypeid){
                $subquery .= " AND job.jobtype = ".$resume_jobtypeid;
                $criteria .= "&jt=".$resume_jobtypeid;
            }   

            $query = "SELECT job.id AS jobid,job.title AS jobtitle,job.city
                        ,CONCAT(job.alias,'-',job.id) AS jobaliasid ,job.isgoldjob,job.isfeaturedjob
                        ,company.id AS companyid,company.logofilename
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                        WHERE job.status = 1 AND DATE(job.startpublishing) <= CURDATE() AND DATE(job.stoppublishing) > CURDATE()
                        $subquery
                        ORDER BY job.created DESC LIMIT 3";
            $db->setQuery($query);
            $results['suggested_jobs'] = $db->loadObjectList();
            $localvar = $results['suggested_jobs'];
            foreach ($localvar as $key) {
                $key->location = $this->getJSModel('cities')->getLocationDataForView($key->city);
            }
            $results['suggested_jobs'] = $localvar;
        }else{
            $query = "SELECT job.id AS jobid,job.title AS jobtitle,job.city
                    ,CONCAT(job.alias,'-',job.id) AS jobaliasid ,job.isgoldjob,job.isfeaturedjob
                    ,company.id AS companyid,company.logofilename
                    FROM `#__js_job_jobs` AS job
                    JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                    WHERE DATE(job.startpublishing) <= CURDATE() AND DATE(job.stoppublishing) > CURDATE() AND job.status = 1
                    ORDER BY job.created DESC LIMIT 3";
            $db->setQuery($query);
            $results['suggested_jobs'] = $db->loadObjectList();            
            $localvar = $results['suggested_jobs'];
            foreach ($localvar as $key) {
                $key->location = $this->getJSModel('cities')->getLocationDataForView($key->city);
            }
            $results['suggested_jobs'] = $localvar;

        }
        $results['suggested_jobs_criteria'] = $criteria;
        $results['line_chart'] = $this->getLineChartData();

        return $results;
    }

    function getLineChartData(){

        $db = $this->getDBO();

        $graph['graph']['title'] = "";
//        $graph['line_chart_horizontal']['title'] = "['".JText::_('Month')."','".JText::_('Active Jobs')."']";
        $graph['line_chart_horizontal']['title'] = '["'.JText::_('Month').'","'.JText::_('Active Jobs').'"]';
        $graph['line_chart_horizontal']['data'] = '';

        for ($i=5; $i >= 0 ; $i--) {
            $display_date = date('M-Y',strtotime(' -'.$i.' months'));
            $month = date('Y-m',strtotime(' -'.$i.' months'));
            $query = "SELECT COUNT(id) FROM `#__js_job_jobs` WHERE status = 1 AND DATE_FORMAT(startpublishing, '%Y-%m') = ".$db->Quote($month);
            $db->setQuery($query);
            $totalactivejobs = $db->loadResult();

            if($i != 5){
                $graph['line_chart_horizontal']['data'] .= ',';
            }
            $graph['line_chart_horizontal']['data'] .= "['".$display_date."'";
            $graph['line_chart_horizontal']['data'] .= ",".$totalactivejobs;
            $graph['line_chart_horizontal']['data'] .= "]";
        }
        return $graph;
    }

    function getMyStats_JobSeeker($uid) {
        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;

        $db = $this->getDBO();
        $results = array();
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        $ispackagerequired = 1;
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'js_newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }
        if ($newlisting_required_package == 0) {
            $ispackagerequired = 0;
        }
        // resume
        $query = "SELECT package.resumeallow,package.coverlettersallow,package.featuredresume,package.goldresume
                    FROM #__js_job_jobseekerpackages AS package
                    JOIN #__js_job_paymenthistory AS payment ON (package.id = payment.packageid AND payment.packagefor=2 )
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
        $db->setQuery($query);
        $packages = $db->loadObjectList();
        if (empty($packages)) {
            $query = "SELECT package.id, package.resumeallow,package.title AS packagetitle, package.packageexpireindays, payment.id AS paymentid
                        , (TO_DAYS( CURDATE() ) - To_days( payment.created ) ) AS packageexpiredays
                       FROM `#__js_job_jobseekerpackages` AS package
                       JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=2 )
                       WHERE payment.uid = " . $uid . " 
                       AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";
            $db->setQuery($query);
            $packagedetail = $db->loadObjectList();

            $results[8] = false;
            $results[9] = $packagedetail;

            $query = "SELECT package.resumeallow,package.coverlettersallow,package.featuredresume,package.goldresume
                    FROM #__js_job_jobseekerpackages AS package
                    JOIN #__js_job_paymenthistory AS payment ON (package.id = payment.packageid AND payment.packagefor=2)
                    WHERE payment.uid = " . $uid . "
                    AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $packages = $db->loadObjectList();
        }
        $unlimitedresume = 0;
        $unlimitedfeaturedresume = 0;
        $unlimitedgoldresume = 0;
        $unlimitedcoverletters = 0;
        $resumeallow = 0;
        $featuredresumeallow = 0;
        $goldresumeallow = 0;
        $coverlettersallow = 0;

        foreach ($packages AS $package) {
            if ($unlimitedresume == 0) {
                if ($package->resumeallow != -1) {
                    $resumeallow = $resumeallow + $package->resumeallow;
                } else
                    $unlimitedresume = 1;
            }
            if ($unlimitedfeaturedresume == 0) {
                if ($package->featuredresume != -1) {
                    $featuredresumeallow = $featuredresumeallow + $package->featuredresume;
                } else
                    $unlimitedfeaturedresume = 1;
            }
            if ($unlimitedgoldresume == 0) {
                if ($package->goldresume != -1) {
                    $goldresumeallow = $goldresumeallow + $package->goldresume;
                } else
                    $unlimitedgoldcompanies = 1;
            }
            if ($unlimitedcoverletters == 0) {
                if ($package->coverlettersallow != -1) {
                    $coverlettersallow = $coverlettersallow + $package->coverlettersallow;
                } else
                    $unlimitedcoverletters = 1;
            }
        }

        //resume
        $query = "SELECT COUNT(id) FROM #__js_job_resume WHERE  uid = " . $uid;
        $db->setQuery($query);
        $totalresume = $db->loadResult();

        //featured resume
        $query = "SELECT COUNT(id) FROM #__js_job_resume WHERE isfeaturedresume=1 AND uid = " . $uid;
        $db->setQuery($query);
        $totalfeaturedresume = $db->loadResult();

        //gold resume
        $query = "SELECT COUNT(id) FROM #__js_job_resume WHERE isgoldresume=1 AND uid = " . $uid;
        $db->setQuery($query);
        $totalgoldresume = $db->loadResult();

        //cover letter
        $query = "SELECT COUNT(id) FROM #__js_job_coverletters WHERE uid = " . $uid;
        $db->setQuery($query);
        $totalcoverletters = $db->loadResult();


        if ($unlimitedresume == 0)
            $results[0] = $resumeallow;
        elseif ($unlimitedresume == 1)
            $results[0] = -1;

        $results[1] = $totalresume;

        if ($unlimitedfeaturedresume == 0)
            $results[2] = $featuredresumeallow;
        elseif ($unlimitedfeaturedresume == 1)
            $results[2] = -1;
        $results[3] = $totalfeaturedresume;

        if ($unlimitedgoldresume == 0)
            $results[4] = $goldresumeallow;
        elseif ($unlimitedgoldresume == 1)
            $results[4] = -1;
        $results[5] = $totalgoldresume;

        if ($unlimitedcoverletters == 0)
            $results[6] = $coverlettersallow;
        elseif ($unlimitedcoverletters == 1)
            $results[6] = -1;
        $results[7] = $totalcoverletters;
        $results[10] = $ispackagerequired;

        return $results;
    }

    function jmGetResumes($userid,$limit=-1){
        $db = JFactory::getDbo();
        $query = "SELECT resume.id,resume.application_title,category.cat_title AS category,jobtype.title AS jobtype,
        CONCAT(resume.alias,'-',resume.id) AS resumealiasid,resume.photo
        FROM `#__js_job_resume` resume
        JOIN `#__js_job_categories` category ON category.id = resume.job_category
        LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
        WHERE resume.uid=".$userid." AND resume.status = 1 ";
        if($limit != -1)
            $query .= ' LIMIT '.$limit;
        $db->setQuery($query);
        $resumelist = $db->loadObjectList();
        return $resumelist;
    }

}
?>    
