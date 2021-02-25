<?php
/**
 * @version     2.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_tlpteam');
$canEdit    = $user->authorise('core.edit', 'com_tlpteam');
$canCheckin = $user->authorise('core.manage', 'com_tlpteam');
$canChange  = $user->authorise('core.edit.state', 'com_tlpteam');
$canDelete  = $user->authorise('core.delete', 'com_tlpteam');

$app = JFactory::getApplication();
$tlpteam_params = JComponentHelper::getParams('com_tlpteam');
$image_storiage_path          = $tlpteam_params->get('image_path','images/tlpteam');
$g_primary_color              = $tlpteam_params->get('g_primary_color','#0d57e0');
$g_name_font_size             = $tlpteam_params->get('g_name_font_size','20');
$g_name_font_color            = $tlpteam_params->get('g_name_font_color');
$g_name_text_align            = $tlpteam_params->get('g_name_text_align');
$g_position_font_size         = $tlpteam_params->get('g_position_font_size');
$g_position_font_color        = $tlpteam_params->get('g_position_font_color');
$g_position_text_align        = $tlpteam_params->get('g_position_text_align');
$g_short_bio_font_color       = $tlpteam_params->get('g_short_bio_font_color');
$g_short_bio_text_align       = $tlpteam_params->get('g_short_bio_text_align');
$g_social_icon_background     = $tlpteam_params->get('g_social_icon_background');
$g_social_icon_color          = $tlpteam_params->get('g_social_icon_color');
$g_social_icon_size           = $tlpteam_params->get('g_social_icon_size','16');
$link_detail                  = $tlpteam_params->get('link_detail','1');
$link_type                    = $tlpteam_params->get('link_type','2');
$g_layout                     = $tlpteam_params->get('g_layout','layout1');
$g_item_to_item_margin        = $tlpteam_params->get('g_item_to_item_margin','1');
$g_overlay_opacity            = $tlpteam_params->get('g_overlay_opacity','.5');
$g_display_no                 = $tlpteam_params->get('g_display_no','4');
$g_display_no_tab             = $tlpteam_params->get('g_display_no_tab','3');
$g_display_no_mob             = $tlpteam_params->get('g_display_no_mob','1');
$bootstrap_version            = $tlpteam_params->get('bootstrap_version','1');
$g_overlay_color              = $tlpteam_params->get('g_overlay_color');
$g_image_style                = $tlpteam_params->get('g_image_style','1');
$g_name_field                 = $tlpteam_params->get('g_name_field','1');
$g_position_field             = $tlpteam_params->get('g_position_field','1');
$g_shortbio_field             = $tlpteam_params->get('g_shortbio_field','1');
$g_email_field                = $tlpteam_params->get('g_email_field','1');
$g_phoneno_field              = $tlpteam_params->get('g_phoneno_field','1');
$g_mobileno_field             = $tlpteam_params->get('g_mobileno_field','1');
$g_website_field              = $tlpteam_params->get('g_website_field','1');
$g_location_field             = $tlpteam_params->get('g_location_field','1');
$g_skill_field                = $tlpteam_params->get('g_skill_field','1');
$g_socialicon_field           = $tlpteam_params->get('g_socialicon_field','1');
$g_short_description_limit    = $tlpteam_params->get('g_short_description_limit','160');
$g_overlay_item_padding       = $tlpteam_params->get('g_overlay_item_padding','15');
$g_btn_bg                     = $tlpteam_params->get('g_btn_bg');
$g_btn_text_color             = $tlpteam_params->get('g_btn_text_color');
$g_btn_bg_hover               = $tlpteam_params->get('g_btn_bg_hover');
$g_gutter                     = $tlpteam_params->get('g_gutter');
$g_gray_scale                 = $tlpteam_params->get('g_gray_scale');

// get the menu parameters for use
// $input = JFactory::getApplication()->input;
// $menuitemid = $input->getInt( 'Itemid' );
// @$menu = JSite::getMenu();
$app = JFactory::getApplication();
$menu = $app->getMenu();
$active = $menu->getActive();
$itemId = $active->id;
$menuparams                   = $menu->getParams($itemId);
$category_id                  = $menuparams->get("category");
$m_primary_color              = $menuparams->get("m_primary_color");
$m_display_no                 = $menuparams->get("m_display_no");
$m_display_no_tab             = $menuparams->get("m_display_no_tab");
$m_display_no_mob             = $menuparams->get("m_display_no_mob");
$m_layout                     = $menuparams->get("m_layout");
$m_item_to_item_margin        = $menuparams->get('m_item_to_item_margin');
$m_name_font_size             = $menuparams->get('m_name_font_size');
$m_name_font_color            = $menuparams->get('m_name_font_color');
$m_name_text_align            = $menuparams->get('m_name_text_align');
$m_position_font_size         = $menuparams->get('m_position_font_size');
$m_position_font_color        = $menuparams->get('m_position_font_color');
$m_position_text_align        = $menuparams->get('m_position_text_align');
$m_short_bio_font_color       = $menuparams->get('m_short_bio_font_color');
$m_short_bio_text_align       = $menuparams->get('m_short_bio_text_align');
$m_social_icon_background     = $menuparams->get('m_social_icon_background');
$m_social_icon_color          = $menuparams->get('m_social_icon_color');
$m_social_icon_size           = $menuparams->get('m_social_icon_size');
$m_overlay_color              = $menuparams->get('m_overlay_color');
$m_overlay_opacity            = $menuparams->get('m_overlay_opacity');
$m_image_style                = $menuparams->get('m_image_style');
$m_name_field                 = $menuparams->get('m_name_field');
$m_position_field             = $menuparams->get('m_position_field');
$m_shortbio_field             = $menuparams->get('m_shortbio_field');
$m_email_field                = $menuparams->get('m_email_field');
$m_phoneno_field              = $menuparams->get('m_phoneno_field');
$m_mobileno_field             = $menuparams->get('m_mobileno_field');
$m_website_field              = $menuparams->get('m_website_field');
$m_location_field             = $menuparams->get('m_location_field');
$m_skill_field                = $menuparams->get('m_skill_field');
$m_socialicon_field           = $menuparams->get('m_socialicon_field');
$m_short_description_limit    = $menuparams->get('m_short_description_limit');
$m_overlay_item_padding       = $menuparams->get('m_overlay_item_padding');
$m_btn_bg                     = $menuparams->get('m_btn_bg');
$m_btn_text_color             = $menuparams->get('m_btn_text_color');
$m_btn_bg_hover               = $menuparams->get('m_btn_bg_hover');
$category                     = $menuparams->get('category');
$m_link_detail                = $menuparams->get('m_link_detail','');
$m_link_type                  = $menuparams->get('m_link_type','');
$m_gutter                     = $menuparams->get('m_gutter','');
$m_gray_scale                 = $menuparams->get('m_gray_scale','');
$layout2_image_area           = $menuparams->get('m_layout2_image_area','');
@$hide_showall                = $menuparams->get('m_hide_showall','');
@$mod_selected_category       = $menuparams->get('m_selected_category','');
$pretext                      = $menuparams->get('pretext','');

if($m_primary_color!=''){ 
  $primary_color=$m_primary_color;
}else{ 
  $primary_color=$g_primary_color;
}
if($m_name_font_size!=''){
  $name_font_size=$m_name_font_size;
}else{
  $name_font_size=$g_name_font_size;
}
if($m_name_font_color!=''){
  $name_font_color=$m_name_font_color;
}else{
  $name_font_color=$g_name_font_color;
}
if($m_name_text_align!=''){
  $name_text_align=$m_name_text_align;
}else{
  $name_text_align=$g_name_text_align;
}
if($m_position_font_size!=''){
  $position_font_size=$m_position_font_size;
}else{
  $position_font_size=$g_position_font_size;
}
if($m_position_font_color!=''){
  $position_font_color=$m_position_font_color;
}else{
  $position_font_color=$g_position_font_color;
}
if($m_position_text_align!=''){
  $position_text_align=$m_position_text_align;
}else{
  $position_text_align=$g_position_text_align;
}
if($m_short_bio_font_color!=''){
  $short_bio_font_color=$m_short_bio_font_color;
}else{
  $short_bio_font_color=$g_short_bio_font_color;
}
if($m_short_bio_text_align!=''){
  $short_bio_text_align=$m_short_bio_text_align;
}else{
  $short_bio_text_align=$g_short_bio_text_align;
}
if($m_social_icon_background!=''){
  $social_icon_background=$m_social_icon_background;
}else{
  $social_icon_background=$g_social_icon_background;
}
if($m_social_icon_color!=''){
  $social_icon_color=$m_social_icon_color;
}else{
  $social_icon_color=$g_social_icon_color;
}
if($m_social_icon_size!=''){
  $social_icon_size=$m_social_icon_size;
}else{
  $social_icon_size=$g_social_icon_size;
}
if($m_image_style!=''){
  $image_style=$m_image_style;
}else{
  $image_style=$g_image_style;
}
if($m_item_to_item_margin!=''){
  $item_to_item_margin=$m_item_to_item_margin;
}else{
  $item_to_item_margin=$g_item_to_item_margin;
}
if($m_name_field!=''){
  $name_field=$m_name_field;
}else{
  $name_field=$g_name_field;
}
if($m_position_field!=''){
  $position_field=$m_position_field;
}else{
  $position_field=$g_position_field;
}
if($m_shortbio_field!=''){
  $shortbio_field=$m_shortbio_field;
}else{
  $shortbio_field=$g_shortbio_field;
}
if($m_email_field!=''){
  $email_field=$m_email_field;
}else{
  $email_field=$g_email_field;
}
if($m_phoneno_field!=''){
  $phoneno_field=$m_phoneno_field;
}else{
  $phoneno_field=$g_phoneno_field;
}
if($m_mobileno_field!=''){
  $mobileno_field=$m_mobileno_field;
}else{
  $mobileno_field=$g_mobileno_field;
}
if($m_website_field!=''){
  $website_field=$m_website_field;
}else{
  $website_field=$g_website_field;
}
if($m_location_field!=''){
  $location_field=$m_location_field;
}else{
  $location_field=$g_location_field;
}
if($m_skill_field!=''){
  $skill_field=$m_skill_field;
}else{
  $skill_field=$g_skill_field;
}
if($m_socialicon_field!=''){
  $socialicon_field=$m_socialicon_field;
}else{
  $socialicon_field=$g_socialicon_field;
}
if($m_overlay_opacity!=''){
  $overlay_opacity=$m_overlay_opacity;
}else{
  $overlay_opacity=$g_overlay_opacity;
}
if($m_short_description_limit!=''){
  $short_description_limit=$m_short_description_limit;
}else{
  $short_description_limit=$g_short_description_limit;
}
if($m_overlay_item_padding!=''){
  $overlay_item_padding=$m_overlay_item_padding;
}else{
  $overlay_item_padding=$g_overlay_item_padding;
}
if($m_overlay_color!=''){
  $overlay_color=$m_overlay_color;
}else{
  $overlay_color=$g_overlay_color;
}
if($m_btn_bg!=''){
  $btn_bg=$m_btn_bg;
}else{
  $btn_bg=$g_btn_bg;
}
if($m_btn_bg_hover!=''){
  $btn_bg_hover=$m_btn_bg_hover;
}else{
  $btn_bg_hover=$g_btn_bg_hover;
}
if($m_btn_text_color!=''){
  $btn_text_color=$m_btn_text_color;
}else{
  $btn_text_color=$g_btn_text_color;
}
if($m_link_detail!=''){
  $link_detail = $m_link_detail;
}else{
  $link_detail = $link_detail;
}
if($m_link_type!=''){
  $link_type = $m_link_type;
}else {
  $link_type = $link_type;
}
if($m_gray_scale!=''){
  $gray_scale = $m_gray_scale;
}else{
  $gray_scale = $g_gray_scale;
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
if($m_layout!=''){ 
  $layout=$m_layout;
}else{
  $layout=$g_layout;
}
if($m_display_no!=''){
  $display_no=$m_display_no; 
  $md_grid=(12/$m_display_no);
}else{
  $display_no=$g_display_no; 
  $md_grid=(12/$g_display_no);
}

if ( $m_display_no_tab != '' ) {
  $sm_grid = ( 12 / $m_display_no_tab );
} else {
  $sm_grid = ( 12 / $g_display_no_tab );
}
if ( $m_display_no_mob != '' ) {
  $xs_grid = ( 12 / $m_display_no_mob );
} else {
  $xs_grid = ( 12 / $g_display_no_mob );
}

if($m_gutter !='') {
  $gutter = $m_gutter;
}else {
  $gutter = $g_gutter;
}

if($item_to_item_margin==0){
    $item_margin = 'allmargin0';
}else{
    $item_margin = '';
}
if($gray_scale==1){
  $grayscale_class = 'tlp-grayscale';
}else{
  $grayscale_class = '';
}
if($image_style==2){ 
  $image_style_class = ' tlp-round-picture';
}else {
  $image_style_class = '';
}

@$layout2_content_area = (12-$layout2_image_area);

if($bootstrap_version==3){
    $bss="col-md-".$md_grid." col-lg-".$md_grid." col-sm-".$sm_grid. " col-xs-".$xs_grid;

    $image_area="col-md-".$layout2_image_area." col-lg-".$layout2_image_area." col-sm-6 col-xs-6 paddingl0";
    $content_area="col-md-".$layout2_content_area." col-lg-".$layout2_content_area." col-sm-6 col-xs-6 paddingr0";
      
  }else{
    $bss="tlp-col-md-".$md_grid." tlp-col-lg-".$md_grid." tlp-col-sm-". $sm_grid. " tlp-col-xs-".$xs_grid;

    $image_area="tlp-col-md-".$layout2_image_area." tlp-col-lg-".$layout2_image_area." tlp-col-sm-6 tlp-col-xs-6";
    $content_area="tlp-col-md-".$layout2_content_area." tlp-col-lg-".$layout2_content_area." tlp-col-sm-6 tlp-col-xs-6";
  }


$document = JFactory::getDocument();

$style  = '.tlp-team .skill-prog .fill, .tlp-tooltip + .tooltip > .tooltip-inner, .tlp-team .layout1 .tlp-content-layout1, .tlp-team .layout6 .tlp-info-block, .tlp-popup-wrap .tlp-popup-navigation-wrap { background: ' . $primary_color . '; }';
$style .= '.tlp-team .skill-prog .fill,.tlp-team .contact-info .fa { color: ' . $primary_color . '; }';
$style .= '.tlp-team .skill-prog .fill { color: ' . $primary_color . '; }';
$style .= '.tooltip.top .tooltip-arrow { border-top-color: ' . $primary_color . '; }';
$style .= '.tlp-team .social-icons a { background: ' . $social_icon_background . '!important; color: '. $social_icon_color. '!important; font-size: '. $social_icon_size .'px; }';
if($social_icon_background==''){
$style .= '.tlp-team .social-icons a:hover .fa-facebook,.tlp-team .social-icons a:hover .fa-twitter, .tlp-team .social-icons a:hover .fa-linkedin, .tlp-team .social-icons a:hover .fa-google-plus, .tlp-team .social-icons a:hover .fa-youtube, .tlp-team .social-icons a:hover .fa-vimeo, .tlp-team .social-icons a:hover .fa-instagram 
, .tlp-team .social-icons a:hover .fa-xing , .tlp-team .social-icons a:hover .fa-joomla , .tlp-team .social-icons a:hover .fa-wordpress , .tlp-team .social-icons a:hover .fa-behance , .tlp-team .social-icons a:hover .fa-dribbble  { background: none; color: '. $social_icon_color. '; opacity: .8; }';
}
$style .= '.tlp-team .button-group button { background:'.$btn_bg.' !important; color:'.$btn_text_color.';}';
$style .= '.tlp-team .button-group button:hover,.tlp-team .button-group button.selected { background:'.$btn_bg_hover.'!important;}';

if($layout=='layout1'){
$style .= '.tlp-team .layout1 .single-team-area h3,.tlp-team .layout1 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout1 .tlp-position { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout1 .short-bio p { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .layout1 .overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
}
if($layout=='layout2'){
$style .= '.tlp-team .layout2 h3,.tlp-team .layout2 h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout2 .tlp-position { color: ' . $position_font_color . '; font-size: '. $position_font_size. '; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout2 .short-bio p { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
}
if($layout=='layout3'){
$style .= '.tlp-team .layout3 h3,.tlp-team .layout3 h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout3 .tlp-position { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout3 .short-bio p { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
$style .= '.tlp-team .layout3 .social-icons { text-align: center; }';
}
if($layout=='layout4'){
$style .= '.tlp-team .layout4 .single-team-area h3,.tlp-team .layout4 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout4 .tlp-position,.tlp-team .layout4 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout4 .short-bio p,.tlp-team .layout4 .short-bio p a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .layout4 .single-team-area .overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
$style .= '.tlp-team .layout4 .single-team-area .tlp-content { padding-top: ' . $overlay_item_padding . '%; }';
}
if($layout=='layout5'){
$style .= '.tlp-team .layout5 h3,.tlp-team .layout5 h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'px; }';
$style .= '.tlp-team .layout5 .tlp-position { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
}
if($layout=='layout6'){
$style .= '.tlp-team .contact-info a,.tlp-team .contact-info .fa { color: ' . $name_font_color .'; }';
$style .= '.tlp-team .layout6 .tlp-content h3 span,.tlp-team .layout6 .tlp-content h3 a span { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout6 .tlp-position,.tlp-team .layout6 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout6 .short-bio,.tlp-team .layout6 .short-bio a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
$style .= '.tlp-team .layout6 .tlp-right-arrow:after { border-color: transparent ' . $primary_color .'; }';
$style .= '.tlp-team .layout6 .tlp-left-arrow:after { border-color: ' . $primary_color .' transparent transparent; }';
}
if($layout=='layout7'){
$style .= '.tlp-team .layout7 .single-team-area h3,.tlp-team .layout7 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout7 .tlp-position,.tlp-team .layout7 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout7 .short-bio,.tlp-team .layout7 .short-bio a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .layout7 figcaption:hover { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
$style .= '.tlp-team .layout7 .tlp-team-item h3 { padding-top: ' . $overlay_item_padding . '%; }';
}
if($layout=='layout8'){
$style .= '.tlp-team .layout8 .tlp-overlay h3,.tlp-team .layout8 .tlp-overlay h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout8 .tlp-position,.tlp-team .layout8 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout8 .tlp-content p { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .layout8 .tlp-overlay .tlp-title { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
//$style .='.tlp-team .layout7 .tlp-team-item h3 { padding-top: '. $overlay_item_padding.';}';
}
if($layout=='layout9'){
$style .= '.tlp-team .layout9 .single-team-area h3,.tlp-team .layout9 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout9 .tlp-position,.tlp-team .layout9 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout9 .short-bio p,.tlp-team .layout9 .short-bio p a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .layout9 .single-team-area:hover .tlp-overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
$style .= '.tlp-team .layout9 .single-team-area:hover h3 { margin-top: ' . $overlay_item_padding . '%; }';
}
if($layout=='layout10'){
$style .= '.tlp-team .layout10 .single-team-area h3,.tlp-team .layout10 .single-team-area h3 a, .tlp-team .layout10 .tlp-team-item .tlp-info h3,.tlp-team .layout10 .tlp-team-item .tlp-info h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout10 .tlp-position,.tlp-team .layout10 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout10 .tlp-overlay p,.tlp-team .layout10 .tlp-overlay p a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .layout10 .image-container:hover .tlp-overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
}
if($layout=='layout11'){
$style .= '.tlp-team .layout11 .single-team-area .tlp-title h3,.tlp-team .layout11 .single-team-area .tlp-title h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout11 .tlp-position, .tlp-team .layout11 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';

if($overlay_color){
$style .= '.tlp-team .layout11 .single-team-area .tlp-title { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
}

if($layout=='layout12'){
$style .= '.tlp-team .layout12 .single-team-area h3 span { background:'.$primary_color.';}';
$style .= '.tlp-team .layout12 .single-team-area h3,.tlp-team .layout12 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout12 .tlp-position,.tlp-team .layout12 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout12 .short-bio p,.tlp-team .layout12 .short-bio p a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .layout12 .single-team-area .tlp-title { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
$style .= '.tlp-team .layout12 .single-team-area:hover .tlp-overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
$style .='.tlp-team .layout12 .single-team-area:hover h3 { margin-top:'.$overlay_item_padding.'%;}';
}

if($layout=='layout13'){
$style .= '.tlp-team .layout13 .single-team-area h3,.tlp-team .layout13 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout13 .tlp-position,.tlp-team .layout13 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout13 .item-info p,.tlp-team .layout13 .item-info p a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
$style .= '.tlp-team .layout13 .tlp-overlay .item-info { padding-top:'.$overlay_item_padding.'%;}';
if($overlay_color){
$style .= '.tlp-team .layout13 .tlp-overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
}
if($layout=='layout14'){
$style .= '.tlp-team .layout14 .single-team-area h3,.tlp-team .layout14 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .layout14 .tlp-position,.tlp-team .layout14 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .layout14 .item-info p { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
$style .= '.tlp-team .layout14 .tlp-overlay .item-info { padding-top:'.$overlay_item_padding.'%;}';
if($overlay_color){
$style .= '.tlp-team .layout14 .tlp-overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
}

if($layout=='isotope1'){
$style .= '.tlp-team .isotope1 .team-item h3,.tlp-team .isotope1 .team-item h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .isotope1 .team-item .overlay .tlp-position, .tlp-team .isotope1 .team-item .overlay .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .isotope1 .overlay .short-bio, .tlp-team .isotope1 .overlay .short-bio a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .isotope1 .team-item .overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
}
if($layout=='isotope2'){
$style .= '.tlp-team .isotope2 h3,.tlp-team .isotope2 h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .isotope2 .tlp-position { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .isotope2 .short-bio { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
}
if($layout=='isotope3'){
$style .= '.tlp-team .isotope3 .single-team-area h3,.tlp-team .isotope3 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .isotope3 .tlp-position { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .isotope3 .short-bio { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .isotope3 .single-team-area:hover .tlp-overlay{ background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
$style .= '.tlp-team .isotope3 .single-team-area:hover h3 { margin-top: ' . $overlay_item_padding . '%; }';
}
if($layout=='isotope4'){
$style .= '.tlp-team .isotope4 .tlp-team-item h3,.tlp-team .isotope4 .tlp-team-item h3 a  { color: ' . $name_font_color . '!important; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .isotope4 .tlp-position,.tlp-team .isotope4 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .isotope4 .short-bio { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .isotope4 figcaption:hover { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
$style .= '.tlp-team .isotope4 .tlp-team-item h3 { padding-top: ' . $overlay_item_padding . '%; }';

}
if($layout=='isotope5'){
$style .= '.tlp-team .isotope5 .single-team-area .tlp-title h3,.tlp-team .isotope5 .single-team-area .tlp-title h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .isotope5 .tlp-position,.tlp-team .isotope5 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .isotope5 .tlp-content p { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .isotope5 .single-team-area .tlp-title { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
$style .= '.tlp-team .isotope5 .single-team-area .social-icons { padding-top: ' . $overlay_item_padding . '%; }';

}
if($layout=='isotope6'){
$style .= '.tlp-team .isotope6 .single-team-area h3 span { background:'.$primary_color.';}';
$style .= '.tlp-team .isotope6 .single-team-area h3,.tlp-team .isotope6 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .isotope6 .tlp-position,.tlp-team .isotope6 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .isotope6 .short-bio p, .tlp-team .isotope6 .short-bio p a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .isotope6 .single-team-area .tlp-title { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
$style .= '.tlp-team .isotope6 .single-team-area:hover .tlp-overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
$style .= '.tlp-team .isotope6 .single-team-area:hover h3 { margin-top: ' . $overlay_item_padding . '%; }';
}
if($layout=='isotope7'){
$style .= '.tlp-team .isotope7 .single-team-area h3,.tlp-team .isotope7 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .isotope7 .tlp-position, .tlp-team .isotope7 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .isotope7 .tlp-overlay .short-bio p,.tlp-team .isotope7 .tlp-overlay .short-bio p a { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .isotope7 .tlp-overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
$style .= '.tlp-team .isotope7 .tlp-overlay .item-info { padding-top:'.$overlay_item_padding.'%; }';
}

if($layout=='isotope8'){
$style .= '.tlp-team .isotope8 .single-team-area h3,.tlp-team .isotope8 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .isotope8 .tlp-position, .tlp-team .isotope8 .tlp-position a { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .isotope8 .item-info p { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
$style .= '.tlp-team .isotope8 .tlp-overlay .item-info { padding-top:'.$overlay_item_padding.'%;}';
if($overlay_color){
$style .= '.tlp-team .isotope8 .tlp-overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
}
if($layout=='isotope9'){
$style .= '.tlp-team .isotope9 .single-team-area h3,.tlp-team .isotope9 .single-team-area h3 a { color: ' . $name_font_color . '; font-size: '. $name_font_size. 'px; text-align: '. $name_text_align .'; }';
$style .= '.tlp-team .isotope9 .tlp-position { color: ' . $position_font_color . '; font-size: '. $position_font_size. 'px; text-align: '. $position_text_align .'; }';
$style .= '.tlp-team .isotope9 .short-bio p { color: ' . $short_bio_font_color . '; text-align: '. $short_bio_text_align .'; }';
if($overlay_color){
$style .= '.tlp-team .isotope9 .overlay { background-color: rgba(' . $r.','.$g.','.$b . ','.$overlay_opacity.'); }';
}
}
if($gutter){
  $style .= '.tlp-team .tlp-equal-height { margin-bottom: 0px;}';
  $style .= '.tlp-team [class*=tlp-col-] { padding-left : '.$gutter.'px; padding-right : '.$gutter.'px; margin-bottom : '.($gutter*2).'px; }';
  $style .= '.tlp-row { margin-left : -'.$gutter.'px!important; margin-right : -'.$gutter.'px!important;}';
  
}
$document->addStyleDeclaration( $style );
?>
<?php
$this->tlpconfig= array(
    'image_storiage_path' => $image_storiage_path,
    'category_id' =>$category_id,
    'bss' =>$bss,
    'display_no' =>$display_no,
    'link_detail' => $link_detail,
    'link_type' => $link_type,
    'item_to_item_margin'=>$item_to_item_margin,
    'bootstrap_version'=>$bootstrap_version,
    'name_field'=>$name_field,
    'shortbio_field'=>$shortbio_field,
    'position_field'=>$position_field,
    'email_field'=>$email_field,
    'phoneno_field'=>$phoneno_field,
    'mobileno_field'=>$mobileno_field,
    'website_field'=>$website_field,
    'location_field'=>$location_field,
    'skill_field'=>$skill_field,
    'socialicon_field'=>$socialicon_field,
    'short_description_limit'=>$short_description_limit,
    'image_style'=>$image_style,
    'image_area'=>$image_area,
    'content_area'=>$content_area,
    'item_margin'=>$item_margin,
    'gray_scale'=>$grayscale_class,
    'image_style_class'=>$image_style_class,
    'hide_showall' => $hide_showall,
    'mod_selected_category' => $mod_selected_category
);
$model      = $this->getModel();
$mtotal = $model->getTotal();
$perpage=(int) JFactory::getConfig()->get('list_limit');
?>
<div class="tlp-team-wrap">
<?php if($pretext){
  echo "<div class='tlp-pre-text'>".$pretext."</div>";
  }?>
<?php if(($layout=='isotope1')||($layout=='isotope2')||($layout=='isotope3')||($layout=='isotope4')||($layout=='isotope5')||($layout=='isotope6')||($layout=='isotope7')||($layout=='isotope8')||($layout=='isotope9')){ ?>
<div class="container-fluid">
  <div class="tlp-row tlp-team">
  	<div class="<?php echo $layout;?>">
  		<?php
  			$this->item = & $item;
  			echo $this->loadTemplate($layout);
  		?>
  	</div>
  </div>
</div>
<?php }elseif($layout=='layout5'){?>
<form action="<?php echo JRoute::_('index.php?option=com_tlpteam&view=teams'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="container-fluid">
  		<div class="tlp-row">
  			<div class="tlp-team single-team-area">
  				<div class="single-team <?php if($image_style==2){?>tlp-round-picture <?php }?> <?php echo $layout;?>">
  					<table class="table table-striped table-responsive">
  						<?php
  						  foreach ($this->items as &$item) : 
     							$this->item = & $item;
     							echo $this->loadTemplate($layout);
     						endforeach; ?>
  					</table>
  				</div>
  			</div>
  		</div>
  	</div>
  <?php 
  if($mtotal>$perpage){
  ?>
	<div class="container-fluid">
		<div class="tlp-row">
	     	<?php echo $this->pagination->getListFooter(); ?>
		</div>
	</div>
  <?php }?>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php }else{?>

<form action="<?php echo JRoute::_('index.php?option=com_tlpteam&view=teams');?>" method="post" name="adminForm" id="adminForm">
  <div class="container-fluid tlp-team">
		<div class="tlp-row <?php echo $layout;?> ">
				<?php
				    $j=0;$k=1; $i=2;
				    $this->l8 = 0;
				    $count = count($this->items);
					foreach ($this->items as &$item) :
						
						$j++;
					if($k== 1){
					//echo '<div class="row-fluid margin-bottom">';
						} ?>
					<div class="<?php echo $bss.' '.$image_style_class;?> tlp-equal-height <?php if($item_to_item_margin==0){echo 'allmargin0';}?> ">
   					<?php
   						$this->item = & $item;
   						$this->k = & $k;
   						echo $this->loadTemplate($layout);
   					?>
					</div>
					<?php
				     if($k == $display_no || $count == $j){
				     	//echo '</div>';
				     	if($this->l8 == 0){
				     		$this->l8 = 1;
				     	}else if($this->l8 == 1){
				     		$this->l8 = 0;
				     	}
				     $k=0;
					 }
					 $k++; $i++;

				 endforeach;
				 $j;?>
		</div>
	</div>
<?php 
if($mtotal>$perpage){
?>
<div class="container-fluid">
	<div class="tlp-row">
     	<?php echo $this->pagination->getListFooter(); ?>
	</div>
</div>
<?php }?>
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>
<?php }?>
<?php $allmembers=TlpteamFrontendHelper::getAllMembersCount($category_id);
      $itemIdsHtml = null;
      foreach($allmembers as $mc){
        $itemIdsHtml .="<span>{$mc->id}</span>";
      }
        if(count($allmembers) > 0){
          $html = null;
            $html .= "<span class='tlp-team-item-count'>";
              $html .=  $itemIdsHtml;
            $html .=  "</span>";
          echo $html;
        }
      ?>
</div>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/imagesloaded.pkgd.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/tlp-team.js" type="text/javascript"></script>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/tooltip.min.js" type="text/javascript"></script>
