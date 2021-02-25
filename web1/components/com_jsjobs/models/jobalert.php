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

class JSJobsModelJobAlert extends JSModel {

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

    function sendJobAlertByAlertType($ck) {
        $pass = $this->getJSModel('configurations')->checkCronKey($ck);
        if ($pass == true) {
            $this->sendJobAlert(1); //For Daily Subscriber
            $this->sendJobAlert(2); //For Weekly Subscriber
            $this->sendJobAlert(3); //For Monthly Subscriber
            if ($this->_client_auth_key != "") {
                for ($i = 1; $i <= 3; $i++) {
                    $data['ck'] = $ck;
                    $data['authkey'] = $this->_client_auth_key;
                    $data['siteurl'] = $this->_siteurl;
                    $data['alerttype'] = $i;
                    $fortask = "sendjobalert";
                    $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                    $encodedata = json_encode($data);
                    $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
                    if (isset($return_server_value['jobalerts']) AND $return_server_value['jobalerts'] == -1) { // auth fail 
                        $logarray['uid'] = $this->_uid;
                        $logarray['referenceid'] = $return_server_value['referenceid'];
                        $logarray['eventtype'] = $return_server_value['eventtype'];
                        $logarray['message'] = $return_server_value['message'];
                        $logarray['event'] = "Job Alerts for Jobseeker";
                        $logarray['messagetype'] = "Error";
                        $logarray['datetime'] = date('Y-m-d H:i:s');
                        $jsjobsharingobject->write_JobSharingLog($logarray);
                    }
                }
            }
        } else
            return false;
    }

