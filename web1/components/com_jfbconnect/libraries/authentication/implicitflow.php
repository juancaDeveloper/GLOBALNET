<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Google
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

//JLoader::register('JFBConnectAuthenticationOauth2Base', JPATH_SITE . '/components/com_jfbconnect/libraries/authentication/oauth2base.php');

/**
 * Google OAuth authentication class
 *
 * @package     Joomla.Platform
 * @subpackage  Google
 * @since       12.3
 */
class JFBConnectAuthenticationImplicitflow extends JFBConnectAuthenticationOauth2
{
    public function authenticate()
    {
        $input = JFactory::getApplication()->input;
        $token = $input->getRaw('access_token', null);
        if ($token)
        {
            $token = ['access_token' => $token];
            $this->setToken($token);
            return true;
        }
        return false;
    }
}