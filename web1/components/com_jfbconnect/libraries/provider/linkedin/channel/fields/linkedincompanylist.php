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

class JFormFieldLinkedinCompanyList extends JFormFieldList
{
    public $type = 'LinkedinCompanyList';
    private $companies;
    private $liLibrary;

    protected function getOptions()
    {
        $options = array();
        $options[] = JHtml::_('select.option', "--", "-- Select a Company --");

        if(isset($this->companies->elements) && count($this->companies->elements) > 0)
        {
            foreach($this->companies->elements as $c)
            {
                if($c->role == 'ADMINISTRATOR')
                {
                    $orgId = $c->organizationalTarget;
                    $orgId = str_replace('urn:li:organization:', '', $orgId);
                    $name = JFBConnectProviderLinkedinChannelCompany::getCompanyName($this->liLibrary, $orgId);
                    $options[] = JHtml::_('select.option', strtolower($orgId), $name);
                }
            }
        }

        return $options;
    }

    function getInput()
    {
        $jid = $this->form->getValue('attribs.user_id');
        if ($jid)
        {
            $uid = JFBCFactory::usermap()->getProviderUserId($jid, 'linkedin');
            if ($uid)
            {
                $access_token = JFBCFactory::usermap()->getUserAccessToken($jid, 'linkedin');
                $params['access_token'] = $access_token;
                $this->liLibrary = JFBCFactory::provider('linkedin');
                $this->liLibrary->client->setToken((array)$access_token);

                $url = 'https://api.linkedin.com/v2/organizationalEntityAcls?q=roleAssignee';
                try
                {
                    $companies = $this->liLibrary->query($url);
                    if ($companies->code == '200')
                    {
                        $this->companies = json_decode($companies->body);
                    }
                    return parent::getInput();
                }
                catch (Exception $e)
                {
                    return '<div class="jfbc-error">'.JText::_('COM_JFBCONNECT_CHANNEL_LINKEDIN_PERM_TOKEN_EXPIRED_LABEL').'</div>';
                }
            }
            else
            {
                return '<div class="jfbc-error">'.JText::_('COM_JFBCONNECT_CHANNEL_LINKEDIN_PERM_USER_AUTH_ERROR_LABEL').'</div>';
            }

        }
        else
            return '<div class="jfbc-error">'.JText::_('COM_JFBCONNECT_CHANNEL_SELECT_USER_ERROR_LABEL').'</div>';
    }
}
