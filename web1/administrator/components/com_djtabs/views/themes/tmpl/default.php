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
 
// no direct access
defined('_JEXEC') or die('Restricted access');

if(version_compare(JVERSION, '3.0', '>=')) JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.tooltip');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$saveOrder	= $listOrder == 'a.ordering';
?>
<form action="<?php echo JRoute::_('index.php?option=com_djtabs&view=themes');?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else: ?>
<div id="j-main-container">
<?php endif;?>
	<fieldset id="filter-bar" class="btn-toolbar">
		<div class="filter-search fltlft btn-group navbar-search pull-left">
			<label class="hidden filter-search-lbl help-inline" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input class="search-query input-small" type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" 
			title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo JText::_('COM_DJTABS_SEARCH_IN_TITLE'); ?>" />
		</div>
		<div class="filter-search fltlft navbar-search btn-group pull-left">
			<button class="btn" type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button class="btn" type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt pull-right">
			<select name="filter_published" class="inputbox input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', array(JHtml::_('select.option', '1', 'JPUBLISHED'),JHtml::_('select.option', '0', 'JUNPUBLISHED')), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>
		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
				</th>
				<?php $version = new JVersion;
				if (version_compare($version->getShortVersion(), '3.0.0', '>=')):?>
				<th width="1%"></th>
				<?php endif; ?>			
				<th>
					<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
				</th>
				<th width="12%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
					<?php if ($saveOrder) :?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'themes.saveorder'); ?>
					<?php endif; ?>
				</th>
				<th width="5%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php //$chx_i=0; ?>
		<?php foreach ($this->items as $i => $item) :
			//$chx_i++;
			$item->max_ordering = 0; //??
			$ordering	= ($listOrder == 'a.ordering');
			$canCheckin	= $user->authorise('core.manage','com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php if ($item->custom==1) 
							echo JHtml::_('grid.id', $i, $item->id); 
					else if ($item->custom==0) { 
					echo "<div style='display:none;'>".JHtml::_('grid.id', $i, $item->id)."</div>";  ?>
					<input onclick="Joomla.isChecked(this.checked);" type="checkbox" id="cb" name="cid[]" value="" disabled="disabled" title="Checkbox">
						<?php } ?>
				</td>
				<?php $version = new JVersion;
				if (version_compare($version->getShortVersion(), '3.0.0', '>=')):?>
					<td class="center">
					<?php 		    
					$styling = new JRegistry();
			 		$styling->loadString($item->params);
					$color=$styling->get('tb-ctv-bck-clr','#000')
					?>
					<?php if($item->custom): ?>
						<i style="color:<?php echo $color; ?>" class="icon-palette"></i>
					<?php else: ?>
						<i style="color:<?php echo $color; ?>" class="icon-picture"></i>
					<?php endif; ?>
					</td>
				<?php endif; ?>
				<td>
					<?php if ($item->custom==1){?>
					<span>
					<a href="<?php echo JRoute::_('index.php?option=com_djtabs&task=theme.edit&id='.$item->id);?>">
						<?php echo $this->escape($item->title); ?>
					</a>
					</span>
					<?php } else echo $this->escape($item->title); ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'themes.', true, 'cb'	); ?>
				</td>
				<td class="order">
						<?php if ($saveOrder) :?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, true, 'themes.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'themes.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php elseif ($listDirn == 'desc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, true, 'themes.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'themes.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php endif; ?>
						<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
					<?php else : ?>
						<?php echo $item->ordering; ?>
					<?php endif; ?>
				</td>
				<td class="center">
					<?php echo (int) $item->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>
</form>

<?php echo DJTABSFOOTER; ?>
