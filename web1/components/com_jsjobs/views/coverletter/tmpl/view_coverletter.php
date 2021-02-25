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
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
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
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('View Cover Letter'); ?></span>
    <?php
    if (isset($this->coverletter)) { ?>
            <div class="jsjobs-data-wrapper">
                 <div class="jsjobs-view-letter-data">
                    <span class="js_job_data_title"><?php echo JText::_('Title'); ?>: </span>
                    <span class="js_job_data_value"><?php if (isset($this->coverletter)) echo $this->coverletter->title; ?></span>
                </div>
                <div class="jsjobs-view-letter-description">
                   <span class="js_controlpanel_section_title"><?php echo JText::_('Description'); ?>: </span>
                   <span class="js_job_full_width_data"><?php if (isset($this->coverletter)) echo $this->coverletter->description; ?></span>
                </div>
            </div>
    <?php }else { 
        $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
        }
        ?>
        </div>            
        <?php
}//ol
?>		
 
</div>