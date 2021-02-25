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
jimport('joomla.html.pane');
$document = JFactory::getDocument();
$document->addStyleSheet('../components/com_jsjobs/css/token-input-jsjobs.css');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('../components/com_jsjobs/js/jquery.tokeninput.js');
$editor = JFactory::getEditor();
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
?>
<script language="javascript">
    function submitbutton(pressbutton) {
        if (pressbutton) {
            document.adminForm.task.value = pressbutton;
        }
        if (pressbutton == 'jobalert.save') {
            returnvalue = validate_form(document.adminForm);
        } else
            returnvalue = true;

        if (returnvalue == true) {
            try {
                document.adminForm.onsubmit();
            }
            catch (e) {
            }
            document.adminForm.submit();
        }
    }

    function validate_form(f)
    {
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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jobalert&view=jobalert&layout=jobalert"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <?php if (isset($this->jobalert->id)){ ?>
            <span id="heading-text"><?php echo JText::_('Edit Job Alert'); ?></span>
            <?php }else{ ?>
            <span id="heading-text"><?php echo JText::_('Form Job Alert'); ?></span>
            <?php } ?>
        </div>
      <form action="index.php" method="POST" name="adminForm" id="adminForm">
            <div class="js-form-area">
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="name"><?php echo JText::_('Name'); ?>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><input class="inputbox required " type="text" name="name" id="name" size="40" maxlength="100" value="<?php if (isset($this->jobalert)) echo $this->jobalert->name; ?>" /></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="categoryid"><?php echo JText::_('Categories'); ?>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><?php if (isset($this->lists['jobcategory'])) echo $this->lists['jobcategory']; ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="subcategoryid"><?php echo JText::_('Sub Category'); ?></label>
                    <div class="jsjobs-value"><?php echo $this->lists['subcategory']; ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="contactemail"><?php echo JText::_('Contact Email'); ?>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><input class="inputbox required validate-email" type="text" name="contactemail" id="contactemail" size="40" maxlength="100" value="<?php if (isset($this->jobalert)) echo $this->jobalert->contactemail; ?>" /></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="city"><?php echo JText::_('City'); ?></label>
                    <div class="jsjobs-value"><input class="inputbox" type="text" name="city" id="jobalertcity" size="40" maxlength="100" value="" /></div>
                     <div class="jsjobs-value"><input type="hidden" name="cityidforedit" id="cityidforedit" value="<?php if (isset($this->multiselectedit)) echo $this->multiselectedit; ?>" />
                    </div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="zipcode"><?php echo JText::_('Zip Code'); ?></label>
                    <div class="jsjobs-value"><input class="inputbox" type="text" name="zipcode" size="40" maxlength="100" value="<?php if (isset($this->jobalert)) echo $this->jobalert->zipcode; ?>" /></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="keywords"><?php echo JText::_('Keywords'); ?></label>
                    <div class="jsjobs-value"><textarea class="inputbox-form-jobalert" cols="46" name="keywords" rows="4" style="resize:none;" ><?php if (isset($this->jobalert)) echo $this->jobalert->keywords; ?></textarea></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="alerttype"><?php echo JText::_('Alert Type'); ?>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><?php if (isset($this->lists['alerttype'])) echo $this->lists['alerttype']; ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Status'); ?></label>
                    <div class="jsjobs-value"><?php if (isset($this->lists['status'])) echo $this->lists['status']; ?></div>
                </div>

            <input type="hidden" name="created" value="<?php echo $this->jobalert->created; ?>" />
            <input type="hidden" name="check" value="" />
            <input type="hidden" name="uid" value="<?php echo $this->jobalert->uid; ?>" />
            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            <input type="hidden" name="task" value="jobalert.savejobalert" />
          <input type="hidden" name="id" value="<?php if(isset($this->jobalert)) echo $this->jobalert->id; ?>" />

        </div>
        <div class="js-buttons-area">
            <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=jobalert&view=jobalert&layout=jobalert"><?php echo JText::_('Cancel'); ?></a>
            <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save Job Alert'); ?>" />
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
<script type="text/javascript">
    jQuery(document).ready(function () {
        var value = jQuery("#cityidforedit").val();
        if (value != "") {
            jQuery("#jobalertcity").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('Type In A Search'); ?>",
                noResultsText: "<?php echo JText::_('No Results'); ?>",
                searchingText: "<?php echo JText::_('Searching...'); ?>",
                tokenLimit: 5,
                prePopulate: <?php if (isset($this->multiselectedit))
    echo $this->multiselectedit;
else
    echo "''";
?>
            });

        } else {
            jQuery("#jobalertcity").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('Type In A Search'); ?>",
                noResultsText: "<?php echo JText::_('No Results'); ?>",
                searchingText: "<?php echo JText::_('Searching...'); ?>",
                tokenLimit: 5

            });
        }
    });
</script>
