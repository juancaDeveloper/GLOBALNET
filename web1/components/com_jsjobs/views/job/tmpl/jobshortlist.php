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
?>
    
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_jsjobs/js/tinybox.js"></script>
<link media="screen" rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_jsjobs/js/style.css" />

<script type="text/javascript" language="javascript">
    function getShortlistViewByJobid(id, job_title){
        var url = "<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=jobshortlist.jobaddtoshortlist";
        jQuery.post(url,{jobid : id }, function(data){
            if(data){
                jQuery("div#jspopup_work_area").html(data);
                jQuery("div#jspopup_title").html("<?php echo JText::_('Shortlist Job');?>");
            }
        });
        jQuery("div#js_jobs_main_popup_back").show();
        jQuery("div#js_jobs_main_popup_area").slideDown('slow');
    }

    function setrating(src, newrating) {
        jQuery("#" + src).width(parseInt(newrating * 20) + '%');
    }
    function jobshortlistclose() {
        jQuery("div#js_jobs_main_popup_area").slideUp('slow');
        setTimeout(function () {
            jQuery("div#js_jobs_main_popup_back").hide();
            jQuery("div#jspopup_work_area").html('');
        }, 700);        
    }

    function saveJobShortlist(jobid, srcid , slid) {

        rating = jQuery('#rating_' + jobid).width();
        rateintvalue = parseInt(rating);
        var comments = document.getElementById("comments_" + jobid).value;
        rate = rateintvalue / 20;
        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=jobshortlist.jobshortlistsave", {jobid: jobid, comments: comments, rate: rate, slid: slid}, function (data) {
            if (data) {
                jQuery("div#js_shortlist_main_wrapper").html(data);
                jQuery("div#js_shortlist_main_wrapper").show();
            }
        });
    }
</script>