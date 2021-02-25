<?php
/**
 * @version     2.0
 * @package     com_tlpteam
 * @subpackage  mod_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
defined('_JEXEC') or die;
$rows = ModTlpteamHelper::getLists($params);
$app = JFactory::getApplication();
$tlpteam_params = JComponentHelper::getParams('com_tlpteam');
$lang = JFactory::getLanguage();
$dir = $lang->get('rtl');
$image_storiage_path 			= $tlpteam_params->get('image_path','images/tlpteam');
$g_primary_color 				= $tlpteam_params->get('g_primary_color','#0d57e0');
$g_name_font_size 				= $tlpteam_params->get('g_name_font_size','20');
$g_name_font_color				= $tlpteam_params->get('g_name_font_color');
$g_name_text_align				= $tlpteam_params->get('g_name_text_align');
$g_position_font_size			= $tlpteam_params->get('g_position_font_size');
$g_position_font_color			= $tlpteam_params->get('g_position_font_color');
$g_position_text_align			= $tlpteam_params->get('g_position_text_align');
$g_short_bio_font_color			= $tlpteam_params->get('g_short_bio_font_color');
$g_short_bio_text_align			= $tlpteam_params->get('g_short_bio_text_align');
$g_social_icon_background		= $tlpteam_params->get('g_social_icon_background');
$g_social_icon_color			= $tlpteam_params->get('g_social_icon_color');
$g_social_icon_size				= $tlpteam_params->get('g_social_icon_size','16');
$link_detail					= $tlpteam_params->get('link_detail','1');
$link_type						= $tlpteam_params->get('link_type','2');
$g_layout						= $tlpteam_params->get('g_layout','layout1');
$g_item_to_item_margin			= $tlpteam_params->get('g_item_to_item_margin','1');
$g_overlay_opacity				= $tlpteam_params->get('g_overlay_opacity','.5');
$g_display_no					= $tlpteam_params->get('g_display_no','4');
$g_display_no_tab				= $tlpteam_params->get('g_display_no_tab','3');
$g_display_no_mob				= $tlpteam_params->get('g_display_no_mob','1');
$bootstrap_version				= $tlpteam_params->get('bootstrap_version','1');
$g_overlay_color				= $tlpteam_params->get('g_overlay_color');
$g_image_style					= $tlpteam_params->get('g_image_style','1');
$g_name_field					= $tlpteam_params->get('g_name_field','1');
$g_position_field				= $tlpteam_params->get('g_position_field','1');
$g_shortbio_field				= $tlpteam_params->get('g_shortbio_field','1');
$g_email_field					= $tlpteam_params->get('g_email_field','1');
$g_phoneno_field				= $tlpteam_params->get('g_phoneno_field','1');
$g_mobileno_field				= $tlpteam_params->get('g_mobileno_field','1');
$g_website_field				= $tlpteam_params->get('g_website_field','1');
$g_location_field				= $tlpteam_params->get('g_location_field','1');
$g_skill_field					= $tlpteam_params->get('g_skill_field','1');
$g_socialicon_field				= $tlpteam_params->get('g_socialicon_field','1');
$g_short_description_limit		= $tlpteam_params->get('g_short_description_limit','160');
$g_overlay_item_padding			= $tlpteam_params->get('g_overlay_item_padding','15');
$g_btn_bg                     	= $tlpteam_params->get('g_btn_bg');
$g_btn_text_color             	= $tlpteam_params->get('g_btn_text_color');
$g_btn_bg_hover               	= $tlpteam_params->get('g_btn_bg_hover');
$g_gutter                     	= $tlpteam_params->get('g_gutter','');
$g_gray_scale                 	= $tlpteam_params->get('g_gray_scale','');

/* Module Parma */
$mod_pretext 					= $params->get('mod_pretext');
$mod_name_field 				= $params->get('mod_name_field');
$mod_position_field				= $params->get('mod_position_field');
$mod_shortbio_field				= $params->get('mod_shortbio_field');
$mod_email_field				= $params->get('mod_email_field');
$mod_phoneno_field				= $params->get('mod_phoneno_field');
$mod_mobileno_field				= $params->get('mod_mobileno_field');
$mod_website_field				= $params->get('mod_website_field');
$mod_location_field				= $params->get('mod_location_field');
$mod_skill_field				= $params->get('mod_skill_field');
$mod_socialicon_field			= $params->get('mod_socialicon_field');
$mod_display_no					= $params->get('mod_showno');
$mod_display_no_tab             = $params->get("mod_display_no_tab");
$mod_display_no_mob             = $params->get("mod_display_no_mob");
$mod_primary_color 				= $params->get("mod_primary_color");
$mod_name_font_size				= $params->get('mod_name_font_size');
$mod_name_font_color			= $params->get('mod_name_font_color');
$mod_name_text_align			= $params->get('mod_name_text_align');
$mod_position_font_size			= $params->get('mod_position_font_size');
$mod_position_font_color		= $params->get('mod_position_font_color');
$mod_position_text_align		= $params->get('mod_position_text_align');
$mod_short_bio_text_align		= $params->get('mod_short_bio_text_align');
$mod_short_bio_font_color		= $params->get('mod_short_bio_font_color');
$mod_social_icon_background		= $params->get('mod_social_icon_background');
$mod_social_icon_color			= $params->get('mod_social_icon_color');
$mod_social_icon_size			= $params->get('mod_social_icon_size');
$mod_overlay_color				= $params->get('mod_overlay_color');
$mod_overlay_opacity			= $params->get('mod_overlay_opacity');
$mod_image_style				= $params->get('mod_image_style');
$mod_short_description_limit	= $params->get('mod_short_description_limit','160');
$mod_overlay_item_padding		= $params->get('mod_overlay_item_padding','15');
$mod_item_to_item_margin		= $params->get('mod_item_to_item_margin');
$mod_btn_bg                     = $params->get('mod_btn_bg');
$mod_btn_text_color             = $params->get('mod_btn_text_color');
$mod_btn_bg_hover               = $params->get('mod_btn_bg_hover');
$team_menuid               		= $params->get('mod_teammenuitem');
$mod_link_detail                = $params->get('mod_link_detail','');
$mod_link_type                  = $params->get('mod_link_type','');
$mod_gutter                     = $params->get('mod_gutter','');
$mod_gray_scale                 = $params->get('mod_gray_scale','');


