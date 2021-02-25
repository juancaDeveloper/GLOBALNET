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

defined('_JEXEC') or die('Restricted access'); ?>


<table class="adminform">
	<tr>
		<td width="55%" valign="top">
			<div class="cpanel-left">
				<div id="cpanel" class="cpanel">	
					<div style="float:left;">
						<div class="icon">
							<a href="index.php?option=com_djtabs&view=groups">
								<?php echo JHTML::_('image.administrator', 'icon-48-category.png', '/components/com_djtabs/assets/', null, null, JText::_('COM_DJTABS_GROUPS') ); ?>
								<span><?php echo JText::_('COM_DJTABS_GROUPS'); ?></span>
							</a>
						</div>
					</div>				
					<div style="float:left;">
						<div class="icon">
							<a href="index.php?option=com_djtabs&view=group&layout=edit">
								<?php echo JHTML::_('image.administrator', 'icon-48-category-add.png', '/components/com_djtabs/assets/', null, null, JText::_('COM_DJTABS_NEW_GROUP') ); ?>
								<span><?php echo JText::_('COM_DJTABS_NEW_GROUP'); ?></span>
							</a>
						</div>
					</div>		
								
					<div style="float:left;">
						<div class="icon">
							<a href="index.php?option=com_djtabs&view=items">
								<?php echo JHTML::_('image.administrator', 'icon-48-items.png', '/components/com_djtabs/assets/', null, null, JText::_('COM_DJTABS_ITEMS') ); ?>
								<span><?php echo JText::_('COM_DJTABS_ITEMS'); ?></span>
							</a>
						</div>
					</div>
					<div style="float:left;">
						<div class="icon">
							<a href="index.php?option=com_djtabs&view=item&layout=edit">
								<?php echo JHTML::_('image.administrator', 'icon-48-item-add.png', '/components/com_djtabs/assets/', null, null, JText::_('COM_DJTABS_NEW_ITEM') ); ?>
								<span><?php echo JText::_('COM_DJTABS_NEW_ITEM'); ?></span>
							</a>
						</div>
					</div>		
						
					<div style="clear:both"></div>
					
					<div style="float:left;">
						<div class="icon">
							<a href="index.php?option=com_djtabs&view=themes">
								<?php echo JHTML::_('image.administrator', 'icon-48-themes.png', '/components/com_djtabs/assets/', null, null, JText::_('COM_DJTABS_THEMES') ); ?>
								<span><?php echo JText::_('COM_DJTABS_THEMES'); ?></span>
							</a>
						</div>
					</div>
					<div style="float:left;">
						<div class="icon">
							<a href="index.php?option=com_djtabs&view=theme&layout=edit">
								<?php echo JHTML::_('image.administrator', 'icon-48-theme-add.png', '/components/com_djtabs/assets/', null, null, JText::_('COM_DJTABS_NEW_THEME') ); ?>
								<span><?php echo JText::_('COM_DJTABS_NEW_THEME'); ?></span>
							</a>
						</div>
					</div>
					
					<div style="float:left;">
						<div class="icon">
							<a href="http://dj-extensions.com/documentation" target="_blank">
								<?php echo JHTML::_('image.administrator', 'icon-48-help.png', '/components/com_djtabs/assets/', null, null, JText::_('COM_DJTABS_DOCUMENTATION') ); ?>
								<span><?php echo JText::_('COM_DJTABS_DOCUMENTATION'); ?></span>
							</a>
						</div>
					</div>		
			
					<div style="float:left;">
						<div class="icon">
							<a rel="{handler: 'iframe', size: {x: 900, y: 550}, onClose: function() {}}" href="index.php?option=com_config&amp;view=component&amp;component=com_djtabs&amp;path=&amp;tmpl=component" class="modal">
								<?php echo JHTML::_('image.administrator', 'icon-48-config.png', '/components/com_djtabs/assets/', null, null, JText::_('JOPTIONS') ); ?>
								<span><?php echo JText::_('JOPTIONS'); ?></span>
							</a>
						</div>
					</div>

				</div>
			</div>
			
			<div class="cpanel-right">
				<div class="cpanel">
					<div style="float:right;">
						<?php echo DJLicense::getSubscription('Tabs'); ?>
					</div>
					<div style="clear: both;" ></div>
				</div>
			</div>
			<div style="clear: both;" ></div>
		</div>
		</td>
	</tr>
</table>

<?php echo DJTABSFOOTER; ?>