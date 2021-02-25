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
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelReport extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }


    function getFieldsForJobsExport(){
        $lists['companies'] = JHTML::_('select.genericList', $this->getJSModel('company')->getAllCompaniesForSearch(JText::_('Select Company')), 'companyid', 'class="inputbox " ' . 'onChange="getdepartments(\'departmentid\', this.value)"' . '', 'value', 'text', '');
        if (isset($companies[0]['value']))
            $lists['departments'] = JHTML::_('select.genericList', $this->getJSModel('department')->getDepartmentsByCompanyId($companies[0]['value'], ''), 'departmentid', 'class="inputbox "' . '', 'value', 'text', '');
        $lists['jobcategory'] = JHTML::_('select.genericList', $this->getJSModel('category')->getCategories(JText::_('Select Category')), 'jobcategory', 'class="inputbox "' . 'onChange="fj_getsubcategories(\'subcategoryid\', this.value)"', 'value', 'text', '');
        $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo('', JText::_('Sub Category'), ''), 'subcategoryid', 'class="inputbox "' . '', 'value', 'text', '');
        $lists['jobtype'] = JHTML::_('select.genericList', $this->getJSModel('jobtype')->getJobType(JText::_('Select Job Type')), 'jobtype', 'class="inputbox "' . '', 'value', 'text', '');
        $lists['jobstatus'] = JHTML::_('select.genericList', $this->getJSModel('jobstatus')->getJobStatus(JText::_('Select Job Status')), 'jobstatus', 'class="inputbox "' . '', 'value', 'text', '');
        $lists['shift'] = JHTML::_('select.genericList', $this->getJSModel('shift')->getShift(JText::_('Select Shift')), 'shift', 'class="inputbox "' . '', 'value', 'text', '');
        $lists['gender'] = JHTML::_('select.genericList', $this->getJSModel('common')->getGender(JText::_('Does Not Matter')), 'gender', 'class="inputbox " ' . '', 'value', 'text', '');
        $lists['careerlevel'] = JHTML::_('select.genericList', $this->getJSModel('careerlevel')->getCareerLevels(JText::_('Select Career Level')), 'careerlevel', 'class="inputbox "' . '', 'value', 'text', '');
        $lists['workpermit'] = JHTML::_('select.genericList', $this->getJSModel('country')->getCountries(JText::_('Select Workpermit')), 'workpermit', 'class="inputbox " ' . '', 'value', 'text', '');
        
        $gfcombo = array(
            '0' => array('value' => 4, 'text' => JText::_('All')),
            '1' => array('value' => 1, 'text' => JText::_('Gold')),
            '2' => array('value' => 2, 'text' => JText::_('Featured')),
            '3' => array('value' => 3, 'text' => JText::_('Gold').' & '.JText::_('Featured')),
        );

        $status = array();
        $status[] = array('value' => '', 'text' => JText::_('All'));
        $status[] = array('value' => 1, 'text' => JText::_('Approved'));
        $status[] = array('value' => 0, 'text' => JText::_('Pending'));
        $status[] = array('value' => -1, 'text' => JText::_('Rejected'));

        $lists['status'] = JHTML::_('select.genericList', $status , 'status', 'class="inputbox" ' , 'value', 'text', '');
        $lists['isgfcombo'] = JHTML::_('select.genericList', $gfcombo, 'isgfcombo', 'class="inputbox" ' , 'value', 'text', '4');
        // and location
        return $lists;
    }

    function getFieldsForResumesExport(){
        $highesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('Select Highest Education'));
        $experiences = $this->getJSModel('experience')->getExperiences(JText::_('Select Minimum Experience'));
        $experiences1 = $this->getJSModel('experience')->getExperiences(JText::_('Select Maximum Experience'));
        
        $lists['jobcategory'] = JHTML::_('select.genericList', $this->getJSModel('category')->getCategories(JText::_('Select Category')), 'jobcategory', 'class="inputbox "' . 'onChange="fj_getsubcategories(\'subcategoryid\', this.value)"', 'value', 'text', '');
        $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo('', JText::_('Sub Category'), ''), 'subcategoryid', 'class="inputbox "' . '', 'value', 'text', '');
        $lists['jobtype'] = JHTML::_('select.genericList', $this->getJSModel('jobtype')->getJobType(JText::_('Select Job Type')), 'jobtype', 'class="inputbox "' . '', 'value', 'text', '');
        $lists['gender'] = JHTML::_('select.genericList', $this->getJSModel('common')->getGender(JText::_('Does Not Matter')), 'gender', 'class="inputbox " ' . '', 'value', 'text', '');
        
        $lists['nationality'] = JHTML::_('select.genericList', $this->getJSModel('country')->getCountries(JText::_('Select Nationality')), 'nationality', 'class="inputbox " ' . '', 'value', 'text', '');

        $lists['highestfinisheducation'] = JHTML::_('select.genericList', $highesteducation, 'highestfinisheducation', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
        $lists['experiencemin'] = JHTML::_('select.genericList', $experiences, 'experiencemin', 'class="inputbox jsjobs-cbo"' . '', 'value', 'text', '');
        $lists['experiencemax'] = JHTML::_('select.genericList', $experiences1, 'experiencemax', 'class="inputbox jsjobs-cbo"' . '', 'value', 'text', '');
        
        $gfcombo = array(
            '0' => array('value' => 4, 'text' => JText::_('All')),
            '1' => array('value' => 1, 'text' => JText::_('Gold')),
            '2' => array('value' => 2, 'text' => JText::_('Featured')),
            '3' => array('value' => 3, 'text' => JText::_('Gold').' & '.JText::_('Featured')),
        );

        $status = array();
        $status[] = array('value' => '', 'text' => JText::_('All'));
        $status[] = array('value' => 1, 'text' => JText::_('Approved'));
        $status[] = array('value' => 0, 'text' => JText::_('Pending'));
        $status[] = array('value' => -1, 'text' => JText::_('Rejected'));

        $lists['status'] = JHTML::_('select.genericList', $status , 'status', 'class="inputbox" ' , 'value', 'text', '');
        $lists['isgfcombo'] = JHTML::_('select.genericList', $gfcombo, 'isgfcombo', 'class="inputbox" ' , 'value', 'text', '4');
        // and location
        return $lists;
    }

    function getFieldsForCompaniesExport(){
        $lists['category'] = JHTML::_('select.genericList', $this->getJSModel('category')->getCategories(JText::_('Select Category')), 'category', 'class="inputbox "' . 'onChange="fj_getsubcategories(\'subcategoryid\', this.value)"', 'value', 'text', '');
        
        $gfcombo = array(
            '0' => array('value' => 4, 'text' => JText::_('All')),
            '1' => array('value' => 1, 'text' => JText::_('Gold')),
            '2' => array('value' => 2, 'text' => JText::_('Featured')),
            '3' => array('value' => 3, 'text' => JText::_('Gold').' & '.JText::_('Featured')),
        );

        $status = array();
        $status[] = array('value' => '', 'text' => JText::_('All'));
        $status[] = array('value' => 1, 'text' => JText::_('Approved'));
        $status[] = array('value' => 0, 'text' => JText::_('Pending'));
        $status[] = array('value' => -1, 'text' => JText::_('Rejected'));

        $lists['status'] = JHTML::_('select.genericList', $status , 'status', 'class="inputbox" ' , 'value', 'text', '');
        $lists['isgfcombo'] = JHTML::_('select.genericList', $gfcombo, 'isgfcombo', 'class="inputbox" ' , 'value', 'text', '4');
        return $lists;
    }

    function exportJobsData(){
        $data = JRequest::get('post');
        $db = JFactory::getDbo();

        // vars for excel string
        $tb = "\t";
        $nl = "\n";

        $inquery = "";

        $criteria_labels = '';
        $criteria_values = '';

        if(isset($data['companyid']) && $data['companyid'] !='' && is_numeric($data['companyid'])){
            $inquery .= " AND job.companyid  = ".$data['companyid'];
            
            $criteria_labels .= JText::_('Company').$tb;
            $option_text  = $data['companyid_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        } 

        if(isset($data['jobtype']) && $data['jobtype'] !='' && is_numeric($data['jobtype'])){
            $inquery .= " AND job.jobtype  = ".$data['jobtype'];
            $criteria_labels .= JText::_('Job Type').$tb;
            $option_text  = $data['jobtype_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        } 

        if(isset($data['jobcategory']) && $data['jobcategory'] !='' && is_numeric($data['jobcategory'])){
            $inquery .= " AND job.jobcategory  = ".$data['jobcategory'];
            $criteria_labels .= JText::_('Job Category').$tb;
            $option_text  = $data['jobcategory_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        } 

        if(isset($data['subcategoryid']) && $data['subcategoryid'] !='' && is_numeric($data['subcategoryid'])){
            $inquery .= " AND job.subcategoryid  = ".$data['subcategoryid'];
            $criteria_labels .= JText::_('Job Sub Category').$tb;
            $option_text  = $data['subcategoryid_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        } 

        if(isset($data['careerlevel']) && $data['careerlevel'] !='' && is_numeric($data['careerlevel'])){
            $inquery .= " AND job.careerlevel  = ".$data['careerlevel'];
            $criteria_labels .= JText::_('Career Level').$tb;
            $option_text  = $data['careerlevel_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        } 

        if(isset($data['jobstatus']) && $data['jobstatus'] !='' && is_numeric($data['jobstatus'])){
            $inquery .= " AND job.jobstatus  = ".$data['jobstatus'];
            $criteria_labels .= JText::_('Job Status').$tb;
            $option_text  = $data['jobstatus_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        } 

        if(isset($data['shift']) && $data['shift'] !='' && is_numeric($data['shift'])){
            $inquery .= " AND job.shift  = ".$data['shift'];
            $criteria_labels .= JText::_('Job Shift').$tb;
            $option_text  = $data['shift_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        } 

        if(isset($data['gender']) && $data['gender'] !='' && is_numeric($data['gender'])){
            $inquery .= " AND job.gender  = ".$data['gender'];
            $criteria_labels .= JText::_('Gender').$tb;
            $option_text  = $data['gender_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        } 


        if(isset($data['workpermit']) && $data['workpermit'] !='' && is_numeric($data['workpermit'])){
            $inquery .= " AND job.workpermit  = ".$data['workpermit'];
            $criteria_labels .= JText::_('Workpermit').$tb;
            $option_text  = $data['workpermit_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }

        if(isset($data['status']) && $data['status'] !='' && is_numeric($data['status'])){
            $inquery .= " AND job.status  = ".$data['status'];
            $criteria_labels .= JText::_('Status').$tb;
            $option_text  = $data['status_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }

        if(isset($data['city']) && $data['city'] !=''){
            $city_query = '';
            $array = explode(',', $data['city']);

            if(!empty($array)){
                $city_query .= ' AND ( ';
            }
            $counter = 0;
            $q_prefix = '';
            foreach ($array as $item) {
                if($counter != 0){
                    $q_prefix = ' OR ';
                }
                $counter = 1;
                if(is_numeric($item)){
                    $city_query .= $q_prefix." job.city LIKE ".$db->Quote('%'.$item.'%');
                }
            }
            if(!empty($array)){
                $city_query .= ' ) ';
            }

            $criteria_labels .= JText::_('Job Location').$tb;
            $option_text  = $data['citynames'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }


        if(isset($data['isgfcombo']) && $data['isgfcombo'] !='' && is_numeric($data['isgfcombo'])){
            switch ($data['isgfcombo']) {
                case '1':
                    $inquery .= " AND job.isgoldjob = 1 ";
                break;
                case '2':
                    $inquery .= " AND job.isfeaturedjob = 1 ";
                break;
                case '3':
                    $inquery .= " AND job.isgoldjob = 1 AND job.isfeaturedjob = 1 ";
                break;
            }
            $criteria_labels .= JText::_('Gold Featured').$tb;
            $option_text  = $data['isgfcombo_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }


    // dates
        $fromdate = '';
        if(isset($data['fromdate'])){
            $fromdate = $data['fromdate'];
        }

        if($fromdate == '' || $fromdate == '0000-00-00 00:00:00' || $fromdate == '0000-00-00'){
            $fromdate = JHtml::_('date', strtotime(date('Y-m-d')." -30 days"), 'Y-m-d');
        }
        
        $todate = '';
        if(isset($data['todate'])){
            $todate = $data['todate'];
        }

        // dates
        if($todate == '' || $todate == '0000-00-00 00:00:00' || $todate == '0000-00-00'){
            $todate = JHtml::_('date', strtotime(date('Y-m-d')), 'Y-m-d');
        }

        if($fromdate > $todate){
            $temp_date = $todate;
            $todate = $fromdate;
            $fromdate = $temp_date;
        }

        //Data
        $query = "
                SELECT job.params,job.id AS jobid,job.title,job.city,job.metakeywords,job.metadescription,job.description,job.created,job.isgoldjob,job.isfeaturedjob,job.gender
                , job.jobcategory,job.duration,job.hidesalaryrange,job.zipcode,job.iseducationminimax,job.degreetitle,job.isexperienceminimax
                , job.startpublishing,job.requiredtravel,job.noofjobs,job.stoppublishing,job.video,job.prefferdskills,job.qualifications,job.agreement,job.experiencetext,job.longitude,job.latitude
                , cat.cat_title, subcat.title as subcategory, company.name as companyname, jobtype.title AS jobtypetitle
                , jobstatus.title AS jobstatustitle, shift.title as shifttitle,company.logofilename AS companylogo
                , department.name AS departmentname, company.id companyid,job.educationminimax,job.experienceminimax
                , salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto, salarytype.title AS salarytype
                , education.title AS educationtitle ,mineducation.title AS mineducationtitle, maxeducation.title AS maxeducationtitle
                , experience.title AS experiencetitle ,minexperience.title AS minexperiencetitle, maxexperience.title AS maxexperiencetitle
                , currency.symbol, agefrom.title AS agefromtitle, ageto.title AS agetotitle
                , workpermit.name as workpermitcountry, careerlevel.title AS careerleveltitle , job.jobapplylink,job.joblink,job.status
                FROM `#__js_job_jobs` AS job
                JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                LEFT JOIN `#__js_job_ages` AS agefrom ON agefrom.id = job.agefrom
                LEFT JOIN `#__js_job_ages` AS ageto ON ageto.id = job.ageto
                LEFT JOIN `#__js_job_subcategories` AS subcat ON job.subcategoryid = subcat.id
                LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                LEFT JOIN `#__js_job_departments` AS department ON job.departmentid = department.id
                LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
                LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
                LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
                LEFT JOIN `#__js_job_heighesteducation` AS education ON job.educationid = education.id
                LEFT JOIN `#__js_job_heighesteducation` AS mineducation ON job.mineducationrange = mineducation.id
                LEFT JOIN `#__js_job_heighesteducation` AS maxeducation ON job.maxeducationrange = maxeducation.id
                LEFT JOIN `#__js_job_experiences` AS experience ON job.experienceid = experience.id
                LEFT JOIN `#__js_job_experiences` AS minexperience ON job.minexperiencerange = minexperience.id
                LEFT JOIN `#__js_job_experiences` AS maxexperience ON job.maxexperiencerange = maxexperience.id
                LEFT JOIN `#__js_job_shifts` AS shift ON job.shift = shift.id
                LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid
                LEFT JOIN `#__js_job_countries` AS workpermit ON workpermit.id = job.workpermit
                LEFT JOIN `#__js_job_careerlevels` AS careerlevel ON job.careerlevel = careerlevel.id
                WHERE DATE(job.created) >= '".$fromdate."' AND DATE(job.created) <= '".$todate."' ";


        $query.=$inquery;
        $query.= " ORDER BY job.created DESC ";

        $db->setQuery($query);
        $results = $db->loadObjectList();
        $currency_align = $this->getJSModel('configuration')->getConfigValue('currency_align');    
        foreach($results AS $d){
            $d->location = $this->getJSModel('city')->getLocationDataForView($this->getJobCities($d->jobid));
            $d->salary = $this->getJSModel('common')->getSalaryRangeView($d->symbol,$d->salaryfrom,$d->salaryto,$d->salarytype , $currency_align);
        }

        // field labels
        $fieldsordering = JSModel::getJSModel('fieldordering')->getFieldsOrderingforForm(2);
        $_fields = array();
        
        $labels = '';
        $field_data = '';

        $first_itratin = 0;
        $date_format = $this->getJSModel('configuration')->getConfigValue('date_format');
        foreach ($results as $job) {
            foreach($fieldsordering AS $field){
                switch ($field->field) {
                    case 'jobtitle':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->title.'"'.$tb;
                    break;
                    
                    case 'company':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->companyname.'"'.$tb;
                    break;
                    
                    case 'department':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->departmentname.'"'.$tb;
                    break;
                    
                    case 'jobcategory':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->cat_title.'"'.$tb;
                    break;
                    
                    case 'subcategory':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->subcategory.'"'.$tb;
                    break;
                    
                    case 'jobtype':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->jobtypetitle.'"'.$tb;
                    break;
                    
                    case 'jobstatus':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->jobstatustitle.'"'.$tb;
                    break;
                    
                    case 'gender':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $gender_text = JText::_('Does not matter');

                        if($job->gender == 1){
                            $gender_text = JText::_('Male');
                        }elseif($job->gender == 2){
                            $gender_text = JText::_('Female');
                        }

                        $field_data .= '"'.$gender_text.'"'.$tb;
                    break;
                    
                    case 'age':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->agefromtitle. '-'.$job->agetotitle .'"'.$tb;
                    break;
                    
                    case 'jobsalaryrange':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->salary.'"'.$tb;
                    break;
                    
                    case 'jobshift':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->shifttitle.'"'.$tb;
                    break;
                    
                    case 'heighesteducation':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        if ($job->iseducationminimax == 1) {
                            if ($job->educationminimax == 1)
                                $educationtitle = JText::_('Minimum');
                            else
                                $educationtitle = JText::_('Maximum ');
                            $educationtitle .= ' '. JText::_($job->educationtitle);
                        }else {
                            
                            $educationtitle = JText::_($job->mineducationtitle) . ' - ' . JText::_($job->maxeducationtitle);
                        }
                        $field_data .= '"'.$educationtitle.'"'.$tb;
                        if($first_itratin == 0){
                            $labels .= JText::_('Degree Title').$tb;
                        }
                        $field_data .= '"'.$job->degreetitle.'"'.$tb;

                    break;
                    
                    case 'experience':
                        if ($job->isexperienceminimax == 1) {
                            if ($job->experienceminimax == 1)
                                $experiencetitle = JText::_('Minimum');
                            else
                                $experiencetitle = JText::_('Maximum');
                            $experiencetitle .= ' '.$job->experiencetitle;
                        }else {
                            
                            $experiencetitle = $job->minexperiencetitle . ' - ' . $job->maxexperiencetitle;
                        }
                        if ($job->experiencetext)
                            $experiencetitle .= ' (' . $job->experiencetext . ')';
                        
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$experiencetitle.'"'.$tb;
                    break;
                    
                    case 'noofjobs':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->noofjobs.'"'.$tb;
                    break;
                    
                    case 'duration':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->duration.'"'.$tb;
                    break;
                    
                    case 'careerlevel':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->careerleveltitle.'"'.$tb;
                    break;
                    
                    case 'workpermit':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->workpermitcountry.'"'.$tb;
                    break;
                    
                    case 'requiredtravel':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        switch ($job->requiredtravel) {
                            case 1: $requiredtraveltitle = JText::_('Not Required');
                                break;
                            case 2: $requiredtraveltitle = "25%";
                                break;
                            case 3: $requiredtraveltitle = "50%";
                                break;
                            case 4: $requiredtraveltitle = "75%";
                                break;
                            case 5: $requiredtraveltitle = "100%";
                                break;
                            default: $requiredtraveltitle = '';
                                break;
                        }
                        $field_data .= '"'.$requiredtraveltitle.'"'.$tb;
                    break;
                    
                    case 'video':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->video.'"'.$tb;
                    break;
                    
                    case 'startpublishing':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        
                        $start_publishing  = JHtml::_('date', $job->startpublishing, $date_format);
                        $field_data .= '"'.$start_publishing.'"'.$tb;
                    break;
                    
                    case 'stoppublishing':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $stop_publishing  = JHtml::_('date', $job->stoppublishing, $date_format);
                        $field_data .= '"'.$stop_publishing.'"'.$tb;
                    break;
                    
                    case 'city':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->location.'"'.$tb;
                    break;
                    
                    case 'zipcode':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->zipcode.'"'.$tb;
                    break;
                    
                    case 'description':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'. strip_tags($job->description) .'"'.$tb;
                    break;
                    
                    case 'qualifications':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'. strip_tags($job->qualifications) .'"'.$tb;
                    break;
                    
                    case 'prefferdskills':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'. strip_tags($job->prefferdskills) .'"'.$tb;
                    break;
                    
                    case 'agreement':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'. strip_tags($job->agreement) .'"'.$tb;
                    break;
                    
                    case 'metadescription':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->metadescription.'"'.$tb;
                    break;
                    
                    case 'metakeywords':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$job->metakeywords.'"'.$tb;
                    break;
                }
            }

            if($first_itratin == 0){
                $labels .= JText::_('Gold Job').$tb;
                $labels .= JText::_('Featured Job').$tb;
                $labels .= JText::_('status').$tb;
                $labels .= JText::_('Created').$tb;
            }
            
            $gold_job_text = JText::_('No');
            $featured_job_text = JText::_('No');
            
            if($job->isgoldjob == 1){
                $gold_job_text = JText::_('Yes');
            }

            if($job->isfeaturedjob == 1){
                $featured_job_text = JText::_('Yes');
            }
            $field_data .= '"'.$gold_job_text.'"'.$tb;
            $field_data .= '"'.$featured_job_text.'"'.$tb;
            
            if($job->status == 1){
                $status_text = JText::_('Approved');
            }elseif($job->status == 0){
                $status_text = JText::_('Pending');
            }else{
                $status_text = JText::_('Rejected');
            }

            $field_data .= '"'.$status_text.'"'.$tb;
            $created  = JHtml::_('date', $job->created, $date_format);
            $field_data .= '"'.$created.'"'.$tb;

            $field_data .= $nl;// start second record;
            $first_itratin = 1;// to not append labels again and again
        }

// file code
        
        $data = $nl;
        $data .= JText::_('Export Data of jobs').' '.JText::_('From').' '.$fromdate. ' '.JText::_('To').' ' .$todate;
        $data .= $nl.$nl;

        $data .= JText::_('Export criteria');
        $data .= $nl;
        $data .= $criteria_labels;
        $data .= $nl;
        $data .= $criteria_values;
        $data .= $nl;
        $data .= $nl;
        

        if(!empty($results)){
            // labels
            $data .= $labels;
            $data .= $nl;
            // values
            $data .= $field_data;
        }else{
            $data .= JText::_('No Jobs Full fill the provided criteria');
        }
        $data .= $nl.$nl.$nl;

        // export to file code
        $name = 'Export-Job-data';
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $name . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Lacation: excel.htm?id=yes");
        print $data;
        exit();
    }

    function exportCompaniesData(){
        $data = JRequest::get('post');
        $db = JFactory::getDbo();

        // vars for excel string
        $tb = "\t";
        $nl = "\n";

        $inquery = "";

        $criteria_labels = '';
        $criteria_values = '';

        if(isset($data['companyname']) && $data['companyname'] !=''){
            $inquery .= " AND LOWER(company.name) LIKE ".$db->Quote('%'.$data['companyname'].'%');
            $criteria_labels .= JText::_('Company Name').$tb;
            $option_text  = $data['companyname'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }

        if(isset($data['category']) && $data['category'] !='' && is_numeric($data['category'])){
            $inquery .= " AND company.category = ".$data['category'];
            $criteria_labels .= JText::_('Category').$tb;
            $option_text  = $data['category_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }

        if(isset($data['city']) && $data['city'] !=''){
            $city_query = '';
            $array = explode(',', $data['city']);

            if(!empty($array)){
                $city_query .= ' AND ( ';
            }
            $counter = 0;
            $q_prefix = '';
            foreach ($array as $item) {
                if($counter != 0){
                    $q_prefix = ' OR ';
                }
                $counter = 1;
                if(is_numeric($item)){
                    $city_query .= $q_prefix." company.city LIKE ".$db->Quote('%'.$item.'%');
                }
            }
            if(!empty($array)){
                $city_query .= ' ) ';
            }

            $criteria_labels .= JText::_('Location').$tb;
            $option_text  = $data['citynames'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }

        if(isset($data['status']) && $data['status'] !='' && is_numeric($data['status'])){
            $inquery .= " AND company.status  = ".$data['status'];
            $criteria_labels .= JText::_('Status').$tb;
            $option_text  = $data['status_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }

        if(isset($data['isgfcombo']) && $data['isgfcombo'] !='' && is_numeric($data['isgfcombo'])){
            switch ($data['isgfcombo']) {
                case '1':
                    $inquery .= " AND company.isgoldcompany = 1 ";
                break;
                case '2':
                    $inquery .= " AND company.isfeaturedcompany = 1 ";
                break;
                case '3':
                    $inquery .= " AND company.isgoldcompany = 1 AND company.isfeaturedcompany = 1 ";
                break;
            }
            $criteria_labels .= JText::_('Gold Featured').$tb;
            $option_text  = $data['isgfcombo_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }

    // dates
        $fromdate = '';
        if(isset($data['fromdate'])){
            $fromdate = $data['fromdate'];
        }

        if($fromdate == '' || $fromdate == '0000-00-00 00:00:00' || $fromdate == '0000-00-00'){
            $fromdate = JHtml::_('date', strtotime(date('Y-m-d')." -30 days"), 'Y-m-d');
        }
        
        $todate = '';
        if(isset($data['todate'])){
            $todate = $data['todate'];
        }

        // dates
        if($todate == '' || $todate == '0000-00-00 00:00:00' || $todate == '0000-00-00'){
            $todate = JHtml::_('date', strtotime(date('Y-m-d')), 'Y-m-d');
        }

        if($fromdate > $todate){
            $temp_date = $todate;
            $todate = $fromdate;
            $fromdate = $temp_date;
        }

        //Data
        $query = "SELECT company.params, company.id,company.isgoldcompany,company.isfeaturedcompany,company.name,company.city,company.url,company.contactemail,company.contactname,company.contactphone,company.companyfax
                        ,company.uid,company.description,company.since,company.address1,company.address2,company.companyfax,company.companysize
                        ,cat.cat_title ,company.logofilename AS companylogo,company.income
                        ,company.endgolddate,company.endfeatureddate, company.zipcode,company.created,company.status
                        FROM `#__js_job_companies` AS company
                        LEFT JOIN `#__js_job_categories` AS cat ON company.category = cat.id
                        WHERE DATE(company.created) >= '".$fromdate."' AND DATE(company.created) <= '".$todate."'  OR 1 = 1 ";
        $query.=$inquery;
        //echo $query;exit;
        $query.= " ORDER BY company.created DESC ";

        $db->setQuery($query);
        $results = $db->loadObjectList();

        foreach ($results as $result) {
            $result->multicity = $this->getJSModel('city')->getLocationDataForView($result->city);
        }


        // field labels
        $fieldsordering = JSModel::getJSModel('fieldordering')->getFieldsOrderingforForm(1);
        
        $labels = '';
        $field_data = '';

        $first_itratin = 0;
        $date_format = $this->getJSModel('configuration')->getConfigValue('date_format');
        foreach ($results as $company) {
            foreach($fieldsordering AS $field){
                switch ($field->field) {
                    
                    case 'name':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->name.'"'.$tb;
                    break;
                    
                    case 'contactname':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->contactname.'"'.$tb;
                    break;
                    
                    case 'contactphone':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->contactphone.'"'.$tb;
                    break;
                    
                    case 'contactemail':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->contactemail.'"'.$tb;
                    break;
                    
                    case 'jobcategory':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->cat_title.'"'.$tb;
                    break;
                    
                    case 'url':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->url.'"'.$tb;
                    break;
                    
                    case 'contactfax':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->companyfax.'"'.$tb;
                    break;
                    
                    case 'since':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $since  = JHtml::_('date', $company->since, $date_format);
                        $field_data .= '"'.$since.'"'.$tb;
                    break;
                    
                    case 'description':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'. strip_tags($company->description) .'"'.$tb;
                    break;
                    
                    case 'companysize':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->companysize.'"'.$tb;
                    break;
                    
                    case 'city':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->multicity.'"'.$tb;
                    break;
                    
                    case 'zipcode':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->zipcode.'"'.$tb;
                    break;
                    
                    case 'address1':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->address1.'"'.$tb;
                    break;
                    
                    case 'address2':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->address2.'"'.$tb;
                    break;
             
                }
            }

            if($first_itratin == 0){
                $labels .= JText::_('Gold Company').$tb;
                $labels .= JText::_('Featured Company').$tb;
                $labels .= JText::_('status').$tb;
                $labels .= JText::_('Created').$tb;
            }
            
            $gold_company_text = JText::_('No');
            $featured_company_text = JText::_('No');
            
            if($company->isgoldcompany == 1){
                $gold_company_text = JText::_('Yes');
            }

            if($company->isfeaturedcompany == 1){
                $featured_company_text = JText::_('Yes');
            }
            $field_data .= '"'.$gold_company_text.'"'.$tb;
            $field_data .= '"'.$featured_company_text.'"'.$tb;
            
            if($company->status == 1){
                $status_text = JText::_('Approved');
            }elseif($company->status == 0){
                $status_text = JText::_('Pending');
            }else{
                $status_text = JText::_('Rejected');
            }
            $field_data .= '"'.$status_text.'"'.$tb;
            $created  = JHtml::_('date', $company->created, $date_format);
            $field_data .= '"'.$created.'"'.$tb;

            $field_data .= $nl;// start second record;
            $first_itratin = 1;// to not append labels again and again
        }

// file code
        
        
        $data = $nl;
        $data .= JText::_('Export Data of Companies').' '.JText::_('From').' '.$fromdate. ' '.JText::_('To').' ' .$todate;
        $data .= $nl.$nl;

        $data .= JText::_('Export criteria');
        $data .= $nl;
        $data .= $criteria_labels;
        $data .= $nl;
        $data .= $criteria_values;
        $data .= $nl;
        $data .= $nl;
        
        if(!empty($results)){
            // labels
            $data .= $labels;
            $data .= $nl;
            // values
            $data .= $field_data;
        }else{
            $data .= JText::_('No Companies Full fill the provided criteria');
        }

        $data .= $nl.$nl.$nl;

        // export to file code
        $name = 'Export-Companies-data';
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $name . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Lacation: excel.htm?id=yes");
        print $data;
        exit();
    }

    
    function exportResumesData(){
        $data = JRequest::get('post');
        $db = JFactory::getDbo();

        // vars for excel string
        $tb = "\t";
        $nl = "\n";

        $inquery = "";

        $criteria_labels = '';
        $criteria_values = '';

        if(isset($data['status']) && $data['status'] !='' && is_numeric($data['status'])){
            $inquery .= " AND company.status  = ".$data['status'];
            $criteria_labels .= JText::_('Status').$tb;
            $option_text  = $data['status_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }

        if(isset($data['city']) && $data['city'] !=''){
            $city_query = '';
            $array = explode(',', $data['city']);

            if(!empty($array)){
                $city_query .= ' AND ( ';
            }
            $counter = 0;
            foreach ($array as $item) {
                if($counter != 0){
                    $q_prefix = ' OR ';
                }
                $counter = 1;
                if(is_numeric($item)){
                    $city_query .= $q_prefix." company.city LIKE ".$db->Quote('%'.$item.'%');
                }
            }
            if(!empty($array)){
                $city_query .= ' ) ';
            }

            $criteria_labels .= JText::_('Location').$tb;
            $option_text  = $data['citynames'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }


        if(isset($data['isgfcombo']) && $data['isgfcombo'] !='' && is_numeric($data['isgfcombo'])){
            switch ($data['isgfcombo']) {
                case '1':
                    $inquery .= " AND company.isgoldcompany = 1 ";
                break;
                case '2':
                    $inquery .= " AND company.isfeaturedcompany = 1 ";
                break;
                case '3':
                    $inquery .= " AND company.isgoldcompany = 1 AND company.isfeaturedcompany = 1 ";
                break;
            }
            $criteria_labels .= JText::_('Gold Featured').$tb;
            $option_text  = $data['isgfcombo_text'];
            $criteria_values .= '"'.$option_text.'"'.$tb;
        }


    // dates
        $fromdate = '';
        if(isset($data['fromdate'])){
            $fromdate = $data['fromdate'];
        }

        if($fromdate == '' || $fromdate == '0000-00-00 00:00:00' || $fromdate == '0000-00-00'){
            $fromdate = JHtml::_('date', strtotime(date('Y-m-d')." -30 days"), 'Y-m-d');
        }
        
        $todate = '';
        if(isset($data['todate'])){
            $todate = $data['todate'];
        }

        // dates
        if($todate == '' || $todate == '0000-00-00 00:00:00' || $todate == '0000-00-00'){
            $todate = JHtml::_('date', strtotime(date('Y-m-d')), 'Y-m-d');
        }

        if($fromdate > $todate){
            $temp_date = $todate;
            $todate = $fromdate;
            $fromdate = $temp_date;
        }

        //Data
        $query = "SELECT company.params, company.id,company.isgoldcompany,company.isfeaturedcompany,company.name,company.city,company.url,company.contactemail,company.contactname,company.contactphone,company.companyfax
                        ,company.uid,company.description,company.since,company.address1,company.address2,company.companyfax,company.companysize
                        ,cat.cat_title ,company.logofilename AS companylogo,company.income
                        ,company.endgolddate,company.endfeatureddate, company.zipcode,company.created,company.status
                        FROM `#__js_job_companies` AS company
                        LEFT JOIN `#__js_job_categories` AS cat ON company.category = cat.id
                        WHERE DATE(company.created) >= '".$fromdate."' AND DATE(company.created) <= '".$todate."'  OR 1 = 1 ";
        $query.=$inquery;
        //echo $query;exit;
        $query.= " ORDER BY company.created DESC ";

        $db->setQuery($query);
        $results = $db->loadObjectList();

        foreach ($results as $result) {
            $result->multicity = $this->getJSModel('city')->getLocationDataForView($result->city);
        }


        // field labels
        $fieldsordering = JSModel::getJSModel('fieldordering')->getFieldsOrderingforForm(1);
        
        $labels = '';
        $field_data = '';

        $first_itratin = 0;
        $date_format = $this->getJSModel('configuration')->getConfigValue('date_format');
        foreach ($results as $company) {
            foreach($fieldsordering AS $field){
                switch ($field->field) {
                    
                    case 'name':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->name.'"'.$tb;
                    break;
                    
                    case 'contactname':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->contactname.'"'.$tb;
                    break;
                    
                    case 'contactphone':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->contactphone.'"'.$tb;
                    break;
                    
                    case 'contactemail':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->contactemail.'"'.$tb;
                    break;
                    
                    case 'jobcategory':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->cat_title.'"'.$tb;
                    break;
                    
                    case 'url':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->url.'"'.$tb;
                    break;
                    
                    case 'contactfax':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->companyfax.'"'.$tb;
                    break;
                    
                    case 'since':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $since  = JHtml::_('date', $company->since, $date_format);
                        $field_data .= '"'.$since.'"'.$tb;
                    break;
                    
                    case 'description':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'. strip_tags($company->description) .'"'.$tb;
                    break;
                    
                    case 'companysize':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->companysize.'"'.$tb;
                    break;
                    
                    case 'city':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->multicity.'"'.$tb;
                    break;
                    
                    case 'zipcode':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->zipcode.'"'.$tb;
                    break;
                    
                    case 'address1':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->address1.'"'.$tb;
                    break;
                    
                    case 'address2':
                        if($first_itratin == 0){
                            $labels .= JText::_($field->fieldtitle).$tb;
                        }
                        $field_data .= '"'.$company->address2.'"'.$tb;
                    break;
             
                }
            }

            if($first_itratin == 0){
                $labels .= JText::_('Gold Company').$tb;
                $labels .= JText::_('Featured Company').$tb;
                $labels .= JText::_('status').$tb;
                $labels .= JText::_('Created').$tb;
            }
            
            $gold_company_text = JText::_('No');
            $featured_company_text = JText::_('No');
            
            if($company->isgoldcompany == 1){
                $gold_company_text = JText::_('Yes');
            }

            if($company->isfeaturedcompany == 1){
                $featured_company_text = JText::_('Yes');
            }
            $field_data .= '"'.$gold_company_text.'"'.$tb;
            $field_data .= '"'.$featured_company_text.'"'.$tb;
            
            if($company->status == 1){
                $status_text = JText::_('Approved');
            }elseif($company->status == 0){
                $status_text = JText::_('Pending');
            }else{
                $status_text = JText::_('Rejected');
            }

            $field_data .= '"'.$status_text.'"'.$tb;
            $created  = JHtml::_('date', $company->created, $date_format);
            $field_data .= '"'.$created.'"'.$tb;

            $field_data .= $nl;// start second record;
            $first_itratin = 1;// to not append labels again and again
        }

// file code
        if(empty($results))
            return '';
        
        $data = $nl;
        $data .= JText::_('Export Data of Companies').' '.JText::_('From').' '.$fromdate. ' '.JText::_('To').' ' .$todate;
        $data .= $nl.$nl;

        $data .= JText::_('Export criteria');
        $data .= $nl;
        $data .= $criteria_labels;
        $data .= $nl;
        $data .= $criteria_values;
        $data .= $nl;
        $data .= $nl;
        

        // labels
        $data .= $labels;
        $data .= $nl;
        // values
        $data .= $field_data;
        $data .= $nl.$nl.$nl;

        // export to file code
        $name = 'Export-Companies-data';
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $name . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Lacation: excel.htm?id=yes");
        print $data;
        exit();
    }



    private function getJobCities($jobid){
        if(!is_numeric($jobid)) return false;
        $db = $this->getDBO();
        $query = "SELECT cityid FROM `#__js_job_jobcities` WHERE jobid = $jobid";
        $db->setQuery($query);
        $cities = $db->loadObjectList();
        $str = '';
        foreach ($cities as $key) {
            if($str) $str .= ",";
            $str .= $key->cityid;
        }
        return $str;
    }

}
?>