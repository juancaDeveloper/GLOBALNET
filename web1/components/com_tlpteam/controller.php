<?php
/**
 * @version     2.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class TlpteamController extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) {
        require_once JPATH_COMPONENT . '/helpers/tlpteam.php';

        $view = JFactory::getApplication()->input->getCmd('view', 'teams');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }

    public function getSpecialSelectedData(){
	    $jInput = JFactory::getApplication()->input;
	    $data = $jInput->post->getArray(array());
	    $memberId = !empty($data['memberId']) ? (int)$data['memberId'] : null;
	    $toggleId = ! empty( $data['toggleId'] ) ? (int)$data['toggleId'] : null;
	    $html     = $toggle_image_src = null;
	    $tlpteam_params             = JComponentHelper::getParams( 'com_tlpteam' );
	    $image_storiage_path        = $tlpteam_params->get( 'image_path', 'images/tlpteam' );
	    $path = JURI::root() . $image_storiage_path . '/m_';
        $g_email_field              = $tlpteam_params->get( 'email_field_detail', '1' );
        $g_phoneno_field            = $tlpteam_params->get( 'phoneno_field_detail', '1' );
        $g_mobileno_field           = $tlpteam_params->get( 'mobileno_field_detail', '1' );
        $g_website_field            = $tlpteam_params->get( 'website_field_detail', '1' );
        $g_location_field           = $tlpteam_params->get( 'location_field_detail', '1' );
        $g_socialicon_field         = $tlpteam_params->get( 'socialicon_field_detail', '1' );
        $g_skill_field              = $tlpteam_params->get( 'skill_field_detail', '1' );
        $link_detail                = $tlpteam_params->get( 'link_detail', '1' );
        $link_type                  = $tlpteam_params->get( 'link_type', '2' );

	    $error = true;
	    if($toggleId){
		    $db = JFactory::getDbo();
		    $query = $db->getQuery(true);
		    $query->select('a.*')->from('#__tlpteam_team a');
		    $query->where("a.id = $toggleId");
		    $db->setQuery($query);
		    $toggleMember = $db->loadObject();
		    $toggle_image_src = $path.$toggleMember->profile_image;
	    }
	    if ( $memberId ) {
		    $db = JFactory::getDbo();
		    $query = $db->getQuery(true);
		    $query->select('a.*')->from('#__tlpteam_team a');
		    $query->where("a.id = $memberId");
		    $db->setQuery($query);
		    $member = $db->loadObject();

		    if(!empty($member)){
			    $error = false;
			    $name = !empty($member->name) ? $member->name : null;
		    	$designation = !empty($member->position) ? $member->position : null;
		    	$short_bio = !empty($member->short_bio) ? $member->short_bio : null;

                $email = !empty($member->email) ? $member->email : null;
                $website = !empty($member->personal_website) ? $member->personal_website : null;
                $phoneno = !empty($member->phoneno) ? $member->phoneno : null;
                $mobileno = !empty($member->mobileno) ? $member->mobileno : null;
                $location = !empty($member->location) ? $member->location : null;

                $facebook = !empty($member->facebook) ? $member->facebook : null;
                $twitter = !empty($member->twitter) ? $member->twitter : null;
                $google_plus = !empty($member->google_plus) ? $member->google_plus : null;
                $linkedin = !empty($member->linkedin) ? $member->linkedin : null;
                $youtube = !empty($member->youtube) ? $member->youtube : null;
                $vimeo = !empty($member->vimeo) ? $member->vimeo : null;
                $instagram = !empty($member->instagram) ? $member->instagram : null;
                $xing = !empty($member->xing) ? $member->xing : null;
                $joomla = !empty($member->joomla) ? $member->joomla : null;
                $wordpress = !empty($member->wordpress) ? $member->wordpress : null;
                $behance = !empty($member->behance) ? $member->behance : null;
                $dribbble = !empty($member->dribbble) ? $member->dribbble : null;



                if($link_type==2){ 
                    $popup=' data-id="'.$member->id.'" class="tlp-single-item-popup"';
                  }else{
                    $popup= null;
                }
                $detail_link = JRoute::_('index.php?option=com_tlpteam&view=team&id='.$member->id.':'.$member->alias.'&Itemid=99');


			    $html   .= "<div class='special-selected-top-wrap'>
                            <div class='tlp-col-xs-6 img allmargin0 '>
                                <img  src='{$path}{$member->profile_image}' alt='{$name}' >
                            </div>";
			    $html   .= "<div class='tlp-col-xs-6 ttp-label allmargin0'>";
                         if($link_detail==1){
                                $html .='<h3><a href="'. $detail_link.'"'.$popup.'><span class="tlp-name">'. $name.'</span></a></h3>';
                            }else{
                                $html .='<h3><span class="tlp-name">'.$name.'</span></h3>';
                            }       

                            $html   .= "<div class='tlp-position'>{$designation}</div>";
                if($g_socialicon_field==1){ 
                    $html .='<div class="social-icons">';  
                        if($facebook){ 
                            $html .='<a href="'.$facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
                        }
                        if($twitter!=''){
                            $html .='<a href="'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
                        }
                        if($google_plus!=''){
                            $html .='<a href="'.$google_plus.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
                        }
                        if($linkedin!=''){
                            $html .='<a href="'.$linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
                        }
                        if($youtube!=''){
                            $html .='<a href="'.$youtube.'" target="_blank"><i class="fa fa-youtube"></i></a>';
                        }
                        if($vimeo!=''){
                            $html .='<a href="'.$vimeo.'" target="_blank"><i class="fa fa-vimeo"></i></a>';
                        }
                        if($instagram!=''){
                            $html .='<a href="'.$instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
                        }
                        if($xing!=''){
                            $html .='<a href="'.$xing.'" target="_blank"><i class="fa fa-xing"></i></a>';
                        }
                        if($joomla!=''){
                            $html .='<a href="'.$joomla.'" target="_blank"><i class="fa fa-joomla"></i></a>';
                        }
                        if($wordpress!=''){
                            $html .='<a href="'.$wordpress.'" target="_blank"><i class="fa fa-wordpress"></i></a>';
                        }
                        if($behance!=''){
                            $html .='<a href="'.$behance.'" target="_blank"><i class="fa fa-behance"></i></a>';
                        }
                        if($dribbble!=''){
                            $html .='<a href="'.$dribbble.'" target="_blank"><i class="fa fa-dribbble"></i></a>';
                        }
                    $html .='</div>';
                    }            
                $html   .= "</div>";
                $html   .= "</div>";

			    $html   .= "<div class='allmargin0 tlp-col-sm-12 special-selected-short-bio'><p>".nl2br($short_bio)."</p></div>";
                if(($g_email_field==1)||($g_phoneno_field==1)||($g_mobileno_field==1)||($g_website_field==1)||($g_location_field==1)){
                        $html .='<div class="contact-info">
                            <ul>';
                            if(($g_email_field==1)&&($email)){
                                $html .='<li><i class="fa fa-envelope-o"></i><span><a href="mailto:'.$email.'">'.$email.'</a></span> </li>';
                            }
                            if(($g_website_field==1)&&($website)){
                                $html .='<li><i class="fa fa-globe"></i><span><a href="'.$website.'" target="_blank">'.$website.'</a></span> </li>';
                            }
                            if(($g_phoneno_field==1)&&($phoneno)){
                                $html .='<li><i class="fa fa-phone"></i><span>'.$phoneno.'</span></li>';
                            }
                            if(($g_mobileno_field==1)&&($mobileno)){
                                $html .='<li><i class="fa fa-mobile"></i><span>'.$mobileno.'</span></li>';
                            }
                            if(($g_location_field==1)&&($location)){
                                $html .='<li><i class="fa fa-map-marker"></i><span>'.$location.'</span></li>';
                            }
                            $html .='</ul>';
                        $html .='</div>';
                    }
		    }

		    echo new JResponseJson(array(
		    	'data' => $html,
		    	'toggle_image_src' => $toggle_image_src,
		    	'error' => $error
		    ));
	    }
    }


    public function singleItem()
    {
        $jinput = JFactory::getApplication()->input;
        $tlpteam_params = JComponentHelper::getParams('com_tlpteam');
        $image_storiage_path            = $tlpteam_params->get('image_path');
        $link_detail                    = $tlpteam_params->get('link_detail');
        $link_type                      = $tlpteam_params->get('link_type');
        $g_name_field                   = $tlpteam_params->get('name_field_detail');
        $g_position_field               = $tlpteam_params->get('position_field_detail');
        $g_email_field                  = $tlpteam_params->get('email_field_detail', '1' );
        $g_phoneno_field                = $tlpteam_params->get('phoneno_field_detail', '1' );
        $g_mobileno_field               = $tlpteam_params->get('mobileno_field_detail', '1' );
        $g_website_field                = $tlpteam_params->get('website_field_detail', '1' );
        $g_location_field               = $tlpteam_params->get('location_field_detail', '1' );
        $g_socialicon_field             = $tlpteam_params->get('socialicon_field_detail', '1' );
        $g_skill_field                  = $tlpteam_params->get( 'skill_field_detail', '1' );
        $bootstrap_version              = $tlpteam_params->get('bootstrap_version');
        $image_grid                     = $tlpteam_params->get('image_grid');
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
        $data = $jinput->post->getArray(array());
        $id = (int)$data['id'];
        
        $html = null;
        if($id) {

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query
                    ->select('a.*,s1.title as skill1,s2.title as skill2,s3.title as skill3,s4.title as skill4,s5.title as skill5')
                    ->from('#__tlpteam_team a');
            
                $query->where("a.id = $id");
      
            $query->join('LEFT', '#__tlpteam_skills AS s1 ON s1.id = a.skill1');
            $query->join('LEFT', '#__tlpteam_skills AS s2 ON s2.id = a.skill2');
            $query->join('LEFT', '#__tlpteam_skills AS s3 ON s3.id = a.skill3');
            $query->join('LEFT', '#__tlpteam_skills AS s4 ON s4.id = a.skill4');
            $query->join('LEFT', '#__tlpteam_skills AS s5 ON s5.id = a.skill5');
            $db->setQuery($query);
            $item = $db->loadObject();
            $imgURL = JURI::root().$tlpteam_params->get('image_path').'/l_'.$item->profile_image;
            if ($item){
                $html .='<div class="tlp-team container">';
                    $html .='<div class="tlp-row tlp-team-detail">';
                        $html .='<div class="'.$image_area.'">';        
                            $html .= '<br><img class="tlp-img-responsive" src="'.$imgURL.'" alt="'.$item->name.'"/>';

                            $html .='<div class="social-icons">';  
                                if($item->facebook!=''){ $html .='<a href="'.$item->facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';}
                                if($item->twitter!=''){$html .='<a href="'.$item->twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>'; }
                                if($item->google_plus!=''){ $html .='<a href="'.$item->google_plus.'" target="_blank"><i class="fa fa-google-plus"></i></a>'; }
                                if($item->linkedin!=''){ $html .='<a href="'.$item->linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>'; }
                                if($item->youtube!=''){ $html .='<a href="'.$item->youtube.'" target="_blank"><i class="fa fa-youtube"></i></a>'; }
                                if($item->vimeo!=''){ $html .='<a href="'.$item->vimeo.'" target="_blank"><i class="fa fa-vimeo"></i></a>'; }
                                if($item->instagram!=''){ $html .='<a href="'.$item->instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';}
                                if($item->xing!=''){ $html .='<a href="'.$item->xing.'" target="_blank"><i class="fa fa-xing"></i></a>'; }
                                if($item->joomla!=''){ $html .='<a href="'.$item->joomla.'" target="_blank"><i class="fa fa-joomla"></i></a>'; }
                                if($item->wordpress!=''){ $html .='<a href="'.$item->wordpress.'" target="_blank"><i class="fa fa-wordpress"></i></a>'; }
                                if($item->behance!=''){ $html .='<a href="'.$item->behance.'" target="_blank"><i class="fa fa-behance"></i></a>';}
                                if($item->dribbble!=''){ $html .='<a href="'.$item->dribbble.'" target="_blank"><i class="fa fa-dribbble"></i></a>';}
                            $html .='</div>';
                            
                        $html .='</div>';
                        $html .='<div class="'.$content_area.' content-area">';
                        if(($g_name_field==1)||($g_position_field==1)){
                            $html .='<article>';
                            $html .='<div class="tlp-content" >';
                                $html .='<h3><span class="tlp-name">'.$item->name.'</span></h3>';
                                if($g_position_field==1){
                                    $html .='<div class="tlp-position">'.$item->position.'</div>';
                                }
                            $html .='</div>';
                           }
                            $html .='<div class="short-bio">';
                               $html .='<p>'.$item->detail_bio.'</p>';
                           $html .='</div>';

                            if(($g_email_field==1)||($g_phoneno_field==1)||($g_mobileno_field==1)||($g_website_field==1)||($g_location_field==1)){
                            $html .='<div class="contact-info">';  
                                $html .='<ul>';
                                if(($g_email_field==1)&&($item->email!='')){
                                    $html .='<li><i class="fa fa-envelope-o"></i><span><a href="mailto:'.$item->email.'">'.$item->email.'</a></span> </li>';
                                    }
                                if(($g_website_field==1)&&($item->personal_website!='')){
                                    $html .='<li><i class="fa fa-globe"></i><span><a href="'. $item->personal_website.'" target="_blank">'.$item->personal_website.'</a></span> </li>';
                                   }
                                if(($g_phoneno_field==1)&&($item->phoneno!='')){
                                    $html .='<li><i class="fa fa-phone"></i><span>'.$item->phoneno.'</span></li>';
                                    }
                                if(($g_mobileno_field==1)&&($item->mobileno!='')){
                                    $html .='<li><i class="fa fa-mobile"></i><span>'.$item->mobileno.'</span></li>';
                                    }
                                if(($g_location_field==1)&&($item->location!='')){
                                    $html .='<li><i class="fa fa-map-marker"></i><span>'. $item->location.'</span> </li>';
                                    }     
                                $html .='</ul>';
                            $html .='</div>';
                            }

                            if($g_skill_field==1){ 
                                $html .='<div class="tlp-team-skill">';
                                    if(($g_skill_field==1)&&(($item->skill1_no)>0)){
                                        $html .='<div class="skill_name">'.$item->skill1.'</div>';
                                        $html .='<div class="skill-prog"><div class="fill" data-progress-animation='. $item->skill1_no.'></div></div>';
                                     }
                                    if(($g_skill_field==1)&&(($item->skill2_no)>0)){   
                                        $html .='<div class="skill_name">'.$item->skill2.'</div>';
                                        $html .='<div class="skill-prog"><div class="fill" data-progress-animation='.$item->skill2_no.'></div></div>';
                                    }
                                    if(($g_skill_field==1)&&(($item->skill3_no)>0)){
                                        $html .='<div class="skill_name">'.$item->skill3.'</div>';
                                        $html .='<div class="skill-prog"><div class="fill" data-progress-animation='.$item->skill3_no.'></div></div>';
                                    }
                                    if(($g_skill_field==1)&&(($item->skill4_no)>0)){
                                        $html .='<div class="skill_name">'.$item->skill4.'</div>';
                                        $html .='<div class="skill-prog"><div class="fill" data-progress-animation='. $item->skill4_no.'></div></div>';
                                     }
                                    if(($g_skill_field==1)&&(($item->skill5_no)>0)){   
                                        $html .='<div class="skill_name">'. $item->skill5.'</div>';
                                        $html .='<div class="skill-prog"><div class="fill" data-progress-animation="'.$item->skill5_no.'"></div></div>';
                                    }
                                $html .='</div>';
                            }

                        

                            $html .='</article>';
                       
                        $html .='</div>';
                    $html .='</div>';

                $html .='</div>';
                 }

                // echo "<pre>";
                // print_r($item);
                // echo "</pre>";
                $html .= "<script>progressBarSingle();</script>";
            } else {
                $html .= JText::_('COM_TLPPORTFOLIO_ITEM_NOT_LOADED');
            }
            echo $html;
    }

}
