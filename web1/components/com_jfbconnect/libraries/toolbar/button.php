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

class JFBConnectToolbarButton
{
    var $order;
    var $displayName;
    var $systemName;

    public function html()
    {
        return '';
    }

    public function javascript()
    {
        $js = $this->generateJavascript();
        if ($js)
        {
            $js = 'var ' . $this->systemName . " = {" . $js . "};";
        }
        return $js;
    }

    protected function generateJavascript()
    {
        return "";
    }
}