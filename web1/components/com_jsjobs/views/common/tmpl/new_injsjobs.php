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


if ($this->config['showemployerlink'] == 0) { // user can not register as a employer
    $usertypeid = '';
    if ($this->usertype)
        $usertypeid = $this->usertype->id;
    echo '<form action="index.php" method="POST" name="adminForm">';

    echo '<input type="hidden" name="usertype" value="2" />'; //2 for job seeker
    echo '<input type="hidden" name="dated" value="' . date('Y-m-d H:i:s') . '" />';
    echo '<input type="hidden" name="uid" value="' . $this->uid . '" />';
    echo '<input type="hidden" name="id" value="' . $usertypeid . '" />';
    echo '<input type="hidden" name="option" value="' . $this->option . '" />';
    echo '<input type="hidden" name="task" value="savenewinjsjobs" />';
    echo '<input type="hidden" name="c" value="userrole" />';
    echo JHTML::_('form.token');
    echo '<script language=Javascript>';
    echo 'document.adminForm.submit();';
    echo '</script>';

    echo '</form>';
}
 
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
    ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Welcome In').' '. $this->config['title']; ?></span>
        <div class="jsjobs-folderinfo">
        <?php
        if ($this->config['showemployerlink'] == 1) { // ask user role
            ?>
            <form action="index.php" method="post" name="adminForm" id="adminForm" >
                <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <label id="noofjobsmsg" for="noofjobs"><?php echo JText::_('Please select your role'); ?> </label>
                    </div>
                    <div class="fieldvalue">
                        <?php echo $this->lists['usertype']; ?>
                    </div>
                </div>

                <div class="fieldwrapper-btn">
                    <div class="jsjobs-folder-info-btn">
                        <sapn class="jsjobs-folder-btn">
                            <input id="button" class="button jsjobs_button" type="submit" name="submit_app" onclick="document.adminForm.submit();" value="<?php echo JText::_('Submit'); ?>" />
                        </span>
                    </div>
                </div>
                <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>" />
                <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
                <input type="hidden" name="id" value="<?php if ($this->usertype) echo $this->usertype->id; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="savenewinjsjobs" />
                <input type="hidden" name="c" value="userrole" />
                <input type="hidden" name="Itemid" value="<?php $this->Itemid ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>        
            </form>
            </div> 
        </div>
    <?php }else { // user can not register as a employer  ?>
        <div width="100%" align="center">
            <br><br><h1>Please wait ...</h1>
        </div>

        <?php
    }
}//ol
?>      
 </div>