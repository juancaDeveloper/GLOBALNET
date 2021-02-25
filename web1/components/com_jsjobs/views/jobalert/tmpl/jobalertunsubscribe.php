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
$editor = JFactory::getEditor();
JHTML::_('behavior.calendar');
$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
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
    <?php
    $printform = 0;
    if (isset($this->userrole->rolefor))
        if ($this->userrole->rolefor == 2) { // job seeker
            $printform = 1;
        } elseif ($this->userrole->rolefor != 1) { // not employer
            if ($this->config['overwrite_jobalert_settings'] == 1)
                $printform = 1;
        }else { // not allowed job posting
            $printform = 0;
        }
    ?> 
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Unsubscribe Job Alert'); ?></span>
    <?php
    if ($printform == 1) { // jobseeker
        ?>
            <form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate jsautoz_form" enctype="multipart/form-data"  onSubmit="return myValidate(this);">
                <div class="jsjobs-field-main-wrapper">                
                    <div class="jsjobs-fieldwrapper">
                        <div class="jsjobs-fieldtitle">
                            <label id="contactemailmsg" for="contactemail"><?php echo JText::_('Contact Email'); ?>&nbsp;<font color="red">*</font></label>
                        </div>
                        <div class="jsjobs-fieldvalue">
                            <?php if ($this->email) { ?>
                                <input class="inputbox required validate-email" type="text" name="contactemail" id="contactemail" size="40" maxlength="100" value="<?php echo $this->email; ?>" />
                            <?php } else { ?>
                                <input class="inputbox required validate-email" type="text" name="contactemail" id="contactemail" size="40" maxlength="100" value="" />
                            <?php } ?>
                        </div>
                    </div>				        
                    <div class="jsjobs-jobsalertinfo-save-btn">
                        <input id="button" class="button jsjobs_button" type="submit" name="submit_app" value="<?php echo JText::_('Unsubscribe'); ?>" />
                    </div>
                    <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="task" value="unsubscribeJobAlertSetting" />
                    <input type="hidden" name="c" value="jobalert" />
                    <input type="hidden" name="check" value="" />
                    <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                    <?php echo JHTML::_( 'form.token' ); ?>  
                </div>
            </form>



        <?php
    } else { // not allowed job posting 
        $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed to unsubscribe job alert', 'You are not allowed to unsubscribe job alert', 0);
    }
    ?>
        </div>
        <?php
}//ol
?>
</div> 
