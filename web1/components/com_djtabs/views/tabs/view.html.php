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

defined ('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class DJTabsViewTabs extends JViewLegacy{
	
    function display($tpl = null) {
		
        $app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$layout = JRequest::getVar('layout','default');
		$menus	= $app->getMenu('site');
		$m_active = $menus->getActive();
		
		if($m_active){
			if($m_active->params->get('menu-meta_keywords')){
				$document->setMetaData('keywords',$m_active->params->get('menu-meta_keywords'));
			}
			if($m_active->params->get('menu-meta_description')){
				$document->setDescription($m_active->params->get('menu-meta_description'));
			}
		}
		
		$model = $this->getModel();
		$params = $model->getParams();
		
		$groupid = $params->get('group_id',0);
		if(!$groupid){
	        return false;
		}
		
		$tabs=$model->getTabs($groupid);

		$this->assignRef('tabs',$tabs);
		$this->assignRef('params',$params);

		DjTabsHelper::addThemeCSS($params);
		DjTabsHelper::addTabsScriptDeclaration($layout, $params);
		
        parent::display($tpl);
    }
}

?>