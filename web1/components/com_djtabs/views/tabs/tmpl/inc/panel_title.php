<?php

if($tab->type==2 || $tab->type==6){ // article or k2 item
	$con->show_create_date = $con->params->get('show_create_date','1');
	$con->show_title = $con->params->get('show_title','1');
	$con->link_titles = $con->params->get('link_titles','1');
}

?>

<?php if($con->state == 1): ?>

	<?php          
		$intro_title = strip_tags($con->title);
		$intro_title_limit = $tab->params->get('title_char_limit','0');
		$intro_title_limit = is_numeric($intro_title_limit) ? $intro_title_limit : '0';
		if ($intro_title_limit!='0' && $intro_title_limit < strlen($intro_title)){
			$intro_title = mb_substr($intro_title,0,$intro_title_limit).'...';
		}
	?>							
	
	<?php if($con->show_create_date && $tab->params->get('date_position','1')=='1'){ ?>
		<span class="djtabs-panel-date">
		<?php 
		//echo date("y.m.d", strtotime($con->created));
			//$date = new JDate($con->created);
			//echo $date->format($tab->params->get('date_panel_format','y.m.d'));
			echo JHtml::_('date', $con->created, $tab->params->get('date_panel_format','y.m.d'));
		?>
		</span>
	<?php } ?>

	<?php if($con->show_title){ ?>
	<span title="<?php echo strip_tags($con->title); ?>" class="djtabs-panel-title">
		<?php if($con->link_titles): ?>
		<a style="color:inherit" href="<?php echo $con->link; ?>">
		<?php endif; ?>
			<?php if($params->get('truncate_titles','1')=='0'): ?>
				<span class="djtabs-title-in">
			<?php endif; ?>
					<?php echo $intro_title; ?>
			<?php if($params->get('truncate_titles','1')=='0'): ?>
				</span>
			<?php endif; ?>
		<?php if($con->link_titles): ?>
		</a>
		<?php endif; ?>
	</span>
	<?php } ?>
	
<?php else: ?>
	<span title="?" class="djtabs-panel-title" style="color:grey;">?</span>
<?php endif; ?>