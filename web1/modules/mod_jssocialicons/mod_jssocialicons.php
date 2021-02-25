<?php
/**
 * @package   JS Easy Social Icons
 * @copyright 2016 Open Source Training, LLC. All rights reserved.
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die('Direct access to files is not permitted');

require_once 'include.php';
require_once JPATH_SITE . '/modules/mod_jssocialicons/helper.php';

//take the values from configuration and replace in the urls
$helper         = new SocialIconsHelper();
$youtubeType    = $params->get('youtubeType', 'channel/');
$layout         = $params->get('layout', 'default');
$sort           = $params->get('ordering', '');
$sites          = $helper->getSites($sort);

foreach ($sites as $service_name => $url) {
    $username = $params->get($service_name, '');
    if ($username !== '') {

        // Check if is youtube
        if(strpos($url, 'youtube.com/channel/'))
        {
            $sites[$service_name] = str_replace("/channel/", $youtubeType, sprintf($url, $username));
        }
        else
        {
            $sites[$service_name] = sprintf($url, $username);
        }

    } else {
        //if does not have a value in the config, we can remove it
        unset($sites[$service_name]);
    }
}

// Params
$iconset     = $params->get('iconset', 'elegant');
$iconsize    = $params->get('iconsize', '16');
$orientation = $params->get('orientation', 'horizontal');
$before      = $params->get('textbefore', '');
$after       = $params->get('textafter', '');
$target      = $params->get('target', '_blank');

$path_i = JURI::root(true) . '/modules/mod_jssocialicons/';
$doc    = JFactory::getDocument();

// Load Font Awesome
$doc->addStyleSheet($path_i . 'assets/css/font-awesome.min.css');

// Global styling and sizes
$doc->addStyleSheet($path_i . 'assets/css/global.css');

// Iconset
if ($iconset != 'templatedesign') {
    $doc->addStyleSheet($path_i . 'assets/css/iconsets/' . $iconset . '.css');
}

require JModuleHelper::getLayoutPath('mod_jssocialicons', $layout);
