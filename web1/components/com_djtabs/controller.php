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
 
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class DJTabsController extends JControllerLegacy
{
	public function display($cachable = true, $urlparams = false)
	{
		$document= JFactory::getDocument();
		
		//$document->addScriptVersion('components/com_djtabs/assets/script.js','text/javascript', true, false);
		$document->addScriptVersion('components/com_djtabs/assets/script.js');
		$document->addStyleSheet('components/com_djtabs/assets/icons.css');
		
		return parent::display($cachable, $urlparams);
	}
}

