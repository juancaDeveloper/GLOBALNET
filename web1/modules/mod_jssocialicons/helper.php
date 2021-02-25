<?php
/**
 * @package   JS Easy Social Icons
 * @copyright 2016 Open Source Training, LLC. All rights reserved.
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die('Direct access to files is not permitted');

class SocialIconsHelper
{


    //defines all the supported sites (alphabetical order)
    protected $sites = array(
        'delicious'   => 'http://delicious.com/%s',
        'digg'        => 'http://digg.com/%s',
        'dribbble'    => 'http://dribbble.com/shots/%s',
        'facebook'    => 'http://facebook.com/%s',
        'flickr'      => 'http://flickr.com/photos/%s',
        'foursquare'  => 'http://foursquare.com/%s',
        'google-plus' => 'http://plus.google.com/%s',
        'instagram'   => 'http://instagram.com/%s',
        'lastfm'      => 'http://www.last.fm/user/%s',
        'linkedin'    => 'http://www.linkedin.com/%s',
		'meetup'      => 'https://www.meetup.com/%s',
        'pinterest'   => 'http://pinterest.com/%s',
        'stumbleupon' => 'http://www.stumbleupon.com/stumbler/%s',
        'tumblr'      => 'http://%s.tumblr.com',
        'twitter'     => 'http://twitter.com/%s',
        'vimeo'       => 'http://www.vimeo.com/%s',
        'vine'        => 'http://vine.co/u/%s',
        'youtube'     => 'http://youtube.com/channel/%s',
        'yelp'        => 'http://yelp.com/biz/%s',
    );

    //returns the $sites array, optionally sorted using a jQuery Sortable serialization
    public function getSites($order = null)
    {
        if ($order === null || $order === '') {
            return $this->sites;
        }

        //convert the $order expression to an array
        //the original format is sort=[network]&sort=[network]...
        //eg: sort[]=twitter&sort[]=youtube

        parse_str($order, $sort);

        //copy the original array because we'll be unseting values (and dont' want to mess with the original)
        $temp    = $this->sites;
        $ordered = array();

        foreach ($sort['sort'] as $site_name) {
            if (isset($temp[$site_name])) {
                $ordered[$site_name] = $temp[$site_name];
                unset($temp[$site_name]);
            }
        }

        //do we have something left on the $sites copy?
        if (count($temp) > 0) {
            //append it at the end
            $ordered = array_merge($ordered, $temp);
        }


        return $ordered;
    }
}
