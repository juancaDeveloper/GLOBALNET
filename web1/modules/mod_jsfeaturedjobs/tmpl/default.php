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

$document->addStyleSheet(JURI::root().'components/com_jsjobs/css/style.css', 'text/css');
require_once(JPATH_ROOT.'/components/com_jsjobs/css/style_color.php');
$language = JFactory::getLanguage();
if($language->isRtl()){
    $document->addStyleSheet(JURI::root().'components/com_jsjobs/css/style_rtl.css', 'text/css');
}
$classname = 'featuredjobs'.uniqid();
$jobs_html = JSModel::getJSModel('listjobs')->listModuleJobs($classname,$result['jobs'],$result['location'],$result['showtitle'],$result['title'],$result['listtype'],$result['noofjobs'],$result['category'],$result['subcategory'],$result['company'],$result['jobtype'],$result['posteddate'],$result['theme'],$result['separator'],$result['moduleheight'],$result['jobsinrow'],$result['jobsinrowtab'],$result['jobmargintop'],$result['jobmarginleft'],$result['companylogo'],$result['logodatarow'],$result['sliding'],$result['datacolumn'],$result['speedTest'],$result['slidingdirection'],$result['dateformat'],$result['data_directory'],$result['consecutivesliding'],$result['moduleclass_sfx'],$result['itemid'],$result['jobheight'],$result['companylogowidth'],$result['companylogoheight']);
echo $jobs_html;

?>
<style>
    <?php if(isset($result['color'][1]) && !empty($result['color'][1])){ ?>
        div#jsjobs_module_wrapper.<?php echo $classname; ?> a{color:<?php echo $result['color'][1];?>;}
    <?php }
    if(isset($result['color'][2]) && !empty($result['color'][2])){ ?>
        div.<?php echo $classname; ?> div#jsjobs_module{background:<?php echo $result['color'][2];?>;}
        div.<?php echo $classname; ?> div#jsjobs_modulelist_databar{background:<?php echo $result['color'][2];?>;}
        div.<?php echo $classname; ?> div#jsjobs_modulelist_titlebar{background:<?php echo $result['color'][2];?>;}
    <?php }
    if(isset($result['color'][3]) && !empty($result['color'][3])){ ?>
        div.<?php echo $classname; ?> div#jsjobs_module{border: 1px solid <?php echo $result['color'][3]; ?>;}
        div.<?php echo $classname; ?> div#jsjobs_modulelist_titlebar{border: 1px solid <?php echo $result['color'][3]; ?>;}
        div.<?php echo $classname; ?> div#jsjobs_modulelist_databar{border: 1px solid <?php echo $result['color'][3]; ?>;}
    <?php } 
    if(isset($result['color'][4]) && !empty($result['color'][4])) { ?>
        div#jsjobs_module_wrapper.<?php echo $classname; ?> div#jsjobs_module_wrap div#jsjobs_module_data_fieldwrapper span#jsjobs_module_data_fieldtitle{color:<?php echo $result['color'][4];?>;}
        div.<?php echo $classname; ?> div#jsjobs_modulelist_databar{color:<?php echo $result['color'][4];?>;}
        div.<?php echo $classname; ?> div#jsjobs_modulelist_titlebar span#jsjobs_modulelist_titlebar{color:<?php echo $result['color'][4];?>;}
    <?php } 
    if(isset($result['color'][5]) && !empty($result['color'][5])) { ?>
        div#jsjobs_module_wrapper.<?php echo $classname; ?> div#jsjobs_module_wrap div#jsjobs_module_data_fieldwrapper span#jsjobs_module_data_fieldvalue{color:<?php echo $result['color'][5];?>;}
    <?php } 
    if(isset($result['color'][6]) && !empty($result['color'][6])) { ?>
        div.<?php echo $classname; ?>  div#jsjobs_module span#jsjobs_module_heading {border-bottom: 1px solid <?php echo $result['color'][6];?>;}
    <?php }?>
</style>