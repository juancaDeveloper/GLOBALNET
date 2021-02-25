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

class JSJobsModelSharingJobshortlist extends JSModel {

    protected $_db = null;
    protected $_client_auth_key = null;
    protected $_siteurl = null;    

    function __construct() {
        parent::__construct();
        $this->_db = JFactory::getDbo();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
    }

    function updateShortlistIDs($sharing){
        if($sharing == 1){ // Sharing is on
            $query = "UPDATE `#__js_job_jobshortlist` AS jobshortlist 
                        JOIN `#__js_job_jobs` AS job ON job.id = jobshortlist.jobid
                        SET jobshortlist.jobid = job.serverid, jobshortlist.sharing = 1 
                        WHERE jobshortlist.sharing = 0";
            $this->_db->setQuery($query);
            $this->_db->query();
        }else{ // Sharing is off
            $query = "UPDATE `#__js_job_jobshortlist` AS jobshortlist 
                        JOIN `#__js_job_jobs` AS job ON job.serverid = jobshortlist.jobid
                        SET jobshortlist.jobid = job.id, jobshortlist.sharing = 0 
                        WHERE jobshortlist.sharing = 1";
            $this->_db->setQuery($query);
            $this->_db->query();
        }
        return;
    }

}
