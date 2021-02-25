<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

class JFBConnectProviderLinkedinChannelCompany extends JFBConnectChannel
{
    public function setup()
    {
        $this->name = "Company";
        $this->outbound = true;
        $this->inbound = true;
        $this->requiredScope[] = 'r_basicprofile';
        $this->requiredScope[] = 'rw_organization_admin';
        $this->requiredScope[] = 'r_organization_social';
        $this->requiredScope[] = 'w_organization_social';

        $this->postCharacterMax = '700';
        $this->postSuccessMessage = 'COM_JFBCONNECT_CHANNELS_LINKEDIN_STREAM_POST_SUCCESS';
    }

    public function canPublish($data)
    {
        $canPublish = false;

        $jid = $data['attribs']['user_id'];
        if ($jid)
        {
            $uid = JFBCFactory::usermap()->getProviderUserId($jid, 'linkedin');
            if ($uid && isset($data['attribs']['company_id']) && ($data['attribs']['company_id'] != '--')
                && $this->userHasToken($jid))
            {
                $canPublish = true;
            }
        }
        return $canPublish;
    }

    public static function getCompanyName($liLibrary, $orgId)
    {
        $orgId = str_replace('urn:li:organization:', '', $orgId);

        $nameUrl = 'https://api.linkedin.com/v2/organizations/'.$orgId.'?projection=(name)';

        $name = "ID:" . $orgId;
        try
        {
            $response = $liLibrary->query($nameUrl);
            if($response->code == '200')
            {
                $nameData = json_decode($response->body);
                $country = $nameData->name->preferredLocale->country;
                $language = $nameData->name->preferredLocale->language;
                $locale = $language .'_'.$country;
                $nameData = $nameData->name->localized->$locale;
                $name = ucfirst($nameData);
            }
        }
        catch (Exception $e)
        {
            print_r($e->getMessage());
        }

        return $name;
    }

    public static function getShareLink($liLibrary, $shareId)
    {
        $shareId = str_replace('urn:li:share:', '', $shareId);
        $shareUrl = 'https://api.linkedin.com/v2/shares/'.$shareId;

        $url = '';
        try
        {
            $response = $liLibrary->query($shareUrl);
            if($response->code == '200')
            {
                $nameData = json_decode($response->body);
                $url = 'https://www.linkedin.com/posts/'.$nameData->id;
            }
        }
        catch (Exception $e)
        {
            print_r($e->getMessage());
        }
        return $url;
    }

