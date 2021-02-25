<?php
/**
 * @package Sj Megamenu
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die('Restricted access');


jimport('joomla.plugin.plugin');

class plgSystemX_Menu_Params extends JPlugin {
	var $_resources = '';
	
	function plgSystemX_Menu_Params(&$subject, $pluginconfig) {
		parent::__construct($subject, $pluginconfig);
		$this->_resources = dirname(__FILE__).'/x_menu_params/xml/';
	}

	function onContentPrepareForm($form, $data) {
		$language = JFactory::getLanguage();
		$language->load('plg_system_x_menu_params');
		$doc 		= JFactory::getDocument();
		$plg_path 	= JURI::root(true).'/plugins/system/x_menu_params/';
		if ($form->getName()=='com_menus.item') {
			JHtml::_('jquery.framework');
			JForm::addFormPath($this->_resources);
			if($data['id'] && $data['parent_id'] == 1) {
				JHtml::_('jquery.ui', array('core', 'more', 'sortable'));				
				$doc->addScript($plg_path.'assets/js/jquery-ui.draggable.min.js');
				$doc->addStyleSheet($plg_path.'assets/css/bootstrap.css');
				$doc->addStyleSheet($plg_path.'assets/css/font-awesome.min.css');
				$doc->addStyleSheet($plg_path.'assets/css/modal.css');
				$doc->addStyleSheet($plg_path.'assets/css/sjmegamenu.css');
				// $doc->addScript($plg_path.'assets/js/modal.js');
				$doc->addScript( $plg_path. 'assets/js/sjmegamenu.js' );
				$form->loadFile('menus_edit_params', false);
			}
			else {
				$form->loadFile('menus_edit_params_child', false);
			}
		}
	}
}