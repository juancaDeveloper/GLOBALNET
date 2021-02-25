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
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo empty($this->item->id) ? JText::_('COM_DJTABS_NEW') : JText::sprintf('COM_DJTABS_EDIT', $this->item->id); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('name'); ?>
                <?php echo $this->form->getInput('name'); ?></li>

                <li><?php echo $this->form->getLabel('group_id');?>
                <?php echo $this->form->getInput('group_id'); ?></li>                
                
                <li><?php echo $this->form->getLabel('type'); ?>
                <?php echo $this->form->getInput('type'); ?></li>
                
                <li><?php echo $this->form->getLabel('published'); ?>
				<?php echo $this->form->getInput('published'); ?></li>

                <li><?php echo $this->form->getLabel('id'); ?>
                <?php echo $this->form->getInput('id'); ?></li>
                
                <?php /*
                <li><?php echo $this->form->getLabel('article_id'); ?>
                <?php echo $this->form->getInput('article_id'); ?></li>
                */ ?>
            </ul>
          
        </fieldset>
    </div>

    <div class="width-40 fltrt">
        <?php echo  JHtml::_('sliders.start', 'item-slider'); ?>

            <?php echo $this->loadTemplate('legacy_params'); ?>
        
        <?php echo JHtml::_('sliders.end'); ?>      
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
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
		var art_per_row = $('jform_params_articles_per_row').getParent();
		var art_space = $('jform_params_articles_space').getParent();
		if (val=='3' || val=='5'){
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
		var art_order_dir = $('jform_params_articles_ordering_direction').getParent();
		if (val!='')
			art_order_dir.setStyle('display','inherit');
		else
			art_order_dir.setStyle('display','none');
			
	}
	
	function paramsHide(){
		
		var val = $('jformtype').value;
		
		var temps = $$('.djinvolved');
		for (i=0; i<=temps.length-1; i++)
		{
			temps[i].setStyle('display','none'); 
		}

		var temp = $('article-params').getParent();
		if (val=='3' || val=='4')
			temp.setStyle('display','none');
		else
			temp.setStyle('display','inherit'); 
				
		/* ver.1.0.6 update start */
		var temp = $('article_category-params').getParent();
		if (val!='1' && val!='5')
			temp.setStyle('display','none');
		else
			temp.setStyle('display','inherit');
		/* end */

		if (val=='1')
			var temps = $$('.djcategory');
		else if (val=='2')
			var temps = $$('.djarticle');
		else if (val=='3')
			var temps = $$('.djmodule');
		else if (val=='4')
			var temps = $$('.djvideo');
		else if (val=='5')
			var temps = $$('.djk2category');
		else if (val=='6')
			var temps = $$('.djk2item');

		for (i=0; i<=temps.length-1; i++)
		{
			temps[i].setStyle('display','inherit'); 
		}

		var cat_field = $('jformparamscategory_id'); //$('jform_params_category_id');
		var art_field = $('jform_params_article_id_id');
		var mod_field = $('jform_params_module_position');
		var vid_field = $('jform_params_video_link');
		var k2cat_field = $('jformparamsk2_category_id');
		var k2item_field = $('jform[params][k2_item_id]_id');
		
		if (val=='1'){
			cat_field.setProperty('required','required');
			cat_field.addClass('required');
			art_field.removeProperty('required');
			art_field.removeClass('required');
			mod_field.removeProperty('required');
			mod_field.removeClass('required');
			vid_field.removeProperty('required');
			vid_field.removeClass('required');
			k2cat_field.removeProperty('required');
			k2cat_field.removeClass('required');
			k2item_field.removeProperty('required');
			k2item_field.removeClass('required');
		}
		else if (val=='2'){
			cat_field.removeProperty('required');
			cat_field.removeClass('required');
			art_field.setProperty('required','required');
			art_field.addClass('required');
			mod_field.removeProperty('required');
			mod_field.removeClass('required');
			vid_field.removeProperty('required');
			vid_field.removeClass('required');
			k2cat_field.removeProperty('required');
			k2cat_field.removeClass('required');
			k2item_field.removeProperty('required');
			k2item_field.removeClass('required');
		}
		else if (val=='3'){
			cat_field.removeProperty('required');
			cat_field.removeClass('required');
			art_field.removeProperty('required');
			art_field.removeClass('required');
			mod_field.setProperty('required','required');
			mod_field.addClass('required');
			vid_field.removeProperty('required');
			vid_field.removeClass('required');
			k2cat_field.removeProperty('required');
			k2cat_field.removeClass('required');
			k2item_field.removeProperty('required');
			k2item_field.removeClass('required');
		}
		else if (val=='4'){
			cat_field.removeProperty('required');
			cat_field.removeClass('required');
			art_field.removeProperty('required');
			art_field.removeClass('required');
			mod_field.removeProperty('required');
			mod_field.removeClass('required');
			vid_field.setProperty('required','required');
			vid_field.addClass('required');
			k2cat_field.removeProperty('required');
			k2cat_field.removeClass('required');
			k2item_field.removeProperty('required');
			k2item_field.removeClass('required');
		}
		else if (val=='5'){
			cat_field.removeProperty('required');
			cat_field.removeClass('required');
			art_field.removeProperty('required');
			art_field.removeClass('required');
			mod_field.removeProperty('required');
			mod_field.removeClass('required');
			vid_field.removeProperty('required');
			vid_field.removeClass('required');
			k2cat_field.setProperty('required','required');
			k2cat_field.addClass('required');
			k2item_field.removeProperty('required');
			k2item_field.removeClass('required');
		}
		else if (val=='6'){
			cat_field.removeProperty('required');
			cat_field.removeClass('required');
			art_field.removeProperty('required');
			art_field.removeClass('required');
			mod_field.removeProperty('required');
			mod_field.removeClass('required');
			vid_field.removeProperty('required');
			vid_field.removeClass('required');
			k2cat_field.removeProperty('required');
			k2cat_field.removeClass('required');
			k2item_field.setProperty('required','required');
			k2item_field.addClass('required');
		}
		
	}
	
</script>