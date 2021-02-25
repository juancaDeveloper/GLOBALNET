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
$contentstitle = '';
$contents = '';
/** sce */
if ($result['cities']) { 
	    if($result['showtitle'] == 1){
	        $moduleclass_sfx = $params->get('moduleclass_sfx');
	        if(!empty($moduleclass_sfx) || $moduleclass_sfx != ''){
	                $contentstitle = '
	                            <div class="'.$moduleclass_sfx.'"><h3>
	                                <span>
	                                        <span id="tp_headingtext_left"></span>
	                                        <span id="tp_headingtext_center">'.$result['title'].'</span>
	                                        <span id="tp_headingtext_right"></span>             
	                                </span></h3>
	                            </div>
	                        ';
	        }else{
	                $contentstitle = '
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
	    $width = 'width:';
	    if($result['slidingdirection'] != 1 && $result['sliding'] == 1)
	    	$width .= $result['slidingleftwidth'].'px;';
	    else
	    	$width .= '100%;';
	    $classname = 'city'.uniqid();
		$contentswrapperstart = '<div id="jsjobs_module_wrapper" class="'.$classname.'" style="width:100%;">';
		$contentswrapperend = '</div>';
	    $contents .= '<div id="jsjobs_modulelist_databar" class="visible-all" style="'.$width.'">';
		if($result['colperrow'] == 0 || $result['colperrow'] == ''){
			$columnwidth = 0;
		}else{
			$columnwidth = 100 / $result['colperrow'];			
		}
		if($columnwidth <= 0){
			$columnwidth = 30;
		}
		foreach ($result['cities'] as $city) {
			$lnks = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs&city='. $city->cityid .'&lt=1&Itemid='.$result['itemid']; 
			$lnks = JRoute::_($lnks);
			$contents .=  '<span id="jsjobs_modulelist_databar" class="module-list visible-all" style="width:'.$columnwidth.'%;"><span id="themeanchor"><a class="anchor" href="'.$lnks.'" >'.$city->cityname;
					 $contents .=  ' ('. $city->totaljobsbycity.')';
					$contents .=  '</a></span></span>';
		}	
		$contents .= '</div>';
		if ($result['sliding'] == 1) {
			if($result['slidingdirection'] == 1 ){			
				for ($a = 0; $a < $result['consecutivesliding']; $a++){
					$contents .= $contents;
					}
				$contents =  $contentstitle.'<marquee id="mod_jsjobscountry"  direction="up" scrollamount="2" onmouseover="this.stop();" onmouseout="this.start()";>'.$contentswrapperstart.$contents.$contentswrapperend.'</marquee>';
				$contents = $contents.'<br clear="all">';
			}else{
				
				$tcontents = '<table cellpadding="0" cellspacing="0" border="1" width="100%" class="contentpane"> <tr>';
				$scontents = '';
				for ($a = 0; $a < $result['consecutivesliding']; $a++){
					$scontents .= '<td>'.$contents.'</td>';
				}
				$contents = $tcontents.$scontents.'</tr></table>';
				$contents =  $contentstitle.'<marquee id="mod_jsjobscountry"  scrollamount="2" onmouseover="this.stop();" onmouseout="this.start()";>'.$contents.'</marquee>';
			}
			
			echo $contents;			
		}else{
			echo $contentstitle.$contentswrapperstart.$contents.$contentswrapperend;
		}
	}
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
    
    <?php }?>
</style>


