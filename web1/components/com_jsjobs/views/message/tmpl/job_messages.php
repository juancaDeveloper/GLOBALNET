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
         <span class="jsjobs-main-page-title"><?php echo JText::_('Messages'); ?></span>
    <?php
    if ($this->userrole->rolefor == 1) { // employer
        if (isset($this->messages)) {
            ?>
                <form action="index.php" method="post" name="adminForm">
                    <?php if (isset($this->messages)) { ?>
                        <?php foreach ($this->messages as $message) { ?>
                            <div class="jsjobs-listing-wrapper">
                               <div class="jsjobs-messages-list">
                                <div class="jsjobs-message-title">
                                    <span class="jsjobs-messages-covertitle">
                                    <span class="jsjobs_message_title">
                                       <span class="jsjobs_message"> <?php echo JText::_('Job Seeker')?> : </span>
                                      <?php
                                        echo $message->first_name;
                                        if ($message->middle_name)
                                            echo ' ' . $message->middle_name;
                                        echo ' ' . $message->last_name;
                                        ?></span>
                                     </span> 
                                     
                                     <span class="jsjobs_message_title-vlaue">
                                       <span class="jsjobs_message"><?php echo JText::_('Resume')?> : </span>
                                     <?php
                                        echo $message->application_title;
                                        ?>
                                      </span>

                                </div>
                                <div class="jsjobs-message-button-area">
                                      <span class="jsjsobs-message-btn">
                                        <?php $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=send_message&bd=' . $message->jobaliasid . '&rd=' . $message->resumealiasid . '&nav=12&Itemid=' . $this->Itemid; ?>
                                    <a class="js_button_message" href="<?php echo $link ?>" class="" title="<?php echo JText::_('Messages'); ?>">
                                        <?php
                                        if ($message->unread > 0)
                                            echo '<strong>' . JText::_('Messages') . ' [' . $message->unread . ']</strong>';
                                        else
                                            echo JText::_('Messages');
                                        ?>
                                       
                                    </a>

                                    </span>
                                </div>
                                </div>
                            </div>
                    <?php
                }
            }
            ?>		
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="task" value="deletejob" />
                    <input type="hidden" name="c" value="job" />
                    <input type="hidden" id="id" name="id" value="" />
                    <input type="hidden" name="boxchecked" value="0" />

                </form>
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=message&view=message&layout=job_messages&bd=' . $this->messages[0]->jobaliasid . '&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
    } ?>
            </div>
    <?php
}//ol
?>	
</div> 
