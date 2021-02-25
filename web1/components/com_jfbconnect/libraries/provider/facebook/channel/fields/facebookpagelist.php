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

class JFormFieldFacebookPageList extends JFormFieldList
{
    public $type = 'FacebookPageList';

    protected function getOptions()
    {
        $options = array();
        $options[] = JHtml::_('select.option', "--", "-- ".JText::_('COM_JFBCONNECT_CHANNEL_FACEBOOK_PAGE_SELECT_LABEL')." --");

        $jid = $this->form->getValue('attribs.user_id');
        $uid = JFBCFactory::usermap()->getProviderUserId($jid, 'facebook');
        $access_token = JFBCFactory::usermap()->getUserAccessToken($jid, 'facebook');
        $params['access_token'] = $access_token;
        $pages = JFBCFactory::provider('facebook')->api('/' . $uid . '/accounts?limit=100', $params, true, 'GET');

        if (isset($pages['data']) && count($pages['data']) > 0)
        {
            foreach ($pages['data'] as $p)
            {
                $options[] = JHtml::_('select.option', strtolower($p['id']), $p['name'] . " (" . $p['category'] . ')');
            }
        }

        return $options;
    }

    function getInput()
    {
        $jid = $this->form->getValue('attribs.user_id');
        if ($jid)
        {
            $uid = JFBCFactory::usermap()->getProviderUserId($jid, 'facebook');
            if ($uid)
            {
                if (!JFBCFactory::provider('facebook')->hasScope($uid, 'pages_show_list'))
                    return '<div class="jfbc-error">'.JText::sprintf('COM_JFBCONNECT_CHANNEL_FACEBOOK_PERM_ERROR_LABEL','pages_show_list').'</div>';
                else if ($this->form->getValue('attribs.allow_posts') && !JFBCFactory::provider('facebook')->hasScope($uid, 'pages_manage_posts'))
                    return '<div class="jfbc-error">'.JText::sprintf('COM_JFBCONNECT_CHANNEL_FACEBOOK_PERM_ERROR_LABEL','pages_manage_posts').'</div>';
                else
                    return parent::getInput();
            }
            else
            {
                return '<div class="jfbc-error">'.JText::_('COM_JFBCONNECT_CHANNEL_FACEBOOK_PERM_PAGE_USER_AUTH_ERROR_LABEL').'</div>';
            }

        }
        else
            return '<div class="jfbc-error">'.JText::_('COM_JFBCONNECT_CHANNEL_SELECT_USER_ERROR_LABEL').'</div>';
    }
 }