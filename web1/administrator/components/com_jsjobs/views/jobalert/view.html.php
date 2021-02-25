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

class JSJobsViewJobalert extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formjobalert') { // formjobalert
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('jobalert')->getJobAlertbyIdforForm($c_id);
            $this->assignRef('jobalert', $result[0]);
            $this->assignRef('lists', $result[1]);
            if (isset($result[2]))
                $this->assignRef('multiselectedit', $result[2]);
            $text = JText::_('Edit');
            JToolBarHelper::title(JText::_('Job Alert') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::save('jobalert.savejobalert');
            if ($isNew)
                JToolBarHelper::cancel('jobalert.cancel');
            else
                JToolBarHelper::cancel('jobalert.cancel', 'Close');
        }elseif ($layoutName == 'jobalert') {    //jobalert
            JToolBarHelper::title(JText::_('Job Alert'));
            $form = 'com_jsjobs.jobalert.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');

            $result = $this->getJSModel('jobalert')->getAllJobAlerts($searchname, $limitstart, $limit);
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
