<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

defined('_JEXEC') or die('Unauthorized Access');

class JFBConnectAdminView extends JViewLegacy
{
    protected $forms = array();

    public function display($tpl = null)
    {
        $this->addToolbar();
        parent::display($tpl);
    }

    public function addToolbar()
    {
    }

    public function tabsStart($tabGroup, $active)
    {

        echo JHtml::_('bootstrap.startTabSet', $tabGroup, array('active' => $active));
    }

    public function tabsEnd()
    {
        echo JHtml::_('bootstrap.endTabSet');
    }

    public function tabStart($tabGroup, $tabName, $label)
    {
        echo JHtml::_('bootstrap.addTab', $tabGroup, $tabName, $label, true);
    }

    public function tabEnd()
    {
        echo JHtml::_('bootstrap.endTab');
    }

    // This form stuff should be broken into it's own class
    public function formLoad($name, $formPath, $options = array())
    {
        $form = JForm::getInstance('com_jfbconnect_' . $name, $formPath, $options);
        $this->forms[$name] = $form;
    }

    public function formBind($name, $data = null)
    {
        if (!isset($this->forms[$name]))
            return false;

        if (!$data)
            $data = JFBCFactory::config()->getSettings();
        $this->forms[$name]->bind($data);
    }

    public function formShowField($field)
    {
        echo $this->formGetField($field);
    }

    public function formGetField($field)
    {
        if ($field->hidden)
            $fieldValue = $field->input;
        else
        {
            $labelClass = $field->type == 'Providerloginbutton' ? 'login-button' : '';
            $fieldValue =  "  <div class=\"control-group\">\n";
            $fieldValue .= "   " . $field->label . "\n";
            $fieldValue .= "     <div class=\"controls " . $labelClass . "\">\n";
            $fieldValue .= "       " . $field->input . "\n";
            $fieldValue .= "     </div>\n";
            $fieldValue .= "  </div>\n";
        }
        return $fieldValue;
    }

    public function formDisplay($name, $columns = null)
    {
        $form = $this->forms[$name];
        // use a 2 column layout (by default) for more than one fieldset, if not passed in
        $blocks = count($form->getFieldsets());
        if (!$columns)
            $columns = $blocks > 1 ? 2 : 1;
        $span = $columns == 1 ? 12 : 6;
        $split = ceil($blocks / 2);
        $column = 0;
        echo "\n<div class=\"row-fluid\">\n";
        foreach ($form->getFieldsets() as $fiedsets => $fieldset)
        {
            if ($column == 0 || $column == $split)
                echo '<div class="span' . $span . '">' . "\n";
            echo "<div class=\"well\">\n";
            if ($fieldset->label)
                $label = $fieldset->label;
            else
                $label = JText::_(strtoupper($form->getName()) . '_MENU_' . strtoupper($fieldset->name));
            echo '<legend>' . $label . "</legend>\n";
            foreach ($form->getFieldset($fieldset->name) as $field)
                $this->formShowField($field);
            echo "</div>\n";
            $column++;
            if ($column == $split)
                echo "</div>\n";
        }
        echo ($column > $split) ? "</div>\n" : '';
        echo "</div>\n";
    }
}