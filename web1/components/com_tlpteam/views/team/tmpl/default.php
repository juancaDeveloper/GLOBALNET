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
$app = JFactory::getApplication();
$tlpteam_params = JComponentHelper::getParams('com_tlpteam');
$image_storiage_path            = $tlpteam_params->get('image_path','images/tlpteam');
$link_detail                    = $tlpteam_params->get('link_detail','1');
$link_type                      = $tlpteam_params->get('link_type','2');
$name_field                     = $tlpteam_params->get('name_field_detail','1');
$primary_color                  = $tlpteam_params->get('g_primary_color');
$position_field                 = $tlpteam_params->get('position_field_detail','1');
$email_field                    = $tlpteam_params->get('email_field_detail','1');
$phoneno_field                  = $tlpteam_params->get('phoneno_field_detail','1');
$mobileno_field                 = $tlpteam_params->get('mobileno_field','1');
$website_field                  = $tlpteam_params->get('website_field_detail','1');
$location_field                 = $tlpteam_params->get('location_field_detail','1');
$skill_field                    = $tlpteam_params->get('skill_field_detail','1');
$socialicon_field               = $tlpteam_params->get('socialicon_field_detail','1');
$bootstrap_version              = $tlpteam_params->get('bootstrap_version','1');
$image_grid                     = $tlpteam_params->get('image_grid','4');
$social_icon_background         = $tlpteam_params->get('g_social_icon_background');
$social_icon_color              = $tlpteam_params->get('g_social_icon_color');
$social_icon_size               = $tlpteam_params->get('g_social_icon_size');
$content_grid                   = 12-$image_grid;

if($bootstrap_version==3){
		$image_area="col-md-".$image_grid." col-lg-".$image_grid." col-sm-6";
		$content_area="col-md-".$content_grid." col-lg-".$content_grid." col-sm-6";
		
	}else{
		$image_area="tlp-col-md-".$image_grid." tlp-col-lg-".$image_grid." tlp-col-sm-6";
        $content_area="tlp-col-md-".$content_grid." tlp-col-lg-".$content_grid." tlp-col-sm-6";
	}
$document = JFactory::getDocument();

$style  = '.tlp-team .skill-prog .fill { background: '.$primary_color.';}';
$style .= '.tlp-team .contact-info .fa { color:'. $primary_color.'; }';
$style .= '.tlp-tooltip + .tooltip > .tooltip-inner { background-color: '.$primary_color.';}';
$style .= '.tooltip.top .tooltip-arrow { border-top-color:'. $primary_color.';}';
$style .= '.tlp-team .social-icons a { background: '.$social_icon_background.'; color:'.$social_icon_color.'; 
font-size:'.$social_icon_size.'px; }';
if($social_icon_background==''){
$style .= '.tlp-team .social-icons a:hover .fa-facebook,.tlp-team .social-icons a:hover .fa-twitter, .tlp-team .social-icons a:hover .fa-linkedin, .tlp-team .social-icons a:hover .fa-google-plus, .tlp-team .social-icons a:hover .fa-youtube, .tlp-team .social-icons a:hover .fa-vimeo, .tlp-team .social-icons a:hover .fa-instagram 
,.tlp-team .social-icons a:hover .fa-xing , .tlp-team .social-icons a:hover .fa-joomla , .tlp-team .social-icons a:hover .fa-wordpress , .tlp-team .social-icons a:hover .fa-behance , .tlp-team .social-icons a:hover .fa-dribbble  { background: none; color: '. $social_icon_color. '; opacity: .8; }';

}
$style .= '.tlp-team h3{ padding-top: 0px; margin-top: 0px; }';

$document->addStyleDeclaration( $style );

