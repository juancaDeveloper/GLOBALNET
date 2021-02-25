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
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jsjobs/css/combobox/chosen.css');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('components/com_jsjobs/js/jquery.tokeninput.js');
$document->addStyleSheet('components/com_jsjobs/css/token-input-jsjobs.css');
$document->addScript('components/com_jsjobs/js/combobox/chosen.jquery.js');
$document->addScript('components/com_jsjobs/js/combobox/prism.js');
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
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    ?>
    <script language="javascript">
        function myValidate(f) {
            if (document.formvalidator.isValid(f)) {
                f.check.value = '<?php if (JVERSION < 3)
        echo JUtility::getToken();
    else
        echo JSession::getFormToken();
    ?>';//send token
            }
            else {
                alert("<?php echo JText::_("Some values are not acceptable").'. '.JText::_("Please retry"); ?>");
                return false;
            }
            return true;
        }

    </script>

    <script language="Javascript" type="text/javascript">
        function displayError(message, divcolor) {
            document.getElementById('message').innerHTML = message;
            document.getElementById('errormessage').style.position = '';
            $('#errormessage').slideDown('50');
        }
    </script>

    <?php
    $notapprovemessage = 0;
    $printform = 0;
    if (isset($this->userrole->rolefor) && $this->userrole->rolefor == 2 ) { // job seeker
        $printform = 1;
        if ((isset($this->jobsetting)) && ($this->jobsetting->id != 0)) { // not new form
            if ($this->jobsetting->status == 1) { // Employment Application is actve
                $printform = 1;
            } else if ($this->jobsetting->status == 0) { // not allowed job posting
                $printform = 0;
                $notapprovemessage = 1;
            } else { // not allowed job posting
                $printform = 0;
                $notapprovemessage = 1;
            }
        }
    }else {
        if(isset($this->userrole->rolefor)){
            if($this->userrole->rolefor != 1){
                if ($this->config['overwrite_jobalert_settings'] == 1)
                    $printform = 1;        
            }
        }else{
            if ($this->config['overwrite_jobalert_settings'] == 1)
                $printform = 1;            
        }
    }
    if ($printform == 1) {
        if ($this->cansetjobalert == 1)
            $cansetjobalert = 1;
    }
    ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><span class="jsjobs-title"><?php echo JText::_('Job Alert Info'); ?></span>
            <?php if ($printform == 1) { ?>
            <span class="jsjobs-btn"> <?php $i = 0; ?>
                <div class="jsjobs-button-jobalert" style="text-align:right;">
                    <?php if (isset($this->jobsetting->id)) { ?>
                    <a id="jsjobs-button" class="button minpad" href= "<?php echo JRoute::_('index.php?option=com_jsjobs&c=jobalert&view=jobalert&layout=jobalertunsubscribe&email='.$this->jobsetting->contactemail.'&Itemid='.$this->Itemid ,false); ?> " ><?php echo JText::_('Unsubscribe Job Alert'); ?></a>
                    <?php } else { ?>                           
                    <a id="jsjobs-button" class="button minpad" href="<?php echo JRoute::_('index.php?option=com_jsjobs&c=jobalert&view=jobalert&layout=jobalertunsubscribe&Itemid='.$this->Itemid ,false); ?>" ><?php echo JText::_('Unsubscribe Job Alert'); ?></a>
                    <?php } ?>                          
                </div>
            </span>
            <?php } ?>
        </span>
    <?php
    if ($printform == 1) {
        if (isset($cansetjobalert) && $cansetjobalert == 1) { // add new resume, in edit case always 1
            ?>
                <form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate jsautoz_form" enctype="multipart/form-data"  onSubmit="return myValidate(this);">
                 <div class="jsjobs-field-main-wrapper">		        
                    <div class="jsjobs-fieldwrapper">
                        <div class="jsjobs-fieldtitle">
                            <label id="namemsg" for="name"><?php echo JText::_('Name'); ?><font color="red">*</font></label>
                        </div>
                        <div class="jsjobs-fieldvalue">
                            <input class="inputbox required " type="text" name="name" id="name" size="40" maxlength="100" value="<?php if (isset($this->jobsetting)) echo $this->jobsetting->name; ?>" />
                        </div>
                    </div>				        
                    <div class="jsjobs-fieldwrapper">
                        <div class="jsjobs-fieldtitle">
                            <label id="jobcategorymsg" for="categoryid"><?php echo JText::_('Categories'); ?><font color="red">*</font></label>
                        </div>
                        <div class="jsjobs-fieldvalue">
            <?php echo $this->lists['jobcategory']; ?>
                        </div>
                    </div>				        
                    <div class="jsjobs-fieldwrapper">
                        <div class="jsjobs-fieldtitle">
                            <label id="subcategoryidmsg" for="subcategoryid"><?php echo JText::_('Sub Category'); ?></label>
                        </div>
                        <div class="jsjobs-fieldvalue" id="fj_subcategory">
            <?php echo $this->lists['subcategory']; ?>
                        </div>
                    </div>				        
                    <div class="jsjobs-fieldwrapper">
                        <div class="jsjobs-fieldtitle">
                            <label id="contactemailmsg" for="contactemail"><?php echo JText::_('Contact Email'); ?><font color="red">*</font></label>
                        </div>
                        <div class="jsjobs-fieldvalue" >
                            <input class="inputbox required validate-email" type="text" name="contactemail" id="contactemail" size="40" maxlength="100" value="<?php if (isset($this->jobsetting)) echo $this->jobsetting->contactemail; ?>" />
                        </div>
                    </div>				        
                    <div class="jsjobs-fieldwrapper">
                        <div class="jsjobs-fieldtitle">
                            <label id="citymsg" for="city"><?php echo JText::_('City'); ?></label>
                        </div>
                        <div class="jsjobs-fieldvalue" id="jobalert_city">
                            <input class="inputbox" type="text" name="city" id="jobalertcity" size="40" maxlength="100" value="" />
                            <input type="hidden" name="cityidforedit" id="cityidforedit" value="<?php if (isset($this->multiselectedit)) echo $this->multiselectedit; ?>" />
                        </div>
                    </div>				        
                    <div class="jsjobs-fieldwrapper">
                        <div class="jsjobs-fieldtitle">
                            <label id="zipcodemsg" for="zipcode"><?php echo JText::_('Zip Code'); ?></label>
                        </div>
                        <div class="jsjobs-fieldvalue" id="jobalert_city">
                            <input class="inputbox" type="text" name="zipcode" size="40" maxlength="100" value="<?php if (isset($this->jobsetting)) echo $this->jobsetting->zipcode; ?>" />
                        </div>
                    </div>				        
                    <div class="jsjobs-fieldwrapper">
                        <div class="jsjobs-fieldtitle">
                            <label id="keywordsmsg" for="keywords"><?php echo JText::_('Keywords'); ?></label>
                        </div>
                        <div class="jsjobs-fieldvalue" id="jobalert_city">
                            <textarea class="inputbox" cols="46" name="keywords" rows="4" style="resize:none;" ><?php if (isset($this->jobsetting)) echo $this->jobsetting->keywords; ?></textarea>
                        </div>
                    </div>				        
                    <div class="jsjobs-fieldwrapper">
                        <div class="jsjobs-fieldtitle">
                            <label id="alerttypemsg" for="alerttype"><?php echo JText::_('Alert Type'); ?><font color="red">*</font></label>
                        </div>
                        <div class="jsjobs-fieldvalue" id="alerttype">
                    <?php echo $this->lists['alerttype']; ?>
                        </div>
                    </div>				        
                    <?php
                    $user = JFactory::getUser();
                    if ($this->config['job_alert_captcha'] == 1 && ($user->guest)) {
                        ?>

                        <div class="jsjobs-fieldwrapper">
                            <div class="jsjobs-fieldtitle">
                                <label id="captchamsg" for="captcha"><?php echo JText::_('Captcha'); ?></label><?php echo '<font color="red">*</font>'; ?>
                            </div>
                            <div class="jsjobs-fieldvalue" id="jobalert_city">
                                <?php echo $this->captcha; ?>
                            </div>
                        </div>
                        
                        			        
            <?php } ?>
                <div class="jsjobs-jobsalertinfo-save-btn">
                    <input type="submit" id="button" class="button jsjobs_button" name="submit_app" value="<?php echo JText::_('Save'); ?>"/>
                </div>
                    				        
                    </div>
                    <?php
                    if (isset($this->jobsetting)) {
                        if (($this->jobsetting->created == '0000-00-00 00:00:00') || ($this->jobsetting->created == ''))
                            $curdate = date('Y-m-d H:i:s');
                        else
                            $curdate = $this->jobsetting->created;
                    } else
                        $curdate = date('Y-m-d H:i:s');
                    ?>
                    <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                    <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
                    <input type="hidden" name="id" value="<?php if (isset($this->jobsetting->id)) echo $this->jobsetting->id; ?>" />
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="task" value="jobalert.savejobalertsetting" />
                    <input type="hidden" name="c" value="jobalert" />
                    <input type="hidden" name="check" value="" />
                    <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                    <?php echo JHTML::_( 'form.token' ); ?>   
                </form>
            <script language=Javascript>
                function validate_form() {
                    var name = jQuery('input#name').val();
                    var contactemail = jQuery('input#contactemail').val();

                    var alert_type = jQuery('#alerttype select option:selected').val();
                    if (alert_type == "") {
                        alert("<?php echo JText::_("Please select alert type") ?>");
                        return false;
                    } else {
                        document.adminForm.submit();
                    }
                }

                jQuery(document).ready(function () {
                    jQuery("select.jsjobs-cbo").chosen();
                    jQuery("input.jsjobs-inputbox").button()
                            .css({
                                'width': '192px',
                                'border': '1px solid #A9ABAE',
                                'cursor': 'text',
                                'margin': '0',
                                'padding': '4px'
                            });

                    var value = jQuery("#cityidforedit").val();
                    if (value != "") {
                        jQuery("#jobalertcity").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                            theme: "jsjobs",
                            preventDuplicates: true,
                            hintText: "<?php echo JText::_('Type In A Search'); ?>",
                            noResultsText: "<?php echo JText::_('No Results'); ?>",
                            searchingText: "<?php echo JText::_('Searching...'); ?>",
                            tokenLimit: 5,
                            prePopulate: <?php if (isset($this->multiselectedit))
                        echo $this->multiselectedit;
                    else
                        echo "''";
                    ?>
                        });

                    } else {
                        jQuery("#jobalertcity").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                            theme: "jsjobs",
                            preventDuplicates: true,
                            hintText: "<?php echo JText::_('Type In A Search'); ?>",
                            noResultsText: "<?php echo JText::_('No Results'); ?>",
                            searchingText: "<?php echo JText::_('Searching...'); ?>",
                            tokenLimit: 5

                        });
                    }
                });





                function deleteJobAlert() {
                    document.adminForm.action = 'index.php?option=com_jsjobs&c=&task=deleteJobAlertSetting';
                    //document.getElementById('action').value=actionvalue;
                    document.forms["adminForm"].submit();
                    // document.adminForm.submit(document.adminForm.action);
                }
                function fj_getsubcategories(src, val) {
                    jQuery("#" + src).html("Loading ...");
                    jQuery.post('<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=subcategory&task=listsubcategories', {val: val}, function (data) {
                        if (data) {
                            jQuery("#" + src).html(data);
                            jQuery("#" + src + " select.jsjobs-cbo").chosen();
                        } else {
                            alert("<?php echo JText::_("Error while getting subcategories"); ?>");
                        }
                    });
                }

            </script>



            <?php
        } else { // not allowed job posting
            $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page', 0);
        }
    } else { // not allowed job posting
        if($notapprovemessage == 0){
            $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page', 0);            
        }else{
            $this->jsjobsmessages->getAccessDeniedMsg('Waiting for approval', 'Your job alert request is waiting for approval', 0);            
        }
    } ?>
    </div>
    <?php
}//ol
?>
</div> 
