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

class JSJobsModelJobapply extends JSModel {

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

    function getResumeCommentsAJAX($id) {
        $db = $this->getDBO();
        if (is_numeric($id) == false)
            return false;
        $query = "SELECT comments,cvid FROM `#__js_job_jobapply` WHERE id = " . $id;
        $db->setQuery($query);
        $row = $db->loadObject();
        $option = 'com_jsjobs';

        $return_value = '<div id="js_job_app_actions">
                            <img class="image_close" onclick="closethisactiondiv();" src="components/com_jsjobs/include/images/act_no.png">';
        $return_value .=    "<div class='resume_comments'>
                                <div class='comment_title'>
                                    ".JText::_('Comments')."
                                </div>
                                <div class='comment_value'>
                                    <textarea name='comments' id='comments' rows='3' cols='55'>" . $row->comments . "</textarea>
                                </div>
                                <div class='comment_btn'>
                                    <input type='button' class='button' onclick='saveresumecomments(" . $id . "," . $row->cvid . ")' value='" . JText::_('Save') . "'>
                                </div>
                            </div>";
        $return_value .= "</div>";

        return $return_value;
    }

    function getMailForm($uid, $resumeid, $jobapplyid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($resumeid) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT 	resume.email_address
				FROM `#__js_job_resume` AS resume
					WHERE resume.id = " . $resumeid;

        $db->setQuery($query);
        $jobseeker_email = $db->loadResult();

        $return_value = "<div  id='resumeactioncandidate'>";
        $return_value.= "<table id='resumeactioncandidatetable' cellpadding='0' cellspacing='0' border='0' width='100%'>\n";
        $return_value .= "<tr >\n";
        $return_value .= "<td width='20%' valign='top' ><b>" . JText::_('Job Seeker') . ":</b></td>\n";
        $return_value .= "<td width='50%' align='left'>\n";
        $return_value .= "<input type='email' name='jsmailaddress' id='jsmailaddress' value='$jobseeker_email' readonly='readonly'/>\n";
        $return_value .= "</td>\n";
        $return_value .= "</tr>\n";
        $return_value .= "<tr >\n";
        $return_value .= "<td width='20%' valign='top' ><b>" . JText::_('Subject Line') . ":</b></td>\n";
        $return_value .= "<td width='50%' align='left'>\n";
        $return_value .= "<input type='text' name='jssubject' id='jssubject'/>\n";
        $return_value .= "</td>\n";
        $return_value .= "<tr >\n";
        $return_value .= "<td width='20%' valign='top' ><b>" . JText::_('Email Sender') . ":</b></td>\n";
        $return_value .= "<td width='50%' align='left'>\n";
        $return_value .= "<input type='email' name='emmailaddress' id='emmailaddress' class='email validate'/>\n";
        $return_value .= "</td>\n";
        $return_value .= "</tr>\n";
        $return_value .= "</table>\n";
        $return_value .= "</div>\n";
        $return_value .= "<div id='resumeactioncandidatecomments'>\n";
        $return_value.= "<table id='resumeactioncandidatecommentstable' cellpadding='0' cellspacing='0' border='0' width='100%'>\n";
        $return_value .= "<tr >\n";
        $return_value .= "<td width='335' align='center'>\n";
        $return_value .= "<textarea name='candidatemessage' id='candidatemessage' rows='5' cols='38'></textarea>\n";
        $return_value .= "</td>\n";
        $return_value .= "<td align='left' ><input type='button' class='button' onclick='sendmailtocandidate(" . $jobapplyid . ")' value='" . JText::_('Send') . "'> </td>\n";
        $return_value .= "</tr>\n";
        $return_value .= "</table>\n";
        $return_value .= "</table>\n";
        $return_value .= "</div>\n";
        

        $return_value = '<div id="js_job_app_actions">
                            <img class="image_close" onclick="closethisactiondiv();" src="components/com_jsjobs/include/images/act_no.png">';
                                
        $return_value .=    "<div class='email_to_canditate'>";
        $return_value .=        "<div class='left_column'>";
        $return_value .=            "<div class='field_f'>";
        $return_value .=                "<div class='title'>
                                            ".JText::_('Job Seeker')."
                                        </div>";
        $return_value .=                "<div class='value'>
                                            <input type='email' name='jsmailaddress' id='jsmailaddress' value='$jobseeker_email' readonly='readonly'/>
                                        </div>";
        $return_value .=                "<div class='title'>
                                            ".JText::_('Subject Line')."
                                        </div>";
        $return_value .=                "<div class='value'>
                                            <input type='text' name='jssubject' id='jssubject'/>
                                        </div>";
        $return_value .=                "<div class='title'>
                                            ".JText::_('Email Sender')."
                                        </div>";
        $return_value .=                "<div class='value'>
                                            <input type='email' name='emmailaddress' id='emmailaddress' class='email validate'/>
                                        </div>";
        $return_value .=            '</div>';
        $return_value .=        '</div>';
        $return_value .=        "<div class='mid_column'>
                                    <textarea name='candidatemessage' id='candidatemessage' rows='5' cols='38'></textarea>
                                </div>";
        $return_value .=        "<div class='right_column'>
                                    <input id='email_button' type='button' class='button' onclick='sendmailtocandidate(" . $jobapplyid . ")' value='" . JText::_('Send') . "'>
                                </div>";
        $return_value .=   '</div>';
        $return_value .='</div>';

        return $return_value;
    }

