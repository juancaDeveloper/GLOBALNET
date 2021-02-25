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

class JSJobsViewFolder extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';
        if ($layout == 'folder_resumes') {      // folder_resumes
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '') {
                    $sort = 'apply_datedesc';
                }
            } else {
                $sort = 'apply_datedesc';
            }
            $sortby = $this->getEmpListOrdering($sort);
            $folderid = $this->getJSModel('common')->parseId(JRequest::getVar('fd', ''));
            $result = $this->getJSModel('folderresume')->getFolderResumebyFolderId($uid, $folderid, $sortby, $limit, $limitstart);
            $this->assignRef('resume', $result[0]);
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('fieldsordering', $result[2]);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('fd', $folderid);
        }elseif ($layout == 'formfolder') {           // form company
            $page_title .= ' - ' . JText::_('Folders Info');
            $folderid = $this->getJSModel('common')->parseId(JRequest::getVar('fd', ''));
            $result = $this->getJSModel('folder')->getFolderbyIdforForm($folderid, $uid);
            $this->assignRef('folders', $result[0]);
            $this->assignRef('canaddnewfolder', $result[1]);
            $this->assignRef('packagedetail', $result[2]);
            JHTML::_('behavior.formvalidation');
        } elseif ($layout == 'myfolders') {   // my folders
            $page_title .= ' - ' . JText::_('My Folders');
            $myfolder_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_FOLDER");
            if ($myfolder_allowed == VALIDATE) {
                $result = $this->getJSModel('folder')->getMyFolders($uid, $limit, $limitstart);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
                $this->assignRef('folders', $result[0]);
            }
            $this->assignRef('myfolder_allowed', $myfolder_allowed);
        }elseif ($layout == 'viewfolder') {   // folders view
            $page_title .= ' - ' . JText::_('My Folders');
            $fid = $this->getJSModel('common')->parseId(JRequest::getVar('fd', ''));
            $result = $this->getJSModel('folder')->getFolderDetail($uid, $fid);
            $this->assignRef('folder', $result);
        }

        require_once('folder_breadcrumbs.php');
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

    function getEmpListOrdering($sort) {
        global $sorton, $sortorder;
        switch ($sort) {
            case "namedesc": $ordering = "app.first_name DESC";
                $sorton = "name";
                $sortorder = "DESC";
                break;
            case "nameasc": $ordering = "app.first_name ASC";
                $sorton = "name";
                $sortorder = "ASC";
                break;
            case "categorydesc": $ordering = "cat.cat_title DESC";
                $sorton = "category";
                $sortorder = "DESC";
                break;
            case "categoryasc": $ordering = "cat.cat_title ASC";
                $sorton = "category";
                $sortorder = "ASC";
                break;
            case "jobtypedesc": $ordering = "app.jobtype DESC";
                $sorton = "jobtype";
                $sortorder = "DESC";
                break;
            case "jobtypeasc": $ordering = "app.jobtype ASC";
                $sorton = "jobtype";
                $sortorder = "ASC";
                break;
            case "jobsalaryrangedesc": $ordering = "salary.rangestart DESC";
                $sorton = "jobsalaryrange";
                $sortorder = "DESC";
                break;
            case "jobsalaryrangeasc": $ordering = "salary.rangestart ASC";
                $sorton = "jobsalaryrange";
                $sortorder = "ASC";
                break;
            case "apply_datedesc": $ordering = "apply.apply_date DESC";
                $sorton = "apply_date";
                $sortorder = "DESC";
                break;
            case "apply_dateasc": $ordering = "apply.apply_date ASC";
                $sorton = "apply_date";
                $sortorder = "ASC";
                break;
            case "emaildesc": $ordering = "app.email_address DESC";
                $sorton = "email";
                $sortorder = "DESC";
                break;
            case "emailasc": $ordering = "app.email_address ASC";
                $sorton = "email";
                $sortorder = "ASC";
                break;
            case "availabledesc": $ordering = "app.iamavailable DESC";
                $sorton = "available";
                $sortorder = "DESC";
                break;
            case "availableasc": $ordering = "app.iamavailable ASC";
                $sorton = "available";
                $sortorder = "ASC";
                break;
            case "educationdesc": $ordering = "app.heighestfinisheducation DESC";
                $sorton = "education";
                $sortorder = "DESC";
                break;
            case "educationasc": $ordering = "app.heighestfinisheducation ASC";
                $sorton = "education";
                $sortorder = "ASC";
                break;
            default: $ordering = "job.id DESC";
        }
        return $ordering;
    }

}

?>
