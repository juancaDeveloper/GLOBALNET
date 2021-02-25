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

class JFBConnectViewUsermap extends JViewLegacy
{
    function display($tpl = null)
    {
        $userMapModel = $this->getModel('usermap');
        $pagination = &$userMapModel->getPagination();
        $lists = $this->get('ViewLists', 'usermap');

        $this->assignRef('pagination', $pagination);
        $this->assignRef('lists', $lists);

        $this->addToolbar();

        parent::display($tpl);
    }

    function addToolbar()
    {
        JToolBarHelper::title('JFBConnect', 'jfbconnect.png');
        SCAdminHelper::addAutotuneToolbarItem();
    }
}
