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
  $html .='<div class="item-img">'; 
    $html .='<figure>';
        if($link_detail==1){
            $html .='<a href="'.$detail_link.'"'.$popup.'><img class="img-responsive '.$gray_scale.'" src="'. JURI::root().$image_storiage_path.'/m_'.$this->item->profile_image.'" alt="'.$this->item->name.'"/></a>';
        }else{
            $html .='<img class="img-responsive '.$gray_scale.'" src="'.JURI::root().$image_storiage_path.'/m_'.$this->item->profile_image.'" alt="'.$this->item->name.'"/>';
        } 
    $html .='</figure>';
  $html .='</div>';
    $html .='<div class="tlp-overlay">';
    $html .='<div class="item-info">';
      $html .='<div class="item-info-top">';
       if($name_field==1){
            if($link_detail==1){
                $html .='<h3><a href="'. $detail_link.'"'.$popup.'><span class="tlp-name">'. $this->item->name.'</span></a></h3>';
            }else{
                $html .='<h3><span class="tlp-name">'.$this->item->name.'</span></h3>';
            }
        }
        $html .='<div class="line"></div>';
      $html .='</div>';
      $html .='<div class="item-info-bottom">';
      if($position_field==1){
            if($link_detail==1){
                $html .='<div class="tlp-position"><a href="'.$detail_link.'" '.$popup.'>'. $this->item->position .'</a></div>';
            }else{
                $html .='<div class="tlp-position">'. $this->item->position.'</div>';
            }
         }
      $html .='</div>';
    $html .='</div>';
    $html .='</div>';
$html .='</div>';
endif;

echo $html;

