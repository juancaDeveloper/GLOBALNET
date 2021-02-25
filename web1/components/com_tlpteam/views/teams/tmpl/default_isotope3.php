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

foreach ($allmembers as $key => $item) : 

if($link_type==2){ 
      $popup=' data-id="'.$item->id.'" class="tlp-single-item-popup"';
  }else{
      $popup= null;
  }
  $detail_link=JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $item->id);
		

  	$html .='<div class="team-item cat'.strtolower($item->department).' '. $bss.' '.$item_margin.' tlp-equal-height '.$image_style_class.'">';
	      if (!empty($item->profile_image)):
	      	$html .='<div class="single-team-area">';
		      	$html .='<figure>';
		      	    if($link_detail==1){
		                $html .='<a href="'.$detail_link.'"'.$popup.'><img class="img-responsive '.$gray_scale.'" src="'. JURI::root().$image_storiage_path.'/m_'.$item->profile_image.'" alt="'.$item->name.'"/></a>';
		              }else{
		                $html .='<img class="img-responsive '.$gray_scale.'" src="'.JURI::root().$image_storiage_path.'/m_'.$item->profile_image.'" alt="'.$item->name.'"/>';
		              }               
	      	        $html .='<figcaption>';
	      	            $html .='<div class="tlp-overlay">';
      	             	   	if($name_field==1){
					            if($link_detail==1){
					                $html .='<h3><a href="'. $detail_link.'"'.$popup.'><span class="tlp-name">'. $item->name.'</span></a></h3>';
					            }else{
					                $html .='<h3><span class="tlp-name">'.$item->name.'</span></h3>';
					            }
					          }
	      	                if($position_field==1){
				                $html .='<p class="tlp-position">'.$item->position.'</p>';
				            }
	      	                if($shortbio_field==1){
					           $html .='<div class="short-bio">
					               <p>'.substr($item->short_bio, 0,$short_description_limit).'</p>
					           </div>';
					           }
  	                       if($socialicon_field==1){ 
					          $html .='<p class="social-icons">';  
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
					        }
	      	            $html .='</div>';
	      	        $html .='</figcaption>'; 
	      	    $html .='</figure>';    
	      	$html .='</div>';
        endif; 	
	$html .='</div>';
endforeach;
 $html .='</div>';
$html .='</div>';

echo $html;