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

class JFormFieldChannelOutboundProviders extends JFormFieldList
{
    public $type = 'ChannelOutboundProviders';

    protected function getOptions()
    {
        $options = array();
        $options[] = JHtml::_('select.option', "--", "-- Select a Provider --");

        $providers = JFBCFactory::getAllProviders();
        foreach ($providers as $p)
        {
            $channels = $p->getChannelsOutbound();
            if (count($channels) > 0)
                $options[] = JHtml::_('select.option', $p->systemName, $p->name);
        }

        return $options;
    }
}