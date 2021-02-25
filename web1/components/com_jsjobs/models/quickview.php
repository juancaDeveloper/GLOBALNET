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

class JSJobsModelQuickview extends JSModel {

    function __construct() {
        parent::__construct();
    }

    function getJobQuickViewById($jobid) {
        if (!is_numeric($jobid))
            return false;

        $result = $this->getJSModel('job')->getJobbyId($jobid);
        $job = $result[0];
        $fieldsordering = $result[3];
        $fieldsorderingcompany = $result[4];

        $cf_model = $this->getJSModel('customfields');

        $user = JFactory::getUser();
        $role = JSModel::getJSModel('userrole')->getUserRole($user->id);       
        $listjobconfig = JSModel::getJSModel('configurations')->getConfigByFor('listjob');
        $islistjobforvisitor = JSModel::getJSModel('common')->islistjobforvisitor();
        if ($islistjobforvisitor == 1) { 
            $listjobconfig['lj_category'] = $listjobconfig['visitor_lj_category'];
            $listjobconfig['lj_jobtype'] = $listjobconfig['visitor_lj_jobtype'];
            $listjobconfig['lj_jobstatus'] = $listjobconfig['visitor_lj_jobstatus'];
            $listjobconfig['lj_company'] = $listjobconfig['visitor_lj_company'];
            $listjobconfig['lj_companysite'] = $listjobconfig['visitor_lj_companysite'];
            $listjobconfig['lj_country'] = $listjobconfig['visitor_lj_country'];
            $listjobconfig['lj_city'] = $listjobconfig['visitor_lj_city'];
            $listjobconfig['lj_salary'] = $listjobconfig['visitor_lj_salary'];
            $listjobconfig['lj_created'] = $listjobconfig['visitor_lj_created'];
            $listjobconfig['lj_noofjobs'] = $listjobconfig['visitor_lj_noofjobs'];
            $listjobconfig['lj_description'] = $listjobconfig['visitor_lj_description'];
            
        }

        $section_array = array();
        //requirement section
        if (
                (isset($fieldsordering['heighesteducation']) && $fieldsordering['heighesteducation'] == 1) ||
                (isset($fieldsordering['experience']) && $fieldsordering['experience'] == 1) ||
                (isset($fieldsordering['workpermit']) && $fieldsordering['workpermit'] == 1) ||
                (isset($fieldsordering['requiredtravel']) && $fieldsordering['requiredtravel'] == 1)
        )
            $section_array['requirement'] = 1;
        else
            $section_array['requirement'] = 0;


        $days = $this->getJSModel('configurations')->getConfigValue('newdays');
        $isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
        $newtag = '';
        if ($job->created > $isnew)
            $newtag = '<span class="js_job_title_new" >' . JText::_('New')."!" . '</span>';
        $Itemid = JRequest::getVar('Itemid', false);
        $navlink = "";
        $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
        $link = JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company' . $navlink . '&cd=' . $companyaliasid . '&cat=' . $job->jobcategory . '&Itemid=' . $Itemid ,false);
        
        $gf = '<span class="js_gs_tag"> ';
                    if($job->isgoldjob == 1){
        $gf .=        '<span class="gold"> '.JText::_('Gold').'</span>';
                    }
                    if($job->isfeaturedjob == 1){
        $gf .=        '<span class="featured"> '.JText::_('Featured').'</span>';
                    }
        $gf .= '</span>';

        $html = '
            <div id="jsnewjob_quickview_wrapper">
                <div id="jsquickview_wrapper1">
                    <div id="quickview_head"> ';
                        if (isset($fieldsordering['jobtitle']) && $fieldsordering['jobtitle'] == 1) {
                            $html .= $job->title ;
                        }
        $html .=    '</div>
                    <div id="quickview_sub"> ';
                        if (isset($fieldsordering['company']) && $fieldsordering['company'] == 1 && $listjobconfig['lj_company'] == 1) {
                            $html .= '
                                    <a class="js_job_company_anchor" href="' . $link . '">
                                        ' . $job->companyname . '
                                    </a>'.$gf;
                        }
        $html .=    '</div>
                    <div id="quickview_det"> ';
                    if (isset($fieldsordering['city']) && $fieldsordering['city'] == 1 && $listjobconfig['lj_city'] == 1) {
                        if ($job->multicity != '')
                            $html .= $job->multicity;
                    }
        $html .=    '</div>
                </div>';
        $html .='<div id="jsquickview_block_bottom">
                    <div id="jsquick_view_title"> '.JText::_('Overview').' </div> ';
                    if (isset($fieldsordering['jobtype']) && $fieldsordering['jobtype'] == 1 && $listjobconfig['lj_jobtype'] == 1) {
                        $html .= '<div class="jsquick_view_rows">
                            <span class="js_quick_title">' . JText::_($cf_model->getFieldTitleByFieldAndFieldfor('jobtype' , 2)) . ':  </span>
                            <span class="js_quick_value">' . JText::_($job->jobtypetitle) . '</span>
                        </div>';
                    }
                    if (isset($fieldsordering['jobsalaryrange']) && $fieldsordering['jobsalaryrange'] == 1 && $listjobconfig['lj_salary'] == 1) {
                        if ($job->hidesalaryrange != 1) {
                            $html .= '<div class="jsquick_view_rows">
                                    <span class="js_quick_title">' . JText::_($cf_model->getFieldTitleByFieldAndFieldfor('jobsalaryrange' , 2)) . ':  </span>
                                    <span class="js_quick_value">';
                            $currencyalign = $this->getJSModel('configurations')->getConfigValue('currency_align');
                            $salary = $this->getJSModel('common')->getSalaryRangeView($job->symbol,$job->salaryfrom,$job->salaryto,JText::_($job->salarytype),$currencyalign);
                            $html .= $salary.'</span>
                                </div>';
                        }
                    }
                    if (isset($fieldsordering['jobcategory']) && $fieldsordering['jobcategory'] == 1 && $listjobconfig['lj_category'] == 1) {
                        $html .= '<div class="jsquick_view_rows">
                            <span class="js_quick_title">' . JText::_($cf_model->getFieldTitleByFieldAndFieldfor('jobcategory' , 2)) . ':  </span>
                            <span class="js_quick_value">' . JText::_($job->cat_title) . '</span>
                        </div>';
                    }
                    if (isset($fieldsordering['jobshift']) && $fieldsordering['jobshift'] == 1) {
                        $html .= '<div class="jsquick_view_rows">
                            <span class="js_quick_title">' . JText::_($cf_model->getFieldTitleByFieldAndFieldfor('jobshift' , 2)) . ':  </span>
                            <span class="js_quick_value">' . $job->shifttitle . '</span>
                        </div>';
                    }
                    if (isset($fieldsordering['jobstatus']) && $fieldsordering['jobstatus'] == 1 && $listjobconfig['lj_jobstatus'] == 1) {
                        $html .= '<div class="jsquick_view_rows">
                            <span class="js_quick_title">' . JText::_($cf_model->getFieldTitleByFieldAndFieldfor('jobstatus' , 2)) . ':  </span>
                            <span class="js_quick_value">' . JText::_($job->jobstatustitle) . '</span>
                        </div>';
                    }
                    if (isset($fieldsordering['nofojobs']) && $fieldsordering['nofojobs'] == 1 && $listjobconfig['lj_noofjobs'] == 1) {
                        $html .= '<div class="jsquick_view_rows">
                            <span class="js_quick_title">' . JText::_($cf_model->getFieldTitleByFieldAndFieldfor('noofjobs' , 2)) . ':  </span>
                            <span class="js_quick_value">' . $job->noofjobs . '</span>
                        </div>';
                    }

                    if (isset($fieldsordering['created']) && $fieldsordering['created'] == 1 && $listjobconfig['lj_created'] == 1) {
                    $html .= '<div class="jsquick_view_rows">
                        <span class="js_quick_title">' . JText::_($cf_model->getFieldTitleByFieldAndFieldfor('created' , 2)) . ':  </span>
                        <span class="js_quick_value">' . date($this->getJSModel('configurations')->getConfigValue('date_format'), strtotime($job->created)) . '</span>
                    </div>';
                }
        $html .='</div>';
        $html .='<div id="jsquickview_block_bottom">
                    <div id="jsquick_view_title"> '.JText::_('Requirements').' </div> ';
                    if ($job->iseducationminimax == 1) {
                        if ($job->educationminimax == 1)
                            $title = JText::_('Minimum Education');
                        else
                            $title = JText::_('Maximum Education');
                        $educationtitle = $job->educationtitle;
                    }else {
                        $title = JText::_('Education');
                        $educationtitle = $job->mineducationtitle . ' - ' . $job->maxeducationtitle;
                    }
                    if (isset($fieldsordering['heighesteducation']) && $fieldsordering['heighesteducation'] == 1) {
                        $html .= '<div class="jsquick_view_rows">
                                <span class="js_quick_title">' . $title . ':  </span>
                                <span class="js_quick_value">' . JText::_($educationtitle) . '</span>
                            </div>
                            <div class="jsquick_view_rows">
                                <span class="js_quick_title">' . JText::_('Degree Title') . ':  </span>
                                <span class="js_quick_value">' . $job->degreetitle . '</span>
                            </div>';
                    }
                    if ($job->isexperienceminimax == 1) {
                        if ($job->experienceminimax == 1)
                            $title = JText::_('Minimum Experience');
                        else
                            $title = JText::_('Maximum Experience');
                        $experiencetitle = $job->experiencetitle;
                    }else {
                        $title = JText::_('Experience');
                        $experiencetitle = $job->minexperiencetitle . ' - ' . $job->maxexperiencetitle;
                    }
                    if ($job->experiencetext)
                        $experiencetitle .= ' (' . $job->experiencetext . ')';
                    if (isset($fieldsordering['experience']) && $fieldsordering['experience'] == 1) {
                        $html .= '<div class="jsquick_view_rows">
                                <span class="js_quick_title">' . $title . ':  </span>
                                <span class="js_quick_value">' . JText::_($experiencetitle) . '</span>
                            </div>';
                    }                    

        $html .='</div>';
        $html .='<div id="jsquickview_block_bottom">
                    <div id="jsquick_view_title"> '.JText::_('Location').' </div> ';
                    if (isset($fieldsordering['map']) && $fieldsordering['map'] == 1 && $listjobconfig['lj_city'] == 1) {
                        $html .= '<div class="js_job_full_width_data">
                            <div id="map"><div id="map_container_quickview"></div></div>
                            <input type="hidden" id="longitude" name="longitude" value="' . $job->longitude . '"/>
                            <input type="hidden" id="latitude" name="latitude" value="' . $job->latitude . '"/>
                            <script type="text/javascript">
                                loadMap1("'.$job->latitude.'","'.$job->longitude.'");
                            </script>
                        </div>';
                    }


        $html .='</div>';
        $html .='<div id="jsquickview_block_bottom">
                    <div id="jsquick_view_title"> '.JText::_('Description').' </div> ';
                    if (isset($fieldsordering['description']) && $fieldsordering['description'] == 1 && $listjobconfig['lj_description'] == 1) {
                        $html .= '<div class="jsquickview_decs">' . $job->description . '</div>';
                    }
        $html .='</div>';
        
        $config = $this->getJSModel('configurations')->getConfigByFor('default');          

        $app_link = "";
        if($config['showapplybutton'] == 1){
            if($job->jobapplylink == 1 && !empty($job->joblink)){
                if(!strstr('http',$job->joblink)){
                    $job->joblink = 'http://'.$job->joblink;
                }  
                $app_link .= '<a class="jsquick_view_btns" href="'.JRoute::_($job->joblink ,false).'" target=_blank" >'.JText::_('Apply Now').'</a>';
            }elseif(!empty($config['applybuttonredirecturl'])){
                $app_link .= '<a class="jsquick_view_btns" href="'.JRoute::_($config['applybuttonredirecturl'] ,false).'" target="_blank">'.JText::_('Apply Now').'</a>';
            }else{
                $app_link .='<a class="jsquick_view_btns applynow" href="Javascript: void(0);" onclick="getApplyNowByJobid(' . $jobid.');">'. JText::_('Apply Now') . '</a>';
            }
        }        

        $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($job->jobaliasid);
        $jobolink = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd=' . $jobaliasid .'&Itemid='.$Itemid ,false);
        $html .= '
            <div class="js_job_form_quickview_wrapper">
                    '.$app_link.'
                    <a class="jsquick_view_btns" href="'.$jobolink.'">' . JText::_('Full Detail') . '</a>
                    <a class="jsquick_view_btns" href="Javascript: void(0);" onclick="js_quick_closepopup();">' . JText::_('Close') . '</a>
            </div>
        </div>';

        return $html;
    }
}
?>
