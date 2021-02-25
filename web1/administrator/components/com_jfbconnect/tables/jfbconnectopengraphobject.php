<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

if (!(defined('_JEXEC') || defined('ABSPATH'))) {     die('Restricted access'); };

class TableJFBConnectOpenGraphObject extends JTable
{
	public $id = null;
    public $plugin = null;
    public $system_name = null;
    public $display_name = null;
    public $type = null;
    public $published = 0;
    public $params = "";
    public $created = null;
    public $modified = null;

	function __construct(&$db)
	{
		parent::__construct('#__opengraph_object', 'id', $db);
	}
}