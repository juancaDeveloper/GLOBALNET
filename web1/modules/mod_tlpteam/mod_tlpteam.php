<?php

/**
 * @version     1.0
 * @package     com_tlpteam
 * @subpackage  mod_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$doc = JFactory::getDocument();

/* */
$doc->addStyleSheet(JURI::base() . '/components/com_tlpteam/assets/css/tlpteam.css');
/***** Owl Carousel Assets ***/
$doc->addStyleSheet(JURI::base() . '/components/com_tlpteam/assets/owlcarousel/owl.carousel.min.css');
$doc->addStyleSheet(JURI::base() . '/components/com_tlpteam/assets/owlcarousel/owl.theme.default.min.css');

$doc->addScript(JURI::base() . '/components/com_tlpteam/assets/owlcarousel/owl.carousel.min.js');

require JModuleHelper::getLayoutPath('mod_tlpteam', $params->get('mod_layout', 'layout1'));

