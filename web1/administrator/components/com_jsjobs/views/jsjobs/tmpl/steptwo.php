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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
$session = JFactory::getSession();
?>
<script language=Javascript>
    function confirmdelete() {
        if (confirm("<?php echo JText::_('Are you sure to delete'); ?>") == true) {
            return true;
        } else
            return false;
    }
</script>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Update'); ?></span></div>
        
        <div style="display:none;" id="jsjob_installer_waiting_div"></div>
        <span style="display:none;" id="jsjob_installer_waiting_span"><?php echo JText::_("Please wait installation in progress"); ?></span>
        <div id="jsjob-main-wrapper" >
            <div id="jsjob-lower-wrapper">
                <div class="jsjob_installer_wrapper" id="jsjob-installer_id">    
                    <div class="jsjob_top">
                        <div class="jsjob_logo_wrp">
                            <img src="components/com_jsjobs/include/images/installerlogo.png">
                        </div>
                        <div class="jsjob_heading_text"><?php echo JText::_("JS Jobs Pro"); ?></div>
                        <div class="jsjob_subheading_text"><?php echo JText::_("Most Poweful Job Board Plugin"); ?></div>
                    </div>
                    <form id="proinstaller_form" action="#" method="post">
                        <div id="jsjob_next_form">
                            <?php echo $session->get('versiondata'); ?>
                        </div> 
                    </form>
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
