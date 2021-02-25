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

class JSJobsViewJobAlert extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';
        if ($layout == 'jobalertsetting') {           // jobalert
            $page_title .= ' - ' . JText::_('Job Alert Info');
            $result = $this->getJSModel('jobalert')->getJobAlertbyUidforForm($uid);
            if (!$uid) {
                $result1 = $this->getJSModel('common')->getCaptchaForForm();
                $this->assignRef('captcha', $result1);
            }
            $this->assignRef('jobsetting', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('cansetjobalert', $result[2]);
            if (isset($result[3]))
                $this->assignRef('multiselectedit', $result[3]);

            JHTML::_('behavior.formvalidation');
        }elseif ($layout == 'jobalertunsubscribe') {
            $email = JRequest::getVar('email');
            $this->assignRef('email', $email);
        }
        require_once('jobalert_breadcrumbs.php');
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