if($mod_name_field!=''){
	$name_field=$mod_name_field;
}else{
	$name_field=$g_name_field;
}
if($mod_position_field!=''){
	$position_field=$mod_position_field;
}else{
	$position_field=$g_position_field;
}
if($mod_shortbio_field!=''){
	$shortbio_field=$mod_shortbio_field;
}else{
	$shortbio_field=$g_shortbio_field;
}
if($mod_email_field!=''){
	$email_field=$mod_email_field;
}else{
	$email_field=$g_email_field;
}
if($mod_phoneno_field!=''){
	$phoneno_field=$mod_phoneno_field;
}else{
	$phoneno_field=$g_phoneno_field;
}
if($mod_mobileno_field!=''){
	$mobileno_field=$mod_mobileno_field;
}else{
	$mobileno_field=$g_mobileno_field;
}
if($mod_website_field!=''){
	$website_field=$mod_website_field;
}else{
	$website_field=$g_website_field;
}
if($mod_location_field!=''){
	$location_field=$mod_location_field;
}else{
	$location_field=$g_location_field;
}
if($mod_skill_field!=''){
	$skill_field=$mod_skill_field;
}else{
	$skill_field=$g_skill_field;
}   
if($mod_socialicon_field!=''){
	$socialicon_field=$mod_socialicon_field;
}else{
	$socialicon_field=$g_socialicon_field;
}
if($mod_primary_color!=''){ 
	$primary_color=$mod_primary_color;
}else{ 
	$primary_color=$g_primary_color;
}
if($mod_name_font_size!=''){
	$name_font_size=$mod_name_font_size;
}else{
	$name_font_size=$g_name_font_size;
}
if($mod_name_font_color!=''){
	$name_font_color=$mod_name_font_color;
}else{
	$name_font_color=$g_name_font_color;
}
if($mod_name_text_align!=''){
	$name_text_align=$mod_name_text_align;
}else{
	$name_text_align=$g_name_text_align;
}
if($mod_position_font_size!=''){
	$position_font_size=$mod_position_font_size;
}else{
	$position_font_size=$g_position_font_size;
}
if($mod_position_font_color!=''){
	$position_font_color=$mod_position_font_color;
}else{
	$position_font_color=$g_position_font_color;
}
if($mod_position_text_align!=''){
	$position_text_align=$mod_position_text_align;
}else{
	$position_text_align=$g_position_text_align;
}
if($mod_short_bio_text_align!=''){
	$short_bio_text_align=$mod_short_bio_text_align;
}else{
	$short_bio_text_align=$g_short_bio_text_align;
}
if($mod_short_bio_font_color!=''){
	$short_bio_font_color=$mod_short_bio_font_color;
}else{
	$short_bio_font_color=$g_short_bio_font_color;
}
if($mod_social_icon_background!=''){
	$social_icon_background=$mod_social_icon_background;
}else{
	$social_icon_background=$g_social_icon_background;
}
if($mod_social_icon_color!=''){
	$social_icon_color=$mod_social_icon_color;
}else{
	$social_icon_color=$g_social_icon_color;
}
if($mod_social_icon_size!=''){
	$social_icon_size=$mod_social_icon_size;
}else{
	$social_icon_size=$g_social_icon_size;
}
if($mod_image_style!=''){
	$image_style=$mod_image_style;
}else{
	$image_style=$g_image_style;
}
if($mod_overlay_color!=''){
	$overlay_color=$mod_overlay_color;
}else{
	$overlay_color=$g_overlay_color;
}
if($mod_overlay_opacity!=''){
	$overlay_opacity=$mod_overlay_opacity;
}else{
	$overlay_opacity=$g_overlay_opacity;
}
if($mod_item_to_item_margin!=''){
	$item_to_item_margin=$mod_item_to_item_margin;
}else{
	$item_to_item_margin=$g_item_to_item_margin;
}
if($mod_short_description_limit!=''){
	$short_description_limit=$mod_short_description_limit;
}else{
	$short_description_limit=$g_short_description_limit;
}
if($mod_overlay_item_padding!=''){
	$overlay_item_padding=$mod_overlay_item_padding;
}else{
	$overlay_item_padding=$g_overlay_item_padding;
}
if($mod_btn_bg!=''){
	$btn_bg=$mod_btn_bg;
}else{
	$btn_bg=$g_btn_bg;
}
if($mod_btn_text_color!=''){
	$btn_text_color=$mod_btn_text_color;
}else{
	$btn_text_color=$g_btn_text_color;
} 
if($mod_btn_bg_hover!=''){
	$btn_bg_hover=$mod_btn_bg_hover;
}else{
	$btn_bg_hover=$g_btn_bg_hover;
} 
if($mod_link_detail!=''){
  $link_detail = $mod_link_detail;
}else{
  $link_detail = $link_detail;
}
if($mod_link_type!=''){
  $link_type = $mod_link_type;
}else {
  $link_type = $link_type;
}
if($mod_gray_scale!=''){
  $gray_scale = $mod_gray_scale;
}else{
  $gray_scale = $g_gray_scale;
}

