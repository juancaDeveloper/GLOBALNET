<?php

/**
  + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , info@burujsolutions.com
  www.joomsky.com, ahmad@joomsky.com
 * Created on:	Oct 5, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	module/topjsjobs.php
  ^
 * Description: Module for JS Jobs
  ^
 * History:		1.0.2 - Nov 27, 2010
  ^
 */
defined('_JEXEC') or die('Restricted access');

// include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$result = modTopJSJobsHelper::getData($params);
require JModuleHelper::getLayoutPath('mod_topjsjobs');

?>