<?php
/**
 * @version     1.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

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
$image_storiage_path = $tlpteam_params->get('image_path');
$primary_color=$tlpteam_params->get('primary_color');
$name_font_size=$tlpteam_params->get('name_font_size');
$name_font_color=$tlpteam_params->get('name_font_color');
$name_text_align=$tlpteam_params->get('name_text_align');
$position_font_size=$tlpteam_params->get('position_font_size');
$position_font_color=$tlpteam_params->get('position_font_color');
$position_text_align=$tlpteam_params->get('position_text_align');
$short_bio_text_align=$tlpteam_params->get('short_bio_text_align');
$social_icon_background=$tlpteam_params->get('social_icon_background');
$social_icon_size=$tlpteam_params->get('social_icon_size');
$link_detail=$tlpteam_params->get('link_detail');
$link_type=$tlpteam_params->get('link_type');
$layout=$tlpteam_params->get('layout');


$display_no=$tlpteam_params->get('display_no');
$grid=(12/$display_no);
$bootstrap_version=$tlpteam_params->get('bootstrap_version');
if($bootstrap_version==3){
	$bss="col-md-".$grid." col-sm-6";
}else{
	$bss="span-".$grid;
}

?>



<style type="text/css">
.single-team-area .tlp-content h3{text-align:<?php echo $name_text_align;?>; }
.tlp-team1.tlp-content{background-color:<?php echo $primary_color;?>};
.tlp-name,a{font-size:<?php echo $name_font_size;?>px; color:<?php echo $name_font_color;?>!important;}
.tlp-team1 a span,.tlp-team2 a span,.tlp-team3 a span,.tlp-team4 a span,.tlp-team5 a span{color:<?php echo $name_font_color;?>!important;}		
.tlp-team1 a, .tlp-team2 a, .tlp-team3 a, .tlp-team4 a, .tlp-team5 a{color:<?php echo $primary_color;?>!important;}
.tlp-team3 .social-icons ul li{  border: 1px solid <?php echo $primary_color;?>; }
.tlp-position{font-size:<?php echo $position_font_size;?>px; color:<?php echo $position_font_color;?>; text-align:<?php echo $position_text_align;?>}
.social-icons a{font-size:<?php echo $social_icon_size;?>px; color:<?php echo $social_icon_background;?>!important;}
.short-bio{text-align:<?php echo $short_bio_text_align;?> !important;}

</style>
<form action="<?php echo JRoute::_('index.php?option=com_tlpteam&view=teams'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="tlp-team<?php echo $layout;?>">
	<table class="table table-striped">

	<?php
		switch ($layout){

			case "1": ?>
			<!-- Layout 1   -->
			<?php
		    $j=0;$k=1;
		    $count = count($this->items);
			foreach ($this->items as $i => $item) : 
				$j++;
			if($k== 1){
			echo '<div class="row-fluid margin-bottom">'; } ?>
			<div class="<?php echo $bss;?>">
			<div class="single-team-area"> 
			   <div class="single-team"> 
			     <?php if (!empty($item->profile_image)):?>
			     	<figure>
			     		<img class="tlp-img-responsive" src="<?php echo JURI::root().$image_storiage_path.'/m_'.$item->profile_image; ?> " alt="<?php echo $item->name; ?>"/>		     		
			     	</figure>	
		         <?php  endif; ?>
		         
		        <figcaption>
				 <div class="overlay"> 
				    <div class="overlay-element"> 
					<a href="#"><i class="fa fa-plus"></i></a>
					  <div class="social-icons">  
					    <ul>
					    	<?php if($item->facebook!=''){?><li ><a href="<?php echo $item->facebook;?>" target="_new"><i class="fa fa-facebook"></i> </a></li><?php }?>
			                <?php if($item->twitter!=''){?><li ><a href="<?php echo $item->twitter;?>" target="_new"><i class="fa fa-twitter"></i></a></li><?php }?>
			                <?php if($item->google_plus!=''){?><li ><a href="<?php echo $item->googleplus;?>" target="_new"><i class="fa fa-google-plus"></i> </a></li><?php }?>
			                <?php if($item->linkedin!=''){?><li ><a href="<?php echo $item->linkedin;?>" target="_new"><i class="fa fa-linkedin"></i></a></li><?php }?>
			                <?php if($item->youtube!=''){?><li ><a href="<?php echo $item->youtube;?>" target="_new"><i class="fa fa-youtube"></i> </a></li><?php }?>
			                <?php if($item->vimeo!=''){?><li ><a href="<?php echo $item->vimeo;?>" target="_new"><i class="fa fa-vimeo"></i></a></li><?php }?>
			                <?php if($item->instagram!=''){?><li ><a href="<?php echo $item->instagram;?>" target="_new"><i class="fa fa-instagram"></i> </a></li><?php }?>
					    </ul>
					  </div>
					</div>
				 </div>
				</figcaption>
			   </div>
			   <?php if(($tlpteam_params->get('name_field')==1)||($tlpteam_params->get('position_field')==1)||($tlpteam_params->get('shortbio_field')==1)){?>
			   <article>
				   <div class="tlp-content" >
				   	<?php if($tlpteam_params->get('name_field')==1){?>
			        	<h3><a href="<?php echo JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $item->id); ?>">
						<span class="tlp-name"><?php echo $this->escape($item->name); ?></span></a></h3>
					<?php }?>
					<?php if($tlpteam_params->get('position_field')==1){?>
			         	<span class="tlp-position"><?php echo $item->position; ?></span>
			        <?php }?>
				   </div>
				   <?php if($tlpteam_params->get('shortbio_field')==1){?>
				   <div class="short-bio">
					   <p><?php echo $item->short_bio; ?></p>
				   </div>
				   <?php }?>
			   </article>
			   <?php }?>
			</div>
			</div>
			<?php 		
		     if($k == $display_no || $count == $j){ 
		     	echo '</div>';
		     $k=0;
			 } 
			 $k++; endforeach; $j;?>
			<!-- End Layout 1 -->	
		
			<?php break; 
			case "2": ?>
			<!-- Layout 2   -->
			<?php
		    $j=0;$k=1;
		    $count = count($this->items);
			foreach ($this->items as $i => $item) : 
				$j++;
			if($k== 1){
			echo '<div class="row-fluid margin-bottom">'; } ?>
			<div class="<?php echo $bss;?>">
				<div class="col-md-5 ">
					<div class="tlp-img tlp-single-team">
                        <?php if (!empty($item->profile_image)):?>
					     	<figure <?php if($tlpteam_params->get('image_style')==2){?>class="tlp-round-picture" <?php }?>>
					     		<img class="tlp-img-responsive " src="<?php echo JURI::root().$image_storiage_path.'/m_'.$item->profile_image; ?> " alt="<?php echo $item->name; ?>"/>		     		
					     	</figure>	
				         <?php  endif; ?>
					</div> 
				</div>

				<div class="col-md-7 ">
					<?php if(($tlpteam_params->get('name_field')==1)||($tlpteam_params->get('position_field')==1)||($tlpteam_params->get('shortbio_field')==1)){?>
					   <article>
						   <div class="tlp-content" >
						   	<?php if($tlpteam_params->get('name_field')==1){?>
					        	<h3><a href="<?php echo JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $item->id); ?>">
								<span class="tlp-name"><?php echo $this->escape($item->name); ?></span></a></h3>
							<?php }?>
							<?php if($tlpteam_params->get('position_field')==1){?>
					         	<span class="tlp-position"><?php echo $item->position; ?></span>
					        <?php }?>
						   </div>
						   <?php if($tlpteam_params->get('shortbio_field')==1){?>
						   <div class="short-bio">
							   <p><?php echo $item->short_bio; ?></p>
						   </div>
						   <?php }?>
					   <?php }?>
					   	<div class="social-icons">  
						    <ul>
					    	<?php if($item->facebook!=''){?><li ><a href="<?php echo $item->facebook;?>" target="_new"><i class="fa fa-facebook"></i> </a></li><?php }?>
			                <?php if($item->twitter!=''){?><li ><a href="<?php echo $item->twitter;?>" target="_new"><i class="fa fa-twitter"></i></a></li><?php }?>
			                <?php if($item->google_plus!=''){?><li ><a href="<?php echo $item->googleplus;?>" target="_new"><i class="fa fa-google-plus"></i> </a></li><?php }?>
			                <?php if($item->linkedin!=''){?><li ><a href="<?php echo $item->linkedin;?>" target="_new"><i class="fa fa-linkedin"></i></a></li><?php }?>
			                <?php if($item->youtube!=''){?><li ><a href="<?php echo $item->youtube;?>" target="_new"><i class="fa fa-youtube"></i> </a></li><?php }?>
			                <?php if($item->vimeo!=''){?><li ><a href="<?php echo $item->vimeo;?>" target="_new"><i class="fa fa-vimeo"></i></a></li><?php }?>
			                <?php if($item->instagram!=''){?><li ><a href="<?php echo $item->instagram;?>" target="_new"><i class="fa fa-instagram"></i> </a></li><?php }?>
					    </ul>                             
                        </div>
				   </article>
				</div>
				</div>
				<?php 		
			     if($k == $display_no || $count == $j){ 
			     	echo '</div>';
			     $k=0;
				 } 
				 $k++; endforeach; $j;?>
			<!-- End Layout 2   -->
			<?php break; 

				case "3": ?>
					<!-- Layout 3  -->
					<?php
				    $j=0;$k=1;
				    $count = count($this->items);
					foreach ($this->items as $i => $item) : 
						$j++;
					if($k== 1){
					echo '<div class="row-fluid margin-bottom">'; } ?>
					<div class="<?php echo $bss;?>">
					<div class="single-team-area"> 
					     <?php if (!empty($item->profile_image)):?>
					     	<figure <?php if($tlpteam_params->get('image_style')==2){?>class="tlp-round-picture" <?php }?>>
					     		<img class="tlp-img-responsive " src="<?php echo JURI::root().$image_storiage_path.'/m_'.$item->profile_image; ?> " alt="<?php echo $item->name; ?>"/>		     		
					     	</figure>	
				         <?php  endif; ?>

					   <?php if(($tlpteam_params->get('name_field')==1)||($tlpteam_params->get('position_field')==1)||($tlpteam_params->get('shortbio_field')==1)){?>
					   <article>
						   <div class="tlp-content" >
						   	<?php if($tlpteam_params->get('name_field')==1){?>
					        	<h3><a href="<?php echo JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $item->id); ?>">
								<span class="tlp-name"><?php echo $this->escape($item->name); ?></span></a></h3>
							<?php }?>
							<?php if($tlpteam_params->get('position_field')==1){?>
					         	<div class="tlp-position"><?php echo $item->position; ?></div>
					        <?php }?>
						   </div>
						   <?php if($tlpteam_params->get('shortbio_field')==1){?>
						   <div class="short-bio">
							   <p><?php echo $item->short_bio; ?></p>
						   </div>
						   <?php }?>
						<?php }?>
							<?php if(($tlpteam_params->get('email_field')==1)||($tlpteam_params->get('phoneno_field')==1)||($tlpteam_params->get('website_field')==1)||($tlpteam_params->get('location_field')==1)){?>
							<div class="contact-info">  
                                <ul>
                                	<?php if(($tlpteam_params->get('email_field')==1)&&($item->email!='')){?>
                                	<li><i class="fa fa-envelope-o"></i> <span><a href="mailto:<?php echo $item->email; ?>"><?php echo $item->email; ?></a></span> </li>
                                	<?php }?>
                                	<?php if(($tlpteam_params->get('website_field')==1)&&($item->personal_website!='')){?>
                                	<li><i class="fa fa-globe"></i> <span><a href="<?php echo $item->personal_website;?>" target="_New"><?php echo $item->personal_website; ?></a></span> </li>
                                	<?php }?>
                                	<?php if(($tlpteam_params->get('phoneno_field')==1)&&($item->phoneno!='')){?>
                                	<li><i class="fa fa-phone"></i> <span><a href="tel:<?php echo $item->phoneno; ?>"><?php echo $item->phoneno; ?></a></span></li>
                                	<?php }?>
                                	<?php if(($tlpteam_params->get('location_field')==1)&&($item->location!='')){?>
                                	<li><i class="fa fa-map-marker"></i> <span><?php echo $item->location; ?></span> </li>
                                	<?php }?>     	
                                </ul>
						      </div>
						 	<?php }?>
						    <div class="social-icons">  
							    <ul>
							    	<?php if($item->facebook!=''){?><li ><a href="<?php echo $item->facebook;?>" target="_new"><i class="fa fa-facebook"></i> </a></li><?php }?>
					                <?php if($item->twitter!=''){?><li ><a href="<?php echo $item->twitter;?>" target="_new"><i class="fa fa-twitter"></i></a></li><?php }?>
					                <?php if($item->google_plus!=''){?><li ><a href="<?php echo $item->googleplus;?>" target="_new"><i class="fa fa-google-plus"></i> </a></li><?php }?>
					                <?php if($item->linkedin!=''){?><li ><a href="<?php echo $item->linkedin;?>" target="_new"><i class="fa fa-linkedin"></i></a></li><?php }?>
					                <?php if($item->youtube!=''){?><li ><a href="<?php echo $item->youtube;?>" target="_new"><i class="fa fa-youtube"></i> </a></li><?php }?>
					                <?php if($item->vimeo!=''){?><li ><a href="<?php echo $item->vimeo;?>" target="_new"><i class="fa fa-vimeo"></i></a></li><?php }?>
					                <?php if($item->instagram!=''){?><li ><a href="<?php echo $item->instagram;?>" target="_new"><i class="fa fa-instagram"></i> </a></li><?php }?>
							    </ul>
							</div>
					   </article>
					</div>
					</div>
					<?php 		
					    if($k == $display_no || $count == $j){ 
					     	echo '</div>';
					     $k=0;
					 } 
					 $k++; endforeach; $j;?>
			<!-- End Layout 3   -->
			<?php break; 

				case "4": ?>
					<!-- Layout 4  overlay with name, position and social icon-->
					<?php
				    $j=0;$k=1;
				    $count = count($this->items);
					foreach ($this->items as $i => $item) : 
						$j++;
					if($k== 1){
					echo '<div class="row-fluid margin-bottom">'; } ?>
					<div class="<?php echo $bss;?>">
					<div class="single-team-area"> 
					   <div class="single-team <?php if($tlpteam_params->get('image_style')==2){?>tlp-round-picture <?php }?>"> 
					      <?php if (!empty($item->profile_image)):?>
					     	<figure>
					     		<img class="tlp-img-responsive " src="<?php echo JURI::root().$image_storiage_path.'/m_'.$item->profile_image; ?> " alt="<?php echo $item->name; ?>"/>		     		
					     	</figure>	
				         <?php  endif; ?>			         
				        <figcaption>
						 <div class="overlay"> 
						    <div class="overlay-element"> 
						    <?php if(($tlpteam_params->get('name_field')==1)||($tlpteam_params->get('position_field')==1)||($tlpteam_params->get('shortbio_field')==1)){?>
							<div class="tlp-content" >
						   	<?php if($tlpteam_params->get('name_field')==1){?>
					        	<h3><a href="<?php echo JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $item->id); ?>">
								<span class="tlp-name"><?php echo $this->escape($item->name); ?></span></a></h3>
							<?php }?>
							<?php if($tlpteam_params->get('position_field')==1){?>
					         	<span class="tlp-position"><?php echo $item->position; ?></span>
					        <?php }?>
					        <?php if($tlpteam_params->get('shortbio_field')==1){?>
							   <div class="short-bio">
								   <p><?php echo $item->short_bio; ?></p>
							   </div>
						   <?php }?>

						   </div>
						   
						<?php }?>
							  <div class="social-icons">  
							    <ul>
							    	<?php if($item->facebook!=''){?><li ><a href="<?php echo $item->facebook;?>" target="_new"><i class="fa fa-facebook"></i> </a></li><?php }?>
					                <?php if($item->twitter!=''){?><li ><a href="<?php echo $item->twitter;?>" target="_new"><i class="fa fa-twitter"></i></a></li><?php }?>
					                <?php if($item->google_plus!=''){?><li ><a href="<?php echo $item->googleplus;?>" target="_new"><i class="fa fa-google-plus"></i> </a></li><?php }?>
					                <?php if($item->linkedin!=''){?><li ><a href="<?php echo $item->linkedin;?>" target="_new"><i class="fa fa-linkedin"></i></a></li><?php }?>
					                <?php if($item->youtube!=''){?><li ><a href="<?php echo $item->youtube;?>" target="_new"><i class="fa fa-youtube"></i> </a></li><?php }?>
					                <?php if($item->vimeo!=''){?><li ><a href="<?php echo $item->vimeo;?>" target="_new"><i class="fa fa-vimeo"></i></a></li><?php }?>
					                <?php if($item->instagram!=''){?><li ><a href="<?php echo $item->instagram;?>" target="_new"><i class="fa fa-instagram"></i> </a></li><?php }?>
							    </ul>
							  </div>
							</div>
						 </div>
						</figcaption>
					   </div>			   
				</div>
				</div>
				<?php 		
			     if($k == $display_no || $count == $j){ 
			     	echo '</div>';
			     $k=0;
			 } 
			 $k++; endforeach; $j;?>
			<!-- End Layout 4   -->
			<?php break; ?>

			<?php break; 

				case "5": ?>
					<!-- Layout 5 Table with name, position, short bio and social icon-->
					<table class="table table-striped">
					<?php
				    $j=0;$k=1;
				    $count = count($this->items);
					foreach ($this->items as $i => $item) : 
						$j++;
					if($k== 1){
					echo '<div class="row-fluid margin-bottom">'; } ?>
					<div class="<?php echo $bss;?>">
					<div class="single-team-area"> 
					<div class="single-team <?php if($tlpteam_params->get('image_style')==2){?>tlp-round-picture <?php }?>">
					<tr>
						<td width="70">
							<?php if (!empty($item->profile_image)):?>
					     	<figure>
					     		<img class="tlp-img-responsive " src="<?php echo JURI::root().$image_storiage_path.'/s_'.$item->profile_image; ?> " alt="<?php echo $item->name; ?>" width="60"/>		     		
					     	</figure>	
				         <?php  endif; ?>	
						</td>
						<td valign="middle">
							<?php if($tlpteam_params->get('name_field')==1){?>
				        		<h3><a href="<?php echo JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $item->id); ?>">
								<span class="tlp-name"><?php echo $this->escape($item->name); ?></span></a></h3>
							<?php }?>
						</td>
						<td valign="middle">
							<?php if($tlpteam_params->get('position_field')==1){?>
					         	<span class="tlp-position"><?php echo $item->position; ?></span>
					        <?php }?>
						</td>
						<td valign="middle">
							<i class="fa fa-envelope-o"></i> <span><a href="mailto:<?php echo $item->email; ?>"><?php echo $item->email; ?></a></span> 
						</td>
						<td valign="middle">
							<i class="fa fa-phone"></i> <span><a href="tel:<?php echo $item->phoneno; ?>"><?php echo $item->phoneno; ?></a></span>
						</td>
					</tr>
					</div>    	   
				</div>
				</div>
				<?php 		
			     if($k == $display_no || $count == $j){ 
			     	echo '</div>';
			     $k=0;
			 } 
			 $k++; endforeach; $j;?>
			 </table>
			<!-- End Layout 5   -->
			<?php break; 

				case "6": ?>
				<div class="isotop-container">
					<!-- Layout 6 overlay with name, position, short bio, contact info and social icon-->
					<div class="button-group filter-button-group">
					<button data-filter="*">show all</button>
					<?php $category=TlpteamFrontendHelper::getCategoryName();
					foreach ($category as $key => $value) {
						echo '<button data-filter=".'.strtolower($value->title).'">'.$value->title.'</button>';
					}
					?>
					</div>
					<div class="grid">

					<?php $allmembers=TlpteamFrontendHelper::getAllMembers();
				 
					foreach ($allmembers as $key => $item) : 
						
						?>

					<div class="element-item <?php echo strtolower($item->title);?>"> 
					      <?php if (!empty($item->profile_image)):?>
					     	<img class="tlp-img-responsive " src="<?php echo JURI::root().$image_storiage_path.'/m_'.$item->profile_image; ?> " alt="<?php echo $item->name; ?>"/>		     		
					     
				         <?php  endif; ?>			         
				   		   
					</div>
				<?php 		
			     endforeach;?>
			     </div>
			  </div>

			<!-- End Layout 5   -->
			<?php break; ?>
			
			<?php default:?>
			<!-- Layout 1   -->
			<?php
		    $j=0;$k=1;
		    $count = count($this->items);
			foreach ($this->items as $i => $item) : 
				$j++;
			if($k== 1){
			echo '<div class="row-fluid margin-bottom">'; } ?>
			<div class="<?php echo $bss;?>">
			<div class="single-team-area"> 
			   <div class="single-team"> 
			     <?php if (!empty($item->profile_image)):?>
			     	<figure>
			     		<img class="tlp-img-responsive" src="<?php echo JURI::root().$image_storiage_path.'/m_'.$item->profile_image; ?> " alt="<?php echo $item->name; ?>"/>		     		
			     	</figure>	
		         <?php  endif; ?>
		         
		        <figcaption>
				 <div class="overlay"> 
				    <div class="overlay-element"> 
					<a href="#"><i class="fa fa-plus"></i></a>
					  <div class="social-icons">  
					    <ul>
					    	<?php if($item->facebook!=''){?><li ><a href="<?php echo $item->facebook;?>" target="_new"><i class="fa fa-facebook"></i> </a></li><?php }?>
			                <?php if($item->twitter!=''){?><li ><a href="<?php echo $item->twitter;?>" target="_new"><i class="fa fa-twitter"></i></a></li><?php }?>
			                <?php if($item->google_plus!=''){?><li ><a href="<?php echo $item->googleplus;?>" target="_new"><i class="fa fa-google-plus"></i> </a></li><?php }?>
			                <?php if($item->linkedin!=''){?><li ><a href="<?php echo $item->linkedin;?>" target="_new"><i class="fa fa-linkedin"></i></a></li><?php }?>
			                <?php if($item->youtube!=''){?><li ><a href="<?php echo $item->youtube;?>" target="_new"><i class="fa fa-youtube"></i> </a></li><?php }?>
			                <?php if($item->vimeo!=''){?><li ><a href="<?php echo $item->vimeo;?>" target="_new"><i class="fa fa-vimeo"></i></a></li><?php }?>
			                <?php if($item->instagram!=''){?><li ><a href="<?php echo $item->instagram;?>" target="_new"><i class="fa fa-instagram"></i> </a></li><?php }?>
					    </ul>
					  </div>
					</div>
				 </div>
				</figcaption>
			   </div>
			   <article>
				   <div class="tlp-content">
			        	<h3><a href="<?php echo JRoute::_('index.php?option=com_tlpteam&view=team&id='.(int) $item->id); ?>">
						<span class="tlp-name"><?php echo $this->escape($item->name); ?></span></a></h3>
			         	<span class="tlp-position"><?php echo $item->position; ?></span>
				   </div>
				   <div class="short-bio">
					   <p><?php echo $item->short_bio; ?></p>
				   </div>
			   </article>
			</div>
			</div>
			<?php 		
		     if($k == $display_no || $count == $j){ 
		     	echo '</div>';
		     $k=0;
			 } 
			 $k++; endforeach; $j;?>
			<!-- End Layout 1 -->		
			<?php
				break;
		}
		?>

    </div>

	<div class="row-fluid">
     <?php echo $this->pagination->getListFooter(); ?>
	</div>



	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js"></script>
	<script>

	(function($){
		var $tlpiso = $('.grid').isotope({
		  // options
		  itemSelector: '.element-item',
		  layoutMode: 'fitRows'
		});

		 $('.filter-button-group').on( 'click', 'button', function() {
		   var filterValue = $(this).attr('data-filter');
		   $tlpiso.isotope({ filter: filterValue });
		 });
	})(jQuery);


	</script>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>