if($mod_display_no!=''){
	$display_no=$mod_display_no;$grid=(12/$mod_display_no);
}else{
	$display_no=$g_display_no;$grid=(12/$g_display_no);
}
$md_grid=(12/$display_no);

if ( $mod_display_no_tab != '' ) {
  $sm_grid = ( 12 / $mod_display_no_tab );
} else {
  $sm_grid = ( 12 / $g_display_no_tab );
}
if ( $mod_display_no_mob != '' ) {
  $xs_grid = ( 12 / $mod_display_no_mob );
} else {
  $xs_grid = ( 12 / $g_display_no_mob );
}

if($mod_gutter !='') {
  $gutter = $mod_gutter;
}else {
  $gutter = $g_gutter;
}
if($gutter=='') {
	$gutter = 15;
}
if($item_to_item_margin==0){
    $item_margin = 'allmargin0';
}else{
    $item_margin = '';
}
if($gray_scale==1){
  $gray_scale = 'tlp-grayscale';
}else{
  $gray_scale = '';
}
if($image_style==2){ 
  $image_style_class = ' tlp-round-picture';
}else {
  $image_style_class = '';
}

if($bootstrap_version==3){
    $bss="col-md-".$md_grid." col-lg-".$md_grid." col-sm-".$sm_grid. " col-xs-".$xs_grid;
      
  }else{
    $bss="tlp-col-md-".$md_grid." tlp-col-lg-".$md_grid." tlp-col-sm-". $sm_grid. " tlp-col-xs-".$xs_grid;
  }


