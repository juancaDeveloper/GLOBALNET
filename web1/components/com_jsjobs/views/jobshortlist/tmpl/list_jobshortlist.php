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
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jsjobs/css/jsjobsrating.css');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
if (isset($this->userrole->rolefor)) {
    if ($this->userrole->rolefor != '') {
        if ($this->userrole->rolefor == 2) // job seeker
            $allowed = true;
        elseif ($this->userrole->rolefor == 1) {
            if ($this->config['employerview_js_controlpanel'] == 1)
                $allowed = true;
            else
                $allowed = false;
        }
    }else {
        $allowed = true;
    }
} else
    $allowed = true; // user not logined
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>

<?php
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    $cf_model = $this->getJSModel('customfields');

    ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Short Listed Jobs'); ?></span>
    <?php
    if ($allowed == true) {
        if (isset($this->shortlistedJob) AND (!empty($this->shortlistedJob))) {
            require_once( JPATH_COMPONENT.'/views/job/tmpl/tellafriend.php' );
            require_once( JPATH_COMPONENT.'/views/job/tmpl/jobapply.php' );
            require_once( JPATH_COMPONENT.'/views/job/tmpl/jobshortlist.php' );
            ?>
                <?php
                    foreach ($this->shortlistedJob as $sljob) { 
                        print_job($sljob, $this, $cf_model, 1);
                    } ?>

            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=jobshortlist&view=jobshortlist&layout=list_jobshortlist&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
            </form>
    <?php
        } else { // no result found in this category 
            $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
        }
    } else { // not allowed job posting
        $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page', 0);
    } ?>
            </div>
    <?php
}//ol
?>
 
<?php

