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
    ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Job By Types'); ?></span>
    <?php
    if ($allowed == true) {
        ?>
            <div class="jsjobs-jobstyoes-maain">
            <?php
            $cmodel = JSModel::getJSModel('common');
            $noofcols = $this->config['categories_colsperrow'];
            $colwidth = round(100 / $noofcols);
            if (isset($this->jobtypes)) {
                foreach ($this->jobtypes as $jobtype) {
                    if(!($jobtype instanceof Object)){
                        $jobtype = (Object) $jobtype;
                    }
                    $lnks = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs&jt=' . $cmodel->removeSpecialCharacter($jobtype->jobtypealiasid) . '&Itemid=' . $this->Itemid;
                    ?>
                    
                    <a class="jsjobs-job-types" style="width:<?php echo $colwidth - 2; ?>%;" href="<?php echo $lnks; ?>" ><?php echo JText::_($jobtype->title); ?><span class="jsjobs-counter">(<?php echo htmlspecialchars($jobtype->typeinjobs); ?>)</span></a>
                    <?php
                }
            }
            ?> 
           </div> 
        <?php
    } else {  // not allowed job posting 
        $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page', 0);
    }
    ?>
    </div>
    <?php
}//ol
?>
 
</div>