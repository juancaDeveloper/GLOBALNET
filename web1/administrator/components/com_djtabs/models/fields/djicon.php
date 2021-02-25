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

defined('_JEXEC') or die();
defined('JPATH_BASE') or die;

class JFormFieldDJIcon extends JFormField {
	
	protected $type = 'DJIcon';

	protected function getInput()
	{
			$name = $this->name;
			$selected = $this->value;
		 
			$icons =  array (
			'icon-joomla','icon-chevron-up','icon-chevron-right','icon-chevron-down','icon-chevron-left','icon-arrow-first','icon-arrow-last','icon-arrow-up-2','icon-arrow-right-2','icon-arrow-down-2','icon-arrow-left-2','icon-arrow-up-3','icon-arrow-right-3','icon-arrow-down-3','icon-arrow-left-3','icon-arrow-up-4','icon-arrow-right-4','icon-arrow-down-4','icon-arrow-left-4','icon-share','icon-undo','icon-forward-2','icon-backward-2','icon-unblock','icon-undo-2','icon-move','icon-expand','icon-contract','icon-expand-2','icon-contract-2','icon-play','icon-pause','icon-stop','icon-previous','icon-next','icon-first','icon-last','icon-play-circle','icon-pause-circle','icon-stop-circle','icon-backward-circle','icon-forward-circle','icon-loop','icon-shuffle','icon-search','icon-zoom-in','icon-zoom-out','icon-apply','icon-pencil-2','icon-brush','icon-save-new','icon-ban-circle','icon-delete','icon-publish','icon-new','icon-plus-circle','icon-minus','icon-minus-circle','icon-unpublish','icon-cancel-circle','icon-checkmark-2','icon-checkmark-circle','icon-info','icon-info-2','icon-question','icon-question-2','icon-notification','icon-notification-2','icon-pending','icon-warning-2','icon-checkbox-unchecked','icon-checkin','icon-checkbox-partial','icon-square','icon-radio-unchecked','icon-radio-checked','icon-circle','icon-signup','icon-grid','icon-grid-2','icon-menu','icon-list','icon-list-2','icon-menu-3','icon-folder-open','icon-folder-close','icon-folder-plus','icon-folder-minus','icon-folder-3','icon-folder-plus-2','icon-folder-remove','icon-file','icon-file-2','icon-file-add','icon-file-remove','icon-file-check','icon-file-remove','icon-save-copy','icon-stack','icon-tree','icon-tree-2','icon-paragraph-left','icon-paragraph-center','icon-paragraph-right','icon-paragraph-justify','icon-screen','icon-tablet','icon-mobile','icon-box-add','icon-box-remove','icon-download','icon-upload','icon-home','icon-home-2','icon-out-2','icon-out-3','icon-link','icon-picture','icon-pictures','icon-palette','icon-camera','icon-camera-2','icon-play-2','icon-music','icon-user','icon-users','icon-vcard','icon-address','icon-share-alt','icon-enter','icon-exit','icon-comment','icon-comments-2','icon-quote','icon-quote-2','icon-quote-3','icon-phone','icon-phone-2','icon-envelope','icon-envelope-opened','icon-unarchive','icon-archive','icon-briefcase','icon-tag','icon-tag-2','icon-tags','icon-tags-2','icon-options','icon-cogs','icon-screwdriver','icon-wrench','icon-equalizer','icon-dashboard','icon-switch','icon-filter','icon-purge','icon-checkedout','icon-unlock','icon-key','icon-support','icon-database','icon-scissors','icon-health','icon-wand','icon-eye-open','icon-eye-close','icon-clock','icon-compass','icon-broadcast','icon-book','icon-lightning','icon-print','icon-feed','icon-calendar','icon-calendar-2','icon-calendar-3','icon-pie','icon-bars','icon-chart','icon-power-cord','icon-cube','icon-puzzle','icon-attachment','icon-lamp','icon-pin','icon-location','icon-shield','icon-flag','icon-flag-3','icon-bookmark','icon-bookmark-2','icon-heart','icon-heart-2','icon-thumbs-up','icon-thumbs-down','icon-unfeatured','icon-star-2','icon-featured','icon-smiley','icon-smiley-2','icon-smiley-sad','icon-smiley-sad-2','icon-smiley-neutral','icon-smiley-neutral-2','icon-cart','icon-basket','icon-credit','icon-credit-2'
			    );
	
	        $id = $name;
	        $id             = str_replace('[','',$id);
	        $id             = str_replace(']','',$id);
	 
	        $html   = '<select name="'.$name.'" id="'.$id.'">';
			
			$sel = ($this->value=='') ? '' : ' selected="selected"';
			
			$html   .= '<option style="width:auto;" value=""'.$sel.'>'.JText::_('COM_DJTABS_NO_ICON').'</option>';
			
			foreach ($icons as $icon){
				
				$sel = '';
				if ($selected==$icon) 
					$sel = ' selected="selected"';
				
				$html   .= '<option style="width:auto;" class="'.$icon.'" value="'.$icon.'"'.$sel.'> '.$icon.'</option>';
			}
			
	        $html   .= '</select>';
	 
	        return $html;
	}
}
?>