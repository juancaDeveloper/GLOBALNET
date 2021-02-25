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
jimport('joomla.application.component.model');
jimport('joomla.html.html');
$option = JRequest::getVar('option', 'com_jsjobs');

class JSJobsModelEmployerPackages extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }


    function getEmployerPackageInfoById($packageid) {
        if (is_numeric($packageid) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT package.name ,package.price ,package.discountstartdate ,package.discountenddate ,package.discounttype
                            ,package.price ,package.discount ,package.price ,package.discount ,package.price ,package.fastspringlink
                            ,package.otherpaymentlink ,package.title ,package.otherpaymentlink

        FROM `#__js_job_employerpackages` AS package WHERE id = " . $packageid;

        $db->setQuery($query);
        $package = $db->loadObject();

        return $package;
    }


    function getEmployerPackages($limit, $limitstart) {
        $db = $this->getDBO();
        $result = array();

        $query = "SELECT COUNT(id) FROM `#__js_job_employerpackages` WHERE status = 1";
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT package.title ,package.discountmessage ,package.companiesallow ,package.jobsallow ,package.viewresumeindetails
                        ,package.resumesearch ,package.featuredcompaines ,package.goldcompanies ,package.featuredjobs ,package.goldjobs
                        ,package.featuredcompaniesexpireindays ,package.goldcompaniesexpireindays ,package.saveresumesearch
                        ,package.packageexpireindays ,package.discountstartdate ,package.discountenddate ,package.discounttype
                        ,package.discount ,package.price ,package.id
                        ,cur.symbol
				FROM `#__js_job_employerpackages` AS package 
				LEFT JOIN `#__js_job_currencies` AS cur ON cur.id=package.currencyid
    		WHERE package.status = 1";
            $db->setQuery($query, $limitstart, $limit);
            $packages = $db->loadObjectList();

            $result[0] = $packages;
            $result[1] = $total;

            return $result;
    }

    function getEmployerPackageById($packageid, $uid) {
        if (is_numeric($packageid) == false)
            return false;
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        $db = $this->getDBO();
        $result = array();
        $query = "SELECT package.id ,package.enforcestoppublishjob , package.enforcestoppublishjobvalue , package.enforcestoppublishjobtype,  package.folders, package.messageallow ,package.title ,package.discountstartdate ,package.discountenddate ,package.discountmessage
                    ,package.companiesallow ,package.jobsallow ,package.viewresumeindetails ,package.resumesearch
                    ,package.featuredcompaines ,package.goldcompanies ,package.goldjobs ,package.featuredcompaniesexpireindays
                    ,package.goldcompaniesexpireindays ,package.saveresumesearch ,package.packageexpireindays ,package.discounttype,package.featuredjobs,package.jobseekershortlist
                    ,package.discount ,package.price ,package.description
                    ,cur.symbol,package.virtuemartproductid
			FROM `#__js_job_employerpackages` AS package 
			LEFT JOIN `#__js_job_currencies` AS cur ON cur.id=package.currencyid
			WHERE package.id = " . $packageid;
        $db->setQuery($query);
        $package = $db->loadObject();
        $result[0] = $package;
        return $result;
    }

    function getAllPackagesByUid($uid, $job_id) {
        if (!is_numeric($uid))
            return false;
        if($job_id)
            if(!is_numeric($job_id)) return false;
        
        $db = $this->getDbo();
        $query = "SELECT payment.id AS paymentid, payment.packagetitle AS packagetitle, package.id AS packageid, package.jobsallow, package.enforcestoppublishjob, package.enforcestoppublishjobvalue, package.enforcestoppublishjobtype
                        , package.featuredjobs AS featuredjobs,package.goldjobs AS goldjobs, (SELECT COUNT(id) FROM #__js_job_jobs WHERE packageid = package.id AND paymenthistoryid = payment.id AND uid = " . $uid . ") AS jobavail
                        , (SELECT COUNT(id) FROM `#__js_job_jobs` WHERE isfeaturedjob=1 AND uid = " . $uid . " AND packageid = package.id ) AS availfeaturedjobs
                        , (SELECT COUNT(id) FROM `#__js_job_jobs` WHERE isgoldjob=1 AND uid = " . $uid . " AND packageid = package.id ) AS availgoldjobs
                        FROM #__js_job_paymenthistory AS payment
                        JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                        WHERE uid = " . $uid . "
                        AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                        AND payment.transactionverified = 1 AND payment.status = 1";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        $count = count($result); //check packages more then once or not
        if (isset($job_id) && $job_id != '') {
            $query = "SELECT packageid,paymenthistoryid FROM `#__js_job_jobs` WHERE id = " . $job_id;
            $db->setQuery($query);
            $job = $db->loadObject();
        }
        if ($count > 1) {

            $packagecombo = '<select id="package" class="inputbox " name="package" onChange="Javascript: changeDate(this.value);">';
            $packagecombo .= "<option value=''>" . JText::_('Select Package') . "</option>";

            foreach ($result AS $package) {
                if ($package->jobsallow != -1)
                    $jobleft = ($package->jobsallow - $package->jobavail) . ' ' . JText::_('Jobs Left');
                else
                    $jobleft = JText::_('Unlimited Jobs');
                if ($package->enforcestoppublishjob == 1) {
                    switch ($package->enforcestoppublishjobtype) {
                        case 1:$timetype = JText::_('Days');
                            break;
                        case 2:$timetype = JText::_('Weeks');
                            break;
                        case 3:$timetype = JText::_('Months');
                            break;
                    }
                    $jobduration = $package->enforcestoppublishjobvalue . ' ' . $timetype;
                } else {
                    $jobduration = JText::_('Manual Select');
                }
                $title = '"' . $package->packagetitle . '"  ' . $jobleft . ', ' . JText::_('Jobs Duration') . ' ' . $jobduration;
                if (isset($job) && $job->packageid == $package->packageid) {
                    $packagecombo .= "<option value='$package->packageid' selected=\"selected\">$title</option>";
                    $combobox[] = array('value' => $package->packageid, 'text' => $title);
                } else {
                    $packagecombo .= "<option value='$package->packageid'>$title</option>";
                    $combobox[] = array('value' => $package->packageid, 'text' => $title);
                }
                $packagedetail["$package->packageid"] = $package;
            }
            $packagecombo .= "</select>";
            if (isset($job_id) && $job_id != '') {
                $lists['packages'] = JHTML::_('select.genericList', $combobox, 'multipackage', 'class="inputbox "' . 'onChange="changeDate(this.value)"' . '', 'value', 'text', $job->packageid);
            } else {
                $lists['packages'] = JHTML::_('select.genericList', $combobox, 'multipackage', 'class="inputbox "' . 'onChange="changeDate(this.value)"' . '', 'value', 'text', '');
            }

            //$lists['packages'] = JHTML::_('select.genericList', $combobox, 'multipackage', 'class="inputbox validate-selectpackage"'. '', 'value', 'text','' );

            $return[0] = $packagecombo;
            //$return[0] = $lists;
            $return[1] = $packagedetail;
        } elseif ($count == 1)
            $return = false;
        elseif ($count == 0)
            $return = 2; //no package
        return $return;
    }

    public function getEmployerPackageByVmId($productid){
        if( !JSModel::getJSModel(JSJOBSVMS)->{JSJOBSVMSFUN}('dVhteXlNdmlydHVlbWFyRWt4dnhC') )
            return false;
        $db = JFactory::getDbo();
        $query = "SELECT * FROM `#__js_job_employerpackages` WHERE `virtuemartproductid`=".$productid;
        $db->setQuery($query);
        $package = $db->loadObject();
        if(is_object($package))
            return $package;
        return null;
    }

    

}
?>


