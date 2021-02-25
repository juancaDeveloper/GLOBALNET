
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
jimport('joomla.html.parameter');

class JSJobsModelListJobs extends JSModel {

    function __construct() {
        parent::__construct();
    }

    function listJobs($layoutName, $jobs, $thisarray, $isnew, $itemid, $fieldsordering, $goldjobs, $featuredjobs, $showgoogleadds) {
        $config = JSModel::getJSModel('configurations')->getConfigByFor('default');
        $afterjobs = $config['googleadsenseshowafter'];
        $googleclient = $config['googleadsenseclient'];
        $googleslot = $config['googleadsenseslot'];
        $googleaddwidth = $config['googleadsensewidth'];
        $googleaddhieght = $config['googleadsenseheight'];
        $googleaddcss = $config['googleadsensecustomcss'];
        $contents = '';
        //for Gold Job
        if (isset($goldjobs) && !empty($goldjobs)) {
            foreach ($goldjobs as $job) {
                $comma = "";
                $contents .= $this->print_job($fieldsordering, $job, $thisarray, $isnew, $itemid, 2, $layoutName);
            }
        }

        //for Featured Job
        if (isset($featuredjobs) && !empty($featuredjobs)) {
            foreach ($featuredjobs as $job) {
                $comma = "";
                $contents .= $this->print_job($fieldsordering, $job, $thisarray, $isnew, $itemid, 3, $layoutName);
            }
        }
        if (isset($jobs)) {
            $noofjobs = 1;
            foreach ($jobs as $job) {
                $comma = "";
                $contents .= $this->print_job($fieldsordering, $job, $thisarray, $isnew, $itemid, 1, $layoutName);
                if ($showgoogleadds == 1) {
                    if ($noofjobs % $afterjobs == 0) {
                        $contents .= '<table cellpadding="0" cellspacing="0" border="0" width="100%" style="' . $googleaddcss . '">
                                        <tr>
                                            <td>
                                                <script type="text/javascript">
                                                    google_ad_client = "' . $googleclient . '";
                                                    google_ad_slot = "' . $googleslot . '";
                                                    google_ad_width = "' . $googleaddwidth . '";
                                                    google_ad_height = "' . $googleaddhieght . '";
                                                </script>
                                                <script type="text/javascript"src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
                                            </td>
                                        </tr>
                                    </table>';
                    } $noofjobs++;
                }
            }
        }
        if ($layoutName == 'company_jobs') {
            if (isset($this->jobs)) {
                foreach ($this->jobs as $job) {
                    $comma = '';
                    $contents .= print_job($fieldsordering, $job, $thisarray, $isnew, $itemid, 1, $layoutName);
                }
            }
        }
        return $contents;
    }

    function print_job($fieldsordering, $job, $thisjob, $isnew, $itemid, $jobtype = 1, $layoutName = 'list_jobs') {
        $user = JFactory::getUser();        
        $listjobconfig = JSModel::getJSModel('configurations')->getConfigByFor('listjob');
        $islistjobforvisitor = JSModel::getJSModel('common')->islistjobforvisitor();
        if ($islistjobforvisitor == 1) { //package expire or user not login
            $listjobconfig['lj_title'] = $listjobconfig['visitor_lj_title'];
            $listjobconfig['lj_category'] = $listjobconfig['visitor_lj_category'];
            $listjobconfig['lj_jobtype'] = $listjobconfig['visitor_lj_jobtype'];
            $listjobconfig['lj_jobstatus'] = $listjobconfig['visitor_lj_jobstatus'];
            $listjobconfig['lj_company'] = $listjobconfig['visitor_lj_company'];
            $listjobconfig['lj_companysite'] = $listjobconfig['visitor_lj_companysite'];
            $listjobconfig['lj_country'] = $listjobconfig['visitor_lj_country'];
            $listjobconfig['lj_state'] = $listjobconfig['visitor_lj_state'];
            $listjobconfig['lj_city'] = $listjobconfig['visitor_lj_city'];
            $listjobconfig['lj_salary'] = $listjobconfig['visitor_lj_salary'];
            $listjobconfig['lj_created'] = $listjobconfig['visitor_lj_created'];
            $listjobconfig['lj_noofjobs'] = $listjobconfig['visitor_lj_noofjobs'];
            $listjobconfig['lj_description'] = $listjobconfig['visitor_lj_description'];
            
        }

        $nav1 = 0;
        $nav2 = 0;
        $companylogoCode = null;
        if ($layoutName == 'list_jobs') {
            $nav1 = 13;
            $nav2 = 32;
            $companylogoCode = 0;
        } elseif ($layoutName == 'listnewstjobs') {
            $nav1 = 15;
            $nav2 = 35;
            $companylogoCode = 1;
        } elseif ($layoutName == 'list_subcategoryjobs') {
            $nav1 = 15;
            $nav2 = 35;
            $companylogoCode = 0;
        } elseif ($layoutName == 'company_jobs') {
            $nav1 = 15;
            $nav2 = 35;
            $companylogoCode = 2;
        } elseif ($layoutName == 'job_searchresults') {
            $nav1 = 17;
            $nav2 = 33;
            $type = '';
            $companylogoCode = 2;
        }

        $contents = '
                    <div class="js_job_main_wrapper">
                        <div class="js_job_data_1">';
        if (isset($fieldsordering['jobtitle']) && $fieldsordering['jobtitle'] == 1 && $listjobconfig['lj_title'] == 1) {
            $jobaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->jobaliasid);
            $link = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=' . $nav1 . '&bd=' . $jobaliasid . '&Itemid=' . $thisjob->Itemid ,false);
            $contents .= '
                            <span class="js_job_title">
                                <a class="js_job_title" href="' . $link . '">' . $job->title . '</a>
                            </span>';
        }
        $contents .= '      <span class="js_job_posted">';
        if($listjobconfig['lj_created'] == 1){
            if ($job->jobdays == 0)
                $contents .= JText::_('Posted') . ': ' . JText::_('Today');
            else
                $contents .= JText::_('Posted') . ': ' . $job->jobdays . ' ' . JText::_('Days Ago');
        }
        $contents .= '      </span>
                        </div>
                        <div class="js_job_image_area">
                            <div class="js_job_image_wrapper">';
        if ($companylogoCode == 0) {
            if (!empty($job->companylogo)) {
                if ($thisjob->isjobsharing) {
                    $imgsrc = $job->companylogo;
                } else {
                    $imgsrc = $thisjob->config['data_directory'] . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->companylogo;
                }
            } else {
                $imgsrc = 'components/com_jsjobs/images/blank_logo.png';
            }
        } elseif ($companylogoCode == 1) {
            if (!empty($job->companylogo)) {
                if (isset($job->localcompanyid))
                    $imgsrc = $thisjob->config['data_directory'] . '/data/employer/comp_' . $job->localcompanyid . '/logo/' . $job->companylogo;
                if ($jobtype == 1) {
                    if ($thisjob->isjobsharing) {
                        $imgsrc = $job->companylogo;
                    } else {
                        $imgsrc = $thisjob->config['data_directory'] . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->companylogo;
                    }
                }
            } else {
                $imgsrc = 'components/com_jsjobs/images/blank_logo.png';
            }
        } elseif ($companylogoCode == 2) {
            if (!empty($job->companylogo)) {
                $imgsrc = $thisjob->config['data_directory'] . '/data/employer/comp_' . $job->companyid . '/logo/' . $job->companylogo;
            } else {
                $imgsrc = 'components/com_jsjobs/images/blank_logo.png';
            }
        }
        $contents .= '
                                <img class="js_job_image" src="' . $imgsrc . '" />
                            </div>
                            <div class="js_job_quick_view_wrapper">
                                <a class="js_job_quick_view_link" data-jobid="' . $job->id . '" href="#" >' . JText::_('Quick View') . '</a>
                            </div>
                        </div>
                        <div class="js_job_data_area">
                            <div class="js_job_data_2">';
        if (isset($fieldsordering['company']) && $fieldsordering['company'] == 1 && $listjobconfig['lj_company'] == 1) {
            $contents .= '
                                        <div class="js_job_data_2_wrapper">';
            if ($thisjob->config['labelinlisting'] == '1') {
                $contents .= '
                                                <span class="js_job_data_2_title">' . JText::_('Company') . ':</span>';
            }
            $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
            $link = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=' . $nav2 . '&cd=' . $companyaliasid . '&Itemid=' . $thisjob->Itemid ,false);
            $contents .= '
                                            <span class="js_job_data_2_value"><a class="js_job_data_2_company_link" href="' . $link . '">' . $job->companyname . '</a></span>
                                        </div>';
        }
        if (isset($fieldsordering['jobcategory']) && $fieldsordering['jobcategory'] == 1 && $listjobconfig['lj_category'] == 1) {
            $contents .= '
                                        <div class="js_job_data_2_wrapper">';
            if ($thisjob->config['labelinlisting'] == '1') {
                $contents .= '
                                                    <span class="js_job_data_2_title">' . JText::_('Category') . ':</span>';
            }
            $contents .= '
                                            <span class="js_job_data_2_value">' . $job->cat_title . '</span>
                                        </div>';
        }
        if (isset($fieldsordering['jobsalaryrange']) && $fieldsordering['jobsalaryrange'] == 1 && $listjobconfig['lj_salary'] == 1) {
            if ($job->salaryfrom) {
                $salary = JSModel::getJSModel('common')->getSalaryRangeView($job->symbol,$job->salaryfrom,$job->salaryto,$job->salaytype,$thisjob->config['currency_align']);
                $contents .= '
                                        <div class="js_job_data_2_wrapper">';
                if ($thisjob->config['labelinlisting'] == '1') {
                    $contents .= '
                                                    <span class="js_job_data_2_title">' . JText::_('Salary') . ':</span>';
                }
                $contents .= '
                                            <span class="js_job_data_2_value">' . $salary . '</span>
                                        </div>';
            }
        }
        if (isset($fieldsordering['jobtype']) && $fieldsordering['jobtype'] == 1 && $listjobconfig['lj_jobtype'] == 1) {
            $contents .= '
                                        <div class="js_job_data_2_wrapper">';
            if ($thisjob->config['labelinlisting'] == '1') {
                $contents .= '
                                                    <span class="js_job_data_2_title">' . JText::_('Job Type') . ':</span>';
            }
            if ($layoutName == 'job_searchresults') {
                $contents .= '
                                                    <span class="js_job_data_2_value">' . $job->jobtypetitle;
                if (isset($fieldsordering['jobstatus']) && $fieldsordering['jobstatus'] == '1')
                    $contents .= ' - ' . $job->jobstatustitle . '</span>';
            }else {
                $contents .= '
                                                    <span class="js_job_data_2_value">' . $job->jobtype;
                if (isset($fieldsordering['jobstatus']) && $fieldsordering['jobstatus'] == '1')
                    $contents .= ' - ' . $job->jobstatus . '</span>';
            }
            $contents .= '
                                        </div>';
        }
        $contents .= '
                        </div>
                        <div class="js_job_data_3">';
        if ($thisjob->config['labelinlisting'] == '1') {
                            $contents .= '<span class="js_job_data_location_title">' . JText::_('Location') . ':&nbsp;</span>';
        }
        if (isset($fieldsordering['city']) && $fieldsordering['city'] == 1 && $listjobconfig['lj_city'] == 1) {
            if (isset($job->city) AND ! empty($job->city)) {
                $contents .= '
                                            <span class="js_job_data_location_value">';
                if (strlen($job->city) > 35) {
                    if(isset($job->multicity))
                    $contents .= JText::_('Multi City') . $job->multicity;
                } else {
                    $contents .= $job->city;
                }
                $contents .= '
                                            </span>';
            }
        }
        $contents .= '
                                <div class="js_job_data_4">';
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_apply&nav=25&bd=' . $job->jobaliasid . '&Itemid=' . $thisjob->Itemid;
        $contents .= '
                                    <a href="Javascript: void(0);" class="js_job_data_button" data-jobapply="jobapply" data-jobid="' . $job->jobaliasid . '" >' . JText::_('Apply Now') . '</a>
                                    <a href="Javascript: void(0);" class="js_job_data_button" onclick="showtellafriend(\'' . $job->id . '\',\'' . $job->title . '\');" >' . JText::_('Tell A Friend') . '</a>';
        $user = JFactory::getUser();
        $listjobshortlist = ($user->guest) ? 'vis_jslistjobshortlist' : 'listjobshortlist';
        $allow = JSModel::getJSModel('configurations')->getConfigValue($listjobshortlist);
        if ($allow == 1) {
            $contents .= '<a href="Javascript: void(0);" class="js_job_data_button js_job_shortlist_btn" onclick="showShortlist(\'job_shortlist_' . $job->id . '\', ' . $job->id . ');" >' . JText::_('Add To Short List') . '</a>';
        }
        $contents .= '
                                </div>
                            </div>
                        </div>';
        switch ($jobtype) {
            case 1: // Normal Job
                break;
            case 2: // Gold Job
                $contents .= '<div class="js_job_gold"><canvas class="goldjob" width="20" height="20"></canvas>' . JText::_('Gold') . '</div>';
                break;
            case 3: // Featured Job
                $contents .= '<div class="js_job_featured"><canvas class="featuredjob" width="20" height="20"></canvas>' . JText::_('Featured') . '</div>';
                break;
        }
        if ($job->created > $isnew) {
            $contents .= '<div class="js_job_new"><canvas class="newjob" width="20" height="20"></canvas>' . JText::_('New')."!" . '</div>';
        }

