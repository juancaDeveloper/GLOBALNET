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

$fieldSets = $this->form->getFieldsets('params');

foreach ($fieldSets as $name => $fieldSet) :

	if($name=='k2_basic'){
		continue;
	}
	
	echo JHtml::_('sliders.panel',JText::_($fieldSet->label), $name.'-params');
	if (isset($fieldSet->description) && trim($fieldSet->description)) :
		echo '<p class="tip">'.$this->escape(JText::_($fieldSet->description)).'</p>';
	endif;
	?>
	<fieldset class="panelform" >
		<ul class="adminformlist">
			
			<?php if($name=='basic') : ?>
				<?php foreach ($this->form->getFieldset('k2_basic') as $field) : ?>
				<?php
					switch($field->id) {
						case 'jform_params_k2_item_id': $temp_class='djinvolved djk2item'; break;
						case 'jform_params_k2_category_id': $temp_class='djinvolved djk2category'; break;
					}
				 ?>
					<li class="<?php echo $temp_class; ?>">
						<?php echo $field->label; ?>
						<?php echo $field->input; ?>
					</li>
				<?php endforeach; ?>
			<?php endif;?>
			
			<?php foreach ($this->form->getFieldset($name) as $field) : ?>
			<?php 
						switch($field->id) {
						case 'jform_params_module_position': $temp_class='djinvolved djmodule'; break;
						case 'jform_params_article_id': $temp_class='djinvolved djarticle'; break;
						case 'jform_params_category_id': $temp_class='djinvolved djcategory'; break;
						case 'jform_params_article_limit': $temp_class='djinvolved djcategory'; break;
						case 'jform_params_video_link': $temp_class='djinvolved djvideo'; break;
						default: $temp_class='djother';
					} 
			
			 ?>
				<li class="<?php echo $temp_class; ?>">			
				<?php echo $field->label; ?>
					<?php if ($field->id=="jform_params_tab_custom_html") : ?>
						<div>
							<input name="tab_custom_html_chx" id="tab_custom_html_chx" value="your_value" type="checkbox">
							<div><?php echo $field->input; ?></div>
						</div>
					<?php else:?>
						<?php echo $field->input; ?>
					<?php endif;?>	
				</li>
			<?php endforeach; ?>
		</ul>
	</fieldset>
<?php endforeach; ?>

<script type="text/javascript">

	window.addEvent('domready', function(){
        
        var custom_html_area = $('jform_params_tab_custom_html');
        var chx = $('tab_custom_html_chx'); 

        if (custom_html_area.value.length==0)
        	custom_html_area.getParent().hide();
        else
        	chx.checked = true;
        
        chx.onclick = customHTMLToggle;
   
	});
	
	function customHTMLToggle(){
		
		var chx = $('tab_custom_html_chx');
		var custom_html_area = $('jform_params_tab_custom_html');
		
		if(chx.checked==true)
			custom_html_area.getParent().show();
		else
			custom_html_area.getParent().hide();
	}
	
</script>