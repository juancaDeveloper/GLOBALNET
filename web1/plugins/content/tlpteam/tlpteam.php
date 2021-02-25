<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  tlpteam
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_tlpteam/router.php';
$document = JFactory::getDocument();

$document->addStyleSheet('components/com_tlpteam/assets/css/tlpteam.css');
/**
 * Content search plugin.
 *
 * @package     Joomla.Plugin
 * @subpackage  Search.content
 * @since       1.6
 */
class PlgContentTlpteam extends JPlugin {


    /**
     * Load the language file on instantiation.
     *
     * @var    boolean
     * @since  3.1
     */
    protected $autoloadLanguage = true;

    public $configs = null;

    function __construct( &$subject, $params ) {
        parent::__construct( $subject, $params );
    }

    /**
     * Plugin that retrieves contact information for contact
     *
     * @param   string   $context  The context of the content being passed to the plugin.
     * @param   mixed    &$row     An object with a "text" property
     * @param   mixed    $params   Additional parameters. See {@see PlgContentContent()}.
     * @param   integer  $page     Optional page number. Unused. Defaults to zero.
     *
     * @return  boolean True on success.
     */
    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {

        $allowed_contexts = array('com_content.category', 'com_content.article', 'com_content.featured', 'mod_custom.content');

        if (!in_array($context, $allowed_contexts))
        {
            return true;
        }

        // Simple performance check to determine whether bot should process further
        if (strpos($article->text, 'tlpteam') === false && strpos($article->text, 'tlpteam') === false)
        {
            return true;
        }

        $db     = JFactory::getDbo();
        $document = JFactory::getDocument();
        $app = JFactory::getApplication();
        $tlpteam_params = JComponentHelper::getParams('com_tlpteam');
        $image_storiage_path = $tlpteam_params->get('image_path');
        $name_field=$tlpteam_params->get('g_name_field');
        $position_field=$tlpteam_params->get('g_position_field');
        $shortbio_field=$tlpteam_params->get('g_shortbio_field');
        $socialicon_field=$tlpteam_params->get('g_socialicon_field');
        $email_field=$tlpteam_params->get('g_email_field');
        $phoneno_field=$tlpteam_params->get('g_phoneno_field');
        $website_field=$tlpteam_params->get('g_website_field');
        $location_field=$tlpteam_params->get('g_location_field');
        $bootstrap_version=$tlpteam_params->get('bootstrap_version');
        $display_no=$tlpteam_params->get('g_display_no');
        $grid=(12/$display_no);
        if($bootstrap_version==3){
            $bss="col-md-".$grid." col-lg-".$grid." col-sm-6";
        }else{
            $bss="tlp-col-md-".$grid." tlp-col-lg-".$grid." tlp-col-sm-6";
        }

        // Expression to search for(tlpteam id)
        $regex = '/{tlpteam\s*.*?}/i';
        // find all instances of mambot and put in $matches
       preg_match_all($regex, $article->text, $matches_v, PREG_SET_ORDER);

       // echo '<pre>';
       // print_r($matches_v);
       // echo '</pre>';
        //if we have mambot on txt replace them
        // No matches, skip this 
        foreach($matches_v as $match){
            $matches_v = $match[0];

                $matches_v = str_replace("{", "", $matches_v);
                $matches_v = str_replace("}", "", $matches_v);
                $search = explode(" ", $matches_v);

              //print_r($search);
                //Array ( [0] => team [1] => id=1 )
                foreach($search as $s_row => $s_value){
                    $final = explode("=",$s_value);
                    if(isset($final[1])){
                        $replace[$final[0]] = $final[1];
                    }
                }

                $whereQ = null;
                $memberIds = explode(',', $replace['id']);
                $i= 1; 
                foreach ($memberIds as $id) {
                    $or = ($i > 1 ? "OR " : null);
                    $whereQ .= " $or id = '$id' "; 
                    $i++;
                }
               
                $query = "SELECT * FROM #__tlpteam_team WHERE $whereQ";
                $db->setQuery($query);
                $items = $db->loadObjectList();
                //echo $items=count($item_total);
               // echo $limit = $this->params->def('search_limit', 50);
                 $output = null;
                 $output .='<div class="container-fluid plg-tlp-team tlp-team ">';
                 $output .='<div class="row layout3">';
               foreach($items as $item){
                $detail_link = JRoute::_('index.php?option=com_tlpteam&view=team&id='.$item->id);
                $output .='<div class="'.$bss.'">';
                $output .='<div class="single-team-area">'; 
                $output .='<figure>
                        <img class="img-responsive" src="'.JURI::root().$image_storiage_path.'/m_'.$item->profile_image.'" alt="'. $item->name.'"/> ';                 
                $output .= '</figure>'; 
                $output .='<h3><span class="tlp-name"><a href="'.$detail_link.'">'.$item->name.'</a></span></h3>';
                if($position_field==1){
                $output .='<div class="tlp-position">'. $item->position.'</div>';
                }
                if($shortbio_field==1){
                $output .='<div class="short-bio">
                   <p>'. $item->short_bio.'</p>';
                $output .='</div>';
            }
            if(($email_field==1)||($phoneno_field==1)||($website_field==1)||($location_field==1)){
                $output .='<div class="contact-info">  
                        <ul>';
                    if(($email_field==1)&&($item->email!='')){
                    $output .='<li><i class="fa fa-envelope-o"></i><span><a href="mailto:'.$item->email.'">'.$item->email.'</a></span> </li>';
                     }
                     if(($website_field==1)&&($item->personal_website!='')){
                    $output .='<li><i class="fa fa-globe"></i><span><a href="'.$item->personal_website.'" target="_blank">'.$item->personal_website.'</a></span> </li>';
                       }
                    if(($phoneno_field==1)&&($item->phoneno!='')){
                    $output .='<li><i class="fa fa-phone"></i><span><a href="tel:'.$item->phoneno.'">'.$item->phoneno.'</a></span></li>';
                     }
                    if(($location_field==1)&&($item->location!='')){
                    $output .='<li><i class="fa fa-map-marker"></i><span>'. $item->location.'</span> </li>';
                    
                    }     
                $output .='</ul>
                      </div>';
                }
            if($socialicon_field==1){ 
                $output .='<div class="social-icons">';
                        if($item->facebook!=''){
                        $output .='<a href="'.$item->facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
                        }
                        if($item->twitter!=''){
                        $output .='<a href="'.$item->twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
                        }
                        if($item->google_plus!=''){
                        $output .='<a href="'.$item->google_plus.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
                        }
                        if($item->linkedin!=''){
                        $output .='<a href="'.$item->linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
                        }
                        if($item->youtube!=''){
                        $output .='<a href="'. $item->youtube.'" target="_blank"><i class="fa fa-youtube"></i></a>';
                        }
                        if($item->vimeo!=''){
                        $output .='<a href="'. $item->vimeo.'" target="_blank"><i class="fa fa-vimeo"></i></a>';
                        }
                        if($item->instagram!=''){
                        $output .='<a href="'. $item->instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
                        }
                    $output .='</div>';
                }
                $output .='</div>';  
                $output .='</div>';
             }
                $output .='</div>';
                $output .='</div>';
                $matchesfull = '{'. $matches_v . '}';
               
                $article->text = preg_replace("|$matchesfull|", $output, $article->text, 1);
        }
        
    }
}