        if (isset($fieldsordering['noofjobs']) && $fieldsordering['noofjobs'] == 1 && $listjobconfig['lj_noofjobs'] == 1) {
            if ($job->noofjobs != 0) {
                $contents .= '<div class="js_job_number"><canvas class="newjob" width="20" height="20"></canvas>' . $job->noofjobs . ' ' . JText::_('Jobs') . '</div>';
            }
        }
        $contents .= '
                    </div>    
                    ';
        return $contents;
    }

    function listModuleJobs($layoutName, $jobs, $location, $showtitle, $title, $listtype, $noofjobs, $category, $subcategory, $company, $jobtype, $posteddate, $theme, $separator, $moduleheight, $jobsinrow, $jobsinrowtab, $jobmargintop, $jobmarginleft, $companylogo, $logodatarow, $sliding, $datacolumn, $speedTest, $slidingdirection, $dateformat, $data_directory, $consecutivesliding, $moduleclass_sfx, $itemid, $jobheight, $companylogowidth,$companylogoheight) {
        $speed = 50;
        if($speedTest < 5){
            for($i = 5; $i > $speedTest; $i--)
                $speed += 10;
            if($speed > 100) $speed = 100;
        }elseif($speedTest > 5){
            for($i = 5; $i < $speedTest; $i++)
                $speed -= 10;
            if($speed < 10) $speed = 10;
        }

        $moduleName = $layoutName;

        $contentswrapperstart = '';
        $contents = '';
        if ($jobs) {
            if ($listtype == 0) { //list style
                $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . ';" >';
                if ($showtitle == 1) {
                    if (!empty($moduleclass_sfx) || $moduleclass_sfx != '') {
                        $contentswrapperstart .= '
                                        <div class="' . $moduleclass_sfx . '"><h3>
                                            <span>
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    } else {
                        $contentswrapperstart .= '
                                        <div id="tp_heading">
                                            <span id="tp_headingtext">
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    }
                }
                $contentswrapperstart .= '<div id="jsjobs_modulelist_titlebar" class="' . $moduleName . '" ><span id="whiteback"></span>';
                //For desktop
                $desktop_w = 1;
                if(($company == 1 || $company == 2 || $company == 4 || $company == 6) || ($companylogo == 1 || $companylogo == 2 || $companylogo == 4 || $companylogo == 6)){
                    $desktop_w++;
                }
                if($category == 1 || $category == 2 || $category == 3 || $category == 5){
                    $desktop_w++;
                }
                if($subcategory == 1 || $subcategory == 2 || $subcategory == 3 || $subcategory == 5){
                    $desktop_w++;
                }
                if($jobtype == 1 || $jobtype == 2 || $jobtype == 3 || $jobtype == 5){
                    $desktop_w++;
                }
                if($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5){
                    $desktop_w++;
                }
                if($location == 1 || $location == 2 || $location == 3 || $location == 5){
                    $desktop_w++;
                }
                //For tablet
                $tablet_w = 1;
                if(($company == 1 || $company == 2 || $company == 4 || $company == 6) || ($companylogo == 1 || $companylogo == 2 || $companylogo == 4 || $companylogo == 6)){
                    $tablet_w++;
                }
                if($category == 1 || $category == 2 || $category == 4 || $category == 6){
                    $tablet_w++;
                }
                if($subcategory == 1 || $subcategory == 2 || $subcategory == 4 || $subcategory == 6){
                    $tablet_w++;
                }
                if($jobtype == 1 || $jobtype == 2 || $jobtype == 4 || $jobtype == 6){
                    $tablet_w++;
                }
                if($posteddate == 1 || $posteddate == 2 || $posteddate == 4 || $posteddate == 6){
                    $tablet_w++;
                }
                if($location == 1 || $location == 2 || $location == 4 || $location == 6){
                    $tablet_w++;
                }
                //For mobile
                $mobile_w = 1;
                if(($company == 1 || $company == 2 || $company == 4 || $company == 6) || ($companylogo == 1 || $companylogo == 2 || $companylogo == 4 || $companylogo == 6)){
                    $mobile_w++;
                }
                if($category == 1 || $category == 3 || $category == 4 || $category == 7){
                    $mobile_w++;
                }
                if($subcategory == 1 || $subcategory == 3 || $subcategory == 4 || $subcategory == 7){
                    $mobile_w++;
                }
                if($jobtype == 1 || $jobtype == 3 || $jobtype == 4 || $jobtype == 7){
                    $mobile_w++;
                }
                if($posteddate == 1 || $posteddate == 3 || $posteddate == 4 || $posteddate == 7){
                    $mobile_w++;
                }
                if($location == 1 || $location == 3 || $location == 4 || $location == 7){
                    $mobile_w++;
                }

                if ($company != 0 || $companylogo != 0){
                    $class = $this->getClasses($companylogo);
                    $class .= $this->getClasses($company);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Company') . '</span>';
                }
                $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' visible-all">' . JText::_('Title') . '</span>';
                if ($category != 0){
                    $class = $this->getClasses($category);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Category') . '</span>';
                }
                if ($subcategory == 1){
                    $class = $this->getClasses($subcategory);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Sub Category') . '</span>';
                }
                if ($jobtype == 1){
                    $class = $this->getClasses($jobtype);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Type') . '</span>';
                }
                if ($location == 1){
                    $class = $this->getClasses($location);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Location') . '</span>';
                }
                if ($posteddate == 1){
                    $class = $this->getClasses($posteddate);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Posted') . '</span>';
                }
                $contentswrapperstart .= '</div>';
                foreach ($jobs as $job) {
                    $contents .= '<div id="jsjobs_modulelist_databar"><span id="whiteback"></span>';
                    if ($company != 0 || $companylogo != 0) {
                        $class = $this->getClasses($company);
                        $class .= $this->getClasses($companylogo);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">';
                        if ($companylogo != 0) {
                            $class = $this->getClasses($companylogo);
                            $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
                            $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);
                            $logo = JSModel::getJSModel('common')->getCompanyLogo( $job->companyid , $job->companylogo , null , 2 );
                            $contents .= '<a href=' . $c_l . '><img  src="' . $logo . '"  /></a>';
                        }
                        ///////////////////////
                        
                        ///////////////////////
                        if($company != 0){
                            $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
                            $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);
                            $contents .= '<span id="themeanchor"><a class="anchor" href=' . $c_l . '>' . $job->companyname . '</a></span>';

                        }
                        $contents .= '</span>';
                    }
                    $jobaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->aliasid);
                    $an_link = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd=' . $jobaliasid . '&Itemid=' . $itemid ,false);
                    $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' visible-all">
                                    <span id="themeanchor">
                                        <a class="anchor" href="'.$an_link.'">
                                            ' . $job->title . '
                                        </a>
                                    </span>
                                    </span>';
                    if ($category != 0) {
                        $class = $this->getClasses($category);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_($job->cat_title) . '</span>';
                    }
                    if ($subcategory != 0) {
                        $class = $this->getClasses($subcategory);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_($job->subcat_title) . '</span>';
                    }
                    if ($jobtype != 0) {
                        $class = $this->getClasses($jobtype);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_($job->jobtypetitle) . '</span>';
                    }
                    if ($location != 0) {
                        $class = $this->getClasses($location);
                        $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                        $joblocation = !empty($job->cityname) ? JText::_($job->cityname) : ' ';
                        switch ($addlocation) {
                            case 'csc':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                            case 'cs':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                            break;
                            case 'cc':
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                        }
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $joblocation . '</span>';
                    }
                    if ($posteddate != 0) {
                        $class = $this->getClasses($posteddate);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . date($dateformat, strtotime($job->created)) . '</span>';
                    }
                    $contents .= '</div>';
                }

                if ($sliding == 1) { // Sliding is enable
                    $consectivecontent = '';
                    for ($i = 0; $i < $consecutivesliding; $i++) {
                        $consectivecontent .= $contents;
                    }

                    if ($slidingdirection == 1) { // UP
                        $contents = '<marquee id="mod_hotjsjobs"  style="height:' . $moduleheight . ';" direction="up" scrolldelay="' . $speed . '" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $consectivecontent . '</marquee>';
                    }
                }
                $contentswrapperend = '</div>';
            } else { //box style
                $jobwidthclass = "modjob" . $jobsinrow;
                $jobtabwidthclass = "modjobtab" . $jobsinrowtab;
                $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . ';overflow:hidden;" >';
                if ($showtitle == 1) {
                    if (!empty($moduleclass_sfx) || $moduleclass_sfx != '') {
                        $contentswrapperstart .= '
                                        <div class="' . $moduleclass_sfx . '"><h3>
                                            <span>
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    } else {
                        $contentswrapperstart .= '
                                        <div id="tp_heading">
                                            <span id="tp_headingtext">
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    }
                }
                $inlineCSS = 'margin-top:'.$jobmargintop.';margin-left:'.$jobmarginleft.';';
                foreach ($jobs as $job) {
                    $contents .= '<div id="jsjobs_module_wrap" class="'.$jobwidthclass. ' ' .$jobtabwidthclass. '">
                                  <div id="jsjobs_module" style="height:'.$jobheight.'px;'.$inlineCSS.'">';
                    $jobaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->aliasid);
                    $an_link = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd=' . $jobaliasid . '&Itemid=' . $itemid);
                    $contents .= '<span id="jsjobs_module_heading">
                                    <span id="themeanchor">
                                        <a class="anchor" href="'.$an_link.'">
                                            ' . $job->title . '
                                        </a>
                                    </span>
                                  </span>';
                    $dataclass = 'data100';
                    if ($companylogo != 0) {
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);
                        if($logodatarow == 1){ // Combine
                            $logoclass = "comp40";
                            $dataclass = "data60";
                            $logocss = 'width:'.$companylogowidth.'px;';
                            
                        }else{
                            $logoclass = "comp100";                 
                            $dataclass = "data100";
                            $logocss = 'height:'.$companylogoheight.'px;';
                        }

                        $logo = JSModel::getJSModel('common')->getCompanyLogo( $job->companyid , $job->companylogo , null , 2 );
                        $logoclass .= $this->getClasses($companylogo);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="' . $logoclass . '" >
                                                <a href=' . $c_l . '><img  src="' . $logo . '" style="'.$logocss.'display:block;margin:auto;" /></a>
                                            </div>
                                          ';
                    }
                    $contents .= '<div id="jsjobs_module_data_fieldwrapper" class="' . $dataclass . ' visible-all">';
                    $colwidthclass = 'modcolwidth'.$datacolumn;
                    if ($company != 0) {
                        $class = $this->getClasses($company);
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Company') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue"><span id="themeanchor"><a class="anchor" href=' . $c_l . '>' . $job->companyname . '</a></span></span>
                                            </div>
                                          ';
                    }
                    if ($category != 0) {
                        $class = $this->getClasses($category);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Category') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $job->cat_title . '</span>
                                            </div>
                                          ';
                    }
                    if ($subcategory != 0) {
                        $class = $this->getClasses($subcategory);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Sub Category') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $job->subcat_title . '</span>
                                            </div>
                                          ';
                    }
                    if ($jobtype != 0) {
                        $class = $this->getClasses($jobtype);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Type') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $job->jobtypetitle . '</span>
                                            </div>
                                          ';
                    }
                    if ($location != 0) {
                        $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                        $joblocation = !empty($job->cityname) ? JText::_($job->cityname) : ' ';
                        $class = $this->getClasses($location);
                        switch ($addlocation) {
                            case 'csc':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                            case 'cs':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                            break;
                            case 'cc':
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                        }
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Location') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $joblocation . '</span>
                                            </div>
                                          ';
                    }
                    if ($posteddate != 0) {
                        $class = $this->getClasses($posteddate);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Posted') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . date($dateformat, strtotime($job->created)) . '</span>
                                            </div>
                                          ';
                    }
                    $contents .= '</div>
                            </div>
                        </div>';
                }
                if ($sliding == 1) { // Sliding is enable
                    $consectivecontent = '';
                    for ($i = 0; $i < $consecutivesliding; $i++) {
                        $consectivecontent .= $contents;
                    }

                    if ($slidingdirection == 1) { // UP
                        $contents = '<marquee id="mod_hotjsjobs"  style="height:' . $moduleheight . ';" direction="up" scrolldelay="' . $speed . '" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $consectivecontent . '</marquee>';
                    } else { // LEFT
                        $marqueewidth = ((int) $jobwidth + (int) $jobmarginleft) * $consecutivesliding;
                        $marqueewidth = count($jobs) * $marqueewidth;
                        $totaljobs = count($jobs) * $consecutivesliding;
                        $marqueeheight = (int) $jobheight + (int) $jobmargintop;
                        if ($showtitle == 1)
                            $top = '25';
                        else
                            $top = '0';
                        $contents = '<div id="jsjobs_mod_' . $moduleName . '" data-top="' . $top . '" data-totaljobs="' . $totaljobs . '" data-speed="' . $speed . '" data-width="' . $marqueewidth . '" data-height="' . $marqueeheight . '">' . $consectivecontent . '</div>';
                    }
                    echo '
                        <script>
                            jQuery(document).ready(function(){
                                var maindiv = jQuery("div#jsjobs_module_wrapper.' . $moduleName . '");
                                var contentdiv = jQuery("div#jsjobs_mod_' . $moduleName . '");
                                var mainwidth = jQuery(maindiv).width();
                                var contentwidth = jQuery(contentdiv).attr("data-width");
                                var contentheight = jQuery(contentdiv).attr("data-height");
                                var totaljobs = jQuery(contentdiv).attr("data-totaljobs");
                                jQuery(maindiv).css({"position":"relative"});
                                var top = jQuery(contentdiv).attr("data-top");
                                jQuery(contentdiv).width(contentwidth)
                                                  .height(contentheight)
                                                  .css({"position":"absolute","left":"100%","top":top+"px"});
                                slideleft();
                                function slideleft(){
                                    var perpix = 0;
                                    var speed = jQuery(contentdiv).attr("data-speed");
                                    mainwidth = jQuery(maindiv).width();
                                    contentwidth = jQuery(contentdiv).attr("data-width");
                                    perpix = (parseInt(contentwidth) + parseInt(mainwidth));
                                    perpix = parseInt(contentwidth);
                                    jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix*speed),"linear",function(){
                                        jQuery(contentdiv).css({"left":"100%"});
                                        jQuery(contentdiv).stop(true,true).animate();
                                        slideleft();
                                    });
                                    jQuery(contentdiv).hover(function(){
                                        jQuery(this).stop();
                                    },function(){
                                        var num = parseInt(jQuery(contentdiv).css("left"));
                                        if(num < 0)
                                            var perpix1 = (parseInt(contentwidth) + parseInt(jQuery(contentdiv).css("left")));
                                        else 
                                            var perpix1 = parseInt(contentwidth);
                                        jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix1*speed),"linear",function(){
                                            jQuery(contentdiv).css({"left":"100%"});
                                            jQuery(contentdiv).stop(true,true).animate();
                                            slideleft();
                                        });
                                    });
                                }
                                /*
                                var left = mainwidth;
                                function manualtimeout(){
                                    jQuery(contentdiv).css({"left":left});
                                    left--;
                                    if(Math.abs(left) < (contentwidth-40)){
                                        manualtimeout();
                                    }
                                }
                                manualtimeout();
                                //setTimeout(\'manualtimeout()\',1000);
                                */
                            });
                        </script>';
                }
                $contentswrapperend = '</div>';
            }
            return $contentswrapperstart . $contents . $contentswrapperend;
        }
    }
    function getClasses($for){
        $class = '';
        switch($for){
            case 1: // Show all
                $class = ' visible-all ';
            break;
            case 2: // Show desktop and tablet
                $class = ' visible-desktop visible-tablet ';
            break;
            case 3: // Show desktop and mobile
                $class = ' visible-desktop visible-mobile ';
            break;
            case 4: // Show tablet and mobile
                $class = ' visible-tablet visible-mobile ';
            break;
            case 5: // Show desktop
                $class = ' visible-desktop ';
            break;
            case 6: // Show tablet
                $class = ' visible-tablet ';
            break;
            case 7: // Show mobile
                $class = ' visible-mobile ';
            break;
        }
        return $class;
    }
     function listModuleResumes($layoutName,$noofresumes,$applicationtitle,$name,$experience,$available,$gender,$nationality,$location,$category,$subcategory,$workpreference,$posteddate,$separator,$moduleheight,$resumeheight,$resumemargintop,$resumemarginleft,$photowidth,$photoheight,$datacolumn,$listtype,$title,$showtitle,$speedTest,$itemid,$sliding,$consecutivesliding,$slidingdirection,$resumes,$dateformat,$data_directory,$moduleclass_sfx,$resumephoto,$resumesinrow,$resumesinrowtab,$logodatarow){
        $speed = 50;
        if($speedTest < 5){
            for($i = 5; $i > $speedTest; $i--)
                $speed += 10;
            if($speed > 100) $speed = 100;
        }elseif($speedTest > 5){
            for($i = 5; $i < $speedTest; $i++)
                $speed -= 10;
            if($speed < 10) $speed = 10;
        }

        $moduleName = $layoutName;

        $contentswrapperstart = '';
        $contents = '';
        if ($resumes) {
            if ($listtype == 0) { //list style
                $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . ';" >';
                if ($showtitle == 1) {
                    if (!empty($moduleclass_sfx) || $moduleclass_sfx != '') {
                        $contentswrapperstart .= '
                                        <div class="' . $moduleclass_sfx . '"><h3>
                                            <span>
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    } else {
                        $contentswrapperstart .= '
                                        <div id="tp_heading">
                                            <span id="tp_headingtext">
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    }
                }
                $contentswrapperstart .= '<div id="jsjobs_modulelist_titlebar" class="' . $moduleName . '" ><span id="whiteback"></span>';
                //For desktop
                $desktop_w = 1;
                if($resumephoto == 1 || $resumephoto == 2 || $resumephoto == 4 || $resumephoto == 6){
                    $desktop_w++;
                }
                if($applicationtitle == 1 || $applicationtitle == 2 || $applicationtitle == 4 || $applicationtitle == 6){
                    $desktop_w++;
                }
                if($name == 1 || $name == 2 || $name == 3 || $name == 5){
                    $desktop_w++;
                }
                if($category == 1 || $category == 2 || $category == 3 || $category == 5){
                    $desktop_w++;
                }
                if($subcategory == 1 || $subcategory == 2 || $subcategory == 3 || $subcategory == 5){
                    $desktop_w++;
                }
                if($workpreference == 1 || $workpreference == 2 || $workpreference == 3 || $workpreference == 5){
                    $desktop_w++;
                }
                if($experience == 1 || $experience == 2 || $experience == 3 || $experience == 5){
                    $desktop_w++;
                }
                if($available == 1 || $available == 2 || $available == 3 || $available == 5){
                    $desktop_w++;
                }
                if($gender == 1 || $gender == 2 || $gender == 3 || $gender == 5){
                    $desktop_w++;
                }
                if($nationality == 1 || $nationality == 2 || $nationality == 3 || $nationality == 5){
                    $desktop_w++;
                }
                if($location == 1 || $location == 2 || $location == 3 || $location == 5){
                    $desktop_w++;
                }
                if($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5){
                    $desktop_w++;
                }
                //For tablet
                $tablet_w = 1;
                if($resumephoto == 1 || $resumephoto == 2 || $resumephoto == 4 || $resumephoto == 6){
                    $tablet_w++;
                }
                if($applicationtitle == 1 || $applicationtitle == 2 || $applicationtitle == 4 || $applicationtitle == 6){
                    $tablet_w++;
                }
                if($name == 1 || $name == 2 || $name == 3 || $name == 5){
                    $tablet_w++;
                }
                if($category == 1 || $category == 2 || $category == 3 || $category == 5){
                    $tablet_w++;
                }
                if($subcategory == 1 || $subcategory == 2 || $subcategory == 3 || $subcategory == 5){
                    $tablet_w++;
                }
                if($workpreference == 1 || $workpreference == 2 || $workpreference == 3 || $workpreference == 5){
                    $tablet_w++;
                }
                if($experience == 1 || $experience == 2 || $experience == 3 || $experience == 5){
                    $tablet_w++;
                }
                if($available == 1 || $available == 2 || $available == 3 || $available == 5){
                    $tablet_w++;
                }
                if($gender == 1 || $gender == 2 || $gender == 3 || $gender == 5){
                    $tablet_w++;
                }
                if($nationality == 1 || $nationality == 2 || $nationality == 3 || $nationality == 5){
                    $tablet_w++;
                }
                if($location == 1 || $location == 2 || $location == 3 || $location == 5){
                    $tablet_w++;
                }
                if($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5){
                    $tablet_w++;
                }
                //For mobile
                $mobile_w = 1;
                if($resumephoto == 1 || $resumephoto == 2 || $resumephoto == 4 || $resumephoto == 6){
                    $mobile_w++;
                }
                if($applicationtitle == 1 || $applicationtitle == 2 || $applicationtitle == 4 || $applicationtitle == 6){
                    $mobile_w++;
                }
                if($name == 1 || $name == 2 || $name == 3 || $name == 5){
                    $mobile_w++;
                }
                if($category == 1 || $category == 2 || $category == 3 || $category == 5){
                    $mobile_w++;
                }
                if($subcategory == 1 || $subcategory == 2 || $subcategory == 3 || $subcategory == 5){
                    $mobile_w++;
                }
                if($workpreference == 1 || $workpreference == 2 || $workpreference == 3 || $workpreference == 5){
                    $mobile_w++;
                }
                if($experience == 1 || $experience == 2 || $experience == 3 || $experience == 5){
                    $mobile_w++;
                }
                if($available == 1 || $available == 2 || $available == 3 || $available == 5){
                    $mobile_w++;
                }
                if($gender == 1 || $gender == 2 || $gender == 3 || $gender == 5){
                    $mobile_w++;
                }
                if($nationality == 1 || $nationality == 2 || $nationality == 3 || $nationality == 5){
                    $mobile_w++;
                }
                if($location == 1 || $location == 2 || $location == 3 || $location == 5){
                    $mobile_w++;
                }
                if($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5){
                    $mobile_w++;
                }

                if ($resumephoto != 0){
                    $class = $this->getClasses($resumephoto);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Photo') . '</span>';
                }
                if($applicationtitle != 0){
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' visible-all">' . JText::_('Application title') . '</span>';
                }
                if ($name != 0){
                    $class = $this->getClasses($name);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Name') . '</span>';
                }
                if ($category != 0){
                    $class = $this->getClasses($category);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Category') . '</span>';
                }
                if ($subcategory != 0){
                    $class = $this->getClasses($subcategory);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Sub category') . '</span>';
                }
                if ($workpreference != 0){
                    $class = $this->getClasses($workpreference);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Work preference') . '</span>';
                }
                if ($experience != 0){
                    $class = $this->getClasses($experience);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Experience') . '</span>';
                }
                if ($available != 0){
                    $class = $this->getClasses($available);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Available') . '</span>';
                }
                if ($gender != 0){
                    $class = $this->getClasses($gender);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Gender') . '</span>';
                }
                if ($nationality != 0){
                    $class = $this->getClasses($nationality);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Nationality') . '</span>';
                }
                if ($location != 0){
                    $class = $this->getClasses($location);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Location') . '</span>';
                }
                if ($posteddate != 0){
                    $class = $this->getClasses($posteddate);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Posted') . '</span>';
                }
                $contentswrapperstart .= '</div>';
                foreach ($resumes as $resume) {
                    $contents .= '<div id="jsjobs_modulelist_databar"><span id="whiteback"></span>';
                    if ($resumephoto != 0) {
                        $class = $this->getClasses($resumephoto);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">';
                        $resumealiasid = JSModel::getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd=' . $resumealiasid . '&Itemid=' . $itemid ,false);
                        $logo = $data_directory . '/data/jobseeker/resume_' . $resume->resumeid . '/photo/' . $resume->photo;
                        if (!file_exists($logo)) {
                            $logo = 'components/com_jsjobs/images/Users.png';
                        }
                        $contents .= '<a href=' . $c_l . '><img  src="' . $logo . '"  /></a>';
                        $contents .= '</span>';
                    }
                    if ($applicationtitle != 0) {
                        $class = $this->getClasses($applicationtitle);
                        $resumealiasid = JSModel::getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                        $an_link = JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd=' . $resumealiasid . '&Itemid=' . $itemid ,false);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">
                                        <span id="themeanchor">
                                            <a class="anchor" href="'.$an_link.'">
                                                ' . $resume->applicationtitle . '
                                            </a>
                                        </span>
                                        </span>';
                    }
                    if ($name != 0) {
                        $class = $this->getClasses($name);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $resume->name . '</span>';
                    }
                    if ($category != 0) {
                        $class = $this->getClasses($category);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $resume->cat_title . '</span>';
                    }
                    if ($subcategory != 0) {
                        $class = $this->getClasses($subcategory);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $resume->subcat_title . '</span>';
                    }
                    if ($workpreference != 0) {
                        $class = $this->getClasses($workpreference);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $resume->jobtypetitle . '</span>';
                    }
                    if ($available != 0) {
                        $class = $this->getClasses($available);
                        $resumeavail = ($resume->available == 1) ? JText::_('Yes') : JText::_('No');
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $resumeavail . '</span>';
                    }
                    if ($gender != 0) {
                        $class = $this->getClasses($gender);
                        $genderText = '';
                        if($resume->gender == 1){
                            $genderText = JText::_('Male');
                        }elseif ($resume->gender == 1) {
                            $genderText = JText::_('Female');
                        }elseif ($resume->gender == 3) {
                            $genderText = JText::_('Does not matter');
                        }
                        $resumegender = $genderText;
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $resumegender . '</span>';
                    }
                    if ($nationality != 0) {
                        $class = $this->getClasses($nationality);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $resume->nationalityname . '</span>';
                    }
                    if ($location != 0) {
                        $class = $this->getClasses($location);
                        $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                        $joblocation = !empty($job->cityname) ? JText::_($job->cityname) : ' ';
                        switch ($addlocation) {
                            case 'csc':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                            case 'cs':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                            break;
                            case 'cc':
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                        }
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $joblocation . '</span>';
                    }
                    if ($posteddate != 0) {
                        $class = $this->getClasses($posteddate);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . date($dateformat, strtotime($resume->created)) . '</span>';
                    }
                    $contents .= '</div>';
                }

                if ($sliding == 1) { // Sliding is enable
                    $consectivecontent = '';
                    for ($i = 0; $i < $consecutivesliding; $i++) {
                        $consectivecontent .= $contents;
                    }

                    if ($slidingdirection == 1) { // UP
                        $contents = '<marquee id="mod_hotjsjobs"  style="height:' . $moduleheight . ';" direction="up" scrolldelay="' . $speed . '" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $consectivecontent . '</marquee>';
                    }
                }
                $contentswrapperend = '</div>';
            } else { //box style
                $jobwidthclass = "modjob" . $resumesinrow;
                $jobtabwidthclass = "modjobtab" . $resumesinrowtab;
                $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . ';overflow:hidden;" >';
                if ($showtitle == 1) {
                    if (!empty($moduleclass_sfx) || $moduleclass_sfx != '') {
                        $contentswrapperstart .= '
                                        <div class="' . $moduleclass_sfx . '"><h3>
                                            <span>
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    } else {
                        $contentswrapperstart .= '
                                        <div id="tp_heading">
                                            <span id="tp_headingtext">
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    }
                }
                $inlineCSS = 'margin-top:'.$resumemargintop.';margin-left:'.$resumemarginleft.';';
                foreach ($resumes as $resume) {
                    $contents .= '<div id="jsjobs_module_wrap" class="'.$jobwidthclass. ' ' .$jobtabwidthclass. '">
                                  <div id="jsjobs_module" style="height:'.$resumeheight.';'.$inlineCSS.'">';
                    $resumealiasid = JSModel::getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                    $an_link = JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd=' . $resumealiasid . '&Itemid=' . $itemid ,false);
                    $contents .= '<span id="jsjobs_module_heading">
                                    <span id="themeanchor">
                                        <a class="anchor" href="'.$an_link.'">
                                            ' . $resume->name . '
                                        </a>
                                    </span>
                                  </span>';
                    $dataclass = 'data100';
                   if ($resumephoto != 0) {
                        $resumealiasid = JSModel::getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd=' . $resumealiasid . '&Itemid=' . $itemid ,false);
                        if($logodatarow == 1){ // Combine
                            $logoclass = "comp40";
                            $dataclass = "data60";
                            $logocss = 'width:'.$photowidth.';';
                        }else{
                            $logoclass = "comp100";                 
                            $dataclass = "data100";
                            $logocss = 'height:'.$photoheight.';';
                        }
                        $logo = $data_directory . '/data/jobseeker/resume_' . $resume->resumeid . '/photo/' . $resume->photo;
                        if (!file_exists($logo)) {
                            $logo = 'components/com_jsjobs/images/Users.png';
                        }
                        $logoclass .= $this->getClasses($resumephoto);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="' . $logoclass . '" >
                                                <a href=' . $c_l . '><img  src="' . $logo . '" style="'.$logocss.'display:block;margin:auto;" /></a>
                                            </div>
                                          ';
                    }
                    
                    $contents .= '<div id="jsjobs_module_data_fieldwrapper" class="' . $dataclass . ' visible-all">';
                    $colwidthclass = 'modcolwidth'.$datacolumn;
                     if ($applicationtitle != 0) {
                        $class = $this->getClasses($applicationtitle);
                        $resumealiasid = JSModel::getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                        $an_link = JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd=' . $resumealiasid . '&Itemid=' . $itemid ,false);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Application Title') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue"><span id="themeanchor"><a class="anchor" href=' .$an_link . '>' . $resume->applicationtitle. '</a></span></span>
                                            </div>
                                          ';
                    }
                    if ($name != 0) {
                        $class = $this->getClasses($name);
                        $resumealiasid = JSModel::getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=35&cd=' . $resumealiasid . '&Itemid=' . $itemid ,false);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Name') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue"><span id="themeanchor"><a class="anchor" href=' . $c_l . '>' . $resume->name . '</a></span></span>
                                            </div>
                                          ';
                    }
                    if ($category != 0) {
                        $class = $this->getClasses($category);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Category') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $resume->cat_title . '</span>
                                            </div>
                                          ';
                    }
                    if ($subcategory != 0) {
                        $class = $this->getClasses($subcategory);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Sub Category') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $resume->subcat_title . '</span>
                                            </div>
                                          ';
                    }
                    if ($workpreference != 0) { 
                        $class = $this->getClasses($workpreference);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Type') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $resume->jobtypetitle . '</span>
                                            </div>
                                          ';
                    }
                    if ($location != 0) {
                        $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                        $joblocation = !empty($job->cityname) ? JText::_($job->cityname) : ' ';
                        $class = $this->getClasses($location);
                        switch ($addlocation) {
                            case 'csc':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                            case 'cs':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                            break;
                            case 'cc':
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                        }
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Location') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $joblocation . '</span>
                                            </div>
                                          ';
                    }
                    if ($posteddate != 0) {
                        $class = $this->getClasses($posteddate);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Posted') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . date($dateformat, strtotime($resume->created)) . '</span>
                                            </div>
                                          ';
                    }
                    $contents .= '</div>
                            </div>
                        </div>';
                }

                if ($sliding == 1) { // Sliding is enable
                    $consectivecontent = '';
                    for ($i = 0; $i < $consecutivesliding; $i++) {
                        $consectivecontent .= $contents;
                    }

                    if ($slidingdirection == 1) { // UP
                        $contents = '<marquee id="mod_hotjsjobs"  style="height:' . $moduleheight . ';" direction="up" scrolldelay="' . $speed . '" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $consectivecontent . '</marquee>';
                    } else { // LEFT
                        $marqueewidth = ((int) $jobwidth + (int) $jobmarginleft) * $consecutivesliding;
                        $marqueewidth = count($jobs) * $marqueewidth;
                        $totaljobs = count($jobs) * $consecutivesliding;
                        $marqueeheight = (int) $jobheight + (int) $jobmargintop;
                        if ($showtitle == 1)
                            $top = '25';
                        else
                            $top = '0';
                        $contents = '<div id="jsjobs_mod_' . $moduleName . '" data-top="' . $top . '" data-totaljobs="' . $totaljobs . '" data-speed="' . $speed . '" data-width="' . $marqueewidth . '" data-height="' . $marqueeheight . '">' . $consectivecontent . '</div>';
                    }
                    echo '
                        <script>
                            jQuery(document).ready(function(){
                                var maindiv = jQuery("div#jsjobs_module_wrapper.' . $moduleName . '");
                                var contentdiv = jQuery("div#jsjobs_mod_' . $moduleName . '");
                                var mainwidth = jQuery(maindiv).width();
                                var contentwidth = jQuery(contentdiv).attr("data-width");
                                var contentheight = jQuery(contentdiv).attr("data-height");
                                var totaljobs = jQuery(contentdiv).attr("data-totaljobs");
                                jQuery(maindiv).css({"position":"relative"});
                                var top = jQuery(contentdiv).attr("data-top");
                                jQuery(contentdiv).width(contentwidth)
                                                  .height(contentheight)
                                                  .css({"position":"absolute","left":"100%","top":top+"px"});
                                slideleft();
                                function slideleft(){
                                    var perpix = 0;
                                    var speed = jQuery(contentdiv).attr("data-speed");
                                    mainwidth = jQuery(maindiv).width();
                                    contentwidth = jQuery(contentdiv).attr("data-width");
                                    perpix = (parseInt(contentwidth) + parseInt(mainwidth));
                                    perpix = parseInt(contentwidth);
                                    jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix*speed),"linear",function(){
                                        jQuery(contentdiv).css({"left":"100%"});
                                        jQuery(contentdiv).stop(true,true).animate();
                                        slideleft();
                                    });
                                    jQuery(contentdiv).hover(function(){
                                        jQuery(this).stop();
                                    },function(){
                                        var num = parseInt(jQuery(contentdiv).css("left"));
                                        if(num < 0)
                                            var perpix1 = (parseInt(contentwidth) + parseInt(jQuery(contentdiv).css("left")));
                                        else 
                                            var perpix1 = parseInt(contentwidth);
                                        jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix1*speed),"linear",function(){
                                            jQuery(contentdiv).css({"left":"100%"});
                                            jQuery(contentdiv).stop(true,true).animate();
                                            slideleft();
                                        });
                                    });
                                }
                                /*
                                var left = mainwidth;
                                function manualtimeout(){
                                    jQuery(contentdiv).css({"left":left});
                                    left--;
                                    if(Math.abs(left) < (contentwidth-40)){
                                        manualtimeout();
                                    }
                                }
                                manualtimeout();
                                //setTimeout(\'manualtimeout()\',1000);
                                */
                            });
                        </script>';
                }
                $contentswrapperend = '</div>';
            }

            return $contentswrapperstart . $contents . $contentswrapperend;
        }
    }
    function listModuleCompanies($layoutName,$noofcompanies,$category,$company,$posteddate,$listtype,$theme,$location,$moduleheight,$jobwidth,$jobheight,$jobfloat,$jobmargintop,$jobmarginleft,$companylogo,$companylogowidth,$companylogoheight,$datacolumn,$listtype2,$title,$showtitle,$speedTest,$itemid,$sliding,$slidingdirection,$dateformat,$data_directory,$consecutivesliding,$moduleclass_sfx,$companies,$resumesinrow,$resumesinrowtab,$logodatarow){

        $speed = 50;
        if($speedTest < 5){
            for($i = 5; $i > $speedTest; $i--)
                $speed += 10;
            if($speed > 100) $speed = 100;
        }elseif($speedTest > 5){
            for($i = 5; $i < $speedTest; $i++)
                $speed -= 10;
            if($speed < 10) $speed = 10;
        }
        $moduleName = $layoutName;
        $contentswrapperstart = '';
        $contents = '';
        if ($companies) {
            if ($listtype == 0) { //list style
                $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . ';" >';
                if ($showtitle == 1) {
                    if (!empty($moduleclass_sfx) || $moduleclass_sfx != '') {
                        $contentswrapperstart .= '
                                        <div class="' . $moduleclass_sfx . '"><h3>
                                            <span>
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    } else {
                        $contentswrapperstart .= '
                                        <div id="tp_heading">
                                            <span id="tp_headingtext">
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    }
                }
                $contentswrapperstart .= '<div id="jsjobs_modulelist_titlebar" class="' . $moduleName . '" ><span id="whiteback"></span>';
                //For desktop
                $desktop_w = 1;
                if($noofcompanies == 1 || $noofcompanies == 2 || $noofcompanies == 4 || $noofcompanies == 6){
                    $desktop_w++;
                }
                if($category == 1 || $category == 2 || $category == 4 || $category == 6){
                    $desktop_w++;
                }
                if($title == 1 || $title == 2 || $title == 3 || $title == 5){
                    $desktop_w++;
                }
                if($location == 1 || $location == 2 || $location == 3 || $location == 5){
                    $desktop_w++;
                }
                if($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5){
                    $desktop_w++;
                }
                //For tablet
                $tablet_w = 1;
                if($noofcompanies == 1 || $noofcompanies == 2 || $noofcompanies == 4 || $noofcompanies == 6){
                    $tablet_w++;
                }
                if($category == 1 || $category == 2 || $category == 4 || $category == 6){
                    $tablet_w++;
                }
                if($title == 1 || $title == 2 || $title == 3 || $title == 5){
                    $tablet_w++;
                }
                if($location == 1 || $location == 2 || $location == 3 || $location == 5){
                    $tablet_w++;
                }
                if($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5){
                    $tablet_w++;
                }
                //For mobile
                $mobile_w = 1;
                if($noofcompanies == 1 || $noofcompanies == 2 || $noofcompanies == 4 || $noofcompanies == 6){
                    $mobile_w++;
                }
                if($category == 1 || $category == 2 || $category == 4 || $category == 6){
                    $mobile_w++;
                }
                if($title == 1 || $title == 2 || $title == 3 || $title == 5){
                    $mobile_w++;
                }
                if($location == 1 || $location == 2 || $location == 3 || $location == 5){
                    $mobile_w++;
                }
                if($posteddate == 1 || $posteddate == 2 || $posteddate == 3 || $posteddate == 5){
                    $mobile_w++;
                }

                if ($noofcompanies != 0){
                    $class = $this->getClasses($noofcompanies);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Photo') . '</span>';
                }
                if ($category != 0){
                    $class = $this->getClasses($category);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Category') . '</span>';
                }
                if ($location != 0){
                    $class = $this->getClasses($location);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Location') . '</span>';
                }
                if ($posteddate != 0){
                    $class = $this->getClasses($posteddate);
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JText::_('Posted') . '</span>';
                }
                $contentswrapperstart .= '</div>';
                foreach ($companies as $company) {
                    $contents .= '<div id="jsjobs_modulelist_databar"><span id="whiteback"></span>';
                    if ($companylogo != 0) {
                        $class = $this->getClasses($companylogo);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">';
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($company->companyaliasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);

                        $logo = JSModel::getJSModel('common')->getCompanyLogo( $company->companyid , $company->companylogo , null , 2 );

                        $contents .= '<a href=' . $c_l . '><img  src="' . $logo . '"  /></a>';
                        $contents .= '</span>';
                    }
                    if ($title != 0) {
                        $class = $this->getClasses($title);
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($company->companyaliasid);
                        $an_link = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&cd=' . $companyaliasid . '&Itemid=' . $itemid);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">
                                        <span id="themeanchor">
                                            <a class="anchor" href="'.$an_link.'">
                                                ' . $company->title . '
                                            </a>
                                        </span>
                                        </span>';
                    }
                    if ($category != 0) {
                        $class = $this->getClasses($category);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . $company->cat_title . '</span>';
                    }
                    if ($location != 0) {
                        $class = $this->getClasses($location);
                        $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                        $joblocation = !empty($company->cityname) ? $company->cityname : ' ';
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . JSModel::getJSModel('cities')->getLocationDataForView($company->city) . '</span>';
                    }
                    if ($posteddate != 0) {
                        $class = $this->getClasses($posteddate);
                        $contents .= '<span id="jsjobs_modulelist_databar" class="desktop_w-'.$desktop_w.' tablet_w-'.$tablet_w.' mobile_w-'.$mobile_w.' '.$class.'">' . date($dateformat, strtotime($company->created)) . '</span>';
                    }
                    $contents .= '</div>';
                }

                if ($sliding == 1) { // Sliding is enable
                    $consectivecontent = '';
                    for ($i = 0; $i < $consecutivesliding; $i++) {
                        $consectivecontent .= $contents;
                    }

                    if ($slidingdirection == 1) { // UP
                        $contents = '<marquee id="mod_hotjsjobs"  style="height:' . $moduleheight . ';" direction="up" scrolldelay="' . $speed . '" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $consectivecontent . '</marquee>';
                    }
                }
                $contentswrapperend = '</div>';
            } else { //box style
               $jobwidthclass = "modjob" . $resumesinrow;
                $jobtabwidthclass = "modjobtab" . $resumesinrowtab;
                $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="' . $moduleName . '" style="height:' . $moduleheight . ';overflow:hidden;" >';
                if ($showtitle == 1) {
                    if (!empty($moduleclass_sfx) || $moduleclass_sfx != '') {
                        $contentswrapperstart .= '
                                        <div class="' . $moduleclass_sfx . '"><h3>
                                            <span>
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    } else {
                        $contentswrapperstart .= '
                                        <div id="tp_heading">
                                            <span id="tp_headingtext">
                                                    <span id="tp_headingtext_left"></span>
                                                    <span id="tp_headingtext_center">' . $title . '</span>
                                                    <span id="tp_headingtext_right"></span>             
                                            </span>
                                        </div>
                                    ';
                    }
                }
                $inlineCSS = 'margin-top:'.$jobmargintop.';margin-left:'.$jobmarginleft.';';
                foreach ($companies as $company) {
                                        $contents .= '<div id="jsjobs_module_wrap" class="'.$jobwidthclass. ' ' .$jobtabwidthclass. '">
                                  <div id="jsjobs_module" style="height:'.$jobheight.';'.$inlineCSS.'">';
                    $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($company->companyaliasid);
                    $an_link = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&cd=' . $companyaliasid . '&Itemid=' . $itemid);
                    $contents .= '<span id="jsjobs_module_heading">
                                    <span id="themeanchor">
                                        <a class="anchor" href="'.$an_link.'">
                                            ' . $company->name . '
                                        </a>
                                    </span>
                                  </span>';
                    $dataclass = 'data100';
                    if ($companylogo != 0) {
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($company->companyaliasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);
                        if($logodatarow == 1){ // Combine
                            $logoclass = "comp40";
                            $dataclass = "data60";
                            $logocss = 'width:'.$companylogowidth.';';
                        }else{
                            $logoclass = "comp100";                 
                            $dataclass = "data100";
                            $logocss = 'height:'.$companylogoheight.';';
                        }

                        $logo = JSModel::getJSModel('common')->getCompanyLogo( $company->companyid , $company->companylogo , null , 2 );

                        $logoclass .= $this->getClasses($companylogo);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="' . $logoclass . '" >
                                                <a href=' . $c_l . '><img  src="' . $logo . '" style="'.$logocss.'display:block;margin:auto;" /></a>
                                            </div>
                                          ';
                    }
                    $contents .= '<div id="jsjobs_module_data_fieldwrapper" class="' . $dataclass . ' visible-all">';
                    $colwidthclass = 'modcolwidth'.$datacolumn; 
                    if ($category != 0) {
                        $class = $this->getClasses($category);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Category') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $company->cat_title . '</span>
                                            </div>
                                          ';
                    }
                    if ($location != 0) {
                        $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                        $joblocation = !empty($company->cityname) ? JText::_($company->cityname) : ' ';
                        $class = $this->getClasses($location);
                        switch ($addlocation) {
                            case 'csc':
                                $joblocation .= !empty($company->statename) ? ', '.JText::_($company->statename) : '';
                                $joblocation .= !empty($company->countryname) ? ', '.JText::_($company->countryname) : '';
                            break;
                            case 'cs':
                                $joblocation .= !empty($company->statename) ? ', '.JText::_($company->statename) : '';
                            break;
                            case 'cc':
                                $joblocation .= !empty($company->countryname) ? ', '.JText::_($company->countryname) : '';
                            break;
                        }
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Location') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $joblocation . '</span>
                                            </div>
                                          ';
                    }
                    if ($posteddate != 0) {
                        $class = $this->getClasses($posteddate);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" class="'.$colwidthclass.$class.'">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Posted') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . date($dateformat, strtotime($company->created)) . '</span>
                                            </div>
                                          ';
                    }
                    $contents .= '</div>
                            </div>
                        </div>';
                }
                if ($sliding == 1) { // Sliding is enable
                    $consectivecontent = '';
                    for ($i = 0; $i < $consecutivesliding; $i++) {
                        $consectivecontent .= $contents;
                    }

                    if ($slidingdirection == 1) { // UP
                        $contents = '<marquee id="mod_hotjsjobs"  style="height:' . $moduleheight . ';" direction="up" scrolldelay="' . $speed . '" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $consectivecontent . '</marquee>';
                    } else { // LEFT
                        $marqueewidth = ((int) $jobwidth + (int) $jobmarginleft) * $consecutivesliding;
                        $marqueewidth = count($jobs) * $marqueewidth;
                        $totaljobs = count($jobs) * $consecutivesliding;
                        $marqueeheight = (int) $jobheight + (int) $jobmargintop;
                        if ($showtitle == 1)
                            $top = '25';
                        else
                            $top = '0';
                        $contents = '<div id="jsjobs_mod_' . $moduleName . '" data-top="' . $top . '" data-totaljobs="' . $totaljobs . '" data-speed="' . $speed . '" data-width="' . $marqueewidth . '" data-height="' . $marqueeheight . '">' . $consectivecontent . '</div>';
                    }
                    echo '
                        <script>
                            jQuery(document).ready(function(){
                                var maindiv = jQuery("div#jsjobs_module_wrapper.' . $moduleName . '");
                                var contentdiv = jQuery("div#jsjobs_mod_' . $moduleName . '");
                                var mainwidth = jQuery(maindiv).width();
                                var contentwidth = jQuery(contentdiv).attr("data-width");
                                var contentheight = jQuery(contentdiv).attr("data-height");
                                var totaljobs = jQuery(contentdiv).attr("data-totaljobs");
                                jQuery(maindiv).css({"position":"relative"});
                                var top = jQuery(contentdiv).attr("data-top");
                                jQuery(contentdiv).width(contentwidth)
                                                  .height(contentheight)
                                                  .css({"position":"absolute","left":"100%","top":top+"px"});
                                slideleft();
                                function slideleft(){
                                    var perpix = 0;
                                    var speed = jQuery(contentdiv).attr("data-speed");
                                    mainwidth = jQuery(maindiv).width();
                                    contentwidth = jQuery(contentdiv).attr("data-width");
                                    perpix = (parseInt(contentwidth) + parseInt(mainwidth));
                                    perpix = parseInt(contentwidth);
                                    jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix*speed),"linear",function(){
                                        jQuery(contentdiv).css({"left":"100%"});
                                        jQuery(contentdiv).stop(true,true).animate();
                                        slideleft();
                                    });
                                    jQuery(contentdiv).hover(function(){
                                        jQuery(this).stop();
                                    },function(){
                                        var num = parseInt(jQuery(contentdiv).css("left"));
                                        if(num < 0)
                                            var perpix1 = (parseInt(contentwidth) + parseInt(jQuery(contentdiv).css("left")));
                                        else 
                                            var perpix1 = parseInt(contentwidth);
                                        jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix1*speed),"linear",function(){
                                            jQuery(contentdiv).css({"left":"100%"});
                                            jQuery(contentdiv).stop(true,true).animate();
                                            slideleft();
                                        });
                                    });
                                }
                                /*
                                var left = mainwidth;
                                function manualtimeout(){
                                    jQuery(contentdiv).css({"left":left});
                                    left--;
                                    if(Math.abs(left) < (contentwidth-40)){
                                        manualtimeout();
                                    }
                                }
                                manualtimeout();
                                //setTimeout(\'manualtimeout()\',1000);
                                */
                            });
                        </script>';
                }
                $contentswrapperend = '</div>';
            }

            return $contentswrapperstart . $contents . $contentswrapperend;
        }
    }
    function listPluginJobs($layoutName, $jobs, $location, $showtitle, $title, $listtype, $noofjobs, $category, $subcategory, $company, $jobtype, $posteddate, $theme, $separator, $moduleheight, $jobwidth, $jobheight, $jobfloat, $jobmargintop, $jobmarginleft, $companylogo, $companylogoheight, $companylogowidth, $sliding, $datacolumn, $speedTest, $slidingdirection, $dateformat, $data_directory, $consecutivesliding, $itemid) {

        $speed = 50;
        if($speedTest < 5){
            for($i = 5; $i > $speedTest; $i--)
                $speed += 10;
            if($speed > 100) $speed = 100;
        }elseif($speedTest > 5){
            for($i = 5; $i < $speedTest; $i++)
                $speed -= 10;
            if($speed < 10) $speed = 10;
        }

        if ($layoutName == 'jsnewestjobs') {
            $pluginName = 'newestjobs';
        } elseif ($layoutName == 'jshotjobs') {
            $pluginName = 'hotjsjobs';
        } elseif ($layoutName == 'jsfeaturedjobs') {
            $pluginName = 'featuredjobs';
        } elseif ($layoutName == 'jsgoldjobs') {
            $pluginName = 'goldjobs';
        } elseif ($layoutName == 'jstopjobs') {
            $pluginName = 'topjobs';
        }
        $script = '';
        $contentswrapperstart = '';
        $contents = '';
        if ($jobs) {
            if ($listtype == 0) { //list style
                $float = ($jobfloat == 0) ? "float:left;" : "display:block;";
                $jobinlinestyle = "width:" . $jobwidth . "; " . $float . " margin-top:" . $jobmargintop . "; margin-left:" . $jobmarginleft . "; height:" . $jobheight . ";";
                $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="' . $pluginName . '" style="height:' . $moduleheight . ';" >';
                if ($showtitle == 1) {
                    $contentswrapperstart .= '
                                <div id="tp_heading">
                                    <span id="tp_headingtext">
                                            <span id="tp_headingtext_left"></span>
                                            <span id="tp_headingtext_center">' . $title . '</span>
                                            <span id="tp_headingtext_right"></span>             
                                    </span>
                                </div>
                            ';
                }
                $contentswrapperstart .= '<div id="jsjobs_modulelist_titlebar" class="' . $pluginName . '" ><span id="whiteback"></span>';
                $noof_w = 1;
                if ($company == 1)
                    $noof_w++;
                if ($category == 1)
                    $noof_w++;
                if ($subcategory == 1)
                    $noof_w++;
                if ($jobtype == 1)
                    $noof_w++;
                if ($posteddate == 1)
                    $noof_w++;

                if ($company == 1)
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="w-' . $noof_w . '">' . JText::_('Company') . '</span>';
                $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="w-' . $noof_w . '">' . JText::_('Title') . '</span>';
                if ($category == 1)
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="w-' . $noof_w . '">' . JText::_('Category') . '</span>';
                if ($subcategory == 1)
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="w-' . $noof_w . '">' . JText::_('Sub Category') . '</span>';
                if ($location == 1)
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="w-' . $noof_w . '">' . JText::_('Location') . '</span>';
                if ($jobtype == 1)
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="w-' . $noof_w . '">' . JText::_('Type') . '</span>';
                if ($posteddate == 1)
                    $contentswrapperstart .= '<span id="jsjobs_modulelist_titlebar" class="w-' . $noof_w . '">' . JText::_('Posted') . '</span>';
                $contentswrapperstart .= '</div>';
                foreach ($jobs as $job) {
                    $contents .= '<div id="jsjobs_modulelist_databar"><span id="whiteback"></span>';
                    $contents .= '<span id="jsjobs_modulelist_databar" class="w-' . $noof_w . '">';
                    if ($companylogo == 1) {
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);
                        $logo = JSModel::getJSModel('common')->getCompanyLogo( $job->companyid , $job->companylogo , null , 2 );
                        $contents .= '<a href=' . $c_l . '><img  src="' . $logo . '"  /></a>';
                    }
                    if ($company == 1) {
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);
                        $contents .= '<span id="themeanchor"><a class="anchor" href=' . $c_l . '>' . $job->companyname . '</a></span>';
                    }
                    $contents .= '</span>';
                    $jobaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->aliasid);
                    $an_link = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd=' . $jobaliasid . '&Itemid=' . $itemid ,false);
                    $contents .= '<span id="jsjobs_modulelist_databar" class="w-' . $noof_w . ' bg">
                                    <span id="themeanchor">
                                        <a class="anchor" href="'.$an_link.'">
                                            ' . $job->title . '
                                        </a>
                                    </span>
                                    </span>';
                    if ($category == 1) {
                        $contents .= '<span id="jsjobs_modulelist_databar" class="w-' . $noof_w . ' bg">' . $job->cat_title . '</span>';
                    }
                    if ($subcategory == 1) {
                        $contents .= '<span id="jsjobs_modulelist_databar" class="w-' . $noof_w . ' bg">' . $job->subcat_title . '</span>';
                    }
                    if ($location == 1) {
                        $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                        $joblocation = !empty($job->cityname) ? JText::_($job->cityname) : ' ';
                        switch ($addlocation) {
                            case 'csc':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                            case 'cs':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                            break;
                            case 'cc':
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                        }
                        $contents .= '<span id="jsjobs_modulelist_databar" class="w-' . $noof_w . ' bg">' . $joblocation . '</span>';
                    }
                    if ($jobtype == 1) {
                        $contents .= '<span id="jsjobs_modulelist_databar" class="w-' . $noof_w . ' bg">' . $job->jobtypetitle . '</span>';
                    }
                    if ($posteddate == 1) {
                        $contents .= '<span id="jsjobs_modulelist_databar" class="w-' . $noof_w . ' bg">' . date($dateformat, strtotime($job->created)) . '</span>';
                    }
                    $contents .= '</div>';
                }

                if ($sliding == 1) { // Sliding is enable
                    $consectivecontent = '';
                    for ($i = 0; $i < $consecutivesliding; $i++) {
                        $consectivecontent .= $contents;
                    }

                    if ($slidingdirection == 1) { // UP
                        $contents = '<marquee id="mod_' . $pluginName . '"  style="height:' . $moduleheight . ';" direction="up" scrolldelay="' . $speed . '" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $consectivecontent . '</marquee>';
                    }
                }
                $contentswrapperend = '</div>';
            } else { //box style
                $float = ($jobfloat == 0) ? "float:left;" : "display:block;";
                $jobinlinestyle = "width:" . $jobwidth . "; " . $float . " height:" . $jobheight . ";";
                $margins = " margin-top:" . $jobmargintop . "; margin-left:" . $jobmarginleft . ";";
                $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="' . $pluginName . '" style="height:' . $moduleheight . ';" >';
                if ($showtitle == 1) {
                    $contentswrapperstart .= '
                                <div id="tp_heading">
                                    <span id="tp_headingtext">
                                            <span id="tp_headingtext_left"></span>
                                            <span id="tp_headingtext_center">' . $title . '</span>
                                            <span id="tp_headingtext_right"></span>             
                                    </span>
                                </div>
                            ';
                }
                foreach ($jobs as $job) {
                    $contents .= '<div id="jsjobs_module_wrap" style="'.$margins.$float.'">
                                  <div id="jsjobs_module" style="' . $jobinlinestyle . '">';
                    $jobaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->aliasid);
                    $an_link = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd=' . $jobaliasid . '&Itemid=' . $itemid ,false);
                    $contents .= '<span id="jsjobs_module_heading">
                                    <span id="themeanchor">
                                        <a class="anchor" href="'.$an_link.'">
                                            ' . $job->title . '
                                        </a>
                                    </span>
                                  </span>';
                    $datawidth = "96%";
                    if ($companylogo == 1) {
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);
                        $per = ((int) $companylogowidth / (int) $jobwidth) * 100;
                        $singlerow = false;
                        $style = 'style="width:' . ($companylogowidth - 20) . 'px;"';
                        $datawidth = ((int) $jobwidth - (int) $companylogowidth) - 20;
                        if ($per >= 60) {
                            $singlerow = true;
                            $style = 'style="width:96%;"';
                            $datawidth = "96%";
                        } else
                            $datawidth .= "px";
                        $logo = JSModel::getJSModel('common')->getCompanyLogo( $job->companyid , $job->companylogo , null , 2 );
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" ' . $style . '>
                                                <a href=' . $c_l . '><img  src="' . $logo . '" style="width:' . $companylogowidth . '; height:' . $companylogoheight . ';" /></a>
                                            </div>
                                          ';
                    }
                    $contents .= '<div id="jsjobs_module_data_fieldwrapper" style="width:' . $datawidth . ';">';
                    $colwidth = (100 / $datacolumn) - 2;
                    if ($company == 1) {
                        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
                        $c_l = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $companyaliasid . '&Itemid=' . $itemid ,false);
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" style="width:' . $colwidth . '%;padding:2px;">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Company') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue"><span id="themeanchor"><a class="anchor" href=' . $c_l . '>' . $job->companyname . '</a></span></span>
                                            </div>
                                          ';
                    }
                    if ($category == 1) {
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" style="width:' . $colwidth . '%;padding:2px;">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Category') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $job->cat_title . '</span>
                                            </div>
                                          ';
                    }
                    if ($subcategory == 1) {
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" style="width:' . $colwidth . '%;padding:2px;">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Sub Category') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $job->subcat_title . '</span>
                                            </div>
                                          ';
                    }
                    if ($location == 1) {
                        $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                        $joblocation = !empty($job->cityname) ? JText::_($job->cityname) : ' ';
                        switch ($addlocation) {
                            case 'csc':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                            case 'cs':
                                $joblocation .= !empty($job->statename) ? ', '.JText::_($job->statename) : '';
                            break;
                            case 'cc':
                                $joblocation .= !empty($job->countryname) ? ', '.JText::_($job->countryname) : '';
                            break;
                        }
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" style="width:' . $colwidth . '%;padding:2px;">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Location') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $joblocation . '</span>
                                            </div>
                                          ';
                    }
                    if ($jobtype == 1) {
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" style="width:' . $colwidth . '%;padding:2px;">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Type') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . $job->jobtypetitle . '</span>
                                            </div>
                                          ';
                    }
                    if ($posteddate == 1) {
                        $contents .= '
                                            <div id="jsjobs_module_data_fieldwrapper" style="width:' . $colwidth . '%;padding:2px;">
                                                <span id="jsjobs_module_data_fieldtitle">' . JText::_('Posted') . '</span>
                                                <span id="jsjobs_module_data_fieldvalue">' . date($dateformat, strtotime($job->created)) . '</span>
                                            </div>
                                          ';
                    }
                    $contents .= '</div>
                            </div>
                        </div>';
                }

                if ($sliding == 1) { // Sliding is enable
                    $consectivecontent = '';
                    for ($i = 0; $i < $consecutivesliding; $i++) {
                        $consectivecontent .= $contents;
                    }

                    if ($slidingdirection == 1) { // UP
                        $contents = '<marquee id="mod_' . $pluginName . '"  style="height:' . $moduleheight . ';" direction="up" scrolldelay="' . $speed . '" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $consectivecontent . '</marquee>';
                    } else { // LEFT
                        $marqueewidth = ((int) $jobwidth + (int) $jobmarginleft) * $consecutivesliding;
                        $marqueewidth = count($jobs) * $marqueewidth;
                        $totaljobs = count($jobs) * $consecutivesliding;
                        $marqueeheight = (int) $jobheight + (int) $jobmargintop;
                        if ($showtitle == 1)
                            $top = '25';
                        else
                            $top = '0';
                        $contents = '<div id="jsjobs_mod_' . $pluginName . '" data-top="' . $top . '" data-totaljobs="' . $totaljobs . '" data-speed="' . $speed . '" data-width="' . $marqueewidth . '" data-height="' . $marqueeheight . '">' . $consectivecontent . '</div>';
                    }
                    $script = '
                        <script>
                            jQuery(document).ready(function(){
                                var maindiv = jQuery("div#jsjobs_module_wrapper.' . $pluginName . '");
                                var contentdiv = jQuery("div#jsjobs_mod_' . $pluginName . '");
                                var mainwidth = jQuery(maindiv).width();
                                var contentwidth = jQuery(contentdiv).attr("data-width");
                                var contentheight = jQuery(contentdiv).attr("data-height");
                                var totaljobs = jQuery(contentdiv).attr("data-totaljobs");
                                jQuery(maindiv).css({"position":"relative"});
                                var top = jQuery(contentdiv).attr("data-top");
                                jQuery(contentdiv).width(contentwidth)
                                                  .height(contentheight)
                                                  .css({"position":"absolute","left":"100%","top":top+"px"});
                                slideleft();
                                function slideleft(){
                                    var perpix = 0;
                                    var speed = jQuery(contentdiv).attr("data-speed");
                                    mainwidth = jQuery(maindiv).width();
                                    contentwidth = jQuery(contentdiv).attr("data-width");
                                    perpix = (parseInt(contentwidth) + parseInt(mainwidth));
                                    perpix = parseInt(contentwidth);
                                    jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix*speed),"linear",function(){
                                        jQuery(contentdiv).css({"left":"100%"});
                                        jQuery(contentdiv).stop(true,true).animate();
                                        slideleft();
                                    });
                                    jQuery(contentdiv).hover(function(){
                                        jQuery(this).stop();
                                    },function(){
                                        var num = parseInt(jQuery(contentdiv).css("left"));
                                        if(num < 0)
                                            var perpix1 = (parseInt(contentwidth) + parseInt(jQuery(contentdiv).css("left")));
                                        else 
                                            var perpix1 = parseInt(contentwidth);
                                        jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix1*speed),"linear",function(){
                                            jQuery(contentdiv).css({"left":"100%"});
                                            jQuery(contentdiv).stop(true,true).animate();
                                            slideleft();
                                        });
                                    });
                                }
                                /*
                                var left = mainwidth;
                                function manualtimeout(){
                                    jQuery(contentdiv).css({"left":left});
                                    left--;
                                    if(Math.abs(left) < (contentwidth-40)){
                                        manualtimeout();
                                    }
                                }
                                manualtimeout();
                                //setTimeout(\'manualtimeout()\',1000);
                                */
                            });
                        </script>';
                }
                $contentswrapperend = '</div>';
            }

            $finalcontent = $contentswrapperstart . $contents . $contentswrapperend . $script;
        }

        return $finalcontent;
    }

}

?>