    function sendToCandidate($data) {
        $senderName = "";
        $senderemail = $data[0];
        $recipient = $data[1];
        $msgBody = $data[3];
        $msgSubject = $data[2];
        $message = JFactory::getMailer();
        if(empty($recipient)) return true; //incase empty email
        $message->addRecipient($recipient); //to email
        $message->setSubject($msgSubject);
        $message->setBody($msgBody);
        $sender = array($senderemail, $senderName);
        $message->setSender($sender);
        $message->IsHTML(true);
        $msg =array();
        if (!$message->send()){
            $msg['message'] = $message->sent();
            $msg['saved'] = 'error';
        }
        else{
            $msg['message'] = JText::_('Mail sent successfully');
            $msg['saved'] = 'ok';
        }
        return json_encode($msg);
    }

    function updateJobApplyActionStatus($jobid, $resumeid, $applyid, $action_status) {
        if (is_numeric($applyid) === false)
            return false;
        $db = JFactory::getDBO();
        $row = $this->getTable('jobapply');
        $msg = array();
        $config_email = $this->getJSModel('configuration')->getConfigByFor('email');

        $comments_data = array();
        $data = JRequest::get('post');
        if (!is_numeric($applyid))
            return false;
        if(!is_numeric($action_status)) return false;
        $query = "UPDATE `#__js_job_jobapply` SET action_status =" . $action_status . " WHERE id = " . $applyid;
        $db->setQuery($query);
        if (!$db->query()) {
            switch ($action_status) {
                case 2:
                    $msg['message'] = JText::_('Error in mark resume as spam');
                    break;
                case 3:
                    $msg['message'] = JText::_('Error in mark resume as hired');
                    break;
                case 1:
                    $msg['message'] = JText::_('Error in move resume to inbox');
                    break;
                case 4:
                    $msg['message'] = JText::_('Error in resume reject');
                    break;
                case 5:
                    $msg['message'] = JText::_('Error in saving candidate in shortlist');
                    break;
                $msg['saved'] = 'error';
            }
        } else {
            switch ($action_status) {
                case 2:
                    $msg['message'] = JText::_('Resume has been mark as spam');
                    $msg['saved'] = 'ok';
                    break;
                case 3:
                    $msg['message'] = JText::_('Job seeker has been hired');
                    $msg['saved'] = 'ok';
                    break;
                case 1:
                    $msg['message'] = JText::_('Resume has been unmarked as spam and moved to the inbox');
                    $msg['saved'] = 'ok';
                    break;
                case 4:
                    $msg['message'] = JText::_('Resume Rejected');
                    $msg['saved'] = 'ok';
                    break;
                case 5:
                    $msg['message'] = JText::_('Candidate successfully mark as shortlist');
                    $msg['saved'] = 'ok';
                    break;
            }
            $return_option = $this->getJSModel('emailtemplate')->getEmailOption('applied_resume_status' , 'jobseeker');
            if($return_option == 1){
                $this->sendMailtoJobseekerAppliedResumeUpdateStatus($jobid, $resumeid, $applyid, $action_status);
            }

        }

        return json_encode($msg);
    }

