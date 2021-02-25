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
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jsjobs/css/token-input-jsjobs.css');
$document->addStyleSheet('components/com_jsjobs/css/combobox/chosen.css');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('components/com_jsjobs/js/jquery.tokeninput.js');
$document->addScript('components/com_jsjobs/js/combobox/chosen.jquery.js');
$document->addScript('components/com_jsjobs/js/combobox/prism.js');


if ($this->config['date_format'] == 'm/d/Y')
    $dash = '/';
else
    $dash = '-';
$dateformat = $this->config['date_format'];
$firstdash = strpos($dateformat, $dash, 0);
$firstvalue = substr($dateformat, 0, $firstdash);
$firstdash = $firstdash + 1;
$seconddash = strpos($dateformat, $dash, $firstdash);
$secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
$seconddash = $seconddash + 1;
$thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
$js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
$js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;

if ($this->config['captchause'] == 0) {
    JPluginHelper::importPlugin('captcha');
    $dispatcher = JDispatcher::getInstance();
    $dispatcher->trigger('onInit', 'dynamic_recaptcha_1');
}
?>
<style type="text/css">
    #coordinatebutton{
        float:right;
    }
    #coordinatebutton .cbutton{
        border-radius: 10px 10px 10px 10px;
        background: gray;
        color:ghostwhite;
        padding:1;
        font-size: 1.08em;
    }
    #coordinatebutton .cbutton:hover{
        background:black;
        color:ghostwhite;
        font-size: 1.08em;
        padding:1;
    }
