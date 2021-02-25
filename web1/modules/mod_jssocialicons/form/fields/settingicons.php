<?php
/**
 * @package   JS Easy Social Icons
 * @copyright 2016 Open Source Training, LLC. All rights reserved.
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die('Direct access to files is not permitted.');


jimport('joomla.form.formfield');


class JFormFieldSettingIcons extends JFormFieldList
{
    protected $type = 'SettingIcons';

    protected function getOptions()
    {
        $options = parent::getOptions();
        $db      = JFactory::getDBO();
        $sql     = " SELECT ts.template " .
        " FROM #__menu as m " .
        " INNER JOIN #__template_styles as ts" .
        " ON ts.id = m.template_style_id " .
        " WHERE m.home = 1" .
        " AND m.published = 1" .
        "";
        $db->setQuery($sql);
        $tplName = $db->loadResult();
        $path    = JPATH_SITE . '/' . 'templates/' . $tplName . '/images/jssocialicons';

        if (is_dir(JPath::clean($path))) {
            $options[] = JHtml::_('select.option', 'templatedesign', 'TemplateDesign');
        }
        return $options;
    }
}
