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
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();

global $mainframe;
$document->addStyleSheet('../components/com_jsjobs/css/token-input-jsjobs.css');

if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('../components/com_jsjobs/js/jquery.tokeninput.js');
$document->addScript('components/com_jsjobs/include/js/jquery_idTabs.js');
?>
<script language="javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'configuration.save') {
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
            f.check.value = '<?php
if (JVERSION < '3')
    echo JUtility::getToken();
else
    echo JSession::getFormToken();
?>';//send token
        } else {
            alert("<?php echo JText::_("Some values are not acceptable, please retry"); ?>");
            return false;
        }
        return true;
    }
</script>

<?php
$ADMINPATH = JPATH_BASE . '\components\com_jsjobs';
?>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div> 
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Cron Job'); ?></span></div>
                <div id="cp_wraper">
                    <div id="cp_icon_main">
                        <div id="tabs_wrapper" class="tabs_wrapper">
                            <div class="idTabs">
                                <a class="selected" data-css="controlpanel" href="#webcrown"><?php echo JText::_('Webcrown.org'); ?></a>
                                <a  class="linktabclass" href="#wget"><?php echo JText::_('Wget'); ?></a> 
                                <a  class="linktabclass" href="#curl"><?php echo JText::_('Curl'); ?></a>
                                <a  class="linktabclass" href="#phpscript"><?php echo JText::_('Php Script'); ?></a>
                                <a  class="linktabclass" href="#url"><?php echo JText::_('Website'); ?></a>
                            </div>
                            <div id="webcrown">
                            <?php
                                $array = array('even', 'odd');
                                $k = 0;
                            ?>
                                <div id="cron_job">
                                    <div class="headtext"><?php echo JText::_('Configuration Of A Backup Job With Webcron.org'); ?></div>
                                    <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                                        <span class="crown_text_left">
                                            <?php echo JText::_('Name Of Cronjob'); ?>
                                        </span>
                                        <span class="crown_text_right"><?php echo JText::_('Log In To Webcron.org. In The Cron Area, Click On The New Cron Button. Below You will Find What You Have To Enter At Webcron.orgs Interface'); ?></span>
                                    </div>
                                    <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                                        <span class="crown_text_left">
                                            <?php echo JText::_('Timeout'); ?>
                                        </span>
                                        <span class="crown_text_right"><?php echo JText::_('180sec If The Backup Does not Complete, Increase It. Most Sites Will Work With A Setting Of 180 Or 600 Here. If You Have A Very Big Site Which Takes More Than 5 Minutes To Back Itself Up, You Might Consider Using Akeeba Backup Professional And The Native Cli Cron Job Instead, As Its Much More Cost-effective.'); ?></span>
                                    </div>
                                    <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                                        <span class="crown_text_left"><?php echo JText::_('Url You Want To Execute'); ?></span>
                                        <span class="crown_text_right">
                                         <?php echo JURI::root() . "index.php?option=com_jsjobs&c=jobalert&task=sendjobalert&ck=" . $this->ck; ?>
                                        </span>
                                    </div>
                                    <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                                        <span class="crown_text_left"><?php echo JText::_('Login'); ?></span>
                                        <span class="crown_text_right">
                                            <?php echo JText::_('Leave This Blank'); ?>
                                        </span>
                                    </div>
                                    <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                                        <span class="crown_text_left"><?php echo JText::_('Password'); ?></span>
                                        <span class="crown_text_right"><?php echo JText::_('Leave This Blank'); ?></span>
                                    </div>
                                    <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                                        <span class="crown_text_left">
                                            <?php echo JText::_('Execution Time'); ?>
                                        </span>
                                        <span class="crown_text_right">
                                            <?php echo JText::_('Thats The Grid Below The Other Options. Select When And How Often You Want Your Cron Job To Run.'); ?>
                                        </span>
                                    </div>
                                            <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                                                <span class="crown_text_left"><?php echo JText::_('Alerts'); ?></span>
                                                <span class="crown_text_right">
                                                <?php echo JText::_('If You Have Already Set Up Alert Methods In Webcron.orgs Interface, We Recommend Choosing An Alert Method Here And Not Checking The only On Error So That You Always Get A Notification When The Backup Cron Job Runs. Finally, Click On The Submit Button To Finish Setting Up Your Cron Job.'); ?>
                                        </span>
                                    </div>
                                </div>  
                            </div>
                            <div id="wget">
                                <div id="cron_job">
                                    <div class="headtext"><?php echo JText::_('Cron Scheduling Using Wget most Hosts'); ?></div>
                                    <div id="cron_job_detail_wrapper" class="even">
                                        <span class="crown_text_right fullwidth">
                                            <?php echo 'wget --max-redirect=10000 "' . JURI::root() . "index.php?option=com_jsjobs&c=jobalert&task=sendjobalert&ck=" . $this->ck . '" -O - 1>/dev/null 2>/dev/null '; ?>
                                        </span>
                                    </div>
                                </div>  
                            </div>
                            <div id="curl">
                                <div id="cron_job">
                                    <div class="headtext"><?php echo JText::_('Cron Scheduling Using Curl siteground And A Few Other Hosts'); ?></div>
                                    <div id="cron_job_detail_wrapper" class="even">
                                        <span class="crown_text_right fullwidth">
                                            <?php echo 'curl "' . JURI::root() . "index.php?option=com_jsjobs&c=jobalert&task=sendjobalert&ck=" . $this->ck . '"<br>' . JText::_('Or') . '<br>'; ?>
                                        <?php echo 'curl -L --max-redirs 1000 -v "' . JURI::root() . "index.php?option=com_jsjobs&c=jobalert&task=sendjobalert&ck=" . $this->ck . '" 1>/dev/null 2>/dev/null '; ?>
                                        </span>
                                    </div>
                                </div>  
                            </div>
                            <div id="phpscript">
                                <div id="cron_job">
                                    <div class="headtext"><?php echo JText::_('Custom Php Script To Run'); ?></div>
                                    <div id="cron_job_detail_wrapper" class="even">
                                        <span class="crown_text_right fullwidth">
                                            <?php
                                            echo '  $curl_handle=curl_init();<br>
                                                    curl_setopt($curl_handle, CURLOPT_URL, \'' . JURI::root() . "index.php?option=com_jsjobs&c=jobalert&task=sendjobalert&ck=" . $this->ck . '\');<br>
                                                    curl_setopt($curl_handle,CURLOPT_FOLLOWLOCATION, TRUE);<br>
                                                    curl_setopt($curl_handle,CURLOPT_MAXREDIRS, 10000);<br>
                                                    curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER, 1);<br>
                                                    $buffer = curl_exec($curl_handle);<br>
                                                    curl_close($curl_handle);<br>
                                                    if (empty($buffer))<br>
                                                    &nbsp;&nbsp;echo "' . JText::_('Sorry, The Backup Did not Work.') . '";<br>
                                                    else<br>
                                                    &nbsp;&nbsp;echo $buffer;<br>
                                                    ';
                                            ?>
                                        </span>
                                    </div>
                                </div>  
                            </div>
                            <div id="url">
                                <div id="cron_job">
                                    <div class="headtext"><?php echo JText::_('Url For Use With Your Own Scripts And Third Party Services'); ?></div>
                                    <div id="cron_job_detail_wrapper" class="even">
                                        <span class="crown_text_right fullwidth"><?php echo JURI::root() . "index.php?option=com_jsjobs&c=jobalert&task=sendjobalert&ck=" . $this->ck; ?></span>
                                    </div>
                                </div>  
                            </div>
                            <div id="cron_job-bottom">
                                <span style="float:left;margin-right:4px;"><?php echo JText::_('Recommended Run Script Once A Day'); ?></span>                                  
                            </div>  
                            
   
        </div>
</div><!-- main wrapper closed -->
    
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
