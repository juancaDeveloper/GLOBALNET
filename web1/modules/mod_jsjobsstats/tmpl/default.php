<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
				www.joomsky.com, ahmad@joomsky.com
 * Created on:	Dec 2, 2009
 ^
 + Project: 		JS Jobs 
 * File Name:	module/hotjsjobs.php
 ^ 
 * Description: Module for JS Jobs
 ^ 
 * History:		1.0.2 - Nov 27, 2010
 ^ 
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();
$version = new JVersion;
$joomla = $version->getShortVersion();
$jversion = substr($joomla,0,3);
if($jversion < 3){
    $document->addScript('components/com_jsjobs/js/jquery.js');
    JHtml::_('behavior.mootools');
}else{
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}	
$document->addScript(JPATH_ROOT.'components/com_jsjobs/js/jquery.marquee.js');
$document->addStyleSheet(JURI::root().'components/com_jsjobs/css/style.css', 'text/css');
require_once(JPATH_ROOT.'/components/com_jsjobs/css/style_color.php');
$language = JFactory::getLanguage();
if($language->isRtl()){
    $document->addStyleSheet(JURI::root().'components/com_jsjobs/css/style_rtl.css', 'text/css');
}

$divclass = array('jsjobs-stats', 'jsjobs-stats');
$classname = 'stats'.uniqid();
$contents = '<div id="modplugwraper" class="'.$classname.'">';
$isodd = 1;
$count = 1;
if ($result['showtitle'] == 1) {
    $moduleclass_sfx = $params->get('moduleclass_sfx');
    if (!empty($moduleclass_sfx) || $moduleclass_sfx != '') {
        echo '
                            <div class="' . $moduleclass_sfx . '"><h3>
                                <span>
                                        <span id="tp_headingtext_left"></span>
                                        <span id="tp_headingtext_center">' . $result['title'] . '</span>
                                        <span id="tp_headingtext_right"></span>             
                                </span></h3>
                            </div>
                        ';
    } else {
        echo '
                            <div id="tp_heading">
                                <span id="tp_headingtext">
                                        <span id="tp_headingtext_left"></span>
                                        <span id="tp_headingtext_center">' . $result['title'] . '</span>
                                        <span id="tp_headingtext_right"></span>             
                                </span>
                            </div>
                        ';
    }
}
if (isset($result['stats']['employer'])) {
    $contents .= '<div class="' . $divclass[0] . '">';
    $contents .= '<strong >' . JText::_('Employers') . ' (' . $result['stats']['employer'] . ')' . '</strong>';
    $contents .= '</div>';
}
if (isset($result['stats']['jobseeker'])) {
    $contents .= '<div class="' . $divclass[1] . '">';
    $contents .= '<strong>' . JText::_('Job seekers') . ' (' . $result['stats']['jobseeker'] . ')' . '</strong>';
    $contents .= '</div>';
}
if (isset($result['stats']['totaljobs'])) {
    $contents .= '<div class="' . $divclass[0] . '">';
    $contents .= '<strong>' . JText::_('Jobs') . ' (' . $result['stats']['totaljobs'] . ')' . '</strong>';
    $contents .= '</div>';
}
if (isset($result['stats']['totalcompanies'])) {
    $contents .= '<div class="' . $divclass[1] . '">';
    $contents .= '<strong>' . JText::_('Companies') . ' (' . $result['stats']['totalcompanies'] . ')' . '</strong>';
    $contents .= '</div>';
}
if (isset($result['stats']['tatalactivejobs'])) {
    $contents .= '<div class="' . $divclass[0] . '">';
    $contents .= '<strong>' . JText::_('Active jobs') . ' (' . $result['stats']['tatalactivejobs'] . ')' . '</strong>';
    $contents .= '</div>';
}
if (isset($result['stats']['totalresume'])) {
    $contents .= '<div class="' . $divclass[1] . '">';
    $contents .= '<strong>' . JText::_('Resume') . ' (' . $result['stats']['totalresume'] . ')' . '</strong>';
    $contents .= '</div>';
}
if ($result['todaystats'] == 1) {
    if (!empty($moduleclass_sfx) || $moduleclass_sfx != '') {
        $contents .= '
                            <div class="' . $moduleclass_sfx . '"><h3>
                                <span>
                                        <span id="tp_headingtext_left"></span>
                                        <span id="tp_headingtext_center">' . JText::_('Today stats') . '</span>
                                        <span id="tp_headingtext_right"></span>             
                                </span></h3>
                            </div>
                        ';
    } else {
        $contents .= '
                            <div id="tp_heading">
                                <span id="tp_headingtext">
                                        <span id="tp_headingtext_left"></span>
                                        <span id="tp_headingtext_center">' . JText::_('Today stats') . '</span>
                                        <span id="tp_headingtext_right"></span>             
                                </span>
                            </div>
                        ';
    }
    if (isset($result['stats']['todyemployer'])) {
        $contents .= '<div class="' . $divclass[0] . '">';
        $contents .= '<strong>' . JText::_('Employers') . ' (' . $result['stats']['todyemployer'] . ')' . '</strong>';
        $contents .= '</div>';
    }
    if (isset($result['stats']['todyjobseeker'])) {
        $contents .= '<div class="' . $divclass[1] . '">';
        $contents .= '<strong>' . JText::_('Job seekers') . ' (' . $result['stats']['todyjobseeker'] . ')' . '</strong>';
        $contents .= '</div>';
    }
    if (isset($result['stats']['todayjobs'])) {
        $contents .= '<div class="' . $divclass[0] . '">';
        $contents .= '<strong>' . JText::_('Jobs') . ' (' . $result['stats']['todayjobs'] . ')' . '</strong>';
        $contents .= '</div>';
    }
    if (isset($result['stats']['todaycompanies'])) {
        $contents .= '<div class="' . $divclass[1] . '">';
        $contents .= '<strong>' . JText::_('Companies') . ' (' . $result['stats']['todaycompanies'] . ')' . '</strong>';
        $contents .= '</div>';
    }
    if (isset($result['stats']['todayactivejobs'])) {
        $contents .= '<div class="' . $divclass[0] . '">';
        $contents .= '<strong>' . JText::_('Active jobs') . ' (' . $result['stats']['todayactivejobs'] . ')' . '</strong>';
        $contents .= '</div>';
    }
    if (isset($result['stats']['todayresume'])) {
        $contents .= '<div class="' . $divclass[1] . '">';
        $contents .= '<strong>' . JText::_('Resumes') . ' (' . $result['stats']['todayresume'] . ')' . '</strong>';
        $contents .= '</div>';
    }
}
$contents .= '</div>';
if ($result['sliding'] == 1) {

    if ($result['slidingdirection'] == 1) {


        for ($a = 0; $a < $result['consecutivesliding']; $a++) {
            $contents .= $contents;
        }
        $contents = '<marquee id="mod_jsjobstats"  direction="up" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $contents . '</marquee>';
        $contents = $contents . '<br clear="all">';
    } else {
        $scontents = "";
        $tcontents = '<table cellpadding="0" cellspacing="0" border="1" width="100%" class="contentpane"> <tr>';
        for ($a = 0; $a < $result['consecutivesliding']; $a++) {
            $scontents .= '<td>' . $contents . '</td>';
        }
        $contents = $tcontents . $scontents . '</tr></table>';
        $contents = '<marquee id="mod_jsjobstats" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>' . $contents . '</marquee>';
    }
}
echo $contents;
?>
<style>
   <?php if(isset($result['color'][1]) && !empty($result['color'][1])){ ?>
        div#modplugwraper.<?php echo $classname; ?>.stats {border: 1px solid <?php echo $result['color'][1];?>;}
    <?php }
    if(isset($result['color'][2]) && !empty($result['color'][2])){ ?>
        div#modplugwraper.<?php echo $classname; ?>.stats {background:<?php echo $result['color'][2];?>;}
    <?php }
    if(isset($result['color'][4]) && !empty($result['color'][4])) { ?>
        div#modplugwraper.<?php echo $classname; ?> div.jsjobs-stats strong{color:<?php echo $result['color'][4];?>;}
    <?php }?>
</style>