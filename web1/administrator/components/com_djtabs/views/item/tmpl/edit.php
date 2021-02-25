<?php
/**
 * @version 1.0
 * @package DJ-Tabs
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Piotr Dobrakowski - piotr.dobrakowski@design-joomla.eu
 *
 * DJ-Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Tabs. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// No direct access.
defined('_JEXEC') or die;

JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
        if (task == 'item.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
           
            Joomla.submitform(task, document.getElementById('item-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('COM_DJTABS_VALIDATION_FORM_FAILED'));?>');
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_djtabs&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="row-fluid">
		<div class="span12 form-horizontal">
			<fieldset class="adminform">	
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#details" data-toggle="tab"><?php echo empty($this->item->id) ? JText::_('COM_DJTABS_NEW') : JText::sprintf('COM_DJTABS_EDIT', $this->item->id); ?></a>
					</li>
					<li>
						<a href="#basic_params" data-toggle="tab"><?php echo JText::_('COM_DJTABS_TAB_OPTIONS');?></a>
					</li>
					<li id="article_params_tab">
						<a href="#article_params" data-toggle="tab"><?php echo JText::_('COM_DJTABS_ARTICLE_OPTIONS');?></a>
					</li>
					<li id="article_category_params_tab">
						<a href="#article_category_params" data-toggle="tab"><?php echo JText::_('COM_DJTABS_ARTICLE_CATEGORY_OPTIONS');?></a>
					</li>
				</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="details">
							<div class="control-group">
								<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
								<div class="controls">		                			
		                    		<?php echo $this->form->getInput('name'); ?>						
								</div>
							</div>
							<div class="control-group">
								<div class="control-label"><?php echo $this->form->getLabel('group_id'); ?></div>
								<div class="controls">		                			
		                    		<?php echo $this->form->getInput('group_id'); ?>						
								</div>
							</div>
							<div class="control-group">
								<div class="control-label"><?php echo $this->form->getLabel('type'); ?></div>
								<div class="controls">		                			
		                    		<?php echo $this->form->getInput('type'); ?>						
								</div>
							</div>
							
							<?php foreach ($this->form->getFieldset('basic') as $field) : ?>	
							<?php 
							$pre='jform_params_'; 
							$fields = array($pre.'tab_icon',$pre.'tab_custom_html',$pre.'myspacer5');
							if (in_array($field->id,$fields))
								continue;
							?>
								<div class="control-group">
									<div class="control-label"><?php echo $field->label; ?></div>
									<div class="controls">
									<?php echo $field->input; ?>
									</div>
								</div>
							<?php endforeach; ?>
							
							<?php foreach ($this->form->getFieldset('k2_basic') as $field) : ?>	
								<div class="control-group">
									<div class="control-label"><?php echo $field->label; ?></div>
									<div class="controls">
									<?php echo $field->input; ?>
									</div>
								</div>
							<?php endforeach; ?>
	
							<div class="control-group">
								<div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
								<div class="controls">		                			
		                    		<?php echo $this->form->getInput('published'); ?>						
								</div>
							</div>
							<div class="control-group">
								<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
								<div class="controls">		                			
		                    		<?php echo $this->form->getInput('id'); ?>						
								</div>
							</div>				
						</div>

							<?php  echo $this->loadTemplate('params'); ?>

					</div>
			</fieldset>
		</div>	
	</div>	
	<div class="clr"></div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<div class="clr"></div>

<?php echo DJTABSFOOTER; ?>

	<script type="text/javascript">

	window.addEvent('domready', function(){

		paramsHide();
        $('jformtype').onchange = paramsHide;
        
        categoryParamsHide();
        $('jform_params_articles_display').onchange = categoryParamsHide;
        
        orderingDirectionHide();
        $('jform_params_articles_ordering').onchange = orderingDirectionHide;
   
	});
	
	function categoryParamsHide(){
		
		var val = $('jform_params_articles_display').value;
		var art_per_row = $('jform_params_articles_per_row').getParent().getParent();
		var art_space = $('jform_params_articles_space').getParent().getParent();
		if (val=='3'){
			art_per_row.setStyle('display','inherit');
			art_space.setStyle('display','inherit');
		}
		else {
			art_per_row.setStyle('display','none');
			art_space.setStyle('display','none');
		}
		
	}
	
	function orderingDirectionHide(){
		
		var val = $('jform_params_articles_ordering').value;
		var art_order_dir = $('jform_params_articles_ordering_direction').getParent().getParent();
		if(val=='random'){
			art_order_dir.setStyle('display','none');
		}else{
			art_order_dir.setStyle('display','inherit');
		}
	}
	

	function paramsHide(){
		
		var val = $('jformtype').value;
		
		var art = $('article_params');
		var art_tab = $('article_params_tab');
		if(val=='3' || val=='4'){
			art.setStyle('visibility','hidden');
			art_tab.setStyle('display','none');
		}else{
			art.setStyle('visibility','visible');
			art_tab.setStyle('display','inherit');
		}	
		
		/* ver.1.0.6 start */
		var cat = $('article_category_params');
		var cat_tab = $('article_category_params_tab');
		if(val!='1' && val!='5'){ //artcile category or k2 article category
			cat.setStyle('visibility','hidden');
			cat_tab.setStyle('display','none');
		}else{
			cat.setStyle('visibility','visible');
			cat_tab.setStyle('display','inherit');
		}	
		/* ver.1.0.6 end */


		/* ver.1.2.0 start */
		manageField(val);
		/* ver.1.2.0 end */
		
		// ver.1.3
		var max_cat_field = $('jform_params_max_category_levels');
		if(val=='5'){
			max_cat_field.getParent().getParent().setStyle('display','none');
		}else{
			max_cat_field.getParent().getParent().setStyle('display','inherit');
		}

	}
	
	function manageField(val){
		
		var cat_field = $('jform_params_category_id');
		var art_field = $('jform_params_article_id_id');
		var mod_field = $('jform_params_module_position');
		var vid_field = $('jform_params_video_link');
		
		var k2_cat_field = $('jformparamsk2_category_id');
		if(!k2_cat_field) k2_cat_field = $('jform_params_k2_category_id')
		var k2_art_field = $('jform[params][k2_item_id]_name');
		var k2_art_field_container;
		if(!k2_art_field){
			k2_art_field = $('jform_params_k2_item_id');
			k2_art_field_container = k2_art_field.getParent().getParent();
		}else{
			k2_art_field_container = k2_art_field.getParent().getParent().getParent();
		}
		
		
		cat_field.removeProperty('required');
		cat_field.removeClass('required');
		art_field.removeProperty('required');
		art_field.removeClass('required');
		mod_field.removeProperty('required');
		mod_field.removeClass('required');
		vid_field.removeProperty('required','required');
		vid_field.removeClass('required');
		
		k2_cat_field.removeProperty('required');
		k2_cat_field.removeClass('required');
		k2_art_field.removeProperty('required');
		k2_art_field.removeClass('required');
		
		cat_field.getParent().getParent().setStyle('display','none');
		art_field.getParent().getParent().setStyle('display','none');
		mod_field.getParent().getParent().setStyle('display','none');
		vid_field.getParent().getParent().setStyle('display','none');
		
		k2_cat_field.getParent().getParent().setStyle('display','none');
		k2_art_field_container.setStyle('display','none');
		
		if (val=='1'){
			cat_field.setProperty('required','required');
			cat_field.addClass('required');
			cat_field.getParent().getParent().setStyle('display','inherit');
		}else if (val=='2'){
			art_field.setProperty('required','required');
			art_field.addClass('required');
			art_field.getParent().getParent().setStyle('display','inherit');
		}else if (val=='3'){
			mod_field.setProperty('required','required');
			mod_field.addClass('required');
			mod_field.getParent().getParent().setStyle('display','inherit');
		}else if (val=='4'){
			vid_field.setProperty('required','required');
			vid_field.addClass('required');
			vid_field.getParent().getParent().setStyle('display','inherit');
		}else if (val=='5'){
			k2_cat_field.setProperty('required','required');
			k2_cat_field.addClass('required');
			k2_cat_field.getParent().getParent().setStyle('display','inherit');
		}else if (val=='6'){
			k2_art_field.setProperty('required','required');
			k2_art_field.addClass('required');
			k2_art_field_container.setStyle('display','inherit');
		}
	}
	
</script>