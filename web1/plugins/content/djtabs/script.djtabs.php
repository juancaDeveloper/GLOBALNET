<?php
class plgContentDjtabsInstallerScript
{
    public function __constructor(JAdapterInstance $adapter)
    {
    }
	function postflight( $type, $parent ) {
			
		if($type == 'install') {
			
			$db = JFactory::getDBO();
			$db->setQuery("UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND element='djtabs' AND folder='content'");
			$db->query();
		}
	}
    
}
?>