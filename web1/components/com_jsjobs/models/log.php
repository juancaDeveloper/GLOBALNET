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

class JSJobsModelLog extends JSModel {

    var $_uid = null;
    var $_siteurl;

    function __construct() {
        parent::__construct();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
        $this->_siteurl = JURI::root();
    }

    function log_Unsubscribe_JobAlert($return_value) {
        $jobseeker_model = $this->getJSModel('jobseeker');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isunsubjobalert'] == 1) {
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Unsubscribe Job Alert";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
            } elseif ($return_value['isunsubjobalert'] == 0) {
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Unsubscribe Job Alert";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
            }
        }
        return true;
    }

    function log_Store_JobapplySharing($return_value) {
        $jobseeker_model = $this->getJSModel('jobseeker');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isjobapplystore'] == 1) {
                if ($return_value['status'] == "Jobapply Sucessfully") {
                    $serverjobapplystatus = "ok";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Jobapply";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverjobapplystatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'jobapply');
            } elseif ($return_value['isjobapplystore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $serverjobapplystatus = "Data not post on server";
                } elseif ($return_value['status'] == "Jobapply Saving Error") {
                    $serverjobapplystatus = "Error Jobapply Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $serverjobapplystatus = "Authentication Fail";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Jobapply";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverjobapplystatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'jobapply');
            }
        }
        return true;
    }

    function log_Store_JobSharing($return_data) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_data)) {
            if ($return_data['isjobstore'] == 1) {
                if ($return_data['status'] == "Job Edit") {
                    $serverjobstatus = "ok";
                } elseif ($return_data['status'] == "Job Add") {
                    $serverjobstatus = "ok";
                } elseif ($return_data['status'] == "Edit Job Userfield") {
                    $serverjobstatus = "ok";
                } elseif ($return_data['status'] == "Add Job Userfield") {
                    $serverjobstatus = "ok";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_data['referenceid'];
                $logarray['eventtype'] = $return_data['eventtype'];
                $logarray['message'] = $return_data['message'];
                $logarray['event'] = "job";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                if (isset($return_data['jobcities'])) {
                    $jobsharing->update_MultiCityServerid($return_data['jobcities'], 'jobcities');
                }
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverjobstatus, $logarray['referenceid'], $return_data['serverid'], $logarray['uid'], 'jobs');
            } elseif ($return_data['isjobstore'] == 0) {
                if ($return_data['status'] == "Data Empty") {
                    $serverjobstatus = "Data not post on server";
                } elseif ($return_data['status'] == "job Saving Error") {
                    $serverjobstatus = "Error Job Saving";
                } elseif ($return_data['status'] == "Auth Fail") {
                    $serverjobstatus = "Authentication Fail";
                } elseif ($return_data['status'] == "Error Save Job Userfield") {
                    $serverjobstatus = "Error Save Job Userfield";
                } elseif ($return_data['status'] == "Improper job name") {
                    $serverjobstatus = "Improper job name";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_data['referenceid'];
                $logarray['eventtype'] = $return_data['eventtype'];
                $logarray['message'] = $return_data['message'];
                $logarray['event'] = "job";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverjobstatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'jobs');
            }
        }
        return true;
    }

    function log_Store_goldfeaturdjob($return_data) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_data)) {
            $logarray['uid'] = $employer_model->_uid;
            $logarray['referenceid'] = $return_data['referenceid'];
            $logarray['event'] = "job";
            $logarray['eventtype'] = $return_data['eventtype'];
            $logarray['message'] = $return_data['message'];
            $logarray['datetime'] = date('Y-m-d H:i:s');
            if ($return_data['goldfeatured'] == 1) {
                $logarray['messagetype'] = "Sucessfully";
            } elseif ($return_data['goldfeatured'] == 0) {
                $logarray['messagetype'] = "Error";
            }
            $jobsharing->write_JobSharingLog($logarray);
        }
        return true;
    }

    function log_Store_VisitorCompanyJobSharing($return_value) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isjobstore'] == 1) {
                if ($return_value['status'] == "Job Edit") {
                    $serverjobstatus = "ok";
                } elseif ($return_value['status'] == "Job Add") {
                    $serverjobstatus = "ok";
                } elseif ($return_value['status'] == "Edit Job Userfield") {
                    $serverjobstatus = "ok";
                } elseif ($return_value['status'] == "Add Job Userfield") {
                    $serverjobstatus = "ok";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "job";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverjobstatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'jobs');
            } elseif ($return_value['isjobstore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $serverjobstatus = "Data not post on server";
                } elseif ($return_value['status'] == "job Saving Error") {
                    $serverjobstatus = "Error Job Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $serverjobstatus = "Authentication Fail";
                } elseif ($return_value['status'] == "Error Save Job Userfield") {
                    $serverjobstatus = "Error Save Job Userfield";
                } elseif ($return_value['status'] == "Improper job name") {
                    $serverjobstatus = "Improper job name";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = "Visitor" . $return_value['message'];
                $logarray['event'] = "job";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverjobstatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'jobs');
            }
        }
        return true;
    }

    function log_Store_CompanySharing($return_value) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['iscompanystore'] == 1) {
                if ($return_value['status'] == "Company Edit") {
                    $servercompanytatus = "ok";
                } elseif ($return_value['status'] == "Company Add") {
                    $servercompanytatus = "ok";
                } elseif ($return_value['status'] == "Company with logo Add") {
                    $servercompanytatus = "ok";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Company";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                if (isset($return_value['companycities'])) {
                    $jobsharing->update_MultiCityServerid($return_value['companycities'], 'companycities');
                }
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($servercompanytatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'companies');
            } elseif ($return_value['iscompanystore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $servercompanytatus = "Data not post on server";
                } elseif ($return_value['status'] == "Company Saving Error") {
                    $servercompanytatus = "Error Company Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $servercompanytatus = "Authentication Fail";
                } elseif ($return_value['status'] == "Improper Company name") {
                    $servercompanytatus = "Improper Company name";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Company";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($servercompanytatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'companies');
            }
        }
        return true;
    }

    function log_Store_JobAlertSharing($return_value) {
        $jobseeker_model = $this->getJSModel('jobseeker');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isjobalertstore'] == 1) {
                if ($return_value['status'] == "Job Alert Edit") {
                    $jobalertstatus = "ok";
                } elseif ($return_value['status'] == "Job Alert Add") {
                    $jobalertstatus = "ok";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Job Alert";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                if (isset($return_value['alertcities'])) {
                    $jobsharing->update_MultiCityServerid($return_value['alertcities'], 'jobalertcities');
                }
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($jobalertstatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'jobalertsetting');
            } elseif ($return_value['isjobalertstore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $jobalertstatus = "Data not post on server";
                } elseif ($return_value['status'] == "Job Alert Saving Error") {
                    $jobalertstatus = "Error Job Alert Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $jobalertstatus = "Authentication Fail";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Job Alert";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($jobalertstatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'jobalertsetting');
            }
        }
        return true;
    }

    function log_Store_ResumeCommentsSharing($return_value) {
        $jobseeker_model = $this->getJSModel('jobseeker');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isresumecommentsstore'] == 1) {
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Resume Comments";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
            } elseif ($return_value['isresumecommentsstore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $serverresumeratingstatus = "Data not post on server";
                } elseif ($return_value['status'] == "Resume Comments Saving Error") {
                    $serverresumeratingstatus = "Error Resume Comments Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $serverresumeratingstatus = "Authentication Fail";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Resume Comments";
                $logarray['messagetype'] = "Error" . $serverresumeratingstatus;
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
            }
            $msg = JText::_('Resume comments has been saved');
        }
        return true;
    }

    function log_Store_ResumeRatingSharing($return_value) {
        $jobseeker_model = $this->getJSModel('jobseeker');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isresumeratingstore'] == 1) {
                if ($return_value['status'] == "Resumerating Sucessfully") {
                    $serverresumeratingstatus = "ok";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Resumerating";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverresumeratingstatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'resumerating');
            } elseif ($return_value['isresumeratingstore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $serverresumeratingstatus = "Data not post on server";
                } elseif ($return_value['status'] == "Resumerating Saving Error") {
                    $serverresumeratingstatus = "Error Resumerating Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $serverresumeratingstatus = "Authentication Fail";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Resumerating";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverresumeratingstatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'resumerating');
            }
        }
        return true;
    }

    function log_Store_FolderSharing($return_value) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isfolderstore'] == 1) {
                if ($return_value['status'] == "Folder Edit") {
                    $serverfolderstatus = "ok";
                } elseif ($return_value['status'] == "Folder Add") {
                    $serverfolderstatus = "ok";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Folder";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverfolderstatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'folders');
            } elseif ($return_value['isfolderstore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $serverfolderstatus = "Data not post on server";
                } elseif ($return_value['status'] == "Folder Saving Error") {
                    $serverfolderstatus = "Error Folder Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $serverfolderstatus = "Authentication Fail";
                } elseif ($return_value['status'] == "Improper Folder name") {
                    $serverfolderstatus = "Improper Folder name";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Folder";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverfolderstatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'folders');
            }
        }
        return true;
    }

    function log_Store_ResumeFolderSharing($return_value) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isfolderresumestore'] == 1) {
                if ($return_value['status'] == "Folderresume Sucessfully") {
                    $serverfolderresumestatus = "ok";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Folder Resume";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverfolderresumestatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'folderresumes');
            } elseif ($return_value['isfolderresumestore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $serverfolderresumestatus = "Data not post on server";
                } elseif ($return_value['status'] == "Folderresume Saving Error") {
                    $serverfolderresumestatus = "Error Folder Resume Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $serverfolderresumestatus = "Authentication Fail";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Folder Resume";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverfolderresumestatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'folderresumes');
            }
        }
        return true;
    }

    function log_Store_ResumeSharing($return_value) {
        $jobseeker_model = $this->getJSModel('jobseeker');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isresumestore'] == 1) {
                if ($return_value['status'] == "Resume Edit") {
                    $serverresumestatus = "ok";
                } elseif ($return_value['status'] == "Resume Add") {
                    $serverresumestatus = "ok";
                } elseif ($return_value['status'] == "Edit Resume Userfield") {
                    $serverresumestatus = "ok";
                } elseif ($return_value['status'] == "Add Resume Userfield") {
                    $serverresumestatus = "ok";
                } elseif ($return_value['status'] == "Resume with Picture") {
                    $serverresumestatus = "ok";
                } elseif ($return_value['status'] == "Resume with File") {
                    $serverresumestatus = "ok";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Resume";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverresumestatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'resume');
            } elseif ($return_value['isresumestore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $serverresumestatus = "Data not post on server";
                } elseif ($return_value['status'] == "Resume Saving Error") {
                    $serverresumestatus = "Error Resume Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $serverresumestatus = "Authentication Fail";
                } elseif ($return_value['status'] == "Error in saving resume user fields") {
                    $serverresumestatus = "Error in saving resume user fields";
                } elseif ($return_value['status'] == "Improper Resume name") {
                    $serverresumestatus = "Improper Resume name";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Resume";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverresumestatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'resume');
            }
        }
        return true;
    }

    function log_Store_DepartmentSharing($return_value) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isdepartmentstore'] == 1) {
                if ($return_value['status'] == "Department Edit") {
                    $serverdepartmentstatus = "ok";
                } elseif ($return_value['status'] == "Department Add") {
                    $serverdepartmentstatus = "ok";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Department";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverdepartmentstatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'departments');
            } elseif ($return_value['isdepartmentstore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $serverdepartmentstatus = "Data not post on server";
                } elseif ($return_value['status'] == "Department Saving Error") {
                    $serverdepartmentstatus = "Error Department Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $serverdepartmentstatus = "Authentication Fail";
                } elseif ($return_value['status'] == "Improper Department name") {
                    $serverdepartmentstatus = "Improper Department name";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Department";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverdepartmentstatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'departments');
            }
        }
        return true;
    }

    function log_Store_MessageSharing($return_value) {
        $common_model = $this->getJSModel('common');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['ismessagestore'] == 1) {
                if ($return_value['status'] == "Message Sucessfully") {
                    $servermessage = "ok";
                }
                $logarray['uid'] = $common_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Messages";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($servermessage, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'messages');
            } elseif ($return_value['ismessagestore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $servermessage = "Data not post on server";
                } elseif ($return_value['status'] == "Message Saving Error") {
                    $servermessage = "Error Message Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $servermessage = "Authentication Fail";
                }
                $logarray['uid'] = $common_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Messages";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($servermessage, $logarray['referenceid'], $serverid, $logarray['uid'], 'messages');
            }
        }
        return true;
    }

    function log_Store_CoverLetterSharing($return_value) {
        $jobseeker_model = $this->getJSModel('jobseeker');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['iscoverletterstore'] == 1) {
                if ($return_value['status'] == "Coverletter Edit") {
                    $servercoverletterstatus = "ok";
                } elseif ($return_value['status'] == "Coverletter Add") {
                    $servercoverletterstatus = "ok";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "CoverLetter";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($servercoverletterstatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'coverletters');
            } elseif ($return_value['iscoverletterstore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $servercoverletterstatus = "Data not post on server";
                } elseif ($return_value['status'] == "Coverletter Saving Error") {
                    $servercoverletterstatus = "Error Coverletter Saving";
                } elseif ($return_value['status'] == "Auth Fail") {
                    $servercoverletterstatus = "Authentication Fail";
                } elseif ($return_value['status'] == "Improper Coverletter name") {
                    $servercoverletterstatus = "Improper Coverletter name";
                }
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "CoverLetter";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($servercoverletterstatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'coverletters');
            }
        }
        return true;
    }

    function log_Delete_CoverletterSharing($return_value) {
        $jobsharing = $this->getJSModel('jobsharingsite');
        $jobseeker_model = $this->getJSModel('jobseeker');
        if (is_array($return_value)) {
            if ($return_value['iscoverletterdelete'] == 1) {
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Coverletter";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
            } elseif ($return_value['iscoverletterdelete'] == -1) {
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Coverletter";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
            }
        }
        return true;
    }

    function log_Delete_ResumeSharing($return_value) {
        $jobsharing = $this->getJSModel('jobsharingsite');
        $jobseeker_model = $this->getJSModel('jobseeker');
        if (is_array($return_value)) {
            if ($return_value['isresumedelete'] == 1) {
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Resume";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
            } elseif ($return_value['isfolderdelete'] == -1) {
                $logarray['uid'] = $jobseeker_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Resume";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
            }
        }
        return true;
    }

    function log_Delete_JobSharing($return_value) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isjobdelete'] == 1) {
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Job";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
            } elseif ($return_value['isjobdelete'] == -1) {
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Job";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
            }
        }
        return true;
    }

    function log_Delete_DepartmentSharing($return_value) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isdepartmentdelete'] == 1) {
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Department";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
            } elseif ($return_value['isdepartmentdelete'] == -1) {
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Department";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
            }
        }
        return true;
    }

    function log_Delete_CompanySharing($return_value) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['iscompanydelete'] == 1) {
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Company";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
            } elseif ($return_value['iscompanydelete'] == -1) {
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Company";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
            }
        }
        return true;
    }

    function log_Delete_FolderSharing($return_value) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_value)) {
            if ($return_value['isfolderdelete'] == 1) {
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Folder";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jobsharing->write_JobSharingLog($logarray);
            } elseif ($return_value['isfolderdelete'] == -1) {
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Delete Folder";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
            }
        }
        return true;
    }

    function log_Store_Copyjob($return_data) {
        $employer_model = $this->getJSModel('employer');
        $jobsharing = $this->getJSModel('jobsharingsite');
        if (is_array($return_data)) {
            if ($return_data['isjobstore'] == 1) {
                if ($return_data['status'] == "Job Edit") {
                    $serverjobstatus = "ok";
                } elseif ($return_data['status'] == "Job Add") {
                    $serverjobstatus = "ok";
                } elseif ($return_data['status'] == "Edit Job Userfield") {
                    $serverjobstatus = "ok";
                } elseif ($return_data['status'] == "Add Job Userfield") {
                    $serverjobstatus = "ok";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_data['referenceid'];
                $logarray['eventtype'] = $return_data['eventtype'];
                $logarray['message'] = $return_data['message'];
                $logarray['event'] = "job Copy";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                if (isset($return_data['jobcities'])) {
                    $jobsharing->update_MultiCityServerid($return_data['jobcities'], 'jobcities');
                }

                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverjobstatus, $logarray['referenceid'], $return_data['serverid'], $logarray['uid'], 'jobs');
            } elseif ($return_data['isjobstore'] == 0) {
                if ($return_data['status'] == "Data Empty") {
                    $serverjobstatus = "Data not post on server";
                } elseif ($return_data['status'] == "job Saving Error") {
                    $serverjobstatus = "Error Job Saving";
                } elseif ($return_data['status'] == "Auth Fail") {
                    $serverjobstatus = "Authentication Fail";
                } elseif ($return_data['status'] == "Error Save Job Userfield") {
                    $serverjobstatus = "Error Save Job Userfield";
                } elseif ($return_data['status'] == "Improper job name") {
                    $serverjobstatus = "Improper job name";
                }
                $logarray['uid'] = $employer_model->_uid;
                $logarray['referenceid'] = $return_data['referenceid'];
                $logarray['eventtype'] = $return_data['eventtype'];
                $logarray['message'] = $return_data['message'];
                $logarray['event'] = "job Copy";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $jobsharing->write_JobSharingLog($logarray);
                $jobsharing->Update_ServerStatus($serverjobstatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'jobs');
            }
        }
        return true;
    }

}

/*$common_model = new JSJobsModelCommon;
        $jobseeker_model = new JSJobsModelJobseeker;
        $employer_model = new JSJobsModelEmployer;
        $jobsharing = new JSJobsModelJob_Sharing;*/
