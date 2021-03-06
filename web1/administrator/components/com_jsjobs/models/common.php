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

class JSJobsModelCommon extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;
    var $_options = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function b64ForEncode($string) {
        return base64_encode($string);
    }
    
    function b64ForDecode($string) {
        return base64_decode($string);
    }

    function removeSpecialCharacter($string) {
        $string = strip_tags($string, "");
        $string = preg_replace("/[@!*%^(){}?&$\\\\#\\/]+/", "", $string);        
        $string = preg_replace("/[@!*&$\\\\#\\/]+/", "", $string);
        //Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    function setDefaultForDefaultTable($id, $for) {
        if (is_numeric($id) == false)
            return false;
        $db = JFactory::getDBO();
        switch ($for) {
            case "jobtypes":
            case "jobstatus":
            case "shifts":
            case "heighesteducation":
            case "ages":
            case "careerlevels":
            case "experiences":
            case "salaryrange":
            case "salaryrangetypes":
            case "categories":
            case "subcategories": 
                
                if($for == 'categories' || $for == 'shifts' || $for == 'heighesteducation' || $for == 'jobstatus' || $for == 'jobtypes'){
                    $query = "SELECT COUNT(id) FROM `#__js_job_".$for."` WHERE id = ".$id." AND isactive = 1";
                }else{ 
                    $query = "SELECT COUNT(id) FROM `#__js_job_".$for."` WHERE id = ".$id." AND status = 1";
                }
                $db->setQuery($query);
                $result = $db->loadResult();
                if($result == 1){
                    $query = "UPDATE `#__js_job_" . $for . "` SET isdefault = 0 ";
                    $db->setQuery($query);
                    $db->Query();
                    $query = "UPDATE  `#__js_job_" . $for . "` SET isdefault=1 WHERE id=" . $id;
                    $db->setQuery($query);
                    if (!$db->Query()){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return false;
                }
                break;
        }
    }

    function makeFieldPublishUnpublish($id, $for, $status) {
        if (is_numeric($id) == false)
            return false;
        $db = JFactory::getDBO();
        if($for == 'currency'){
            $for = 'currencies';
        }
        switch ($for) {
            case "jobtypes":
            case "jobstatus":
            case "shifts":
            case "heighesteducation":
            case "ages":
            case "careerlevels":
            case "experiences":
            case "salaryrange":
            case "salaryrangetypes":
            case "categories":
            case "subcategories":
            case "currencies":
            
                if($status==1){
                    if($for == 'categories' || $for == 'shifts' || $for == 'heighesteducation' || $for == 'jobstatus' || $for == 'jobtypes'){
                        $query = "UPDATE `#__js_job_".$for."` SET isactive = 1 WHERE id = ".$id;
                    }else{ 
                        $query = "UPDATE `#__js_job_".$for."` SET status = 1 WHERE id = ".$id;
                    }
                    $db->setQuery($query);
                    if($db->Query()){
                        return 1;
                    }else{
                        return 2;
                    }
                }elseif($status==0){
                    $returnvar = $this->canUnpublishRecord($id, $for);
                    if($returnvar=='yes'){                    
                        if($for == 'categories' || $for == 'shifts' || $for == 'heighesteducation' || $for == 'jobstatus' || $for == 'jobtypes'){
                            $query = "UPDATE `#__js_job_".$for."` SET isactive = 0 WHERE id = ".$id;
                        }else{ 
                            $query = "UPDATE `#__js_job_".$for."` SET status = 0 WHERE id = ".$id;
                        }
                        $db->setQuery($query);
                        if($db->Query()){
                            return 1;
                        }else{
                            return 2;
                        }
                    }else{
                        return 3; // default cant be unpublish
                    }
                }
            break;
        }
        return false;
    }

    function canUnpublishRecord($id , $table){
        if(! is_numeric($id))
            return false;
        $db = JFactory::getDBO();
        switch ($table) {
            case "categories":
            case "jobtypes":
            case "jobstatus":
            case "shifts":
            case "heighesteducation":
            case "ages":
            case "careerlevels":
            case "experiences":
            case "salaryrange":
            case "salaryrangetypes":
            case "subcategories":
                $query = "SELECT isdefault FROM `#__js_job_".$table."` WHERE id = ".$id;
                $db->setQuery($query);
                $result = $db->loadObject();
                if($result->isdefault == 1){
                    return 'no';
                }else{
                    return 'yes';
                }
                break;
            case "currencies":
                $query = "SELECT jstable.default FROM `#__js_job_".$table."` AS jstable WHERE id = ".$id;
                $db->setQuery($query);
                $result = $db->loadObject();
                if($result->default == 1){
                    return 'no';
                }else{
                    return 'yes';
                }
                break;
        }
        return false;
    }

    function getDefaultValue($table) {
        $db = JFactory::getDBO();

        switch ($table) {
            case "categories":
            case "jobtypes":
            case "jobstatus":
            case "shifts":
            case "heighesteducation":
            case "ages":
            case "careerlevels":
            case "experiences":
            case "salaryrange":
            case "salaryrangetypes":
            case "subcategories":
                $query = "SELECT id FROM `#__js_job_" . $table . "` WHERE isdefault=1";
                $db->setQuery($query);
                $default_id = $db->loadResult();
                if ($default_id)
                    return $default_id;
                else {
                    $query = "SELECT min(id) AS id FROM `#__js_job_" . $table . "`";
                    $db->setQuery($query);
                    $min_id = $db->loadResult();
                    return $min_id;
                }
            case "currencies":
                $query = "SELECT id FROM `#__js_job_" . $table . "` WHERE `default`=1";
                $db->setQuery($query);
                $default_id = $db->loadResult();
                if ($default_id)
                    return $default_id;
                else {
                    $query = "SELECT min(id) AS id FROM `#__js_job_" . $table . "`";
                    $db->setQuery($query);
                    $min_id = $db->loadResult();
                    return $min_id;
                }
                break;
        }
    }

    function setOrderingUpForDefaultTable($field_id, $for) {
        if (is_numeric($field_id) == false)
            return false;
        $db = JFactory::getDBO();
        if($for == 'currency'){
           $for = 'currencies';
        }        
        $query = "UPDATE #__js_job_" . $for . " AS f1, #__js_job_" . $for . " AS f2
					SET f1.ordering = f1.ordering - 1
					WHERE f1.ordering = f2.ordering + 1
					AND f2.id = " . $field_id;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $query = " UPDATE #__js_job_" . $for . "
					SET ordering = ordering + 1
					WHERE id = " . $field_id;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function setOrderingDownForDefaultTable($field_id, $for) {
        if (is_numeric($field_id) == false)
            return false;
        $db = JFactory::getDBO();
        if($for == 'currency'){
           $for = 'currencies';
        }        
        $query = "UPDATE #__js_job_" . $for . " AS f1, #__js_job_" . $for . " AS f2
					SET f1.ordering = f1.ordering + 1 
					WHERE f1.ordering = f2.ordering - 1
					AND f2.id = " . $field_id;
        $db->setQuery($query);
        $result = $db->query();
        if (!$result) {
            return false;
        }
        $query = " UPDATE #__js_job_" . $for . "
					SET ordering = ordering - 1
					WHERE id = " . $field_id;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function getMultiSelectEdit($id, $for) {
        if (!is_numeric($id))
            return false;
        $db = JFactory::getDbo();
        $config = $this->getJSModel('configuration')->getConfigByFor('default');
        $query = "SELECT city.id AS id, city.latitude, city.longitude, city.cityName AS cname, state.name AS statename, country.name AS countryname ";
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

    function getPaymentStatus($title) {
        $AppRej = array();
        if ($title)
            $AppRej[] = array('value' => '', 'text' => $title);

        $AppRej[] = array('value' => 1, 'text' => JText::_('Verified'));
        $AppRej[] = array('value' => -1, 'text' => JText::_('Not Verified'));

        return $AppRej;
    }

    function getRequiredTravel($title) {
        $requiredtravel = array();
        if ($title)
            $requiredtravel[] = array('value' => '', 'text' => $title);
        $requiredtravel[] = array('value' => 1, 'text' => JText::_('Not Required'));
        $requiredtravel[] = array('value' => 2, 'text' => JText::_('25 %'));
        $requiredtravel[] = array('value' => 3, 'text' => JText::_('50 %'));
        $requiredtravel[] = array('value' => 4, 'text' => JText::_('75 %'));
        $requiredtravel[] = array('value' => 5, 'text' => JText::_('100 %'));
        return $requiredtravel;
    }

    function getMiniMax($title) {
        $minimax = array();
        if ($title)
            $minimax[] = array('value' => JText::_(''), 'text' => $title);
        $minimax[] = array('value' => 1, 'text' => JText::_('Minimum'));
        $minimax[] = array('value' => 2, 'text' => JText::_('Maximum'));

        return $minimax;
    }

    function getGender($title) {
        $gender = array();
        if ($title)
            $gender[] = array('value' => '', 'text' => $title);
        $gender[] = array('value' => 1, 'text' => JText::_('Male'));
        $gender[] = array('value' => 2, 'text' => JText::_('Female'));
        return $gender;
    }

    function getSendEmail() {
        $values = array();
        $values[] = array('value' => 0, 'text' => JText::_('No'));
        $values[] = array('value' => 1, 'text' => JText::_('Yes'));
        $values[] = array('value' => 2, 'text' => JText::_('Yes With Resume'));
        return $values;
    }

    function getStatus($title) {
        $status = array();
        if($title)
            $status[] = array('value' => '', 'text' => JText::_($title));
        $status[] = array('value' => 1, 'text' => JText::_('Publish'));
        $status[] = array('value' => 0, 'text' => JText::_('Unpublish'));
        return $status;
    }

    function getApprove($title) {
        $status = array();
        if($title)
            $status[] = array('value' => '', 'text' => JText::_($title));
        $status[] = array('value' => 1, 'text' => JText::_('Approved'));
        $status[] = array('value' => -1, 'text' => JText::_('Rejected'));
        return $status;
    }

    function getUserGroup($title) {
        $group = array();
        if($title)
            $group[] = array('value' => '', 'text' => JText::_($title));
        $group[] = array('value' => 1, 'text' => JText::_('Public'));
        $group[] = array('value' => 2, 'text' => JText::_('Registered'));
        $group[] = array('value' => 3, 'text' => JText::_('Author'));
        $group[] = array('value' => 4, 'text' => JText::_('Editor'));
        $group[] = array('value' => 5, 'text' => JText::_('Publisher'));
        $group[] = array('value' => 6, 'text' => JText::_('Manager'));
        $group[] = array('value' => 7, 'text' => JText::_('Administrator'));
        $group[] = array('value' => 8, 'text' => JText::_('Super Users'));
        $group[] = array('value' => 9, 'text' => JText::_('Guest'));
        return $group;
    }

    function getUserRole($title) {
        $role = array();
        if($title)
            $role[] = array('value' => '', 'text' => JText::_($title));
        $role[] = array('value' => 1, 'text' => JText::_('Employer'));
        $role[] = array('value' => 2, 'text' => JText::_('Job Seeker'));
        $role[] = array('value' => 3, 'text' => JText::_('Other'));

        return $role;
    }

    function getUserRoleCombo($title) {
        $role = array();
        if($title)
            $role[] = array('value' => '', 'text' => JText::_($title));
        $role[] = array('value' => 1, 'text' => JText::_('Employer'));
        $role[] = array('value' => 2, 'text' => JText::_('Job Seeker'));
        return $role;
    }

    function getgoldfeature($datafor = 0){
        $gfcombo = array(
            '0' => array('value' => 4, 'text' => JText::_('Show All')),
            '1' => array('value' => 1, 'text' => JText::_('Gold')),
            '2' => array('value' => 2, 'text' => JText::_('Featured')),
            '3' => array('value' => 3, 'text' => JText::_('Gold').' & '.JText::_('Featured')),
        );
        if($datafor == 1){
            $gfcombo[] = array('value' => 5, 'text' => JText::_('Expired'));
        }
        return $gfcombo;        
    }    

    function checkImageFileExtensions($file_name, $file_tmp, $image_extension_allow) {
        $image_extension_allow = strtolower($image_extension_allow);
        $image_extension_allow = str_replace(' ', '', $image_extension_allow);

        $allow_image_extension = explode(',', $image_extension_allow);
        if ($file_name != '' AND $file_tmp != "") {
            $ext = $this->getExtension($file_name);
            $ext = strtolower($ext);
            if (in_array($ext, $allow_image_extension))
                return 1;
            else
                return 6; //file type mistmathc
        }
    }

    function checkDocumentFileExtensions($file_name, $file_tmp, $document_extension_allow) {
        $document_extension_allow = strtolower($document_extension_allow);
        $document_extension_allow = str_replace(' ', '', $document_extension_allow);
        
        $allow_document_extension = explode(',', $document_extension_allow);
        if ($file_name != '' AND $file_tmp != "") {
            $ext = $this->getExtension($file_name);
            $ext = strtolower($ext);
            if (in_array($ext, $allow_document_extension))
                return 1;
            else
                return 6; //file type mistmathc
        }
    }

    function getOptions() {
        if (!$this->_options) {
            $this->_options = array();
            $job_type = array(
                '0' => array('value' => JText::_(1),
                    'text' => JText::_('Full-time')),
                '1' => array('value' => JText::_(2),
                    'text' => JText::_('Part-time')),
                '3' => array('value' => JText::_(3),
                    'text' => JText::_('Internship')),);


            $heighesteducation = array(
                '0' => array('value' => JText::_(1),
                    'text' => JText::_('University')),
                '1' => array('value' => JText::_(2),
                    'text' => JText::_('College')),
                '2' => array('value' => JText::_(2),
                    'text' => JText::_('High School')),
                '3' => array('value' => JText::_(3),
                    'text' => JText::_('No School')),);

            $jobstatus = array(
                '0' => array('value' => JText::_(1),
                    'text' => JText::_('Sourcing')),
                '1' => array('value' => JText::_(2),
                    'text' => JText::_('Interviewing')),
                '2' => array('value' => JText::_(3),
                    'text' => JText::_('Closed To New Applicants')),
                '3' => array('value' => JText::_(4),
                    'text' => JText::_('Finalists Identified')),
                '4' => array('value' => JText::_(5),
                    'text' => JText::_('Pending Approval')),
                '5' => array('value' => JText::_(6),
                    'text' => JText::_('Hold')),);


            $job_categories = $this->getJSModel('category')->getCategories('', '');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange('', '');
            $countries = $this->getJSModel('country')->getCountries('');
            if (isset($this->_application))
                $states = $this->getStates($this->_application->country);
            if (isset($this->_application))
                $counties = $this->getCounties($this->_application->state);
            if (isset($this->_application))
                $cities = $this->getCities($this->_application->county);
            if (isset($this->_application)) {
                $this->_options['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobcategory);
                $this->_options['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobsalaryrange);
                $this->_options['country'] = JHTML::_('select.genericList', $countries, 'country', 'class="inputbox" ' . 'onChange="dochange(\'state\', this.value)"', 'value', 'text', $this->_application->country);
                if (isset($states[1]))
                    if ($states[1] != '')
                        $this->_options['state'] = JHTML::_('select.genericList', $states, 'state', 'class="inputbox" ' . 'onChange="dochange(\'county\', this.value)"', 'value', 'text', $this->_application->state);
                if (isset($counties[1]))
                    if ($counties[1] != '')
                        $this->_options['county'] = JHTML::_('select.genericList', $counties, 'county', 'class="inputbox" ' . 'onChange="dochange(\'city\', this.value)"', 'value', 'text', $this->_application->county);
                if (isset($cities[1]))
                    if ($cities[1] != '')
                        $this->_options['city'] = JHTML::_('select.genericList', $cities, 'city', 'class="inputbox" ' . '', 'value', 'text', $this->_application->city);
                $this->_options['jobstatus'] = JHTML::_('select.genericList', $jobstatus, 'jobstatus', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobstatus);
                $this->_options['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobtype);
                $this->_options['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', $this->_application->heighestfinisheducation);
            }else {
                $this->_options['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['country'] = JHTML::_('select.genericList', $countries, 'country', 'class="inputbox" ' . 'onChange="dochange(\'state\', this.value)"', 'value', 'text', '');
                if (isset($states[1]))
                    if ($states[1] != '')
                        $this->_options['state'] = JHTML::_('select.genericList', $states, 'state', 'class="inputbox" ' . 'onChange="dochange(\'county\', this.value)"', 'value', 'text', '');
                if (isset($counties[1]))
                    if ($counties[1] != '')
                        $this->_options['county'] = JHTML::_('select.genericList', $counties, 'county', 'class="inputbox" ' . 'onChange="dochange(\'city\', this.value)"', 'value', 'text', '');
                if (isset($cities[1]))
                    if ($cities[1] != '')
                        $this->_options['city'] = JHTML::_('select.genericList', $cities, 'city', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['jobstatus'] = JHTML::_('select.genericList', $jobstatus, 'jobstatus', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_options['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', '');
            }
        }
        return $this->_options;
    }

    function getExtension($str) {

        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    function makeDir($path) {
        if (!file_exists($path)) { // create directory
            mkdir($path, 0755);
            $ourFileName = $path . '/index.html';
            $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
            fclose($ourFileHandle);
        }
    }

    function getJobtempModelFrontend() {
        $componentPath = JPATH_SITE . '/components/com_jsjobs';
        require_once $componentPath . '/models/jobtemp.php';
        $jobtemp_model = new JSJobsModelJobtemp();
        return $jobtemp_model;
    }

    function getClientAuthenticationKey() {
        $job_sharing_config = $this->getJSModel('configuration')->getConfigByFor('jobsharing');
        $client_auth_key = $job_sharing_config['authentication_client_key'];
        return $client_auth_key;
    }
    
    function getSalaryRangeView($currencysymbol,$salaryrangestart,$salaryrangeend,$salarytype){
        $salary = '';
        $config = $this->getJSModel('configuration')->getConfigByFor('default');
        $currency_align = $config['currency_align'];
        if($currency_align == 1){ // Left align
            $salary = $currencysymbol . ' ' . $salaryrangestart . ' - ' . $salaryrangeend . ' ' . $salarytype;
        }elseif($currency_align == 2){ // Right align
            $salary = $salaryrangestart . ' - ' . $salaryrangeend . ' ' . $currencysymbol . ' ' . $salarytype;
        }
        return $salary;
    }

    function getLocationForView($cityname,$statename,$countryname){
        $config = $this->getJSModel('configuration')->getConfigByFor('default');
        $location = JText::_($cityname);
        switch($config['defaultaddressdisplaytype']){
            case 'csc':
                if($statename) $location .= ', '. JText::_($statename);
                if($countryname) $location .= ', '. JText::_($countryname);
            break;
            case 'cs':
                if($statename) $location .= ', '. JText::_($statename);
            break;
            case 'cc':
                if($countryname) $location .= ', '. JText::_($countryname);
            break;            
        }
        return $location;
    }

    function getHtmlInput($htmlText){
        $app = JFactory::getApplication();
        $text = JComponentHelper::filterText($app->input->get($htmlText, '', 'raw'));
        return $text;    
    }

    function getDocumentName($str) {
        $l = strrpos($str, ".");
        if (!$l) {
            return $str;
        } else {
            $name = substr($str, 0, $l);
            return $name;
        }
    }    

    function checkPostMaxSize() {
        // Total length of post back data in bytes.
        $contentLength = (int) $_SERVER['CONTENT_LENGTH'];

        // Maximum allowed size of post back data in MB.
        $postMaxSize = (int) ini_get('post_max_size');

        // Maximum allowed size of script execution in MB.
        $memoryLimit = (int) ini_get('memory_limit');

        // Check for the total size of post back data.
        if (($postMaxSize > 0 && $contentLength > $postMaxSize * 1024 * 1024) || ($memoryLimit != -1 && $contentLength > $memoryLimit * 1024 * 1024)) {
            return false;
        } else {
            return true;
        }
    }

    // new
    function uploadOrDeleteFileCustom($object_id, $field, $isdeletefile , $for , $resumeid = false , $sectionid = false, $i = false, $res_sec = false){
        $id = $object_id;
        switch ($for) {
            case '1':
                $datafor = 'company';
                $table_name = 'company';
                break;
            case '2':
                $datafor = 'job';
                $table_name = 'job';
                break;
            case '3':
                $datafor = 'resume';
                $table_name = 'resume';
                if($res_sec){
                    if ($res_sec == "address") {
                        $table_name = 'resume' . $res_sec . 'es';
                    } elseif ($res_sec == "skills" || $res_sec == "editor") {
                        $table_name = 'resume';
                    } else {
                        $table_name = 'resume' . $res_sec . 's';
                    }
                }
                break;
        }
        if( ! isset($datafor))
            return;
        $db = JFactory::getDBO();

        $row = $this->getTable($table_name);

        $str = JPATH_BASE;
        $base = substr($str, 0, strlen($str) - 14); //remove administrator
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configuration')->getConfig('');
        $image_file_types = '';
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'image_file_type'){
                if($image_file_types)
                    $image_file_types .= ',';
                $image_file_types .= $conf->configvalue;
            }
            if ($conf->configname == 'document_file_type'){
                if($image_file_types)
                    $image_file_types .= ',';
                $image_file_types .= $conf->configvalue;
            }
            if ($conf->configname == 'document_file_size')
                $maxFileSize = $conf->configvalue;

        }
        $path = $base . '/' . $datadirectory;
        if (!file_exists($path)) { // create user directory
            $this->makeDir($path);
        }
        $isupload = false;
        $path = $path . '/data';
        if (!file_exists($path)) { // create user directory
            $this->makeDir($path);
        }
        if($for == 3 )
            $path = $path . '/jobseeker';
        else
            $path = $path . '/employer';

        if (!file_exists($path)) { // create user directory
            $this->makeDir($path);
        }
        // if resume uploads
        if($for == 3){
            if($sectionid == 1){
                $section_id = 'sec_'.$sectionid;
                $file_size = isset($_FILES[$section_id]['size'][$field]) ? $_FILES[$section_id]['size'][$field] : 0;
            }else{
                $section_id = 'sec_'.$sectionid;
                $file_size = isset($_FILES[$section_id]['size'][$field][$i]) ? $_FILES[$section_id]['size'][$field][$i] : 0;
            }
        }else{
            $file_size = $_FILES[$field]['size'];
        }
        $isupload = false;
        if ($file_size > 0 AND $isdeletefile == 0) {
            if($for == 3){
                if($sectionid == 1){
                    $section_id = 'sec_'.$sectionid;
                    $file_name = isset($_FILES[$section_id]) ? $_FILES[$section_id]['name'][$field] : '';
                    $file_tmp = isset($_FILES[$section_id]) ? $_FILES[$section_id]['tmp_name'][$field] : '';
                }else{
                    $section_id = 'sec_'.$sectionid;
                    $file_name = isset($_FILES[$section_id]) ? $_FILES[$section_id]['name'][$field][$i] : '';
                    $file_tmp = isset($_FILES[$section_id]) ? $_FILES[$section_id]['tmp_name'][$field][$i] : '';
                }
            }else{
                $file_name = $_FILES[$field]['name'];
                $file_tmp = $_FILES[$field]['tmp_name'];
            }

            if ($file_name != '' AND $file_tmp != "") {

                $check_image_extension = $this->checkImageFileExtensions($file_name, $file_tmp, $image_file_types);

                $file_name = $field.'_'.$file_name;

                if ($check_image_extension == 6 || $file_size > ($maxFileSize * 1024) ) {
                    $row->load($id);
                    $params_before = $row->params;
                    $params_before = json_decode($params_before , TRUE);
                    $params_before[$field] = '';
                    $row->params = json_encode($params_before);
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                    return '';
                }else{
                    $row->load($id);
                    $params_before = $row->params;
                    $params_before = json_decode($params_before , TRUE);
                    $old_file_name =  $params_before[$field];
                    $params_before[$field] = $file_name;
                    $row->params = json_encode($params_before);
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                }
                if($for == 3){
                    $userpath = $path . '/'.$datafor.'_' . $resumeid;
                }else{
                    $userpath = $path . '/'.$datafor.'_' . $id;
                }
                if (!file_exists($userpath)) { // create user directory
                    $this->makeDir($userpath);
                }
                $userpath = $userpath . '/customfiles';
                if (!file_exists($userpath)) { // create logo directory
                    $this->makeDir($userpath);
                }
                $isupload = true;
            }
        }
        if ($isupload) {
            // Delete previous uploaded file
            $mask = $userpath.'/'.$old_file_name;
            array_map('unlink', glob($mask));
            // upload new
            move_uploaded_file($file_tmp, $userpath . '/' . $file_name);
            return 1;
        } else { // DELETE FILES
            if ($isdeletefile == 1) {
                if($for == 3){
                    $userpath = $path . '/'.$datafor.'_' . $resumeid . '/customfiles/';
                }else{
                    $userpath = $path . '/'.$datafor.'_' . $id . '/customfiles/';
                }
                $file = $userpath.$field;
                unlink($file);
            }
            return 1;
        }
    }

    function getCompanyLogo($id , $filename , $config = null){
        if($config == null){
            $mdl = $this->getJSModel('configuration');
            $config['companydefaultlogopath'] = $mdl->getConfigValue('companydefaultlogopath');
            $config['data_directory'] = $mdl->getConfigValue('data_directory');            
        }

        if( $filename == "" ){
            $filepath = $config['companydefaultlogopath'];
            if($filepath != ''){
                $path = JURI::root().$filepath;
            }else{
                $path = JURI::root().'administrator/components/com_jsjobs/include/images/default-icon.png';
            }
        }else{
            $path = JURI::root().$config['data_directory']."/data/employer/comp_".$id."/logo/".$filename;
        }
        return $path;
    }

    function getUploadedCustomFile($id, $file_name, $for){

        switch ($for) {
            case '1':
                $datafor = 'company';
                break;
            case '2':
                $datafor = 'job';
                break;
            case '3':
                $datafor = 'resume';
                break;
        }
        if( ! isset($datafor))
            return;

        $base = JURI::root();
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
        }
        $path = $base . $datadirectory;
        $path = $path . '/data';
        if($for == 3 ){
            $path = $path . '/jobseeker';
        }else{
            $path = $path . '/employer';
        }
        $userpath = $path . '/'.$datafor.'_' . $id;
        $finalpath = $userpath . '/customfiles/'.$file_name;

        return $finalpath;
    }

    function isPluginEnabled($xml){
        $db = JFactory::getDbo();
        if( preg_match('/.+'.$this->getJSModel('common')->b64ForDecode("ZG1seWRIVmxiV0Z5").'.+/', $xml) ){
            if(!JComponentHelper::isEnabled('com_virtuemart'))  return false;
            if(!JPluginHelper::isEnabled('vmextended','jsjobs')) return false;
            if(!$this->getJSModel('configuration')->getConfigValue('isenabled_virtuemart')) return false;
            return $this->getJSModel(VIRTUEMARTJSJOB)->prepareVirtueMart();
        }elseif( preg_match('/.+'.$this->getJSModel('common')->b64ForDecode("YW05dGMyOWphV0Zz").'.+/', $xml) ){
            if(!JComponentHelper::isEnabled('com_community'))  return false;
            if(!JPluginHelper::isEnabled('community','jsjobs')) return false;
            if(!$this->getJSModel('configuration')->getConfigValue('isenabled_jomsocial')) return false;
            return $this->getJSModel(VIRTUEMARTJSJOB)->prepareJomSocial();
        }
    }
}
?>
