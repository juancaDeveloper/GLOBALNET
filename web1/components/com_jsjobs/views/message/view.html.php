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

class JSJobsViewMessage extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'empmessages') {        // emp messages            
            $page_title .= ' - ' . JText::_('Messages');
            $mymessage_allowed = $this->getJSModel('permissions')->checkPermissionsFor("EMPLOYER_MESSAGES");
            if ($mymessage_allowed == VALIDATE) {
                $result = $this->getJSModel('message')->getMessagesbyJobs($uid, $limit, $limitstart);
                $this->assignRef('messages', $result[0]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
            $this->assignRef('mymessage_allowed', $mymessage_allowed);
        }elseif ($layout == 'send_message') {        // messages
            $page_title .= ' - ' . JText::_('Messages');
            $jobaliasid = JRequest::getVar('bd');
            $jobid = $this->getJSModel('common')->parseId($jobaliasid);
            $resumealiasid = JRequest::getVar('rd');
            $resumeid = $this->getJSModel('common')->parseId($resumealiasid);
            $result = $this->getJSModel('message')->getMessagesbyJobResume($uid, $jobid, $resumeid, $limit, $limitstart);
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('messages', $result[0]);

            $this->assignRef('totalresults', $result[1]);
            $this->assignRef('canadd', $result[2]);
            if (isset($result[3]))
                $this->assignRef('summary', $result[3]);
            $this->assignRef('jobaliasid', $jobaliasid);
            $this->assignRef('resumealiasid', $resumealiasid);
            $nav = JRequest::getVar('nav');
            $this->assignRef('nav', $nav);
        }elseif ($layout == 'job_messages') {        // job messages
            $jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd'));
            $page_title .= ' - ' . JText::_('Messages');
            $result = $this->getJSModel('message')->getMessagesbyJob($uid, $jobid, $limit, $limitstart);
            $this->assignRef('messages', $result[0]);
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }elseif ($layout == 'jsmessages') {        // jobseeker messages
            $page_title .= ' - ' . JText::_('Messages');
            $mymessage_allowed = $this->getJSModel('permissions')->checkPermissionsFor("JOBSEEKER_MESSAGES");
            if ($mymessage_allowed == VALIDATE) {
                $result = $this->getJSModel('message')->getMessagesbyJobsforJobSeeker($uid, $limit, $limitstart);
                $this->assignRef('messages', $result[0]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
            $this->assignRef("mymessage_allowed", $mymessage_allowed);
        }

        require_once('message_breadcrumbs.php');
        $document->setTitle($page_title);
        $this->assignRef('userrole', $userrole);
        $this->assignRef('config', $config);
        $this->assignRef('socailsharing', $socialconfig);
        $this->assignRef('option', $option);
        $this->assignRef('params', $params);
        $this->assignRef('viewtype', $viewtype);
        $this->assignRef('employerlinks', $employerlinks);
        $this->assignRef('jobseekerlinks', $jobseekerlinks);
        $this->assignRef('uid', $uid);
        $this->assignRef('id', $id);
        $this->assignRef('Itemid', $itemid);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }

}

?>
