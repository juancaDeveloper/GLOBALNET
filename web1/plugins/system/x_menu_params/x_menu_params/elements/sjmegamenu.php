<?php
/**
 * @package Sj Megamenu
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined ('_JEXEC') or die ('resticted aceess');

jimport('joomla.form.formfield');

class JFormFieldSjmegamenu extends JFormField
{
    protected $type = "Sjmegamenu";

    public function getInput()
    {
        $mega_menu_path = JPATH_SITE.'/plugins/system/x_menu_params/x_menu_params/elements/';
        $html = $this->getMegaSettings($mega_menu_path, json_decode($this->value));
        $html .= '<input type="hidden" name="'.$this->name.'" id="'.$this->id.'" value="'.$this->value.'">';

        return $html;
    }

    public function getMegaSettings($path, $value = null)
    {
        ob_flush();
        ob_start();
        $menu_data = $value;
        include_once $path.'sjmenulayout.php';
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}