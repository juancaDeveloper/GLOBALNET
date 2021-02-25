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

class JSJobsViewFolder extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formfolder') {          // highest educations
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('folder')->getFolderbyId($c_id);
            $folders = $result[0];
            $lists = $result[1];
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Folder') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::save('folder.savefolder');
            if ($isNew)
                JToolBarHelper::cancel('folder.cancel');
            else
                JToolBarHelper::cancel('folder.cancel', 'Close');
            $this->assignRef('folders', $folders);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'folders') {    //folders
            JToolBarHelper::title(JText::_('Folders'));
            JToolBarHelper::addNew('folder.add');
            JToolBarHelper::editList('folder.edit');
            JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'folder.remove');
            JToolBarHelper::cancel('folder.cancel');
            $form = 'com_jsjobs.folder.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchempname = $mainframe->getUserStateFromRequest($form . 'searchempname', 'searchempname', '', 'string');
            $searchstatus = $mainframe->getUserStateFromRequest($form . 'searchstatus', 'searchstatus', '', 'string');
            $result = $this->getJSModel('folder')->getAllFolders( 1, $searchname, $searchempname, $searchstatus , $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists', $result[2]);
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);

        }elseif ($layoutName == 'foldersqueue') {    //folders queue
            JToolBarHelper::title(JText::_('Folder Queue'));
            $form = 'com_jsjobs.folder.list.';
            $searchname = $mainframe->getUserStateFromRequest($form . 'searchname', 'searchname', '', 'string');
            $searchempname = $mainframe->getUserStateFromRequest($form . 'searchempname', 'searchempname', '', 'string');
            $searchstatus = $mainframe->getUserStateFromRequest($form . 'searchstatus', 'searchstatus', '', 'string');
            $result = $this->getJSModel('folder')->getAllFolders( 2, $searchname, $searchempname, $searchstatus , $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists', $result[2]);
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
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
