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

$document = JFactory::getDocument();
$document->addStyleSheet('../components/com_jsjobs/css/jsjobsrating.css');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
?>

<script type="text/javascript">
    function fj_getsubcategories(src, val) {
        jQuery.post("index.php?option=com_jsjobs&task=subcategory.listsubcategoriesForSearch", {val: val}, function (data) {
            if (data) {
                jQuery("#" + src).html(data);
            }
        });
    }

    function tabaction(jobid, action) {
        jQuery('#jobid').val(jobid);
        jQuery('#tab_action').val(action);
        jQuery('#task').val('jobapply.aappliedresumetabactions');
        jQuery('#adminForm').submit();
    }
    
    function tabsearch() {
        jQuery('div#jobsappliedresumeAS').toggle();
    }

    function jobappliedresumesearch(jobid, action) {
        jQuery('#jobid').val(jobid);
        jQuery('#tab_action').val(action); // 6 for search 
        jQuery('#task').val("jobapply.aappliedresumetabactions");
        jQuery('#adminForm').submit();
    }

    function actioncall(jobapplyid, jobid, resumeid, action) {
        jQuery('#resumedetail_'+jobapplyid).html("");
        if (action == 3) { // folder
            getfolders('resumeaction_' + jobapplyid, jobid, resumeid, jobapplyid);
        } else if (action == 4) { // comments
            getresumecomments('resumeaction_' + jobapplyid, jobapplyid);
        } else if (action == 5) { // email candidate
            mailtocandidate('resumeaction_' + jobapplyid, resumeid, jobapplyid);
        } else {
            var src = '#resumeactionmessage_' + jobapplyid;
            jQuery(src).html("Loading ...");
            jQuery.post("index.php?option=com_jsjobs&task=jobapply.saveshortlistcandiate", {jobid: jobid, resumeid: resumeid, action: action}, function (data) {
                if (data) {
                    var obj = jQuery.parseJSON(data);
                    if(obj.saved=="ok"){
                            jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                    }else{  
                        jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                    }
                    setTimeout(function () {
                        closeresumeactiondiv(src)
                    }, 3000);
                }
            });
        }

    }
    function closeresumeactiondiv(src) {
        jQuery(src).html("");
        location.reload();
    }

    function actionchangestatus(jobapplyid, jobid, resumeid, action) {
        var src = '#resumeactionmessage_' + jobapplyid;
        jQuery(src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.updateactionstatus", {jobid: jobid, resumeid: resumeid, applyid: jobapplyid, action_status: action}, function (data) {
            if (data) {
                var obj = jQuery.parseJSON(data);
                if(obj.saved=="ok"){
                        jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                }else{
                    jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                }
                setTimeout(function () {
                    closeresumeactiondiv(src)
                }, 3000);
            }
        });
    }

    function setresumeid(resumeid, action) {
        jQuery('#resumeid').val(resumeid);
        jQuery('#action').val(jQuery("#" + action).val());
        jQuery('adminForm').submit();
    }
    function saveaddtofolder(jobapplyid, jobid, resumeid) {
        var src = '#resumeactionmessage_' + jobapplyid;
        var clearhtml = '#resumeaction_' + jobapplyid;
        var folderid = document.getElementById('folderid').value;
        jQuery(src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=folderresume.saveresumefolder", {jobid: jobid, resumeid: resumeid, applyid: jobapplyid, folderid: folderid}, function (data) {
            if (data) {
                var obj = jQuery.parseJSON(data);
                jQuery(clearhtml).html("");
                if(obj.saved=="ok"){
                        jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                }else{
                    jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                }
                setTimeout(function () {
                    closeresumeactiondiv(src)
                }, 3000);
            }
        });
    }
    function saveresumecomments(jobapplyid, resumeid) {
        var src = '#resumeactionmessage_' + jobapplyid;
        var clearhtml = '#resumeaction_' + jobapplyid;
        var comments = jQuery('#comments').val();
        jQuery(src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.saveresumecomments", {jobapplyid: jobapplyid, resumeid: resumeid, comments: comments}, function (data) {
            if (data) {
                var obj = jQuery.parseJSON(data);
                jQuery(clearhtml).html("");
                if(obj.saved=="ok"){
                        jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                }else{
                    jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                }
                setTimeout(function () {
                    closeresumeactiondiv(src)
                }, 3000);
            }
        });
    }

    function closethisactiondiv(){
        jQuery('.resume_sp_actions_div').html("");
    }
    function closethisactiondiv2(){
        jQuery('.resumedetail_detail').html("");
    }

    function getfolders(src, jobid, resumeid, applyid) {
        jQuery("#" + src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=folder.getmyforlders", {jobid: jobid, resumeid: resumeid, applyid: applyid}, function (data) {
            if (data) {
                jQuery("#" + src).html(data);
            }
        });
    }
    function mailtocandidate(src, resumeid, jobapplyid) {
        jQuery("#" + src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.mailtocandidate", {resumeid: resumeid, jobapplyid: jobapplyid}, function (data) {
            if (data) {
                jQuery("#" + src).html(data);
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
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.sendtocandidate", {val: JSON.stringify(arr)}, function (data) {
            if (data) {
                var obj = jQuery.parseJSON(data);
                jQuery(clearhtml).html("");
                if(obj.saved=="ok"){
                    jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                }else{
                    jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                }
                setTimeout(function () {
                    closeresumeactiondiv(src)
                }, 3000);
            }
        });
    }

    function getresumecomments(src, jobapplyid) {
        jQuery("#" + src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.getresumecomments", {jobapplyid: jobapplyid}, function (data) {
            if (data) {
                jQuery("#" + src).html(data); //retuen value   
            }
        });
    }
    function getjobdetail(jobapplyid, jobid, resumeid) {
        
        jQuery('#resumeactionmessage_' + jobapplyid).html("");
        jQuery('#resumeaction_' + jobapplyid).html("");

        var src = '#resumedetail_' + jobapplyid;

        jQuery(src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=resume.getresumedetail", {jobid: jobid, resumeid: resumeid}, function (data) {
            if (data) {
                jQuery(src).html(data); //retuen value
            }
        });
    }

    function clsjobdetail(src) {
        jQuery("#" + src).html("");
    }
    function clsaddtofolder(src) {
        jQuery("#" + src).html("");
    }

    function setrating(src, newrating, ratingid, jobid, resumeid) {
        jQuery.post("index.php?option=com_jsjobs&task=resume.saveresumerating", {ratingid: ratingid, jobid: jobid, resumeid: resumeid, newrating: newrating}, function (data) {
            if (data == 1) {
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
</script>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <span id="heading-text"><?php echo JText::_('Job Applied Resume'); ?></span>
        </div>
        <?php 
        if(isset($this->items[0]->jobtitle)){ ?>
            <div id="js-jobs-appliedresume-title" class="js-col-xs-12 js-col-md-12">
                <span class="headtitle"><?php echo $this->items[0]->jobtitle; ?></span>
            </div>
            <?php
        } ?>

        <form action="index.php" method="post" name="adminForm" id="adminForm">
            <div id="jsjobs_appliedapplication_tab_container" class="js-col-xs-12 js-col-md-12">
                    <a class="link-hover<?php if($this->tabaction==1) echo ' a_selected';?>" onclick="tabaction(<?php echo $this->oi; ?>, '1')">
                        <span class='link-hovers' id='jsjobs_appliedapplication_tab'>
                            <?php echo JText::_('Inbox') . ' (' . $this->resumeCountPerTab['inbox'] . ')'; ?>
                        </span>
                    </a>
                    <a class="link-hover<?php if($this->tabaction==5) echo ' a_selected';?>" onclick="tabaction(<?php echo $this->oi; ?>, '5')" >
                        <span class='link-hovers' id='jsjobs_appliedapplication_tab'>
                        <?php echo JText::_('Shortlist') . ' (' . $this->resumeCountPerTab['shortlist'] . ')'; ?>
                        </span>
                    </a>
                    <a class="link-hover<?php if($this->tabaction==2) echo ' a_selected';?>" onclick="tabaction(<?php echo $this->oi; ?>, '2')" >    
                        <span class='link-hovers' id='jsjobs_appliedapplication_tab'>
                        <?php echo JText::_('Spam') . ' (' . $this->resumeCountPerTab['spam'] . ')'; ?>
                        </span>
                    </a>
                    <a class="link-hover<?php if($this->tabaction==3) echo ' a_selected';?>" onclick="tabaction(<?php echo $this->oi; ?>, '3')" > 
                        <span class='link-hovers' id='jsjobs_appliedapplication_tab'>
                              <?php echo JText::_('Hired') . ' (' . $this->resumeCountPerTab['hired'] . ')'; ?>
                        </span>
                    </a>
                    <a class="link-hover<?php if($this->tabaction==4) echo ' a_selected';?>" onclick="tabaction(<?php echo $this->oi; ?>, '4')" >    
                        <span class='link-hovers' id='jsjobs_appliedapplication_tab'>
                              <?php echo JText::_('Rejected') . ' (' . $this->resumeCountPerTab['rejected'] . ')'; ?>
                        </span>
                    </a>    
                        <?php ?>
                    <a class="link-hover<?php if($this->tabaction==6) echo ' a_selected';?>" id="appliedresume_tabnarmalsearch" onclick="tabsearch();">
                        <span class="link-hovers" id='jsjobs_appliedapplication_tab' >
                            <?php echo JText::_('Advanced Search'); ?>
                        </span>
                    </a>
                    <div id="jsjobs_appliedresume_action_allexport">
                        <?php $exportalllink = 'index.php?option=com_jsjobs&c=jsjobs&task=export.exportallresume&bd=' . $this->oi; ?>
                        <a href="<?php echo $exportalllink; ?>" >
                            <img src="components/com_jsjobs/include/images/export-all.png"  />            
                            <span id="jsjobs_appliedresume_action_allexport_text" ><?php echo JText::_('Export All'); ?></span>     
                        </a>
                    </div>
                </div>

               <!-- advace search -->
                <div id="jobsappliedresumeAS" style="display:none;">
                    <div id="jobs_applied_resume_AS">
                        <span class="jobs_search_fields"><input class="inputbox" type="text" name="title" value="<?php echo isset($this->filter_data['title']) ? $this->filter_data['title'] : ''; ?>" placeholder="<?php echo JText::_('Application Title'); ?>" size="20" maxlength="255" /></span>
                        <span class="jobs_search_fields"><input class="inputbox" type="text" name="name" value="<?php echo isset($this->filter_data['name']) ? $this->filter_data['name'] : ''; ?>" placeholder="<?php echo JText::_('Name'); ?>" size="20" maxlength="255" /></span>
                        <span class="jobs_search_fields"><input class="inputbox" type="text" name="experience" value="<?php echo isset($this->filter_data['experience']) ? $this->filter_data['experience'] : ''; ?>" placeholder="<?php echo JText::_('Experience'); ?>" size="20" maxlength="255" /></span>
                        <span class="jobs_search_fields"><?php echo $this->searchoptions['nationality']; ?></span>
                        <span class="jobs_search_fields"><?php echo $this->searchoptions['jobcategory']; ?></span>
                        <span class="jobs_search_fields"><?php echo $this->searchoptions['jobsubcategory']; ?></span>
                        <span class="jobs_search_fields"><?php echo $this->searchoptions['gender']; ?></span>
                        <span class="jobs_search_fields"><?php echo $this->searchoptions['jobtype']; ?></span>
                        <span class="jobs_search_fields"><?php echo $this->searchoptions['currency']; ?><?php echo $this->searchoptions['jobsalaryrange']; ?></span>
                        <span class="jobs_search_fields"><?php echo $this->searchoptions['heighestfinisheducation']; ?></span>
                        <span class="jobs_search_fields">
                        <input type="submit" id="button" class="button" name="submit_app" onclick="jobappliedresumesearch(<?php echo $this->oi; ?>, '6');" value="<?php echo JText::_('Resume Search'); ?>" />
                        <input type="button" id="button" class="button" name="reset" onclick="resetformthis(<?php echo $this->oi; ?>, '6');" value="<?php echo JText::_('Reset'); ?>" />
                        </span>
                        <span id="fj_subcategory" class="jsjobs_appliedresume_tab_search_data_value">
                            <!-- handler for sub cateroty -->
                        </span>
                    </div>
                </div>

            <?php if(!empty($this->items)){ ?>
                <?php
                jimport('joomla.filter.output');
                $k = 0;
                $count = 0;
                for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                    $count++;
                    $row = $this->items[$i];
                    $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=jobapply.edit&cid[]=' . $row->id);
                    $resumelink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&rd=' . $row->appid . '&oi=' . $this->oi;
                    $plink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resumeprint&rd=' . $row->appid . '&oi=' . $this->oi;
                    $exportlink = 'index.php?option=com_jsjobs&task=export.exportresume&bd=' . $this->oi . '&rd=' . $row->appid;
                    $des_id = "des_$i";
                ?>
                <div style="display:none;" id="<?php echo $des_id; ?>"><?php echo $row->cletterdescription; ?></div>
                <div id="jobs-jobapplied-wrapper" data-containerid="container_<? echo $row->jobapplyid; ?>">
                    <div id="js-top-row">
                        <div id="jsjobs-left-image" class="js-col-xs-12 js-col-md-2">
                            <?php 
                            if($row->photo == ""){
                              $logo_path = "components/com_jsjobs/include/images/Users.png";
                            }else{
                              $logo_path = "../".$this->config['data_directory']."/data/jobseeker/resume_".$row->appid."/photo/".$row->photo;
                            }
                            ?>
                            <span class="outer-circle-appliedresume"><img class="circle-appliedresume" src="<?php echo $logo_path; ?>"/></span>
                            <div class="js-col-xs-12 js-col-md-12 js-nullpadding">
                                 <a class="view-links view-resume" href="index.php?option=com_jsjobs&task=resume.edit&cid[]=<?php echo $row->appid; ?>"><img src="components/com_jsjobs/include/images/view-resume-new.png" alt="resume-link">&nbsp;<?php echo JText::_('View Resume'); ?></a>
                                 <a class="view-links view-cvletter" href="javascript:void(0);" onclick="showPopupAndSetValues('<?php echo $row->first_name . ' ' . $row->last_name;?>','<?php echo $row->clettertitle;?>','<?php echo $des_id;?>');"><img src="components/com_jsjobs/include/images/view-coverletter-new.png" alt="resume-link">&nbsp;<?php echo JText::_('View Cover Letter'); ?></a>
                            </div>
                        </div>
                        <div id="jsjobs-right-content" class="js-col-xs-12 js-col-md-10">
                            <div class="js-jobs-title-row">
                                <span class="js-col-xs-12 js-col-md-6 resume-title"><?php echo $row->applicationtitle; ?></span>
                                <span class="js-col-xs-12 js-col-md-3 resume-created"><span class="js-bold color-default"><?php echo JText::_('Apply Date'); ?>: </span><?php echo JHtml::_('date', $row->apply_date, $this->config['date_format']); ?></span>
                                <span class="js-col-xs-12 js-col-md-3 resume-stars">
                                    <?php $id = $row->jobapplyid; $percent = 0; $stars = ''; $percent = $row->rating * 20; $stars = '-small'; $html = "<div class=\"jsjobs-container" . $stars . "\"" . ( " style=\"margin-top:2px;\"" ) . "> <ul class=\"jsjobs-stars" . $stars . "\"> <li id=\"rating_" . $id . "\" class=\"current-rating\" style=\"width:" . (int) $percent . "%;\"></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',1," . (int) $row->ratingid . "," . $row->id . "," . $row->appid . ");\" title=\"" . JTEXT::_('Very Poor') . "\" class=\"one-star\">1</a></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',2," . (int) $row->ratingid . "," . $row->id . "," . $row->appid . ");\" title=\"" . JTEXT::_('Poor') . "\" class=\"two-stars\">2</a></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',3," . (int) $row->ratingid . "," . $row->id . "," . $row->appid . ");\" title=\"" . JTEXT::_('Regular') . "\" class=\"three-stars\">3</a></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',4," . (int) $row->ratingid . "," . $row->id . "," . $row->appid . ");\" title=\"" . JTEXT::_('Good') . "\" class=\"four-stars\">4</a></li> <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',5," . (int) $row->ratingid . "," . $row->id . "," . $row->appid . ");\" title=\"" . JTEXT::_('Very Good') . "\" class=\"five-stars\">5</a></li> </ul> </div> "; $html .="</small></span>";
                                        echo $html;
                                    ?>
                                </span>
                            </div>
                            <div class="js-main-area">
                                <div class="js-col-xs-12 js-col-md-12 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('Name'); ?></span>:&nbsp;<?php  echo $row->first_name . ' ' . $row->last_name; ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('salary', 3 )); ?></span>:&nbsp;<?php 
                                   echo $this->getJSModel('common')->getSalaryRangeView($row->symbol,$row->rangestart,$row->rangeend,JText::_($row->rangetype));
                                   ?>
                                </div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('total_experience', 3 )); ?>:&nbsp;</span><?php if(empty($row->exptitle)){ echo  $row->total_experience; }else{ echo JText::_($row->exptitle); } ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('desired_salary', 3 )); ?>:&nbsp;</span><?php 
                                   echo  $this->getJSModel('common')->getSalaryRangeView($row->dsymbol,$row->drangestart,$row->drangeend,JText::_($row->drangetype));
                                    ?>
                                </div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('heighestfinisheducation', 3 )); ?></span>:&nbsp;<?php echo $row->educationtitle; ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('gender', 3 )); ?></span>:&nbsp;<?php if($row->gender == 1) echo JText::_('Male'); else echo JText::_('Female'); ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('iamavailable', 3 )); ?></span>:&nbsp;<?php echo $row->iamavailable==1 ? JText::_('Yes') :  JText::_('No'); ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('address_city', 3 )); ?></span>:&nbsp;<?php echo $this->getJSModel('city')->getLocationDataForView($row->cityid);?>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('NOTE');?></span></div>
                                <?php if(isset($row->comments)){ ?>
                                <div class="js-col-xs-12 js-col-md-12 js-data color-font"><span class=""><?php echo $row->comments; ?></span></div>
                                <?php } else {?>
                                <div class="js-col-xs-12 js-col-md-12 js-data color-font"><span class=""><?php echo JText::_('Currently No Notes Available') ?></span></div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <span class="resumedetail_detail" id="resumedetail_<?php echo $row->jobapplyid; ?>"></span>
                        <span class="resume_message_print" id="resumeactionmessage_<?php echo $row->jobapplyid; ?>"></span>
                        <div class="resume_sp_actions_div" id="resumeaction_<?php echo $row->jobapplyid; ?>"></div>
                    </div>
                    <div id="bottomrightnew-appliedresume">
                        <span class="js-bottom-links" onclick="actioncall(<?php echo $row->jobapplyid; ?>,<?php echo $row->id; ?>,<?php echo $row->appid; ?>, '3');" href=""><img src="components/com_jsjobs/include/images/copy-to-folder-new.png" alt="newfolder">&nbsp;&nbsp;<?php echo JText::_('Copy To Folder');?></span>
                        <span class="js-bottom-links" onclick="actioncall(<?php echo $row->jobapplyid; ?>,<?php echo $row->id; ?>,<?php echo $row->appid; ?>, '5');" href=""><img src="components/com_jsjobs/include/images/email-candidates-new.png" alt="emailcandidate">&nbsp;&nbsp;<?php echo JText::_('Email Candidate');?></span>
                        <?php if ($this->tabaction != 5) { ?>
                            <span class="js-bottom-links" onclick="actionchangestatus(<?php echo $row->jobapplyid; ?>,<?php echo $row->id; ?>,<?php echo $row->appid; ?>, '5');" href=""><img src="components/com_jsjobs/include/images/shortlist-new.png" alt="shortlist">&nbsp;&nbsp;<?php echo JText::_('Short List');?></span>
                        <?php } ?>
                        <?php if ($this->tabaction != 2) { ?>
                            <span class="js-bottom-links" onclick="actionchangestatus(<?php echo $row->jobapplyid; ?>,<?php echo $row->id; ?>,<?php echo $row->appid; ?>, '2');" href=""><img src="components/com_jsjobs/include/images/mark-spam-new.png" alt="markspam">&nbsp;&nbsp;<?php echo JText::_('Mark Spam');?></span>
                        <?php } ?>
                        <?php if ($this->tabaction == 2) { ?>
                            <span class="js-bottom-links" onclick="actionchangestatus(<?php echo $row->jobapplyid; ?>,<?php echo $row->id; ?>,<?php echo $row->appid; ?>, '1');" href=""><img src="components/com_jsjobs/include/images/mark-spam-new.png" alt="markspam">&nbsp;&nbsp;<?php echo JText::_('Not Spam');?></span>
                        <?php } ?>
                        <?php if ($this->tabaction != 3) { ?>
                            <span class="js-bottom-links" onclick="actionchangestatus(<?php echo $row->jobapplyid; ?>,<?php echo $row->id; ?>,<?php echo $row->appid; ?>, '3');" href=""><img src="components/com_jsjobs/include/images/hired-new.png" alt="hired">&nbsp;&nbsp;<?php echo JText::_('Hired');?></span>
                        <?php } ?>
                        <?php if ($this->tabaction != 4) { ?>
                            <span class="js-bottom-links" onclick="actionchangestatus(<?php echo $row->jobapplyid; ?>,<?php echo $row->id; ?>,<?php echo $row->appid; ?>, '4');" href=""><img src="components/com_jsjobs/include/images/reject-new.png" alt="rejected">&nbsp;&nbsp;<?php echo JText::_('Rejected');?></span>
                        <?php } ?>
                        <?php $printlink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resumeprint&rd=' . $row->appid . '&oi=' . $this->oi . '&tmpl=component&print=1'; ?>
                        <a class="js-bottom-links" target="_blank" href="<?php echo $printlink;?>"><img src="components/com_jsjobs/include/images/print-new.png" alt="print">&nbsp;&nbsp;<?php echo JText::_('Print');?></a>
                        <?php $printlink = 'index.php?option=com_jsjobs&c=resume&view=report&layout=resume1&format=pdf&rd=' . $row->appid; ?>
                        <a class="js-bottom-links" target="_blank" href="<?php echo $printlink;?>"><img src="components/com_jsjobs/include/images/pdf-new.png" alt="pdf">&nbsp;&nbsp;<?php echo JText::_('Pdf');?></a>
                        <?php $exportlink = 'index.php?option=com_jsjobs&task=export.exportresume&bd=' . $row->id . '&rd=' . $row->appid; ?>
                        <a class="js-bottom-links" target="_blank" href="<?php echo $exportlink;?>"><img src="components/com_jsjobs/include/images/export-new.png" alt="export">&nbsp;&nbsp;<?php echo JText::_('Export');?></a>
                        <span class="js-bottom-links" onclick="actioncall(<?php echo $row->jobapplyid; ?>,<?php echo $row->id; ?>,<?php echo $row->appid; ?>, '4');" href=""><img src="components/com_jsjobs/include/images/add-note-new.png" alt="add-note">&nbsp;&nbsp;<?php echo JText::_('Add Notes');?></span>
                        <span class="js-bottom-links" onclick='getjobdetail(<?php echo $row->jobapplyid; ?>,<?php echo $row->id; ?>,<?php echo $row->appid; ?>);' href=""><img src="components/com_jsjobs/include/images/details-new.png" alt="details">&nbsp;&nbsp;<?php echo JText::_('Details');?></span>
                    <?php $message_link = 'index.php?option=com_jsjobs&c=message&view=message&layout=formmessage&bd=' . $this->oi . '&rd=' . $row->appid ; ?>
                <span class="js-bottom-links"><a href="<?php echo $message_link; ?>" ><img src="<?php echo JURI::root();?>components/com_jsjobs/images/messages.png" width="20" height="20" />&nbsp;&nbsp;<?php echo JText::_('Message'); ?></a></span>

                    </div>
                </div>
                <?php
                    $k = 1 - $k;
                }?>

                <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>
            <?php }else{ 
                JSJOBSlayout::getNoRecordFound(); 
            } ?>                            
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="c"  id="c" value="jobapply" />
                <input type="hidden" name="view"  id="view" value="jobapply" />
                <input type="hidden" name="layout"  id="layout" value="jobappliedresume" />
                <input type="hidden" name="task"  id="task" value="actionresume" />
                <input type="hidden" name="jobid" id="jobid" value="<?php echo $this->oi; ?>" />
                <input type="hidden" name="oi" id="oi" value="<?php echo $this->oi; ?>" />
                <input type="hidden" name="resumeid" id="resumeid" value="<?php // echo $row->appid; ?>" />
                <input type="hidden" name="id" id="id" value="" />
                <input type="hidden" name="action" id="action" value="" />
                <input type="hidden" name="action_status" id="action_status" value="" />
                <input type="hidden" name="tab_action" id="tab_action" value="" />
                <input type="hidden" name="boxchecked" value="0" />
            </form>
        </div>
    </div>