if($overlay_color){
	$hex = str_replace("#", "", $overlay_color);
   if(strlen($hex) == 3) {
      $r = hexdec($hex[0].$hex[0]);
      $g = hexdec($hex[1].$hex[1]);
      $b = hexdec($hex[2].$hex[2]);
   } else {
      $r = hexdec($hex[0].$hex[1]);
      $g = hexdec($hex[2].$hex[3]);
      $b = hexdec($hex[4].$hex[5]);
	}
}
$document = JFactory::getDocument();
$style  = '.tlp-team .skill-prog .fill, .tlp-tooltip + .tooltip > .tooltip-inner, .tlp-popup-wrap .tlp-popup-navigation-wrap  { background: ' . $primary_color . '; }';
$style .= '.tlp-team .skill-prog .fill,.tlp-team .contact-info .fa { color: ' . $primary_color . '; }';
$style .= '.tlp-team .skill-prog .fill { color: ' . $primary_color . '; }';
$style .= '.tooltip.top .tooltip-arrow { border-top-color: ' . $primary_color . '; }';
$style .= '.tlp-team .social-icons a { background: ' . $social_icon_background . '!important; color: '. $social_icon_color. '!important; font-size: '. $social_icon_size .'px; }';
if($social_icon_background==''){
$style .= '.tlp-team .social-icons a:hover .fa-facebook,.tlp-team .social-icons a:hover .fa-twitter, .tlp-team .social-icons a:hover .fa-linkedin, .tlp-team .social-icons a:hover .fa-google-plus, .tlp-team .social-icons a:hover .fa-youtube, .tlp-team .social-icons a:hover .fa-vimeo, .tlp-team .social-icons a:hover .fa-instagram  { background: none; color: '. $social_icon_color. '; opacity: .8; }';
}
$style .= '.tlp-team .layout7 .single-team-area h3,.tlp-team .layout7 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px ; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout7 .tlp-position,.tlp-team .layout7 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px ; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout7 .short-bio p,.tlp-team .layout7 .short-bio p a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
$style .= '.tlp-team .layout7 .overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
$style .= '.owl-theme .owl-nav div,.owl-theme .owl-dots .owl-dot span { background:' . $btn_bg . ' !important; color:' . $btn_text_color . ';}';
$style .= '.owl-theme .owl-nav div:hover,.owl-theme .owl-dots .owl-dot.active span { background:' .$btn_bg_hover. '!important; color: '.$btn_text_color.' !important;}';

$document->addStyleDeclaration( $style );

$html ='';

if (!empty($rows)) :
echo '<div class="tlp-team-wrap container-fluid">';
	if($mod_pretext){
		$html .='<p class="module-pretext">'.$mod_pretext.'</p>';
	}
	$html .='<div class="tlp-team mod-tlp-team-carousol">';
		$html .='<div class="tlp-row layout7">';
			$html .='<div id="owl-team" class="owl-carousel owl-theme '.$image_style_class.'">';
			foreach ($rows as &$item) : 
				if($link_type==2){ 
			        $popup=' data-id="'.$item->id.'" class="tlp-single-item-popup"';
			      }else{
			        $popup= null;
			    }
					$detail_link = JRoute::_('index.php?option=com_tlpteam&view=team&id='.$item->id.':'.$item->alias.'&Itemid='.$team_menuid);
				
				$html .='<div class="item">';
					$html .='<div class="single-team-area">'; 
						$html .='<div class="single-team'.$image_style_class.'">'; 
						    if (!empty($item->profile_image)):
						     	$html .='<figure class="tlp-team-item">';
						     		$html .='<a href="'.$detail_link.'"'.$popup.'><img class="img-responsive '.$gray_scale.'" src="'. JURI::root().$image_storiage_path.'/m_'.$item->profile_image.'" alt="'.$item->name.'"/></a>';		     		
						        $html .='<figcaption>';
						        if($socialicon_field==1){ 
					            	$html .='<div class="social-icons social-icons">';  
					            		$html .='<p class="tpl-social">';
				            		    	if($item->facebook!=''){ 
				                               $html .='<a href="'.$item->facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
				                           	}
				                           	if($item->twitter!=''){
				                               $html .='<a href="'.$item->twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
				                           	}
				                           	if($item->google_plus!=''){
				                               $html .='<a href="'.$item->google_plus.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
				                           	}
				                           	if($item->linkedin!=''){
				                               $html .='<a href="'.$item->linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
				                           	}
				                           	if($item->youtube!=''){
				                               $html .='<a href="'.$item->youtube.'" target="_blank"><i class="fa fa-youtube"></i></a>';
				                           	}
				                           	if($item->vimeo!=''){
				                               $html .='<a href="'.$item->vimeo.'" target="_blank"><i class="fa fa-vimeo"></i></a>';
				                           	}
				                           	if($item->instagram!=''){
				                               $html .='<a href="'.$item->instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
				                           	}
				                           	if($item->xing!=''){
				                               $html .='<a href="'.$item->xing.'" target="_blank"><i class="fa fa-xing"></i></a>';
				                           	}
				                           	if($item->joomla!=''){
				                               $html .='<a href="'.$item->joomla.'" target="_blank"><i class="fa fa-joomla"></i></a>';
				                           	}
				                           	if($item->wordpress!=''){
				                               $html .='<a href="'.$item->wordpress.'" target="_blank"><i class="fa fa-wordpress"></i></a>';
				                           	}
				                           	if($item->behance!=''){
				                               $html .='<a href="'.$item->behance.'" target="_blank"><i class="fa fa-behance"></i></a>';
				                           	}
				                           	if($item->dribbble!=''){
				                               $html .='<a href="'.$item->dribbble.'" target="_blank"><i class="fa fa-dribbble"></i></a>';
				                           	}
						            		$html .='</p>';
						            	$html .='</div>';  
						                }
						        	   $html .='<div class="tlp-content" >';
						                   if($name_field==1){
						                    if($link_detail==1){
						                        $html .='<h3><a href="'. $detail_link.'"'.$popup.'><span class="tlp-name">'. $item->name.'</span></a></h3>';
						                    }else{
						                        $html .='<h3><span class="tlp-name">'.$item->name.'</span></h3>';
						                    }
						                }
						                if($position_field==1){
						                    if($link_detail==1){
						                        $html .='<div class="tlp-position"><a href="'.$detail_link.'" '.$popup.'>'. $item->position .'</a></div>';
						                    }else{
						                        $html .='<div class="tlp-position">'. $item->position.'</div>';
						                    }
						                 }
						               $html .='</div>';
						               if($shortbio_field==1){
						                    if($link_detail==1){
						                       $html .='<div class="short-bio">
						                           <p><a href="'.$detail_link.'" '.$popup.'>'.substr($item->short_bio, 0,$short_description_limit).'</a></p>
						                       </div>';
						                    }else{
						                        $html .='<div class="short-bio">
						                           <p>'.substr($item->short_bio, 0,$short_description_limit).'</p>
						                       </div>';
						                    }
						                }
						        	$html .='</figcaption>';
						         $html .='</figure>';	
						    endif;
						   $html .='</div>';
						$html .='</div>';
					$html .='</div>';		
				endforeach;
			$html .='</div>';
		$html .='</div>';
	$html .='</div>';
