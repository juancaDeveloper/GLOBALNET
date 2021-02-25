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

class JFBConnectProviderMeetup extends JFBConnectProvider
{
    function __construct()
    {
        $this->name = "Meetup";
        $this->usernamePrefix = "meetup_";
        $this->loginPrefix = "me";

        parent::__construct();
    }

    function setupAuthentication()
    {
        $options = new JRegistry();
        $options->set('authurl', 'https://secure.meetup.com/oauth2/authorize');
        $options->set('tokenurl', 'https://secure.meetup.com/oauth2/access');
        $options->set('authmethod', 'get');

        $headers = array();
        $headers['Content-Type'] = 'application/json';
        $options->set('headers', $headers);

        $options->set('scope', '');

        $this->client = new JFBConnectAuthenticationOauth2($options);

        $token = JFactory::getApplication()->getUserState('com_jfbconnect.' . $this->systemName . '.token', null);
        if ($token)
        {
            $token = (array)json_decode($token);
            $this->client->setToken($token);
        }
        $this->client->initialize($this);
    }

    /* getProviderUserId
    * Gets the provider User Id from the provider. This is regardless of whether they are mapped to an
    *  existing Joomla account.
    */
    function getProviderUserId()
    {
        if ($this->get('providerUserId', null) == null)
        {
            $profile = $this->profile->fetchProfile('self', 'id');
            $id = $profile->get('id');
            if (!empty($id))
                $this->set('providerUserId', $id);
            else
                $this->set('providerUserId', null);
        }
        return $this->get('providerUserId');
    }

    function getHeadData()
    {
        $head = '';
        if ($this->needsJavascript)
        {
            // Add any Javascript files here
        }

        return $head;
    }

}