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

class JSJobsViewCompany extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'mycompanies') {        // my companies
            
            $page_title .= ' - ' . JText::_('My Companies');
            $mycompany_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_COMPANY");
            if ($mycompany_allowed == VALIDATE) {
                $result = $this->getJSModel('company')->getMyCompanies($uid, $limit, $limitstart);
                $companies = $result[0];
                $this->assignRef('companies', $companies);
                $this->assignRef('fieldsordering', $result[2]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
                $companyconfig = $this->getJSModel('configurations')->getConfigByFor('company');
                $this->assignRef('companyconfig', $companyconfig);

            }
            $this->assignRef('mycompany_allowed', $mycompany_allowed);
        }elseif ($layout == 'view_company') {                // view company
            $companyid = $this->getJSModel('common')->parseId(JRequest::getVar('cd', ''));
            $result = $this->getJSModel('company')->getCompanybyId($companyid);
            $company = $result[0];
            $company_title = isset($company->name) ? $company->name : '';
            $company_description = isset($company->description) ? $company->description : '';
            $document->setMetaData('title', $company_title, true);
            $document->setDescription($company_description);
            $this->assignRef('company', $company);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            $jobcat = JRequest::getVar('cat', '');
            $this->assignRef('jobcat', $jobcat);
            if (isset($company)) {
                $page_title .= ' - ' . $company->name;
            }
        } elseif ($layout == 'formcompany') {           // form company
          
			$page_title .= ' - ' . JText::_('Company Information');
			$companyid = $this->getJSModel('common')->parseId(JRequest::getVar('cd', ''));
			$showform = true;
            $this->getJSModel('permissions');
			if($uid == 0){
				$param = VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA;
				$this->assignRef('canaddnewcompany', $param);
				$avoid_breadcrumbs = 1;
				unset($result);
				$result[0] = false;
			}else{
				if($companyid){
					if(!$this->getJSModel('company')->getIfCompanyOwner($companyid, $uid)){
						$param = JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA;
						$this->assignRef('canaddnewcompany', $param);
						$avoid_breadcrumbs = 1;
						unset($result);
						$result[0] = false;         			
						$showform = false;
					}
				}
				if($showform == true){
					$page_title .= ' - ' . JText::_('Company Information');
					if (!isset($companyid))
						$companyid = '';
					$result = $this->getJSModel('company')->getCompanybyIdforForm($companyid, $uid, '', '', '');
					$this->assignRef('company', $result[0]);
					$this->assignRef('lists', $result[1]);
					$this->assignRef('userfields', $result[2]);
					$this->assignRef('fieldsordering', $result[3]);
					$this->assignRef('canaddnewcompany', $result[4]);
					$this->assignRef('packagedetail', $result[5]);
					if (isset($result[6]))
						$this->assignRef('multiselectedit', $result[6]);
					JHTML::_('behavior.formvalidation');
				}
			}
        } elseif ($layout == 'company_info') {            // job Details
            //--//
            $companyid = JRequest::getVar('cd');
            $result = $this->getJSModel('company')->getCompanyInfoById($companyid);
            $this->assignRef('info', $result[0]);
            $this->assignRef('jobs', $result[1]);
            $this->assignRef('company', $result[2]);
        } elseif ($layout == 'listallcompanies') {            // List all companies
            $page_title .= ' - ' . JText::_('All Companies');
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '')
                    $sort = 'createddesc';
            } else {
                $sort = 'createddesc';
            }
            if(JRequest::getVar('sortby',null) == null && JRequest::getVar('limitstart',null) == null){                
                $mainframe->setUserState($option.'companycity','');
                $mainframe->setUserState($option.'companyname','');
            }
            $sortby = $this->getJobListOrdering($sort);
            $filter_search = array();
            $filter_search['companycity'] = $mainframe->getUserStateFromRequest($option . 'companycity', 'companycity', '', 'string');
            $filter_search['companyname'] = $mainframe->getUserStateFromRequest($option . 'companyname', 'companyname', '', 'string');
            $result = $this->getJSModel('company')->getAllCompaniesList($sortby, $limit, $limitstart,$filter_search);
            $this->assignRef('companies', $result[0]);
            $this->assignRef('multicities', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $sortlinks = $this->getJobListSorting($sort);
            $sortlinks['sorton'] = $sorton;
            $sortlinks['sortorder'] = $sortorder;
            $this->assignRef('sortlinks', $sortlinks);
            $this->assignRef('filter_search', $filter_search);
        }
        require_once('company_breadcrumbs.php');
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

    function getJobListSorting($sort) {
        $sortlinks['name'] = $this->getSortArg("name", $sort);
        $sortlinks['category'] = $this->getSortArg("category", $sort);
        $sortlinks['city'] = $this->getSortArg("city", $sort);
        $sortlinks['created'] = $this->getSortArg("created", $sort);
        return $sortlinks;
    }

    function getSortArg($type, $sort) {
        $mat = array();
        if (preg_match("/(\w+)(asc|desc)/i", $sort, $mat)) {
            if ($type == $mat[1]) {
                return ( $mat[2] == "asc" ) ? "{$type}desc" : "{$type}asc";
            } else {
                return $type . $mat[2];
            }
        }
        return "createddesc";
    }

    function getJobListOrdering($sort) {
        global $sorton, $sortorder;
        switch ($sort) {
            case "namedesc": $ordering = "company.name DESC";
                $sorton = "name";
                $sortorder = "DESC";
                break;
            case "nameasc": $ordering = "company.name ASC";
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
            case "citydesc": $ordering = "city.name DESC";
                $sorton = "city";
                $sortorder = "DESC";
                break;
            case "cityasc": $ordering = "city.name ASC";
                $sorton = "city";
                $sortorder = "ASC";
                break;
            case "createddesc": $ordering = "company.created DESC";
                $sorton = "created";
                $sortorder = "DESC";
                break;
            case "createdasc": $ordering = "company.created ASC";
                $sorton = "created";
                $sortorder = "ASC";
                break;
            default: $ordering = "company.created DESC";
                $sorton = "created";
                $sortorder = "DESC";
                break;
        }
        return $ordering;
    }

}

?>
