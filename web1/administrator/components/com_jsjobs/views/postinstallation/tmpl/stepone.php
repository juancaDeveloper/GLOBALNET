<?php
/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */
defined('_JEXEC') or die('Restricted access');

$yesno = array(
    '0' => array('value' => '1',
        'text' => JText::_('Yes')),
    '1' => array('value' => '0',
        'text' => JText::_('No')),);
$med_field_width = 25;
$date_format = array(
    '0' => array('value' => 'd-m-Y', 'text' => JText::_('DD-MM-YYYY')),
    '1' => array('value' => 'm-d-Y', 'text' => JText::_('MM-DD-YYYY')),
    '2' => array('value' => 'Y-m-d', 'text' => JText::_('YYYY-MM-DD')),);

$date_format = JHTML::_('select.genericList', $date_format, 'date_format', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['date_format']);
?>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>
    <div id="jsjobs-content">
        <div id="jsjob-main-wrapper" class="post-installation">
            <div class="js-admin-title-installtion">
                <span class="jsjob_heading"><?php echo JText::_('JS Jobs Configurations'); ?></span>
                <div class="close-button-bottom">
                    <a href="index.php?option=com_jsjobs&c=jsjobs&layout=controlpanel" class="close-button">
                        <img src="components/com_jsjobs/include/images/postinstallation/close-icon.png" />
                    </a>
                </div>
            </div>
            <div class="post-installtion-content-wrapper">
                <div class="post-installtion-content-header">
                    <ul class="update-header-img step-1">
                        <li class="header-parts first-part active">
                            <a href="index.php?option=com_jsjobs&c=postinstallation&layout=stepone" title="link" class="tab_icon">
                                <img class="start" src="components/com_jsjobs/include/images/postinstallation/general-settings.png" />
                                <span class="text"><?php echo JText::_('General Settings'); ?></span>
                            </a>
                        </li>
                        <li class="header-parts second-part">
                           <a href="index.php?option=com_jsjobs&c=postinstallation&layout=steptwo" title="link" class="tab_icon">
                               <img class="start" src="components/com_jsjobs/include/images/postinstallation/user.png" />
                                <span class="text"><?php echo JText::_('Employer Settings'); ?></span>
                            </a>
                        </li>
                        <li class="header-parts third-part">
                           <a href="index.php?option=com_jsjobs&c=postinstallation&layout=stepthree" title="link" class="tab_icon">
                               <img class="start" src="components/com_jsjobs/include/images/postinstallation/jobseeker.png" />
                                <span class="text"><?php echo JText::_('Job Seeker Settings'); ?></span>
                            </a>
                        </li>
                        <li class="header-parts third-part">
                           <a href="index.php?option=com_jsjobs&c=postinstallation&layout=stepfour" title="link" class="tab_icon">
                               <img class="start" src="components/com_jsjobs/include/images/postinstallation/sample-data.png" />
                                <span class="text"><?php echo JText::_('Sample Data'); ?></span>
                            </a>
                        </li>
                        <li class="header-parts forth-part">
                            <a href="index.php?option=com_jsjobs&c=postinstallation&layout=settingcomplete" title="link" class="tab_icon">
                               <img class="start" src="components/com_jsjobs/include/images/postinstallation/complete.png" />
                                <span class="text"><?php echo JText::_('Settings Complete'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="post-installtion-content_wrapper_right">
                    <div class="jsjob-config-topheading">
                        <span class="heading-post-ins jsjob-configurations-heading"><?php echo JText::_('General Settings');?></span>
                        <span class="heading-post-ins jsjob-config-steps"><?php echo JText::_('Step 1 of 4');?></span>
                    </div>
                    <div class="post-installtion-content">
                        <form id="jsjobs-form-ins" method="post" action="index.php">
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Title');?>:  
                                </div>
                                <div class="field"> 
                                    <input type="text" class="inputbox jsjob-postsetting" name="title" id="title" placeholder="<?php echo JText::_('System Title'); ?>" size="<?php echo $med_field_width; ?>" value="<?php echo isset($this->result) ? $this->result['title'] : ''; ?>" />
                                </div>
                                <div class="desc">
                                    <?php echo JText::_("Enter the site title"); ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Data Directory');?>:  
                                </div>
                                <div class="field"> 
                                    <input type="text" class="inputbox jsjob-postsetting" name="data_directory" id="directory" placeholder="<?php echo JText::_('Data Directory'); ?>" size="<?php echo $med_field_width; ?>" value="<?php echo isset($this->result) ? $this->result['data_directory'] : ''; ?>" />
                                </div>
                                <div class="desc">
                                    <?php echo JText::_("You need to rename the existing data directory in file system before changing the data directory name"); echo ': <b>"'.JPATH_SITE.$this->result['data_directory'].'"</b>'; ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Date Format');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo $date_format; ?>
                                </div>
                                <div class="desc"><?php echo JText::_('Date format for plugin');?> </div>
                            </div> 
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Admin email address');?>:  
                                </div>
                                <div class="field"> 
                                    <input type="text" class="inputbox jsjob-postsetting" name="adminemailaddress" id="adminemailaddress" value="<?php echo $this->result['adminemailaddress']; ?>" />
                                </div>
                                <div class="desc">
                                    <?php echo JText::_("Admin will receive email notifications on this address"); ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('System email address');?>:  
                                </div>
                                <div class="field"> 
                                    <input type="text" class="inputbox jsjob-postsetting" name="mailfromaddress" id="mailfromaddress" value="<?php echo $this->result['mailfromaddress']; ?>" />
                                </div>
                                <div class="desc">
                                    <?php echo JText::_("Email address that will be used to send emails"); ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Email from name');?>:  
                                </div>
                                <div class="field"> 
                                    <input type="text" class="inputbox jsjob-postsetting" name="mailfromname" id="mailfromname" value="<?php echo $this->result['mailfromname']; ?>" />
                                </div>
                                <div class="desc">
                                    <?php echo JText::_("Sender name that will be used in emails"); ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Show breadcrumbs');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'cur_location', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['cur_location']); ?>
                                </div>
                                <div class="desc"><?php echo JText::_('Show navigation in breadcrumbs');?> </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Number Of Featured Jobs');?>:  
                                </div>
                                <div class="field"> 
                                    <input type="text" class="inputbox jsjob-postsetting" name="nooffeaturedjobsinlisting" id="nooffeaturedjobsinlisting" value="<?php echo $this->result['nooffeaturedjobsinlisting']; ?>" />
                                </div>
                                <div class="desc">
                                    <?php echo JText::_("How many featured job show per page scroll"); ?>
                                </div>
                            </div> 
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Auto Assign Package To Employer');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'employer_defaultpackage', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['employer_defaultpackage']); ?>
                                </div>
                                <div class="desc"><?php echo JText::_('Auto assign package to New Employer');?> </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Auto Assign Package To Job Seeker');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'jobseeker_defaultpackage', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['jobseeker_defaultpackage']); ?>
                                </div>
                                <div class="desc"><?php echo JText::_('Auto assign package to New Job Seeker');?> </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Show Google Ads In List Jobs');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'googleadsenseshowinlistjobs', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['googleadsenseshowinlistjobs']); ?>
                                </div>
                                <div class="desc"><?php echo JText::_('Show google adds in jobs listings');?> </div>
                            </div>
                             
                            <div class="pic-button-part">
                                <a class="next-step full-width" href="#"  onclick="document.getElementById('jsjobs-form-ins').submit();" >
                                    <?php echo JText::_('Next'); ?>
                                    <img src="components/com_jsjobs/include/images/postinstallation/next-arrow.png">
                                </a>
                            </div>
                            <input type="hidden" name="task" value="save" />
                            <input type="hidden" name="c" value="postinstallation" />
                            <input type="hidden" name="layout" value="stepone" />
                            <input type="hidden" name="step" value="1">
                            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                            <?php echo JHtml::_( 'form.token' ); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<div id="jsjobs-footer">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>
