<?php
/**
 * @package   JS Easy Social Icons
 * @copyright 2016 Open Source Training, LLC. All rights reserved.
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die('Direct access to files is not permitted.');


jimport('joomla.form.formfield');
require_once JPATH_SITE . '/modules/mod_jssocialicons/helper.php';

class JFormFieldIconsorder extends JFormField
{
    protected $type = 'Iconsorder';

    protected function getInput()
    {


        //add the jQuery UI Sortable plug-in (javascript and css)
        $path_i = JURI::root(true) . '/modules/mod_jssocialicons/';
        $path   = JPATH_SITE . '/modules/mod_jssocialicons/';
        $doc    = JFactory::getDocument();

        //add jQuery only if we are not on 3+
        if (version_compare(JVERSION, '3.0', 'lt')) {
            $doc->addScript($path . '/form/fields/sortable/js/jquery-1.8.3.js');
        }

        $doc->addScript($path_i . '/form/fields/sortable/js/jquery-ui-1.9.2.sortable.min.js');
        $doc->addStylesheet($path_i . '/form/fields/sortable/css/jquery-ui-1.9.2.custom.css');

        // Add the stylesheet for Elegant 32 icons
        $doc->addStyleSheet($path_i . 'assets/css/font-awesome.min.css');
        $doc->addStyleSheet($path_i . 'assets/css/global.css');
        $doc->addStyleSheet($path_i . 'assets/css/iconsets/elegant.css');

        // Force to use Font Awesome and YouTube icon over IcoMoon settings
        $force_fa = 'ul.jssocialicons > li > a.iconset-elegant:before{font-family:FontAwesome;font-weight:normal;font-style:normal;text-decoration:inherit;-webkit-font-smoothing:antialiased;*margin-right:.3em;}';
        $force_fa .= 'ul.jssocialicons > li > a.iconset-elegant{cursor:all-scroll;font-size:20px;height:32px;line-height:32px;width:32px;margin-bottom:5px;}';
        $force_fa .= 'ul.jssocialicons > li > a.icon-youtube:before{content:"\f167";}';
        $force_fa .= '#socialicons-sortlist{margin-left:0;}';
        $doc->addStyleDeclaration($force_fa);

        //javascript to activate the sortable plugin on our code
        $js = 'jQuery(document).ready(function() { '
                . '	jQuery("#socialicons-sortlist").sortable({'
                . '		"update" : function() { var order = jQuery("#socialicons-sortlist").sortable("serialize", {key : "sort[]"}); jQuery("#jform_params_ordering").val(order); }  '
                . '	});'
                . ' jQuery("#socialicons-sortlist").disableSelection(); '
                . ' jQuery("#socialicons-sortlist li img").mousedown(function(e) { '
                . '		e.preventDefault(); '
                . ' });'
                . '});';
        $doc->addScriptDeclaration($js);

        //get the ordered array of sites
        $helper = new SocialIconsHelper();
        $sort   = ($this->value !== '') ? $this->value : null;
        $sites  = $helper->getSites($sort);


        //create the html
        $html  = '<div id="easy-social-icons"><ul id="socialicons-sortlist" class="jssocialicons">';

        //add each social network
        $i = 0;
        foreach ($sites as $name => $url) {
            $html .= '<li id="socialicon-' . $name . '" class="ui-state-default"><a class="iconset-elegant si-' . $name . '" href="javascript:void(0)"></a></li>';
        }

        $html .= '</ul></div>';

        //add the hidden input which will contain the actual ordering values
        $html .= '<input id="jform_params_ordering" type="hidden" name="jform[params][ordering]" value="' . $this->value . '" />';

        return $html;
    }
}
