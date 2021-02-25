<?php
/*
 * @version		$Id: ads.php 1.2.8 2019-03-10 $
 * @package		Yenidf Video Share
 * @copyright   Copyright (C) 2012-2019 Yenidfplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class YendifVideoShareControllerAds extends YendifVideoShareController {
	
	public function vast() {
		$model = $this->getModel( 'ads' );

	    $view = $this->getView( 'ads', 'xml' );	
		$view->setModel( $model, true );		
		$view->setLayout( 'vast' );
		$view->vast();
	}

	public function vmap() {
		$model = $this->getModel( 'ads' );
		
	    $view = $this->getView( 'ads', 'xml' );	
		$view->setModel( $model, true );		
		$view->setLayout( 'vmap' );
		$view->vmap();
	}

	public function impression() {
		$model = $this->getModel( 'ads' );
		$model->impression();
	}

	public function click() {
		$model = $this->getModel( 'ads' );
		$model->click();
	}
			
}