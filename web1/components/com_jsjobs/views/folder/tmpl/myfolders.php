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
<script language=Javascript>
    function confirmdeletefolder() {
        return confirm("<?php echo JText::_('Are you sure to delete the folder').'!'; ?>");
    }
</script>
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
    if ($this->myfolder_allowed == VALIDATE) { ?>
    <div id="jsjobs-main-wrapper">       
        <span class="jsjobs-main-page-title"><span class="jsjobs-title-componet"><?php echo JText::_('My Folders'); ?></span>
        <span class="jsjobs-add-resume-btn"><a class="jsjobs-resume-a" href="index.php?option=com_jsjobs&c=folder&view=folder&layout=formfolder&Itemid=<?php echo $this->Itemid; ?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/add-icon.png"><span class="jsjobs-add-resume-btn"><?php echo JText::_('Add New Folder');?></span></a></span>
        </span>
    <?php
        if ($this->folders) {
            ?>
                <?php foreach ($this->folders as $folder) { ?>
                    <div class="jsjobs-folderinfon">
                      <div class="jsjobs-listfolders">
                        <div class="jsjobs-message-title">
                             <?php echo $folder->name; ?>               
                        </div>
                        <div class="jsjobs-status-button">
                            <span class="jsjobs-message-created">
                                <span class="js_message_created_title"><?php echo JText::_('Status'); ?>:</span>
                                <strong>
                                    <?php
                                    if ($folder->status == 1)
                                        echo '<font color="#99D000">' . JText::_('Approved') . '</font>';
                                    elseif ($folder->status == 0) {
                                        echo '<font color="#FC9735;"> ' . JText::_('Pending') . '</font>';
                                    } elseif ($folder->status == -1)
                                        echo '<font color="red"> ' . JText::_('Rejected') . '</font>';
                                    ?>
                                </strong>
                            </span>
                            <span class="jsjobs-message-btn">
                                <?php if ($folder->status == 0) { ?>
                                            <font id="jsjobs-status-btn" class="folder"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Waiting for approval');?></font>
                                        
                                    <?php } elseif ($folder->status == 1) { ?>
                                           <a class="js_listing_icon" href="index.php?option=com_jsjobs&c=folder&view=folder&layout=formfolder&fd=<?php echo $folder->folderaliasid; ?>&Itemid=<?php echo $this->Itemid; ?>"  title="<?php echo JText::_('Edit'); ?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/edit.png" /></a>
                                            <a class="js_listing_icon" href="index.php?option=com_jsjobs&c=folder&view=folder&layout=viewfolder&fd=<?php echo $folder->folderaliasid; ?>&Itemid=<?php echo $this->Itemid; ?>"  title="<?php echo JText::_('View'); ?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/view.png" /></a>
                                            <a class="js_listing_icon" href="index.php?option=com_jsjobs&task=folder.deletefolder&fd=<?php echo $folder->folderaliasid; ?>&Itemid=<?php echo $this->Itemid; ?>&<?php echo JSession::getFormToken(); ?>=1" onclick=" return confirmdeletefolder();"  title="<?php echo JText::_('Delete'); ?>">
                                                <img class="icon" src="<?php echo JURI::root();?>components/com_jsjobs/images/force-delete.png" />
                                    </a>
                                        <?php if ($folder->status == 1) { ?>
                                            <?php $link = 'index.php?option=com_jsjobs&c=folder&view=folder&layout=folder_resumes&fd=' . $folder->folderaliasid . '&Itemid=' . $this->Itemid; ?>
                                                <a class="jsjobs-button-message-noof" href="<?php echo $link ?>" >
                                                    <?php echo JText::_('Resume');
                                                    echo ' (' . $folder->noofresume . ')'; ?>
                                                </a>
                                        <?php } ?>
                            </span>
                              
                <?php } ?>
                        </div>
                        </div>
                    </div>
            <?php } ?>
                <input type="hidden" name="layout" value="myfolders" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />

            <form id="jsjobs_pagination_form" action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=folder&view=folder&layout=myfolders&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
        <?php } else { // no result found in this category 
                $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
            } ?>
    </div>        
    <?php  
    } else { // not allowed job posting    
        switch ($this->myfolder_allowed) {
            case JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Job seeker not allowed', 'Job seeker is not allowed in employer private area', 0);
            break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role', $vartext, $link);
                break;
            case VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
                break;
        }
    }  
}//ol
?>	
</div>
