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
JHtml::_('behavior.framework');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'group.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
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
				</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="details">
							<div class="control-group">
								<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
								<div class="controls">		                			
		                    		<?php echo $this->form->getInput('title'); ?>						
								</div>
							</div>
							<!-- <div class="control-group">
								<div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
								<div class="controls">		                			
		                    		<?php echo $this->form->getInput('alias'); ?>						
								</div>
							</div> -->
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