<?php
/**
 * @version     1.1
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// no direct access
defined('_JEXEC') or die;
extract($this->tlpconfig); 

$html ='';

$html .='<div class="isotop-container">';
  $html .='<div class="button-group filter-button-group">';
  if(!$hide_showall){
		$selected = $mod_selected_category ? null : " class='selected'" ;
		$html .='<button data-filter="*" '.$selected.'>'.JText::_('COM_TLPTEAM_FORM_LBL_BTN_SHOW_ALL').'</button>';
	}
	$category=TlpteamFrontendHelper::getCategoryName($category_id);
	foreach ($category as $key => $value) {
		$selected = null;
		if($value->id == $mod_selected_category){
			$selected = " class='selected'";
		}
		$html .='<button '.$selected.' data-filter=".cat'.strtolower($value->id).'">'.$value->title.'</button>';
	}
  
$html .='</div>';
$html .='<div class="tlp-team-grid">';

$allmembers=TlpteamFrontendHelper::getAllMembers($category_id);

foreach ($allmembers as $key => $item):

if($link_type==2){ 
      $popup=' data-id="'.$item->id.'" class="tlp-single-item-popup"';
  }else{
      $popup= null;
  }
  $detail_link=JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $item->id);
		

  		$html .='<div class="team-item cat'.strtolower($item->department).' '. $bss.' '.$item_margin.' tlp-equal-height '.$image_style_class.'">';
	      if (!empty($item->profile_image)):
	      	$html .='<div class="single-team-area">';
			  $html .='<div class="item-img">'; 
			    $html .='<figure>';
			      if($link_detail==1){
	                $html .='<a href="'.$detail_link.'"'.$popup.'><img class="img-responsive '.$gray_scale.'" src="'. JURI::root().$image_storiage_path.'/m_'.$item->profile_image.'" alt="'.$item->name.'"/></a>';
	              }else{
	                $html .='<img class="img-responsive '.$gray_scale.'" src="'.JURI::root().$image_storiage_path.'/m_'.$item->profile_image.'" alt="'.$item->name.'"/>';
	              }                
			    $html .='</figure>';
			  $html .='</div>';
			    $html .='<div class="tlp-overlay">';
			    $html .='<div class="item-info">';
			      $html .='<div class="item-info-top">';
			       if($name_field==1){
	                    if($link_detail==1){
	                        $html .='<h3><a href="'. $detail_link.'"'.$popup.'><span class="tlp-name">'. $item->name.'</span></a></h3>';
	                    }else{
	                        $html .='<h3><span class="tlp-name">'.$item->name.'</span></h3>';
	                    }
                	}
			        $html .='<div class="line"></div>';
			      $html .='</div>';
			      $html .='<div class="item-info-bottom">';
			      if($position_field==1){
	                    if($link_detail==1){
	                        $html .='<div class="tlp-position"><span><a href="'.$detail_link.'" '.$popup.'>'. $item->position .'</a></span></div>';
	                    }else{
	                        $html .='<div class="tlp-position"><span>'. $item->position.'</span></div>';
	                    }
                 	}
			      
			      $html .='</div>';
			    $html .='</div>';
			    $html .='</div>';
			$html .='</div>';
			endif;
		$html .='</div>';
	endforeach;
 	$html .='</div>';
$html .='</div>';

echo $html;