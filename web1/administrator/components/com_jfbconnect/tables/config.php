<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

if (!(defined('_JEXEC') || defined('ABSPATH'))) {     die('Restricted access'); };

/* Deprecated for TableJFBConnectConfig table. Keep in installation for now because of Joomla error on installation */
class TableConfig extends JTable
{
	public $id = null;

	public $setting = null;
	public $value = null;

	public $created_at = null;
	public $updated_at = null;

	function __construct(&$db)
	{
		parent::__construct('#__jfbconnect_config', 'id', $db);
	}
}