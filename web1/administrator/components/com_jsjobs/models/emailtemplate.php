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

class JSJobsModelEmailtemplate extends JSModel {

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

    function getTemplate($tempfor) {
        $db = JFactory::getDBO();
        switch ($tempfor) {
            case 'ew-cm' : $tempatefor = 'company-new';
                break;
            case 'cm-ap' : $tempatefor = 'company-approval';
                break;
            case 'cm-rj' : $tempatefor = 'company-rejecting';
                break;
            case 'ew-ob' : $tempatefor = 'job-new';
                break;
            case 'ew-ob-em' : $tempatefor = 'job-new-employer';
                break;
            case 'ob-ap' : $tempatefor = 'job-approval';
                break;
            case 'ob-rj' : $tempatefor = 'job-rejecting';
                break;
            case 'ap-rs' : $tempatefor = 'applied-resume_status';
                break;
            case 'ew-rm' : $tempatefor = 'resume-new';
                break;
            case 'rm-ap' : $tempatefor = 'resume-approval';
                break;
            case 'rm-rj' : $tempatefor = 'resume-rejecting';
                break;
            case 'ba-ja' : $tempatefor = 'jobapply-jobapply';
                break;
            case 'ew-md' : $tempatefor = 'department-new';
                break;
            case 'ew-rp' : $tempatefor = 'employer-buypackage';
                break;
            case 'ew-js' : $tempatefor = 'jobseeker-buypackage';
                break;
            case 'ms-sy' : $tempatefor = 'message-email';
                break;
            case 'jb-at' : $tempatefor = 'job-alert';
                break;
            case 'jb-at-vis' : $tempatefor = 'job-alert-visitor';
                break;
            case 'jb-to-fri' : $tempatefor = 'job-to-friend';
                break;
            case 'jb-pkg-pur' : $tempatefor = 'jobseeker-packagepurchase';
                break;
            case 'emp-pkg-pur' : $tempatefor = 'employer-packagepurchase';
                break;
            case 'cm-dl' : $tempatefor = 'company-delete';
                break;
            case 'ob-dl' : $tempatefor = 'job-delete';
                break;
            case 'rm-dl' : $tempatefor = 'resume-delete';
                break;
            case 'js-ja' : $tempatefor = 'jobapply-jobseeker';
                break;
            case 'ew-rm-vis' : $tempatefor = 'resume-new-vis';
                break;

        }
        $query = "SELECT * FROM `#__js_job_emailtemplates` WHERE templatefor = " . $db->Quote($tempatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        return $template;
    }

    function getEmailTemplateOptionsForView(){
        $db = JFactory::getDBO();
        $query = "SELECT * FROM `#__js_job_emailtemplates_config`";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $options = array();
        foreach ($rows as $row) {
            $options[$row->emailfor] = $row;
        }
        return $options;        
    }

    function updateEmailTemplateOption($emailfor , $for){
        switch ($for) {
            case '1': $settingfor = 'employer'; break;
            case '2': $settingfor = 'jobseeker'; break;
            case '3': $settingfor = 'admin'; break;
            case '4': $settingfor = 'jobseeker_visitor'; break;
            case '5': $settingfor = 'employer_visitor'; break;
        }
        if(! isset($settingfor))
            return false;

        if( empty($emailfor))
            return false;

        $db = JFactory::getDBO();
        $query = "UPDATE `#__js_job_emailtemplates_config` SET `$settingfor` = ( 1 -  `$settingfor`) WHERE `emailfor` = '$emailfor'";
        $db->setQuery($query);
        $db->query();
        return SAVED;
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

    function storeEmailTemplate() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $row = $this->getTable('emailtemplate');

        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $data['body'] = $this->getJSModel('common')->getHtmlInput('body');

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

    function sendMailtoVisitor($jobid) {
        if ($jobid)
            if ((is_numeric($jobid) == false) || ($jobid == 0) || ($jobid == ''))
                return false;
        $db = JFactory::getDBO();
        $templatefor = 'job-alert-visitor';

        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;
        $jobquery = "SELECT job.title, job.jobstatus,job.jobid AS jobid, company.name AS companyname, cat.cat_title AS cattitle,job.sendemail,company.contactemail,company.contactname
                              FROM `#__js_job_jobs` AS job
                              JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                              JOIN `#__js_job_categories` AS cat ON cat.id = job.jobcategory
                              WHERE job.id = " . $jobid;
        $db->setQuery($jobquery);
        $jobuser = $db->loadObject();
        if ($jobuser->jobstatus == 1) {

            $CompanyName = $jobuser->companyname;
            $JobCategory = $jobuser->cattitle;
            $JobTitle = $jobuser->title;
            if ($jobuser->jobstatus == 1)
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

            $config = $this->getJSModel('configuration')->getConfigByFor('default');
            if ($config['visitor_can_edit_job'] == 1) {
                $path = JURI::root();
				$path = str_replace('/administrator', '', $path);
                $path .= 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&email=' . $jobuser->contactemail . '&jobid=' . $jobuser->jobid;
                $text = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Click Here To Edit Job') . '</a>';
                $msgBody .= $text;
            }

            $emailconfig = $this->getJSModel('configuration')->getConfigByFor('email');
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
        }
    }

    function sendMail($for, $action, $id ) {

        //action, 1 = job approved, 2 = job reject 6, resume approved, 7 resume reject
        $db = JFactory::getDBO();
        $app = JApplication::getInstance('site');
        $router = $app->getRouter();
        $siteAddress = JURI::root();

        if ($for == 1) { //company
            $result = $this->getEmailOption('company_status' , 'employer');
            if($result != 1)
                return '';
            if ($action == 1) { // company approved
                $templatefor = 'company-approval';
            } elseif ($action == -1) { //company reject
                $templatefor = 'company-rejecting';
            }
        } elseif ($for == 2) { //job
            $result = $this->getEmailOption('job_status' , 'employer');
            if($result != 1)
                return '';
            if ($action == 1) { // job approved
                $templatefor = 'job-approval';
            } elseif ($action == -1) { // job reject
                $templatefor = 'job-rejecting';
            }
        } elseif ($for == 3) { // resume
            $result = $this->getEmailOption('resume_status' , 'jobseeker');
            if($result != 1)
                return '';
            if ($action == 1) { //resume approved
                $templatefor = 'resume-approval';
            } elseif ($action == -1) { // resume reject
                $templatefor = 'resume-rejecting';
            }
        } elseif ($for == 4) {// visitor job
            $result = $this->getEmailOption('job_status' , 'employer_visitor');
            if($result != 1)
                return '';
            if ($action == 1) { //job approved
                $templatefor = 'job-alert-visitor';
            } elseif ($action == -1) { // resume reject
                $templatefor = 'job-alert-visitor';
            }
        }
        
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;
        if ($for == 1) { //company
            if(!is_numeric($id)) return false;
            $query = "SELECT company.name, company.contactname, company.contactemail,CONCAT(company.alias,'-',company.id) AS aliasid,company.params 
                FROM `#__js_job_companies` AS company
                WHERE company.id = " . $id;

            $db->setQuery($query);
            $company = $db->loadObject();

            $Name = $company->contactname;
            $Email = $company->contactemail;
            $companyName = $company->name;

            $msgSubject = str_replace('{COMPANY_NAME}', $companyName, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $Name, $msgSubject);
            $msgBody = str_replace('{COMPANY_NAME}', $companyName, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $Name, $msgBody);
            if ($action == 1) {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&vm=1&cd=' . $company->aliasid;
                //$newUrl = $router->build($newUrl);
                $parsed_url = $newUrl;
                $parsed_url = str_replace('/administrator', '', $parsed_url);
                $companylink = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Company') . '</a>';
                $msgBody = str_replace('{COMPANY_LINK}', $companylink, $msgBody);
            }else{
                $msgBody = str_replace('{COMPANY_LINK}', '', $msgBody);
            }
            //custom fields in email
            $params = empty($company->params) ? array() : json_decode($company->params,true);
            $fields = $this->getJSModel('fieldordering')->getUserfieldsfor(1);
            foreach ($fields as $field){
                if($field->userfieldtype != 'file'){
                    $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                    $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                }
            }
        } elseif ($for == 2) { //job
            if(!is_numeric($id)) return false;
            $query = "SELECT job.uid, job.title, company.contactname, company.contactemail,CONCAT(job.alias,'-',job.id) AS aliasid,job.params
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                WHERE job.id = " . $id;
            $db->setQuery($query);
            $job = $db->loadObject();

            $Name = $job->contactname;
            $Email = $job->contactemail;
            $jobTitle = $job->title;
            $msgSubject = str_replace('{JOB_TITLE}', $jobTitle, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $Name, $msgSubject);
            $msgBody = str_replace('{JOB_TITLE}', $jobTitle, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $Name, $msgBody);
            if ($action == 1) {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&vj=1&bd=' . $job->aliasid;
            } else {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs';
            }
            //$newUrl = $router->build($newUrl);
            $parsed_url = $newUrl;
            $parsed_url = str_replace('/administrator', '', $parsed_url);
            $joblink = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Job') . '</a>';
            $msgBody = str_replace('{JOB_LINK}', $joblink, $msgBody);
            //custom fields in email
            $params = empty($job->params) ? array() : json_decode($job->params,true);
            $fields = $this->getJSModel('fieldordering')->getUserfieldsfor(2);
            foreach ($fields as $field){
                if($field->userfieldtype != 'file'){
                    $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                    $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                }
            }
        } elseif ($for == 3) { // resume
            if(!is_numeric($id)) return false;
            $query = "SELECT app.application_title, app.first_name, app.middle_name, app.last_name, app.email_address,CONCAT(app.alias,'-',app.id) AS aliasid,app.params
                        FROM `#__js_job_resume` AS app
                        WHERE app.id = " . $id;

            $db->setQuery($query);
            $app = $db->loadObject();

            $Name = $app->first_name;
            if ($app->middle_name)
                $Name .= " " . $app->middle_name;
            if ($app->last_name)
                $Name .= " " . $app->last_name;
            $Email = $app->email_address;
            $resumeTitle = $app->application_title;
            $msgSubject = str_replace('{RESUME_TITLE}', $resumeTitle, $msgSubject);
            $msgSubject = str_replace('{JOBSEEKER_NAME}', $Name, $msgSubject);
            $msgBody = str_replace('{RESUME_TITLE}', $resumeTitle, $msgBody);
            $msgBody = str_replace('{JOBSEEKER_NAME}', $Name, $msgBody);
            if ($action == 1) {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&vm=1&rd=' . $app->aliasid.'&nav=1';
            } else {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes';
            }
            //$newUrl = $router->build($newUrl);
            $parsed_url = $newUrl;
            $parsed_url = str_replace('/administrator', '', $parsed_url);
            $resumelink = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Resume') . '</a>';
            $msgBody = str_replace('{RESUME_LINK}', $resumelink, $msgBody);
            //custom fields in email
            $params = empty($app->params) ? array() : json_decode($app->params,true);
            $fields = $this->getJSModel('fieldordering')->getUserfieldsfor(3);
            foreach ($fields as $field){
                if($field->userfieldtype != 'file'){
                    $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                    $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                }
            }
        } elseif ($for == 4) {
            if(!is_numeric($id)) return false;
            $jobquery = "SELECT job.title, job.jobstatus,job.jobid AS jobid, company.name AS companyname, cat.cat_title AS cattitle,job.sendemail,company.contactemail,company.contactname,job.params
                                      FROM `#__js_job_jobs` AS job
                                      JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                                      JOIN `#__js_job_categories` AS cat ON cat.id = job.jobcategory
                                      WHERE job.id = " . $id;
            $db->setQuery($jobquery);
            $jobuser = $db->loadObject();

            $CompanyName = $jobuser->companyname;
            $JobCategory = $jobuser->cattitle;
            $JobTitle = $jobuser->title;
            if ($jobuser->jobstatus == 1)
                $JobStatus = JText::_('Approved');
            else
                $JobStatus = JText::_('Waiting For Approval');
            $Email = $jobuser->contactemail;
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

            $config = $this->getJSModel('configuration')->getConfigByFor('default');
            if ($config['visitor_can_edit_job'] == 1) {
                $path = JURI::root();
                $path = str_replace('/administrator', '', $path);
                $path .= 'index.php?option=com_jsjobs&view=job&layout=myjobs&email=' . $jobuser->contactemail . '&bd=' . $jobuser->jobid;
                $text = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Click Here To Edit Job') . '</a>';
                $msgBody = str_replace('{JOB_LINK}', $text, $msgBody);
            }else{
                $msgBody = str_replace('{JOB_LINK}', '', $msgBody);
            }
            //custom fields in email
            $params = empty($jobuser->params) ? array() : json_decode($jobuser->params,true);
            $fields = $this->getJSModel('fieldordering')->getUserfieldsfor(2);
            foreach ($fields as $field){
                if($field->userfieldtype != 'file'){
                    $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                    $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                }
            }
        }

        if (!$this->_config)
            $this->_config = $this->getJSModel('configuration')->getConfig();
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
        
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = " . $db->Quote($templatefor);
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
            $this->_config = $this->getJSModel('configuration')->getConfig();
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

    function sendMailToPackagePurchaser($id, $uid, $user) {
        if (!is_numeric($id))
            return false;
        if (!is_numeric($uid))
            return false;
        if (!is_numeric($user))
            return false;
        $db = JFactory::getDbo();
        $Itemid = JRequest::getVar('Itemid');
        $emailconfig = $this->getJSModel('configuration')->getConfigByFor('email');
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

}
?>