echo $html; 

$itemIdsHtml = null;
  	foreach ($rows as &$item){
    	$itemIdsHtml .="<span>{$item->id}</span>";
  	}
   	if(count($rows) > 0){
      $html = null;
        $html .= "<span class='tlp-team-item-count'>";
          $html .=  $itemIdsHtml;
        $html .=  "</span>";
      echo $html;
    }
echo '</div>';
endif; ?>
<script type="text/javascript">
	(function ($) {
		var owl = $("#owl-team");
		owl.owlCarousel({
			autoplay: <?php echo $params->get( 'mod_autoplay' );?>,
			navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
			nav: <?php echo $params->get( 'mod_navigation' );?>,
			dots: <?php echo $params->get( 'mod_pagination' );?>,
			lazyLoad: <?php echo $params->get( 'mod_lazyload' );?>,
			rtl: <?php if($dir==1){ echo "true";}else{ echo "false";};?>,
			loop: <?php echo $params->get( 'mod_loop_enable' );?>,
			smartSpeed: <?php echo $params->get( 'mod_speed' );?>,
			margin: <?php echo $gutter;?>,
			autoHeight: true,
			responsiveClass: true,
			responsive: {
				0: {
					items: 1,
					nav: <?php echo $params->get( 'mod_navigation' );?>,
					dots: <?php echo $params->get( 'mod_pagination' );?>
				},
				480: {
					items: <?php echo $params->get( 'mod_display_no_mob' );?>,
					nav: <?php echo $params->get( 'mod_navigation' );?>,
					dots: <?php echo $params->get( 'mod_pagination' );?>
				},
				// breakpoint from 768 up
				768: {
					items: <?php echo $params->get( 'mod_display_no_tab' );?>,
					nav: <?php echo $params->get( 'mod_navigation' );?>,
					dots: <?php echo $params->get( 'mod_pagination' );?>
				},
				// breakpoint from 768 up
				1200: {
					items: <?php echo $params->get( 'mod_showno' );?>,
					nav: <?php echo $params->get( 'mod_navigation' );?>,
					dots: <?php echo $params->get( 'mod_pagination' );?>
				}
			}
		});
	})(jQuery);
          
</script>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/imagesloaded.pkgd.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/tlp-team.js" type="text/javascript"></script>
