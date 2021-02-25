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

class JSJobsViewJobapply extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';

        if ($layoutName == 'jobappliedresume') { //job applied resume
            JToolBarHelper::title(JText::_('Applied Resume'));
            JToolBarHelper::cancel('jobalert.cancel');
            $jobid = JRequest::getVar('oi');
            $tab_action = JRequest::getVar('ta', '');
            $session = JFactory::getSession();
            $needle_array = $session->get('jsjobappliedresumefilter');

            if (empty($tab_action))
                $tab_action = 1;
            $needle_array = ($needle_array ? $needle_array : "");

            if($needle_array)
                $arr_for_filter = json_decode($needle_array, TRUE);


            $form = 'com_jsjobs.jobappliedresume.list.';
            $result = $this->getJSModel('jobapply')->getJobAppliedResume($needle_array, $tab_action, $jobid, $limitstart, $limit);
            $result1 = $this->getJSModel('jobapply')->getJobAppliedResumeSearchOption($needle_array);
            $items = $result[0];
            $total = $result[1];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('filter_data', $arr_for_filter);
            $this->assignRef('oi', $jobid);
            $this->assignRef('tabaction', $tab_action);
            $this->assignRef('searchoptions', $result1[0]); // for advance search tab 
            $this->assignRef('resumeCountPerTab', $result[3]); // for advance search tab 
            $session->clear('jsjobappliedresumefilter');
        }


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
