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


<form action="index.php" method="post" name="adminForm">
	<?php if(!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php else: ?>
	<div id="j-main-container">
	<?php endif;?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span8 djcpanel well">
				<div class="row-fluid">
					<div class="icon">
						<a class="span3 cpanel-btn" href="index.php?option=com_djtabs&amp;view=items"> <img
							alt="<?php echo JText::_('COM_DJTABS_ITEMS'); ?>"
							src="components/com_djtabs/assets/icon-48-items.png" />
							<span><?php echo JText::_('COM_DJTABS_ITEMS'); ?> </span>
						</a>
					</div>
					<div class="icon">
						<a class="span3 cpanel-btn" href="index.php?option=com_djtabs&amp;task=item.add"> <img
							alt="<?php echo JText::_('COM_DJTABS_NEW_ITEM'); ?>"
							src="components/com_djtabs/assets/icon-48-item-add.png" />
							<span><?php echo JText::_('COM_DJTABS_NEW_ITEM'); ?> </span>
						</a>
					</div>
					<div class="icon">
						<a class="span3 cpanel-btn" href="index.php?option=com_djtabs&amp;view=groups"> <img
							alt="<?php echo JText::_('COM_DJTABS_GROUPS'); ?>"
							src="components/com_djtabs/assets/icon-48-category.png" />
							<span><?php echo JText::_('COM_DJTABS_GROUPS'); ?> </span>
						</a>
					</div>
					<div class="icon">
						<a class="span3 cpanel-btn" href="index.php?option=com_djtabs&amp;task=group.add"> <img
							alt="<?php echo JText::_('COM_DJTABS_NEW_GROUP'); ?>"
							src="components/com_djtabs/assets/icon-48-category-add.png" />
							<span><?php echo JText::_('COM_DJTABS_NEW_GROUP'); ?> </span>
						</a>
					</div>
				</div>
				<div class="row-fluid">
					<div class="icon">
						<a class="span3 cpanel-btn" href="index.php?option=com_djtabs&amp;view=themes"> <img
							alt="<?php echo JText::_('COM_DJTABS_THEMES'); ?>"
							src="components/com_djtabs/assets/icon-48-themes.png" />
							<span><?php echo JText::_('COM_DJTABS_THEMES'); ?> </span>
						</a>
					</div>
					<div class="icon">
						<a class="span3 cpanel-btn" href="index.php?option=com_djtabs&amp;task=theme.add"> <img
							alt="<?php echo JText::_('COM_DJTABS_NEW_THEME'); ?>"
							src="components/com_djtabs/assets/icon-48-theme-add.png" />
							<span><?php echo JText::_('COM_DJTABS_NEW_THEME'); ?> </span>
						</a>
					</div>
					<div class="icon">
						<a class="span3 cpanel-btn" href="http://dj-extensions.com/documentation"
							target="_blank"> <img
							alt="<?php echo JText::_('COM_DJTABS_DOCUMENTATION'); ?>"
							src="components/com_djtabs/assets/icon-48-help.png" />
							<span><?php echo JText::_('COM_DJTABS_DOCUMENTATION'); ?> </span>
						</a>
					</div>
					<div class="icon">
						<a class="span3 cpanel-btn" 
						href="index.php?option=com_config&view=component&component=com_djtabs&return=<?php echo base64_encode(JFactory::getURI()->toString()); ?>"> 
						<img alt="<?php echo JText::_('JOPTIONS'); ?>"
							src="components/com_djtabs/assets/icon-48-config.png" />
							<span><?php echo JText::_('JOPTIONS'); ?> </span>
						</a>
					</div>
				</div>
			</div>

			<div class="span4" style="float:right;margin: 0 auto;">
				<div class="cpanel">
						<?php echo DJLicense::getSubscription('Tabs'); ?>
				</div>
			</div>
		</div>
	</div>
	<div>
		<input type="hidden" name="option" value="com_djtabs" />
		<input type="hidden" name="c" value="cpanel" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="cpanel" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</div>
</div>
</form>

<?php echo DJTABSFOOTER; ?>