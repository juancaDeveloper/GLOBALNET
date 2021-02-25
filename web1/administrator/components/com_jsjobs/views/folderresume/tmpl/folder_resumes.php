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

// this is the basic listing scene when you click on the component 
// in the component menu
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();

$document->addStyleSheet('../components/com_jsjobs/css/jsjobsrating.css');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}

$status = array(
    '1' => JText::_('Job Approved'),
    '-1' => JText::_('Job Rejected'));
?>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <form action="index.php" method="post" name="adminForm" id="adminForm">
        <div id="jsjobs-heading">
            <a id="backimage" href="index.php?option=com_jsjobs&c=folder&view=folder&layout=folders"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <span id="heading-text"><?php echo JText::_('Folders Resume'); ?></span>
        </div>
        <div id="jsjobs_filter_wrapper">           
             <span class="jsjobs-filter"><input type="text" name="searchname" id="searchname" value="<?php if (isset($this->lists['searchname'])) echo $this->lists['searchname']; ?>" class="text_area" onchange="document.adminForm.submit();" /></span>
             <span class="jsjobs-filter"><?php echo $this->lists['jobtype']; ?></span>
             <span class="jsjobs-filter"><button class="js-button" id="js-search" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
             <span class="jsjobs-filter"><button class="js-button" id="js-reset" onclick="document.getElementById('searchname').value = ''; this.form.getElementById('searchjobtype').value = ''; this.form.submit();" ><?php echo JText::_('Reset'); ?></button></span>
         </div>
        <?php if(!empty($this->items)){ ?>
            <?php
            for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                $row = $this->items[$i];
                $resumelink = 'index.php?option=com_jsjobs&task=resume.edit&cid[]='.$row->appid
                ?>
                <div id="js-folderresume-wrapper">
                    <div class="js-fl-toprow">
                        <div class="js-fl-leftcol">
                            <div class="js-fl-imgblock">
                                <img src="components/com_jsjobs/include/images/Users.png">
                            </div>
                        </div>
                        <div class="js-fl-rightcol">
                            <div class="js-fl-titlerow">
                                <a href="<?php echo $resumelink; ?>"><?php echo $row->first_name . ' ' . $row->last_name; ?></a>
                                <div>
                                    <?php
                                    $id = $row->id;
                                    $percent = 0;
                                    $stars = '';
                                    $percent = $row->rating * 20;
                                    $stars = '-small';
                                    $html = "
                                        <div class=\"jsjobs-container" . $stars . "\"" . ( " style=\"margin-top:5px;\"" ) . ">
                                        <ul class=\"jsjobs-stars" . $stars . "\">
                                        <li id=\"rating_" . $id . "\" class=\"current-rating\" style=\"width:" . (int) $percent . "%;\"></li>
                                        <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',1," . (int) $row->ratingid . "," . $row->jobid . "," . $row->appid . ");\" title=\"" . JTEXT::_('Very Poor') . "\" class=\"one-star\">1</a></li>
                                        <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',2," . (int) $row->ratingid . "," . $row->jobid . "," . $row->appid . ");\" title=\"" . JTEXT::_('Poor') . "\" class=\"two-stars\">2</a></li>
                                        <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',3," . (int) $row->ratingid . "," . $row->jobid . "," . $row->appid . ");\" title=\"" . JTEXT::_('Regular') . "\" class=\"three-stars\">3</a></li>
                                        <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',4," . (int) $row->ratingid . "," . $row->jobid . "," . $row->appid . ");\" title=\"" . JTEXT::_('Good') . "\" class=\"four-stars\">4</a></li>
                                        <li><a href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $id . "',5," . (int) $row->ratingid . "," . $row->jobid . "," . $row->appid . ");\" title=\"" . JTEXT::_('Very Good') . "\" class=\"five-stars\">5</a></li>
                                        </ul>
                                        </div>
                                    ";
                                    $html .="</small></span>";
                                    echo $html;
                                ?>
                                </div>
                            </div>
                            <div class="js-col-xs-12 js-col-md-6 js-fl-valwrapper"><span class="js-fl-title"><?php echo JText::_('Category'); ?>:</span><span class="js-fl-value"><?php echo JText::_($row->cat_title); ?></span></div>
                            <div class="js-col-xs-12 js-col-md-6 js-fl-valwrapper"><span class="js-fl-title"><?php echo JText::_('Job Type'); ?>:</span><span class="js-fl-value"><?php echo JText::_($row->jobtypetitle); ?></span></div>
                            <div class="js-col-xs-12 js-col-md-6 js-fl-valwrapper"><span class="js-fl-title"><?php echo JText::_('Salary Range'); ?>:</span><span class="js-fl-value"><?php echo $row->symbol . $row->rangestart . ' - ' . $row->symbol . $row->rangeend; ?></span></div>
                            <div class="js-col-xs-12 js-col-md-6 js-fl-valwrapper"><span class="js-fl-title"><?php echo JText::_('Contact Email'); ?>:</span><span class="js-fl-value"><?php echo $row->email_address; ?></span></div>
                            <div class="js-col-xs-12 js-col-md-12 js-fl-valwrapper"><span class="js-fl-title"><?php echo JText::_('Location'); ?>:</span><span class="js-fl-value"><?php
                                if ($row->cityname) {
                                    echo $row->cityname;
                                    $comma = 1;
                                }
                                if ($row->statename) {
                                    if ($comma)
                                        echo', ';
                                    echo $row->statename;
                                    $comma = 1;
                                }
                                if ($row->countryname) {
                                    if ($comma)
                                        echo', ';
                                    echo $row->countryname;
                                    $comma = 1;
                                }
                                ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="js-fl-bottomrow">
                        <span id="js-fl-created"><?php echo JText::_('Created');?></span> <?php echo JHtml::_('date', $row->apply_date, $this->config['date_format']); ?>
                        <?php echo "<a id='js-fl-rvbtn' href='" . $resumelink . "'><img src='components/com_jsjobs/include/images/ad-resume.png' />" . JText::_('Edit Resume') . "</a>"; ?>
                    </div>
                </div> <?php
            } ?>

                <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>
            <?php }else{ JSJOBSlayout::getNoRecordFound(); } ?>                
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="folderid" id="folderid" value="<?php echo $this->fd; ?>" />
                <input type="hidden" name="fd" id="fd" value="<?php echo $this->fd; ?>" />
                <input type="hidden" name="resumeid" id="resumeid" value="<?php echo $row->appid; ?>" />
                <input type="hidden" name="c"  value="folderresume" />
                <input type="hidden" name="view"  value="folderresume" />
                <input type="hidden" name="layout"  value="folder_resumes" />
                <input type="hidden" name="id" id="id" value="" />
                <input type="hidden" name="boxchecked" value="0" />
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

<script>
    function setrating(src, newrating, ratingid, jobid, resumeid) {
        jQuery.post("index.php?option=com_jsjobs&task=resume.saveresumerating", {ratingid: ratingid, jobid: jobid, resumeid: resumeid, newrating: newrating}, function (data) {
            if (data == 1) {
                document.getElementById(src).style.width = parseInt(newrating * 20) + '%';
            }
        });
    }
</script>
