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
defined('_JEXEC') or die;

class plgButtonDJTabs extends JPlugin
{
	
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * Display the button
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name)
	{
		$app = JFactory::getApplication();
		if($app->isSite()) return;
		
		$doc = JFactory::getDocument();
		$template = $app->getTemplate();

		$js = "
		function jInsertDJTabs(groupid, themeid, layoutname, title) {			
			var tag = '<div><img src=\"' + 'administrator/components/com_djtabs/assets/icon-90-editor.png' + '\" style=\"background: #f5f5f5 10px center no-repeat; display: block; max-width: 100%; max-height: 300px; margin: 10px auto; padding: 10px 50px 10px 50px; border: 1px solid #ddd; \" alt=\"djtabs:' + groupid +','+themeid+','+layoutname+ '\" title=\"' + title + '\"></div>';
			jInsertEditorText(tag, '".$name."');
			SqueezeBox.close();
		}";
		$doc->addScriptDeclaration($js);
		$doc->addStyleDeclaration('
			.button2-left .djtabs a {background: url("'.JURI::base(true).'/components/com_djtabs/assets/icon-16.png") 100% 50% no-repeat; margin: 0 4px 0 0; padding: 0 22px 0 6px;}
			.icon-djtabs { height: 16px; width: 16px; background: url("'.JURI::base(true).'/components/com_djtabs/assets/icon-16.png") 0 0 no-repeat; margin: 0 0 -3px; }
		');
		
		//$link = 'index.php?option=com_djmediatools&amp;view=categories&amp;layout=modal&amp;tmpl=component&amp;f_name=jInsertDJMedia';
		$link = 'index.php?option=com_djtabs&amp;view=modal&amp;tmpl=component&amp;f_name=jInsertDJTabs';
		
		JHtml::_('behavior.modal');
		
		$button = new JObject;
		$button->modal = true;
		$button->class = 'btn';
		$button->link = $link;
		$button->text = JText::_('PLG_EDITORSXTD_DJTABS_BUTTON');
		$button->name = 'djtabs blank';
		//$button->options = '{handler: \'iframe\', size: {x: \'100%\', y: \'100%\'}, onOpen: function() { window.addEvent(\'resize\', function(){ this.resize({x: window.getSize().x - 100, y: window.getSize().y - 100}, true); }.bind(this) ); window.fireEvent(\'resize\'); }}';
		if(version_compare(JVERSION, '3.0', '>=')){
			$x = '280'; $y = '280'; 
		}
		else{
			$x = '200'; $y = '200'; 
		}
		$button->options = '{handler: \'iframe\', size: {x: \'100%\', y: \'100%\'}, onOpen: function() { window.addEvent(\'resize\', function(){ this.resize({x: '.$x.', y: '.$y.'}, true); }.bind(this) ); window.fireEvent(\'resize\'); }}';

		return $button;
	}
}

