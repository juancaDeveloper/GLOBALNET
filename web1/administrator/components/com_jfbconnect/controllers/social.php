<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */
 // Check to ensure this file is included in Joomla!
if (!(defined('_JEXEC') || defined('ABSPATH'))) {     die('Restricted access'); };

class JFBConnectControllerSocial extends JFBConnectController
{
    function apply()
    {
        $configs = JRequest::get('POST', 4);
        $model = $this->getModel('config');
        $model->saveSettings($configs);
        JFBCFactory::log(JText::_('COM_JFBCONNECT_MSG_SETTINGS_UPDATED'));
        $this->setRedirect('index.php?option=com_jfbconnect&view=social');
    }

}