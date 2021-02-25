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

<script type="text/javascript">
    
    function getQuickViewByJobId(id,job_title){
        var Itemid = '<?php echo JRequest::getVar("Itemid"); ?>';
      jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=job.quickview",{jobid : id,Itemid:Itemid} , function(data){
        if(data){
          jQuery("div#jspopup_work_area").append(data);
          jQuery("div#jspopup_title").html("<?php echo JText::_('Job Information')?>");
        }
      });
      jQuery("div#js_jobs_main_popup_back").show();
      jQuery("div#js_jobs_main_popup_area").slideDown('slow');
    }

    function js_quick_closepopup(){
        jQuery("div#js_jobs_main_popup_area").slideUp('slow');
            setTimeout(function () {
                jQuery("div#js_jobs_main_popup_back").hide();
                jQuery("div#jspopup_work_area").html('');
            }, 700);
    }

    jQuery("body").delegate("img#jspopup_image_close", "click", function (e) {
        e.preventDefault();
        js_quick_closepopup();
    });
</script>