    function sendMailtoJobseekerAppliedResumeUpdateStatus($jobid, $resumeid, $applyid, $action_status) {
        if ($jobid)
            if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
                return false;
        if ($resumeid)
            if ((is_numeric($resumeid) == false) || ($resumeid == 0) || ($resumeid == ''))
                return false;
        if ($resumeid)
            if ((is_numeric($applyid) == false) || ($applyid == 0) || ($applyid == ''))
                return false;
        $config_email = $this->getJSModel('configuration')->getConfigByFor('email');
        $db = JFactory::getDBO();
        $templatefor = 'applied-resume_status';
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;

        $query = "SELECT resume.uid AS uid, resume.email_address AS email, job.title
			FROM `#__js_job_jobapply` AS apply
			JOIN `#__js_job_resume` AS resume ON apply.cvid=resume.id
			JOIN `#__js_job_jobs` AS job ON apply.jobid=job.id
			WHERE apply.id = " . $applyid;
        $db->setQuery($query);
        $result = $db->loadObject();
        if ($result) {
            switch ($action_status) {
                case 1:
                    $resume_status = "inbox";
                    break;
                case 2:
                    $resume_status = "spam";
                    break;
                case 3:
                    $resume_status = "hired";
                    break;
                case 4:
                    $resume_status = "rejected";
                    break;
                case 5:
                    $resume_status = "shortlist candidate";
                    break;
            }
            if ($result->uid == 0 || $result->uid == '') {
                $jobseekr_name = " Visitor ";
            } else {
                $userquery = "SELECT name, email FROM `#__users` 
									  WHERE id = " . $db->Quote($result->uid);
                $db->setQuery($userquery);
                $user = $db->loadObject();
                $jobseekr_name = " " . $user->name . "  ";
            }
            $job_title = $result->title;
            $jobseeker_email = $result->email;

            $msgBody = str_replace('{JOBSEEKER_NAME}', $jobseekr_name, $msgBody);
            $msgBody = str_replace('{RESUME_STATUS}', $resume_status, $msgBody);
            $msgBody = str_replace('{JOB_TITLE}', $job_title, $msgBody);

            $app = JApplication::getInstance('site');
            $router = $app->getRouter();
            $str = JURI::root();
            $sitaddress = str_replace('/administrator', '', $str);
            $newUrl = $sitaddress . 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs';
			// $newUrl = $router->build($newUrl);
			// $parsed_url = $newUrl->toString();
			$parsed_url = $newUrl;
			
            $applied_resume_status_link = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Status') . '</a>';
            $msgBody = str_replace('{STATUS}', $applied_resume_status_link, $msgBody);

            $senderName = $config_email['mailfromname'];
            $senderEmail = $config_email['mailfromaddress'];


            $send_email = 1;
            $data = array();
            $data['name'] = $jobseekr_name;
            $data['jobseeker_email'] = $jobseeker_email;
            $data['apply_status'] = $resume_status;
            $data['job_title'] = $job_title;
            $data['applied_job_link'] = $newUrl;
            $data['sender_name'] = $config_email['mailfromname'];
            $data['sender_email'] = $config_email['mailfromaddress'];

            if( JPluginHelper::isEnabled('extension','jsjobsjobapply') ){
                JPluginHelper::importPlugin('extension');
                $dispatcher = JEventDispatcher::getInstance();
                $response = $dispatcher->trigger('JSJobsJobApplyActionStatusChange',array($data));
                $send_email = $response[0];
            }


            $message = JFactory::getMailer();
            if($send_email == 1){
                if(!empty($jobseeker_email)){
                    $message->addRecipient($jobseeker_email); //to email

                    $message->setSubject($msgSubject);
                    $siteAddress = JURI::base();
                    $message->setBody($msgBody);
                    $sender = array($senderEmail, $senderName);
                    $message->setSender($sender);
                    $message->IsHTML(true);
                    $sent = $message->send();
                }
            }
            return true;
        }
        return false;
    }

