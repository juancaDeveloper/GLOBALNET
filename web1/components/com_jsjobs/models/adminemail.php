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

class JSJobsModelAdminEmail extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() { // clean constructor.
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }    

    function sendMailtoAdmin($id, $uid, $for) {
        $db = JFactory::getDBO();
        $Itemid = JRequest::getVar('Itemid');
        if ((is_numeric($id) == false) || ($id == 0) || ($id == ''))
            return false;
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if( JFactory::getApplication()->isAdmin() )
            $emailconfig = $this->getJSModel('configuration')->getConfigByFor('email');
        else
            $emailconfig = $this->getJSModel('configurations')->getConfigByFor('email');
        $senderName = $emailconfig['mailfromname'];
        $senderEmail = $emailconfig['mailfromaddress'];
        $adminEmail = $emailconfig['adminemailaddress'];

        $issendemail = false;
        switch ($for) {
            case 1: // new company
                $return_option = $this->getJSModel('emailtemplate')->getEmailOption('add_new_company' , 'admin');
                if($return_option == 1){
                    $issendemail = 1;
                }
                $templatefor = 'company-new';
                break;
            case 2: // new job
                $return_option = $this->getJSModel('emailtemplate')->getEmailOption('add_new_job' , 'admin');
                if($return_option == 1){
                    $issendemail = 1;
                }
                $templatefor = 'job-new';
                break;
            case 3: // new resume
                $return_option = $this->getJSModel('emailtemplate')->getEmailOption('add_new_resume' , 'admin');
                if($return_option == 1){
                    $issendemail = 1;
                }
                $templatefor = 'resume-new';
                break;
            case 4: // job apply
                $return_option = $this->getJSModel('emailtemplate')->getEmailOption('jobapply_jobapply' , 'admin');
                if($return_option == 1){
                    $issendemail = 1;
                }
                $templatefor = 'jobapply-jobapply';
                break;
            case 5: // new department
                $return_option = $this->getJSModel('emailtemplate')->getEmailOption('add_new_department' , 'admin');
                if($return_option == 1){
                    $issendemail = 1;
                }
                $templatefor = 'department-new';
                break;
            case 6: // new employer package
                $return_option = $this->getJSModel('emailtemplate')->getEmailOption('employer_purchase_package' , 'admin');
                if($return_option == 1){
                    $issendemail = 1;
                }
                $templatefor = 'employer-buypackage';
                break;
            case 7: // new job seeker package
                $return_option = $this->getJSModel('emailtemplate')->getEmailOption('jobseeker_purchase_package' , 'admin');
                if($return_option == 1){
                    $issendemail = 1;
                }
                $templatefor = 'jobseeker-buypackage';
                break;
        }
        if ($issendemail == 1) {
            $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
            $db->setQuery($query);
            $template = $db->loadObject();
            $msgSubject = $template->subject;
            $msgBody = $template->body;

            switch ($for) {
                case 1: // new company
                    $mailfor = "New Company";
                    $jobquery = "SELECT company.name AS companyname, company.id AS id, company.contactname AS name, company.contactemail AS email,
                                company.params 
                                FROM `#__js_job_companies` AS company
                                WHERE company.uid = " . $uid . "  AND company.id = " . $id;
                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $EmployerName = $user->name;
                    $CompanyName = $user->companyname;

                    $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&cid[]=' . $id;
                    $companylink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Company') . '</a>';
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

                    break;
                case 2: // new job.
                    $mailfor = "New JOB";
                    $jobquery = "SELECT job.title, company.contactname AS name, company.contactemail AS email ,job.id AS id,job.params
                                FROM `#__js_job_jobs` AS job
                                JOIN `#__js_job_companies` AS company ON company.id = job.companyid
                                WHERE job.uid = " . $uid . "  AND job.id = " . $id;
                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $EmployerName = $user->name;
                    $JobTitle = $user->title;

                    $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&c=job&view=job&layout=formjob&cid[]=' . $id.'&Itemid='.$Itemid;
                    $joblink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Job') . '</a>';
                    $msgBody = str_replace('{JOB_LINK}', $joblink, $msgBody);
                    //custom fields in email
                    $params = empty($user->params) ? array() : json_decode($user->params,true);
                    $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(2);
                    foreach ($fields as $field){
                        if($field->userfieldtype != 'file'){
                            $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                            $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                        }
                    }

                    break;
                case 3: // new resume
                    if ($uid) {
                        $mailfor = "New Resume by user";
                        $jobquery = "SELECT resume.application_title ,resume.id, concat(resume.first_name,' ',resume.last_name) AS name, resume.email_address as email,resume.params
                                    FROM `#__js_job_resume` AS resume
                                    WHERE resume.uid = " . $uid . "  AND resume.id = " . $id;
                    } else {
                        $mailfor = "New Resume by Guest";
                        $jobquery = "SELECT resume.application_title, 'Guest' AS name, resume.email_address AS email ,resume.id,resume.params FROM `#__js_job_resume` AS resume WHERE resume.id = " . $id;
                    }

                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $JobSeekerName = $user->name;
                    $ApplicationTitle = $user->application_title;

                    $msgSubject = str_replace('{RESUME_TITLE}', $ApplicationTitle, $msgSubject);
                    $msgSubject = str_replace('{JOBSEEKER_NAME}', $JobSeekerName, $msgSubject);
                    $msgBody = str_replace('{RESUME_TITLE}', $ApplicationTitle, $msgBody);
                    $msgBody = str_replace('{JOBSEEKER_NAME}', $JobSeekerName, $msgBody);

                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&c=resume&view=resume&layout=formresume&cid[]=' . $user->id;
                    $resumelink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Resume') . '</a>';
                    $msgBody = str_replace('{RESUME_LINK}', $resumelink, $msgBody);
                    //custom fields in email
                    $params = empty($user->params) ? array() : json_decode($user->params,true);
                    $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(3);
                    foreach ($fields as $field){
                        if($field->userfieldtype != 'file'){
                            $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                            $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                        }
                    }

                    break;
                case 4: // job apply 
                    $mailfor = "Job apply";
                    $jobquery = "SELECT resume.id, job.title, employer.contactname AS employername, employer.contactemail AS employeremail,concat(resume.first_name,' ',resume.last_name) AS jobseekername,resume.params
                                FROM `#__js_job_jobs` AS job
                                JOIN `#__js_job_companies` AS employer ON employer.id = job.companyid
                                JOIN `#__js_job_resume` AS resume ON resume.uid = " . $uid . "
                                WHERE job.id = " . $id;


                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->employeremail;
                    $EmployerName = $user->employername;
                    $JobseekerName = $user->jobseekername;
                    $JobTitle = $user->title;

                    $msgSubject = str_replace('{JOB_TITLE}', $JobTitle, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgSubject = str_replace('{JOBSEEKER_NAME}', $JobseekerName, $msgSubject);
                    $msgBody = str_replace('{JOB_TITLE}', $JobTitle, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    $msgBody = str_replace('{JOBSEEKER_NAME}', $JobseekerName, $msgBody);
                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&c=resume&view=resume&layout=formresume&cid[]=' . $user->id;
                    $resumelink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Resume') . '</a>';
                    $msgBody = str_replace('{RESUME_LINK}', $resumelink, $msgBody);
                    $msgBody = str_replace('{RESUME_DATA}', '', $msgBody); // RESUME DATA IS NOT FOR ADMIN
                    //custom fields in email
                    $params = empty($user->params) ? array() : json_decode($user->params,true);
                    $fields = $this->getJSModel('fieldsordering')->getUserfieldsfor(3);
                    foreach ($fields as $field){
                        if($field->userfieldtype != 'file'){
                            $fvalue = isset($params[$field->field]) ? $params[$field->field] : '';
                            $msgBody = str_replace('{'.$field->field.'}', $fvalue, $msgBody);
                        }
                    }
                    break;
                case 5: // new department
                    $mailfor = "New department";
                    $jobquery = "SELECT department.name AS departmentname, company.name AS companyname, company.contactname as name,company.contactemail as email
                                FROM `#__js_job_departments` AS department
                                JOIN `#__js_job_companies` AS company ON company.id = department.companyid
                                WHERE department.uid = " . $uid . "  AND department.id = " . $id;

                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $EmployerName = $user->name;
                    $CompanyName = $user->companyname;
                    $DepartmentTitle = $user->departmentname;

                    $msgSubject = str_replace('{COMPANY_NAME}', $CompanyName, $msgSubject);
                    $msgSubject = str_replace('{DEPARTMENT_NAME}', $DepartmentTitle, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgBody = str_replace('{COMPANY_NAME}', $CompanyName, $msgBody);
                    $msgBody = str_replace('{DEPARTMENT_NAME}', $DepartmentTitle, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    break;
                case 6: // new employer package purchase
                    $mailfor = "package purcahse by employer";

                    $jobquery = "SELECT package.title, package.price, user.name, user.email,payment.id,cur.symbol AS currency,payment.transactionverified
                                FROM `#__users` AS user
                                JOIN `#__js_job_paymenthistory` AS payment ON payment.uid = user.id
                                JOIN `#__js_job_employerpackages` AS package ON package.id = payment.packageid
                                LEFT JOIN `#__js_job_currencies` AS cur ON package.currencyid = cur.id
                                WHERE user.id = " . $uid . "  AND payment.id = " . $id . " AND payment.packagefor=1 ";

                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $EmployerEmail = $user->email;
                    $EmployerName = $user->name;
                    $PackageTitle = $user->title;
                    $packagePrice = $user->price;
                    $paymentstatus = ($user->transactionverified == 1) ? '<font color="#009412">' . JText::_('Verified') . '</font>' : '<font color="#FF5B03">' . JText::_('Not Verified') . '</font>';

                    $msgSubject = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgSubject);
                    $msgSubject = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgSubject);
                    $msgSubject = str_replace('{PAYMENT_STATUS}', $paymentstatus, $msgSubject);
                    $msgBody = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgBody);
                    $msgBody = str_replace('{EMPLOYER_NAME}', $EmployerName, $msgBody);
                    $msgBody = str_replace('{CURRENCY}', $user->currency, $msgBody);
                    $msgBody = str_replace('{PACKAGE_PRICE}', $packagePrice, $msgBody);
                    $msgBody = str_replace('{PAYMENT_STATUS}', $paymentstatus, $msgBody);
                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymentdetails&pk=' . $user->id;
                    $epacklink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Package Detail') . '</a>';
                    $msgBody = str_replace('{PACKAGE_LINK}', $epacklink, $msgBody);
                    break;
                case 7: // new job seeker package purchase
                    $mailfor = "package purcahse by JObseeker";
                    $jobquery = "SELECT package.title, package.price, user.name, user.email,payment.id ,cur.symbol AS currency,payment.transactionverified
                                FROM `#__users` AS user
                                JOIN `#__js_job_paymenthistory` AS payment ON payment.uid = user.id 
                                JOIN `#__js_job_jobseekerpackages` AS package ON package.id = payment.packageid
                                LEFT JOIN `#__js_job_currencies` AS cur ON package.currencyid = cur.id
                                WHERE user.id = " . $uid . "  AND payment.id = " . $id . " AND payment.packagefor=2 ";

                    $db->setQuery($jobquery);
                    $user = $db->loadObject();
                    $JobSeekerEmail = $user->email;
                    $JobSeekerName = $user->name;
                    $PackageTitle = $user->title;
                    $packagePrice = $user->price;
                    $paymentstatus = ($user->transactionverified == 1) ? '<font color="#009412">' . JText::_('Verified') . '</font>' : '<font color="#FF5B03">' . JText::_('Not Verified') . '</font>';

                    $msgSubject = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgSubject);
                    $msgSubject = str_replace('{JOBSEEKER_NAME}', $JobSeekerName, $msgSubject);
                    $msgSubject = str_replace('{PAYMENT_STATUS}', $paymentstatus, $msgSubject);
                    $msgBody = str_replace('{PACKAGE_NAME}', $PackageTitle, $msgBody);
                    $msgBody = str_replace('{JOBSEEKER_NAME}', $JobSeekerName, $msgBody);
                    $msgBody = str_replace('{CURRENCY}', $user->currency, $msgBody);
                    $msgBody = str_replace('{PACKAGE_PRICE}', $packagePrice, $msgBody);
                    $msgBody = str_replace('{PAYMENT_STATUS}', $paymentstatus, $msgBody);
                    $path = JURI::root();
                    $path .= 'administrator/index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymentdetails&pk=' . $user->id;
                    $jpacklink = '<br><a href="' . $path . '" target="_blank" >' . JText::_('Package Detail') . '</a>';
                    $msgBody = str_replace('{PACKAGE_LINK}', $jpacklink, $msgBody);
                    break;
            }
            $message = JFactory::getMailer();
            if(!empty($adminEmail)){
                $message->addRecipient($adminEmail); //to email
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
