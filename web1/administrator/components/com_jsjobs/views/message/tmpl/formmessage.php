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
            if (task == 'message.save') {
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
    function validate_form(f)
    {
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php if (JVERSION < 3) 
                                        echo JUtility::getToken(); 
                                    else 
                                        echo JSession::getFormToken(); ?>'; //send token
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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=message&view=message&layout=messages"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <?php if (isset($this->message->id)){ ?>
            <span id="heading-text"><?php echo JText::_('Edit Message'); ?></span>
            <?php }else{ ?>
            <span id="heading-text"><?php echo JText::_('Form Message'); ?></span>
            <?php } ?>
        </div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm" >    
            <div class="js-form-area">
            <?php if (isset($this->summary)) { ?>
            <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Job'); ?></label>
                    <div class="jsjobs-value"><?php echo $this->summary->title; ?></div>
            </div>
            <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Job Seeker'); ?></label>
                    <div class="jsjobs-value"><?php
                                            echo $this->summary->first_name;
                                            if ($this->summary->middle_name)
                                                echo ' ' . $this->summary->middle_name;
                                            echo ' ' . $this->summary->last_name;
                                            ?></div>
            </div>
            <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Resume'); ?></label>
                    <div class="jsjobs-value"><?php echo $this->summary->application_title; ?></div>
            </div>
            <?php } else {
            }
            ?>
            <?php
                $flag = true;
                if(isset($this->message->replytoid) && $this->message->replytoid != 0){
                    $flag = false;
                }
                if($flag == true){
            ?>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="name"><?php echo JText::_('Subject'); ?>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><input class="inputbox required" type="text" name="subject" id="name" size="40" maxlength="255" value="<?php if (isset($this->message->subject)) echo $this->message->subject; ?>" /></div>
                </div>
            <?php } ?>
            <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="messages"><?php echo JText::_('Message'); ?>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"> <?php
                        $editor = JFactory::getEditor();
                        if (isset($this->message->message)){
                            echo $editor->display('message', $this->message->message, '550', '300', '60', '20', false);
                        }else{
                            echo $editor->display('message', '', '550', '300', '60', '20', false);
                        }
                        ?></div>
            </div>
            <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Status'); ?></label>
                    <div class="jsjobs-value"><?php print_r($this->lists['status']); ?></div>
            </div>
                <?php
                if (isset($this->message->created)) {
                    if (($this->message->created == '0000-00-00 00:00:00') || ($this->message->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $this->message->created;
                }else {
                    $uid = $this->uid;
                    $curdate = date('Y-m-d H:i:s');
                }
                ?>
                <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="id" value="<?php if (isset($this->message->id)) echo $this->message->id; ?>" />
                <input type="hidden" name="sendby" value="<?php echo $this->message->employerid; ?>" />
                <input type="hidden" name="task" value="message.savemessage" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php if (isset($this->summary)) { ?>
                <input type="hidden" id="employerid" name="employerid" value="<?php if (isset($this->summary)) echo $this->summary->employerid; ?>" />
                <input type="hidden" id="jobseekerid" name="jobseekerid" value="<?php if (isset($this->summary)) echo $this->summary->jobseekerid; ?>" />
                <input type="hidden" id="jobid" name="jobid" value="<?php if (isset($this->summary)) echo $this->summary->jobid; ?>" />
                <input type="hidden" id="resumeid" name="resumeid" value="<?php if (isset($this->summary)) echo $this->summary->resumeid; ?>" />
                <?php }else {
                if (isset($this->message))
                    
                    ?>
                <input type="hidden" name="jobid" id="jobid" value="<?php echo $this->message->jobid; ?>" />
                <input type="hidden" name="resumeid" id="resumeid" value="<?php echo $this->message->resumeid; ?>" />
                <input type="hidden" id="employerid" name="employerid" value="<?php echo $this->message->employerid; ?>" />
                <input type="hidden" id="jobseekerid" name="jobseekerid" value="<?php echo $this->message->jobseekerid; ?>" />
                <?php } ?>
                <input type="hidden" id="sm" name="sm" value="<?php echo $this->sm; ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>        
            
        </div>
            <div class="js-buttons-area">
                <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=message&view=message&layout=messages"><?php echo JText::_('Cancel'); ?></a>
                <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save Message'); ?>" />
            </div>
        </form>
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







