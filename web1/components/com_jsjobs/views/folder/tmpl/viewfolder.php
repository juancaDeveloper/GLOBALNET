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
        <span class="jsjobs-main-page-title"><?php echo JText::_('Folder Information'); ?></span>
    <?php    
    if (isset($this->folder)) { ?>
            <div class="js_jobs_data_wrapper">
                <span class="js_jobs_data_title"><?php echo JText::_('Name'); ?>:</span>
                <span class="js_jobs_data_value"><?php echo $this->folder->name; ?></span>
            </div>
            <div class="jsjobs-description-area">
            <span class="js_jobs_description_section_title"><?php echo JText::_('Description'); ?>:</span>
            <div class="js_jobs_full_width_data"><?php echo $this->folder->decription; ?></div>
            </div>
    <?php } else {
            $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 1);
        } ?>
    </div>
    <?php        
}//ol
?>
</div> 