if ($this->item) : ?>
<div class="tlp-team">
    <div class="tlp-row tlp-team-detail">
    	<div class="<?php echo $image_area;?>">
    	 <?php if (!empty($this->item->profile_image)):?>
    	     	<figure>
    	     		<img class="img-responsive " src="<?php echo JURI::root().$image_storiage_path.'/l_'.$this->item->profile_image; ?> " alt="<?php echo $this->item->name; ?>"/>		     		
    	     	</figure>	
             <?php  endif; ?>
            <?php if($socialicon_field==1){ ?>
                <div class="social-icons">  
                    <?php if($this->item->facebook!=''){?><a href="<?php echo $this->item->facebook;?>" target="_blank"><i class="fa fa-facebook"></i></a><?php }?>
                    <?php if($this->item->twitter!=''){?><a href="<?php echo $this->item->twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a><?php }?>
                    <?php if($this->item->google_plus!=''){?><a href="<?php echo $this->item->google_plus;?>" target="_blank"><i class="fa fa-google-plus"></i></a><?php }?>
                    <?php if($this->item->linkedin!=''){?><a href="<?php echo $this->item->linkedin;?>" target="_blank"><i class="fa fa-linkedin"></i></a><?php }?>
                    <?php if($this->item->youtube!=''){?><a href="<?php echo $this->item->youtube;?>" target="_blank"><i class="fa fa-youtube"></i></a><?php }?>
                    <?php if($this->item->vimeo!=''){?><a href="<?php echo $this->item->vimeo;?>" target="_blank"><i class="fa fa-vimeo"></i></a><?php }?>
                    <?php if($this->item->instagram!=''){?><a href="<?php echo $this->item->instagram;?>" target="_blank"><i class="fa fa-instagram"></i></a><?php }?>
                    <?php if($this->item->xing!=''){?><a href="<?php echo $this->item->xing;?>" target="_blank"><i class="fa fa-xing"></i></a><?php }?>
                    <?php if($this->item->joomla!=''){?><a href="<?php echo $this->item->joomla;?>" target="_blank"><i class="fa fa-joomla"></i></a><?php }?>
                    <?php if($this->item->wordpress!=''){?><a href="<?php echo $this->item->wordpress;?>" target="_blank"><i class="fa fa-wordpress"></i></a><?php }?>
                    <?php if($this->item->behance!=''){?><a href="<?php echo $this->item->behance;?>" target="_blank"><i class="fa fa-behance"></i></a><?php }?>
                    <?php if($this->item->dribbble!=''){?><a href="<?php echo $this->item->dribbble;?>" target="_blank"><i class="fa fa-dribbble"></i></a><?php }?>
              </div>
            <?php }?>
    	</div>

    	<div class="<?php echo $content_area;?>">
    	<?php if(($name_field==1)||($position_field==1)||($shortbio_field==1)){?>
        <article>
    	   <div class="tlp-content" >
                <h3><span class="tlp-name"><?php echo $this->item->name; ?></span></h3>
    		<?php if($position_field==1){?>
             	<span class="tlp-position"><?php echo $this->item->position; ?></span>
            <?php }?>
    	   </div>
    	   <?php //if($shortbio_field==1){?>
    	   <div class="short-bio">
    		   <p><?php echo $this->item->detail_bio; ?></p>
    	   </div>
    	   <?php //}?>
       <?php }?>
       	<?php if(($email_field==1)||($phoneno_field==1)||($website_field==1)||($location_field==1)){?>
    		<div class="contact-info">  
                <ul>
                <?php if(($email_field==1)&&($this->item->email!='')){?>
                	<li><i class="fa fa-envelope-o"></i><span><a href="mailto:<?php echo $this->item->email; ?>"><?php echo $this->item->email; ?></a></span> </li>
                <?php }?>
                <?php if(($website_field==1)&&($this->item->personal_website!='')){?>
                	<li><i class="fa fa-globe"></i><span><a href="<?php echo $this->item->personal_website;?>" target="_blank"><?php echo $this->item->personal_website; ?></a></span> </li>
                <?php }?>
                <?php if(($phoneno_field==1)&&($this->item->phoneno!='')){?>
                    <li><i class="fa fa-phone"></i><span><a href="tel:<?php echo $this->item->phoneno; ?>"><?php echo $this->item->phoneno; ?></a></span></li>
                <?php }?>
                <?php if(($mobileno_field==1)&&($this->item->mobileno!='')){?>
                	<li><i class="fa fa-mobile"></i><span><a href="tel:<?php echo $this->item->mobileno; ?>"><?php echo $this->item->mobileno; ?></a></span></li>
                <?php }?>
                <?php if(($location_field==1)&&($this->item->location!='')){?>
                	<li><i class="fa fa-map-marker"></i><span><?php echo $this->item->location; ?></span> </li>
                <?php }?>     	
                </ul>
    	      </div>
    	<?php }?>
        <?php if($skill_field==1){ ?>
            <div class="tlp-team-skill">
                <?php if(($skill_field==1)&&(($this->item->skill1_no)>0)){?>
                    <div class="skill_name"><?php echo $this->item->skill1?></div>
                    <div class='skill-prog'><div class='fill' data-progress-animation='<?php echo $this->item->skill1_no?>'></div></div>
                <?php }
                    if(($skill_field==1)&&(($this->item->skill2_no)>0)){?>    
                    <div class="skill_name"><?php echo $this->item->skill2?></div>
                    <div class='skill-prog'><div class='fill' data-progress-animation='<?php echo $this->item->skill2_no?>'></div></div>
                <?php }
                    if(($skill_field==1)&&(($this->item->skill3_no)>0)){?>
                    <div class="skill_name"><?php echo $this->item->skill3?></div>
                    <div class='skill-prog'><div class='fill' data-progress-animation='<?php echo $this->item->skill3_no?>'></div></div>
                <?php }
                    if(($skill_field==1)&&(($this->item->skill4_no)>0)){?>
                    <div class="skill_name"><?php echo $this->item->skill4?></div>
                    <div class='skill-prog'><div class='fill' data-progress-animation='<?php echo $this->item->skill4_no?>'></div></div>
                <?php }
                    if(($skill_field==1)&&(($this->item->skill5_no)>0)){?>    
                    <div class="skill_name"><?php echo $this->item->skill5?></div>
                    <div class='skill-prog'><div class='fill' data-progress-animation='<?php echo $this->item->skill5_no?>'></div></div>
        	    <?php }?>
            </div>
            <?php }?>
            
        </article>
    	</div>
    </div>
</div>    
    <?php
else:
    echo JText::_('COM_TLPTEAM_ITEM_NOT_LOADED');
endif;
?>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/imagesloaded.pkgd.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/isotope.pkgd.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::root();?>components/com_tlpteam/assets/js/tlp-team.js" type="text/javascript"></script>
