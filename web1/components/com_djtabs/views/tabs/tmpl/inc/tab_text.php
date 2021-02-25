<?php $tab_custom_html = $tab->params->get('tab_custom_html',''); ?>
<?php if ($tab_custom_html !=''){ ?>
	<div class="djtab-custom-html">
	<?php echo $tab_custom_html; ?>
	</div>
<?php } ?>
<span class="djtab-text" title="<?php echo $tab->name; ?>">
	<?php $tab_icon = $tab->params->get('tab_icon',''); ?>
	<?php if($tab_icon!=''){ ?>
		<i class="<?php echo $tab_icon; ?> "></i>&nbsp;
	<?php  } ?>
	<?php echo $tab->name; ?>
</span>