    function getJobAlertbyUidforForm($uid) {
        $db = $this->getDBO();
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'overwrite_jobalert_settings')
                $overwrite_jobalert_settings = $conf->configvalue;
        }
        $jobalert = $overwrite_jobalert_settings;
        if ($jobalert == 0) {
            $jobalert = $this->canSetJobAlert($uid);
        }
        if ($jobalert == 1) {
            if (is_numeric($uid) == false)
                return false;
            if ($uid != 0) {
                $query = "SELECT jobset.id ,jobset.status ,jobset.contactemail ,jobset.name ,jobset.zipcode
                            ,jobset.keywords ,jobset.created ,jobset.categoryid ,jobset.subcategoryid ,jobset.alerttype
        	                FROM `#__js_job_jobalertsetting` AS jobset
        					WHERE jobset.uid = " . $uid;
                        $db->setQuery($query);
                        $setting = $db->loadObject();
            }

            $alerttype = $this->getAlerttype('', '');
            $categories = $this->getJSModel('category')->getCategories('');
            if (isset($setting)) {
                if ($setting->categoryid)
                    $categoryid = $setting->categoryid;
                else
                    $categoryid = $categories[0]['value'];
                if ($setting->subcategoryid)
                    $subcategoryid = $setting->subcategoryid;
                else
                    $subcategoryid = '';
                $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'categoryid', 'class="inputbox jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $categoryid);
                $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($categoryid, JText::_('Sub Category'), ''), 'subcategoryid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $subcategoryid);
                $lists['alerttype'] = JHTML::_('select.genericList', $alerttype, 'alerttype', 'class="inputbox required jsjobs-cbo" ' . '', 'value', 'text', $setting->alerttype);
                $multi_lists = $this->getJSModel('employer')->getMultiSelectEdit($setting->id, 3);
            }else {
                $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
                $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'categoryid', 'class="inputbox jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $defaultCategory);
                $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($categories[0]['value'], JText::_('Sub Category'), ''), 'subcategoryid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
                $lists['alerttype'] = JHTML::_('select.genericList', $alerttype, 'alerttype', 'class="inputbox required jsjobs-cbo" ' . '', 'value', 'text', '');
            }
        }
        if (isset($setting))
            $result[0] = $setting;
        if(isset($lists))
            $result[1] = $lists;
        $result[2] = $jobalert;
        if (isset($multi_lists) && $multi_lists != "")
            $result[3] = $multi_lists;
        return $result;
    }

    function sendJobAlertJobseeker($jobid) {
        $db = $this->getDBO();
        if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
            return false;
        $query = "SELECT job.title,job.jobcategory, category.cat_title AS categorytitle, subcategory.title AS subcategorytitle
                    ,subcategory.id AS subcategoryid, job.country, job.state, job.city
                    , country.name as countryname, state.name as statename, city.cityName as cityname
                    , job.metakeywords AS keywords

                    FROM `#__js_job_jobs` AS job
                    JOIN `#__js_job_categories` AS category ON job.jobcategory  = category.id
                    LEFT JOIN `#__js_job_subcategories` AS subcategory ON job.subcategoryid = subcategory.categoryid
                     JOIN `#__js_job_countries` AS country ON job.country = country.id
                    LEFT JOIN `#__js_job_states` AS state ON job.state = state.id
                    LEFT JOIN `#__js_job_cities` AS city ON job.city = city.id
                    WHERE job.id = " . $jobid;
        $db->setQuery($query);
        $job = $db->loadObject();
        if (isset($job->keywords)) {
            $keywords = explode(' ', $job->keywords);
            $metakeywords = array();
            foreach ($keywords AS $keyword) {
                $metakeywords[] = " jobalert.keywords LIKE LOWER(" . $db->Quote('%'.$keyword.'%'). ")";
            }
            $metakeywords[] = " jobalert.keywords = '' OR jobalert.keywords IS NULL";
        }
        $countryquery = "(SELECT jobalert.contactemail
                            FROM `#__js_job_jobalertsetting` AS jobalert
                            WHERE jobalert.categoryid = " . $job->jobcategory . " 
							AND jobalert.country = " . $job->country;
        if ($job->subcategoryid)
            $countryquery .= " AND jobalert.subcategoryid = " . $job->subcategoryid;
        if ($job->state)
            $countryquery .= " AND jobalert.state != " . $job->state;
        //if($job->county) $countryquery .= " AND LOWER(jobalert.county) != LOWER(".$db->quote($job->county).")";
        if ($job->city)
            $countryquery .= " AND jobalert.city != " . $job->city;
        if ($job->keywords)
            $countryquery .= " AND ( " . implode(' OR ', $metakeywords) . " )";
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
            if ($job->keywords)
                $statequery .= " AND ( " . implode(' OR ', $metakeywords) . " )";
            $statequery .= ")";
            $query .= " UNION " . $statequery;
        }
        if ($job->city) {
            $cityquery = "(SELECT jobalert.contactemail
                                FROM `#__js_job_jobalertsetting` AS jobalert
                                WHERE jobalert.categoryid = " . $job->jobcategory . " 
								AND jobalert.country) = " . $job->country;
            if ($job->subcategoryid)
                $cityquery .= " AND jobalert.subcategoryid = " . $job->subcategoryid;
            if ($job->state)
                $cityquery .= " AND jobalert.state = " . $job->state;
            if ($job->city)
                $cityquery .= " AND jobalert.city = " . $job->city;
            if ($job->keywords)
                $cityquery .= " AND ( " . implode(' OR ', $metakeywords) . " )";
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

        $mail_jobs = '<table width="100%" cellpadding="10px" cellspacing="0">
						<tr>
							<th>' . JText::_('Job Title') . '</th>
							<th>' . JText::_('Job Category') . '</th>
							<th>' . JText::_('Job Sub Category') . '</th>
							<th>' . JText::_('Job Location') . '</th>
						</tr>';
        $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($job->id);
        $path = JRoute::_('index.php?option=com_jsjobs&c=jsjobs&view=employer&layout=view_job&bd=' . $jobaliasid . '&Itemid='.JRequest::getVar('Itemid') ,false);
        $mail_jobs .= '<tr>
							<td><a href="' . $path . '" target="_blank">' . $job->title . '</a></td>
							<td>' . $job->categorytitle . '</td>
							<td>' . $job->subcategorytitle . '</td>
							<td>' . $location . '</td>
						</tr>';
        $mail_jobs .= '</table>';
        $msgBody = str_replace('{SHOW_JOBS}', $mail_jobs, $msgBody);

        $config = $this->getJSModel('configurations')->getConfigByFor('email');

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

    function storeJobAlertSetting() { //store job alert setting
        JRequest::checkToken() or die( 'Invalid Token' );
        $row = $this->getTable('jobalertsetting');
        $db = $this->getDBO();
        $query = "SELECT configvalue FROM `#__js_job_config` WHERE configname='job_alert_captcha'";
        $db->setQuery($query);
        $result = $db->loadObject();
        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        if ($data['uid'] == 0 && $result->configvalue == 1)
            if (!$this->getJSModel('common')->performChecks()) {
                $result = 8;
                return $result;
            }
        $email = $data['contactemail'];
        if ($data['id'] == '') { // only for new 
            if ($this->emailValidation($email) == true)
                return 3;
            $config = $this->getJSModel('configurations')->getConfigByFor('jobalert');
            $data['status'] = $config['jobalert_auto_approve'];
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
        $storemulticity = true; //for validate
        if ($data['city'] && $data['city'] != '') {
            $storemulticity = $this->storeMultiJobAlertCities($data['city'], $row->id);
        }
        if ($storemulticity == false)
            return false;

        if ($this->_client_auth_key != "") {
            $query = "SELECT jobalert.* FROM `#__js_job_jobalertsetting` AS jobalert  
						WHERE jobalert.id = " . $row->id;
            //echo '<br> SQL '.$query;
            $db->setQuery($query);
            $data_jobalert = $db->loadObject();
            if ($data['id'] != "" AND $data['id'] != 0)
                $data_jobalert->id = $data['id']; // for edit case
            $data_jobalert->jobalert_id = $row->id;
            $data_jobalert->authkey = $this->_client_auth_key;
            $data_jobalert->task = 'storejobalert';
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $return_value = $jsjobsharingobject->store_JobAlertSharing($data_jobalert);
            $job_log_object = $this->getJSModel('log');
            $job_log_object->log_Store_JobAlertSharing($return_value);
        }
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

    function storeMultiJobAlertCities($city_id, $alertid) { // city id comma seprated 
        if (is_numeric($alertid) === false)
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

    function unSubscribeJobAlert($email) {
        JRequest::checkToken() or die("Invalid Token");
        $db = $this->getDBO();
        $row = $this->getTable('jobalertsetting');
        $returnvalue = $this->jobAlertCanUnsubscribe($email);
        if ($returnvalue == 1) {
            if ($this->_client_auth_key != "") {
                $query = "SELECT jobalert.id,jobalert.serverid FROM `#__js_job_jobalertsetting` AS jobalert
							WHERE jobalert.contactemail = " . $db->Quote($email);
                //echo '<br> SQL '.$query;
                $db->setQuery($query);
                $alert_data = $db->loadObject();
                $data['authkey'] = $this->_client_auth_key;
                $data['task'] = 'unsunscribejobalert';
                $data['id'] = $alert_data->serverid;
                $data['jobalert_id'] = $alert_data->id;
                $jsjobsharingobject = $this->getJSModel('jobsharingsite');
                $return_value = $jsjobsharingobject->unsubscribe_JobAlert($data);
            }
            $query = "DELETE jobalert,acity
                        FROM `#__js_job_jobalertsetting` AS jobalert
                        LEFT JOIN `#__js_job_jobalertcities` AS acity ON acity.alertid=jobalert.id 
                        WHERE jobalert.contactemail = " . $db->Quote($email);
            $db->setQuery($query);
            if (!$db->query()) {
                return false;
            }
            if ($this->_client_auth_key != "") {
                $job_log_object = $this->getJSModel('log');
                $job_log_object->log_Unsubscribe_JobAlert($return_value);
            }
            return true;
        } else
            return $returnvalue;
    }

    function jobAlertCanUnsubscribe($email) {
        $db = $this->getDBO();
        $result = array();

        $query = "SELECT COUNT(jobalert.id) FROM `#__js_job_jobalertsetting` AS jobalert WHERE jobalert.contactemail = " . $db->Quote($email);
        $db->setQuery($query);
        $comtotal = $db->loadResult();
        if ($comtotal > 0)
            return 1;
        else
            return 3;
    }

    function canSetJobAlert($uid) {
        $db = $this->getDBO();
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        $newlisting_required_package = 1;
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'js_newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }
        if ($newlisting_required_package == 0) {
            $allow = 1;
            return $allow;
        } else {
            $query = "SELECT package.id AS packageid, package.jobalertsetting, package.packageexpireindays, payment.id AS paymentid, payment.created
                        FROM `#__js_job_jobseekerpackages` AS package
                        JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=2)
                        WHERE payment.uid = " . $uid . "
                        AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                        AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $packages = $db->loadObjectList();
            $allow = 0;
            if (isset($packages)) {
                foreach ($packages AS $pack) {
                    if ($pack->jobalertsetting == 1)
                        $allow = 1;
                }
            }
            return $allow;
        }
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

    function sendJobAlert($alerttype) {
        $admin_jobs = '';
        $message = JFactory::getMailer();
        $config = $this->getJSModel('configurations')->getConfigByFor('email');
        $db = $this->getDBO();
        //$curdate = date('Y-m-d H:i:s');
        $curdate = date('Y-m-d 00:00:00');
        if ($alerttype == 1)
            $days = 1;
        elseif ($alerttype == 2)
            $days = 7;
        elseif ($alerttype == 3)
            $days = 30;

        if ($alerttype == 1)
            $alerttitle = 'Daily';
        elseif ($alerttype == 2)
            $alerttitle = 'Weekly';
        elseif ($alerttype == 3)
            $alerttitle = 'Monthly';
        if(!is_numeric($alerttype)) return false;
        $query = "SELECT person.*
                    FROM `#__js_job_jobalertsetting` AS person
                    WHERE person.alerttype = " . $alerttype . " AND DATE(DATE_ADD(person.lastmailsend,INTERVAL " . $days . " DAY)) <= CURDATE()";
        $db->setQuery($query);
        $persons = $db->loadObjectList();
        if (empty($persons))
            return false; // no person were selected for mail

        foreach ($persons AS $person) {
            $message->ClearAddresses(); 
            $wherequery = "";
            $query = "SELECT malert.cityid
                        FROM `#__js_job_jobalertcities` AS malert
                        WHERE malert.alertid = " . $person->id;
            $db->setQuery($query);
            $alertcities = $db->loadObjectList();
            if (is_object($alertcities)) {
                $lenght = count($alertcities);
                for ($i = 0; $i < $lenght; $i++) {
                    if ($i == 0)
                        $wherequery .= " AND ( mjob.cityid=" . $alertcities[$i]->cityid;
                    else
                        $wherequery .= " OR mjob.cityid=" . $alertcities[$i]->cityid;
                }
                $wherequery .= ")";
            }

            if ($alerttype == 1)
                //$wherequery .= " AND DATE(job.startpublishing) = CURDATE()";
            if ($alerttype == 2)
                $wherequery .= " AND job.startpublishing >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)";
            if ($alerttype == 3)
                $wherequery .= " AND job.startpublishing >= DATE_SUB(CURDATE(),INTERVAL 30 DAY)";

            $wherequery .= " AND job.startpublishing BETWEEN " . $db->Quote($person->lastmailsend) . " AND " . $db->Quote($curdate) ;


            $metakeywords = array();
            if (isset($person->keywords)) {
                $keywords = explode(' ', $person->keywords);
                $length = count($keywords);
                if ($length <= 5)
                    $i = $length;
                else
                    $i = 5;

                for ($j = 0; $j < $i; $j++) {
					$metakeywords[] = " job.metakeywords LIKE LOWER (".$db->Quote('%'.$keywords[$j].'%'). ")";
                }
                $metakeywords[] = " job.metakeywords = '' OR job.metakeywords IS NULL";
            }
            $query = "SELECT DISTINCT job.id,job.title,cat.cat_title AS categorytitle,job.city , subcat.title AS subcategorytitle
								FROM `#__js_job_jobs` AS job
								JOIN `#__js_job_categories` AS cat ON cat.id = job.jobcategory
								LEFT JOIN `#__js_job_subcategories` AS subcat ON subcat.id = job.subcategoryid
								LEFT JOIN `#__js_job_jobcities` AS mjob ON mjob.jobid = job.id
								WHERE job.jobcategory = " . $person->categoryid;

            if ($person->subcategoryid)
                $query .= " AND job.subcategoryid = " . $person->subcategoryid;
            if ($person->keywords)
                $query .= " AND ( " . implode(' OR ', $metakeywords) . " )";
            $query .=$wherequery;
            $db->setQuery($query);
            $jobs = $db->loadObjectList();
            foreach ($jobs AS $job) {  // for multicity select 
                $multicitydata = $this->getJSModel('cities')->getLocationDataForView($job->city);
                if ($multicitydata != "")
                    $job->mcity = $multicitydata;
            }

            if (!empty($jobs)) {
                $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = 'job-alert'";
                $db->setQuery($query);
                $template = $db->loadObject();
                $msgSubject = $template->subject;
                $msgBody = $template->body;
                if(empty($person->contactemail)) return true; //incase empty email
                $message->addRecipient($person->contactemail); //to email
                $mail_jobs = '<table width="100%" cellpadding="10px" cellspacing="0">
								<tr>
									<th>' . JText::_('Job Title') . '</th>
									<th>' . JText::_('Job Category') . '</th>
									<th>' . JText::_('Sub Categories') . '</th>
									<th>' . JText::_('Job Location') . '</th>
								</tr>';
                foreach ($jobs AS $job) {
                    $comma = '';
                    $location = '';
                    if (isset($job->mcity))
                        $location = $job->mcity;
                    $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($job->id);
                    $path = JRoute::_(JURI::root().'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&bd=' . $jobaliasid . '&Itemid='.JRequest::getVar('Itemid') ,false);
                    $mail_jobs .= '<tr>
										<td><a href="' . $path . '" target="_blank">' . $job->title . '</a></td>
										<td>' . $job->categorytitle . '</td>
										<td>' . $job->subcategorytitle . '</td>
										<td>' . $location . '</td>
									</tr>';
                }
                $mail_jobs .= '</table>';
                $admin_jobs .= $mail_jobs . " <br/> To " . $person->name . " <br/><br/>";
                $msgBody = str_replace('{JOBSEEKER_NAME}', $person->name, $msgBody);
                $msgBody = str_replace('{JOBS_INFO}', $mail_jobs, $msgBody);
                $message->setSubject($msgSubject);
                $message->setBody($msgBody);
                $sender = array($config['mailfromaddress'], $config['mailfromname']);
                $message->setSender($sender);
                $message->IsHTML(true);
                $sent = $message->send();
            }
            // update last mail send
            $query = "UPDATE `#__js_job_jobalertsetting` SET lastmailsend = '" . $curdate . "' WHERE id = " . $person->id;
            $db->setQuery($query);
            $db->query();
        } // end of each persons foreach loop
        // mail send to admin
        $message1 = JFactory::getMailer();
        if(!empty($config['adminemailaddress'])){
            $message1->addRecipient($config['adminemailaddress']); //to email
            $msgSubject = "Job Alert Information";
            $msgBody = "<p>Dear Admin</p><br/>Following jobs was succefully sent.<br/>Alert type: $alerttitle <br />" . $admin_jobs;
            $message1->setSubject($msgSubject);
            $message1->setBody($msgBody);
            $sender = array($config['mailfromaddress'], $config['mailfromname']);
            $message1->setSender($sender);
            $message1->IsHTML(true);
            $sent = $message1->send();
        }
    }


}
?>
    
