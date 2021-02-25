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

JHtml::_('behavior.framework');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'theme.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			Joomla.submitform(task, document.getElementById('item-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('COM_DJTABS_VALIDATION_FORM_FAILED'));?>');
		}
	}	
	
</script>

<form action="<?php echo JRoute::_('index.php?option=com_djtabs&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="width-100 fltlft">
	<div class="width-60 fltlft">
		<fieldset class="adminform">

			<legend><?php echo empty($this->item->id) ? JText::_('COM_DJTABS_NEW') : JText::sprintf('COM_DJTABS_EDIT', $this->item->id); ?></legend>
						
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('title'); ?>
				<?php echo $this->form->getInput('title'); ?></li>
				
				<li><?php echo $this->form->getLabel('random'); ?>
				<?php echo $this->form->getInput('random'); ?></li>
				
				<li><?php echo $this->form->getLabel('published'); ?>
				<?php echo $this->form->getInput('published'); ?></li>

				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
			</ul>

		</fieldset>

	</div>
	<div class="width-40 fltlft">
		<?php echo  JHtml::_('sliders.start', 'item-slider'); ?>

            <?php echo $this->loadTemplate('params_legacy'); ?>
        
        <?php echo JHtml::_('sliders.end'); ?> 

		</div>	
	</div>
	<div>
	
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	
	
	
</form>
	<button type="button" style="margin:0;border:0;padding:0;position:absolute;left:47px;top:125px;" 
	title="¿" id="test" onclick="randomize();" >
	<canvas id="djcanvas" width="14" height="13" style="border:1px solid #d3d3d3;">
	</canvas></button>
<div class="clr"></div>
<?php echo DJTABSFOOTER; ?>
