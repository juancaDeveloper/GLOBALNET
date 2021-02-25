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
$overduetype_array = array(
    '0' => array('value' => '1',
        'text' => JText::_('Days')),
    '1' => array('value' => '2',
        'text' => JText::_('Hours')),);
$med_field_width = 25;
$searchjobtag = array(
    '0' => array('value' => 1, 'text' => JText::_('Top left')),
    '1' => array('value' => 2, 'text' => JText::_('Top right')), 
    '2' => array('value' => 3, 'text' => JText::_('middle left')), 
    '3' => array('value' => 4, 'text' => JText::_('middle right')), 
    '4' => array('value' => 5, 'text' => JText::_('bottom left')), 
    '5' => array('value' => 6, 'text' => JText::_('bottom right')),
    '6' => array('value' => 7, 'text' => JText::_('None'))
);
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
                        <li class="header-parts first-part">
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
                        <li class="header-parts third-part active">
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
                        <span class="heading-post-ins jsjob-configurations-heading"><?php echo JText::_('Sample Data');?></span>
                        <span class="heading-post-ins jsjob-config-steps"><?php echo JText::_('Step 3 of 4');?></span>
                    </div>
                    <div class="post-installtion-content">
                        <form id="jsjobs-form-ins" method="post" action="index.php">
                             <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Import Menu');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'importmenu', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',1); ?>
                                </div> 
                                <div class="desc">
                                    <?php echo JText::_("Employer and job seeker menus will be created on frontend"); ?>
                                </div>                              
                            </div> 
                            <div class="pic-config">
                                <div class="title sample-data-label"> 
                                    <?php echo JText::_('Import Sample Data');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'sampledata', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',1); ?>
                                    <div class="desc sample-data-desc">
                                        <?php echo JText::_("Demo users, companies, jobs and resumes will be inserted into system"); ?>
                                    </div>   
                                    <div class="sample-data-heading"><?php echo JText::_("Employer"); ?></div>
                                    <div class="sample-data-text"><?php echo JText::_("Username"); ?>: <b>jsjobs_employer</b></div>
                                    <div class="sample-data-text"><?php echo JText::_("Password"); ?>: <b>demo</b></div>
                                    <div class="sample-data-heading"><?php echo JText::_("Job Seeker"); ?></div>
                                    <div class="sample-data-text"><?php echo JText::_("Username"); ?>: <b>jsjobs_jobseeker</b></div>
                                    <div class="sample-data-text"><?php echo JText::_("Password"); ?>: <b>demo</b></div>
                                </div>                            
                            </div>  
                            

                            <div class="pic-button-part">
                                <a class="next-step" href="#"  onclick="document.getElementById('jsjobs-form-ins').submit();" >
                                    <?php echo JText::_('Next'); ?>
                                    <img src="components/com_jsjobs/include/images/postinstallation/next-arrow.png">
                                </a>
                                <a class="back" href="index.php?option=com_jsjobs&c=postinstallation&layout=stepthree"> 
                                   <img src="components/com_jsjobs/include/images/postinstallation/back-arrow.png">
                                    <?php echo JText::_('Back'); ?>
                                </a>
                            </div>
                            
                            <input type="hidden" name="task" value="save" />
                            <input type="hidden" name="c" value="postinstallation" />
                            <input type="hidden" name="layout" value="stepthree" />
                            <input type="hidden" name="step" value="4">
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