    function storeResumeComments($data) {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $row = $this->getTable('jobapply');
        $row->id = $data['id'];
        $row->comments = $data['comments'];
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

    function storeShortListCandidatee($uid, $data) {
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        global $resumedata;
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        $data = JRequest::get('post');
        if (is_numeric($data['resumeid']) == false)
            return false;
        if (is_numeric($data['jobid']) == false)
            return false;
        if (is_numeric($uid) == false)
            return false;
        if ($this->shortListCandidateValidation($uid, $data['jobid'], $data['resumeid']) == false)
            return 3;
        $row = $this->getTable('shortlistcandidate');
        $row->uid = $uid;
        $row->jobid = $data['jobid'];
        $row->cvid = $data['resumeid'];
        $row->status = 0;
        $row->created = date('Y-m-d H:i:s');
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 2;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        return true;
    }

    function getJobAppliedResume($needle_array, $tab_action, $jobid, $limitstart, $limit) {
        if (is_numeric($jobid) == false)
            return false;
        $db = JFactory::getDBO();
        $result = array();
        if (!empty($needle_array)) {
            $needle_array = json_decode($needle_array, true);
            $tab_action = "";
        }
        $query = "SELECT COUNT(job.id)
		FROM `#__js_job_jobs` AS job
		   , `#__js_job_jobapply` AS apply  
		   , `#__js_job_resume` AS app  
		   
		WHERE apply.jobid = job.id AND apply.cvid = app.id AND apply.jobid = " . $jobid;
        if ($tab_action){
            if(!is_numeric($tab_action)) return false;
            $query.=" AND apply.action_status=" . $tab_action;
        }
        if (isset($needle_array['title']) AND $needle_array['title'] != '')
            $query.=" AND app.application_title LIKE '%" . str_replace("'", "", $db->Quote($needle_array['title'])) . "%'";
        if (isset($needle_array['name']) AND $needle_array['name'] != '')
            $query.=" AND LOWER(app.first_name) LIKE " . $db->Quote('%' . $needle_array['name'] . '%');
        if (isset($needle_array['nationality']) AND $needle_array['nationality'] != '')
            $query .= " AND app.nationality = " . $needle_array['nationality'];
        if (isset($needle_array['gender']) AND $needle_array['gender'] != '')
            $query .= " AND app.gender = " . $needle_array['gender'];
        if (isset($needle_array['jobtype']) AND $needle_array['jobtype'] != '')
            $query .= " AND app.jobtype = " . $needle_array['jobtype'];
        if (isset($needle_array['currency']) AND $needle_array['currency'] != '')
            $query .= " AND app.currencyid = " . $needle_array['currency'];
        if (isset($needle_array['jobsalaryrange']) AND $needle_array['jobsalaryrange'] != '')
            $query .= " AND app.jobsalaryrange = " . $needle_array['jobsalaryrange'];
        if (isset($needle_array['heighestfinisheducation']) AND $needle_array['heighestfinisheducation'] != '')
            $query .= " AND app.heighestfinisheducation = " . $needle_array['heighestfinisheducation'];
        if (isset($needle_array['iamavailable']) AND $needle_array['iamavailable'] != '') {
            $available = ($needle_array['iamavailable'] == "yes") ? 1 : 0;
            $query .= " AND app.iamavailable = " . $available;
        }
        if (isset($needle_array['jobcategory']) AND $needle_array['jobcategory'] != '')
            $query .= " AND app.job_category = " . $needle_array['jobcategory'];
        if (isset($needle_array['jobsubcategory']) AND $needle_array['jobsubcategory'] != '')
            $query .= " AND app.job_subcategory = " . $needle_array['jobsubcategory'];
        if (isset($needle_array['experience']) AND $needle_array['experience'] != '')
            $query .= " AND app.total_experience LIKE " . $db->Quote($needle_array['experience']);


        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT DISTINCT apply.comments,apply.id AS jobapplyid , job.title AS jobtitle, job.id,job.agefrom,job.ageto, cat.cat_title ,apply.apply_date, apply.resumeview, jobtype.title AS jobtypetitle,app.iamavailable
                        , app.id AS appid, app.first_name, app.last_name, app.email_address, app.jobtype,app.gender
                        , app.total_experience, app.jobsalaryrange,rating.id AS ratingid, rating.rating
                        , app.id as resumeid
                        ,city.id AS cityid,job.hits AS jobview
                        ,(SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE jobid = job.id) AS totalapply
                        , salary.rangestart, salary.rangeend,education.title AS educationtitle
                        , currency.symbol AS symbol
                        ,dcurrency.symbol AS dsymbol ,dsalary.rangestart AS drangestart, dsalary.rangeend AS drangeend  
                        ,institutes.institute_study_area AS education
                        ,app.photo AS photo,app.application_title AS applicationtitle
                        ,CONCAT(app.alias,'-',app.id) resumealiasid, CONCAT(job.alias,'-',job.id) AS jobaliasid
                        ,cletter.id AS cletterid, cletter.title AS clettertitle,  cletter.description AS cletterdescription 
                        ,exp.title AS exptitle,saltype.title AS rangetype,dsaltype.title AS drangetype
                        
                        FROM `#__js_job_jobapply` AS apply
                        JOIN `#__js_job_jobs` AS job  ON job.id = apply.jobid
                        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                        JOIN `#__js_job_resume` AS app ON apply.cvid = app.id 
                        LEFT JOIN `#__js_job_resumeinstitutes` AS institutes ON app.id = institutes.resumeid
                        LEFT JOIN `#__js_job_resumeemployers` AS employers ON app.id = employers.resumeid
                        LEFT JOIN `#__js_job_resumereferences` AS reference ON app.id = reference.resumeid
                        LEFT JOIN `#__js_job_resumelanguages` AS languages ON app.id = languages.resumeid
                        LEFT JOIN  `#__js_job_resumerating` AS rating ON (app.id=rating.resumeid AND apply.jobid=rating.jobid)
                        LEFT JOIN `#__js_job_heighesteducation` AS  education  ON app.heighestfinisheducation=education.id
                        LEFT JOIN  `#__js_job_salaryrange` AS salary  ON  app.jobsalaryrange=salary.id
                        LEFT JOIN  `#__js_job_salaryrange` AS dsalary ON app.desired_salary=dsalary.id 
                        LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address_city FROM `#__js_job_resumeaddresses` WHERE resumeid = app.id ORDER BY id DESC LIMIT 1) 
                        LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = app.currencyid
                        LEFT JOIN `#__js_job_currencies` AS dcurrency ON dcurrency.id = app.dcurrencyid 
                        LEFT JOIN `#__js_job_coverletters` AS cletter ON apply.coverletterid = cletter.id 
                        LEFT JOIN `#__js_job_experiences` AS exp ON exp.id = app.experienceid 
                        LEFT JOIN `#__js_job_salaryrangetypes` AS dsaltype ON dsaltype.id = app.djobsalaryrangetype 
                        LEFT JOIN `#__js_job_salaryrangetypes` AS saltype ON saltype.id = app.jobsalaryrangetype 
                        WHERE apply.jobid = " . $jobid;
        if ($tab_action)
            $query.=" AND apply.action_status=" . $tab_action;
        if (isset($needle_array['title']) AND $needle_array['title'] != '')
            $query.=" AND app.application_title LIKE '%" . str_replace("'", "", $db->Quote($needle_array['title'])) . "%'";
        if (isset($needle_array['name']) AND $needle_array['name'] != '')
            $query.=" AND LOWER(app.first_name) LIKE " . $db->Quote('%' . $needle_array['name'] . '%');
        if (isset($needle_array['nationality']) AND $needle_array['nationality'] != '')
            $query .= " AND app.nationality = " . $needle_array['nationality'];
        if (isset($needle_array['gender']) AND $needle_array['gender'] != '')
            $query .= " AND app.gender = " . $needle_array['gender'];
        if (isset($needle_array['jobtype']) AND $needle_array['jobtype'] != '')
            $query .= " AND app.jobtype = " . $needle_array['jobtype'];
        if (isset($needle_array['currency']) AND $needle_array['currency'] != '')
            $query .= " AND app.currencyid = " . $needle_array['currency'];
        if (isset($needle_array['jobsalaryrange']) AND $needle_array['jobsalaryrange'] != '')
            $query .= " AND app.jobsalaryrange = " . $needle_array['jobsalaryrange'];
        if (isset($needle_array['heighestfinisheducation']) AND $needle_array['heighestfinisheducation'] != '')
            $query .= " AND app.heighestfinisheducation = " . $needle_array['heighestfinisheducation'];
        if (isset($needle_array['iamavailable']) AND $needle_array['iamavailable'] != '') {
            $available = ($needle_array['iamavailable'] == "yes") ? 1 : 0;
            $query .= " AND app.iamavailable = " . $available;
        }
        if (isset($needle_array['jobcategory']) AND $needle_array['jobcategory'] != '')
            $query .= " AND app.job_category = " . $needle_array['jobcategory'];
        if (isset($needle_array['jobsubcategory']) AND $needle_array['jobsubcategory'] != '')
            $query .= " AND app.job_subcategory = " . $needle_array['jobsubcategory'];
        if (isset($needle_array['experience']) AND $needle_array['experience'] != '')
            $query .= " AND app.total_experience LIKE " . $db->Quote($needle_array['experience']);

        $query .= " GROUP BY app.id ORDER BY apply.apply_date DESC";

        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $result[0] = $this->_application;
        $result[1] = $total;

        // resume count -> named as appCounts starts here 
        $resumeCountPerTab = array();
        $resumeCountPerTab['inbox'] = $this->resumeCountPerTab(1, $jobid);
        $resumeCountPerTab['shortlist'] = $this->resumeCountPerTab(5, $jobid);
        $resumeCountPerTab['spam'] = $this->resumeCountPerTab(2, $jobid);
        $resumeCountPerTab['hired'] = $this->resumeCountPerTab(3, $jobid);
        $resumeCountPerTab['rejected'] = $this->resumeCountPerTab(4, $jobid);
        $result[3] = $resumeCountPerTab;
        return $result;
    }

