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

class JSJobsModelEmailTemplate extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function sendToCandidate($data) {
        $senderName = "";
        $senderemail = $data[0];
        $recipient = $data[1];
        $msgBody = $data[3];
        $msgSubject = $data[2];
        $message = JFactory::getMailer();
        if(!empty($recipient)){
            $message->addRecipient($recipient); //to email
            $message->setSubject($msgSubject);
            $message->setBody($msgBody);
            $sender = array($senderemail, $senderName);
            $message->setSender($sender);
            $message->IsHTML(true);
            if (!$message->send())
                $sent = $message->sent();
            else
                $sent = true;
        }
        $sent = true;
        $msg=array();
        if($sent == true){
            $msg['status'] = 'ok';
            $msg['msg'] = JText::_('Email has been sent');
        }else{
            $msg['status'] = 'error';
            $msg['msg'] = JText::_('Email has not been sent');
        }
        return json_encode($msg);
    }

    function sendMail($jobid, $uid, $resumeid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if ($jobid)
            if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
                return false;
        if ($resumeid)
            if ((is_numeric($resumeid) == false) || ($resumeid == 0) || ($resumeid == ''))
                return false;
        $db = JFactory::getDBO();

        $return_option = $this->getEmailOption('jobapply_jobapply' , 'employer');
        if($return_option == 1){

            $Itemid = JRequest::getVar('Itemid');
            $templatefor = 'jobapply-jobapply';
            $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
            $db->setQuery($query);
            $template = $db->loadObject();
            $msgSubject = $template->subject;
            $msgBody = $template->body;

            $jobquery = "SELECT company.contactname AS name, company.contactemail AS email, job.title, job.sendemail 
                FROM `#__js_job_companies` AS company
                JOIN `#__js_job_jobs` AS job ON job.companyid = company.id  
                WHERE job.id = " . $jobid;

            $db->setQuery($jobquery);
            $jobuser = $db->loadObject();
            $cansendemail = true;
            if ($jobuser->sendemail != 0) {
                $userquery = "SELECT CONCAT(first_name,' ',last_name) AS name, email_address AS email,params FROM `#__js_job_resume`
                WHERE id = " . $db->Quote($resumeid);
                $db->setQuery($userquery);
                $user = $db->loadObject();

                $ApplicantName = $user->name;
                $EmployerEmail = $jobuser->email;
                $EmployerName = $jobuser->name;
                $JobTitle = $jobuser->title;

                $msgSubject = str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgSubject);
                $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
                $msgBody = str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgBody);
                $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
                //custom fields in email
                $params = empty($user->params) ? array() : json_decode($user->params,true);
                $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(3);
                foreach ($fields as $field){
                    if($field->userfieldtype != 'file'){
                        $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                        $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                    }
                }

                $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
                $senderName = $emailconfig['mailfromname'];
                $senderEmail = $emailconfig['mailfromaddress'];
                $check_fields_send = $emailconfig['employer_resume_alert_fields'];

                $message = JFactory::getMailer();
               // if(empty($EmployerEmail)) return true; // incase employer email is empty
                $message->addRecipient($EmployerEmail); //to email
                    $message->setSubject($msgSubject);
                $siteAddress = JURI::base();
                if ($jobuser->sendemail == 2) { // email with attachment
                    if ($check_fields_send) {
                            $this->sendJobApplyResumeAlertEmployer($resumeid, $check_fields_send, $EmployerEmail, $msgSubject, $msgBody, $senderEmail, $senderName, $jobid);
                            $cansendemail = false; // already send email, not send again.
                    } else {
                        $resumequery = "SELECT resume.id,CONCAT(resume.alias,'-',resume.id) AS aliasid,resume.params 
                        FROM `#__js_job_resume` AS resume WHERE resume.id = " . $resumeid;
                        $db->setQuery($resumequery);
                        $resume = $db->loadObject();

                        //code for the multiple files added in the email
                        $query = "SELECT resumefile.filename FROM `#__js_job_resumefiles` AS resumefile WHERE resumefile.resumeid = ".$resumeid;
                        $db->setQuery($query);
                        $resumefiles = $db->loadObjectList();
                        if(!empty($resumefiles)){
                            foreach($resumefiles AS $file){
                                $iddir = 'resume_' . $resumeid;
                                if (!isset($this->_config))
                                    $this->getJSModel('configurations')->getConfig('');
                                foreach ($this->_config as $conf) {
                                    if ($conf->configname == 'data_directory')
                                        $datadirectory = $conf->configvalue;
                                }
                                $path = JPATH_BASE . '/' . $datadirectory;
                                $path = $path . '/data/jobseeker/' . $iddir . '/resume/' . $file->filename;
                                $message->addAttachment($path);
                            }
                        }

                        $app = JApplication::getInstance('site');
                        $router = $app->getRouter();
                        $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($resume->aliasid);
                        $newUrl = JURI::root() . 'index.php?option=com_jsjobs&c=jsjobs&view=resume&layout=view_resume&nav=6&rd=' . $resumealiasid . '&bd=' . $jobid.'&Itemid='.$Itemid;
                        //$newUrl = $router->build($newUrl);
                        //$parsed_url = $newUrl->toString();
                        $parsed_url = $newUrl;
                        $applied_resume_link = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Resume') . '</a>';
                        $msgBody = str_replace('{RESUME_LINK}', $applied_resume_link, $msgBody);
                        $msgBody = str_replace('{RESUME_DATA}', '', $msgBody);
                        //custom fields in email
                        $params = empty($resume->params) ? array() : json_decode($resume->params,true);
                        $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(3);
                        foreach ($fields as $field){
                            if($field->userfieldtype != 'file'){
                                $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                                $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                            }
                        }
                        echo $msgBody;
                        exit;
                    }
                }else {
                    $resumequery = "SELECT resume.id, CONCAT(resume.alias,'-',resume.id) AS aliasid 
                        FROM `#__js_job_resume` AS resume WHERE resume.id = " . $resumeid;

                    $db->setQuery($resumequery);
                    $resume = $db->loadObject();
                    //code for the multiple files added in the email
                    $query = "SELECT resumefile.filename FROM `#__js_job_resumefiles` AS resumefile WHERE resumefile.resumeid = ".$resumeid;
                    $db->setQuery($query);
                    $resumefiles = $db->loadObjectList();

                    if (!empty($resumefiles)) {
                        foreach($resumefiles AS $file){
                            $iddir = 'resume_' . $resumeid;
                            if (!isset($this->_config))
                                $this->getJSModel('configurations')->getConfig('');
                            foreach ($this->_config as $conf) {
                                if ($conf->configname == 'data_directory')
                                    $datadirectory = $conf->configvalue;
                            }
                            $path = JPATH_BASE . '/' . $datadirectory;
                            $path = $path . '/data/jobseeker/' . $iddir . '/resume/' . $file->filename;
                            $message->addAttachment($path);
                        }
                    }
                    $app = JApplication::getInstance('site');
                    $router = $app->getRouter();
                    $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($resume->aliasid);
                    $newUrl = JURI::root() . 'index.php?option=com_jsjobs&c=jsjobs&view=resume&layout=view_resume&nav=6&rd=' . $resumealiasid . '&bd=' . $jobid.'&Itemid='.$Itemid;
                    //$newUrl = $router->build($newUrl);
                    //$parsed_url = $newUrl->toString();
                    $parsed_url = $newUrl;
                    $applied_resume_link = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Resume') . '</a>';
                    $msgBody = str_replace('{RESUME_LINK}', $applied_resume_link, $msgBody);
                    $msgBody = str_replace('{RESUME_DATA}', '', $msgBody);
                    //custom fields in email
                    $params = empty($resume->params) ? array() : json_decode($resume->params,true);
                    $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(3);
                    foreach ($fields as $field){
                        if($field->userfieldtype != 'file'){
                            $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                            $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                        }
                    }
                }

                if ($cansendemail == true) {
                    $message->setBody($msgBody);
                    $sender = array($senderEmail, $senderName);
                    $message->setSender($sender);
                    $message->IsHTML(true);
                    $sent = $message->send();
                    //return $sent;
                } else{
                    //return true;
                }
            }
        }
        
        $return_option = $this->getEmailOption('jobapply_jobapply' , 'jobseeker');
        if($return_option == 1){
            $Itemid = JRequest::getVar('Itemid');
            $templatefor = 'jobapply-jobseeker';
            
            $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
            $db->setQuery($query);
            $template = $db->loadObject();
            $msgSubject = $template->subject;
            $msgBody = $template->body;

            $jobquery = "SELECT company.contactname AS name, company.contactemail AS email, job.title, job.sendemail,job.params
                FROM `#__js_job_companies` AS company
                JOIN `#__js_job_jobs` AS job ON job.companyid = company.id  
                WHERE job.id = " . $jobid;


            $db->setQuery($jobquery);
            $job = $db->loadObject();

            $userquery = "SELECT CONCAT(first_name,' ',last_name) AS name, application_title, email_address AS email FROM `#__js_job_resume`
            WHERE id = " . $db->Quote($resumeid);
            $db->setQuery($userquery);
            $resume = $db->loadObject();

            $Email = $resume->email;
            $JobTitle = $job->title;
            $ApplicantName = $resume->name;
            $Application_title = $resume->application_title;
            $EmployerName = $job->name;
            
            $query = "SELECT apply.action_status
                    FROM `#__js_job_jobapply` AS apply
                    JOIN `#__js_job_jobs` AS job ON job.id = apply.jobid
                    JOIN `#__js_job_resume` AS resume ON resume.id = apply.cvid
                    WHERE apply.cvid = $resumeid AND apply.jobid = $jobid";
            $db->setQuery($query);
            $action_status = $db->loadResult();

            switch ($action_status) {
                case 2:
                    $resume_status = "spam";
                    break;
                case 3:
                    $resume_status = "hired";
                    break;
                case 1:
                    $resume_status = "inbox";
                    break;
                case 4:
                    $resume_status = "rejected";
                    break;
                case 5:
                    $resume_status = "shortlist candidate";
                    break;
            }



            $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);

            $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
            $msgBody = str_replace('{JOBSEEKER_NAME}', $ApplicantName, $msgBody);
            $msgBody = str_replace('{RESUME_TITLE}', $Application_title, $msgBody);
            $msgBody = str_replace('{COMPANY_NAME}', $EmployerName, $msgBody);
            $msgBody = str_replace('{RESUME_APPLIED_STATUS}', $resume_status, $msgBody);
            //custom fields in email
            $params = empty($job->params) ? array() : json_decode($job->params,true);
            $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(2);
            foreach ($fields as $field){
                if($field->userfieldtype != 'file'){
                    $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                    $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                }
            }

            $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
            $senderName = $emailconfig['mailfromname'];
            $senderEmail = $emailconfig['mailfromaddress'];

            $message = JFactory::getMailer();
            if(empty($Email))
                return true;

            $message->addRecipient($Email);
            $message->setSubject($msgSubject);
            $message->setBody($msgBody);
            $sender = array($senderEmail, $senderName);
            $message->setSender($sender);
            $message->IsHTML(true);
            $sent = $message->send();
            return $sent;
        }
    }

    function sendMailtoEmployerNewCompany($companyid, $uid) {

        if(!is_numeric($companyid))
            return false;
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;

        $db = JFactory::getDBO();
        $Itemid = JRequest::getVar('Itemid');

        $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
        $senderName = $emailconfig['mailfromname'];
        $senderEmail = $emailconfig['mailfromaddress'];

        $issendemail = false;
        $return_option = $this->getJSModel('emailtemplate')->getEmailOption('add_new_company' , 'employer');
        if($return_option == 1){
            $issendemail = 1;
        }

        $templatefor = 'company-new';
        
        if ($issendemail == 1) {
            $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
            $db->setQuery($query);
            $template = $db->loadObject();
            $msgSubject = $template->subject;
            $msgBody = $template->body;

            $jobquery = "SELECT company.name AS companyname, company.id AS id, company.contactname AS name, company.contactemail AS email,company.params 
                        FROM `#__js_job_companies` AS company
                        WHERE company.uid = " . $uid . "  AND company.id = " . $companyid;
            $db->setQuery($jobquery);
            $user = $db->loadObject();
            $EmployerEmail = $user->email;
            $EmployerName = $user->name;
            $CompanyName = $user->companyname;

            $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
            $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);

            $itemid = JRequest::getVar('Itemid');
            $companylink = JRoute::_(JURI::root().'index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid='.$itemid ,false);
            $companylink = '<a href="'.$companylink.'" target="_blank">'.JText::_('Company').'</a>';
            $msgBody = str_replace('{COMPANY_LINK}', $companylink, $msgBody);
            //custom fields in email
            $params = empty($user->params) ? array() : json_decode($user->params,true);
            $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(1);
            foreach ($fields as $field){
                if($field->userfieldtype != 'file'){
                    $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                    $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                }
            }

            $message = JFactory::getMailer();
            if(!empty($EmployerEmail)){
                $message->addRecipient($EmployerEmail); //to email
                $message->setSubject($msgSubject);
                $siteAddress = JURI::base();
                $message->setBody($msgBody);
                $sender = array($senderEmail, $senderName);
                $message->setSender($sender);
                $message->IsHTML(true);
                $sent = $message->send();
                return $sent;
            }
            return true;
        }
    }

    function sendMailtoEmployerNewJob($jobid, $uid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if ($jobid)
            if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
                return false;
        $db = JFactory::getDBO();
        $Itemid = JRequest::getVar('Itemid');
        $templatefor = 'job-new-employer';
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;

        $jobquery = "SELECT company.contactname AS name, company.name AS companyname, job.title AS jobtitle, department.name AS departmentname, category.cat_title AS categorytitle, jobtype.title AS jobtypetitle, job.status AS jobstatus, company.contactemail AS email,job.params
                        FROM `#__js_job_jobs` AS job 
                        JOIN `#__js_job_companies` AS company ON company.id = job.companyid 
                        JOIN `#__js_job_categories` AS category ON category.id = job.jobcategory 
                        LEFT JOIN `#__js_job_departments` AS department ON department.id = job.departmentid 
                        LEFT JOIN `#__js_job_jobtypes` AS jobtype ON jobtype.id = job.jobtype 
                        WHERE job.id = " . $jobid;
        $db->setQuery($jobquery);
        $jobuser = $db->loadObject();
        $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
        $cansendemail = 1;

        if ($cansendemail == 1) {
            $EmployerName = $jobuser->name;
            $EmployerEmail = $jobuser->email;
            $JobTitle = $jobuser->jobtitle;
            $CompanyName = $jobuser->companyname;
            $DepartmentName = $jobuser->departmentname;
            $CategoryTitle = $jobuser->categorytitle;
            $JobTypeTitle = $jobuser->jobtypetitle;
            $JobStatus = $jobuser->jobstatus;
            switch($JobStatus){
                case 1: $JobStatus = '<strong style="color:#99D000;">'.JText::_('Approved').'</strong>';break;
                case -1: $JobStatus = '<strong style="color:#E22828;">'.JText::_('Rejected').'</strong>';break;
                case 0: $JobStatus = '<strong style="color:#FEA702;">'.JText::_('Waiting for approval').'</strong>';break;
            }

            $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
            $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
            $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
            $msgSubject = str_replace('{DEPARTMENT_NAME}', $DepartmentName, $msgSubject);
            $msgSubject = str_replace('{CATEGORY_TITLE}', $CategoryTitle, $msgSubject);
            $msgSubject = str_replace('{JOB_TYPE_TITLE}', $JobTypeTitle, $msgSubject);
            $msgSubject = str_replace('{JOB_STATUS}', $JobStatus, $msgSubject);
            $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
            $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
            $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
            $msgBody = str_replace('{DEPARTMENT_NAME}', $DepartmentName, $msgBody);
            $msgBody = str_replace('{CATEGORY_TITLE}', $CategoryTitle, $msgBody);
            $msgBody = str_replace('{JOB_TYPE_TITLE}', $JobTypeTitle, $msgBody);
            $msgBody = str_replace('{JOB_STATUS}', $JobStatus, $msgBody);
            $itemid = JRequest::getVar('Itemid');
            $joblink = JRoute::_(JURI::root().'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid='.$itemid ,false);
            $joblink = '<a href="'.$joblink.'" target="_blank">'.JText::_('Job').'</a>';
            $msgSubject = str_replace('{JOB_LINK}', $joblink, $msgSubject);
            $msgBody = str_replace('{JOB_LINK}', $joblink, $msgBody);
            //custom fields in email
            $params = empty($jobuser->params) ? array() : json_decode($jobuser->params,true);
            $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(2);
            foreach ($fields as $field){
                if($field->userfieldtype != 'file'){
                    $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                    $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                }
            }

            $senderName = $emailconfig['mailfromname'];
            $senderEmail = $emailconfig['mailfromaddress'];
            $check_fields_send = $emailconfig['employer_resume_alert_fields'];
            $message = JFactory::getMailer();
            if(!empty($EmployerEmail)){
                $message->addRecipient($EmployerEmail); //to email
                $message->setSubject($msgSubject);

                $message->setBody($msgBody);
                $sender = array($senderEmail, $senderName);
                $message->setSender($sender);
                $message->IsHTML(true);
                $sent = $message->send();
                return $sent;
            }
            return true;
        }
        return true;
    }

    function getRowForResume($title, $value, &$msgBody, $published) {
        if ($published == 1) {
            $msgBody .= "<tr style='background: #eee;'>";
            $msgBody .= "<td><strong>" . $title . "</strong></td>";
            $msgBody .= "<td>" . $value . "</td></tr>";
        }
    }

    function getUserFieldRowForResume($object, $field, $customfieldobj , &$msgBody) {
        if ($this->_client_auth_key != "") {
            
        } else {
            $field = $field->field;
            $arr = $customfieldobj->showCustomFields($field, 11 ,$object);
            if(!$arr)
                return '';
            $title = $arr['title'];
            $value = $arr['value'];
            
            $msgBody .= "<tr style='background: #eee;'>";
            $msgBody .= "<td><strong>" . $title . "</strong></td>";
            $msgBody .= "<td>" . $value . "</td></tr>";
        }
    }

    function sendJobApplyResumeAlertEmployer($resumeid, $check_fields_send, $EmployerEmail, $msgSubject, $msgBody, $senderEmail, $senderName, $job_id_mail_link) {

        $db = JFactory::getDBO();
        $Itemid = JRequest::getVar('Itemid');
        $user = JFactory::getUser();
        $uid = $user->id;
        $myresume = 1;
        $jobid = "";
        $message = JFactory::getMailer();
        if(empty($EmployerEmail)) return true; // incase empty email
        $message->addRecipient($EmployerEmail); //to email
        $result = array();

        $customfieldobj = getCustomFieldClass();

        $message->setSubject($msgSubject);
        $siteAddress = JURI::base();
        if($uid != 0){
            $result = $this->getJSModel('resume')->getResumeViewbyId($uid, $jobid, $resumeid, $myresume);
        }else{
            $result = $this->getJSModel('resume')->getResumeViewbyIdForVisitor($resumeid);
        }
        $personalInfo = $result['personal'];
        $addresses = $result['addresses'];
        $institutes = $result['institutes'];
        $employers = $result['employers'];
        $references = $result['references'];
        $languages = $result['languages'];
        $fieldsordering = $result['fieldsordering'];
        $acutalBody = $msgBody;
        $msgBody = "<table cellpadding='5' style='border-color: #666;' cellspacing='0' border='0' width='100%'>";
        if(isset($fieldsordering['personal']))
        foreach ($fieldsordering['personal'] as $field) {
            switch ($field->field) {
                case "section_personal":
                    $msgBody .= "<tr style='background: #eee;'>";
                    $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Personal Information') . "</strong></td></tr>";
                    break;
                case "application_title":
                    $this->getRowForResume(JText::_('Application Title'), $personalInfo->application_title, $msgBody, $field->published);
                    break;
                case "first_name":
                    $this->getRowForResume(JText::_('First Name'), $personalInfo->first_name, $msgBody, $field->published);
                    break;
                case "middle_name":
                    $this->getRowForResume(JText::_('Middle Name'), $personalInfo->middle_name, $msgBody, $field->published);
                    break;
                case "last_name":
                    $this->getRowForResume(JText::_('Last Name'), $personalInfo->last_name, $msgBody, $field->published);
                    break;
                case "email_address":
                    $this->getRowForResume(JText::_('Email Address'), $personalInfo->email_address, $msgBody, $field->published);
                    break;
                case "home_phone":
                    $this->getRowForResume(JText::_('Home Phone'), $personalInfo->home_phone, $msgBody, $field->published);
                    break;
                case "work_phone":
                    $this->getRowForResume(JText::_('Work Phone'), $personalInfo->work_phone, $msgBody, $field->published);
                    break;
                case "cell":
                    $this->getRowForResume(JText::_('Cell'), $personalInfo->cell, $msgBody, $field->published);
                    break;
                case "gender":
                    $genderText = '';
                    if($personalInfo->gender == 1){
                        $genderText = JText::_('Male');
                    }elseif ($personalInfo->gender == 1) {
                        $genderText = JText::_('Female');
                    }elseif ($personalInfo->gender == 3) {
                        $genderText = JText::_('Does not matter');
                    }
                    $this->getRowForResume(JText::_('Gender'), $genderText, $msgBody, $field->published);
                    break;
                case "iamavailable":
                    $availableText = ($personalInfo->iamavailable == 1) ? JText::_('Yes') : JText::_('No');
                    $this->getRowForResume(JText::_('I Am Available'), $availableText, $msgBody, $field->published);
                    break;
                case "nationality":
                    $this->getRowForResume(JText::_('Country'), $personalInfo->nationalitycountry, $msgBody, $field->published);
                    break;
                case "section_moreoptions":
                    if ($field->published == 1) {
                        $msgBody .= "<tr style='background: #eee;'>";
                        $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Basic Information') . "</strong></td></tr>";
                    }
                    break;
                case "category":
                    $this->getRowForResume(JText::_('Category'), $personalInfo->categorytitle, $msgBody, $field->published);
                    break;
                case "salary":
                    $currencyalign = $this->getJSModel('configurations')->getConfigByFor('currency_align');
                    $salary = $this->getJSModel('common')->getSalaryRangeView($personalInfo->symbol,$personalInfo->rangestart,$personalInfo->rangeend,$personalInfo->salarytype,$currencyalign);
                    $this->getRowForResume(JText::_('Salary'), $salary, $msgBody, $field->published);
                    break;
                case "jobtype":
                    $this->getRowForResume(JText::_('Work Preference'), $personalInfo->jobtypetitle, $msgBody, $field->published);
                    break;
                case "heighestfinisheducation":
                    $this->getRowForResume(JText::_('Highest Finished Education'), $personalInfo->heighesteducationtitle, $msgBody, $field->published);
                    break;
                case "total_experience":
                    $this->getRowForResume(JText::_('Total Experience'), $personalInfo->total_experience, $msgBody, $field->published);
                    break;
                case "start_date":
                    $this->getRowForResume(JText::_('Date You Can Start'), $personalInfo->date_start, $msgBody, $field->published);
                    break;
                case "date_of_birth":
                    $this->getRowForResume(JText::_('Date Of Birth'), $personalInfo->date_of_birth, $msgBody, $field->published);
                    break;
                default:
                    $this->getUserFieldRowForResume($personalInfo, $field, $customfieldobj, $msgBody);
                    break;
            }
        }

        $i = 0;
        $msgBody .= "<tr style='background: #eee;'>";
        $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Address') . "</strong></td></tr>";
        if(isset($addresses))
        foreach ($addresses as $address) {
            $i++;
            foreach ($fieldsordering['address'] as $field) {
                switch ($field->field) {
                    case "section_address":
                        if ($field->published == 1) {
                            $msgBody .= "<tr style='background: #eee;'>";
                            $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Address') . "-" . $i . "</strong></td></tr>";
                        }
                        break;
                    case "address_city":
                        $defaultaddressdisplaytype = $this->getJSModel('configurations')->getConfigByFor('defaultaddressdisplaytype');
                        $this->getRowForResume(JText::_('City'), JText::_($address->address_cityname) , $msgBody, $field->published);
                        switch ($defaultaddressdisplaytype){
                            case 'csc':
                                $this->getRowForResume(JText::_('State'), JText::_($address->address_statename) , $msgBody, $field->published);
                                $this->getRowForResume(JText::_('Country'), JText::_($address->address_countryname) , $msgBody, $field->published);
                            break;
                            case 'cs':
                                $this->getRowForResume(JText::_('State'), JText::_($address->address_statename) , $msgBody, $field->published);
                            break;
                            case 'cc':
                                $this->getRowForResume(JText::_('Country'), JText::_($address->address_countryname) , $msgBody, $field->published);
                            break;
                        }
                        break;
                    case "address_zipcode":
                        $this->getRowForResume(JText::_('Zip Code'), $address->address_zipcode, $msgBody, $field->published);
                        break;
                    case "address":
                        $this->getRowForResume(JText::_('Address'), $address->address, $msgBody, $field->published);
                        break;
                    default:
                        $this->getUserFieldRowForResume($address, $field, $customfieldobj, $msgBody);
                        break;
                }
            }
        }
        $i = 0;
        $msgBody .= "<tr style='background: #eee;'>";
        $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Institutes') . "</strong></td></tr>";
        if(isset($institutes))
        foreach ($institutes as $institute) {
            $i++;
            foreach ($fieldsordering['institute'] as $field) {
                switch ($field->field) {
                    case "section_education":
                        if ($field->published == 1) {
                            $msgBody .= "<tr style='background: #eee;'>";
                            $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Institute') . "-" . $i . "</strong></td></tr>";
                        }
                        break;
                    case "institute":
                        $this->getRowForResume(JText::_('Institution Name'), $institute->institute, $msgBody, $field->published);
                        break;
                    case "institute_city":
                        $defaultaddressdisplaytype = $this->getJSModel('configurations')->getConfigByFor('defaultaddressdisplaytype');
                        $this->getRowForResume(JText::_('City'), JText::_($institute->institute_cityname), $msgBody, $field->published);
                        switch ($defaultaddressdisplaytype){
                            case 'csc':
                                $this->getRowForResume(JText::_('State'), JText::_($institute->institute_statename), $msgBody, $field->published);
                                $this->getRowForResume(JText::_('Country'), JText::_($institute->institute_countryname), $msgBody, $field->published);
                            break;
                            case 'cs':
                                $this->getRowForResume(JText::_('State'), JText::_($institute->institute_statename), $msgBody, $field->published);
                            break;
                            case 'cc':
                                $this->getRowForResume(JText::_('Country'), JText::_($institute->institute_countryname), $msgBody, $field->published);
                            break;
                        }
                        break;
                    case "institute_address":
                        $this->getRowForResume(JText::_('Address'), $institute->institute_address, $msgBody, $field->published);
                        break;
                    case "institute_certificate":
                        $this->getRowForResume(JText::_('Cert/deg/oth'), $institute->institute_certificate, $msgBody, $field->published);
                        break;
                    case "institute_study_area":
                        $this->getRowForResume(JText::_('Area Of Study'), $institute->institute_study_area, $msgBody, $field->published);
                        break;
                    default:
                        $this->getUserFieldRowForResume($institute, $field, $customfieldobj, $msgBody);
                        break;
                }
            }
        }
        $i = 0;
        $msgBody .= "<tr style='background: #eee;'>";
        $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Employers') . "</strong></td></tr>";
        if(isset($employers))
        foreach ($employers as $employer) {
            $i++;
            foreach ($fieldsordering['employer'] as $field) {
                switch ($field->field) {
                    case "section_employer":
                        if ($field->published == 1) {
                            $msgBody .= "<tr style='background: #eee;'>";
                            $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Employer') . "-" . $i . "</strong></td></tr>";
                        }
                        break;
                    case "employer":
                        $this->getRowForResume(JText::_('Employer'), $employer->employer, $msgBody, $field->published);
                        break;
                    case "employer_position":
                        $this->getRowForResume(JText::_('Position'), $employer->employer_position, $msgBody, $field->published);
                        break;
                    case "employer_resp":
                        $this->getRowForResume(JText::_('Responsibilities'), $employer->employer_resp, $msgBody, $field->published);
                        break;
                    case "employer_pay_upon_leaving":
                        $this->getRowForResume(JText::_('Pay Upon Leaving'), $employer->employer_pay_upon_leaving, $msgBody, $field->published);
                        break;
                    case "employer_supervisor":
                        $this->getRowForResume(JText::_('Supervisor'), $employer->employer_supervisor, $msgBody, $field->published);
                        break;
                    case "employer_from_date":
                        $this->getRowForResume(JText::_('From Date'), $employer->employer_from_date, $msgBody, $field->published);
                        break;
                    case "employer_to_date":
                        $this->getRowForResume(JText::_('To Date'), $employer->employer_to_date, $msgBody, $field->published);
                        break;
                    case "employer_leave_reason":
                        $this->getRowForResume(JText::_('Reason For Leaving'), $employer->employer_leave_reason, $msgBody, $field->published);
                        break;
                    case "employer_city":
                        $defaultaddressdisplaytype = $this->getJSModel('configurations')->getConfigByFor('defaultaddressdisplaytype');                       
                        $this->getRowForResume(JText::_('City'), JText::_($employer->employer_cityname), $msgBody, $field->published);
                        switch ($defaultaddressdisplaytype){
                            case 'csc':
                                $this->getRowForResume(JText::_('State'), JText::_($employer->employer_statename), $msgBody, $field->published);
                                $this->getRowForResume(JText::_('Country'), JText::_($employer->employer_countryname), $msgBody, $field->published);
                            break;
                            case 'cs':
                                $this->getRowForResume(JText::_('State'), JText::_($employer->employer_statename), $msgBody, $field->published);
                            break;
                            case 'cc':
                                $this->getRowForResume(JText::_('Country'), JText::_($employer->employer_countryname), $msgBody, $field->published);
                            break;
                        }
                        break;
                    case "employer_zip":
                        $this->getRowForResume(JText::_('Zip Code'), $employer->employer_zip, $msgBody, $field->published);
                        break;
                    case "employer_address":
                        $this->getRowForResume(JText::_('Address'), $employer->employer_address, $msgBody, $field->published);
                        break;
                    case "employer_phone":
                        $this->getRowForResume(JText::_('Phone'), $employer->employer_phone, $msgBody, $field->published);
                        break;
                    default:
                        $this->getUserFieldRowForResume($employer, $field, $customfieldobj, $msgBody);
                        break;
                }
            }
        }
        if(isset($fieldsordering['skills']))
        foreach ($fieldsordering['skills'] as $field) {
            switch ($field->field) {
                case "section_skills":
                    if ($field->published == 1) {
                        $msgBody .= "<tr style='background: #eee;'>";
                        $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Skills') . "</strong></td></tr>";
                    }
                    break;
                case "skills":
                    $this->getRowForResume(JText::_('Skills'), $personalInfo->skills, $msgBody, $field->published);
                    break;
                default:
                    $this->getUserFieldRowForResume($personalInfo, $field, $customfieldobj, $msgBody);
                    break;
            }
        }
        if(isset($fieldsordering['resume']))
        foreach ($fieldsordering['resume'] as $field) {
            switch ($field->field) {
                case "section_resume":
                    if ($field->published == 1) {
                        $msgBody .= "<tr style='background: #eee;'>";
                        $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Resume') . "</strong></td></tr>";
                    }
                    break;
                case "resume":
                    $this->getRowForResume(JText::_('Resume'), $personalInfo->resume, $msgBody, $field->published);
                    break;
                default:
                    $this->getUserFieldRowForResume($personalInfo, $field, $customfieldobj, $msgBody);
                    break;
            }
        }
        $i = 0;
        $msgBody .= "<tr style='background: #eee;'>";
        $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('References') . "</strong></td></tr>";
        if(isset($references))
        foreach ($references as $reference) {
            $i++;
            foreach ($fieldsordering['reference'] as $field) {
                switch ($field->field) {
                    case "section_reference":
                        if ($field->published == 1) {
                            $msgBody .= "<tr style='background: #eee;'>";
                            $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Reference') . "-" . $i . "</strong></td></tr>";
                        }
                        break;
                    case "reference":
                        $this->getRowForResume(JText::_('Reference'), $reference->reference, $msgBody, $field->published);
                        break;
                    case "reference_name":
                        $this->getRowForResume(JText::_('Name'), $reference->reference_name, $msgBody, $field->published);
                        break;
                    case "reference_city":
                        $defaultaddressdisplaytype = $this->getJSModel('configurations')->getConfigByFor('defaultaddressdisplaytype');
                        $this->getRowForResume(JText::_('City'), JText::_($reference->reference_cityname), $msgBody, $field->published);
                        switch ($defaultaddressdisplaytype){
                            case 'csc':
                                $this->getRowForResume(JText::_('State'), JText::_($reference->reference_statename), $msgBody, $field->published);
                                $this->getRowForResume(JText::_('Country'), JText::_($reference->reference_cityname), $msgBody, $field->published);
                            break;
                            case 'cs':
                                $this->getRowForResume(JText::_('State'), JText::_($reference->reference_statename), $msgBody, $field->published);
                            break;
                            case 'cc':
                                $this->getRowForResume(JText::_('Country'), JText::_($reference->reference_cityname), $msgBody, $field->published);
                            break;
                        }
                        break;
                    case "reference_zipcode":
                        $this->getRowForResume(JText::_('Zip Code'), $reference->reference_zipcode, $msgBody, $field->published);
                        break;
                    case "reference_address":
                        $this->getRowForResume(JText::_('Address'), $reference->reference_address, $msgBody, $field->published);
                        break;
                    case "reference_phone":
                        $this->getRowForResume(JText::_('Phone'), $reference->reference_phone, $msgBody, $field->published);
                        break;
                    case "reference_relation":
                        $this->getRowForResume(JText::_('Relation'), $reference->reference_relation, $msgBody, $field->published);
                        break;
                    case "reference_years":
                        $this->getRowForResume(JText::_('Years'), $reference->reference_years, $msgBody, $field->published);
                        break;
                    default:
                        $this->getUserFieldRowForResume($reference, $field, $customfieldobj, $msgBody);
                        break;
                }
            }
        }
        $i = 0;
        $msgBody .= "<tr style='background: #eee;'>";
        $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Language') . "</strong></td></tr>";
        if(isset($languages))
        foreach ($languages as $language) {
            $i++;
            foreach ($fieldsordering['language'] as $field) {
                switch ($field->field) {
                    case "section_language":
                        if ($field->published == 1) {
                            $msgBody .= "<tr style='background: #eee;'>";
                            $msgBody .= "<td colspan='2' align='center'><strong>" . JText::_('Language') . "-" . $i . "</strong></td></tr>";
                        }
                        break;
                    case "language_name":
                        $this->getRowForResume(JText::_('Language Name'), $language->language, $msgBody, $field->published);
                        break;
                    case "language_reading":
                        $this->getRowForResume(JText::_('Language Read'), $language->language_reading, $msgBody, $field->published);
                        break;
                    case "language_writing":
                        $this->getRowForResume(JText::_('Language Write'), $language->language_writing, $msgBody, $field->published);
                        break;
                    case "language_understading":
                        $this->getRowForResume(JText::_('Language Understand'), $language->language_understanding, $msgBody, $field->published);
                        break;
                    case "language_where_learned":
                        $this->getRowForResume(JText::_('Language Learn Institute'), $language->language_where_learned, $msgBody, $field->published);
                        break;
                    default:
                        $this->getUserFieldRowForResume($language, $field, $customfieldobj, $msgBody);
                        break;
                }
            }
        }

        $msgBody .= "</table>";
        if (strstr($acutalBody, '{RESUME_DATA}')) {
            $msgBody = str_replace('{RESUME_DATA}', $msgBody, $acutalBody);
        } else { // FOr old version support
            $msgBody = $acutalBody . $msgBody;
        }

        $resumeFiles = $this->getJSModel('resume')->getResumeFilesByResumeId($resumeid);
        if (!empty($resumeFiles)) {
            foreach ($resumeFiles as $resumeFile) {
                $iddir = 'resume_' . $resumeid;
                if (!isset($this->_config))
                    $this->_config = $this->getJSModel('configurations')->getConfig('');
                foreach ($this->_config as $conf) {
                    if ($conf->configname == 'data_directory')
                        $datadirectory = $conf->configvalue;
                }
                $path = JPATH_BASE . '/' . $datadirectory;
                $path = $path . '/data/jobseeker/' . $iddir . '/resume/' . $resumeFile->filename;
                $message->addAttachment($path);
            }
        }
        $app = JApplication::getInstance('site');
        $router = $app->getRouter();
        $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($resumeid);
        $newUrl = JURI::root().'index.php?option=com_jsjobs&c=jsjobs&view=resume&layout=view_resume&nav=6&rd=' . $resumealiasid . '&bd=' . $job_id_mail_link.'&Itemid='.$Itemid;
        //$newUrl = $router->build($newUrl);
        $parsed_url = $newUrl;
        $applied_resume_link = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Resume') . '</a>';
        $msgBody = str_replace('{RESUME_LINK}', $applied_resume_link, $msgBody);

        $message->setBody($msgBody);
        $sender = array($senderEmail, $senderName);
        $message->setSender($sender);
        $message->IsHTML(true);
        $sent = $message->send();
        return 1;
    }

    function sendMailtoVisitor($jobid) {
        if ($jobid)
            if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
                return false;
        $db = JFactory::getDBO();
        $Itemid = JRequest::getVar('Itemid');
        $templatefor = 'job-alert-visitor';
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;
        $jobquery = "SELECT job.title, job.status,job.jobid AS jobid, company.name AS companyname, cat.cat_title AS cattitle,job.sendemail,company.contactemail,company.contactname,job.params
                              FROM `#__js_job_jobs` AS job
                              JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                              JOIN `#__js_job_categories` AS cat ON cat.id = job.jobcategory
                              WHERE job.id = " . $jobid;
        $db->setQuery($jobquery);
        $jobuser = $db->loadObject();
        if ($jobuser) {

            $CompanyName = $jobuser->companyname;
            $JobCategory = $jobuser->cattitle;
            $JobTitle = $jobuser->title;
            if ($jobuser->status == 1)
                $JobStatus = JText::_('Approved');
            else
                $JobStatus = JText::_('Waiting For Approval');
            $EmployerEmail = $jobuser->contactemail;
            $ContactName = $jobuser->contactname;


            $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
            $msgSubject = str_replace('{CONTACT_NAME}', $ContactName, $msgSubject);
            $msgSubject = str_replace('{JOB_CATEGORY}', $JobCategory, $msgSubject);
            $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
            $msgSubject = str_replace('{JOB_STATUS}', $JobStatus, $msgSubject);
            $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
            $msgBody = str_replace('{CONTACT_NAME}', $ContactName, $msgBody);
            $msgBody = str_replace('{JOB_CATEGORY}', $JobCategory, $msgBody);
            $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
            $msgBody = str_replace('{JOB_STATUS}', $JobStatus, $msgBody);

            $visitor_can_edit_job = $this->getJSModel('configurations')->getConfigValue('visitor_can_edit_job');
            if ($visitor_can_edit_job == 1) {
                $path = JURI::root();
                $path .= 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&email=' . $jobuser->contactemail . '&bd=' . $jobuser->jobid.'&Itemid='.$Itemid;
                $text = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Click Here To Edit Job') . '</a>';
                $msgBody = str_replace('{JOB_LINK}', $text, $msgBody);
            } else {// delete {JOB_LINK} if not allowed to edit job
                $msgBody = str_replace('{JOB_LINK}', '', $msgBody);
            }
            //custom fields in email
            $params = empty($jobuser->params) ? array() : json_decode($jobuser->params,true);
            $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(2);
            foreach ($fields as $field){
                if($field->userfieldtype != 'file'){
                    $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                    $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                }
            }

            $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
            $senderName = $emailconfig['mailfromname'];
            $senderEmail = $emailconfig['mailfromaddress'];

            $message = JFactory::getMailer();
            if(!empty($EmployerEmail)){
                $message->addRecipient($EmployerEmail); //to email

                $message->setSubject($msgSubject);
                $siteAddress = JURI::base();
                $message->setBody($msgBody);
                $sender = array($senderEmail, $senderName);
                $message->setSender($sender);
                $message->IsHTML(true);
                $sent = $message->send();
                return $sent;
            }
            return true;
            //if ($sent != 1) echo 'Error sending email';
        }
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
        $config_email = $this->getJSModel('configurations')->getConfigByFor('email');
        $db = JFactory::getDBO();
        $Itemid = JRequest::getVar('Itemid');
        $templatefor = 'applied-resume_status';
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;

        $query = "SELECT CONCAT(resume.first_name,' ',resume.last_name) AS name, resume.uid AS uid, resume.email_address AS email, job.title
            FROM `#__js_job_jobapply` AS apply
            JOIN `#__js_job_resume` AS resume ON apply.cvid=resume.id
            JOIN `#__js_job_jobs` AS job ON apply.jobid=job.id
            WHERE apply.id = " . $applyid;
        $db->setQuery($query);
        $result = $db->loadObject();
        if ($result) {
            switch ($action_status) {
                case 2:
                    $resume_status = "spam";
                    break;
                case 3:
                    $resume_status = "hired";
                    break;
                case 1:
                    $resume_status = "inbox";
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
                $jobseekr_name = " " . $result->name . "  ";
            }
            $job_title = $result->title;
            $jobseeker_email = $result->email;

            $newUrl = JURI::root() . 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs'.'&Itemid='.$Itemid;
            
            // $data['name'] = $jobseekr_name;
            // $data['jobseeker_email'] = $jobseeker_email;
            // $data['apply_status'] = $resume_status;
            // $data['job_title'] = $job_title;
            // $data['applied_job_link'] = $newUrl;
            // $data['sender_name'] = $config_email['mailfromname'];
            // $data['sender_email'] = $config_email['mailfromaddress'];

            // if( JPluginHelper::isEnabled('extension','jsjobsjobapply') ){
            //     JPluginHelper::importPlugin('extension');
            //     $dispatcher = JEventDispatcher::getInstance();
            //     $abc  = $dispatcher->trigger('JSJobsJobApplyActionStatusChange',array($data));
            //     echo '<pre>';print_r($abc);exit;
            // }

            $msgBody = str_replace('{JOBSEEKER_NAME}', $jobseekr_name, $msgBody);
            $msgBody = str_replace('{RESUME_STATUS}', $resume_status, $msgBody);
            $msgBody = str_replace('{JOB_TITLE}', $job_title, $msgBody);
            $app = JApplication::getInstance('site');
            $router = $app->getRouter();
            $newUrl = JURI::root() . 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs'.'&Itemid='.$Itemid;
            //$newUrl = $router->build($newUrl);
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

            if($send_email == 1){
                $message = JFactory::getMailer();
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

    function sendToFriend($data) {
        $recipient = array();
        $recipient[] = $data[2]; // 2 to 6 friend emails
        if ($data[3] != '')
            $recipient[] = $data[3];
        if ($data[4] != '')
            $recipient[] = $data[4];
        if ($data[5] != '')
            $recipient[] = $data[5];
        if ($data[6] != '')
            $recipient[] = $data[6];
        $sendername = $data[0];
        $senderemail = $data[1];
        $sendermessage = $data[7];
        $jobid = $data[8];
        if (!is_numeric($jobid))
            return false;
        $message = JFactory::getMailer();
        if(empty($recipient)) return true; // incase empty email
        $message->addRecipient($recipient); //to email
        $db = $this->getDbo();
        $templatefor = 'job-to-friend';
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;
        $config = $this->getJSModel('configurations')->getConfigByFor('default');
        $sitename = $config['title'];
        $jobquery = "SELECT  job.title AS jobtitle,cat.cat_title AS cattitle,comp.name AS companyname,job.params
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON cat.id = job.jobcategory
                        JOIN `#__js_job_companies` AS comp ON comp.id = job.companyid
                        WHERE job.id = " . $jobid;
        $db->setQuery($jobquery);
        $job = $db->loadObject();
        $CompanyName = $job->companyname;
        $CategoryTitle = $job->cattitle;
        $JobTitle = $job->jobtitle;
        $siteAddress = JURI::root();
        $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($jobid);
        $path = $siteAddress . "index.php?option=com_jsjobs&c=jsjobs&view=job&layout=view_job&bd=" . $jobaliasid . "&Itemid=".JRequest::getVar('itemid',105);
        $text = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Click Here To') . '</a>';
        $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
        $msgSubject = str_replace('{JOB_CATEGORY}', $CategoryTitle, $msgSubject);
        $msgSubject = str_replace('{SENDER_NAME}', $sendername, $msgSubject);
        $msgSubject = str_replace('{SITE_NAME}', $sitename, $msgSubject);
        $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
        $msgSubject = str_replace('{CLICK_HERE_TO_VISIT}', $link, $msgSubject);
        $msgSubject = str_replace('{SENDER_MESSAGE}', $sendermessage, $msgSubject);

        $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
        $msgBody = str_replace('{JOB_CATEGORY}', $CategoryTitle, $msgBody);
        $msgBody = str_replace('{SENDER_NAME}', $sendername, $msgBody);
        $msgBody = str_replace('{SITE_NAME}', $sitename, $msgBody);
        $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
        $msgBody = str_replace('{CLICK_HERE_TO_VISIT}', $text, $msgBody);
        $msgBody = str_replace('{SENDER_MESSAGE}', $sendermessage, $msgBody);
        //custom fields in email
        $params = empty($job->params) ? array() : json_decode($job->params,true);
        $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(2);
        foreach ($fields as $field){
            if($field->userfieldtype != 'file'){
                $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
            }
        }

        $message->setSubject($msgSubject);
        $message->setBody($msgBody);
        $sender = array($senderemail, $sendername);
        $message->setSender($sender);
        $message->IsHTML(true);
        if (!$message->send())
            $sent = $message->sent();
        else
            $sent = true;
        return $sent;
    }

    function getSendEmail() {
        $values = array();
        $values[] = array('value' => 0, 'text' => JText::_('No'));
        $values[] = array('value' => 1, 'text' => JText::_('Yes'));
        $values[] = array('value' => 2, 'text' => JText::_('Yes With Resume'));
        return $values;
    }

    function getEmailOption($emailfor , $for){
        if(empty($emailfor))
            return false;

        $array = array('employer', 'jobseeker', 'admin', 'jobseeker_visitor', 'employer_visitor');
        if( ! in_array($for, $array))
            return false;

        $db = JFactory::getDBO();
        $query = "SELECT `$for` FROM `#__js_job_emailtemplates_config` WHERE `emailfor` = '$emailfor'";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }    

    function sendMailToPackagePurchaser($id, $uid, $user) {
        if (!is_numeric($id))
            return false;
        if (!is_numeric($uid))
            return false;
        if (!is_numeric($user))
            return false;
        $db = JFactory::getDbo();
        $Itemid = JRequest::getVar('Itemid');
        $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
        $senderName = $emailconfig['mailfromname'];
        $senderEmail = $emailconfig['mailfromaddress'];
        $issendemail = false;
        if ($user == 1) { // Employer
            $return_option = $this->getEmailOption('employer_purchase_package' , 'employer');
            if($return_option == 1){
                $issendemail = 1;
            }
            $templatefor = "employer-packagepurchase";
            $packagefor = 1;
            $usernamefor = '{EMPLOYER_NAME}';
            $userpackage = 'employerpackages';
        } elseif ($user == 2) { // Jobseeker
            $return_option = $this->getEmailOption('jobseeker_purchase_package' , 'jobseeker');
            if($return_option == 1){
                $issendemail = 1;
            }            
            $templatefor = "jobseeker-packagepurchase";
            $packagefor = 2;
            $usernamefor = '{JOBSEEKER_NAME}';
            $userpackage = 'jobseekerpackages';
        }

        if ($issendemail == 1) {
            $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
            $db->setQuery($query);
            $template = $db->loadObject();
            $msgSubject = $template->subject;
            $msgBody = $template->body;

            /*
            $jobquery = "SELECT package.title, package.price, user.name, user.email,package.id ,cur.symbol AS currency,payment.transactionverified
                        FROM `#__users` AS user
                        JOIN `#__js_job_paymenthistory` AS payment ON payment.uid = user.id 
                        JOIN `#__js_job_jobseekerpackages` AS package ON package.id = payment.packageid
                        LEFT JOIN `#__js_job_currencies` AS cur ON package.currencyid = cur.id
                        WHERE user.id = " . $uid . "  AND payment.id = " . $id . " AND payment.packagefor= " . $packagefor;

            $db->setQuery($jobquery);
            $user = $db->loadObject();
            
            $UserEmail = $user->email;
            $UserName = $user->name;
            $PackageTitle = $user->title;
            $packagePrice = $user->price;
            */

            $jobquery = "SELECT user.name, user.email ,payment.transactionverified,payment.packageid
                        FROM `#__users` AS user
                        JOIN `#__js_job_paymenthistory` AS payment ON payment.uid = user.id 
                        WHERE user.id = " . $uid . "  AND payment.id = " . $id . " AND payment.packagefor= " . $packagefor;
            $db->setQuery($jobquery);
            $user = $db->loadObject();

            if($packagefor == 1){
                $query = "SELECT package.title, package.price,package.id,cur.symbol AS currency
                            FROM `#__js_job_employerpackages` AS package 
                            LEFT JOIN `#__js_job_currencies` AS cur ON package.currencyid = cur.id
                            WHERE  package.id = " . $user->packageid;

                $db->setQuery($query);
                $package = $db->loadObject();
            }else{
                $query = "SELECT package.title, package.price,package.id,cur.symbol AS currency
                            FROM `#__js_job_jobseekerpackages` AS package 
                            LEFT JOIN `#__js_job_currencies` AS cur ON package.currencyid = cur.id
                            WHERE  package.id = " . $user->packageid;

                $db->setQuery($query);
                $package = $db->loadObject();

            }

            $UserEmail = $user->email;
            $UserName = $user->name;
            $PackageTitle = $package->title;
            $packagePrice = $package->price;

            $paymentstatus = ($user->transactionverified == 1) ? '<font color="#009412">' . JText::_('Verified') . '</font>' : '<font color="#FF5B03">' . JText::_('Not Verified') . '</font>';

            $msgSubject = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgSubject);
            $msgSubject = str_replace('{PACKAGE_TITLE}', $PackageTitle, $msgSubject);
            $msgSubject = str_replace($usernamefor, $UserName, $msgSubject);
            $msgSubject = str_replace('{PAYMENT_STATUS}', $paymentstatus, $msgSubject);
            $msgBody = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgBody);
            $msgBody = str_replace('{PACKAGE_TITLE}', $PackageTitle, $msgBody);
            $msgBody = str_replace($usernamefor, $UserName, $msgBody);
            $msgBody = str_replace('{CURRENCY}', $user->currency, $msgBody);
            $msgBody = str_replace('{PACKAGE_PRICE}', $packagePrice, $msgBody);
            $msgBody = str_replace('{PAYMENT_STATUS}', $paymentstatus, $msgBody);
            $path = JURI::root();
            $Itemid = JRequest::getVar('Itemid');
            $path .= 'index.php?option=com_jsjobs&c=' . $userpackage . '&view=' . $userpackage . '&layout=package_buynow&jslayfor=detail&gd=' . $user->packageid . '&Itemid=' . $Itemid;
            //$path .= 'index.php?option=com_jsjobs&c=' . $userpackage . '&view=' . $userpackage . '&layout=package_details&gd=' . $user->id . '&Itemid=' . $Itemid;
            $jpacklink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Package Detail') . '</a>';
            $msgBody = str_replace('{LINK}', $jpacklink, $msgBody);

            $message = JFactory::getMailer();
            if(!empty($UserEmail)){
                $message->addRecipient($UserEmail); //to email
                $message->setSubject($msgSubject);
                $siteAddress = JURI::base();
                $message->setBody($msgBody);
                $sender = array($senderEmail, $senderName);
                $message->setSender($sender);
                $message->IsHTML(true);
                $sent = $message->send();
                return $sent;
            }
            return true;
        }
        return true;
    }

    function sendDeleteMail( $id , $for) {

        $db = JFactory::getDBO();

        if ($for == 1) { //company
            $result = $this->getEmailOption('company_delete' , 'employer');
            if($result != 1)
                return '';
            $templatefor = 'company-delete';
        } elseif ($for == 2) { //job
            $result = $this->getEmailOption('job_delete' , 'employer');
            if($result != 1)
                return '';
            $templatefor = 'job-delete';
        } elseif ($for == 3) { // resume
            $result = $this->getEmailOption('resume_delete' , 'jobseeker');
            if($result != 1)
                return '';
            $templatefor = 'resume-delete';
        }
        
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;
        if ($for == 1) { //company

            $session = JFactory::getSession();
            $Name = $session->get('contactname');
            $Email = $session->get('contactemail');
            $companyName = $session->get('name');

            $msgSubject = str_replace('{COMPANY_NAME}', $companyName, $msgSubject);
            $msgBody = str_replace('{COMPANY_NAME}', $companyName, $msgBody);
            $msgBody = str_replace('{COMPANY_OWNER_NAME}', $Name, $msgBody);

        } elseif ($for == 2) { //job

            $session = JFactory::getSession();
            $Name = $session->get('contactname');
            $companyname = $session->get('companyname');
            $Email = $session->get('contactemail');
            $jobTitle = $session->get('title');

            $msgSubject = str_replace('{JOB_TITLE}', $jobTitle, $msgSubject);
            $msgBody = str_replace('{JOB_TITLE}', $jobTitle, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $Name, $msgBody);
            $msgBody = str_replace('{COMPANY_NAME}', $companyname, $msgBody);

        } elseif ($for == 3) { // resume

            $session = JFactory::getSession();
            $Name = $session->get('name');
            $Email = $session->get('email_address');
            $resumeTitle = $session->get('application_title');

            $msgSubject = str_replace('{RESUME_TITLE}', $resumeTitle, $msgSubject);
            $msgBody = str_replace('{RESUME_TITLE}', $resumeTitle, $msgBody);
            $msgBody = str_replace('{JOBSEEKER_NAME}', $Name, $msgBody);
        }

        if (!$this->_config)
            $this->_config = $this->getJSModel('configurations')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'mailfromname')
                $senderName = $conf->configvalue;
            if ($conf->configname == 'mailfromaddress')
                $senderEmail = $conf->configvalue;
        }

        $message = JFactory::getMailer();
        if(!empty($Email)){
            $message->addRecipient($Email); //to email
            $message->setSubject($msgSubject);
            $message->setBody($msgBody);
            $sender = array($senderEmail, $senderName);
            $message->setSender($sender);
            $message->IsHTML(true);
            $sent = $message->send();
        }
        return true;
    }

    function sendMailNewResume( $id , $uid) {
        $db = JFactory::getDBO();
        $Itemid = JRequest::getVar('Itemid');
        if ((is_numeric($id) == false) || ($id == 0) || ($id == ''))
            return false;
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
        $senderName = $emailconfig['mailfromname'];
        $senderEmail = $emailconfig['mailfromaddress'];


        if ($uid) {
            $result = $this->getEmailOption('add_new_resume' , 'jobseeker');
            if($result != 1)
                return true;

            $templatefor = 'resume-new';
            $jobquery = "SELECT resume.application_title ,resume.id, CONCAT( resume.alias,'-',resume.id) AS aliasid, resume.status, concat(resume.first_name,' ',resume.last_name) AS name, resume.email_address as email,resume.params
                        FROM `#__js_job_resume` AS resume
                        WHERE resume.uid = " . $uid . "  AND resume.id = " . $id;
        } else {
            $result = $this->getEmailOption('add_new_resume' , 'jobseeker_visitor');
            if($result != 1)
                return true;
            $templatefor = 'resume-new-vis';
            $jobquery = "SELECT resume.application_title,CONCAT( resume.alias,'-',resume.id) AS aliasid, 'Guest' AS name, resume.status ,  resume.email_address AS email ,resume.id,resume.params FROM `#__js_job_resume` AS resume WHERE resume.id = " . $id;
        }

        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;


        $db->setQuery($jobquery);
        $resume = $db->loadObject();
        $receiver = $resume->email;
        $JobSeekerName = $resume->name;
        $ApplicationTitle = $resume->application_title;
        $resumestatus = $resume->status;
        $aliasid = $resume->aliasid;
        switch ($resumestatus) {
            case '1':
                $resumestatus = 'Approved';
                break;
            case '-1':
                $resumestatus = 'Rejected';
                break;
            case '0':
                $resumestatus = 'Pending';
                break;
        }
        $resumestatus = JText::_($resumestatus);

        $msgSubject = str_replace('{RESUME_TITLE}', $ApplicationTitle, $msgSubject);
        $msgBody = str_replace('{JOBSEEKER_NAME}', $JobSeekerName, $msgBody);
        $msgBody = str_replace('{RESUME_TITLE}', $ApplicationTitle, $msgBody);
        $msgBody = str_replace('{RESUME_STATUS}', $resumestatus, $msgBody);

        $path = JURI::root();
        $path .= 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=1&rd='.$aliasid;
        $resumelink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Resume') . '</a>';
        $msgBody = str_replace('{RESUME_LINK}', $resumelink, $msgBody);
        //custom fields in email
        $params = empty($resume->params) ? array() : json_decode($resume->params,true);
        $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(3);
        foreach ($fields as $field){
            if($field->userfieldtype != 'file'){
                $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
            }
        }

        $message = JFactory::getMailer();
        if(!empty($receiver)){
            $message->addRecipient($receiver); //to email
            $message->setSubject($msgSubject);
            $message->setBody($msgBody);
            $sender = array($senderEmail, $senderName);
            $message->setSender($sender);
            $message->IsHTML(true);
            $sent = $message->send();
            return $sent;
        }
    }

}
?>
    
