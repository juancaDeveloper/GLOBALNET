<?php
/**
 + Created by:  Ahmad Bilal
 * Company:     Buruj Solutions
 + Contact:     www.burujsolutions.com , info@burujsolutions.com
                www.joomsky.com, ahmad@joomsky.com
 * Created on:  Dec 2, 2009
 ^
 + Project:         JS Jobs 
 * File Name:   module/jsjobsonmap
 ^ 
 * Description: Module for JS Jobs
 ^ 
 * History:     1.0.0 - June 8, 2015
 ^ 
 */
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
 
$result = modJSJobsOnMapHelper::getData($params);
require JModuleHelper::getLayoutPath('mod_jsjobsonmap');


?>