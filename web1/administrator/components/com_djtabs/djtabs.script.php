<?php
/**
 * @version 1.0
 * @package DJ-Tabs
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Piotr Dobrakowski - piotr.dobrakowski@design-joomla.eu
 *
 * DJ-Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Tabs. If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die('Restricted access');

class com_djtabsInstallerScript {
	function postflight($type, $parent)
	{
		if($type == 'update') {
		
			defined('DS') or define('DS', DIRECTORY_SEPARATOR);
			
			$path = JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'router.php';
			if(JFile::exists($path)) {
				@unlink($path);
			}
		
			require_once(JPath::clean(JPATH_BASE.'/components/com_djtabs/lib/djlicense.php'));
			DJLicense::setUpdateServer('Tabs');
		}
	}
}