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

class JFBConnectProviderYahoo extends JFBConnectProvider
{
    function __construct()
    {
        $this->name = "Yahoo";
        $this->usernamePrefix = "yh_";
        $this->loginPrefix = "yh";

        parent::__construct();
    }

    public function setupAuthentication()
    {
        $options = new JRegistry();
        $options->set('authurl', 'https://api.login.yahoo.com/oauth2/request_auth');
        $options->set('tokenurl', 'https://api.login.yahoo.com/oauth2/get_token');
        $options->set('authmethod', 'bearer');

        $headers = array();
        $headers['Content-Type'] = 'application/json';
        $options->set('headers', $headers);

        /* DEVELOPER NOTE: Do not set scope here. Breaks with an Oops error on Yahoo side with any scope set.
            The authentication will use the scope set in the app to give the necessary profile fields
            e.g. App - public and private = sdpp-w Extended Profile Information and Email address
            e.g. App - public - sdps-r = Basic profile read (NO EMAIL ADDRESS -> no automatic registration)
        */
//        $scope = 'openid sdpp-r';
//		$options->set('scope', $scope);

        $currentLanguage = JFactory::getLanguage();
        $requestparams['language'] = $currentLanguage->getTag();
        $requestparams['prompt'] = 'consent';
        $options->set('requestparams', $requestparams);

        $this->client = new JFBConnectAuthenticationOauth2($options);

        $token = JFactory::getApplication()->getUserState('com_jfbconnect.' . $this->systemName . '.token', null);
        if ($token)
        {
            $token = (array)json_decode($token);
            $this->client->setToken($token);
        }
        $this->client->initialize($this);

        $redirect = JUri::base() . 'index.php';
        $this->client->setOption('redirecturi', $redirect);
    }

    /* getProviderUserId
    * Gets the provider User IdFacebook. This is regardless of whether they are mapped to an
    *  existing Joomla account.
    */
    function getProviderUserId()
    {
        $token = $this->client->getToken();

        if(isset($token['access_token']) && $this->get('providerUserId', null) == null)
        {
            $profile = $this->profile->fetchProfile('me', 'id');
            $id = $profile->get('sub');

            if (!empty($id))
                $this->set('providerUserId', $id);
            else
                $this->set('providerUserId', null);
        }
        return $this->get('providerUserId');
    }

    function onAfterInitialise()
    {
        $app = JFactory::getApplication();
        $loginStarted = $app->getUserState('com_jfbconnect.authentication.started.' . $this->systemName, false);

        $app->setUserState('com_jfbconnect.authentication.started.' . $this->systemName, false);

        if ($loginStarted)
        {
            $code = $app->input->get('code', false, 'raw');
            if ($code)
            {
                $app->redirect('index.php?option=com_jfbconnect&task=authenticate.callback&provider=yahoo&code=' . $code . '&state=' . JSession::getFormToken());
            }
        }

    }
}
