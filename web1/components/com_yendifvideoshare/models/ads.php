<?php
/*
 * @version		$Id: ads.php 1.2.8 2019-01-10 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2012-2019 Yendif Player
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class YendifVideoShareModelAds extends YendifVideoShareModel {

    public function getPlayer() {
        $app = JFactory::getApplication();	
        $db = JFactory::getDBO();
        
        $query = 'SELECT * FROM #__yendifvideoshare_videos WHERE published=1 AND id=' . $app->input->getInt( 'id' );
        $db->setQuery( $query );
        $player = $db->loadObject();

		
        // Fallback to the default player profile
        if ( empty( $player ) ) {
            $query = 'SELECT * FROM #__yendifvideoshare_videos WHERE id=1';
            $db->setQuery( $query );
            $player = $db->loadObject();
        }
        
        return $player;        
    }

    public function getPrerollId() {	
        $db = JFactory::getDBO();
		$item =  $this->getPlayer();	 
        $query = "SELECT id FROM #__yendifvideoshare_adverts WHERE published=1 AND (type=" . $db->Quote( 'preroll' ) . " OR type=" . $db->Quote( 'both' ) . ")";
		
		if( $item->preroll == -1 ) {
			$query .= " ORDER BY RAND() LIMIT 1";
		} else {
			$query .= " AND id=" . $item->preroll;
		}
		
        $db->setQuery( $query );
        $id = $db->loadResult();
		
		return $id;  
    }

    public function getPostrollId() {	
        $db = JFactory::getDBO();
		$item =  $this->getPlayer();		 
        $query = "SELECT id FROM #__yendifvideoshare_adverts WHERE published=1 AND (type=" . $db->Quote( 'postroll' ) . " OR type=" . $db->Quote( 'both' ) . ") ";
		
		if( $item->postroll == -1 ) {
			$query .= " ORDER BY RAND() LIMIT 1";
		} else {
			$query .= " AND id=" . $item->postroll;
		}
        $db->setQuery( $query );
        $id = $db->loadResult();
		
		return $id;  
    }

    public function getAd() {	
        $app = JFactory::getApplication();
        $db = JFactory::getDBO();
                
        $query = 'SELECT * FROM #__yendifvideoshare_adverts WHERE published=1 AND id=' . $app->input->getInt( 'id' );
        $db->setQuery( $query );
        $ad = $db->loadObject();
    
        return $ad;   
    }

    public function impression() {
        $app = JFactory::getApplication();
		$db = JFactory::getDBO();
		$query = 'UPDATE #__yendifvideoshare_adverts SET impressions=impressions+1 WHERE id=' . $app->input->getInt( 'id' );
    	$db->setQuery( $query );
		$db->query();
    }

    public function click() {	
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();	
			
		$query = 'UPDATE #__yendifvideoshare_adverts SET clicks=clicks+1 WHERE id=' . $app->input->getInt( 'id' );
    	$db->setQuery( $query );
		$db->query();		
	}
   
}