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

class JSJobsModelJobAlert extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function storeJobAlertSetting() { //store job alert setting
        JRequest::checkToken() or die( 'Invalid Token' );
        $row = $this->getTable('jobalertsetting');
        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $email = $data['contactemail'];
        if ($data['id'] == '') { // only for new 
            if ($this->emailValidation($email))
                return 3;
            $data['lastmailsend'] = date('Y-m-d H:i:s');
        }
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
        if ($data['city']){
            $storemulticity = $this->storeMultiJobAlertCities($data['city'], $row->id);
            if ($storemulticity == false)
                return false;
        }

        if ($this->_client_auth_key != "") {
            $db = $this->getDBO();
            $query = "SELECT jobalert.* FROM `#__js_job_jobalertsetting` AS jobalert  
						WHERE jobalert.id = " . $row->id;

            $db->setQuery($query);
            $data_jobalert = $db->loadObject();
            if ($data['id'] != "" AND $data['id'] != 0)
                $data_jobalert->id = $data['id']; // for edit case
            $data_jobalert->jobalert_id = $row->id;
            $data_jobalert->authkey = $this->_client_auth_key;
            $data_jobalert->task = 'storejobalert';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->storeJobAlertSharing($data_jobalert);
            return $return_value;
        }else {
            return true;
        }
    }

    function storeMultiJobAlertCities($city_id, $alertid) { // city id comma seprated 
        if (!is_numeric($alertid))
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT cityid FROM #__js_job_jobalertcities WHERE alertid = " . $alertid;
        $db->setQuery($query);
        $old_cities = $db->loadObjectList();

        $id_array = explode(",", $city_id);
        $row = $this->getTable('jobalertcities');
        $error = array();

        foreach ($old_cities AS $oldcityid) {
            $match = false;
            foreach ($id_array AS $cityid) {
                if ($oldcityid->cityid == $cityid) {
                    $match = true;
                    break;
                }
            }
            if ($match == false) {
                $query = "DELETE FROM #__js_job_jobalertcities WHERE alertid = " . $alertid . " AND cityid=" . $oldcityid->cityid;
                $db->setQuery($query);
                if (!$db->query()) {
                    $err = $this->setError($this->_db->getErrorMsg());
                    $error[] = $err;
                }
            }
        }


        foreach ($id_array AS $cityid) {
            $insert = true;
            foreach ($old_cities AS $oldcityid) {
                if ($oldcityid->cityid == $cityid) {
                    $insert = false;
                    break;
                }
            }
            if ($insert) {
                $row->id = "";
                $row->alertid = $alertid;
                $row->cityid = $cityid;
                if (!$row->store()) {
                    $err = $this->setError($this->_db->getErrorMsg());
                    $error[] = $err;
                }
            }
        }
        if (!empty($error))
            return false;
        return true;
    }

    function emailValidation($email) {
        $db = JFactory:: getDBO();
        $query = "SELECT COUNT(id) FROM `#__js_job_jobalertsetting` WHERE contactemail = " . $db->Quote($email);
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result > 0)
            return true;
        else
            return false;
    }

    function getJobAlertbyIdforForm($id) {
        $db = $this->getDBO();
        if ($id)
            if ((is_numeric($id) == false) || ($id == 0) || ($id == ''))
                return false;
        $status = array(
            '0' => array('value' => 1, 'text' => JText::_('Approve')),
            '1' => array('value' => -1, 'text' => JText::_('Reject')),);

        $query = "SELECT jobset.*
			FROM `#__js_job_jobalertsetting` AS jobset
			WHERE jobset.id = " . $id;

        $db->setQuery($query);
        $setting = $db->loadObject();

        $alerttype = $this->getAlerttype('', '');
        $categories = $this->getJSModel('category')->getCategories('', '');
        if (isset($setting)) {
            if ($setting->categoryid)
                $categoryid = $setting->categoryid;
            else
                $categoryid = $categories[0]['value'];
            if ($setting->subcategoryid)
                $subcategoryid = $setting->subcategoryid;
            else
                $subcategoryid = '';
            $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'categoryid', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $categoryid);
            $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($categoryid, JText::_('Sub Category'), ''), 'subcategoryid', 'class="inputbox" ' . '', 'value', 'text', $subcategoryid);
            $lists['alerttype'] = JHTML::_('select.genericList', $alerttype, 'alerttype', 'class="inputbox required" ' . '', 'value', 'text', $setting->alerttype);
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox" ' . '', 'value', 'text', $setting->status);
            $multi_lists = $this->getJSModel('common')->getMultiSelectEdit($setting->id, 3);
        }else {
            $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'categoryid', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', '');
            $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($categories[0]['value'], JText::_('Sub Category'), ''), 'subcategoryid', 'class="inputbox" ' . '', 'value', 'text', '');
            $lists['alerttype'] = JHTML::_('select.genericList', $alerttype, 'alerttype', 'class="inputbox required" ' . '', 'value', 'text', '');
            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox" ' . '', 'value', 'text', $setting->status);
        }
        if (isset($setting))
            $result[0] = $setting;
        $result[1] = $lists;

        if (isset($multi_lists) && $multi_lists != "")
            $result[2] = $multi_lists;

        return $result;
    }

    function getAlerttype($alert_type, $title) {
        $alerttype = array();
        if ($title)
            $alerttype[] = array('value' => JText::_(''), 'text' => $title);
        else
            $alerttype[] = array('value' => JText::_(''), 'text' => JText::_('Choose Alert Type'));

        $alerttype[] = array('value' => 1, 'text' => JText::_('Daily'));
        $alerttype[] = array('value' => 2, 'text' => JText::_('Weekly'));
        $alerttype[] = array('value' => 3, 'text' => JText::_('Monthly'));
        return $alerttype;
    }

    function unSubscribeJobAlert($alertid) {
        if (!is_numeric($alertid))
            return false;
        $db = $this->getDBO();
        $row = $this->getTable('jobalertsetting');
        if ($this->_client_auth_key != "") {
            $query = "SELECT jobalert.id,jobalert.serverid FROM `#__js_job_jobalertsetting` AS jobalert
							WHERE jobalert.id = " . $alertid;

            $db->setQuery($query);
            $alert_data = $db->loadObject();
            $data['authkey'] = $this->_client_auth_key;
            $data['task'] = 'unsunscribejobalert';
            $data['id'] = $alert_data->serverid;
            $data['jobalert_id'] = $alert_data->id;
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->unsubscribeJobAlert($data);
        }
        $query = "DELETE jobalert,acity
					FROM `#__js_job_jobalertsetting` AS jobalert
					LEFT JOIN `#__js_job_jobalertcities` AS acity ON acity.alertid=jobalert.id 
			WHERE jobalert.id = " . $alertid;
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        if ($this->_client_auth_key != "") {
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logUnsubscribeJobAlert($return_value);
        }
        return true;
    }

    function getAllJobAlerts($searchname, $limitstart, $limit) {
        $db = $this->getDBO();
        $query = "SELECT COUNT(*) FROM `#__js_job_jobalertsetting` ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;
        $query = "SELECT alert.*,cat.cat_title,subcat.title 
					FROM `#__js_job_jobalertsetting` AS alert
					JOIN `#__js_job_categories` AS cat ON alert.categoryid = cat.id
					LEFT JOIN `#__js_job_subcategories` AS subcat ON alert.subcategoryid = subcat.id";
        if ($searchname)
            $query .= " WHERE LOWER(alert.name) LIKE " . $db->Quote('%' . $searchname . '%');

        $db->setQuery($query, $limitstart, $limit);
        $jobalerts = $db->loadObjectList();
        $lists = array();
        if ($searchname)
            $lists['searchname'] = $searchname;
        $result[0] = $jobalerts;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function sendJobAlertJobseeker($jobid) {
        $db = $this->getDBO();
        if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
            return false;
        $query = "SELECT job.title,job.jobcategory, category.cat_title AS categorytitle, subcategory.title AS subcategorytitle
                            ,subcategory.id AS subcategoryid, job.country, job.state, job.county, job.city
                            , country.name as countryname, state.name as statename, city.cityName as cityname

                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS category ON job.jobcategory  = category.id
                        LEFT JOIN `#__js_job_subcategories` AS subcategory ON job.subcategoryid = subcategory.categoryid
                         JOIN `#__js_job_countries` AS country ON job.country = country.id
                        LEFT JOIN `#__js_job_states` AS state ON job.state = state.id
                        LEFT JOIN `#__js_job_cities` AS city ON job.city = city.id
                        WHERE job.id = " . $jobid;
        $db->setQuery($query);
        $job = $db->loadObject();
        $countryquery = "(SELECT jobalert.contactemail
                            FROM `#__js_job_jobalertsetting` AS jobalert
                            WHERE jobalert.categoryid = " . $job->jobcategory . " 
							AND jobalert.country = " . $job->country;
        if ($job->subcategoryid)
            $countryquery .= " AND jobalert.subcategoryid = " . $job->subcategoryid;
        if ($job->state)
            $countryquery .= " AND jobalert.state != " . $job->state;
        if ($job->city)
            $countryquery .= " AND jobalert.city != " . $job->city;
        $countryquery .= ")";
        $query = $countryquery;
        if ($job->state) {
            $statequery = "(SELECT jobalert.contactemail
                                FROM `#__js_job_jobalertsetting` AS jobalert
                                WHERE jobalert.categoryid = " . $job->jobcategory . " 
								AND jobalert.country = " . $job->country;
            if ($job->subcategoryid)
                $statequery .= " AND jobalert.subcategoryid = " . $job->subcategoryid;
            if ($job->state)
                $statequery .= " AND jobalert.state = " . $job->state;
            if ($job->city)
                $statequery .= " AND jobalert.city != " . $job->city;
            $statequery .= ")";
            $query .= " UNION " . $statequery;
        }
        if ($job->city) {
            $cityquery = "(SELECT jobalert.contactemail
                                FROM `#__js_job_jobalertsetting` AS jobalert
                                WHERE jobalert.categoryid = " . $job->jobcategory . " 
								AND jobalert.country = " . $job->country;
            if ($job->subcategoryid)
                $cityquery .= " AND jobalert.subcategoryid = " . $job->subcategoryid;
            if ($job->state)
                $cityquery .= " AND jobalert.state = " . $job->state;
            if ($job->city)
                $cityquery .= " AND jobalert.city = " . $job->city;
            $cityquery .= ")";
            $query .= " UNION " . $cityquery;
        }
        $db->setQuery($query);
        $result = $db->loadObjectList();

        if (isset($result)) {
            foreach ($result AS $email) {
                $bcc[] = $email->contactemail;
            }
        } else
            exit;

        $comma = '';
        if ($job->cityname) {
            $location = $comma . $job->cityname;
            $comma = ', ';
        } elseif ($job->city) {
            $location = $comma . $job->city;
            $comma = ', ';
        }
        if ($job->countyname) {
            $location = $comma . $job->countyname;
            $comma = ', ';
        } elseif ($job->county) {
            $location = $comma . $job->county;
            $comma = ', ';
        }
        if ($job->statename) {
            $location = $comma . $job->statename;
            $comma = ', ';
        } elseif ($job->state) {
            $location = $comma . $job->state;
            $comma = ', ';
        }
        $location .= $comma . $job->countryname;
        $msgSubject = 'New Job';
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = 'job-alert'";
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;

        $msgBody = str_replace('{JOB_TITLE}', $job->title, $msgBody);
        $msgBody = str_replace('{CATEGORY}', $job->categorytitle, $msgBody);
        $msgBody = str_replace('{SUB_CATEGORY}', $job->subcategorytitle, $msgBody);
        $msgBody = str_replace('{LOCATION}', $location, $msgBody);

        $config = $this->getJSModel('configuration')->getConfigByFor('email');

        $message = JFactory::getMailer();
        if(!empty($config['mailfromaddress'])){
            $message->addRecipient($config['mailfromaddress']); //to email

            $message->addBCC($bcc);

            $message->setSubject($msgSubject);
            $message->setBody($msgBody);
            $sender = array($config['mailfromaddress'], $config['mailfromname']);
            $message->setSender($sender);

            $message->IsHTML(true);
            $sent = $message->send();
            return $sent;
        }
        return true;
    }

}

?>