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

if(version_compare(JVERSION, '3.0', '>=')) {
JHtml::_('formbehavior.chosen', 'select');
}
//JHtml::_('behavior.framework');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$function = JRequest::getVar('f_name');
?>

<style type="text/css">
	#adminForm .chzn-container .chzn-results {
		max-height: 100px;
	}
	body {
		background-color:#ACCF9B;
		/*background: #f4f4f4 url(components/com_djtabs/assets/icon-48-logo.png);*/
	}
	button {
		position: absolute;
		right:20px;
		bottom:20px;
	}
</style>

<form action="<?php echo JRoute::_('index.php?option=com_djtabs&view=modal&layout=default&tmpl=component&'.JSession::getFormToken().'=1'); ?>" method="post" name="adminForm" id="adminForm">
	
<div class="control-group">
	<div class="control-label"><?php echo $this->form->getLabel('group_id'); ?></div>
	<div class="controls">		                			
		<?php echo $this->form->getInput('group_id'); ?>						
	</div>
</div>
<div class="control-group">
	<div class="control-label"><?php echo $this->form->getLabel('theme'); ?></div>
	<div class="controls">		                			
		<?php echo $this->form->getInput('theme'); ?>						
	</div>
</div>
<div class="control-group">
	<div class="control-label"><?php echo $this->form->getLabel('layout'); ?></div>
	<div class="controls">		                			
		<?php echo $this->form->getInput('layout'); ?>						
	</div>
</div>
<?php //print_r($this->getValue('layout')); die();?>


<button class="button btn btn-lg btn-success pointer" onclick="if (window.parent) window.parent.<?php echo $function ?>(getFieldValue(1),getFieldValue(2),getFieldValue(3),getGroupName());">
<?php echo JText::_('COM_DJTABS_INSERT'); ?></button>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="f_name" value="<?php echo $function; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>


<script>


	function getFieldValue(_field){
		if (_field == 1) _field = 'group_id';
		else if (_field == 2) _field = 'theme';
		else if (_field == 3) _field = 'layout';
		var field_check = $('jform'+_field)
		if (!field_check) _field = '_'+_field;
			
		//var field_chzn = $$('#jform'+_field+'_chzn .chzn-drop .chzn-results .result-selected');
		//var splitted = field_chzn[0].id.split('_');
		var field = $('jform'+_field);
		
		//return field.options[splitted[splitted.length - 1]].value;
		return field.options[field.selectedIndex].value;

	}
	
	function getGroupName(){
		
		var _field = 'group_id';
		var field_check = $('jform'+_field)
		if (!field_check) _field = '_'+_field;

		//var field_chzn = $$('#jform'+_field+'_chzn .chzn-drop .chzn-results .result-selected');
		//var splitted = field_chzn[0].id.split('_');
		var field = $('jform'+_field)
		//return field.options[splitted[splitted.length - 1]].innerHTML;
		return field.options[field.selectedIndex].innerHTML;

	}

	
</script>