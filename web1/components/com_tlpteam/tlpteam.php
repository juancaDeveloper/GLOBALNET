<?php
/**
 * @version     2.0
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');
$tlpteam_params = JComponentHelper::getParams('com_tlpteam');
$enable_font_awesome=$tlpteam_params->get('enable_font_awesome','1');
$document = JFactory::getDocument();

$document->addStyleSheet('components/com_tlpteam/assets/css/tlpteam.css');
//if($enable_font_awesome==1){
$document->addStyleSheet('components/com_tlpteam/assets/css/font-awesome.min.css');
//}
// Execute the task.
$controller	= JControllerLegacy::getInstance('Tlpteam');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
