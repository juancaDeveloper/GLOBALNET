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

class JFBConnectControllerScope extends JFBConnectController
{
    public function __construct()
    {
        parent::__construct();
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = 'scope';
        $this->view = $this->getView($viewName, $viewType);
    }

    function display($cachable = false, $urlparams = false)
    {
        $task = JRequest::getCmd('task', 'default');

        $this->view->setLayout($task);
        $this->view->display();
    }

}