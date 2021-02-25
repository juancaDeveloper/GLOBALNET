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

  if($display_no==2){
        $image_area="tlp-col-md-6 tlp-col-lg-6 tlp-col-sm-6 paddingl0";
        $content_area="tlp-col-md-6 tlp-col-lg-6 tlp-col-sm-6 paddingr0";
    }else{
        $image_area="tlp-col-md-6 tlp-col-lg-6 tlp-col-sm-12 paddingl0";
        $content_area="tlp-col-md-6 tlp-col-lg-6 tlp-col-sm-12 paddingr0";
    }   

$html ='';
if($this->l8 == 0){
$html .='<div class="tlp-row2">';
    $html .='<div class="'.$image_area.' tlp-img-block ">';
    	$html .='<div class="tlp-img tlp-single-team single-team-area">';
          if (!empty($this->item->profile_image)):  	     	
    	     		if($link_detail==1){
                  $html .='<a href="'.$detail_link.'"'.$popup.'><img class="img-responsive '.$gray_scale.'" src="'. JURI::root().$image_storiage_path.'/m_'.$this->item->profile_image.'" alt="'.$this->item->name.'"/></a>';
            }else{
                $html .='<img class="img-responsive '.$gray_scale.'" src="'.JURI::root().$image_storiage_path.'/m_'.$this->item->profile_image.'" alt="'.$this->item->name.'"/>';
            }		     		
    	   endif;
    	$html .='</div>'; 
    $html .='</div>';
    $html .='<div class="'.$content_area.' tlp-info-block tlp-right-arrow ">';
    if(($name_field==1)||($position_field==1)||($shortbio_field==1)){
      $html .='<article>';
    	$html .='<div class="tlp-content" >';
          if($name_field==1){
                if($link_detail==1){
                    $html .='<h3><a href="'. $detail_link.'"'.$popup.'><span class="tlp-name">'. $this->item->name.'</span></a></h3>';
                }else{
                $html .='<h3><span class="tlp-name">'.$this->item->name.'</span></h3>';
                }
          }
    		if($position_field==1){
          if($link_detail==1){
                $html .='<div class="tlp-position"><a href="'.$detail_link.'" '.$popup.'>'. $this->item->position .'</a></div>';
              }else{
                $html .='<div class="tlp-position">'. $this->item->position.'</div>';
              }
             }
    	   $html .='</div>';
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
        }
        if(($email_field==1)||($phoneno_field==1)||($mobileno_field==1)||($website_field==1)||($location_field==1)){    		
          $html .='<div class="contact-info">
            <ul>';
            if(($email_field==1)&&($this->item->email!='')){
                $html .='<li><i class="fa fa-envelope-o"></i><span><a href="mailto:'.$this->item->email.'">'.$this->item->email.'</a></span> </li>';
            }
            if(($website_field==1)&&($this->item->personal_website!='')){
                $html .='<li><i class="fa fa-globe"></i><span><a href="'.$this->item->personal_website.'" target="_blank">'.$this->item->personal_website.'</a></span> </li>';
            }
            if(($phoneno_field==1)&&($this->item->phoneno!='')){
                $html .='<li><i class="fa fa-phone"></i><span>'.$this->item->phoneno.'</span></li>';
            }
            if(($mobileno_field==1)&&($this->item->mobileno!='')){
                $html .='<li><i class="fa fa-mobile"></i><span>'.$this->item->mobileno.'</span></li>';
            }
            if(($location_field==1)&&($this->item->location!='')){
                $html .='<li><i class="fa fa-map-marker"></i><span>'.$this->item->location.'</span></li>';
            }
            $html .='</ul>';
        $html .='</div>';
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
    $html .='</article>';
    $html .='</div>';
    $html .='</div>';
 }else if($this->l8 == 1){

    $html .='<div class="tlp-row2">';
    $html .='<div class="'.$content_area .' tlp-info-block tlp-left-arrow ">';
    if(($name_field==1)||($position_field==1)||($shortbio_field==1)){
        $html .='<article>';
            $html .='<div class="tlp-content" >';
              if($name_field==1){
                if($link_detail==1){
                    $html .='<h3><a href="'. $detail_link.'"'.$popup.'><span class="tlp-name">'. $this->item->name.'</span></a></h3>';
                }else{
                    $html .='<h3><span class="tlp-name">'.$this->item->name.'</span></h3>';
                }
          }
        if($position_field==1){
          if($link_detail==1){
                $html .='<div class="tlp-position"><a href="'.$detail_link.'" '.$popup.'>'. $this->item->position .'</a></div>';
              }else{
                $html .='<div class="tlp-position">'. $this->item->position.'</div>';
              }
             }
          $html .='</div>';
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
        }
        if(($email_field==1)||($phoneno_field==1)||($website_field==1)||($location_field==1)){
            $html .='<div class="contact-info">
            <ul>';
            if(($email_field==1)&&($this->item->email!='')){
                $html .='<li><i class="fa fa-envelope-o"></i><span><a href="mailto:'.$this->item->email.'">'.$this->item->email.'</a></span> </li>';
            }
            if(($website_field==1)&&($this->item->personal_website!='')){
                $html .='<li><i class="fa fa-globe"></i><span><a href="'.$this->item->personal_website.'" target="_blank">'.$this->item->personal_website.'</a></span> </li>';
            }
            if(($phoneno_field==1)&&($this->item->phoneno!='')){
                $html .='<li><i class="fa fa-phone"></i><span>'.$this->item->phoneno.'</span></li>';
            }
            if(($mobileno_field==1)&&($this->item->mobileno!='')){
                $html .='<li><i class="fa fa-mobile"></i><span>'.$this->item->mobileno.'</span></li>';
            }
            if(($location_field==1)&&($this->item->location!='')){
                $html .='<li><i class="fa fa-map-marker"></i><span>'.$this->item->location.'</span></li>';
            }
            $html .='</ul>';
        $html .='</div>';
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
    $html .='</article>';
    $html .='</div>';
    $html .='<div class="'.$image_area.' tlp-img-block ">';
        $html .='<div class="tlp-img tlp-single-team single-team-area">';
            if (!empty($this->item->profile_image)):            
                if($link_detail==1){
                   $html .='<a href="'.$detail_link.'"'.$popup.'><img class="img-responsive '.$gray_scale.'" src="'. JURI::root().$image_storiage_path.'/m_'.$this->item->profile_image.'" alt="'.$this->item->name.'"/></a>';
                }else{
                    $html .='<img class="img-responsive " src="'.JURI::root().$image_storiage_path.'/m_'.$this->item->profile_image.'" alt="'.$this->item->name.'"/>';
                }                
             endif;
        $html .='</div>'; 
    $html .='</div>';
$html .='</div>';
    
}
echo $html;
?>

<script>

    (function($){
        var maxH = 0;
        var l8imgH = $(".tlp-img-block").height();
        var l8infoH = $(".tlp-info-block").height();
        if(l8imgH > l8infoH){
            maxH = l8imgH;
        }else{
            maxH = l8infoH;
        }
        $(".tlp-img-block, .tlp-info-block").css('height', maxH + "px");
        
    })(jQuery);
</script>
