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

class plgContentDJTabs extends JPlugin
{
	protected static $tabs = array();
	/**
	 * Plugin that loads DJ-Tabs within content
	 *
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	object	The article object.  Note $article->text is also available
	 * @param	object	The article params
	 * @param	int		The 'page' number
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0){
		
		// Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer') {
			return true;
		}

		// simple performance check to determine whether bot should process further
		if (strpos($article->text, 'djtabs') === false) {
			return true;
		}

		// expression to search for (positions)
		$regex		= '/{djtabs\s*(\d*)\s*(\-?\d*)\s*(\w*)}/i';
		$regex2		= '/<img [^>]*alt="djtabs:(\d*),(\-?\d*),(\w*)"[^>]*>/i';
		//$style		= $this->params->def('style', 'none');
		
		// replace the image placeholder with plugin code
		$article->text = preg_replace($regex2, '{djtabs $1 $2 $3}', $article->text);

		// Find all instances of plugin and put in $matches for djmedia code
		// $matches[0] is full pattern match, $matches[1] is the album ID
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
		// No matches, skip this
		if ($matches) {
			foreach ($matches as $match) {
				$output = '';
				// Chceck if group ID is set.
				if (isset($match[1]) && (int)$match[1] > 0) {
					$output = $this->_load($match[1],$match[2],$match[3]);
				}
				// We should replace only first occurrence in order to allow the same category to regenerate their content:
				$article->text = preg_replace("|$match[0]|", addcslashes($output, '\\$'), $article->text, 1);
			}
		}
	}

	protected function _load($groupid, $themeid, $layout)
	{
		$tab_instance_id = $groupid.$themeid.$layout;
		if(isset(self::$tabs[$tab_instance_id])){
			return;
		}
		
		self::$tabs[$tab_instance_id] = '';
		
		if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);	
		jimport( 'joomla.application.module.helper' );
		require_once (JPATH_BASE . DS . 'components' . DS . 'com_djtabs' . DS . 'helpers' . DS . 'helper.php');
		require_once (JPATH_BASE . DS . 'components' . DS . 'com_djtabs' . DS . 'models' . DS . 'tabs.php');
			
		$document = JFactory::getDocument();
		$document->addScriptVersion('components/com_djtabs/assets/script.js');
	 	$document->addStyleSheet('components/com_djtabs/assets/icons.css');
		
		$lang = JFactory::getLanguage();
		$lang->load('com_djtabs', JPATH_SITE . '/components/com_djtabs');
		
		$params = JComponentHelper::getParams('com_djtabs');
		$params->set('theme',$themeid);
		$params->set('prefix','p'.$tab_instance_id);
		
		$tabs = DJTabsModelTabs::getTabs($groupid);
		
		$layout = $layout == 'tabs' ? 'default' : $layout; // backward compatibility
		
		DjTabsHelper::addThemeCSS($params); 
		DjTabsHelper::addTabsScriptDeclaration($layout, $params, true, 'p'.$tab_instance_id.'_');
		
		ob_start();

		require(JModuleHelper::getLayoutPath('mod_djtabs',$layout));

		self::$tabs[$tab_instance_id] = ob_get_clean();
		
		return self::$tabs[$tab_instance_id];
	}
	
}
