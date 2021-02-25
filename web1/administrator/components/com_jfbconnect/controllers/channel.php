<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

if (!(defined('_JEXEC') || defined('ABSPATH'))) {     die('Restricted access'); };

jimport('joomla.application.component.controllerform');
class JFBConnectControllerChannel extends JControllerForm
{
    private function checkAutotune()
    {
        // Saving an object or action
        $appConfig = JFBCFactory::config()->getSetting('autotune_app_config', array());
        $namespace = $appConfig['namespace'];
        if ($namespace == '')
            return false;
        else
            return true;
    }
}