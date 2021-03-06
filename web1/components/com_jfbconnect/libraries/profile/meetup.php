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

// Probably should work toward extending the JFBConnectFacebookLibrary for this class.
// Too much intertwined in the root library right now.
class JFBConnectProfileMeetup extends JFBConnectProfile
{
    /* Fetch a user's profile based on the passed in array of fields
    * @return JRegistry with profile field values
    */
    public function fetchProfile($userId, $fields = array(), $only = array())
    {
        if (!is_array($fields))
            $fields = array($fields);

        $unsetFields = array('full_name', 'first_name', 'last_name', 'middle_name');

        foreach($unsetFields as $unsetField)
        {
            if(in_array($unsetField, $fields))
            {
                unset($fields[array_search($unsetField, $fields)]);
            }
        }

        $fields = array_unique($fields);

        $profile = new JFBConnectProfileDataMeetup();
        $url = 'https://api.meetup.com/2/member/'.$userId;

        if(!empty($fields)) {
            $url .= '?fields=' . implode(',', $fields);
        }

        if(!empty($only)) {
            if (!is_array($only))
                $only = array($only);

            $only = array_unique($only);
            $url .= empty($fields) ? '?only=' . implode(',', $only) : '&only=' . implode(',', $only);
        }
        try
        {
            $jdata = $this->provider->client->query($url);

            if ($jdata->code == 200)
            {
                $data = json_decode($jdata->body, true);
                $profile->loadObject($data);
            }
        }
        catch (Exception $e)
        {
            if (JFBCFactory::config()->get('facebook_display_errors'))
                JFBCFactory::log($e->getMessage());
        }

        return $profile;
    }

    // nullForDefault - If the avatar is the default image for the social network, return null instead
    // Prevents the default avatars from being imported
    function getAvatarUrl($providerUserId, $nullForDefault = true, $params = null)
    {
        $nullString = $nullForDefault ? 'null' : 'notnull';
        $avatarUrl = JFBCFactory::cache()->get('meetup.avatar.' . $nullString . '.' . $providerUserId);
        if ($avatarUrl === false)
        {
            //get token from the usermap
            $token = $this->provider->client->getToken();
            if(empty($token)) {
                $token = $this->getUserAccessToken($providerUserId);
                $this->provider->client->setToken($token);
            }

            //meetup doesnt return photo if avatar is not available
            $profile = $this->fetchProfile($providerUserId, '', 'photo');
            $avatarUrl = $profile->get('photo.thumb_link');

            if (!$avatarUrl)
                $avatarUrl = null;

            JFBCFactory::cache()->store($avatarUrl, 'meetup.avatar.' . $providerUserId);
        }
        return $avatarUrl;
    }

    function getProfileUrl($providerUserId)
    {
        //get token from the usermap
        $token = $this->provider->client->getToken();
        if(empty($token)) {
            $token = $this->getUserAccessToken($providerUserId);
            $this->provider->client->setToken($token);
        }

        $profile = $this->fetchProfile($providerUserId, '', 'link');
        $profile_url = $profile->get('link');

        return $profile_url;
    }

    private function getUserAccessToken($providerUserId)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select($db->qn('access_token'))
            ->from('#__jfbconnect_user_map')
            ->where($db->qn('provider') . ' = ' . $db->q($this->provider->systemName))
            ->where($db->qn('provider_user_id') . ' = ' . $db->q($providerUserId));
        $db->setQuery($query);
        $token = $db->loadResult();
        if ($token) {
            $token = (array)json_decode($token);
        }
        return $token;
    }

}

class JFBConnectProfileDataMeetup extends JFBConnectProfileData
{
    public function get($path, $default = "")
    {
        $data = null;
        if($this->exists($path))
        {
            if ($path == 'joined')
            {
                $data = parent::get('joined');
                $data = intval($data / 1000); //convert from milliseconds
                $jdate = new JDate($data);
                $data = $jdate->format(JText::_('DATE_FORMAT_LC'));
            }
            else if($path == 'birthday')
            {
                $birthday = parent::get('birthday');
                //Return in Y-m-d format
                $data = $birthday->year.'-'.$birthday->month.'-'.$birthday->day;
            }
            else
            {
                $parts = explode('.', $path);

                if($parts[0] == 'other_services')
                {
                    $other_services = parent::get($parts[0]);
                    $services = array('facebook', 'twitter', 'linkedin', 'flickr', 'tumblr');
                    if($parts[1] == 'facebook' && isset($other_services->facebook))
                    {
                        $data = 'https://www.facebook.com/'.intval($other_services->facebook->identifier);
                    }
                    else if($parts[1] == 'twitter' && isset($other_services->twitter))
                    {
                        $data = strpos($other_services->twitter->identifier, '@') ? 'http://twitter.com/'.str_replace('@', '', $other_services->twitter->identifier) : $other_services->twitter->identifier;
                    }
                    else
                    {
                        $data = $default;
                    }
                }
                else if ($parts[0] == 'photo')
                {
                    //photo_link, highres_link, thumb_link
                    $photo = parent::get($parts[0]);
                    $photos = array('photo_link', 'highres_link', 'thumb_link');
                    $data = in_array($parts[1], $photos) && isset($photo->$parts[1]) ? $photo->$parts[1] : $default;
                }
                else
                    $data = parent::get($path, $default);
            }
        }
        else
        {
            if ($path == "full_name")
            {
                $data = parent::get('name', $default);
            }
            else if ($path == 'first_name')
            {
                $data = parent::get('name');
                $data = substr($data, 0, strpos($data, " "));
            }
            else if ($path == 'last_name')
            {
                $data = parent::get('name');
                $data = substr($data, strpos($data, " ") + 1);
            }
            else if ($path == "middle_name")
            {
                $data =  "";
            }
            else
            {
                return $default;
            }

        }

        return !is_null($data) ? $data : $default;

    }

}