<div id="full_background" style="display:none;"></div>
<div id="popup-main-outer" style="display:none;">
<div id="popup-main" style="display:none;">
    <span class="popup-top"><span id="popup_title"></span><img id="popup_cross" src="components/com_jsjobs/include/images/popup-close.png">
    </span>
    <div class="js-field-wrapper js-row no-margin" id="popup-bottom-part">
        <span id="popup_coverletter_title"></span>
        <span id="popup_coverletter_desc"> </span>
    </div>
</div>
</div>
<div id="jsjobsfooter">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">

    function showPopupAndSetValues(name,title,desc_id){
        jQuery("div#full_background").css("display","block");
        jQuery("div#popup-main").css("display","block");
        jQuery("div#popup-main-outer").slideDown('slow');
        jQuery("div#popup-main").slideDown('slow');
        jQuery("div#popup-main-outer").css("display","block");
        jQuery("div#full_background").click(function(){closePopup();});
        jQuery("img#popup_cross").click(function(){closePopup();});
        jQuery("div#popup-main").slideDown('slow');
        jQuery("span#popup_title").html(name);
        jQuery("span#popup_coverletter_title").html(title);
        myDivObj = document.getElementById(desc_id);
        if ( myDivObj ) {
            jQuery("span#popup_coverletter_desc").html(myDivObj.innerHTML);
        }
    }

    function closePopup(){      
        jQuery("div#popup-main-outer").slideUp('slow');
        setTimeout(function () {
            jQuery("div#full_background").hide();
            jQuery("span#popup_title").html('');
            jQuery("div#popup-main").css("display","none");
            jQuery("span#popup_coverletter_title").html('');
            jQuery("span#popup_coverletter_desc").html('');
        }, 700);
    }

    function resetformthis(jobid, action){

        jQuery('#jobid').val(jobid);
        jQuery('#tab_action').val(action); // 6 for search 
        jQuery('#task').val("jobapply.aappliedresumetabactions");


        var form = jQuery('form#adminForm');
        form.find("input[type=text], input[type=email], input[type=password], textarea").val("");
        form.find('input:checkbox').removeAttr('checked');
        form.find('select').prop('selectedIndex', 0);
        form.find('input[type="radio"]').prop('checked', false);

        jQuery(form).submit();
    }


</script>
