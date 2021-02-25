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
jimport('joomla.html.parameter');

class JSJobsModelJobshortlist extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
    }

    function storeJobShortList($data) {
        $row = $this->getTable('jobshortlist');
        $db = $this->getDBO();        
        $sharing = ($this->_client_auth_key != '') ? 1 : 0;
        $data['sharing'] = $sharing;
        $result = array();
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return 2;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        //save id in cookie
        if (!isset($data['uid'])) {
            if (isset($_COOKIE['jsjobshortlistid']))
                $totalid = count($_COOKIE['jsjobshortlistid']);
            else
                $totalid = 0;
            $nextid = $totalid + 1;
            $cookie = new JInputCookie;
            $cookiedata = json_encode(array('id'=>$row->id,'sharing'=>$sharing));
            $cookie->set('jsjobshortlistid[' . $nextid . ']', $cookiedata, 0, '/', null, false, true);
        }
        return true;
    }

    function checkJobShortlist($jobid, $shortlistarray) {
        $user = JFactory::getUser();
        $ids = $this->parseShortListIds($shortlistarray);
        $wherequery = '';
        $canrun = 0;
        if ($user->guest) {
            if (!empty($shortlistarray)) {
                $canrun = 1;
                $ids = $this->parseShortListIds($shortlistarray);
                $wherequery = " AND id IN ( " . implode(",", $ids) . " ) ";
            }
        } else {
            $canrun = 1;
            if (!empty($shortlistarray)) {
                $ids = $this->parseShortListIds($shortlistarray);
                $wherequery = " AND ( id IN ( " . implode(",", $ids) . " ) OR uid = " . $user->id . " ) ";
            } else {
                $wherequery = " AND uid = " . $user->id;
            }
        }
        if ($canrun == 1) {
            $db = $this->getDBO();
            if (!is_numeric($jobid))
                return false;
            $query = "SELECT * FROM `#__js_job_jobshortlist` WHERE jobid = " . $jobid . $wherequery;
            $db->setQuery($query);
            $shortlistdata = $db->loadObject();
        } else
            $shortlistdata = false;
        if (!empty($shortlistdata))
            return $shortlistdata;
        return false;
    }   

    function parseShortListIds($shortlistarray) {
        $ids = false;
        foreach ($shortlistarray AS $obj) {
            $obj = (array)json_decode($obj);
            if($this->_client_auth_key != ''){ // sharing is on
                if($obj['sharing'] == 1)
                    $ids[] = (int) $obj['id'];
            }else{ // sharing is off
                if($obj['sharing'] == 0)
                    $ids[] = (int) $obj['id'];
            }            
        }
        return $ids;
    }

    function getShortlistedJobs($uid, $shortlistarray, $limitstart, $limit) {
        $user = JFactory::getUser();
        $db = $this->getDBO();
        $wherequery = '';
        $result = array();
        $slJobsArray = array();

        if ($user->guest) {
            if (!empty($shortlistarray)) {
                $ids = $this->parseShortListIds($shortlistarray);
                $wherequery = " AND jobshortlist.id IN ( " . implode(",", $ids) . " ) ";
            }else{ // Visitor is not eligble to view shortlisted jobs
                return false;            
            }
        } else {
            if (!empty($shortlistarray)) {
                $ids = $this->parseShortListIds($shortlistarray);
                $wherequery = " AND ( jobshortlist.id IN ( " . implode(",", $ids) . " ) OR jobshortlist.uid = " . $user->id . " ) ";
            } else {
                $wherequery = " AND jobshortlist.uid = " . $user->id;
            }
        }
        $query = "SELECT COUNT(job.id)
                FROM `#__js_job_jobs` AS job
                JOIN `#__js_job_jobshortlist` AS jobshortlist ON job.id= jobshortlist.jobid
                JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                WHERE job.id = jobshortlist.jobid AND job.status = 1 AND DATE(job.stoppublishing) >= CURDATE()";
        $query .= $wherequery;
        $db->setQuery($query);
        $totaljobs = $db->loadResult();

        $query = "SELECT DISTINCT job.params,job.id,job.title,job.noofjobs,job.isgoldjob,job.isfeaturedjob,job.joblink,job.jobapplylink,job.city ,company.name AS companyname, company.id AS companyid, company.id AS localcompanyid ,jobshortlist.id AS sljobid, jobshortlist.uid AS sljobuid, jobshortlist.comments AS comment, jobshortlist.rate AS rate
                ,jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle ,country.name AS countryname,city.cityName AS cityname ,education.title AS educationtitle, experience.title AS exptitle, category.cat_title AS categorytitle
                ,subcategory.title AS subcattitle, currency.title AS currencytitle, currency.symbol AS currencysymbol ,salaryrangefrom.rangestart AS salaryfrom, salaryrangeto.rangeend AS salaryto, salaryrangetype.title AS salaytype ,salaryrangetype.title AS salrangetitle, CONCAT(company.alias,'-',companyid) AS companyaliasid, CONCAT(job.alias,'-',job.id) AS jobaliasid, company.logofilename AS companylogo, (TO_DAYS( CURDATE() ) - To_days( job.startpublishing )) AS jobdays
                
                FROM `#__js_job_jobs` AS job
                JOIN `#__js_job_jobshortlist` AS jobshortlist ON job.id= jobshortlist.jobid
                LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                LEFT JOIN `#__js_job_heighesteducation` AS education ON job.educationid = education.id
                LEFT JOIN `#__js_job_experiences` AS experience ON job.experienceid = experience.id
                LEFT JOIN `#__js_job_categories` AS category ON job.jobcategory = category.id
                LEFT JOIN `#__js_job_subcategories` AS subcategory ON job.subcategoryid = subcategory.id
                LEFT JOIN `#__js_job_countries` AS country ON job.country = country.id
                LEFT JOIN `#__js_job_cities` AS city ON job.city = city.id
                LEFT JOIN `#__js_job_currencies` AS currency ON job.currencyid = currency.id
                LEFT JOIN `#__js_job_salaryrange` AS salaryrangefrom ON job.salaryrangefrom = salaryrangefrom.id
                LEFT JOIN `#__js_job_salaryrange` AS salaryrangeto ON job.salaryrangeto = salaryrangeto.id
                LEFT JOIN `#__js_job_salaryrangetypes` AS salaryrangetype ON job.salaryrangetype = salaryrangetype.id
                WHERE job.id = jobshortlist.jobid AND job.status = 1 AND DATE(job.stoppublishing) >= CURDATE()";

        $query .= $wherequery;
        $query .= ' GROUP BY job.id';
        $db->setQuery($query, $limitstart, $limit);
        $slJobsArray = $db->loadObjectlist();

        foreach ($slJobsArray AS $jobdata) {
            $jobdata->location = $this->getJSModel('cities')->getLocationDataForView($jobdata->city);
        }

        $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(2);
        $fieldsordering = $this->getJSModel('customfields')->parseFieldsOrderingForView($fieldsordering);

        $result[0] = $slJobsArray;
        $result[1] = $fieldsordering;
        $result[2] = $totaljobs;
        return $result;
    }

    function removeJobShortlist($id) {
        if (!is_numeric($id))
            return false;
        $db = $this->getDBO();
        $row = $this->getTable('jobshortlist');
        if (!$row->delete($id)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        foreach ($_COOKIE['jsjobshortlistid'] AS $key => $value) {
            if ($value == $id) {
                JInputCookie::set('jsjobshortlistid[' . $key . ']', $row->id, time() - 3600, '/', null, false, true);
            }
        }
        return true;
    }

}

?>
