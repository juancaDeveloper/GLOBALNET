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
?>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Reports'); ?></span></div>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=overallreports" class="overall report_anc">
            <span class="left">
                <img src="components/com_jsjobs/include/images/job-stats.png">
                <span class="text"><?php echo JText::_('Over All');?></span>
            </span>
            <span class="right">
                <img src="components/com_jsjobs/include/images/1.png">
            </span>
        </a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=employerreports" class="employer report_anc">
            <span class="left">
                <img src="components/com_jsjobs/include/images/employer.png">
                <span class="text"><?php echo JText::_('Employer');?></span>
            </span>
            <span class="right">
                <img src="components/com_jsjobs/include/images/2.png">
            </span>
        </a>
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=jobseekerreports"  class="jobseeker report_anc">
            <span class="left">
                <img src="components/com_jsjobs/include/images/jobseeker-2e.png">
                <span class="text"><?php echo JText::_('Job Seeker');?></span>
            </span>
            <span class="right">
                <img src="components/com_jsjobs/include/images/3.png">
            </span>
        </a>        
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