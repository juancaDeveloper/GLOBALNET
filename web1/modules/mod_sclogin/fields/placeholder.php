<?php
/**
 * @package         SCLogin
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.helper');

class JFormFieldPlaceholder extends JFormField
{
    public function getInput()
    {
        return "";
    }

    public function getLabel()
    {
        return "";
    }
}
