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
$detail_link=JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $this->item->id);
extract($this->tlpconfig); 
if($link_type==2){ 
        $popup=' data-id="'.$this->item->id.'" class="tlp-single-item-popup"';
    }else{
        $popup= null;
    }

$html ='';

if (!empty($this->item->profile_image)):
$html .='<div class="single-team-area'. $image_style_class.'">';
    $html .='<figure>';
        if($link_detail==1){
            $html .='<a href="'.$detail_link.'"'.$popup.'><img class="img-responsive '.$gray_scale.'" src="'. JURI::root().$image_storiage_path.'/m_'.$this->item->profile_image.'" alt="'.$this->item->name.'"/></a>';
        }else{
            $html .='<img class="img-responsive '.$gray_scale.'" src="'.JURI::root().$image_storiage_path.'/m_'.$this->item->profile_image.'" alt="'.$this->item->name.'"/>';
        } 
    $html .='</figure>';
    $html .='<div class="tlp-overlay">';
        if($name_field==1){
            if($link_detail==1){
                $html .='<h3><a href="'. $detail_link.'"'.$popup.'><span class="tlp-name">'. $this->item->name.'</span></a></h3>';
            }else{
                $html .='<h3><span class="tlp-name">'.$this->item->name.'</span></h3>';
            }
        }
        if($position_field==1){
            if($link_detail==1){
                $html .='<div class="tlp-position"><span><a href="'.$detail_link.'" '.$popup.'>'. $this->item->position .'</a></span></div>';
            }else{
                $html .='<div class="tlp-position"><span>'. $this->item->position.'</span></div>';
            }
         }
        if($shortbio_field==1){
            if($link_detail==1){
               $html .='<div class="short-bio">
                   <p><a href="'.$detail_link.'" '.$popup.'>'.substr($this->item->short_bio, 0,$short_description_limit).'</a></p>
               </div>';
            }else{
                $html .='<div class="short-bio">
                   <p>'.substr($this->item->short_bio, 0,$short_description_limit).'</p>
               </div>';
            }
        }
       
        if($socialicon_field==1){ 
          $html .='<div class="social-icons">';  
             if($this->item->facebook!=''){ 
                 $html .='<a href="'.$this->item->facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
             }
             if($this->item->twitter!=''){
                 $html .='<a href="'.$this->item->twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
             }
             if($this->item->google_plus!=''){
                 $html .='<a href="'.$this->item->google_plus.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
             }
             if($this->item->linkedin!=''){
                 $html .='<a href="'.$this->item->linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
             }
             if($this->item->youtube!=''){
                 $html .='<a href="'.$this->item->youtube.'" target="_blank"><i class="fa fa-youtube"></i></a>';
             }
             if($this->item->vimeo!=''){
                 $html .='<a href="'.$this->item->vimeo.'" target="_blank"><i class="fa fa-vimeo"></i></a>';
             }
             if($this->item->instagram!=''){
                 $html .='<a href="'.$this->item->instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
             }
             if($this->item->xing!=''){
                 $html .='<a href="'.$this->item->xing.'" target="_blank"><i class="fa fa-xing"></i></a>';
             }
             if($this->item->joomla!=''){
                 $html .='<a href="'.$this->item->joomla.'" target="_blank"><i class="fa fa-joomla"></i></a>';
             }
             if($this->item->wordpress!=''){
                 $html .='<a href="'.$this->item->wordpress.'" target="_blank"><i class="fa fa-wordpress"></i></a>';
             }
             if($this->item->behance!=''){
                 $html .='<a href="'.$this->item->behance.'" target="_blank"><i class="fa fa-behance"></i></a>';
             }
             if($this->item->dribbble!=''){
                 $html .='<a href="'.$this->item->dribbble.'" target="_blank"><i class="fa fa-dribbble"></i></a>';
             }
          $html .='</div>';
        }
    $html .='</div>';
$html .='</div>';
endif;

echo $html;
