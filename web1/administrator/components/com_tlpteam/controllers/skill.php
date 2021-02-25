<?php
/**
 * @version     1.1
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Skill controller class.
 */
class TlpteamControllerSkill extends JControllerForm
{

    function __construct() {
        $this->view_list = 'skills';
        parent::__construct();
    }

}