<?php
/**
 * @package BW Social Share
 * @copyright (C) 2016 www.woehrlin-websolutions.de
 * @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


class ModBWSocialShareHelper {

	public static function urloptimize ($string)
	{
		$string = str_replace(' ', '%20', $string);
		return $string;
	}
	public static function urlencode ($string) {
    	$string = urlencode($string);
	    $string = str_replace('|', '%7C', $string);
	    return $string;
    }



}