</style>
<span style="display:none" id="filesize"><?php echo JText::_('Error file size too large'); ?></span>
<span style="display:none" id="fileext"><?php echo JText::_('Error file extension mismatch'); ?></span>
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
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    ?>
    <script language="javascript">

		function checkUrl(obj) {
			if(obj.value != ''){
				if (!obj.value.match(/^http[s]?\:\/\//))
					obj.value = 'http://' + obj.value;
				}
		}
        function validate_url() {
            var value = jQuery("#validateurl").val();
            if (typeof value != 'undefined') {
				if (value != '' && value != 'http://') {
                    if (value.match(/^(http|https|ftp)\:\/\/\w+([\.\-]\w+)*\.\w{2,4}(\:\d+)*([\/\.\-\?\&\%\#]\w+)*\/?$/i) ||
                            value.match(/^mailto\:\w+([\.\-]\w+)*\@\w+([\.\-]\w+)*\.\w{2,4}$/i))
                    {
                        return true;
                    }
                    else
                    {
                        jQuery("#validateurl").addClass("invalid");
                        alert("<?php echo JText::_("Please enter correct company address"); ?>");
                        return false;
                    }
                }
                return true;
            }
            return true;
        }

        function validate_since() {
            var date_since_make = new Array();
            var split_since_value = new Array();

            f = document.adminForm;
            var returnvalue = true;
            var today = new Date();
            today.setHours(0, 0, 0, 0);

            var since_string = document.getElementById("companysince").value;
            var format_type = document.getElementById("j_dateformat").value;
            if (format_type == 'd-m-Y') {
                split_since_value = since_string.split('-');

                date_since_make['year'] = split_since_value[2];
                date_since_make['month'] = split_since_value[1];
                date_since_make['day'] = split_since_value[0];


            } else if (format_type == 'm/d/Y') {
                split_since_value = since_string.split('/');
                date_since_make['year'] = split_since_value[2];
                date_since_make['month'] = split_since_value[0];
                date_since_make['day'] = split_since_value[1];


            } else if (format_type == 'Y-m-d') {

                split_since_value = since_string.split('-');

                date_since_make['year'] = split_since_value[0];
                date_since_make['month'] = split_since_value[1];
                date_since_make['day'] = split_since_value[2];
            }
            var sincedate = new Date(date_since_make['year'], date_since_make['month'] - 1, date_since_make['day']);

            if (sincedate > today) {
                jQuery("#companysince").addClass("invalid");
                msg.push('<?php echo JText::_('Start date must be less than today'); ?>');
                returnvalue = false;
            }
            return returnvalue;
        }


        function hideShowRange(hideSrc, showSrc, showName, showVal) {
            document.getElementById(hideSrc).style.display = "none";
            document.getElementById(showSrc).style.display = "block";
            document.getElementById(showName).value = showVal;
        }

        function check_start_stop_job_publishing_dates(forcall) {
            var date_start_make = new Array();
            var date_stop_make = new Array();
            var split_start_value = new Array();
            var split_stop_value = new Array();
            var returnvalue = true;

            var start_string = document.getElementById("job_startpublishing").value;
            var stop_string = document.getElementById("job_stoppublishing").value;


            var format_type = document.getElementById("j_dateformat").value;
            if (format_type == 'd-m-Y') {
                split_start_value = start_string.split('-');

                date_start_make['year'] = split_start_value[2];
                date_start_make['month'] = split_start_value[1];
                date_start_make['day'] = split_start_value[0];

                split_stop_value = stop_string.split('-');

                date_stop_make['year'] = split_stop_value[2];
                date_stop_make['month'] = split_stop_value[1];
                date_stop_make['day'] = split_stop_value[0];

            } else if (format_type == 'm/d/Y') {
                split_start_value = start_string.split('/');
                date_start_make['year'] = split_start_value[2];
                date_start_make['month'] = split_start_value[0];
                date_start_make['day'] = split_start_value[1];

                split_stop_value = stop_string.split('/');

                date_stop_make['year'] = split_stop_value[2];
                date_stop_make['month'] = split_stop_value[0];
                date_stop_make['day'] = split_stop_value[1];

            } else if (format_type == 'Y-m-d') {

                split_start_value = start_string.split('-');

                date_start_make['year'] = split_start_value[0];
                date_start_make['month'] = split_start_value[1];
                date_start_make['day'] = split_start_value[2];

                split_stop_value = stop_string.split('-');

                date_stop_make['year'] = split_stop_value[0];
                date_stop_make['month'] = split_stop_value[1];
                date_stop_make['day'] = split_stop_value[2];

            }
            var start = new Date(date_start_make['year'], date_start_make['month'] - 1, date_start_make['day']);
            var stop = new Date(date_stop_make['year'], date_stop_make['month'] - 1, date_stop_make['day']);
            if (start >= stop) {
                if (forcall == 1) {
                    jQuery("#job_startpublishing").addClass("invalid");
                    var isedit = document.getElementById("id");
                    if (isedit.value != "" && isedit.value != 0) { // for edit case
                        alert("<?php echo JText::_("StartStart publishing date must be less than stop publishing date"); ?>");
                    } else { // for add case
                        alert("<?php echo JText::_("Start publishing date must be greater than today date"); ?>");

                    }
                } else if (forcall == 2) {
                    jQuery("#job_stoppublishing").addClass("invalid");
                    alert("<?php echo JText::_("Stop publishing date must be greater than start publishing date"); ?>");
                }
                returnvalue = false;
            }
            return returnvalue;
        }
        function validate_checkstartdate() {
            var date_start_make = new Array();
            var split_start_value = new Array();
            f = document.adminForm;
            var isedit = document.getElementById("jobid");
            if (isedit.value != "" && isedit.value != 0) {
                var return_value = check_start_stop_job_publishing_dates();
                return return_value;
            } else {
                var returnvalue = true;
                var today = new Date()
                today.setHours(0, 0, 0, 0);

                var start_string = document.getElementById("job_startpublishing").value;
                var format_type = document.getElementById("j_dateformat").value;
                if (format_type == 'd-m-Y') {
                    split_start_value = start_string.split('-');

                    date_start_make['year'] = split_start_value[2];
                    date_start_make['month'] = split_start_value[1];
                    date_start_make['day'] = split_start_value[0];


                } else if (format_type == 'm/d/Y') {
                    split_start_value = start_string.split('/');
                    date_start_make['year'] = split_start_value[2];
                    date_start_make['month'] = split_start_value[0];
                    date_start_make['day'] = split_start_value[1];


                } else if (format_type == 'Y-m-d') {

                    split_start_value = start_string.split('-');

                    date_start_make['year'] = split_start_value[0];
                    date_start_make['month'] = split_start_value[1];
                    date_start_make['day'] = split_start_value[2];
                }

                var startpublishingdate = new Date(date_start_make['year'], date_start_make['month'] - 1, date_start_make['day']);

                if (today > startpublishingdate) {
                    jQuery("#job_startpublishing").addClass("invalid");
                    var isedit = document.getElementById("id");
                    if (isedit.value != "" && isedit.value != 0) { // for edit case
                        alert("<?php echo JText::_("Start publishing date must be less than stop publishing date"); ?>");
                    } else { // for add case
                        alert("<?php echo JText::_("Start publishing date must be greater than today date"); ?>");

                    }
                    returnvalue = false;
                }
                return returnvalue;
            }
        }
        function validate_checkstopdate() {
            var return_value = check_start_stop_job_publishing_dates(2);
            return return_value;
        }


        function validate_checkagefrom() {
            var optionagefrom = document.getElementById("agefrom");
            var strUser = optionagefrom.options[optionagefrom.selectedIndex].text;
            var range_from_value = parseInt(strUser, 10);

            var optionageto = document.getElementById("ageto");
            var strUserTo = optionageto.options[optionageto.selectedIndex].text;
            var range_from_to = parseInt(strUserTo, 10);
            if (range_from_value > range_from_to) {
                jQuery("#agefrom").addClass("invalid");
                alert("<?php echo JText::_("Age from must be less than age to"); ?>");
                return false;
            } else if (range_from_value == range_from_to) {
                return true;
            }
            return true;
        }

        function validate_salaryrangefrom() {
            var optionsalaryrangefrom = document.getElementById("salaryrangefrom");
            var strUser = optionsalaryrangefrom.options[optionsalaryrangefrom.selectedIndex].text;
            var salaryrange_from_value = parseInt(strUser, 10);

            var optionsalaryrangeto = document.getElementById("salaryrangeto");
            var strUserTo = optionsalaryrangeto.options[optionsalaryrangeto.selectedIndex].text;
            var salaryrangerange_from_to = parseInt(strUserTo, 10);
            if (salaryrange_from_value > salaryrangerange_from_to) {
                jQuery("#salaryrangefrom").addClass("invalid");
                alert("<?php echo JText::_("Salary range from must be less than salary range to"); ?>");
                return false;
            } else if (salaryrange_from_value == salaryrangerange_from_to) {
                return true;
            }
            return true;

        }


        function validate_checkageto() {
            var optionagefrom = document.getElementById("agefrom");
            var strUser = optionagefrom.options[optionagefrom.selectedIndex].text;
            var range_from_value = parseInt(strUser, 10);

            var optionageto = document.getElementById("ageto");
            var strUserTo = optionageto.options[optionageto.selectedIndex].text;
            var range_from_to = parseInt(strUserTo, 10);
            if (range_from_to < range_from_value) {
                jQuery("#ageto").addClass("invalid");
                alert("<?php echo JText::_("Age to must be greater than age from"); ?>");
                return false;
            } else if (range_from_to == range_from_value) {
                return true;
            }
            return true;

        }

        function validate_salaryrangeto() {
            var optionsrangefrom_obj = document.getElementById("salaryrangefrom");
            if (typeof optionsrangefrom_obj !== 'undefined' && optionsrangefrom_obj !== null) {
                var optionsalaryrangefrom = document.getElementById("salaryrangefrom");
                var strUser = optionsalaryrangefrom.options[optionsalaryrangefrom.selectedIndex].text;
                var salaryrange_from_value = parseInt(strUser, 10);

                var optionsalaryrangeto = document.getElementById("salaryrangeto");
                var strUserTo = optionsalaryrangeto.options[optionsalaryrangeto.selectedIndex].text;
                var salaryrangerange_from_to = parseInt(strUserTo, 10);
                if (salaryrangerange_from_to < salaryrange_from_value) {
                    jQuery("#salaryrangeto").addClass("invalid");
                    alert("<?php echo JText::_("Salary range to must be greater than salary range from"); ?>");
                    return false;
                } else if (salaryrangerange_from_to == salaryrange_from_value) {
                    return true;
                }
                return true;
            }
            return true;
        }





        function hasClass(el, selector) {
            var className = " " + selector + " ";

            if ((" " + el.className + " ").replace(/[\n\t]/g, " ").indexOf(className) > -1) {
                return true;
            }
            return false;
        }

        function myValidate(f) {
            var msg = new Array();
            var returnvalue = true;
            var since_obj = document.getElementById('company-since-required');
            if (typeof since_obj !== 'undefined' && since_obj !== null) {
                var since_required = document.getElementById('company-since-required').value;
                if (since_required != '') {
                    var since_value = document.getElementById('companysince').value;
                    if (since_value == '') {
                        jQuery("#companysince").addClass("invalid");
                        msg.push('<?php echo JText::_('Please enter company since date'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var desc_obj = document.getElementById("company-description-required");
            if (typeof desc_obj !== 'undefined' && desc_obj !== null) {
                var desc_required = document.getElementById("company-description-required").value;
                if (desc_required != '') {
                    var comdescription = tinyMCE.get('companydescription').getContent();
                    if (comdescription == '') {
                        msg.push('<?php echo JText::_('Please enter company description'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }

            var logo_obj = document.getElementById('company-logo-required');
            if (typeof logo_obj !== 'undefined' && logo_obj !== null) {
                var logo_required = document.getElementById('company-logo-required').value;
                if (logo_required != '') {
                    var logo_value = document.getElementById('logo').value;
                    if (logo_value == '') {
                        var logofile_value = document.getElementById('company-logofilename').value;
                        if (logofile_value == '') {
                            msg.push('<?php echo JText::_('Please select company logo'); ?>');
                            alert(msg.join('\n'));
                            return false;
                        }
                    }
                }
            }

            var url_return = validate_url();
            if (url_return == false)
                return false;
            var call_since = jQuery("#companysince").val();
            if (typeof call_since != 'undefined') {
                var since_return = validate_since();
                if (since_return == false)
                    return false;
            }



            var startpub_required = document.getElementById('startdate-required').value;
            if (startpub_required != '') {
                var startpub_value = document.getElementById('job_startpublishing').value;
                if (startpub_value == '') {
                    jQuery("#job_startpublishing").addClass("invalid");
                    msg.push('<?php echo JText::_('Please enter job publish date'); ?>');
                    alert(msg.join('\n'));
                    return false;
                }
            }
            var stoppub_required = document.getElementById("stopdate-required");
            if (typeof stoppub_required !== 'undefined' && stoppub_required !== null) {
                var stoppub_required = document.getElementById('stopdate-required').value;
                if (stoppub_required != '') {
                    var stop_obj = document.getElementById("job_stoppublishing");
                    if (typeof stop_obj !== 'undefined' && stop_obj !== null) {
                        var stoppub_value = document.getElementById('job_stoppublishing').value;
                        if (stoppub_value == '') {
                            jQuery("#job_stoppublishing").addClass("invalid");
                            msg.push('<?php echo JText::_('Please enter job stop publish date'); ?>');
                            alert(msg.join('\n'));
                            return false;
                        }
                    }
                }
            }
            var desc_obj = document.getElementById("description-required");
            if (typeof desc_obj !== 'undefined' && desc_obj !== null) {
                var desc_required_val = document.getElementById("description-required").value;
                if (desc_required_val != '') {
                    var jobdescription = tinyMCE.get('description').getContent();
                    if (jobdescription == '') {
                        msg.push('<?php echo JText::_('Please enter job description'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var qal_obj = document.getElementById("qualification-required");
            if (typeof qal_obj !== 'undefined' && qal_obj !== null) {
                var qal_required_val = document.getElementById("qualification-required").value;
                if (qal_required_val != '') {
                    var jobqal = tinyMCE.get('qualifications').getContent();
                    if (jobqal == '') {
                        msg.push('<?php echo JText::_('Please enter job qualifications'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var pref_obj = document.getElementById("prefferdskills-required");
            if (typeof pref_obj !== 'undefined' && pref_obj !== null) {
                var pref_required_val = document.getElementById("prefferdskills-required").value;
                if (pref_required_val != '') {
                    var jobpref = tinyMCE.get('prefferdskills').getContent();
                    if (jobpref == '') {
                        msg.push('<?php echo JText::_('Please enter job preferred skills'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var agr_obj = document.getElementById("agreement-required");
            if (typeof agr_obj !== 'undefined' && agr_obj !== null) {
                var agr_required_val = document.getElementById("agreement-required").value;
                if (agr_required_val != '') {
                    var jobagr = tinyMCE.get('agreement').getContent();
                    if (jobagr == '') {
                        msg.push('<?php echo JText::_('Please enter job agreement'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var fil_obj = document.getElementById("filter-required");
            if (typeof fil_obj !== 'undefined' && fil_obj !== null) {
                var fil_required_val = document.getElementById("filter-required").value;
                if (fil_required_val != '') {
                    var atLeastOneIsChecked = jQuery("input:checked").length;
                    if (atLeastOneIsChecked == 0) {
                        msg.push('<?php echo JText::_('Please check filter apply setting'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var emailsetting_obj = document.getElementById("email-required");
            if (typeof emailsetting_obj !== 'undefined' && emailsetting_obj !== null) {
                var email_required_val = document.getElementById("email-required").value;
                if (email_required_val != '') {
                    var checkedradio = jQuery('input[name=sendemail]:radio:checked').length;
                    if (checkedradio == 0) {
                        msg.push('<?php echo JText::_('Please check email setting'); ?>');
                        alert(msg.join('\n'));
                        return false;
                    }
                }
            }
            var chkst_return = validate_checkstartdate();
            if (chkst_return == false)
                return false;
            var chkstop_return = validate_checkstopdate();
            if (chkstop_return == false)
                return false;

            var call_agefrom = jQuery("#agefrom").lenght;
            if (typeof call_agefrom != 'undefined') {
                var chkagefrom_return = validate_checkagefrom();
                if (chkagefrom_return == false)
                    return false;
            }
            var call_salaryrangefrom = jQuery("#salaryrangefrom").lenght;
            if (typeof call_salaryrangefrom != 'undefined') {
                var chksalfrom_return = validate_salaryrangefrom();
                if (chksalfrom_return == false)
                    return false;
            }
            var call_ageto = jQuery("#ageto").lenght;
            if (typeof call_ageto != 'undefined') {
                var chkageto_return = validate_checkageto();
                if (chkageto_return == false)
                    return false;
            }
            var call_salaryrangeto = jQuery("#salaryrangeto").lenght;
            if (typeof call_salaryrangeto != 'undefined') {
                var chksalto_return = validate_salaryrangeto();
                if (chksalto_return == false)
                    return false;
            }

            if (document.formvalidator.isValid(f)) {
                f.check.value = '<?php
    if (JVERSION < 3)
        echo JUtility::getToken();
    else
        echo JSession::getFormToken();
    ?>';//send token
            } else {
                msg.push('<?php echo JText::_('Some values are not acceptable, please retry'); ?>');
                alert(msg.join('\n'));
                return false;
            }
            return true;
        }

        function CheckDate() {
            //alert('date');
            f = document.adminForm;
            var returnvalue = true;
            var today = new Date()
            if ((today.getMonth() + 1) < 10)
                var tomonth = "0" + (today.getMonth() + 1);
            else
                var tomonth = (today.getMonth() + 1);

            if ((today.getDate()) < 10)
                var day = "0" + (today.getDate());
            else
                var day = (today.getDate());

            var todate = (today.getYear() + 1900) + "-" + tomonth + "-" + day;

    //alert(todate);
            if (f.startpublishing.value != "") {
                if (todate > f.startpublishing.value) {
                    alert("Please enter a valid start publishing date");
                    f.startpublishing.value = "";
                    returnvalue = false;
                }
            }
            if (f.startpublishing.value >= f.stoppublishing.value) {
                alert("Please enter a valid stop publishing date");
                f.stoppublishing.value = "";
                returnvalue = false;
            }
            return returnvalue;

        }
    </script>
<div id="js_jobs_main_wrapper">
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Company Information'); ?></span>
    <?php
    if ($this->config['visitor_can_post_job'] == 1) { // visitor can post job
        ?>
             <div class="jsjobs-folderinfo">
            <form action="index.php" method="post" name="adminForm" id="adminForm" class="jsautoz_form" enctype="multipart/form-data"  onSubmit="return myValidate(this);">
                <?php
                $customfieldobj = getCustomFieldClass();
                $i = 0; // for user field
                foreach ($this->companyfieldsordering as $field) {
                    //echo '<br> uf'.$field->field;
                    switch ($field->field) {
                        case "jobcategory":
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label  id="jobcategorymsg" for="jobcategory"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                </div>
                                <div class="fieldvalue">
                                    <?php echo $this->companylists['jobcategory']; ?>
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "name": $cname_required = ($field->required ? 'required' : '');
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label id="companynamemsg" for="companyname"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                </div>
                                <div class="fieldvalue">
                                    <input class="inputbox-required <?php echo $cname_required; ?>" type="text" name="companyname" id="companyname" size="20" maxlength="255" value="<?php if (isset($this->company)) echo $this->company->name; ?>" />
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "url":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $url_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="companyurlmsg" for="companyurl"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox <?php echo $url_required; ?> validate-url" type="text" id="validateurl" name="companyurl" size="20" maxlength="100" onblur="checkUrl(this);" value="<?php if (isset($this->company)) echo trim($this->company->url); ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "contactname": $contactname_required = ($field->required ? 'required' : '');
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label id="companycontactnamemsg" for="companycontactname"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                </div>
                                <div class="fieldvalue">
                                    <input class="inputbox <?php echo $contactname_required; ?>" type="text" name="companycontactname" id="companycontactname" size="20" maxlength="100" value="<?php if (isset($this->company)) echo $this->company->contactname; ?>" />
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "contactphone":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $contactphone_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="companycontactphonemsg" for="companycontactphone"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox <?php echo $contactphone_required; ?>" type="text" name="companycontactphone" size="20" maxlength="100" value="<?php if (isset($this->company)) echo $this->company->contactphone; ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "contactfax":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $fax_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="companyfaxmsg" for="companyfax"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox <?php echo $fax_required; ?>" type="text" name="companyfax" size="20" maxlength="100" value="<?php if (isset($this->company)) echo $this->company->companyfax; ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "contactemail": $email_required = ($field->required ? 'required' : '');
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label id="companycontactemailmsg" for="companycontactemail"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                </div>
                                <div class="fieldvalue">
                                    <input class="inputbox <?php echo $email_required; ?> validate-email" type="text" name="companycontactemail" id="companycontactemail" size="20" maxlength="100" value="<?php if (isset($this->company)) echo $this->company->contactemail; ?>" />
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "since":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $since_required = ($field->required ? 'required' : '');
                                $startdatevalue = '';
                                if (isset($this->company))
                                    $startdatevalue = JHtml::_('date', $this->company->since, $this->config['date_format']);
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>:<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php
                                        if (isset($this->company))
                                            echo JHTML::_('calendar', JHtml::_('date', $this->company->since, $this->config['date_format']), 'companysince', 'companysince', $js_dateformat, array('class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19'));
                                        else
                                            echo JHTML::_('calendar', '', 'companysince', 'companysince', $js_dateformat, array('class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19'));
                                        ?>
                                        <input type='hidden' id='company-since-required' name="company-since-required" value="<?php echo $since_required; ?>">
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "companysize":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $companysize_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="companysize" for="companysize"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox <?php echo $companysize_required; ?>" type="text" name="companysize" id="companysize" size="20" maxlength="20" value="<?php if (isset($this->company)) echo $this->company->companysize; ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "income":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $income_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="companyincomemsg" for="companyincome"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox validate-numeric <?php echo $income_required; ?>" type="text" name="companyincome" id="companyincome" size="20" maxlength="10" value="<?php if (isset($this->company)) echo $this->company->income; ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "description":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $description_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="descriptionmsg" for="description"><strong><?php echo JText::_($field->fieldtitle); ?></strong><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php
                                        $editor = JFactory::getEditor();
                                        if (isset($this->company))
                                            echo $editor->display('companydescription', $this->company->description, '100%', '100%', '60', '20', false);
                                        else
                                        echo $editor->display('companydescription', '', '100%', '100%', '60', '20', false);
                                        ?>
                                        <input type='hidden' id='company-description-required' name="company-description-required" value="<?php echo $description_required; ?>">
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "city":
                            ?>
                            <?php if ($this->config['comp_city'] == 1) { ?>
                                <?php
                                if ($field->isvisitorpublished == 1) {
                                    $city_required = ($field->required ? 'required' : '');
                                    ?>
                                    <div class="fieldwrapper">
                                        <div class="fieldtitle">
                                            <label id="companycitymsg" for="companycity"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                        </div>
                                        <div class="fieldvalue" id="company_city">
                                            <input class="inputbox <?php echo $city_required; ?>" type="text" name="companycity" id="companycity" size="40" maxlength="100" value="" />
                                            <input class="inputbox" type="hidden" name="companycityforedit" id="companycityforedit" size="40" maxlength="100" value="<?php if (isset($this->vmultiselecteditcompany)) echo $this->vmultiselecteditcompany; ?>" />
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php
                            break;
                        case "zipcode":
                            ?>
                            <?php if ($this->config['comp_zipcode'] == 1) { ?>
                                <?php
                                if ($field->isvisitorpublished == 1) {
                                    $zipcode_required = ($field->required ? 'required' : '');
                                    ?>
                                    <div class="fieldwrapper">
                                        <div class="fieldtitle">
                                            <label id="companyzipcodemsg" for="companyzipcode"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                        </div>
                                        <div class="fieldvalue">
                                            <input class="inputbox <?php echo $zipcode_required; ?>" type="text" name="companyzipcode" size="20" maxlength="100" value="<?php if (isset($this->company)) echo $this->company->zipcode; ?>" />
                                        </div>
                                    </div>				        
                                <?php } ?>
                            <?php } ?>
                            <?php
                            break;
                        case "address1":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $address1_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="companyaddress1msg" for="companyaddress1"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox <?php echo $address1_required; ?>" type="text" name="companyaddress1" size="20" maxlength="100" value="<?php if (isset($this->company)) echo $this->company->address1; ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "address2":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $address2_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="companyaddress2msg" for="companyaddress2"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox <?php echo $address2_required; ?>" type="text" name="companyaddress2" size="20" maxlength="100" value="<?php if (isset($this->company)) echo $this->company->address2; ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "logo":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $logo_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="logomsg" for="logo">	<?php echo JText::_($field->fieldtitle); ?>	<?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php
                                        if (isset($this->company)) {
                                            if ($this->company->logofilename != '') {
                                                ?>
                                                <input type='checkbox' name='companydeletelogo' value='1'><?php echo JText::_('Delete Logo File') . '[' . $this->company->logofilename . ']'; ?>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <input type="file" class="inputbox" id="logo" name="companylogo" size="20" maxlenght='30' onchange="uploadfile(this, '<?php echo $this->config['company_logofilezize']; ?>', '<?php echo $this->config['image_file_type']; ?>');"/>
                                        <br><small><?php echo JText::_('Maximum Width'); ?> : 200px)</small>
                                        <br><small><?php echo JText::_('Maximum File Size') . ' (' . $this->config['company_logofilezize']; ?>KB)</small>
                                        <input type='hidden' id='company-logo-required' name="company-logo-required" value="<?php echo $logo_required; ?>" />
                                        <input type='hidden' id='company-logofilename' value="<?php
                                        if (isset($this->company->logofilename))
                                            echo $this->company->logofilename;
                                        else
                                            echo "";
                                        ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "smalllogo":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="companysmalllogomsg" for="companysmalllogo"><?php echo JText::_($field->fieldtitle); ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php
                                        if (isset($this->company))
                                            if ($this->company->smalllogofilename != '') {
                                                ?>
                                                <input type='checkbox' name='companydeletesmalllogo' value='1'><?php echo JText::_('Delete Small Logo') . '[' . $this->company->smalllogofilename . ']'; ?>
                                            <?php } ?>
                                        <input type="file" class="inputbox" name="companysmalllogo" size="20" maxlenght='30'/>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "aboutcompany":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="companyaboutcompanymsg" for="companyaboutcompany"><?php echo JText::_($field->fieldtitle); ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php
                                        if (isset($this->company))
                                            if ($this->company->aboutcompanyfilename != '') {
                                                ?>
                                                <input type='checkbox' name='companydeleteaboutcompany' value='1'><?php echo JText::_('Delete About Company File') . '[' . $this->company->aboutcompanyfilename . ']'; ?>
                                            <?php } ?>
                                        <input type="file" class="inputbox" name="companyaboutcompany" size="20" maxlenght='30'/>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        default:
                            $params = NULL;
                            $id = NULL;
                            if(isset($this->company)){
                                $id = $this->company->id; 
                                $params = $this->company->params; 
                            }
                            $array = $customfieldobj->formCustomFields($field , $id , $params , 'f_company');
                                $var = '
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="address1msg" for="'.$array['lable'].'"> '.JText::_($array['title']).'</label>';
                                        if ($field->required == 1) {
                                            $var .= '&nbsp;<font color="red">*</font>';
                                        }
                                    $var .= '</div>
                                    <div class="fieldvalue">
                                        '.$array['value'].'
                                    </div>
                                </div>';
                                echo $var;
                        break;   
                    }
                }
                echo '<input type="hidden" id="companyuserfields_total" name="companyuserfields_total"  value="' . $i . '"  />';
                ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('Job Information'); ?></span>
                <?php
                if (isset($this->company)) {
                    if (($this->company->created == '0000-00-00 00:00:00') || ($this->company->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $this->company->created;
                } else
                    $curdate = date('Y-m-d H:i:s');
                ?>
                <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="uid" value="0" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="savejobvisitor" />
                <input type="hidden" name="c" value="job" />

                <input type="hidden" name="check" value="" />
                <?php if (!empty($this->companypackagedetail)) echo '<input type="hidden" name="packageid" value="' . $this->companypackagedetail[0] . '" />'; ?>
                <?php if (!empty($this->companypackagedetail)) echo '<input type="hidden" name="paymenthistoryid" value="' . $this->companypackagedetail[1] . '" />'; ?>

                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                <input type="hidden" name="companyid" value="<?php if (isset($this->company)) echo $this->company->id; ?>" />
                <?php
                $i = 0;
                foreach ($this->fieldsordering as $field) {
                    //echo '<br> uf'.$field->field;
                    switch ($field->field) {
                        case "jobtitle": $title_required = ($field->required ? 'required' : '');
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label id="titlemsg" for="title"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                </div>
                                <div class="fieldvalue">
                                    <input class="inputbox <?php echo $title_required; ?>" type="text" name="title" id="title" size="20" maxlength="255" value="<?php if (isset($this->job)) echo $this->job->title; ?>" />
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "jobcategory":
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                </div>
                                <div class="fieldvalue">
                                    <?php echo $this->lists['jobcategory']; ?>
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "subcategory":
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                </div>
                                <div class="fieldvalue" id="fj_subcategory">
                                    <?php echo $this->lists['subcategory']; ?>
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "jobtype":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php echo $this->lists['jobtype']; ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "jobstatus":
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                </div>
                                <div class="fieldvalue">
                                    <?php echo $this->lists['jobstatus']; ?>
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "jobshift":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php echo $this->lists['shift']; ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "jobsalaryrange":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php echo $this->lists['currencyid']; ?>&nbsp;&nbsp;&nbsp;
                                        <?php echo $this->lists['salaryrangefrom']; ?>&nbsp;&nbsp;&nbsp;
                                        <?php echo $this->lists['salaryrangeto']; ?>&nbsp;&nbsp;&nbsp;
                                        <?php echo $this->lists['salaryrangetypes']; ?>&nbsp;&nbsp;&nbsp;
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "heighesteducation":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                    </div>
                                    <div class="fieldvalue">
                                            <?php
                                            if (isset($this->job))
                                                $iseducationminimax = $this->job->iseducationminimax;
                                            else
                                                $iseducationminimax = 1;
                                            if ($iseducationminimax == 1) {
                                                $educationminimaxdivstyle = "display:block;";
                                                $educationrangedivstyle = "display:block;";
                                            } else {
                                                $educationminimaxdivstyle = "display:block";
                                                $educationrangedivstyle = "display:block;";
                                            }
                                            ?>
                                            <input type="hidden" name="iseducationminimax" id="iseducationminimax" value="<?php echo $iseducationminimax; ?>">
                                            <div id="educationminimaxdiv" style="<?php echo $educationminimaxdivstyle; ?>">
                                                <span class="jsjobs-cbobox"><?php echo $this->lists['educationminimax']; ?></span>
                                                <span class="jsjobs-cbobox"><?php echo $this->lists['education']; ?></span>
                                                <a  onclick="hideShowRange('educationminimaxdiv', 'educationrangediv', 'iseducationminimax', 0);" style="cursor:pointer;"><?php echo JText::_('Specify Range'); ?></a>
                                            </div>
                                            <div id="educationrangediv" data-jquery="hideit" style="<?php echo $educationrangedivstyle; ?>">
                                               <span class="jsjobs-cbobox"> <?php echo $this->lists['minimumeducationrange']; ?></span>
                                               <span class="jsjobs-cbobox"> <?php echo $this->lists['maximumeducationrange']; ?></span>
                                               <a onclick="hideShowRange('educationrangediv', 'educationminimaxdiv', 'iseducationminimax', 1);" style="cursor:pointer;margin:0 10px 0 0;"><?php echo JText::_('Cancel Range'); ?></a>
                                            </div>
                                        </div>
                                </div>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="degreetitlesmsg" for="degreetitle"><?php echo JText::_($field->fieldtitle); ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input  type="text" name="degreetitle" id="degreetitle" size="20" maxlength="40" value="<?php if (isset($this->job)) echo $this->job->degreetitle; ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "noofjobs":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $noofjob_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="noofjobsmsg" for="noofjobs"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox  <?php echo $noofjob_required; ?> validate-numeric" type="text" name="noofjobs" id="noofjobs" size="10" maxlength="10" value="<?php if (isset($this->job)) echo $this->job->noofjobs; ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>	
                            <?php
                            break;
                        case "experience":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="experiencesmsg" for="experience"><?php echo JText::_($field->fieldtitle); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                    </div>
                                    <div class="fieldvalue"> 
                                            
                                            <?php
                                            if (isset($this->job))
                                                $isexperienceminimax = $this->job->isexperienceminimax;
                                            else
                                                $isexperienceminimax = 1;
                                            if ($isexperienceminimax == 1) {
                                                $experienceminimaxdivstyle = "display:block;";
                                                $experiencerangedivstyle = "display:block;";
                                            } else {
                                                $experienceminimaxdivstyle = "display:block;";
                                                $experiencerangedivstyle = "display:block;";
                                            }
                                            ?>
                                            
                                            <input type="hidden" name="isexperienceminimax" id="isexperienceminimax" value="<?php echo $isexperienceminimax; ?>">
                                             
                                            <div id="experienceminimaxdiv" style="<?php echo $experienceminimaxdivstyle; ?>">
                                               <span  class="jsjobs-cbobox"> <?php echo $this->lists['experienceminimax']; ?></span>
                                               <span  class="jsjobs-cbobox"> <?php echo $this->lists['experience']; ?></span>
                                                <a  onclick="hideShowRange('experienceminimaxdiv', 'experiencerangediv', 'isexperienceminimax', 0);" style="cursor:pointer;"><?php echo JText::_('Specify Range'); ?></a>
                                            </div> 
                                              
                                              
                                            <div id="experiencerangediv" data-jquery="hideit" style="<?php echo $experiencerangedivstyle; ?>">
                                                <span  class="jsjobs-cbobox"><?php echo $this->lists['minimumexperiencerange']; ?></span>
                                                <span  class="jsjobs-cbobox"><?php echo $this->lists['maximumexperiencerange']; ?></span>
                                                <a onclick="hideShowRange('experiencerangediv', 'experienceminimaxdiv', 'isexperienceminimax', 1);" style="cursor:pointer;"><?php echo JText::_('Cancel Range'); ?></a>
                                            </div>
                                            <span style="float:left; width:100%; display:inline-block;">
                                               <input class="" type="text" name="experiencetext" id="experiencetext" size="30" maxlength="150" value="<?php if (isset($this->job)) echo $this->job->experiencetext; ?>" />
                                               <span> <?php echo JText::_('If Any Other Experience'); ?></span>
                                            </span>
                                        </div>
                                     
                                </div>
                                

                                		        
                            <?php } ?>
                            <?php
                            break;
                        case "duration":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $duration_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="durationmsg" for="duration"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox <?php echo $duration_required; ?>" type="text" name="duration" id="duration" size="10" maxlength="15" value="<?php if (isset($this->job)) echo $this->job->duration; ?>" />
                                        <?php echo JText::_('I.e. 18 Months Or 3 Years'); ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "zipcode":
                                ?>
                                <?php
                                if ($field->isvisitorpublished == 1) {
                                    $zipcode_required = ($field->required ? 'required' : '');
                                    ?>
                                    <div class="fieldwrapper">
                                        <div class="fieldtitle">
                                            <label id="zipcodemsg" for="zipcode"><?php echo JText::_($field->fieldtitle); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                        </div>
                                        <div class="fieldvalue">
                                            <input class="inputbox-required <?php echo $zipcode_required; ?>" type="text" name="zipcode" id="zipcode" size="10" maxlength="25" value="<?php if (isset($this->job)) echo $this->job->zipcode; ?>" />
                                        </div>
                                    </div>                      
                                <?php } ?>
                                <?php
                                break;
                        case "startpublishing":
                            ?>
                            <?php
                            $startpub_required = ($field->required ? 'required' : '');
                            $startdatevalue = '';
                            if (isset($this->job))
                                $startdatevalue = JHtml::_('date', $this->job->startpublishing, $this->config['date_format']);
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label id="startpublishingmsg" for="startpublishing"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                </div>
                                <div class="fieldvalue">
                                    <?php
                                    if (isset($this->job))
										echo JHTML::_('calendar', JHtml::_('date', $this->job->startpublishing, $this->config['date_format'],true, true), 'startpublishing', 'job_startpublishing', $js_dateformat, array('class' => 'inputbox validate-checkstartdate', 'size' => '10', 'maxlength' => '19', 'readonly' => 'readonly'));
                                    else
                                        echo JHTML::_('calendar', '', 'startpublishing', 'job_startpublishing', $js_dateformat, array('class' => 'inputbox required validate-checkstartdate', 'size' => '10', 'maxlength' => '19'));
                                    ?>
                                    <input type='hidden' id='startdate-required' name="startdate-required" value="<?php echo $startpub_required; ?>">
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "stoppublishing":
                            ?>
                            <?php
                            $stoppublish_required = ($field->required ? 'required' : '');
                            $stopdatevalue = '';
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label id="stoppublishingmsg" for="stoppublishing"><?php echo JText::_($field->fieldtitle); ?> <?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                </div>
                                <div class="fieldvalue">
                                    <?php
                                    if (isset($this->job->stoppublishing))
										echo JHTML::_('calendar', JHtml::_('date', $this->job->stoppublishing, $this->config['date_format'],true, true), 'stoppublishing', 'job_stoppublishing', $js_dateformat, array('class' => 'inputbox required validate-checkstopdate', 'size' => '10', 'maxlength' => '19'));
                                    else
                                        echo JHTML::_('calendar', '', 'stoppublishing', 'job_stoppublishing', $js_dateformat, array('class' => 'inputbox required validate-checkstopdate', 'size' => '10', 'maxlength' => '19'));
                                    ?>
                                    <input type='hidden' id='stopdate-required' name="stopdate-required" value="<?php echo $stoppublish_required; ?>">
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "age":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="agefrommsg" for="agefrom"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php echo $this->lists['agefrom']; ?>&nbsp;&nbsp;&nbsp;
                                        <?php echo $this->lists['ageto']; ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "gender":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="gendermsg" for="gender"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) echo '&nbsp;<font color="red">*</font>'; ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php echo $this->lists['gender']; ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "careerlevel":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="careerlevelmsg" for="careerlevel"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php echo $this->lists['careerlevel']; ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "workpermit":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="workpermitmsg" for="workpermit"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php echo $this->lists['workpermit']; ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "requiredtravel":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="requiredtravelmsg" for="requiredtravel"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php echo $this->lists['requiredtravel']; ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "description": $des_required = ($field->required ? 'required' : '');
                            ?>
                            <div class="fieldwrapper">
                                <div class="fieldtitle">
                                    <label id="descriptionmsg" for="description"><strong><?php echo JText::_($field->fieldtitle); ?></strong><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                </div>
                                <div class="fieldvalue">
                                    <?php
                                    if ($this->config['job_editor'] == 1) {
                                        $editor = JFactory::getEditor();
                                        if (isset($this->job))
                                            echo $editor->display('description', $this->job->description, '100%', '100%', '60', '20', false);
                                        else
                                            echo $editor->display('description', '', '100%', '100%', '60', '20', false);
                                        ?>
                                        <input type='hidden' id='description-required' name="description-required" value="<?php echo $des_required; ?>">
                                    <?php }else { ?>
                                        <textarea class="inputbox <?php echo $des_required; ?>" name="description" id="description" cols="60" rows="5"><?php if (isset($this->job)) echo $this->job->description; ?></textarea></td>
                                    <?php } ?>
                                </div>
                            </div>				        
                            <?php
                            break;
                        case "agreement":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $agr_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="agreementmsg" for="agreement"><strong><?php echo JText::_($field->fieldtitle); ?></strong><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php
                                        if ($this->config['job_editor'] == 1) {
                                            $editor = JFactory::getEditor();
                                            if (isset($this->job))
                                                echo $editor->display('agreement', $this->job->agreement, '100%', '100%', '60', '20', false);
                                            else
                                                echo $editor->display('agreement', '', '100%', '100%', '60', '20', false);
                                            ?>
                                            <input type='hidden' id='agreement-required' name="agreement-required" value="<?php echo $agr_required; ?>">
                                        <?php }else { ?>
                                            <textarea class="inputbox <?php echo $agr_required; ?>" name="agreement" id="agreement" cols="60" rows="5"><?php if (isset($this->job)) echo $this->job->agreement; ?></textarea>
                                        <?php } ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "qualifications":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $qal_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="qualificationsmsg" for="qualifications"><strong><?php echo JText::_($field->fieldtitle); ?></strong><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php
                                        if ($this->config['job_editor'] == 1) {
                                            $editor = JFactory::getEditor();
                                            if (isset($this->job))
                                                echo $editor->display('qualifications', $this->job->qualifications, '100%', '100%', '60', '20', false);
                                            else
                                                echo $editor->display('qualifications', '', '100%', '100%', '60', '20', false);
                                            ?>
                                            <input type='hidden' id='qualification-required' name="qualification-required" value="<?php echo $qal_required; ?>">
                                        <?php }else { ?>
                                            <textarea class="inputbox <?php echo $qal_required; ?>" name="qualifications" id="qualifications" cols="60" rows="5"><?php if (isset($this->job)) echo $this->job->qualifications; ?></textarea>
                                        <?php } ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "prefferdskills": $pref_required = ($field->required ? 'required' : '');
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="prefferdskillsmsg" for="prefferdskills"><strong><?php echo JText::_($field->fieldtitle); ?></strong><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <?php
                                        if ($this->config['job_editor'] == 1) {
                                            $editor = JFactory::getEditor();
                                            if (isset($this->job))
                                                echo $editor->display('prefferdskills', $this->job->prefferdskills, '100%', '100%', '60', '20', false);
                                            else
                                                echo $editor->display('prefferdskills', '', '100%', '100%', '60', '20', false);
                                            ?>
                                            <input type='hidden' id='prefferdskills-required' name="prefferdskills-required" value="<?php echo $pref_required; ?>">
                                        <?php }else { ?>
                                            <textarea class="inputbox <?php echo $pref_required; ?>" name="prefferdskills" id="prefferdskills" cols="60" rows="5"><?php if (isset($this->job)) echo $this->job->prefferdskills; ?></textarea>
                                        <?php } ?>
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "city":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $city_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="citymsg" for="city"><?php echo JText::_($field->fieldtitle); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                    </div>
                                    <div class="fieldvalue" id="job_city">
                                        <input class="inputbox <?php echo $city_required; ?>" type="text" name="city" id="city" size="40" maxlength="100" value="" />
                                        <input class="inputbox" type="hidden" name="citynameforedit" id="citynameforedit" size="40" maxlength="100" value="<?php if (isset($this->vmultiselecteditjob)) echo $this->vmultiselecteditjob; ?>" />
                                    </div>
                                </div>				        
                            <?php } ?>
                            <?php
                            break;
                        case "metadescription":
                            if ($field->isvisitorpublished == 1) {
                                $mdes_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="metadescriptionmsg" for="metadescription"><?php echo JText::_($field->fieldtitle); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                    </div>
                                    <div class="fieldvalue">
                                        <textarea cols="25" rows="5" class="inputbox <?php echo $mdes_required; ?> " name="metadescription" size="20" id="metadescription" ><?php if (isset($this->job)) echo $this->job->metadescription; ?></textarea>
                                    </div>
                                </div>				        
                            <?php } ?>	  
                            <?php
                            break;
                        case "metakeywords":
                            if ($field->isvisitorpublished == 1) {
                                $mkyw_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="metakeywordsmsg" for="metakeywords"><?php echo JText::_($field->fieldtitle); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                    </div>
                                    <div class="fieldvalue">
                                        <textarea cols="25" rows="5" class="inputbox <?php echo $mkyw_required; ?>" name="metakeywords" size="20" id="metakeywords" ><?php if (isset($this->job)) echo $this->job->metakeywords; ?></textarea>
                                    </div>
                                </div>				        
                            <?php } ?>	  
                            <?php
                            break;
                        case "video":
                            ?>
                            <?php
                            if ($field->isvisitorpublished == 1) {
                                $video_required = ($field->required ? 'required' : '');
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="videomsg" for="video"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <input class="inputbox <?php echo $video_required; ?>" type="text" name="video" id="video" size="20" maxlength="255" value="<?php if (isset($this->job)) echo $this->job->video; ?>" /><?php echo JText::_('Youtube Video Id'); ?>
                                    </div>
                                </div>				        
                            <?php } ?>  
                            <?php
                            break;
                        case "map":
                            ?>
                            <?php if ($field->isvisitorpublished == 1) { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="mapmsg" for="map"><?php echo JText::_($field->fieldtitle); ?></label>
                                    </div>
                                    <div class="fieldvalue">
                                        <div id="map"><div id="map_container"></div></div>
                                        <span class="jsjobs-mapvalue">
                                        
                                        <span class="jsjobs-latitude">
                                         <?php echo JText::_('Latitude'); ?>
                                        <input type="text" id="latitude" name="latitude" value="<?php //if (isset($this->job)) echo $this->job->latitude; ?>"/>
                                        </span>
                                        <span class="jsjobs-longitude">
                                        <?php echo JText::_('Longitude'); ?>
                                        <input type="text" id="longitude" name="longitude" value="<?php //if (isset($this->job)) echo $this->job->longitude; ?>"/>
                                        </span>
                                        </span>
                                    </div>
                                </div>				        
                            <?php } ?>	
                            <?php
                            break;
                        default:
                            $params = NULL;
                            $id = NULL;
                            if(isset($this->job)){
                                $id = $this->job->id; 
                                $params = $this->job->params; 
                            }
                            $array = $customfieldobj->formCustomFields($field , $id , $params , 'f_company');
                            if(is_array($array)){
                                $var = '
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="address1msg" for="'.$array['lable'].'"> '.JText::_($array['title']).'</label>';
                                        if ($field->required == 1) {
                                            $var .= '&nbsp;<font color="red">*</font>';
                                        }
                                    $var .= '</div>
                                    <div class="fieldvalue">
                                        '.$array['value'].'
                                    </div>
                                </div>';
                                echo $var;
                            }
                        break;
                    }
                }
                echo '<input type="hidden" id="userfields_total" name="userfields_total"  value="' . $i . '"  />';
                ?>
                <?php
                foreach ($this->fieldsordering as $field) {
                    switch ($field->field) {
                        case "filter":
                            if ($field->isvisitorpublished) {
                                $filter_required = ($field->required ? 'required' : '');
                                ?><div class="fieldwrapper">
                                        <div class="fieldtitle">
                                            <label id="filter" for="filter"><?php echo JText::_($field->fieldtitle); ?><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?></label>
                                        </div>
                                        <div class="fieldvalue-check">
                                            <div id="resumeapplyfilter">
                                                <span class="jsjobs-filter"><?php echo JText::_('Applied resume will be filtered on given criteria'); ?></span>
                                                <span class="jsjobs-maim-wrp-btn">
                                                   <span class="jsjobs-checkbox-gender">
                                                      
                                                         <span class="jsjobs-check-box"> 
                                                           <input class="checkbox-gender" type='checkbox' name='raf_gender' id='raf_gender' value='1' <?php
                                                         if (isset($this->job)) {
                                                            echo ($this->job->raf_gender == 1) ? "checked='checked'" : "";
                                                             }
                                                          ?> />
                                                          </span>
                                                       <span class="jsjobs-label-gender">
                                                        <label for="raf_gender"><?php echo JText::_('Gender'); ?></label>
                                                       </span>
                                                      
                                                </span>
                                                        <span class="jsjobs-checkbox-location">
                                                         <span class="jsjobs-checkbox">
                                                          <span class="jsjobs-check-box">
                                                        <input type='checkbox' name='raf_location' id='raf_location' value='1' <?php
                                                         if (isset($this->job)) {
                                                            echo ($this->job->raf_location == 1) ? "checked='checked'" : "";
                                                                 }
                                                          ?> />
                                                           </span> 
                                                            <span class="jsjobs-label-gender">
                                                          <label for="raf_location"><?php echo JText::_('Location'); ?></label>
                                                          </span>
                                                          </span>
                                                        </span>
                                                                    <span class="jsjobs-checkbox-eduction"> 
                                                                    <span class="jsjobs-checkbox"> 
                                                                     <span  class="jsjobs-check-box">
                                                                    <input type='checkbox' name='raf_education' id='raf_education' value='1' <?php
                                                                        if (isset($this->job)) {
                                                                            echo ($this->job->raf_education == 1) ? "checked='checked'" : "";
                                                                        }
                                                                        ?> />
                                                                        </span>
                                                                        <span class="jsjobs-label-gender">
                                                                    <label for="raf_education"><?php echo JText::_('Education'); ?></label>
                                                                    </span>
                                                                     </span>
                                                                     </span>
                                                                      <span class="jsjobs-checkbox-eduction">
                                                                      <span class="jsjobs-checkbox">
                                                                      <span class="jsjobs-check-box">
                                                                    <input type='checkbox' name='raf_category' id='raf_category' value='1' <?php
                                                                        if (isset($this->job)) {
                                                                            echo ($this->job->raf_category == 1) ? "checked='checked'" : "";
                                                                        }
                                                                        ?> />
                                                                        </span>
                                                                        <span class="jsjobs-label-gender">
                                                                        <label for="raf_category"><?php echo JText::_('Category'); ?></label>
                                                                        </span>
                                                                        </span>
                                                                        </span>
                                                                     <span class="jsjobs-checkbox-subcategory">
                                                                      <span class="jsjobs-checkbox">
                                                                      <span class="jsjobs-check-box">
                                                                    <input type='checkbox' name='raf_subcategory' id='raf_subcategory' value='1' <?php
                                                                        if (isset($this->job)) {
                                                                            echo ($this->job->raf_subcategory == 1) ? "checked='checked'" : "";
                                                                        }
                                                                        ?> />
                                                                        </span>
                                                                        <span class="jsjobs-label-gender">
                                                                        <label for="raf_subcategory"><?php echo JText::_('Sub Category'); ?></label> 
                                                                       </span>
                                                                        </span>
                                                                        </span>
                                                                    
                                                               
                                                             
                                                     
                                                   </span>
                                            </div>
                                            <input type='hidden' id='filter-required' name="filter-required" value="<?php echo $filter_required; ?>">
                                        </div>
                                    </div>     
                            <?php } ?>	  
                            <?php break; ?>
                        <?php
                        case "emailsetting":
                            if ($field->isvisitorpublished) {
                                $email_required = ($field->required ? 'required' : '');
                                ?>
                               <div class="fieldwrapper">
                                        <div class="fieldtitle">
                                            <label id="filter" for="filter"><?php echo JText::_($field->fieldtitle); ?></label><?php if ($field->required == 1) { ?> &nbsp;<font color="red">*</font><?php } ?>
                                        </div>
                                        <div class="fieldvalue-radio-button">
                                            <div id="resumeapplyfilter">
                                                                <span id="jobsapplyalertsettingheading"><?php echo JText::_('Job apply alert e-mail setting'); ?></span>
                                                                       <span class="jsjobs-radio-email-me">
                                                                        <span class="jsjobs-radio-btn">
                                                                        <input type="radio" name="sendemail" value="0" class="radio" <?php
                                                                           if (isset($this->job)) {
                                                                                    echo ($this->job->sendemail == 0) ? "checked='checked'" : "";
                                                                              }
                                                                              ?> />  
                                                                         </span> 
                                                                         <span class="jsjobs-radio-title">                      
                                                                        <label for="sendemail"><?php echo JText::_('Do not email me'); ?></label>
                                                                        </span>
                                                                        </span>  
                                                                        <span id="formjobemailtext">
                                                                        <?php echo JText::_("No job applied notification will be emailed to you") . ", " . JText::_("you can only check your workspace for new applicants"); ?>
                                                                        </span> 
                                                                         <span class="jsjobs-radio-email-me">
                                                                         <span class="jsjobs-radio-btn">
                                                                        <input type="radio" name="sendemail" value="1" class="radio" <?php
                                                                          if (isset($this->job)) {
                                                                              echo ($this->job->sendemail == 1) ? "checked='checked'" : "";
                                                                                   }
                                                                              ?> />
                                                                         </span> 
                                                                          <span class="jsjobs-radio-title">                          
                                                                        <label for="sendemail"><?php echo JText::_('Email me resume of new applicant'); ?></label>
                                                                        </span>
                                                                        </span>
                                                                        <span id="formjobemailtext">
                                                                        <?php echo JText::_("Job applied notification will be emailed to you with the resume of the applicant").', '.JText::_("you can also check your workspace"); ?>
                                                                        </span>
                                                                        <span class="jsjobs-radio-email-me">
                                                                        <span class="jsjobs-radio-btn">
                                                                        <input type="radio" name="sendemail" value="2" class="radio" <?php
                                                                             if (isset($this->job)) {
                                                                                  echo ($this->job->sendemail == 2) ? "checked='checked'" : "";
                                                                                }else{
                                                                                   echo "checked='checked'";
                                                                                   }
                                                                              ?> /> 
                                                                        </span> 
                                                                          <span class="jsjobs-radio-title">                             
                                                                        <label for="sendemail"><?php echo JText::_('Email me the resume and resume attachments of applicant'); ?></label>
                                                                        </span>
                                                                        </span>
                                                                        <span id="formjobemailtext">
                                                                            <?php echo JText::_("Job applied notification will be emailed to you with the resume and attachments of the applicant").', '.JText::_("you can also check your workspace"); ?>
                                                                        </span>
                                                    <input type='hidden' id='email-required' name="email-required" value="<?php echo $email_required; ?>">  
                                            </div>
                                        </div>
                                    </div>           
                            <?php } ?>	  
                            <?php break; ?>
                    <?php } ?>			
                <?php } ?>			
                <?php
                if ($this->config['job_captcha'] == 1) {
                    if ($this->config['captchause'] == 1) {
                        ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <label id="captchamsg" for="captcha"><?php echo JText::_('Captcha'); ?></label><?php
                                if ($field->required == 1) {
                                    echo '&nbsp;
                                                                        <font color = "red">*</font>';
                                }
                                ?>
                            </div>
                            <div class="fieldvalue">
                        <?php echo $this->captcha; ?>
                            </div>
                        </div>				        
            <?php } else {
                ?>
                        <div class="fieldwrapper">
                            <div class="fieldtitle">
                                <label id="captchamsg" for="captcha"><?php echo JText::_('Captcha'); ?></label><?php
                if ($field->required == 1) {
                    echo '&nbsp;
                                                                        <font color = "red">*</font>';
                }
                ?>
                            </div>
                            <div class="fieldvalue">
                                <?php
                                    JPluginHelper::importPlugin('captcha');
                                    $dispatcher = JDispatcher::getInstance();
                                    $dispatcher->trigger('onInit', array('dynamic_recaptcha_1'));
                                    $recaptcha = $dispatcher->trigger('onDisplay', array(null, 'dynamic_recaptcha_1' , 'class=""'));
                                    echo isset($recaptcha[0]) ? $recaptcha[0] : '';     
                                ?>
                            </div>
                        </div>				        
            <?php
            }
        }
        ?>
                
                <div class="fieldwrapper-btn">
                    <div class="jsjobs-folder-info-btn">
                        <sapn class="jsjobs-folder-btn">
                            <input id="button" class="button jsjobs_button" type="submit" name="submit_app" value="<?php echo JText::_('Save Job'); ?>" />
                        </sapn>
                    </div>
                </div>				        

                <?php
                if (isset($this->job)) {
                    if (($this->job->created == '0000-00-00 00:00:00') || ($this->job->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $this->job->created;
                } else
                    $curdate = date('Y-m-d H:i:s');
                ?>
                <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="jobid" id="jobid" value="<?php if (isset($this->job)) echo $this->job->jobid; ?>" />
                <input type="hidden" name="view" value="jobposting" />
                <input type="hidden" name="layout" value="viewjob" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="packageid" value="<?php echo $this->packagedetail[0]; ?>" />
                <input type="hidden" name="paymenthistoryid" value="<?php echo $this->packagedetail[1]; ?>" />
                <input type="hidden" name="enforcestoppublishjob" value="<?php echo $this->packagedetail[2]; ?>" />
                <input type="hidden" name="enforcestoppublishjobvalue" value="<?php echo $this->packagedetail[3]; ?>" />
                <input type="hidden" name="enforcestoppublishjobtype" value="<?php echo $this->packagedetail[4]; ?>" />

                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                <input type="hidden" name="id" value="<?php if (isset($this->job)) echo $this->job->id; ?>" />
                <input type="hidden" name="j_dateformat" id="j_dateformat" value="<?php echo $js_scriptdateformat; ?>" />

                <input type="hidden" name="default_longitude" id="default_longitude" value="<?php echo $this->config['default_longitude']; ?>" />
                <input type="hidden" name="default_latitude" id="default_latitude" value="<?php echo $this->config['default_latitude']; ?>" />
                <input type="hidden" id="edit_latitude" value="<?php if (isset($this->job)) echo $this->job->latitude; ?>" />
                <input type="hidden" id="edit_longitude" value="<?php if (isset($this->job)) echo $this->job->longitude; ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>
                <script language=Javascript>
                    function getdepartments(src, val) {
                        jQuery("#" + src).html("Loading ...");
                        jQuery.post('<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=listdepartments', {val: val}, function (data) {
                            if (data) {
                                jQuery("#" + src).html(data);
                                jQuery("#" + src + " select.jsjobs-cbo").chosen();
                            }
                        });
                    }
                    function fj_getsubcategories(src, val) {
                        jQuery("#" + src).html("Loading ...");
                        jQuery.post('<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=subcategory&task=listsubcategories', {val: val}, function (data) {
                            if (data) {
                                jQuery("#" + src).html(data);
                                jQuery("#" + src + " select.jsjobs-cbo").chosen();
                            } else {
                                alert("<?php echo JText::_("Error while getting subcategories");
                ?>");
                            }
                        });
                    }

                </script>


            </form>
            </div>
        <?php
    } else { // not allowed job posting 
        $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'visitor can not post job', 1);
    }
    ?>
        </div>
<?php    
}//ol
?>
</div> 
<style type="text/css">
    div#map_container{
        width:100%;
        height:350px;
    }
</style>
<?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
<script type="text/javascript" src="<?php echo $protocol; ?>maps.googleapis.com/maps/api/js?key=<?php echo $this->config['google_map_api_key']; ?>"></script>
<script type="text/javascript">
    var latlang_marker_array = [];
    var markers = [];
    var map = null;
    var bound = new google.maps.LatLngBounds();

            jQuery(document).ready(function () {
                var cityname = jQuery("#companycityforedit").val();
                if (cityname != "") {
                    jQuery("#companycity").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                        theme: "jsjobs",
                        preventDuplicates: true,
                        hintText: "<?php echo JText::_('Type In A Search'); ?>",
                        noResultsText: "<?php echo JText::_('No Results'); ?>",
                        searchingText: "<?php echo JText::_('Searching...'); ?>",
//tokenLimit: 1,
                        prePopulate: <?php
if (isset($this->vmultiselecteditcompany))
    echo $this->vmultiselecteditcompany;
else
    echo "''";
?>
                
                    });
                } else {
                    jQuery("#companycity").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                        theme: "jsjobs",
                        preventDuplicates: true,
                        hintText: "<?php echo JText::_('Type In A Search'); ?>",
                        noResultsText: "<?php echo JText::_('No Results'); ?>",
                        searchingText: "<?php echo JText::_('Searching...'); ?>",
//tokenLimit: 1

                    });
                }
                jQuery("select.jsjobs-cbo").chosen();
                jQuery("input.jsjobs-inputbox").button()
                        .css({
                            'width': '192px',
                            'border': '1px solid #A9ABAE',
                            'cursor': 'text',
                            'margin': '0',
                            'padding': '4px'
                        });

            });
            jQuery(document).ready(function () {
                var cityname = jQuery("#citynameforedit").val();
                if (cityname != "") {
                    jQuery("#city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                        theme: "jsjobs",
                        preventDuplicates: true,
                        hintText: "<?php echo JText::_('Type In A Search'); ?>",
                        noResultsText: "<?php echo JText::_('No Results'); ?>",
                        searchingText: "<?php echo JText::_('Searching...'); ?>",
//tokenLimit: 1,
                        prePopulate: <?php
if (isset($this->vmultiselecteditjob))
    echo $this->vmultiselecteditjob;
else
    echo "''";
?>,
                        onAdd: function(item) {
                            if (item.id > 0){
                                addMarkerOnMap(item);
                            }
                        },
                        onDelete: function(item){
                            identifyMarkerForDelete(item);
                        }
                    });
                } else {
                    jQuery("#city").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                        theme: "jsjobs",
                        preventDuplicates: true,
                        hintText: "<?php echo JText::_('Type In A Search'); ?>",
                        noResultsText: "<?php echo JText::_('No Results'); ?>",
                        searchingText: "<?php echo JText::_('Searching...'); ?>",
//tokenLimit: 1
                        onAdd: function(item) {
                            if (item.id > 0){
                                addMarkerOnMap(item);
                            }
                        },
                        onDelete: function(item){
                            identifyMarkerForDelete(item);
                        }
                    });
                }
            });

            var map_obj = document.getElementById('map_container');
            if (typeof map_obj !== 'undefined' && map_obj !== null) {
                window.onload = loadMap(1, '', '', '');
            }

            /*function addMarker(latlang){

                //bounds.extend(latlang);                

                var marker = new google.maps.Marker({
                    position: latlang,
                    map: jsadmap,
                    draggable: true,
                });
                
                marker.setMap(jsadmap);
                // jsadmap.fitBounds(bounds);
                // jsadmap.panToBounds(bounds);


                marker.addListener("dblclick", function() {
                    var latitude = document.getElementById('latitude').value;
                    latitude = latitude.replace(','+marker.position.lat(), "");
                    latitude = latitude.replace(marker.position.lat()+',', "");
                    latitude = latitude.replace(marker.position.lat(), "");
                    document.getElementById('latitude').value = latitude;
                    var longitude = document.getElementById('longitude').value;
                    longitude = longitude.replace(','+marker.position.lng(), "");
                    longitude = longitude.replace(marker.position.lng()+',', "");
                    longitude = longitude.replace(marker.position.lng(), "");
                    document.getElementById('longitude').value = longitude;
                    marker.setMap(null);
                });
                if(document.getElementById('latitude').value == ''){
                    document.getElementById('latitude').value = marker.position.lat();
                }else{
                    document.getElementById('latitude').value += ',' + marker.position.lat();
                }
                if(document.getElementById('longitude').value == ''){
                    document.getElementById('longitude').value = marker.position.lng();
                }else{
                    document.getElementById('longitude').value += ',' + marker.position.lng();
                }
            }

            function addMarkerOnMap(location){
                var geocoder =  new google.maps.Geocoder();
                geocoder.geocode( { 'address': location}, function(results, status) {
                    var latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                    if (status == google.maps.GeocoderStatus.OK) {
                        if(jsadmap != null){
                            addMarker(latlng);
                        }
                    } else {
                        alert("<?php echo JText::_('Something got wrong');?>:"+status);
                    }
                });    
            }


            function loadMap(callfrom, country, state, city) {
                var values_longitude = [];
                var values_latitude = [];
                var latedit = [];
                var longedit = [];
                var longitude = '';
                var latitude = '';

                var long_obj = document.getElementById('longitude');
                if (typeof long_obj !== 'undefined' && long_obj !== null) {
                    longitude = document.getElementById('longitude').value;
                    if (longitude != '')
                        longedit = longitude.split(",");
                }
                var lat_obj = document.getElementById('latitude');
                if (typeof long_obj !== 'undefined' && long_obj !== null) {
                    latitude = document.getElementById('latitude').value;
                    if (latitude != '')
                        latedit = latitude.split(",");
                }

                var default_latitude = document.getElementById('default_latitude').value;
                var default_longitude = document.getElementById('default_longitude').value;
                if (latedit != '' && longedit != '') {
                    for (var i = 0; i < latedit.length; i++) {
                        var latlng = new google.maps.LatLng(latedit[i], longedit[i]);
                        zoom = 4;
                        var myOptions = {
                            zoom: zoom,
                            center: latlng,
                            scrollwheel: false,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        if (i == 0)
                            jsadmap = new google.maps.Map(document.getElementById("map_container"), myOptions);
                        if (callfrom == 1) {
                            var marker = new google.maps.Marker({
                                position: latlng,
                                map: jsadmap,
                                visible: true,
                            });

                            document.getElementById('longitude').value = marker.position.lng();
                            document.getElementById('latitude').value = marker.position.lat();
                            marker.setMap(jsadmap);
                            values_longitude.push(longedit[i]);
                            values_latitude.push(latedit[i]);
                            document.getElementById('latitude').value = values_latitude;
                            document.getElementById('longitude').value = values_longitude;
                        }
                        bounds.extend(latlng);
                    }      
                    jsadmap.fitBounds(bounds);
                    jsadmap.panToBounds(bounds);    

                } else {
                    var latlng = new google.maps.LatLng(default_latitude, default_longitude);
                    zoom = 4;
                    var myOptions = {
                        zoom: zoom,
                        center: latlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    jsadmap = new google.maps.Map(document.getElementById("map_container"), myOptions);
                }
                google.maps.event.addListener(jsadmap, "click", function (e) {
                    var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
                    geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': latLng}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            //lastmarker.setMap(null);
                            var marker = new google.maps.Marker({
                                position: results[0].geometry.location,
                                map: jsadmap,
                            });
                            marker.setMap(jsadmap);
                            //lastmarker = marker;
                            document.getElementById('latitude').value = marker.position.lat();
                            document.getElementById('longitude').value = marker.position.lng();
                            values_longitude.push(document.getElementById('longitude').value);
                            values_latitude.push(document.getElementById('latitude').value);
                            document.getElementById('latitude').value = values_latitude;
                            document.getElementById('longitude').value = values_longitude;

                        } else {
                            alert("Geocode was not successful for the following reason: " + status);
                        }
                    });
                });


                if (callfrom == 3) {
                    var value = '';
                    var zoom = 4;
                    jQuery("div#job_city > ul > li > p").each(function () {
                        value = jQuery(this).html();
                        if (value != '') {
                            geocoder = new google.maps.Geocoder();
                            geocoder.geocode({'address': value}, function (results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    jsadmap.setCenter(results[0].geometry.location);
                                    document.getElementById('latitude').value = results[0].geometry.location.lat();
                                    document.getElementById('longitude').value = results[0].geometry.location.lng();
                                    jsadmap.setZoom(zoom);
                                    //lastmarker.setMap(null);
                                    var marker = new google.maps.Marker({
                                        position: results[0].geometry.location,
                                        map: jsadmap,
                                    });
                                    //marker.setMap(jsadmap);
                                    values_longitude.push(document.getElementById('longitude').value);
                                    values_latitude.push(document.getElementById('latitude').value);
                                    document.getElementById('latitude').value = values_latitude;
                                    document.getElementById('longitude').value = values_longitude;
                                    //lastmarker = marker;
                                } else {
                                    alert("Geocode was not successful for the following reason: " + status);
                                }
                            });
                        }
                    });
                }
            }*/

            function loadMap() {
                var default_latitude = document.getElementById('default_latitude').value;
                var default_longitude = document.getElementById('default_longitude').value;
                var latitude = document.getElementById('edit_latitude').value;
                var longitude = document.getElementById('edit_longitude').value;
                var isdefaultvalue = true;
                if (latitude != '' && longitude != '') {
                    default_latitude = latitude;
                    default_longitude = longitude;
                    isdefaultvalue = false;
                }

                var latlng = new google.maps.LatLng(document.getElementById('default_latitude').value, document.getElementById('default_longitude').value);
                zoom = 8;
                var myOptions = {
                    zoom: zoom,
                    center: latlng,
                    scrollwheel: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("map_container"), myOptions);
                default_latitude = default_latitude.split(',');
                if(default_latitude instanceof Array){
                    default_longitude = default_longitude.split(',');
                    for (i = 0; i < default_latitude.length; i++) {
                        var latlng = new google.maps.LatLng(default_latitude[i], default_longitude[i]);
                        if(isdefaultvalue == false)
                            addMarker(latlng);
                    }                            
                }else{
                    var latlng = new google.maps.LatLng(default_latitude, default_longitude);
                    if(isdefaultvalue == false)
                        addMarker(latlng);
                }
                google.maps.event.addListener(map, "click", function (e) {
                    var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
                    geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': latLng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        addMarker(results[0].geometry.location);
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                    });
                });
            }

            function addMarker(latlang,cityid){
                if (cityid === undefined) {
                    cityid = 0;
                }
                var marker = new google.maps.Marker({
                    position: latlang,
                    map: map,
                    draggable: true,
                });
                marker.setMap(map);
                map.setCenter(latlang);
                // cityid is to identify the marker neds to be removed.
                if(cityid != 0){
                    marker.cityid = cityid;
                    markers.push(marker);
                }
                // this array is for newly added city whoose marker may need to be removed.
                latlang_marker_array[latlang] = marker;
                //..

                marker.addListener("rightclick", function() {
                    deleteMarker(marker);
                });
                if(document.getElementById('latitude').value == ''){
                    document.getElementById('latitude').value = marker.position.lat();
                }else{
                    document.getElementById('latitude').value += ',' + marker.position.lat();
                }
                if(document.getElementById('longitude').value == ''){
                    document.getElementById('longitude').value = marker.position.lng();
                }else{
                    document.getElementById('longitude').value += ',' + marker.position.lng();
                }
                bound.extend(marker.getPosition());
                map.fitBounds(bound);
            }

            function deleteMarker(marker){ // this fucntion completely remves markr and thier lat lang values from text field
                var latitude = document.getElementById('latitude').value;
                latitude = latitude.replace(','+marker.position.lat(), "");
                latitude = latitude.replace(marker.position.lat()+',', "");
                latitude = latitude.replace(marker.position.lat(), "");
                document.getElementById('latitude').value = latitude;
                var longitude = document.getElementById('longitude').value;
                longitude = longitude.replace(','+marker.position.lng(), "");
                longitude = longitude.replace(marker.position.lng()+',', "");
                longitude = longitude.replace(marker.position.lng(), "");
                document.getElementById('longitude').value = longitude;
                marker.setMap(null);
                return;
            }

            function identifyMarkerForDelete(t_item){// this fucntion identifies the marker assiciated with token input value that has been removed.
                var id = t_item.id;
                // this code is when lat lang are added from data base cities
                for (var i = 0; i < markers.length; i++) {
                    if (markers[i].cityid == id) {
                        //Remove the marker from Map                  
                        //markers[i].setMap(null);
                        deleteMarker(markers[i]);
                        //Remove the marker from array.
                        markers.splice(i, 1);
                        return;
                    }
                }
                // this code is for when lat lang belonged to newely added city
                if( t_item.latitude != undefined && t_item.latitude != '' && t_item.latitude != 0){
                    var markerLatlng = new google.maps.LatLng(t_item.latitude, t_item.longitude);
                    deleteMarker(latlang_marker_array[markerLatlng]);
                    markers.splice(markerLatlng, 1);
                }
            }

            function addMarkerOnMap(location){
                if( location.latitude != undefined && location.latitude != '' && location.latitude != 0){// code is for adding a marker from data base lat lang.
                    var latlng = new google.maps.LatLng(String(location.latitude), String(location.longitude));
                    if(map != null){
                        addMarker(latlng,location.id);
                    } else {
                        alert("Something got wrong 1:");
                    } 
                }else{ // this code for adding a marker from location name. // this code is redundant but leaving it here 
                    var geocoder =  new google.maps.Geocoder();
                    geocoder.geocode( { 'address': location.name}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            var latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                            if(map != null){
                                addMarker(latlng,location.id);
                            }
                        } else {
                            //alert("<?php //echo __('Something got wrong','js-jobs');?>:"+status);
                        }
                    }); 
                }
                return;
            }

    jQuery(document).ready(function () {
        jQuery('div[data-jquery="hideit"]').each(function () {
            jQuery(this).hide()
        });
    });
</script>
