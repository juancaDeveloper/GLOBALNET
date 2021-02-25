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
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jsjobs/css/' . $this->config['theme']);
$comma = 0;
$colperrow = 2;
$colwidth = round(100 / $colperrow, 1);
$colwidth = $colwidth . '%';
?>
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
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title"><?php echo JText::_('RSS Control Panel'); ?></span>        
        <table cellpadding="0" cellspacing="0" border="0" width="100%" >
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                        <tr height="15">
                            <td width="250"></td>
                        </tr>
                    </table>
                </td>
            </tr>	
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                        <tr>
                            <td width="47%" valign="top">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                                    <tr>
                                        <td>
                                            <img width="24" height="24" src="<?php echo JURI::root();?>components/com_jsjobs/images/rss.png" text="Job RSS" alt="Job RSS" />
                                            <a class="cplinks" target="_blank" href="index.php?option=com_jsjobs&c=jsjobs&view=rss&layout=rssjobs&format=rss&Itemid=<?php echo $this->Itemid;?>"><?php echo JText::_('Subscribe For Jobs'); ?></a>
                                        </td>
                                        <td>
                                            <img width="24" height="24" src="<?php echo JURI::root();?>components/com_jsjobs/images/rss.png" text="Resume RSS" alt="Resume RSS" />
                                            <a class="cplinks" target="_blank" href="index.php?option=com_jsjobs&c=jsjobs&view=rss&layout=rssresumes&format=rss&Itemid=<?php echo $this->Itemid;?>"><?php echo JText::_('Subscribe For Resumes'); ?></a>
                                        </td>
                                    </tr>
                                </table>	
                            </td>		
                        </tr>

                    </table>	
                </td>
            </tr>	
            <tr>
                <td>
                </td>
            </tr>		
        </table>
    </div>
    <?php
}//ol
?>
<div width="100%">
    <?php
    if ($this->config['fr_cr_txsh']) {
        echo
        '<table width="100%" style="table-layout:fixed;">
		<tr><td height="15"></td></tr>
		<tr><td style="vertical-align:top;" align="center">' . $this->config['fr_cr_txa'] . $this->config['fr_cr_txb'] . '</td></tr>
	</table>';
    }
    ?>
</div>

