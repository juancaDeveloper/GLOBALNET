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
$ticketidsequence = array(
    '0' => array('value' => '1',
        'text' => JText::_('Random')),
    '1' => array('value' => '2',
        'text' => JText::_('Sequential')),);
$owncaptchaoparend = array(
    array('value' => '2', 'text' => JText::_('2')),
    array('value' => '3', 'text' => JText::_('3'))
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
                    <a href="index.php?option=com_jsjobs&c=jssupportticket&layout=controlpanel" class="close-button">
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
                        <li class="header-parts second-part active">
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
                        <span class="heading-post-ins jsjob-configurations-heading"><?php echo JText::_('Employer Settings');?></span>
                        <span class="heading-post-ins jsjob-config-steps"><?php echo JText::_('Step 2 of 4');?></span>
                    </div>
                    <div class="post-installtion-content">
                        <form id="jssupportticket-form-ins" method="post" action="index.php">
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Allow User Register As Employer');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'showemployerlink', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['showemployerlink']); ?>
                                </div>
                                <div class="desc"><?php echo JText::_('Effects on user registration');?> </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Employer Can View Job Seeker Area');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'employerview_js_controlpanel', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['employerview_js_controlpanel']); ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Visitor can post job');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'visitor_can_post_job', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['visitor_can_post_job']); ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Company Auto Approve');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'companyautoapprove', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['companyautoapprove']); ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Job Auto Approve');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'jobautoapprove', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['jobautoapprove']); ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Enable gold job');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'show_fe_goldcompany_button', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['show_fe_goldcompany_button']); ?>
                                </div>
                                <div class="desc"><?php echo JText::_('Show hide frontend gold button form company listing');?> </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Enable featured job');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'show_fe_featuredcompany_button', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['show_fe_featuredcompany_button']); ?>
                                </div>
                                <div class="desc"><?php echo JText::_('Show hide frontend featured button form company listing');?> </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Package Required For Employer');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'newlisting_requiredpackage', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['newlisting_requiredpackage']); ?>
                                </div>
                            </div>
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Visitor can serch resume');?>:  
                                </div>
                                <div class="field"> 
                                    <?php echo JHTML::_('select.genericList', $yesno, 'visitorview_emp_resumesearch', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['visitorview_emp_resumesearch']); ?>
                                </div>
                                <div class="desc"><?php echo JText::_('Show hide frontend featured button form company listing');?> </div>
                            </div> 
                            <div class="pic-config">
                                <div class="title"> 
                                    <?php echo JText::_('Employer default role');?>:  
                                </div>
                                <div class="field">  
                                    <?php echo JHTML::_('select.genericList', $this->getJSModel('jsjobs')->getUserGroups(), 'employer_defaultgroup', 'class="inputbox js-select jsjob-postsetting" ' . '', 'value', 'text',$this->result['employer_defaultgroup']); ?>
                                </div>
                                <div class="desc"><?php echo JText::_('This role will auto assign to new employer');?> </div>
                            </div> 


                            <div class="pic-button-part">
                                <a class="next-step" href="index.php?option=com_jsjobs&c=postinstallation&layout=stepthree"  onclick="document.getElementById('jssupportticket-form-ins').submit();" >
                                    <?php echo JText::_('Next'); ?>
                                    <img src="components/com_jsjobs/include/images/postinstallation/next-arrow.png">
                                </a>
                                <a class="back" href="index.php?option=com_jsjobs&c=postinstallation&layout=stepone"> 
                                   <img src="components/com_jsjobs/include/images/postinstallation/back-arrow.png">
                                    <?php echo JText::_('Back'); ?>
                                </a>
                            </div>
                            
                            <input type="hidden" name="task" value="save" />
                            <input type="hidden" name="c" value="postinstallation" />
                            <input type="hidden" name="layout" value="stepthree" />
                            <input type="hidden" name="step" value="3">
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