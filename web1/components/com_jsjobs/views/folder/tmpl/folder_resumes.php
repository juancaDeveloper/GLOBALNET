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
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('My Folders Resumes'); ?></span>
    <?php
    if ($this->resume) {
        if ($this->userrole->rolefor == 1) { // employer
            ?>
            <style>
                div.fieldwrapper.view{text-align: left;padding: 0px 2%;width:96%;}
                div#folder_resume{float:left;clear:both;}
            </style>
                <?php 
                $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(3);
                $_field = array();
                foreach($fieldsordering AS $field){
                    if($field->showonlisting == 1){
                        $_field[$field->field] = $field->fieldtitle;
                    }
                }
                foreach ($this->resume as $resume) {
                    $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                    $resumelink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=7&rd=' . $resumealiasid . '&fd=' . $this->fd . '&Itemid=' . $this->Itemid;
                    $comma = "";
                    ?>
                    <div class="js_job_main_wrapper">
                        <div class="header">
                           <?php if (isset($_field['photo'])) { ?>
                            <div class="js_job_image_area">
                                <div class="js_job_image_wrapper mycompany">
                                    <?php
                                    if ($resume->photo != '') {
                                        $imgsrc = JURI::root().$this->config['data_directory'] . "/data/jobseeker/resume_" . $resume->appid . "/photo/" . $resume->photo;
                                    } else {
                                        $imgsrc = JURI::root()."components/com_jsjobs/images/jobseeker.png";
                                    }
                                    ?>
                                    <img class="js_job_image" src="<?php echo $imgsrc; ?>" />
                                </div>
                            </div>
                        <?php } ?>                        
                        <div class="js_job_data_area">
                            <div class="js_job_data_3 myresume_folder">
                                <?php
                                    $address = '';
                                    $comma = '';
                                    if ($resume->cityname != '') {
                                        $address = $comma . JText::_($resume->cityname);
                                        $comma = " ,";
                                    }
                                    switch ($this->config['defaultaddressdisplaytype']){
                                        case 'csc':
                                            if ($resume->statename != '') {
                                                $address .= $comma . JText::_($resume->statename);
                                                $comma = " ,";
                                            }
                                            if ($resume->countryname != '')
                                                $address .= $comma . JText::_($resume->countryname);
                                        break;
                                        case 'cs':
                                            if ($resume->statename != '') {
                                                $address .= $comma . JText::_($resume->statename);
                                                $comma = " ,";
                                            }
                                        break;
                                        case 'cc':
                                            if ($resume->countryname != '')
                                                $address .= $comma . JText::_($resume->countryname);
                                        break;
                                    }
                                ?>
                                <div class='title'>
                                    <?php if (isset($_field['first_name'])) { ?>
                                        <?php echo $resume->first_name; ?>
                                    <?php } ?>
                                    <?php if (isset($_field['last_name'])) { ?>
                                        <?php echo ' ' . $resume->last_name; ?>
                                    <?php } ?>
                                </div>
                                    <?php
                                    echo "<span class='js_job_data_2_created_myresume'>" . JText::_('Applied').'&nbsp'.JText::_('Date') . ": ";
                                    echo JHtml::_('date', $resume->apply_date, $this->config['date_format']) . "</span>";
                                    ?>
                                    <?php
                                    echo "<span class='js_job_data_2_created_myresume jobtype'>". JText::_($resume->jobtypetitle) . "</span>";
                                    ?>
                            </div>
                            <div class="js_job_data_2 myresume first-child">
                                <div class='js_job_data_2_wrapper'>
                                <?php if (isset($_field['gender'])) { ?>
                                    <span class="heading"><?php echo JText::_($_field['gender']).':';?></span>
                                    <span class="text">
                                         <?php
                                            if ($resume->gender == 1)
                                                echo JText::_('Male');
                                            elseif ($resume->gender == 2)
                                                echo JText::_('Female');
                                            elseif ($resume->gender == 3)
                                                echo JText::_('Does Not Matter');
                                            ?>
                                    </span>
                                <?php } ?>
                                </div>
                                <?php if(isset($_field['total_experience'])){ ?>
                                <div class='js_job_data_2_wrapper'>
                                    <span class="heading"><?php echo JText::_($_field['total_experience']).':';?></span>
                                    <span class="text">
                                        <?php
                                        if (empty($resume->exptitle))
                                            echo $resume->total_experience;
                                        else
                                            echo $resume->exptitle
                                        ?>
                                    </span>
                                </div>
                                <?php } ?>
                            <?php if (isset($_field['salary'])) { ?>
                                <div class='js_job_data_2_wrapper'>
                                    <span class="heading"><?php echo JText::_('Salary').'&nbsp'.JText::_('Range').':';?></span>
                                    <span class="text">
                                        <?php
                                            $salary = $this->getJSModel('common')->getSalaryRangeView($resume->symbol,$resume->rangestart,$resume->rangeend,$resume->salarytype,$this->config['currency_align']);
                                            echo $salary;
                                        ?>
                                    </span>
                                </div>
                            <?php } ?> 
                            </div>
                        </div> 
                        </div>                        
                        <div class="bottom">
                            <span class="location">
                                <span class="js_job_data_2_title"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span>
                                <span class="js_job_data_2_value"><?php echo $address; ?></span>
                            </span>
                            <div class='btn-view'>
                                    <a class="js_job_data_area_button" href="<?php echo $resumelink ?>"><?php echo JText::_('View Resume'); ?></a>
                            </div>
                        </div>
                    </div>        
                    <?php
                }
                ?>

            <input type="hidden" name="layout" value="folder_resumes" />
            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            <input type="hidden" name="folderid" id="folderid" value="<?php echo $this->fd; ?>" />
            <input type="hidden" name="resumeid" id="resumeid" value="<?php echo $resume->appid; ?>" />
            <input type="hidden" name="id" id="id" value="" />
            <script>
                function setrating(src, newrating, ratingid, jobid, resumeid) {
                    jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=saveresumerating", {ratingid: ratingid, jobid: jobid, resumeid: resumeid, newrating: newrating}, function (data) {
                        if (data == 1) {
                            document.getElementById(src).style.width = parseInt(newrating * 20) + '%';
                        }
                    });
                }
            </script>
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=folder&view=folder&layout=folder_resumes&fd=' . $this->fd . '&Itemid=' . $this->Itemid ,false); ?>" method="post">
                <div id="jsjobs_jobs_pagination_wrapper">
                    <div class="jsjobs-resultscounter">
                        <?php echo $this->pagination->getResultsCounter(); ?>
                    </div>
                    <div class="jsjobs-plinks">
                        <?php echo $this->pagination->getPagesLinks(); ?>
                    </div>
                    <div class="jsjobs-lbox">
                        <?php echo $this->pagination->getLimitBox(); ?>
                    </div>
                </div>

            </form>
        <?php }else { // no result found in this category 
                $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
            }
    } else { // not allowed job posting 
        $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page', 0);
    }
    ?>
    </div>
    <?php
}//ol
?>
</div> 
