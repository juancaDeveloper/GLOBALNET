<?php
/**
 * @package		 JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license		 http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

// Check to ensure this file is included in Joomla!
if (!(defined('_JEXEC') || defined('ABSPATH'))) {	 die('Restricted access'); };

// Probably should work toward extending the JFBConnectFacebookLibrary for this class.
// Too much intertwined in the root library right now.
class JFBConnectProfileYahoo extends JFBConnectProfile
{
    public function fetchProfile($userId, $fields = NULL)
    {
        $profile = new JFBConnectProfileDataYahoo();

        try
        {
            // User is set in bearer access token
            $url = 'https://api.login.yahoo.com/openid/v1/userinfo';
            $jdata = $this->provider->client->query($url);

            if($jdata->code == 200)
            {
                $data = json_decode($jdata->body, true);
                $profile->loadObject($data);
            }
        }
        catch (Exception $e)
        {
            if (JFBCFactory::config()->get('facebook_display_errors'))
            {
                JFBCFactory::log($e->getMessage());
            }
        }
        return $profile;
    }

    // nullForDefault - If the avatar is the default image for the social network, return null instead
    // Prevents the default avatars from being imported
    function getAvatarUrl($userId, $nullForDefault = true, $params = null)
    {
        $nullString = $nullForDefault ? 'null' : 'notnull';
        $avatarUrl = JFBCFactory::cache()->get('yahoo.avatar.' . $nullString . '.' . $userId);
        if ($avatarUrl === false)
        {
            $profile = $this->fetchProfile($userId);
            $avatarUrl = $profile->get('picture', null);
            if ($nullForDefault && (!$avatarUrl || strpos($avatarUrl, 'https://s.yimg.com/dg/users')))
            {
                $avatarUrl = null;
            }
            JFBCFactory::cache()->store($avatarUrl, 'yahoo.avatar.' . $nullString . '.' . $userId);
        }
        return $avatarUrl;
    }
}

class JFBConnectProfileDataYahoo extends JFBConnectProfileData
{
    public function get($path, $default = NULL)
    {
        switch (strtolower($path)) {
            case 'email':
                $data = parent::get('email', $default);
                break;
            case 'name':
            case 'full_name':
                $data = parent::get('given_name', $default) . ' ' . parent::get('family_name', $default);
                break;
            case 'first_name':
            case 'given_name':
                $data = parent::get('given_name', $default);
                break;
            case 'surname':
            case 'last_name':
            case 'family_name':
                $data = parent::get('family_name', $default);
                break;
            default:
                if ($this->exists($path))
                {
                    $data = parent::get($path, $default);
                }
                else
                {
                    $data = NULL;
                }
        }

        if (!is_null($data))
        {
            // format or manipulate the data as necessary here
            return $data;
        }
        else
        {
            return $default;
        }
    }

}