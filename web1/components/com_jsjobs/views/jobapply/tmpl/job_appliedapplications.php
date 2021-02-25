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
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jsjobs/css/jsjobsrating.css');

if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$actions = array(
    '0' => array('value' => 1, 'text' => JText::_('Short List')),
    '1' => array('value' => 2, 'text' => JText::_('Send Message')),
    '2' => array('value' => 3, 'text' => JText::_('Folder')),
    '3' => array('value' => 4, 'text' => JText::_('Comments'))
);
$actioncombo = JHTML::_('select.genericList', $actions, 'action', 'class="inputbox" ' . '', 'value', 'text', '');
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>

<?php

$cf_model = $this->getJSModel('customfields');
function getjobfieldtitle($field  , $cf_model , $for){
    return JText::_($cf_model->getFieldTitleByFieldAndFieldfor($field , $for));
}


if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    if (isset($this->userrole->rolefor) && $this->userrole->rolefor == 1) {  // employer
        ?>
        <div id="js_main_wrapper">
            <span class="js_controlpanel_section_title">
                <?php echo JText::_('Job') . "&nbsp;[" . $this->jobtitle . "]" . '&nbsp;&nbsp' . JText::_('Resume Applied'); ?>
                <span class="js_apply_view_job">
                    <?php echo JText::_('Job View') . " : " . $this->stats->jobview . " / " . JText::_('Applied') . " : " . $this->stats->totalapply; ?></span>
                </span>
            <form action="index.php" method="post" name="adminForm" id="appliedAdminForm" >
                <?php
                if ($this->sortlinks['sortorder'] == 'ASC')
                    $img = JURI::root()."components/com_jsjobs/images/sort0.png";
                else
                    $img = JURI::root()."components/com_jsjobs/images/sort1.png";
                $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $this->jobaliasid . '&ta=' . $this->tabaction . '&Itemid=' . $this->Itemid;
                $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(3);
                $_field = array();
                foreach($fieldsordering AS $field){
                    if($field->showonlisting == 1){
                        $_field[$field->field] = $field->fieldtitle;
                    }
                }

                ?>
                <div id="sortbylinks">
                    <?php if (isset($_field['first_name'])) { ?>
                        <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['name']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'name') echo 'selected' ?>"><?php echo JText::_('Name'); ?><?php if ($this->sortlinks['sorton'] == 'name') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                    <?php } ?>
                    <?php if (isset($_field['job_category'])) { ?>                
                        <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['category']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'category') echo 'selected' ?>"><?php echo JText::_('Category'); ?><?php if ($this->sortlinks['sorton'] == 'category') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                    <?php } ?>
                    <?php if (isset($_field['gender'])) { ?>
                        <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['gender']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'gender') echo 'selected' ?>"><?php echo JText::_('Gender'); ?><?php if ($this->sortlinks['sorton'] == 'gender') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                    <?php } ?>
                    <?php if (isset($_field['iamavailable'])) { ?>
                        <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['available']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'available') echo 'selected' ?>"><?php echo JText::_('Available'); ?><?php if ($this->sortlinks['sorton'] == 'available') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                    <?php } ?>
                    <?php if (isset($_field['salary'])) { ?>
                        <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['jobsalaryrange']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'jobsalaryrange') echo 'selected' ?>"><?php echo JText::_('Salary'); ?><?php if ($this->sortlinks['sorton'] == 'jobsalaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                    <?php } ?>
                    <?php if (isset($_field['heighestfinisheducation'])) { ?>                    
                        <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['education']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'education') echo 'selected' ?>"><?php echo JText::_('Education'); ?><?php if ($this->sortlinks['sorton'] == 'education') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                    <?php } ?>
                    <?php if (isset($_field['total_experience'])) { ?>                
                        <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['total_experience']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'total_experience') echo 'selected' ?>"><?php echo JText::_('Experience'); ?><?php if ($this->sortlinks['sorton'] == 'total_experience') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                    <?php } ?>
                    <span class="job_applied_resume_sbl_links"><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['apply_date']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'apply_date') echo 'selected' ?>"><?php echo JText::_('Applied Date'); ?><?php if ($this->sortlinks['sorton'] == 'apply_date') { ?> <img src="<?php echo $img ?>"> <?php } ?></a></span>
                </div>            

                <div id="jsjobs_appliedapplication_tab_container">
                    <a  onclick="tabaction(<?php echo $this->jobid; ?>, '1')" class='<?php if ($this->tabaction == 1) echo 'selected'; ?>'>
                        <?php echo JText::_('Inbox') . '(' . $this->resumeCountPerTab['inbox'] . ')'; ?>
                    </a>
                    <a onclick="tabaction(<?php echo $this->jobid; ?>, '5')" class='<?php if ($this->tabaction == 5) echo 'selected'; ?>'>
                        <?php echo JText::_('Shortlist') . '(' . $this->resumeCountPerTab['shortlist'] . ')'; ?>
                    </a>
                    <a  onclick="tabaction(<?php echo $this->jobid; ?>, '2')" class='<?php if ($this->tabaction == 2) echo 'selected'; ?>'>
                        <?php echo JText::_('Spam') . '(' . $this->resumeCountPerTab['spam'] . ')'; ?>
                    </a>
                    <a onclick="tabaction(<?php echo $this->jobid; ?>, '3')" class='<?php if ($this->tabaction == 3) echo 'selected'; ?>'>
                        <?php echo JText::_('Hired') . '(' . $this->resumeCountPerTab['hired'] . ')'; ?>
                    </a>
                    <a  onclick="tabaction(<?php echo $this->jobid; ?>, '4')" class='<?php if ($this->tabaction == 4) echo 'selected'; ?>'>
                        <?php echo JText::_('Rejected') . '(' . $this->resumeCountPerTab['rejected'] . ')'; ?>
                    </a>	
                    <a id="appliedresume_tabnarmalsearch" onclick="tabsearch(<?php echo $this->jobid; ?>, 'search', '#appliedresume_tabnarmalsearch')" >
                        <?php echo JText::_('Search'); ?>
                    </a>	
                    <div id="jsjobs_appliedresume_action_allexport">
                        <?php $exportalllink = 'index.php?option=com_jsjobs&task=exportresume.exportallresume&bd=' . $this->jobaliasid; ?>
                        <a id="jsjobs-expot-all-btn" href="<?php echo $exportalllink; ?>" >
                            <img src="<?php echo JURI::root();?>components/com_jsjobs/images/export.png">
                            <span class="jsjobs-export-file"><?php echo JText::_('Export All'); ?></span>		
                        </a>

                    </div>
                </div>	
                <div id="jsjobs_appliedresume_tab_search" style="display: none;">
                    <div id="jsjobs_appliedresume_tab_search_data">
                        <span class="jsjobs_appliedresume_tab">
                           <span class="jsjobs-applied-resume-field">                           
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['application_title']) ? $_field['application_title'] : JText::_('Application Title') . ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_search_data_value">
                                    <input class="inputbox" type="text" name="title" value="<?php echo isset($this->filter_data['title']) ? $this->filter_data['title'] : '';?>" size="20" maxlength="255"/>
                                </span>
                            </div>
                            <div class="field">
                                 <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['total_experience']) ? $_field['total_experience'] : JText::_('Total Experience') . ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_search_data_value">
                                    <input class="inputbox" type="text" name="experience" value="<?php echo isset($this->filter_data['experience']) ? $this->filter_data['experience'] : '';?>" size="20" maxlength="15"/>
                                </span>
                            </div>
                            </span> 
                             <span class="jsjobs-applied-resume-field">
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo JText::_('Name') . ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_search_data_value">
                                    <input class="inputbox" type="text" name="name" value="<?php echo isset($this->filter_data['name']) ? $this->filter_data['name'] : '';?>" size="20" maxlength="255"/>
                                </span>
                            </div>
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['nationality']) ? $_field['nationality'] : JText::_('Nationality') . ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_tab_search_data_value">
                                    <?php echo $this->searchoptions['nationality']; ?>
                                </span>
                            </div>
                            </span>
                             <span class="jsjobs-applied-resume-field">
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['job_category']) ? $_field['job_category'] : JText::_('Category') . ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_tab_search_data_value">
                                    <?php echo $this->searchoptions['jobcategory']; ?>
                                </span>
                            </div>
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['job_subcategory']) ? $_field['job_subcategory'] : JText::_('Sub category') . ":"; ?>
                                </span>
                                <span id="fj_subcategory" class="jsjobs_appliedresume_tab_search_data_value">
                                    <?php echo $this->searchoptions['jobsubcategory']; ?>
                                </span>
                            </div>
                            </span>
                            <span class="jsjobs-applied-resume-field">
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['gender']) ? $_field['gender'] : JText::_('Gender') . ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_tab_search_data_value">
                                    <?php echo $this->searchoptions['gender']; ?>
                                </span>
                            </div>
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['jobtype']) ? $_field['jobtype'] : JText::_('Job type') . ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_tab_search_data_value">
                                    <?php echo $this->searchoptions['jobtype']; ?>
                                </span>
                            </div>
                            </span>
                             <span class="jsjobs-applied-resume-field">
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['salary']) ? $_field['salary'] : JText::_('Salary') . ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_tab_search_data_value">
                                    <?php echo $this->searchoptions['currency']; ?><?php echo $this->searchoptions['jobsalaryrange']; ?>
                                </span>
                            </div>
                       
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['heighestfinisheducation']) ? $_field['heighestfinisheducation'] : JText::_('Highest Education') . ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_tab_search_data_value">
                                    <?php echo $this->searchoptions['heighestfinisheducation']; ?>
                                </span>
                            </div>
                            </span>
                            <span class="jsjobs-applied-resume-field">
                            <div class="field">
                                <span class="jsjobs_appliedresume_tab_search_data_title">
                                    <?php echo isset($_field['iamavailable']) ? $_field['iamavailable'] : JText::_('I am available'). ":"; ?>
                                </span>
                                <span class="jsjobs_appliedresume_tab_search_data_value">
                                    <span class="jsjobs-radio-btn"><input type="radio" name="iamavailable" value="yes" class="radio" <?php if (isset($this->filter_data['iamavailable']) && $this->filter_data['iamavailable'] == 'yes'): ?>checked='checked'<?php endif; ?> /><span class="jsjobs-status-radio-btn"><?php echo JText::_('Yes'); ?></span></span> 
                                    <span class="jsjobs-radio-btn"><input type="radio" name="iamavailable" value="no"  class="radio" <?php if (isset($this->filter_data['iamavailable']) && $this->filter_data['iamavailable'] == 'no'): ?>checked='checked'<?php endif; ?> /><span class="jsjobs-status-radio-btn"><?php echo JText::_('No'); ?></span> </span>					
                                </span>
                            </div>
                            </span>
                            <div class="fieldwrapper-btn">
                                <div class="jsjobs-folder-info-btn">
                                    <sapn class="jsjobs-folder-btn">
                                        <input type="submit" id="button" class="button jsjobs_button" name="submit_app" onclick="jobappliedresumesearch(<?php echo $this->jobid; ?>, '6');" value="<?php echo JText::_('Resume Search'); ?>" />
                                        <input type="button" id="button" class="button jsjobs_button" name="submit_app" onclick="resetformthis(<?php echo $this->jobid; ?>, '6');" value="<?php echo JText::_('Reset'); ?>" />
                                        <input type="button" id="button" class="button_cancel" name="submit_app" onclick="closetabsearch('#jsjobs_appliedresume_tab_search')" value="<?php echo JText::_('Close'); ?>" />
                                    </sapn>  
                                </div>
                            </div>
                        </span>
                    </div>	
                </div>
                <?php
                if (isset($this->resume) && !empty($this->resume)) {
                    foreach ($this->resume as $app) {
                        ?>
                        <div class="js-jobs-jobs-applie" id="jsjobs_appliedresume_data_action_message_<?php echo $app->jobapplyid; ?>">
                            <div class="js_job_image_area">
                                <?php if (isset($_field['photo'])) { ?>
                                    <div class="js_job_image_wrapper mycompany">
                                        <?php
                                        $imgsrc = JURI::root()."components/com_jsjobs/images/jobseeker.png";
                                        if (isset($app->photo) && $app->photo != "") {
                                            if ($this->isjobsharing) {
                                                $imgsrc = $app->photo;
                                            } else {
                                                $imgsrc = JURI::root().$this->config['data_directory'] . "/data/jobseeker/resume_" . $app->appid . '/photo/' . $app->photo;
                                            }
                                        }
                                        ?>
                                        <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                                    </div>
                                <?php } ?>
                                <?php 
                                    $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($app->resumealiasid);
                                    $link = JURI::root() . 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd=' . $resumealiasid . '&bd=' . $app->jobaliasid . '&sortby=' . $this->sortby . '&ta=' . $this->tabaction . '&Itemid=' . $this->Itemid; 
                                ?> 
                                <a class="view_resume_button" href="<?php echo $link ?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/resume-icon.png"><?php echo JText::_('View Resume'); ?></a>
                                <?php if (isset($app->cletterid)) { ?>
                                    <div class="view_coverltr_button"  onclick="showCoverletter('coverletterPopup', <?php echo $app->cletterid; ?>)">
                                        <img src="<?php echo JURI::root();?>components/com_jsjobs/images/addnote.png" />
                                        <span id="resume_action_style" ><?php echo JText::_('Cover Letter'); ?></span>
                                    </div>
                                <?php } ?>

                            </div>
                            <div class="js_job_data_area">
                                <div class="js_job_data_1 mycompany">
                                    <?php if (isset($_field['application_title'])) { ?>
                                        <span class="js_job_title">
                                            <?php echo $app->applicationtitle; ?>
                                        </span>
                                    <?php } ?>
                                    <span class="js_job_posted">
                                        <span class="js_jobapply_title">
                                            <?php echo JText::_('Applied Date') . " : "; ?>
                                        </span>
                                        <span class="js_jobapply_value"> 
                                            <?php echo JHtml::_('date', $app->apply_date, $this->config['date_format']); ?>
                                        </span>                                
                                        <div id="jsjsjobs_stars"> <?php $id = $app->jobapplyid; $percent = 0; $stars = ''; $percent = $app->rating * 20; $stars = '-small'; $html = "<div id=\"jsjobs_appliedresume_stars\" class=\"jsjobs-container" . $stars . "\"" . ( " style=\"float:right;\"" ) . "> <ul class=\"jsjobs-stars" . $stars . "\"> <li id=\"rating_" . $id . "\" class=\"current-rating\" style=\"width:" . (int) $percent . "%;\"></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',1," . (int) $app->ratingid . "," . $app->id . "," . $app->appid . ");\" title=\"" . JTEXT::_('Very Poor') . "\" class=\"one-star\">1</a></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',2," . (int) $app->ratingid . "," . $app->id . "," . $app->appid . ");\" title=\"" . JTEXT::_('Poor') . "\" class=\"two-stars\">2</a></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',3," . (int) $app->ratingid . "," . $app->id . "," . $app->appid . ");\" title=\"" . JTEXT::_('Regular') . "\" class=\"three-stars\">3</a></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',4," . (int) $app->ratingid . "," . $app->id . "," . $app->appid . ");\" title=\"" . JTEXT::_('Good') . "\" class=\"four-stars\">4</a></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',5," . (int) $app->ratingid . "," . $app->id . "," . $app->appid . ");\" title=\"" . JTEXT::_('Very Good') . "\" class=\"five-stars\">5</a></li> </ul> </div> "; $html .="</small></span>"; echo $html; ?></div>
                                </div>
                                <div class="js_job_data_2 myresume first-child">
                                    <?php if (isset($_field['first_name'])) { ?>
                                        <div class="js-col-xs-12 js-col-md-6 jsjobsapp_wrapper">
                                            <span class="jsjobs-apptitle"><?php echo JText::_('Name') . " : "; ?>
                                            </span>
                                            <span class="jsjobs-appvalue"><?php echo $app->first_name." ".$app->last_name; ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_field['gender'])) { ?>
                                        <div class="js-col-xs-12 js-col-md-6 jsjobsapp_wrapper">
                                            <span class="jsjobs-apptitle"><?php echo getjobfieldtitle('gender' , $cf_model , 3) . " : "; ?>
                                            </span>
                                            <span class="jsjobs-appvalue"><?php 
                                                $genderText = '';
                                                if($app->gender == 1){
                                                    $genderText = JText::_('Male');
                                                }elseif ($app->gender == 1) {
                                                    $genderText = JText::_('Female');
                                                }elseif ($app->gender == 3) {
                                                    $genderText = JText::_('Does not matter');
                                                }
                                                echo $genderText; ?>
                                            </span>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_field['iamavailable'])) { ?>
                                        <div class="js-col-xs-12 js-col-md-6 jsjobsapp_wrapper">
                                            <span class="jsjobs-apptitle"><?php echo getjobfieldtitle('iamavailable' , $cf_model , 3) . " : "; ?>
                                                
                                            </span>
                                            <span class="jsjobs-appvalue"><?php echo ($app->iamavailable == 1) ? JText::_('Yes') : JText::_('No'); ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_field['job_category'])) { ?>
                                        <div class="js-col-xs-12 js-col-md-6 jsjobsapp_wrapper">
                                            <span class="jsjobs-apptitle"><?php echo getjobfieldtitle('job_category' , $cf_model , 3) . " : "; ?>
                                                
                                            </span>
                                            <span class="jsjobs-appvalue"><?php echo $app->cat_title; ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_field['heighestfinisheducation'])) { ?>
                                        <div class="js-col-xs-12 js-col-md-6 jsjobsapp_wrapper">
                                            <span class="jsjobs-apptitle"><?php echo getjobfieldtitle('heighestfinisheducation' , $cf_model , 3) . " : "; ?>
                                                
                                            </span>
                                            <span class="jsjobs-appvalue"><?php echo $app->educationtitle; ?></span>
                                        </div>
                                    <?php } ?>

                                    <?php if (isset($_field['total_experience'])) { ?>
                                        <div class="js-col-xs-12 js-col-md-6 jsjobsapp_wrapper">
                                            <span class="jsjobs-apptitle"><?php echo getjobfieldtitle('total_experience' , $cf_model , 3) . " : "; ?>
                                                
                                            </span>
                                            <span class="jsjobs-appvalue"><?php
                                                 if(empty($app->exptitle))
                                                    echo $app->total_experience ;
                                                 else 
                                                    echo $app->exptitle; ?>
                                            </span>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_field['salary'])) { ?>
                                        <div class="js-col-xs-12 js-col-md-6 jsjobsapp_wrapper">
                                            <span class="jsjobs-apptitle"><?php echo getjobfieldtitle('salary' , $cf_model , 3) . " : "; ?>
                                            </span>
                                            <span class="jsjobs-appvalue">
                                                    <?php 
                                                        $salary = $this->getJSModel('common')->getSalaryRangeView($app->symbol,$app->rangestart,$app->rangeend,$app->salarytype,$this->config['currency_align']);
                                                        echo $salary;
                                                    ?>
                                            </span>
                                        </div>
                                    <?php } ?>
                                    <?php //if (isset($_field['desired_salary'])) { ?>
                                        <div class="js-col-xs-12 js-col-md-6 jsjobsapp_wrapper">
                                            <span class="jsjobs-apptitle"><?php echo getjobfieldtitle('desired_salary' , $cf_model , 3) . " : "; ?>
                                                
                                            </span>
                                            <span class="jsjobs-appvalue">
                                                    <?php 
                                                        $salary = $this->getJSModel('common')->getSalaryRangeView($app->dsymbol,$app->drangestart,$app->drangeend,$app->dsalarytype,$this->config['currency_align']);
                                                        echo $salary;
                                                    ?>
                                            </span>
                                        </div>
                                    <?php //} ?>
                                    <div class="js-col-xs-12 js-col-md-12 jsjobsapp_wrapper">
                                            <span class="jsjobs-apptitle"><?php echo getjobfieldtitle('address_city' , $cf_model , 3) . ":&nbsp;"; ?>
                                            </span>
                                            <span class="jsjobs-appvalue">
                                                    <?php
                                                    echo $this->getJSModel('cities')->getLocationDataForView($app->cityid);
                                                    ?>
                                                </span>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 appnotes_wrapper">
                                        <span class="js-col-xs-12 js-col-md-12 jsjobs-appnotes"><?php echo JText::_('Note') . " : "; ?> </span>
                                        <span class="js-col-xs-12 js-col-md-12 jsjobs-appnotesvalue"><?php if($app->comments) echo $app->comments; else echo JText::_('None'); ?> </span>
                                    </div>
                                </div>
                            </div>

                            <div class="resumeaction1ton" id="resumeaction_<?php echo $app->jobapplyid; ?>"></div>
                            <div class="resumeactionmessage1ton" id="resumeactionmessage_<?php echo $app->jobapplyid; ?>"></div>

                            <div class="js_job_data_5">
                                <div class="jsjobs_appliedresume_action" onclick="actioncall(<?php echo $app->jobapplyid; ?>,<?php echo $app->id; ?>,<?php echo $app->appid; ?>, '3')">
                                    <img src="<?php echo JURI::root();?>components/com_jsjobs/images/copytofolder.png" />
                                    <span id="resume_action_style" ><?php echo JText::_('Copy To Folder'); ?></span>
                                </div>
                                <div class="jsjobs_appliedresume_action" onclick="actioncall(<?php echo $app->jobapplyid; ?>,<?php echo $app->id; ?>, '<?php echo $app->email_address; ?>', '5')">
                                    <img src="<?php echo JURI::root();?>components/com_jsjobs/images/emailcandidate.png"   />
                                    <span id="resume_action_style"><?php echo JText::_('Email Candidate'); ?></span>
                                </div>
                                <?php if ($this->tabaction != 5) { ?>
                                    <div class="jsjobs_appliedresume_action" onclick="actionchangestatus(<?php echo $app->jobapplyid; ?>,<?php echo $app->id; ?>,<?php echo $app->appid; ?>, '5')">
                                        <img src="<?php echo JURI::root();?>components/com_jsjobs/images/apr_shortlist.png"   />
                                        <span id="resume_action_style"  ><?php echo JText::_('Short List'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($this->tabaction != 2) { ?>
                                    <div class="jsjobs_appliedresume_action" onclick="actionchangestatus(<?php echo $app->jobapplyid; ?>,<?php echo $app->id; ?>,<?php echo $app->appid; ?>, '2')">
                                        <img src="<?php echo JURI::root();?>components/com_jsjobs/images/markspam.png"   />
                                        <span id="resume_action_style"  ><?php echo JText::_('Mark Spam'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($this->tabaction != 3) { ?>
                                    <div class="jsjobs_appliedresume_action" onclick="actionchangestatus(<?php echo $app->jobapplyid; ?>,<?php echo $app->id; ?>,<?php echo $app->appid; ?>, '3')">
                                        <img src="<?php echo JURI::root();?>components/com_jsjobs/images/hired.png" />
                                        <span id="resume_action_style"  ><?php echo JText::_('Hired'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($this->tabaction == 2) { ?>
                                    <div class="jsjobs_appliedresume_action" onclick="actionchangestatus(<?php echo $app->jobapplyid; ?>,<?php echo $app->id; ?>,<?php echo $app->appid; ?>, '1')">
                                        <img src="<?php echo JURI::root();?>components/com_jsjobs/images/notespam.png"   />
                                        <span id="resume_action_style"  ><?php echo JText::_('Not Spam'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($this->tabaction != 4) { ?>
                                    <div class="jsjobs_appliedresume_action" onclick="actionchangestatus(<?php echo $app->jobapplyid; ?>,<?php echo $app->id; ?>,<?php echo $app->appid; ?>, '4')">
                                        <img src="<?php echo JURI::root();?>components/com_jsjobs/images/reject-small.png" />
                                        <span id="resume_action_style"  ><?php echo JText::_('Rejected'); ?></span>
                                    </div>
                                <?php } ?>
                                <div class="jsjobs_appliedresume_action">
                                    <?php 
                                    $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($app->resumealiasid);
                                    $printlink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=2&rd=' . $resumealiasid . '&bd=' . $app->jobaliasid . '&sortby=' . $this->sortby . '&ta=' . $this->tabaction . '&Itemid=' . $this->Itemid . '&tmpl=component&print=1'; 
                                    ?>
                                    <img src="<?php echo JURI::root();?>components/com_jsjobs/images/print.png"   />
                                    <span id="resume_action_style"><a target="_blank" href="<?php echo $printlink ?>"><?php echo JText::_('Print'); ?></a></span>
                                </div>
                                <div class="jsjobs_appliedresume_action">
                                    <?php $printlink = 'index.php?option=com_jsjobs&c=resume&view=output&layout=resumepdf&format=pdf&rd=' . $app->resumealiasid . '&bd=' . $app->jobaliasid . '&ms=2&Itemid'.$this->Itemid; ?>
                                    <img width="15px" src="<?php echo JURI::root();?>components/com_jsjobs/images/pdf.png"   />
                                    <span id="resume_action_style"><a target="_blank" href="<?php echo $printlink ?>"><?php echo JText::_('Pdf'); ?></a></span>
                                </div>
                                <div class="jsjobs_appliedresume_action">
                                    <?php $exportlink = 'index.php?option=com_jsjobs&task=exportresume.exportresume&bd=' . $app->jobaliasid . '&rd=' . $app->resumealiasid; ?>
                                    <img src="<?php echo JURI::root();?>components/com_jsjobs/images/export.png"  />
                                    <span id="resume_action_style"><a href="<?php echo $exportlink; ?>"><?php echo JText::_('Export'); ?></a></span>
                                </div>
                                <div class="jsjobs_appliedresume_action" onclick="actioncall(<?php echo $app->jobapplyid; ?>,<?php echo $app->id; ?>,<?php echo $app->appid; ?>, '4')">
                                    <img src="<?php echo JURI::root();?>components/com_jsjobs/images/addnote.png" />
                                    <span id="resume_action_style"  ><?php echo JText::_('Add Note'); ?></span>
                                </div>
                                <div class="jsjobs_appliedresume_action" onclick='getjobdetail("resumeaction_<?php echo $app->jobapplyid; ?>",<?php echo $app->id; ?>,<?php echo $app->appid; ?>)'>
                                    <img src="<?php echo JURI::root();?>components/com_jsjobs/images/shrotdetail.png" />
                                    <span id="resume_action_style"  ><?php echo JText::_('Details'); ?></span>
                                </div>
                                <div class="jsjobs_appliedresume_action">
                                    <?php $message_link = JRoute::_('index.php?option=com_jsjobs&c=message&view=message&layout=send_message&bd=' . $app->jobaliasid . '&rd=' . $app->resumealiasid . '&nav=30&Itemid=' . $this->Itemid ,false); ?>
                                    <img src="<?php echo JURI::root();?>components/com_jsjobs/images/messages.png" width="18" height="18" />
                                    <span id="resume_action_style"><a href="<?php echo $message_link; ?>" ><?php echo JText::_('Message'); ?></a></span>
                                </div>
                            </div>
                        </div>            
                        <?php
                    }
                }else{
                    $this->jsjobsmessages->getAccessDeniedMsg('No record found', 'Could not found any matching result', 0);
                }
                ?>
                <input type="hidden" name="task" id="task" value="saveshortlistcandiate" />
                <input type="hidden" name="c"  value="jobapply" />
                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                <input type="hidden" name="jobid" id="jobid" value="<?php echo $this->jobid; ?>" />
                <input type="hidden" name="resumeid" id="resumeid" value="<?php echo $app->appid; ?>" />
                <input type="hidden" name="id" id="id" value="" />
                <input type="hidden" name="action" id="action" value="" />
                <input type="hidden" name="action_status" id="action_status" value="<?php echo $this->tabaction; ?>" />

                <input type="hidden" name="tab_action" id="tab_action" value="" />
                <input type="hidden" name="view" id="view" value="employer" />
                <input type="hidden" name="layout" id="layout" value="job_appliedapplications" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            </form>
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $this->jobaliasid . '&ta=' . $this->tabaction . '&sortby='.$this->sortlinks['sorton']. strtolower($this->sortlinks['sortorder']) .'&Itemid=' . $this->Itemid ,false); ?>" method="post">
                <div id="jsjobs_jobs_pagination_wrapper">
                    <div class="jsjobs-resultscounter">
                        <?php echo $this->pagination->getResultsCounter(); ?>
                    </div>
                    <div class="jsjobs-plinks">
                        <?php echo $this->pagination->getPagesLinks(); ?>
                    </div>
                    <div class="jsjobs-lbox">
                        <?php echo $this->pagination->getLimitBox(); ?>
                    </div>
                </div>

                <?php require_once( 'coverletterbox.php' ); ?>

                <script language="Javascript" type"text/javascript">

                        function fj_getsubcategories(src, val) {
                        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=subcategory&task=listsubcategoriesForSearch",{val:val},function(data){
                        if(data)
                        jQuery("#"+src).html(data); //retuen value
                        });
                        }

                        function jobappliedresumesearch(jobid, action) {
                        document.getElementById('jobid').value = jobid;
                        document.getElementById('tab_action').value = action; // 6 for search 
                        document.getElementById('task').value = 'aappliedresumetabactions';
                        document.forms.appliedAdminForm.submit();

                        }
                        function tabsearch(jobid, searchtype, selected_tab) {
                        var element = jQuery("#jsjobs_appliedapplication_tab_container .jsjobs_appliedapplication_tab_selected");
                        element.removeClass("jsjobs_appliedapplication_tab_selected");
                        jQuery(selected_tab).parents('span').addClass('jsjobs_appliedapplication_tab_selected');
                        var searchhtml = '#jsjobs_appliedresume_tab_search';
                        jQuery(searchhtml).slideDown("slow");
                        }
                        function closetabsearch(src) {
                        jQuery(src).slideUp("slow");
                        }
                        function tabaction(jobid, action) {
                        document.getElementById('jobid').value = jobid;
                        document.getElementById('tab_action').value = action;
                        document.getElementById('task').value = 'aappliedresumetabactions';
                        document.forms["adminForm"].submit();
                        }
                        function actioncall(jobapplyid, jobid, resumeid, action) {
                            
                        jQuery("div#resumeaction_"+jobapplyid).css("display","inline-block");
                        
                        if (action == 3) { // folder
                        getfolders('resumeaction_' + jobapplyid, jobid, resumeid, jobapplyid);
                        } else if (action == 4) { // comments
                        getresumecomments('resumeaction_' + jobapplyid, jobapplyid);
                        } else if (action == 5) { // email candidate
                        mailtocandidate('resumeaction_' + jobapplyid, resumeid, jobapplyid);
                        } else {
                        var src = '#resumeactionmessage_' + jobapplyid;
                        var htmlsrc = '#jsjobs_appliedresume_data_action_message_' + jobapplyid;
                        jQuery(src).html("Loading ...");
                        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=shortlistcandidate&task=saveshortlistcandiate",{jobid:jobid,resumeid:resumeid,action:action},function(data){
                        if(data){
                        jQuery(src).html(data);
                        jQuery(htmlsrc).slideDown("slow");
                        setTimeout(function() {
                        closeresumeactiondiv(htmlsrc)
                        }, 3000);
                        }
                        });
                        }

                        }
                        function actionchangestatus(jobapplyid, jobid, resumeid, action) {
                        var src = '#resumeactionmessage_' + jobapplyid;
                        jQuery(src).html("Loading ...");
                        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=jobapply&task=updateactionstatus",{jobid:jobid,resumeid:resumeid,applyid:jobapplyid,action_status:action},function(data){
                        if(data){
                                jQuery(src).html('');
                                data = jQuery.parseJSON(data);
                                if(data.status == 'ok'){
                                    jQuery(src).html('<span class="resume_message_print_ok"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/approve.png" />'+data.msg+'</span>');
                                }else{
                                    jQuery(src).html('<span class="resume_message_print_notok"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/act_no.png" />'+data.msg+'</span>');
                                }
                                jQuery(src).slideDown("slow");
                                    setTimeout(function() {
                                    closeresumeactiondiv(src)
                                    tabaction(jobid,action);
                                }, 3000);
                            }
                        });
                        }
                        function closeresumeactiondiv(src) {
                        jQuery(src).slideUp("slow");
                        }
                        function setresumeid(resumeid, action) {
                        document.getElementById('resumeid').value = resumeid;
                        document.getElementById('action').value = document.getElementById(action).value;
                        document.forms["adminForm"].submit();
                        }
                        function saveresumecomments(jobapplyid, resumeid) {
                            var src = '#resumeactionmessage_' + jobapplyid;
                            var clearhtml = '#resumeaction_' + jobapplyid;
                            var comments = document.getElementById('comments').value;
                            jQuery(src).html("Loading ...");
                            jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=resume&task=saveresumecomments",{jobapplyid:jobapplyid,resumeid:resumeid,comments:comments},function(data){
                                if(data){
                                    jQuery(clearhtml).hide("");
                                    jQuery(src).html('');
                                    data = jQuery.parseJSON(data);
                                    if(data.status == 'ok'){
                                        jQuery(src).html('<span class="resume_message_print_ok"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/approve.png" />'+data.msg+'</span>');
                                    }else{
                                        jQuery(src).html('<span class="resume_message_print_notok"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/act_no.png" />'+data.msg+'</span>');
                                    }
                                    jQuery(src).slideDown("slow");
                                        setTimeout(function() {
                                        closeresumeactiondiv(src)
                                    }, 3000);
                                }
                            });
                        }
                        function saveaddtofolder(jobapplyid, jobid, resumeid) {
                        var src = '#resumeactionmessage_' + jobapplyid;
                        var clearhtml = '#resumeaction_' + jobapplyid;
                        var folderid = document.getElementById('folderid').value;
                        jQuery(src).html("Loading ...");
                        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=folder&task=saveresumefolder",{jobid:jobid,resumeid:resumeid,applyid:jobapplyid,folderid:folderid},function(data){
                            if(data){
                                jQuery(clearhtml).hide("");
                                jQuery(src).html('');
                                data = jQuery.parseJSON(data);
                                if(data.status == 'ok'){
                                    jQuery(src).html('<span class="resume_message_print_ok"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/approve.png" />'+data.msg+'</span>');
                                }else{
                                    jQuery(src).html('<span class="resume_message_print_notok"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/act_no.png" />'+data.msg+'</span>');
                                }
                                jQuery(src).slideDown("slow");
                                    setTimeout(function() {
                                    closeresumeactiondiv(src)
                                }, 3000);
                            }
                        });
                            }

                        function getfolders(src, jobid, resumeid, applyid) {
                            document.getElementById(src).innerHTML = "Loading ...";
                            jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=folder&task=getmyforlders",{jobid:jobid,resumeid:resumeid,applyid:applyid},function(data){
                                if(data){
                                    jQuery("#"+src).html(data); //retuen value
                                } 
                            });
                        }

                        function mailtocandidate(src, emailaddress, jobapplyid) {
                        document.getElementById(src).innerHTML = "Loading ...";
                        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=job&task=mailtocandidate",{email:emailaddress,jobapplyid:jobapplyid},function(data){
                        if(data){
                        jQuery("#"+src).html(data); //retuen value
                        }
                        });
                        }
                        function sendmailtocandidate(jobapplyid) {
                        var src = 'resumeactionmessage_' + jobapplyid;
                        var arr = new Array();
                        var emmailaddress = document.getElementById('emmailaddress').value;
                        if (emmailaddress) {
                        var result = echeck(emmailaddress);
                        if (result == false) {
                        alert("<?php echo JText::_("Invalid Email"); ?>");
                        document.getElementById('emmailaddress').focus();
                        return false;
                        }
                        arr[0] = emmailaddress;
                        arr[1] = document.getElementById('jsmailaddress').value;
                        arr[2] = document.getElementById('jssubject').value;
                        arr[3] = document.getElementById('candidatemessage').value;
                        sendtocandidate(arr, jobapplyid);

                        } else {
                        alert("<?php echo JText::_("Your Email Is Required").'!'; ?>");
                        document.getElementById('emmailaddress').focus();
                        return false;
                        }
                        }
                        function sendtocandidate(arr, jobapplyid) {

                        var src = '#resumeactionmessage_' + jobapplyid;
                        var clearhtml = '#resumeaction_' + jobapplyid;
                        jQuery(src).html("Loading ...");
                            jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=job&task=sendtocandidate",{val:JSON.stringify(arr)},function(data){
                                jQuery(clearhtml).hide("");
                                jQuery(src).html('');
                                data = jQuery.parseJSON(data);
                                if(data.status == 'ok'){
                                    jQuery(src).html('<span class="resume_message_print_ok"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/approve.png" />'+data.msg+'</span>');
                                }else{
                                    jQuery(src).html('<span class="resume_message_print_notok"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/act_no.png" />'+data.msg+'</span>');
                                }
                                jQuery(src).slideDown("slow");
                                    setTimeout(function() {
                                    closeresumeactiondiv(src)
                                }, 3000);

                            });
                        }
                        function getresumecomments(src, jobapplyid) {
                            document.getElementById(src).innerHTML = "Loading ...";
                            jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=resume&task=getresumecomments",{jobapplyid:jobapplyid},function(data){
                                if(data){
                                    jQuery("#"+src).html(data);
                                } 
                            });
                        }
                        function getjobdetail(src, jobid, resumeid) {
                        
                        jQuery("div#"+src).css("display","inline-block");
                        
                        document.getElementById(src).innerHTML = "Loading ...";
                        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=resume&task=getresumedetail",{jobid:jobid,resumeid:resumeid},function(data){
                        if(data){
                        jQuery("#"+src).html(data); //retuen value
                        } 
                        });
                        }
                        function clsjobdetail(src) {
                        document.getElementById(src).innerHTML = "";
                        }
                        function clsaddtofolder(src) {
                            document.getElementById(src).innerHTML = "";                        
                        }

                        function setrating(src, newrating, ratingid, jobid, resumeid) {
                        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=resume&task=saveresumerating",{ratingid:ratingid,jobid:jobid,resumeid:resumeid,newrating:newrating},function(data){
                        if(data){
                        document.getElementById(src).style.width = parseInt(newrating * 20) + '%';
                        }
                        });
                        }
                        function echeck(str) {
                        var at = "@";
                        var dot = ".";
                        var lat = str.indexOf(at);
                        var lstr = str.length;
                        var ldot = str.indexOf(dot);

                        if (str.indexOf(at) == -1)
                        return false;
                        if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr)
                        return false;
                        if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr)
                        return false;
                        if (str.indexOf(at, (lat + 1)) != -1)
                        return false;
                        if (str.substring(lat - 1, lat) == dot || str.substring(lat + 1, lat + 2) == dot)
                        return false;
                        if (str.indexOf(dot, (lat + 2)) == -1)
                        return false;
                        if (str.indexOf(" ") != -1)
                        return false;
                        return true;
                        }
                        function showCoverletter(src, cletterid) {
                        document.getElementById(src).innerHTML = "Loading ...";
                        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=coverletter&task=getcoverletter",{cletterid:cletterid},function(data){
                        if(data){
                        console.log(data);
                        jQuery('#black_wrapper_jobshortlist').show();
                        jQuery('#'+src).slideDown();
                        jQuery('#'+src).html(data);
                        } 
                        });
                        }
                        function closeCoverletter() {
                        jQuery("div#coverletterPopup").fadeOut(300, function(){
                        jQuery('#black_wrapper_jobshortlist').fadeOut();
                        });
                        }
                        function jobsAppCloseAction(id){
                            jQuery("div#resumeaction_"+id).hide();
                        }
                        jQuery(document).ready(function() {
                        jQuery("span#jsjobs_moreoption").click(function() {
                        jQuery(this).parent().parent().next("div#jsjobs_appliedresume_actioncontainer").slideDown("slow");
                        });
                        jQuery("span#jsjobs_moreoption_close").click(function() {
                        jQuery("div#jsjobs_appliedresume_actioncontainer").slideUp("slow");
                        });
                        });
            </script>
        </form>	
        </div>
        <?php
    } else { // not allowed job posting 
        $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page', 0);
    }
}
?>
</div>
<script type="text/javascript">
    function resetformthis(jobid, action){

        jQuery('#jobid').val(jobid);
        jQuery('#tab_action').val(action); // 6 for search 
        jQuery('#task').val("jobapply.aappliedresumetabactions");


        var form = jQuery('form#appliedAdminForm');
        form.find("input[type=text], input[type=email], input[type=password], textarea").val("");
        form.find('input:checkbox').removeAttr('checked');
        form.find('select').prop('selectedIndex', 0);
        form.find('input[type="radio"]').prop('checked', false);

        jQuery(form).submit();
    }
</script>