    function resumeCountPerTab($tabNumber = '', $jobid) {
        $db = $this->getDBO();
        $tabCount = 0;
        if ($tabNumber == 0) {
            return false;
        }
        if(!is_numeric($jobid)) return false;
        $query = "SELECT COUNT(apply.id)
                    FROM `#__js_job_jobapply` AS apply
                    WHERE apply.jobid = " . $jobid .
                " AND apply.action_status = " . $tabNumber;
        $db->setQuery($query);
        $tabCount = $db->loadResult();
        return $tabCount;
    }

    function getJobAppliedResumeSearchOption($needle_array) {

        $gender = array(
            '0' => array('value' => '', 'text' => JText::_('All')),
            '1' => array('value' => 1, 'text' => JText::_('Male')),
            '2' => array('value' => 2, 'text' => JText::_('Female')),);


        if($needle_array)
            $needle_array = json_decode($needle_array, TRUE);

        $nationality = $this->getJSModel('country')->getCountries(JText::_('All'));
        $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('All'));
        $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('All'));
        $job_categories = $this->getJSModel('category')->getCategories(JText::_('All'));
        $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($job_categories[1]['value'], JText::_('All'), '');
        $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('All'), '');
        $job_currency = $this->getJSModel('currency')->getCurrencyResumeApplied(JText::_('Select'));

        $searchoptions['nationality'] = JHTML::_('select.genericList', $nationality, 'nationality', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['nationality']) ? $needle_array['nationality'] : '' );
        $searchoptions['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'jobsubcategory\', this.value)"', 'value', 'text', isset($needle_array['jobcategory']) ? $needle_array['jobcategory'] : '' );
        $searchoptions['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'jobsubcategory', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['jobsubcategory']) ? $needle_array['jobsubcategory'] : '' );
        $searchoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['jobsalaryrange']) ? $needle_array['jobsalaryrange'] : '' );
        $searchoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['jobtype']) ? $needle_array['jobtype'] : '' );
        $searchoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['heighestfinisheducation']) ? $needle_array['heighestfinisheducation'] : '' );
        $searchoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['gender']) ? $needle_array['gender'] : '' );
        $searchoptions['currency'] = JHTML::_('select.genericList', $job_currency, 'currency', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['currency']) ? $needle_array['currency'] : '' );
        $result = array();
        $result[0] = $searchoptions;
        return $result;
    }

    function storeShortListCandidate($uid, $resumeid, $jobid) {
        if (is_numeric($resumeid) == false)
            return false;
        if (is_numeric($jobid) == false)
            return false;
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if ($this->shortListCandidateValidation($uid, $jobid, $resumeid) == false)
            return 3;

        $row = $this->getTable('shortlistcandidate');
        $row->uid = $uid;
        $row->jobid = $jobid;
        $row->cvid = $resumeid;
        $row->status = 1;
        $row->created = date('Y-m-d H:i:s');

        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 2;
        }
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        return true;
    }

    function shortListCandidateValidation($uid, $jobid, $resumeid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if (is_numeric($jobid) == false)
            return false;
        if (is_numeric($resumeid) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT COUNT(id) FROM #__js_job_shortlistcandidates
		WHERE jobid = " . $jobid . " AND cvid = " . $resumeid;
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result == 0)
            return true;
        else
            return false;
    }

}

?>