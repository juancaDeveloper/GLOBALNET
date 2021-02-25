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

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewMessage extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formmessage') {
            $cids = JRequest::getVar('cid', array(0), 'post', 'array');
            $c_id = $cids[0];
            if (!$c_id)
                $c_id = JRequest::getVar('cid');
            if ($c_id) {
                if(is_array($c_id)){
                    $c_id = $c_id[0];
                }
                $results = $this->getJSModel('message')->getMessagesbyId($c_id);
                $sm = JRequest::getVar('sm', 3);
                $this->assignRef('sm', $sm);
                $this->assignRef('message', $results[0]);
                $this->assignRef('lists', $results[1]);
                if (isset($results[0]->id))
                    $isNew = false;
                $text = $isNew ? JText::_('Add') : JText::_('Edit');
                JToolBarHelper::title(JText::_('Message') . ': <small><small>[ ' . $text . ' ]</small></small>');
                JToolBarHelper::save('message.savemessage');
                if ($isNew)
                    JToolBarHelper::cancel('message.cancel');
                else
                    JToolBarHelper::cancel('message.cancel', 'Close');
            }else {
                $jobid = JRequest::getVar('bd');
                $resumeid = JRequest::getVar('rd');
                $text = JText::_('Send');
                JToolBarHelper::title(JText::_('Message') . ': <small><small>[ ' . $text . ' ]</small></small>');
                $results = $this->getJSModel('message')->getMessagesbyJobResumes($uid, $jobid, $resumeid);
                JToolBarHelper::save('message.savemessage');
                JToolBarHelper::cancel('message.cancelsendmessage');
                $sm = 1;
                $this->assignRef('sm', $sm);
                $this->assignRef('message', $results[0]);
                $this->assignRef('lists', $results[2]);
                $this->assignRef('summary', $results[1]);
            }
        } elseif ($layoutName == 'message_history') {
            JToolBarHelper::title(JText::_('Message History'));
            $jobid = JRequest::getVar('bd');
            $resumeid = JRequest::getVar('rd');
            $result = $this->getJSModel('message')->getMessagesbyJobResume($uid, $jobid, $resumeid, $limit, $limitstart);
            $this->assignRef('messages', $result[0]);
            $this->assignRef('totalresults', $result[1]);
            $this->assignRef('summary', $result[3]);
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $this->assignRef('limit', $limit);
            $this->assignRef('limitstart', $limitstart);
            $this->assignRef('bd', $jobid);
            $this->assignRef('resumeid', $resumeid);
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            JToolBarHelper::cancel('message.cancelmessagehistory');
        } elseif (($layoutName == 'messages') || ($layoutName == 'messagesqueue')) {    //messages
            if ($layoutName == 'messages') {
                $statusoperator = "<>";
                JToolBarHelper::title(JText::_('Messages'));
                JToolBarHelper::editList('message.edit');
                JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'message.remove');
            } else {
                $statusoperator = "=";
                JToolBarHelper::title(JText::_('Messages Approval Queue'));
            }
            $employername = $mainframe->getUserStateFromRequest($option . 'message_employername', 'message_employername', '', 'string');
            $jobseekername = $mainframe->getUserStateFromRequest($option . 'message_jobseekername', 'message_jobseekername', '', 'string');
            $conflict = $mainframe->getUserStateFromRequest($option . 'message_conflicted', 'message_conflicted', '', 'string');
            $status = $mainframe->getUserStateFromRequest($option . 'message_status', 'message_status', '', 'string');
            $company = $mainframe->getUserStateFromRequest($option . 'message_company', 'message_company', '', 'string');
            $jobtitle = $mainframe->getUserStateFromRequest($option . 'message_jobtitle', 'message_jobtitle', '', 'string');
            $subject = $mainframe->getUserStateFromRequest($option . 'message_subject', 'message_subject', '', 'string');
            $appname = $mainframe->getUserStateFromRequest($option . 'message_appname', 'message_appname', '', 'string');
            $result = $this->getJSModel('message')->getAllMessages($statusoperator, $employername, $jobseekername,  $status, $conflict , $company, $appname ,$jobtitle, $subject, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('items', $items);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }

}

?>
