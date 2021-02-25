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
defined( '_JEXEC' ) or die( 'Restricted access' );

if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}
// Include dependancies
jimport('joomla.application.component.controller');
require_once(JPATH_COMPONENT.DS.'lib'.DS.'djlicense.php');
$db = JFactory::getDBO();
$db->setQuery("SELECT manifest_cache FROM #__extensions WHERE element='com_djtabs' LIMIT 1");
$version = json_decode($db->loadResult());
$version = $version->version;
//$version= 1.0;

define('DJTABSFOOTER', '<div style="text-align: center; margin: 10px 0; clear:both; ">DJ-Tabs (version '.$version.'), &copy; 2012-'.JFactory::getDate()->format('Y').' Copyright by <a target="_blank" href="http://dj-extensions.com">DJ-Extensions.com</a>, All Rights Reserved.<br /><a target="_blank" href="http://dj-extensions.com"><img src="'.JURI::base().'components/com_djtabs/assets/logo.png" alt="dj-extensions.com" style="margin: 20px 0 0;" /></a></div>');

$controller = JControllerLegacy::getInstance('djtabs');
$document = JFactory::getDocument();
if ($document->getType() == 'html') {
	$document->addStyleSheet(JURI::base(true).'/components/com_djtabs/assets/style.css');
}

// Perform the Request task
//$controller->execute( JRequest::getCmd('task'));
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

function djdebug($array, $type = 'message'){
	
	$app = JFactory::getApplication();	
	$app->enqueueMessage("<pre>".print_r($array,true)."</pre>", $type);
	
}


?>