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

class JSJobsViewReport extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        $session = JFactory::getSession();
        if ($layoutName == 'jobsexport') {          // exportjobs
            $result = $this->getJSModel('report')->getFieldsForJobsExport();
            $this->assignRef('lists', $result);
        }elseif ($layoutName == 'companiesexport') {          // exportcompanies
            $result = $this->getJSModel('report')->getFieldsForCompaniesExport();
            $this->assignRef('lists', $result);
        }elseif ($layoutName == 'resumesexport') {          // exportreumes
            $result = $this->getJSModel('report')->getFieldsForResumesExport();
            $this->assignRef('lists', $result);
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