<?php
/*
 * @version		$Id: model.php 3.5.0 2020-01-25 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2020 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access ');

jimport( 'joomla.application.component.model' );

class AllVideoShareModel extends JModelLegacy {
	
	public static function addIncludePath( $path = '', $prefix = '' ) {	
		return parent::addIncludePath( $path, $prefix );		
	}

}