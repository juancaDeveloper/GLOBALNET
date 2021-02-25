<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

if (!(defined('_JEXEC') || defined('ABSPATH'))) {     die('Restricted access'); };

class TableUserMap extends JTable
{
    public $id = null;
    public $created_at = null;
    public $updated_at = null;
    public $authorized = 1;

    public $j_user_id = null;
    public $provider_user_id = null;
    public $provider = null;
    public $access_token = null;
    public $params = null;

    function __construct(&$db)
    {
        parent::__construct('#__jfbconnect_user_map', 'id', $db);
    }
}