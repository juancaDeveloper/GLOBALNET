<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
				www.joomsky.com, ahmad@joomsky.com
 * Created on:	Dec 30, 2010
 ^
 + Project: 		JS Jobs 
 * File Name:	module/jsjobsstates.php
 ^ 
 * Description: Module for JS Jobs
 ^ 
 * History:		1.0.0 - Dec 30, 2010
 ^ 
 */

defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
 
$result = modJSJobsCountryHelper::getData($params);
require JModuleHelper::getLayoutPath('mod_jsjobscountry');

?>