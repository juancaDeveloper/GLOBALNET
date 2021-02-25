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
$link = 'index.php?option=com_jsjobs&c=message&view=message&layout=jsmessages&Itemid=' . $this->Itemid;
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'messages') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'messages') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
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
    if ($this->mymessage_allowed == VALIDATE) {
        if ($this->messages) {
            ?>
                <form action="index.php" method="post" name="adminForm">
                    <?php foreach ($this->messages as $message) { ?>
                        <div class="jsjobs-listing-wrapper">
                           <div class="jsjobs-messages-list">
                            <div class="jsjobs-message-title">
                                <span class="jsjobs-messages-covertitle">
                                <span class="jsjobs_message_title"><span class="jsjobs_message"><?php echo JText::_('Job Title : ')?></span><?php echo $message->title; ?></span>
                                 <span class="jsjobs-message-created">
                                    <span class="js_message_created_title"><?php echo JText::_('Posted'); ?></span>
                                    <?php echo JHtml::_('date', $message->created, $this->config['date_format']); ?>
                                </span>
                                </span>
                                <span class="jsjobs-messages-company"> 
                                 <span class="jsjobs_message"><?php echo JText::_('Company'); ?> : </span>
                                <?php 
                                $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($message->companyaliasid);
                                $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=36&cd=' . $companyaliasid . '&Itemid=' . $this->Itemid; 
                                ?>
                                <a class="js_job_anchor" href="<?php echo $link ?>">
                                <?php echo  $message->companyname; ?></a>
                                </span>
                            </div>
                            <div class="jsjobs-message-button-area">
                                <span class="jsjsobs-message-btn">
                                <?php $link = 'index.php?option=com_jsjobs&c=message&view=message&layout=send_message&bd=' . $message->jobaliasid . '&rd=' . $message->resumealiasid . '&nav=11&Itemid=' . $this->Itemid; ?>
                                <a  href="<?php echo $link ?>" class="" title="<?php echo JText::_('Messages'); ?>">
                                    <?php if ($message->unread > 0)
                                        echo '<strong>' . JText::_('Messages') . ' [' . $message->unread . ']</strong>';
                                    else
                                        echo JText::_('Messages');
                                    ?>
                                     
                                </a>

                                </sapn>
                            </div>
                            </div>
                        </div>
                <?php
            }
            ?>		
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="task" value="deletejob" />
                    <input type="hidden" name="c" value="job" />
                    <input type="hidden" id="id" name="id" value="" />
                    <input type="hidden" name="boxchecked" value="0" />
                </form>
                <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=message&view=message&layout=jsmessages&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
    } else {
        $itemid = JRequest::getVar('Itemid');
        switch ($this->mymessage_allowed) {
            case EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Employer not allowed', 'Employer is not allowed in job seeker private area', 0);
            break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role',$vartext, $link);
            break;
            case VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
            break;
        }
    } ?>
            </div>
    <?php
}//ol
?>	
</div> 
