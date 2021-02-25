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

jimport('joomla.application.component.model');
JHTML::_('behavior.formvalidation');
?>
<script language="javascript">
    function myValidate(f) {
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php if (JVERSION < 3)
    echo JUtility::getToken();
else
    echo JSession::getFormToken();
?>';//send token
        } else {
            alert("<?php echo JText::_("Some values are not acceptable").'. '.JText::_("Please retry"); ?>");
            return false;
        }
        return true;
    }

</script>
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
            <span class="jsjobs-main-page-title"><?php echo JText::_('Send Message'); ?></span>
    <?php
    if ($this->canadd == 1) { // employer
        ?>

            <div class="jsjobs-message-send-list"> 
        
            <form action="index.php" method="post" name="adminForm" id="adminForm">
               <div class="jsjobs-main-message-wrap">
                 <div class="jsjobs-main-message">
                   <div class="jsjobs-company-logo">
                     <span class="jsjobs-img-wrap">
                       <span class="jsjobs-img-border">
                    <?php
                    $logourl = JSModel::getJSModel('common')->getCompanyLogo( $this->summary->companyid , $this->summary->companylogo , $this->config , 2 );
                    $userrole = $this->getJSModel('userrole')->getUserRoleByUid($this->uid);
                    if ($userrole == 1)
                        $sentby =  JText::_('Employer Sent');
                    elseif($userrole == 2)
                        $sentby =  JText::_('Job Seeker Sent');
                    ?>
                    <img class="js_job_company_logo" src="<?php echo $logourl; ?>" />
                       </span>
                    </span>
                   </div>
                <div class="jsjobs-company-data">
                    <div class="jsjobs-data-wrapper border-class"> 
                        <span class="jsjobs-job-main">                        
                            <span class="jsjobs-data-value"><?php if (isset($this->summary)) echo $this->summary->title; ?></span>
                            &nbsp;(<?php if (isset($this->summary)) echo $this->summary->application_title; ?>)
                        </span>
                    </div>
                    <div class="jsjobs-data-wrapper">
                     <span class="jsjobs-main-company"> 
                        <span class="jsjobs-data-title"><?php echo JText::_('Company'); ?> : </span>
                        <span class="jsjobs-data-value"><?php if (isset($this->summary)) echo $this->summary->companyname; ?></span>
                     </span>
                        <span class="jsjobs-main-job">
                          <span class="jsjobs-data-title"><?php echo $sentby; ?> : </span>
                          <span class="jsjobs-data-value"><?php
                             if (isset($this->summary->first_name))
                                echo $this->summary->first_name;
                             if (isset($this->summary->middle_name))
                                echo ' ' . $this->summary->middle_name;
                             if (isset($this->summary->last_name))
                                echo ' ' . $this->summary->last_name;
                    ?>   </span>
                       </span>
                    </div>
                </div>
                </div>
                </div>
                <?php
                if(isset($this->messages) AND (!empty($this->messages))){
                    $m = end($this->messages);  ?>
                    <div class="jsjobs-data-wrapper">
                        <div class="jsjobs-data-title-subject">
                            <?php echo JText::_('Subject'); ?>
                        </div>
                        <div class="jsjobs-data-value-subject">
                        <?php echo $m->subject;?>
                        </div>
                    </div> 
                    <div class="jsjobs-data-wrapper">
                        <div class="jsjobs-data-title-message">
                            <?php echo JText::_('Message'); ?>
                        </div>
                        <div class="jsjobs-data-value-message">
                            <?php echo $m->message;?>                        
                        </div>
                    </div>
                <?php
                }else{ ?>
                    <div class="jsjobs-data-wrapper">
                        <div class="jsjobs-data-title">
                            <?php echo JText::_('Subject'); ?>&nbsp;<font color="red">*</font>
                        </div>
                        <div class="jsjobs-data-value">
                            <input class="inputbox required" type="text" name="subject" id="subject" maxlength="255" value="<?php if (isset($this->job)) echo $this->job->subject; ?>" />
                        </div>
                    </div> 
                    <?php
                }
                ?>
                <div class="jsjobs-data-wrapper">
                    <div class="jsjobs-data-title">
                        <?php echo JText::_('Message'); ?>&nbsp;<font color="red">*</font>
                    </div>
                    <div class="jsjobs-data-value">
                            <?php
                               $editor = JFactory::getEditor();
                               if (isset($this->job))
                               echo $editor->display('message', $this->job->message, '100%', '100%', '60', '20', false);
                               else
                               echo $editor->display('message', '', '100%', '100%', '60', '20', false);
                            ?>
                    </div>
                </div>				        
                <div class="fieldwrapper-btn">
                    <div class="jsjobs-folder-info-btn">
                        <sapn class="jsjobs-folder-btn">
                            <input class="jsjobs-send-message-button button" type="submit" name="submit" onClick="return myValidate(document.adminForm);" value="<?php echo JText::_('Send Message'); ?>" />
                        </sapn>
                   </div>
                </div>				        
                <?php
                if (isset($this->company)) {
                    if (($this->company->created == '0000-00-00 00:00:00') || ($this->company->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $this->company->created;
                }else {
                    $uid = $this->uid;
                    $curdate = date('Y-m-d H:i:s');
                }
                ?>
                <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="savemessage" />
                <input type="hidden" name="check" id="check" value="" />
                <input type="hidden" name="c" value="message" />
                <input type="hidden" id="id" name="id" value="" />
                <input type="hidden" id="replytoid" name="replytoid" value="<?php if (isset($this->messages[0])) echo $this->messages[0]->id; else echo '0';?>" />
                <input type="hidden" id="employerid" name="employerid" value="<?php if (isset($this->summary)) echo $this->summary->employerid; ?>" />
                <input type="hidden" id="jobseekerid" name="jobseekerid" value="<?php if (isset($this->summary)) echo $this->summary->jobseekerid; ?>" />
                <input type="hidden" id="jobid" name="jobid" value="<?php if (isset($this->summary)) echo $this->summary->jobid; ?>" />
                <input type="hidden" id="resumeid" name="resumeid" value="<?php if (isset($this->summary)) echo $this->summary->resumeid; ?>" />
                <input type="hidden" name="nav" value="<?php echo $this->nav; ?>" />
                <input type="hidden" name="boxchecked" value="0" />
                 <?php echo JHTML::_( 'form.token' ); ?>
            </form>
            <span class="jsjobs-controlpanel-section-title"><?php echo JText::_('Message History'); ?></span>
                    <?php if ($this->totalresults != 0) { ?>
                        <?php if (isset($this->messages) AND (!empty($this->messages))) { ?>
                            <?php for ($i=0; $i < count($this->messages)-1; $i++) { 
                                $message = $this->messages[$i]; ?>
                        <div class="jsjobs-message-history-wrapper <?php if ($this->uid == $message->sendby)
                        echo "yousend";
                    else
                        echo "othersend";
                    ?>">
                    <span class="jsjobs-img-sender">
                        <span class="jsjobs-img-area"> 
                            <img src="<?php echo JURI::root();?>components/com_jsjobs/images/Users.png">
                        </span>
                    </span>
                    
                    <div class="jsjobs-message-right-top">
                                 <span class="jsjobs-message-name">
                                <?php

                                $userrole = $this->getJSModel('userrole')->getUserRoleByUid($this->uid);
                                $user = JFactory::getUser();
                                $uid = $user->id;
                                if($userrole == 1){ // Employer
                                    if($uid == $message->sendby){
                                        echo JText::_('You sent');
                                    }else{
                                        echo JText::_('Job seeker sent');
                                    }
                                }elseif($userrole == 2){ // Job seeker
                                    if($uid == $message->sendby){
                                        echo JText::_('You sent');
                                    }else{
                                        echo JText::_('Employer sent');
                                    }
                                }

                                ?>
                                </span>
                            <div class="jsjobs-message-created">
                                   <?php $created = JHtml::_('date', $message->created, $this->config['date_format'] . ' H:i:s');
                                      echo $created;
                                        ?>
                            </div>
                            </div>
                            <div class="jsjobs-message-data-wrapper">
                                <span class="jsjobs-message-value"><?php echo $message->message; ?></span>
                            </div>
                        </div>
                    <?php
                }
            }
        }else { // no result found in this category
            echo '<tr><td>' . JText::_('Message history not found') . '</td></tr>';
        }
        ?>

        </div>
        <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=message&view=message&layout=send_message&bd=' . $this->jobaliasid . '&rd=' . $this->resumealiasid . '&nav=' . $this->nav . '&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
    <?php } else { // not allowed job posting 
            $this->jsjobsmessages->getAccessDeniedMsg('You do not have this feature', 'You do not have this feature', 0);
            } ?>
        </div>
            <?php
}//ol
?>	
</div> 
