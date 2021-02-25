<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
			www.joomsky.com, ahmad@joomsky.com
 * Created on:	Oct 2nd, 2009
 ^
 + Project: 		JS Jobs 
 * File Name:	module/jsjobssearch.php
 ^ 
 * Description: Module for JS Jobs
 ^ 
 * History:		1.0.3 - Nov 27, 2010
 ^ 
 */

defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
 
$result = modJSJobsSearchHelper::getData($params);
require JModuleHelper::getLayoutPath('mod_jsjobssearch');

?>