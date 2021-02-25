<?php
defined('_JEXEC') or die('Access Dany');
require_once dirname(__FILE__) . '/helper.php';

$result = modJSPackageHelper::getData($params, $module);
require JModuleHelper::getLayoutPath('mod_jsjobspackage');
                        
?>