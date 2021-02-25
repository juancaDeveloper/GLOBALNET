<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

if (!(defined('_JEXEC') || defined('ABSPATH'))) {     die('Restricted access'); };

require_once(JPATH_SITE . '/components/com_jfbconnect/libraries/factory.php');
JFBCFactory::initializeJoomla();

$document = JFactory::getDocument();
$document->addStyleSheet("components/com_jfbconnect/assets/css/default.css");
$document->addStyleSheet(JURI::root() . "media/sourcecoast/css/sc_bootstrap.css");
$document->addStyleSheet(JURI::root() . "media/sourcecoast/css/common.css");
$document->addScript(JURI::root() . "media/sourcecoast/js/jq-bootstrap-1.8.3.js");
$document->addScript("components/com_jfbconnect/assets/jfbconnect-admin.js?v=8.0");
$document->addScript("components/com_jfbconnect/assets/js/jfbcadmin-template.js");

JFBConnectUtilities::loadLanguage('com_jfbconnect', JPATH_ADMINISTRATOR);

require_once(JPATH_COMPONENT . '/controller.php');

$input = JFactory::getApplication()->input;
$task = $input->getCmd('task');

// Slowly update these 'old' admin views to the new style...
$oldStyle = array('ajax', 'autotune', 'canvas', 'config', 'opengraph', 'profiles', 'social', 'usermap');
if (strpos($task, '.') === false &&
        (in_array(JRequest::getCmd('controller', ''), $oldStyle) ||
        in_array(JRequest::getCmd('view', ''), $oldStyle))
        )
{
    // Old beatup way. Don't do this anymore
    $view = JRequest::getCmd('controller', '');
    if ($view == "")
        $view = JRequest::getCmd('view', '');

    if ($view != '' && $view != "jfbconnect") // Don't do this for the main landing page. Fix this system
    {
        require_once(JPATH_COMPONENT . '/controllers/' . strtolower($view) . '.php');
        $controllerName = $view;
    }
    else
        $controllerName = "";

    $classname = 'JFBConnectController' . ucfirst($controllerName);
    $controller = new $classname();
}
else
    $controller = JControllerLegacy::getInstance('jfbconnect');

$controller->execute($input->getCmd('task'));

if (JRequest::getCmd('tmpl') != 'component')
    include_once(JPATH_ADMINISTRATOR . '/components/com_jfbconnect/assets/footer/footer.php');

$controller->redirect();
