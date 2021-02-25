<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldProviderList extends JFormFieldList
{
    public $type = 'ProviderList';

    protected function getOptions()
    {
        require_once(JPATH_ROOT.'/components/com_jfbconnect/libraries/factory.php');

        $providers = JFBCFactory::getAllProviders();

        $options = array();
        $options[] = JHtml::_('select.option', "provider", "--Select your provider--");
        foreach ($providers as $provider)
        {
            $options[] = JHtml::_('select.option', $provider->systemName, $provider->name);
        }
        return $options;
    }

    protected function getInput()
    {
        JFactory::getDocument()->addScript(JUri::root() . 'media/sourcecoast/js/jq-bootstrap-1.8.3.js');
        JFactory::getDocument()->addScript('components/com_jfbconnect/assets/js/jfbcadmin-template.js');
        JFactory::getDocument()->addScript('components/com_jfbconnect/assets/jfbconnect-admin.js');
        JFactory::getDocument()->addScriptDeclaration('var sc_modid = "' . JRequest::getInt('id') . '";');
        if (count($this->getOptions()) == 0)
            return "";

        //if ($this->value != "provider")
        //    JFactory::getDocument()->addScriptDeclaration("jfbcJQuery(document).ready(function() { jfbcAdmin.scsocialwidget.fetchWidgets('" . $this->value . "'); });");
        return parent::getInput();
    }

    protected function getLabel()
    {
        if (count($this->getOptions()) == 0)
            return "<label>There are no Social Providers available</label>";

        return parent::getLabel();
    }
}
