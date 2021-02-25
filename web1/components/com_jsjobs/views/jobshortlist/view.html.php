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

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewJobshortlist extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';
        if ($layout == 'list_jobshortlist') {
            //COOKIES
            $shortlistarray = array();
            if (isset($_COOKIE['jsjobshortlistid']))
                $shortlistarray = $_COOKIE['jsjobshortlistid'];
            $result = $this->getJSModel('jobshortlist')->getShortListedJobs($uid, $shortlistarray, $limitstart, $limit);

            $this->assignRef('shortlistedJob', $result[0]);
            $this->assignRef('fieldsordering', $result[1]);

            if (isset($result[2])) {
                if ($result[2] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[2], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
        }
        $this->assignRef('uid', $uid);
        $this->assignRef('Itemid', $itemid);
        $this->assignRef('config', $config);
        $this->assignRef('jobseekerlinks', $jobseekerlinks);
        $this->assignRef('employerlinks', $employerlinks);
        $this->assignRef('isjobsharing', $_client_auth_key);
        parent::display($tpl);
    }

}

?>
