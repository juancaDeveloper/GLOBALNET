<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
				www.joomsky.com, ahmad@joomsky.com
 * Created on:	Dec 2, 2009
 ^
 + Project: 		JS Jobs 
 * File Name:	module/featuredcompanies.php
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
$classname = 'featuredcompanies'.uniqid();
$companies_html = JSModel::getJSModel('listjobs')->listModuleCompanies($classname,$result['noofcompanies'],$result['category'],$result['company'],$result['posteddate'],$result['listtype'],$result['theme'],$result['location'],$result['moduleheight'],$result['jobwidth'],$result['jobheight'],$result['jobfloat'],$result['jobmargintop'],$result['jobmarginleft'],$result['companylogo'],$result['companylogowidth'],$result['companylogoheight'],$result['datacolumn'],$result['listtype'],$result['title'],$result['showtitle'],$result['speedTest'],$result['itemid'],$result['sliding'],$result['slidingdirection'],$result['dateformat'],$result['data_directory'],$result['consecutivesliding'],$result['moduleclass_sfx'],$result['companies'],$result['resumesinrow'],$result['resumesinrowtab'],$result['logodatarow']);
echo $companies_html;
/*
$speed = 50;
if($result['speedTest'] < 5){
    for($i = 5; $i > $result['speedTest']; $i--)
        $speed += 10;
    if($speed > 100) $speed = 100;
}elseif($result['speedTest'] > 5){
    for($i = 5; $i < $result['speedTest']; $i++)
        $speed -= 10;
    if($speed < 10) $speed = 10;
}

$contents = '';
/** sce */
/*
$contentswrapperstart = '';
if ($result['companies']) {
    if($result['listtype'] == 0){ //list style
        $float = ($result['jobfloat'] == 0) ? "float:left;":"display:block;";
        $jobinlinestyle = "width:".$result['jobwidth']."; ".$float." margin-top:".$result['jobmargintop']."; margin-left:".$result['jobmarginleft']."; height:".$result['jobheight'].";";
        $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="featuredcompanies companies" style="height:'.$result['moduleheight'].';" >';
        if($result['showtitle'] == 1){
            $moduleclass_sfx = $params->get('moduleclass_sfx');
            if(!empty($moduleclass_sfx) || $moduleclass_sfx != ''){
                    $contentswrapperstart .= '
                                <div class="'.$moduleclass_sfx.'"><h3>
                                    <span>
                                            <span id="tp_headingtext_left"></span>
                                            <span id="tp_headingtext_center">'.$result['title'].'</span>
                                            <span id="tp_headingtext_right"></span>             
                                    </span></h3>
                                </div>
                            ';
            }else{
                    $contentswrapperstart .= '
                                <div id="tp_heading">
                                    <span id="tp_headingtext">
                                            <span id="tp_headingtext_left"></span>
                                            <span id="tp_headingtext_center">'.$result['title'].'</span>
                                            <span id="tp_headingtext_right"></span>             
                                    </span>
                                </div>
                            ';
            }
        }
        $contentswrapperstart .= '<div id="jsjobs_modulelist_titlebar" class="featuredcompanies" ><span id="whiteback"></span>';
        $noof_w = 1;
        if($result['company'] == 1) $noof_w++;
        if($result['category'] == 1) $noof_w++;
        if($result['location'] == 1) $noof_w++;
        if($result['posteddate'] == 1) $noof_w++;
        
        if ($result['company'] == 1) $contentswrapperstart .=  '<span id="jsjobs_modulelist_titlebar" class="w-'.$noof_w.'">'.JText::_('Company').'</span>';
        $contentswrapperstart .=  '<span id="jsjobs_modulelist_titlebar" class="w-'.$noof_w.'">'.JText::_('Title').'</span>';
        if ($result['category'] == 1) $contentswrapperstart .=  '<span id="jsjobs_modulelist_titlebar" class="w-'.$noof_w.'">'.JText::_('Category').'</span>';
        if ($result['location'] == 1) $contentswrapperstart .=  '<span id="jsjobs_modulelist_titlebar" class="w-'.$noof_w.'">'.JText::_('Location').'</span>';
        if ($result['posteddate'] == 1) $contentswrapperstart .=  '<span id="jsjobs_modulelist_titlebar" class="w-'.$noof_w.'">'.JText::_('Posted').'</span>';
        $contentswrapperstart .= '</div>';
        foreach ($result['companies'] as $comp) {
            $contents .= '<div id="jsjobs_modulelist_databar"><span id="whiteback"></span>';
            $contents .= '<span id="jsjobs_modulelist_databar" class="w-'.$noof_w.'">';
            if ($result['companylogo'] == 1) {
                    $c_l=JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' .$comp->companyaliasid .  '&Itemid='.$result['itemid']);
                    $logo = $result['data_directory'].'/data/employer/comp_'.$comp->companyid.'/logo/'.$comp->companylogo;
                    if(!file_exists($logo)){
                        $logo = 'components/com_jsjobs/images/defaultlogo.png';
                    }
                    $contents .=  '<a href='.$c_l.'><img  src="'.$logo.'"  /></a>';
            }
            $c_l=JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' .$comp->companyaliasid .  '&Itemid='.$result['itemid']);
            $contents .= '<span id="themeanchor"><a class="anchor" href='.$c_l.'>'.$comp->name.'</a></span>';
            $contents .= '</span>';
            $contents .=  '<span id="jsjobs_modulelist_databar" class="w-'.$noof_w.' bg">
                            <span id="themeanchor">
                                <a class="anchor" href="index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $comp->companyaliasid . '&Itemid='.$result['itemid'].'">
                                    '. $comp->name . '
                                </a>
                            </span>
                            </span>';
            if ($result['category'] == 1) { 
                $contents .=  '<span id="jsjobs_modulelist_databar" class="w-'.$noof_w.' bg">'.$comp->cat_title.'</span>';
            }
            if ($result['location'] == 1) { 
                $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                $companylocation = !empty($comp->cityname) ? $comp->cityname : ' ';
                switch ($addlocation) {
                    case 'csc':
                        $companylocation .= !empty($comp->statename) ? ', '.$comp->statename : '';
                        $companylocation .= !empty($comp->countryname) ? ', '.$comp->countryname : '';
                    break;
                    case 'cs':
                        $companylocation .= !empty($comp->statename) ? ', '.$comp->statename : '';
                    break;
                    case 'cc':
                        $companylocation .= !empty($comp->countryname) ? ', '.$comp->countryname : '';
                    break;
                }
                $contents .=  '<span id="jsjobs_modulelist_databar" class="w-'.$noof_w.' bg">'.$companylocation.'</span>';
            }
            if ($result['posteddate'] == 1) { 
                $contents .=  '<span id="jsjobs_modulelist_databar" class="w-'.$noof_w.' bg">'.date($result['dateformat'],strtotime($comp->created)).'</span>';
            }
            $contents .= '</div>';
        }

        if($result['sliding'] == 1){ // Sliding is enable
            $consectivecontent = '';
            for($i = 0; $i < $result['consecutivesliding']; $i++){
                $consectivecontent .= $contents;
            }

            if($result['slidingdirection'] == 1){ // UP
                $contents = '<marquee id="mod_featuredcompanies"  direction="up" scrolldelay="'.$speed.'" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>'.$consectivecontent.'</marquee>';
            }
        }
        $contentswrapperend = '</div>';

    }else{ //box style
        $float = ($result['jobfloat'] == 0) ? "float:left;":"display:block;";
        $jobinlinestyle = "width:".$result['jobwidth']."; ".$float." height:".$result['jobheight'].";";
        $margins = " margin-top:".$result['jobmargintop']."; margin-left:".$result['jobmarginleft'].";";
        $contentswrapperstart .= '<div id="jsjobs_module_wrapper" class="featuredcompanies companies" style="height:'.$result['moduleheight'].';" >';
        if($result['showtitle'] == 1){
            $moduleclass_sfx = $params->get('moduleclass_sfx');
            if(!empty($moduleclass_sfx) || $moduleclass_sfx != ''){
                    $contentswrapperstart .= '
                                <div class="'.$moduleclass_sfx.'"><h3>
                                    <span>
                                            <span id="tp_headingtext_left"></span>
                                            <span id="tp_headingtext_center">'.$result['title'].'</span>
                                            <span id="tp_headingtext_right"></span>             
                                    </span></h3>
                                </div>
                            ';
            }else{
                    $contentswrapperstart .= '
                                <div id="tp_heading">
                                    <span id="tp_headingtext">
                                            <span id="tp_headingtext_left"></span>
                                            <span id="tp_headingtext_center">'.$result['title'].'</span>
                                            <span id="tp_headingtext_right"></span>             
                                    </span>
                                </div>
                            ';
            }
        }
        foreach ($result['companies'] as $comp) {
            $contents .= '<div id="jsjobs_module_wrap" style="'.$margins.$float.'">
                          <div id="jsjobs_module" style="'.$jobinlinestyle.'">';
            $contents .= '<span id="jsjobs_module_heading">
                            <span id="themeanchor">
                                <a class="anchor" href="index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=35&cd=' . $comp->companyaliasid . '&Itemid='.$result['itemid'].'">
                                    '. $comp->name . '
                                </a>
                            </span>
                          </span>';
            $datawidth = "96%";
            if ($result['companylogo'] == 1) { 
                    $c_l=JRoute::_('index.php?option=com_jsjobs&c=jsjobs&view=employer&layout=view_company&nav=35&cd=' .$comp->companyaliasid .  '&Itemid='.$result['itemid']);
                    $per = ((int)$result['companylogowidth']/(int)$result['jobwidth'])*100;
                    $singlerow = false;
                    $style = 'style="width:'.($result['companylogowidth'] - 20).'px;"';
                    $datawidth = ((int)$result['jobwidth'] - (int)$result['companylogowidth']) - 20;
                    if($per >= 60){
                        $singlerow = true;
                        $style = 'style="width:96%;"';
                        $datawidth = "96%";
                    }else
                        $datawidth .= "px";
                    $logo = $result['data_directory'].'/data/employer/comp_'.$comp->companyid.'/logo/'.$comp->companylogo;
                    if(!file_exists($logo)){
                        $logo = 'components/com_jsjobs/images/defaultlogo.png';
                    }
                    $contents .=  '
                                    <div id="jsjobs_module_data_fieldwrapper" '.$style.' class="companies">
                                        <a href='.$c_l.'><img  src="'.$logo.'" style="width:'.$result['companylogowidth'].'; height:'.$result['companylogoheight'].';" /></a>
                                    </div>
                                  ';
            }
            $contents .= '<div id="jsjobs_module_data_fieldwrapper" style="width:'.$datawidth.';">';
            $colwidth = (100 / $result['datacolumn']) - 2;
            if ($result['category'] == 1) { 
                    $contents .=  '
                                    <div id="jsjobs_module_data_fieldwrapper" style="width:'.$colwidth.'%;padding:2px;">
                                        <span id="jsjobs_module_data_fieldtitle">'.JText::_('Category').'</span>
                                        <span id="jsjobs_module_data_fieldvalue">'.$comp->cat_title.'</span>
                                    </div>
                                  ';
            }
            if ($result['location'] == 1) { 
                $addlocation = JSModel::getJSModel('configurations')->getConfigValue('defaultaddressdisplaytype');
                $companylocation = !empty($comp->cityname) ? $comp->cityname : ' ';
                switch ($addlocation) {
                    case 'csc':
                        $companylocation .= !empty($comp->statename) ? ', '.$comp->statename : '';
                        $companylocation .= !empty($comp->countryname) ? ', '.$comp->countryname : '';
                    break;
                    case 'cs':
                        $companylocation .= !empty($comp->statename) ? ', '.$comp->statename : '';
                    break;
                    case 'cc':
                        $companylocation .= !empty($comp->countryname) ? ', '.$comp->countryname : '';
                    break;
                }
                $contents .=  '
                                <div id="jsjobs_module_data_fieldwrapper" style="width:'.$colwidth.'%;padding:2px;">
                                    <span id="jsjobs_module_data_fieldtitle">'.JText::_('Location').'</span>
                                    <span id="jsjobs_module_data_fieldvalue">'.$companylocation.'</span>
                                </div>
                              ';
            }
            if ($result['posteddate'] == 1) { 
                    $contents .=  '
                                    <div id="jsjobs_module_data_fieldwrapper" style="width:'.$colwidth.'%;padding:2px;">
                                        <span id="jsjobs_module_data_fieldtitle">'.JText::_('Posted').'</span>
                                        <span id="jsjobs_module_data_fieldvalue">'.date($result['dateformat'],strtotime($comp->created)).'</span>
                                    </div>
                                  ';
            }
            $contents .= '</div>
                    </div>
                </div>';
        }

        if($result['sliding'] == 1){ // Sliding is enable
            $consectivecontent = '';
            for($i = 0; $i < $result['consecutivesliding']; $i++){
                $consectivecontent .= $contents;
            }

            if($result['slidingdirection'] == 1){ // UP
                $contents = '<marquee id="mod_featuredcompanies"  direction="up" scrolldelay="'.$speed.'" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start()";>'.$consectivecontent.'</marquee>';
            }else{ // LEFT
                $marqueewidth = ((int)$result['jobwidth'] + (int)$result['jobmarginleft']) * $result['consecutivesliding'];
                $marqueewidth = count($result['companies']) * $marqueewidth;
                $totaljobs = count($result['companies']) * $result['consecutivesliding'];
                $marqueeheight = (int)$result['jobheight'] + (int)$result['jobmargintop'];
                if($result['showtitle'] == 1) $top = '25'; else $top = '0';
                $contents = '<div id="jsjobs_mod_featuredcompanies" data-top="'.$top.'" data-totaljobs="'.$totaljobs.'" data-speed="'.$speed.'" data-width="'.$marqueewidth.'" data-height="'.$marqueeheight.'">'.$consectivecontent.'</div>';
            }
            echo '
                <script>
                    jQuery(document).ready(function(){
                        var maindiv = jQuery("div#jsjobs_module_wrapper.featuredcompanies");
                        var contentdiv = jQuery("div#jsjobs_mod_featuredcompanies");
                        var mainwidth = jQuery(maindiv).width();
                        var contentwidth = jQuery(contentdiv).attr("data-width");
                        var contentheight = jQuery(contentdiv).attr("data-height");
                        var totaljobs = jQuery(contentdiv).attr("data-totaljobs");
                        jQuery(maindiv).css({"position":"relative"});
                        var top = jQuery(contentdiv).attr("data-top");
                        jQuery(contentdiv).width(contentwidth)
                                          .height(contentheight)
                                          .css({"position":"absolute","left":"100%","top":top+"px"});
                        slideleft();
                        function slideleft(){
                            var perpix = 0;
                            var speed = jQuery(contentdiv).attr("data-speed");
                            mainwidth = jQuery(maindiv).width();
                            contentwidth = jQuery(contentdiv).attr("data-width");
                            perpix = (parseInt(contentwidth) + parseInt(mainwidth));
                            perpix = parseInt(contentwidth);
                            jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix*speed),"linear",function(){
                                jQuery(contentdiv).css({"left":"100%"});
                                jQuery(contentdiv).stop(true,true).animate();
                                slideleft();
                            });
                            jQuery(contentdiv).hover(function(){
                                jQuery(this).stop();
                            },function(){
                                var num = parseInt(jQuery(contentdiv).css("left"));
                                if(num < 0)
                                    var perpix1 = (parseInt(contentwidth) + parseInt(jQuery(contentdiv).css("left")));
                                else 
                                    var perpix1 = parseInt(contentwidth);
                                jQuery(contentdiv).stop().animate({"left":-contentwidth},(perpix1*speed),"linear",function(){
                                    jQuery(contentdiv).css({"left":"100%"});
                                    jQuery(contentdiv).stop(true,true).animate();
                                    slideleft();
                                });
                            });
                        }
                        /*
                        var left = mainwidth;
                        function manualtimeout(){
                            jQuery(contentdiv).css({"left":left});
                            left--;
                            if(Math.abs(left) < (contentwidth-40)){
                                manualtimeout();
                            }
                        }
                        manualtimeout();
                        //setTimeout(\'manualtimeout()\',1000);
                        */
                   // });
               // </script>';
     //   }
      //  $contentswrapperend = '</div>';
   // }
    
//echo $contentswrapperstart.$contents.$contentswrapperend;
//}
?>
<style>
    <?php if(isset($result['color'][1]) && !empty($result['color'][1])){ ?>
        div.<?php echo $classname; ?> div#jsjobs_module span#jsjobs_module_heading span#themeanchor a{color:<?php echo $result['color'][1];?>;}
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
