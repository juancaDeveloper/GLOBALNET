<?php
/**
 * @package		customfieldsforall
 * @copyright	Copyright (C)2014-2018 breakdesigns.net . All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

if(!class_exists('VmConfig')) {
    require(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_virtuemart'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'config.php');
}
VmConfig::loadConfig();
if(!class_exists('vmCustomPlugin')) {
    require(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_virtuemart'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'vmcustomplugin.php');
}

require_once(__DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'Customfield.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'Filter.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'Update.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'VmCompatibilityCF.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'Language'.DIRECTORY_SEPARATOR.'LanguageHandlerFactory.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'LanguageHandler.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'Language'.DIRECTORY_SEPARATOR.'Table.php');

