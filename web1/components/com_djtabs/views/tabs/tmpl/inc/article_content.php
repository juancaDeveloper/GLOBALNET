<?php

if($tab->type==2 || $tab->type==6){ // article or k2 item
	$con->show_author = $con->params->get('show_author','1');
	$con->show_category = $con->params->get('show_category','1');
	$con->link_category = $con->params->get('link_category','1');
	$con->show_create_date = $con->params->get('show_create_date','1');
	$con->show_readmore = $con->params->get('show_readmore');
}

?>

<?php if($con->state == 1): ?>

	<div class="djtabs-article-content">
		<!-- date (under the title) -->
		<?php if($con->show_create_date && $tab->params->get('date_position','1')=='2'){ ?>
			<span class="djtabs-date-in">
				<?php 
					//$date = new JDate($tab->content->created);
					//echo $date->format($tab->params->get('date_format','l, d F Y'));
					echo JHtml::_('date', $con->created, $tab->params->get('date_format','l, d F Y'));
				?>
			</span>
		<?php } ?>
		<!-- image -->
		<?php if($tab->params->get('image',0) && $con->image_url){ ?>
		
			<?php if($tab->params->get('image_link',0)): ?> 
				<a href="<?php echo $con->link; ?>">
			<?php endif; ?>
			<?php 
			    $img_pos = $tab->params->get('image_position',1);
			    if($img_pos==1){
			    	$img_class = "dj-img-left";
				}else if($img_pos==2){
			    	$img_class = "dj-img-right";
			    }else{
			    	$img_class = "dj-img-top";
			    }
				$img_w = $tab->params->get('image_width',0);
				$img_h = $tab->params->get('image_height',0);
			?>
			<img 
				class="djtabs-article-img <?php echo $img_class; ?>" 
				src="<?php echo $con->image_url;?>" 
				<?php if($img_w>0) echo 'width="'.$img_w.'"';?> 
				<?php if($img_h>0) echo 'height="'.$img_h.'"';?> 
				alt="<?php echo strip_tags($con->image_alt); ?>" 
				title="<?php echo strip_tags($con->image_caption); ?>" 
			/>
			<?php if($tab->params->get('image_link',0)): ?>
				</a>
			<?php endif; ?>
		
		<?php  } ?>
		<!-- description -->  
		<?php 
		if ($tab->params->get('HTML_in_description',0)){
			$intro_desc = $con->introtext;
		}else if ($tab->params->get('description_char_limit')==''){
			$intro_desc = strip_tags($con->introtext);
		}else{
			//$intro_desc = mb_substr(strip_tags($con->introtext),0,$tab->params->get('description_char_limit')).'...';
			$desc = strip_tags($con->introtext);
			$limit = $tab->params->get('description_char_limit');
			if($limit && $limit - strlen($desc) < 0) {
				$desc = substr($desc, 0, $limit);
			// don't cut in the middle of the word unless it's longer than 20 chars
			if($pos = strrpos($desc, ' ')) {
				$limit = ($limit - $pos > 20) ? $limit : $pos;
				$desc = substr($desc, 0, $limit);
			}
			// cut text and add dots
			if(preg_match('/[a-zA-Z0-9]$/', $desc)) $desc.='&hellip;';
				$desc = '<p>'.nl2br($desc).'</p>';
			}
			$intro_desc = $desc;
		}
		?>
		<?php if($tab->params->get('description','1') && $intro_desc){ ?>
			
			<?php if($tab->params->get('description_link','1')): ?>
				<a style="color:inherit" href="<?php echo $con->link; ?>">
			<?php endif; ?>
				<?php echo $intro_desc; ?>
			<?php if($tab->params->get('description_link','1')): ?>
				</a>
			<?php endif; ?>
			
			<?php if($con->show_readmore && $con->link) { ?>
			<span class="djtabs-readmore">
				<a href="<?php echo $con->link; ?>" >
					<?php echo ($tab->params->get('readmore_text',0) ? $tab->params->get('readmore_text') : JText::_('COM_DJTABS_READMORE')); ?>			
				</a>
			</span>
			<?php } ?>
		<?php } ?>
	</div>
	<?php if($con->show_author || $con->show_category){ ?>
		<div class="djtabs-article-footer">
		<?php if($con->show_author): ?>
			<div class="djtabs-article-author">
			<?php echo $con->author;?>	                    
			</div>
		<?php endif; ?>
		
		<?php if($con->show_category){ ?>
			<div class="djtabs-article-category">
			<?php if($con->link_category): ?>
			<a href="<?php echo $con->cat_link; ?>">
			<?php endif; ?>
			   <?php echo $con->category_title; ?>
			<?php if($con->link_category): ?>
			</a>
			<?php endif; ?>
			</div>
		<?php } ?>
		</div>
	<?php } ?>

<?php else: ?>
	<span style="color:grey;font-style:italic;"><?php echo JText::_('COM_DJTABS_ARTICLE_NO_LONGER_PUBLISHED'); ?></span>
<?php endif; ?>