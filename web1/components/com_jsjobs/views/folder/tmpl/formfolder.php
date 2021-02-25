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
JHTML::_('behavior.calendar');
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

    <script language="javascript">
        function myValidate(f) {
            if (document.formvalidator.isValid(f)) {
                f.check.value = '<?php if (JVERSION < 3)
        echo JUtility::getToken();
    else
        echo JSession::getFormToken();
    ?>';//send token
            }
            else {
                alert("<?php echo JText::_("Some values are not acceptable").'. '.JText::_("Please retry"); ?>");
                return false;
            }
            return true;
        }

    </script>
    <?php
    if (isset($this->folders->id)) {
         $heading = "Edit Folders Info";
    }else{
         $heading = "Folders Info";
    }   
    ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_("$heading"); ?></span> 
    <?php    
    if ($this->canaddnewfolder == VALIDATE) { // add new Folder, in edit case always VAlidate
        ?>
             <div class="jsjobs-folderinfo">
            <form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate jsautoz_form" onSubmit="return myValidate(this);">
                <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <label id="namemsg" for="name"><strong><?php echo JText::_('Folder'); ?></strong>&nbsp;<font color="red">*</font></label>
                    </div>
                    <div class="fieldvalue">
                        <input class="inputbox-required" type="text" name="name" id="name"  value="<?php if (isset($this->folders)) echo $this->folders->name; ?>" />
                    </div>
                </div>				        
        <?php ?>
                <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <label id="decriptionmsg" for="decription"><strong><?php echo JText::_('Description'); ?></strong>&nbsp;<font color="red">*</font></label>
                    </div>
                    <div class="fieldvalue">
                        <?php
                        if ($this->config['comp_editor'] == '1') {
                            $editor = JFactory::getEditor();
                            if (isset($this->folders))
                                echo $editor->display('decription', $this->folders->decription, '100%', '100%', '60', '20', false);
                            else
                                echo $editor->display('decription', '', '100%', '100%', '60', '20', false);
                        } else {
                            ?>	
                            <textarea class="inputbox required" name="decription" id="decription" cols="60" rows="5"><?php if (isset($this->folders)) echo $this->folders->decription; ?></textarea>
        <?php } ?>
                    </div>
                </div>				        

                <div class="fieldwrapper-btn">
                    <div class="jsjobs-folder-info-btn">
                        <sapn class="jsjobs-folder-btn">
                    <input id="button-save" class="button jsjobs_button" type="submit" name="submit_app" onclick="return myValidate(f)" value="<?php echo JText::_('Save'); ?>" />
                    </sapn>
                  </div>
                </div>
                <?php
                if (isset($this->folders))
                    $curdate = $this->folders->created;
                else
                    $curdate = date('Y-m-d H:i:s');
                ?>
                <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="status" value="<?php echo $this->folders->status; ?>" />
                <input type="hidden" name="global"  value="1" />
                <input type="hidden" name="task" value="savefolder" />
                <input type="hidden" name="c" value="folder" />
                <input type="hidden" name="check" value="" />
        <?php if (isset($this->packagedetail[0])) echo '<input type="hidden" name="packageid" value="' . $this->packagedetail[0] . '" />'; ?>
        <?php if (isset($this->packagedetail[1])) echo '<input type="hidden" name="paymenthistoryid" value="' . $this->packagedetail[1] . '" />'; ?>

                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                <input type="hidden" name="id" value="<?php if (isset($this->folders)) echo $this->folders->id; ?>" />
                <?php echo JHTML::_('form.token'); ?>
            </form>
            </div>
        <?php
    } else { // can not add new folder
        switch ($this->canaddnewfolder) {
            case NO_PACKAGE:
                $link = "index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=".$this->Itemid;
                $this->jsjobsmessages->getPackageExpireMsg('You do not have package', 'Package is required to perform this action, please get package', $link);
            break;
            case EXPIRED_PACKAGE:
                $link = "index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=".$this->Itemid;
                $vartext = JText::_('Package is required to perform this action and your current package is expired').','.JText::_('please get new package');
                $this->jsjobsmessages->getPackageExpireMsg('Your current package is expired', $var, $link);
                break;
            case FOLDER_LIMIT_EXCEEDS:
                $link = "index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=".$this->Itemid;
                $vartext = JText::_('You can not add new folder') .', '. JText::_('Please get new package to extend your folder limit');
                $this->jsjobsmessages->getPackageExpireMsg('Folder limit exceed',$vartext, $link);
                break;
            case JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Job seeker not allowed', 'Job seeker is not allowed in employer private area', 0);
                break;
            case USER_ROLE_NOT_SELECTED:
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role', $vartext, $link);
                break;
            case VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
                break;
        }
    } ?>
    </div>
    <?php    
}//ol
?>
</div> 
