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
$option = JRequest::getVar('option', 'com_jsjobs');

class JSJobsModelSharingJobbytypes extends JSModel {

    protected $_db = null;
    protected $_client_auth_key = null;
    protected $_siteurl = null;    

    function __construct() {
        parent::__construct();
        $this->_db = JFactory::getDbo();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
    }

    function getJobByTypes(){
        $data_resumedetail = array();
        $data_resumedetail['authkey'] = $this->_client_auth_key;
        $data_resumedetail['siteurl'] = $this->_siteurl;
        $fortask = "getjobbytypes";
        $jsjobsharingobject = $this->getJSModel('jobsharingsite');
        $encodedata = json_encode($data_resumedetail);
        $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
        if (isset($return_server_value['jobbytypes']) AND $return_server_value['jobbytypes'] == -1) { // auth fail 
            $logarray['uid'] = $this->_uid;
            $logarray['eventtype'] = $return_server_value['eventtype'];
            $logarray['message'] = $return_server_value['message'];
            $logarray['event'] = "Jobs by types";
            $logarray['messagetype'] = "Error";
            $logarray['datetime'] = date('Y-m-d H:i:s');
            $jsjobsharingobject->write_JobSharingLog($logarray);
        } else {
            $result = $return_server_value['jobbytypes'];
        }
        return $result;
    }

}
