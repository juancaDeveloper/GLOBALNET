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

global $mainframe;

$editor = JFactory::getEditor();
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();
?>

<script language="javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'folder.savefolder') {
                returnvalue = validate_form(document.adminForm);
            } else
                returnvalue = true;
            if (returnvalue) {
                Joomla.submitform(task);
                return true;
            } else
                return false;
        }
    }
    function validate_form(f) {
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

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=folder&view=folder&layout=folders"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
        <?php if (isset($this->folders->id)){ ?>
        <span id="heading-text"><?php echo JText::_('Edit Folder'); ?></span>
        <?php }else{ ?>
        <span id="heading-text"><?php echo JText::_('Form Folder'); ?></span>
         <?php } ?>
        </div>
        <form action="index.php" method="post" name="adminForm" id="adminForm"  >
            <div class="js-form-area">
                <input type="hidden" name="check" value="post"/>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="name"><b><?php echo JText::_('Folder'); ?></b></label>
                    <div class="jsjobs-value"><input class="inputbox required" type="text" name="name" id="name" size="40" maxlength="255" value="<?php if (isset($this->folders)) echo $this->folders->name; ?>" /></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="name"><b><?php echo JText::_('Description'); ?>:</b>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"> <?php
                            $editor = JFactory::getEditor();
                            if (isset($this->folders))
                                echo $editor->display('decription', $this->folders->decription, '550', '300', '60', '20', false);
                            else
                                echo $editor->display('decription', '', '550', '300', '60', '20', false);
                            ?>
                    </div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Status'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><?php echo $this->lists['status']; ?></div>
                </div>
            <?php
                if (isset($this->folders))
                    $curdate = $this->folders->created;
                else
                    $curdate = date('Y-m-d H:i:s');
                ?>
                <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="uid" value="<?php if (isset($this->folders))
                    echo $this->folders->uid;
                else
                    echo $this->uid;
                ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="global"  value="1" />
                <input type="hidden" name="task" value="folder.savefolder" />
                <input type="hidden" name="id" value="<?php if (isset($this->folders)) echo $this->folders->id; ?>" />
            </div>
            <div class="js-buttons-area">
                <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=folder&view=folder&layout=folders"><?php echo JText::_('Cancel'); ?></a>
                <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save Folder'); ?>" />
            </div>
        <?php echo JHTML::_( 'form.token' ); ?>        
        </form>
    </div>
</div>
<div id="jsjobsfooter">
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
