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

jimport('joomla.application.component.view');
jimport('sourcecoast.adminHelper');

class JFBConnectViewSocial extends JViewLegacy
{
    function display($tpl = null)
    {
        $model = JFBCFactory::config();

        $this->assignRef('model', $model);

        $filter_provider = JRequest::getVar('filter_provider');
        $this->assignRef('filter_provider', $filter_provider);

        $this->addToolbar();

        parent::display($tpl);
    }

    function addToolbar()
    {
        JToolBarHelper::title('JFBConnect: Social Widgets / Content Plugin', 'jfbconnect.png');
        JToolBarHelper::apply('apply', JText::_('COM_JFBCONNECT_BUTTON_APPLY_CHANGES'));
        SCAdminHelper::addAutotuneToolbarItem();
    }
}
