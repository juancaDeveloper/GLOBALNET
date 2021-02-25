<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
				www.joomsky.com, ahmad@joomsky.com
 * Created on:	Nov 29, 2009
 ^
 + Project: 		JS Jobs 
 * File Name:	module/jsfeaturedcompanies.php
 ^ 
 * Description: Module for JS Jobs
 ^ 
 * History:		NONE
 ^ 
 */

defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
 
$result = modJSFeaturedCompaniesHelper::getData($params,$module); 
require JModuleHelper::getLayoutPath('mod_jsfeaturedcompanies');

?>

