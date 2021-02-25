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

class JFBConnectProviderVkWidgetPlaylist extends JFBConnectWidget
{
    var $name = "Playlist";
    var $systemName = "playlist";
    var $className = "sc_vkplaylist";
    var $tagName = "scvkplaylist";
    var $examples = array (
        '{SCVkPlaylist}',
        '{SCVkPlaylist code=code from widget here width=350}'
    );

    /**
     * @return string
     */
    protected function getTagHtml()
    {
        $tag = $this->getParamValue('code');
        if(empty($tag)) return $tag;

        //we remove the js insert of vk.com/js/api/openapi.js since we already have it in the VK provider class
        $tag = preg_replace('/\(function(.+)\bfunction/', '(function', $tag);

        //we set the width from the params
        $width = intval($this->getParamValue('width'));
        $width_txt = '{width: '.$width.'}';
        $tag = preg_replace('/{width:(.+)\b}/', $width_txt, $tag);

        return $tag;
    }
}