    private function userHasToken($jid)
    {
        $access_token = JFBCFactory::usermap()->getUserAccessToken($jid, 'linkedin');
        $params['access_token'] = $access_token;
        $liLibrary = JFBCFactory::provider('linkedin');
        $liLibrary->client->setToken((array)$access_token);

        $url = 'https://api.linkedin.com/v2/organizationalEntityAcls?q=roleAssignee';
        try
        {
            $companies = $liLibrary->query($url);
            if ($companies->code == '200')
            {
                $this->companies = json_decode($companies->body);
            }
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
        return true;
    }

    public function getStream($stream)
    {
        $user = $this->options->get('user_id');
        if (!$user)
            return;

        $companyId = $this->options->get('company_id');
        $companyName = self::getCompanyName($this->provider->client, $companyId);

        $feed = JFBCFactory::cache()->get('linkedin.stream.' . $companyId);
        if ($feed === false)
        {
            $access_token = JFBCFactory::usermap()->getUserAccessToken($user, 'linkedin');
            if (!is_object($access_token) || ($access_token->created + $access_token->expires_in < time()))
                return;

            $urn = urlencode('urn:li:organization:'. $companyId);
            $url = 'https://api.linkedin.com/v2/ugcPosts?q=authors&authors=List('.$urn.')';

            $this->provider->client->setToken((array)$access_token);
            try
            {
                $feedResponse = $this->provider->query($url, json_encode(array()), array(), 'get');
                if ($feedResponse->code != 200)
                    return;

                $feed = json_decode($feedResponse->body);
                JFBCFactory::cache()->store($feed, 'linkedin.stream.' . $companyId);
            }
            catch (Exception $e)
            {
                return;
            }
        }

        if(isset($feed->elements) && $feed->elements)
        {
            $public = 'com.linkedin.ugc.MemberNetworkVisibility';
            $shareContent = 'com.linkedin.ugc.ShareContent';

            foreach($feed->elements as $data)
            {
                if($data->lifecycleState == 'PUBLISHED' && $data->visibility->$public == 'PUBLIC')
                {
                    $post = new JFBConnectPost();

                    $post->message = $data->specificContent->$shareContent->shareCommentary->text;

                    $picData = isset($data->specificContent->$shareContent->media[0]) ? $data->specificContent->$shareContent->media[0]: null;
                    $pic = $picData->originalUrl;
                    if (strpos($pic, "slidesharecdn"))
                        $pic = str_replace("http://", "https://", $pic);
                    $post->thumbPicture = $pic;
                    $post->thumbDescription = $picData->description->text;
                    $post->thumbLink = $picData->thumbnails[0]->url;

                    //TODO URN
                    //$post->link = self::getShareLink($this->provider->client, $data->id);

                    //TODO URN
                    $post->authorScreenName = $companyName;
                    //$post->authorScreenName = $data->author;

                    /*if (isset($data->updateContent->companyJobUpdate))
                    {
                        $post->type = 'job-posting';
                        $post->message = isset($data->updateContent->companyJobUpdate->job->description) ? $data->updateContent->companyJobUpdate->job->description : "";
                        $post->jobLocation = isset($data->updateContent->companyJobUpdate->job->locationDescription) ? $data->updateContent->companyJobUpdate->job->locationDescription : "";
                        $post->jobPosition = isset($data->updateContent->companyJobUpdate->job->position->title) ? $data->updateContent->companyJobUpdate->job->position->title : "";
                        $post->link = isset($data->updateContent->companyJobUpdate->job->siteJobRequest->url) ? $data->updateContent->companyJobUpdate->job->siteJobRequest->url : "";
                    }
                    elseif (isset($data->updateContent->companyStatusUpdate))
                    {
                        $post->type = 'status-update';
                        $post->message = (isset($data->updateContent->companyStatusUpdate->share->comment) ? $data->updateContent->companyStatusUpdate->share->comment : "");
                        $post->thumbLink = (isset($data->updateContent->companyStatusUpdate->share->content->submittedUrl) ? $data->updateContent->companyStatusUpdate->share->content->submittedUrl : "");

                        $pic = (isset($data->updateContent->companyStatusUpdate->share->content->submittedImageUrl) ? $data->updateContent->companyStatusUpdate->share->content->submittedImageUrl : "");
                        if (strpos($pic, "slidesharecdn"))
                            $pic = str_replace("http://", "https://", $pic);

                        $post->thumbPicture = $pic;
                        $post->thumbDescription = (isset($data->updateContent->companyStatusUpdate->share->content->description) ? $data->updateContent->companyStatusUpdate->share->content->description : "");
                        $post->thumbCaption = (isset($data->updateContent->companyStatusUpdate->share->content->eyebrowUrl) ? $data->updateContent->companyStatusUpdate->share->content->eyebrowUrl : "");
                        $post->thumbTitle = (isset($data->updateContent->companyStatusUpdate->share->content->title) ? $data->updateContent->companyStatusUpdate->share->content->title : "");
                        $post->link = '';

                        //check if we have the correct update-key format
                        // update key format will be UPDATE-c[company_id]-[topic_id].. ex. UPDATE-c1441-5965553136775999488
                        if (isset($data->updateKey))
                        {
                            $keyA = explode('-', $data->updateKey);
                            if (strpos($data->updateKey, 'UPDATE') !== false && count($keyA) == 3)
                                $post->link = 'https://www.linkedin.com/nhome/updates?topic=' . $keyA[2];
                        }
                    }
*/
                    if (isset($data->lastModified))
                    {
                        $timestamp = intval($data->lastModified->time / 1000);
                        $post->updatedTime = gmdate($stream->options->get('datetime_format'), $timestamp);
                    }
                    else
                        $post->updatedTime = "";

                    $stream->addPost($post);
                }
            }
        }
    }

    public function performPost(JRegistry $data)
    {
        $user = $this->options->get('user_id');
        $access_token = JFBCFactory::usermap()->getUserAccessToken($user, 'linkedin');

        $this->provider->client->setToken((array)$access_token);

        $companyId = $this->options->get('company_id');

        $link = $data->get('link', '');
        $message = $data->get('message', '');

        $url = 'https://api.linkedin.com/v2/ugcPosts';
        $vals =
            <<<EOT
{
    "author": "urn:li:organization:{$companyId}",
    "lifecycleState": "PUBLISHED",
    "specificContent": {
        "com.linkedin.ugc.ShareContent": {
            "shareCommentary": {
                "text": "{$message}"
            },
            "shareMediaCategory": "ARTICLE",
            "media": [
                {
                    "status": "READY",
                    "originalUrl": "{$link}"
                }
            ]
        }
    },
    "visibility": {
        "com.linkedin.ugc.MemberNetworkVisibility": "PUBLIC"
    }
}
EOT;

        $return = $this->provider->query($url, $vals, array(), 'post');
        return $return;
    }
}
