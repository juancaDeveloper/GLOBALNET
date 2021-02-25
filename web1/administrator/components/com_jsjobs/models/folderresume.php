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

class JSJobsModelFolderresume extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function storeFolderResume($data) {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $row = $this->getTable('folderresume');
        $curdate = date('Y-m-d H:i:s');
        $data['created'] = $curdate;
        $jobid = $data['jobid'];
        $resumeid = $data['resumeid'];
        $folderid = $data['folderid'];
        if(! $folderid)
            return 6;
        if ($this->resumeFolderValidation($jobid, $resumeid, $folderid))
            return 3;
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 2;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        return true;
    }

    function resumeFolderValidation($jobid, $resumeid, $folderid) {
        $db = JFactory:: getDBO();
        if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
            return false;
        if ((is_numeric($resumeid) == false) || ($resumeid == 0) || ($resumeid == ''))
            return false;
        if ((is_numeric($folderid) == false) || ($folderid == 0) || ($folderid == ''))
            return false;
        $query = "SELECT COUNT(id) FROM #__js_job_folderresumes
		WHERE jobid = " . $jobid . " AND resumeid =" . $resumeid . " AND folderid = " . $folderid;
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function getFolderResume($folderid, $searchname, $searchjobtype, $limitstart, $limit) {
        if (is_numeric($folderid) == false)
            return false;
        if ($searchjobtype)
            if (is_numeric($searchjobtype) == false)
                return false;
        $db = JFactory::getDBO();
        $result = array();

        $query = "SELECT COUNT(fres.id) 
                    FROM `#__js_job_resume` AS app
                    JOIN `#__js_job_jobapply` AS apply  ON apply.cvid = app.id
                    LEFT JOIN  `#__js_job_folderresumes` AS fres ON (app.id=fres.resumeid AND apply.jobid=fres.jobid)
                    WHERE fres.folderid = " . $folderid;

        if ($searchname) {
            $query .= " AND (";
            $query .= " LOWER(app.first_name) LIKE " . $db->Quote('%' . $searchname . '%');
            $query .= " OR LOWER(app.last_name) LIKE " . $db->Quote('%' . $searchname . '%');
            $query .= " OR LOWER(app.middle_name) LIKE " . $db->Quote('%' . $searchname . '%');
            $query .= " )";
        }
        if ($searchjobtype)
            $query .= " AND app.jobtype = " . $searchjobtype;

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT  apply.comments,apply.id,apply.jobid,cat.cat_title ,apply.apply_date, jobtype.title AS jobtypetitle
                        , app.id AS appid, app.first_name, app.last_name, app.email_address, app.jobtype,app.gender
                        ,app.total_experience, app.jobsalaryrange, salary.rangestart, salary.rangeend, rating.rating,rating.id AS ratingid                        
                        ,country.name AS countryname,state.name AS statename
                        ,city.cityName AS cityname,currency.symbol

                        FROM `#__js_job_resume` AS app
                        LEFT JOIN `#__js_job_jobtypes` AS jobtype ON app.jobtype = jobtype.id
                        LEFT JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id
                        JOIN `#__js_job_jobapply` AS apply  ON apply.cvid = app.id
                        LEFT JOIN  `#__js_job_resumerating` AS rating ON (app.id=rating.resumeid AND apply.jobid=rating.jobid)
                        LEFT JOIN  `#__js_job_salaryrange` AS salary ON app.jobsalaryrange=salary.id
                        LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = app.currencyid 	 		
                        LEFT JOIN  `#__js_job_folderresumes` AS fres ON (app.id=fres.resumeid AND apply.jobid=fres.jobid)
                        LEFT JOIN `#__js_job_countries` AS country ON country.id = (SELECT address.address_country FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = app.id ORDER BY address.created DESC LIMIT 1)
                        LEFT JOIN `#__js_job_states` AS state ON state.id = (SELECT address.address_state FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = app.id ORDER BY address.created DESC LIMIT 1)
                        LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = app.id ORDER BY address.created DESC LIMIT 1)
		WHERE fres.folderid = " . $folderid;
        if ($searchname) {
            $query .= " AND (";
            $query .= " LOWER(app.first_name) LIKE " . $db->Quote('%' . $searchname . '%');
            $query .= " OR LOWER(app.last_name) LIKE " . $db->Quote('%' . $searchname . '%');
            $query .= " OR LOWER(app.middle_name) LIKE " . $db->Quote('%' . $searchname . '%');
            $query .= " )";
        }
        if ($searchjobtype)
            $query .= " AND app.jobtype = " . $searchjobtype;

        $query .= " ORDER BY apply.apply_date DESC";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $lists = array();
        $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('Select Job Type'));

        if ($searchname)
            $lists['searchname'] = $searchname;
        if ($searchjobtype)
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', $searchjobtype);
        else
            $lists['jobtype'] = JHTML::_('select.genericList', $job_type, 'searchjobtype', 'class="inputbox" ' . 'onChange="document.adminForm.submit();"', 'value', 'text', '');

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

}

?>