function print_job($job, $thisjob, $cf_model ,$jobtype = 1) {
    $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(2);
    $common = JSModel::getJSModel('common');
    $_field = array();
    foreach($fieldsordering AS $field){
        if($field->showonlisting == 1){
            $_field[$field->field] = $field->fieldtitle;
        }
    }
    $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->companyaliasid);
    $link_compdetail = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $companyaliasid . '&cat=' . $job->categorytitle . '&Itemid=' . $thisjob->Itemid; 
    ?>
    <div class="jsjobs-main-wrapper-listjobshort">
         <div class="jsjobs-main-wrapper-shortjoblist"> 
            <div class="jsjobs-image-area">
                <?php 
                if(isset($_field['company'])){ ?>
                    <a href="<?php echo $link_compdetail;?>">
                        <?php
                        $imgsrc = $common->getCompanyLogo($job->companyid, $job->companylogo , $thisjob->config);
                        ?>
                        <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                    </a>
                <?php } ?>
            </div>

            <div class="jsjobs-content-shortlist-area">
                <div class="jsjobs-data-1">
                    <?php 
                    if (isset($_field['jobtitle'])) { ?>
                        <span class="jsjobs-title">
                            <?php 
                            $jobaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($job->jobaliasid);
                            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd=' . $jobaliasid . '&Itemid=' . $thisjob->Itemid; 
                            ?>
                            <a class="js_job_title" href="<?php echo $link ?>"><?php echo htmlspecialchars($job->title); ?></a>
                            <?php if ($job->isgoldjob == 1){ ?> <span class="jsjobs-gold-shortlist"><?php echo JText::_('Gold');?></span> <?php } if ($job->isfeaturedjob == 1){ ?> <span class="jsjobs-featured-shortlist"><?php echo JText::_('Featured');?></span> <?php } ?>
                        </span>
                    <?php } ?>
                    <span class="jsjobs-posted-rating-main">
                        <span class="jsjobs-posted-days">
                            <?php if ($job->jobdays == 0) echo  ': ' . JText::_('Today'); else echo htmlspecialchars($job->jobdays) . ' ' . JText::_('Days Ago'); ?>
                        </span>
                        <?php if(isset($_field['jobtype'])){ ?>
                        <span class="jsjobs-posted">
                           <?php echo JText::_($job->jobtypetitle); ?>
                        </span>                        
                        <?php } ?>
                        <span class="jsjobs-ratingjos">
                            <?php $id = $job->id; $percent = 0; $stars = ''; $percent = $job->rate * 20; $stars = '-small'; $html = "<div id=\"jsjobs_appliedresume_stars\" class=\"jsjobs-container" . $stars . "\"" . ( " style=\"float:right;\"" ) . "> <ul class=\"jsjobs-stars" . $stars . "\"> <li id=\"rating_" . $id . "\" class=\"current-rating\" style=\"width:" . (int) $percent . "%;\"></li> <li><a href=\"javascript:void(null)\" title=\"" . JTEXT::_('Very Poor') . "\" class=\"one-star\">1</a></li> <li><a href=\"javascript:void(null)\" title=\"" . JTEXT::_('Poor') . "\" class=\"two-stars\">2</a></li> <li><a href=\"javascript:void(null)\" title=\"" . JTEXT::_('Regular') . "\" class=\"three-stars\">3</a></li> <li><a href=\"javascript:void(null)\" title=\"" . JTEXT::_('Good') . "\" class=\"four-stars\">4</a></li> <li><a href=\"javascript:void(null)\" title=\"" . JTEXT::_('Very Good') . "\" class=\"five-stars\">5</a></li> </ul> </div> "; $html .="</small></span>"; echo $html; ?>
                        </span>
                    </span>
                </div>

            <div class="jsjobs-data-area-2">
                <div class="jsjobs-data-2">
                    <?php 
                    if(isset($_field['company'])){ ?>
                        <div class="jsjobs-data-2-wrapper">
                            <?php if ($thisjob->config['labelinlisting'] == '1') { ?>
                                <span class="jsjobs-data-2-title"><?php echo JText::_($_field['company']) . ": "; ?></span>
                            <?php } ?>
                            <span class="jsjobs-data-2-value"><a class="js_job_data_2_company_link" href="<?php echo $link_compdetail; ?>"><?php echo $job->companyname; ?></a></span>
                        </div>
                    <?php 
                    }
                    if(isset($_field['jobcategory'])){ ?>
                        <div class="jsjobs-data-2-wrapper">
                            <?php if ($thisjob->config['labelinlisting'] == '1') { ?>
                                <span class="jsjobs-data-2-title"><?php echo JText::_($_field['jobcategory']) . ": "; ?></span>
                            <?php } ?>
                            <span class="jsjobs-data-2-value"><?php echo htmlspecialchars(JText::_($job->categorytitle)); ?></span>
                        </div>
                    <?php
                    }
                    if(isset($_field['jobsalaryrange'])){
                        if ($job->salaryfrom) { 
                            $salary = JSModel::getJSModel('common')->getSalaryRangeView($job->currencysymbol,$job->salaryfrom,$job->salaryto,JText::_($job->salaytype),$thisjob->config['currency_align']);
                            ?>
                            <div class="jsjobs-data-2-wrapper">
                                <?php if ($thisjob->config['labelinlisting'] == '1') { ?>
                                    <span class="jsjobs-data-2-title"><?php echo JText::_($_field['jobsalaryrange']) . ": "; ?></span>
                                <?php } ?>
                                <span class="jsjobs-data-2-value"><?php echo htmlspecialchars($salary); ?></span>
                            </div>
                            <?php
                        }
                    }

                    $customfields = getCustomFieldClass()->userFieldsData( 2 , 1);
                    foreach ($customfields as $field) {
                        echo  getCustomFieldClass()->showCustomFields($field, 3 ,$job , $thisjob->config['labelinlisting']);
                    }
                    
                    if(isset($_field['noofjobs'])){
                        if ($job->noofjobs != 0) { ?>
                            <div class="jsjobs-data-2-wrapper-jobsno"><?php echo htmlspecialchars($job->noofjobs) . ' ' . JText::_('Jobs'); ?></div>
                        <?php
                        }
                    } ?>



         <div class="jsjobs-comment-wrapper" id="<?php echo 'comment' . $job->id; ?>">
        <?php echo htmlspecialchars($job->comment); ?>
        </div>
            </div>
            
        </div>
        </div>
       
    </div>
      <div class="jsjobs-main-wrapper-shortjoblist-btn">
      <div class="jsjobs-data-3">
            <div class="location-jobs-tablet">
            <?php if(isset($_field['city'])){ ?>
               <span class="jsjobs-img-locaation"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span>
                    <span class="js-job-data-location-value">
                    <?php echo $job->location; ?>        
                    </span>
                <?php
            } ?>
            </div>
                <div class="jsjobs-data-btn-tablet"> 
                <?php
                $appl_link = "";
                    if($thisjob->config['showapplybutton']==1){
                        if($job->jobapplylink == 1 && !empty($job->joblink)){
                            if(!strstr($job->joblink , 'http')){
                                $job->joblink = 'http://'.$job->joblink;
                            }  
                            $appl_link = '<a class="js_job_data_button_apply" href="'.$job->joblink.'" target=_blank" >'.JText::_('Apply Now').'</a>';
                        }elseif(!empty($thisjob->config['applybuttonredirecturl'])){
                            $appl_link = '<a class="js_job_data_button_apply" href="'.$thisjob->config['applybuttonredirecturl'].'" target="_blank">'.JText::_('Apply Now').'</a>';
                        }else{
                            $appl_link = '<a href="Javascript: void(0);" class="js_job_data_button_apply" onclick="getApplyNowByJobid('.$job->id.');" data-jobapply="jobapply" data-jobid="<?php echo $job->id; ?>" >'.JText::_("Apply Now").'</a>';
                        }
                    }
                    echo($appl_link);
                ?>
                    <?php if(JSModel::getJSModel('configurations')->getConfigValue('show_fe_tellafriend_button') == 1){ ?>
                    <a href="Javascript: void(0);" class="js_job_data_button" onclick="showtellafriend('<?php echo $job->id; ?>', '<?php echo htmlspecialchars($job->title); ?>');" ><img src="<?php echo JURI::root();?>components/com_jsjobs/images/tell-friend.png" title ="<?php echo JText::_('Tell A Friend');?>"></a>
                    <?php } ?>
                    <a  id="js_show_comment" href="#" data-for="<?php echo $job->id; ?>" class="js_job_comment js_job_data_button"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/comment.png" title ="<?php echo JText::_('Comment');?>"></a>
                    <a href="index.php?option=com_jsjobs&task=jobshortlist.deletejobshortlist&id=<?php echo $job->sljobid; ?>&Itemid=<?php echo $thisjob->Itemid; ?>&<?php echo JSession::getFormToken(); ?>=1" class="js_job_data_button"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/deleteicon.png" title ="<?php echo JText::_('Delete');?>"></a>
                </div>
            </div>
          
      </div>
    </div>
<?php } ?>

</div>

<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('a.js_job_comment').click(function (e) {
            e.preventDefault();
            var id = $(this).attr('data-for');
            $('div#comment' + id).slideToggle();
        });
    });
</script>

<div id="js_jobs_main_popup_back"></div>
<div id="js_jobs_main_popup_area">
    <div id="js_jobs_main_popup_head">
        <div id="jspopup_title"><?php echo JText::_('Apply Now'); ?></div>
        <img id="jspopup_image_close" src="<?php echo JURI::root();?>components/com_jsjobs/images/popup-close.png" />
    </div>
    <div id="jspopup_work_area"></div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("img#jspopup_image_close,div#js_jobs_main_popup_back").click(function(){
            jQuery("div#js_jobs_main_popup_area").slideUp('slow');
            setTimeout(function () {
                jQuery("div#js_jobs_main_popup_back").hide();
                jQuery("div#jspopup_work_area").html('');
            }, 700);
        });
    });
</script>
