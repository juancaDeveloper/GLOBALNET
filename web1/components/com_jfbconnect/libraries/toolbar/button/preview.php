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

class JFBConnectToolbarButtonPreview extends JFBConnectToolbarButton
{
    var $order = '20';
    var $displayName = "Preview";
    var $systemName = "preview";

    protected function generateJavascript()
    {
        return "display: function() {
                window.open('http://socialdebug.com/results?url=' + encodeURIComponent(document.location), '_blank');
            }";
    }

}