<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */

defined('_JEXEC') or die('Restricted access');

// our table class for the application data
class TableCity extends JTable {

   var $id = null;
   var $referenceid = null;
   var $referencefor = null;
   var $referencetype = null;
   var $status = null;
   var $startdate = null;
   var $enddate = null;
   var $created  = null;

  function __construct(&$db) {
        parent::__construct('#__js_job_goldfeaturedhistory', 'id', $db);
    }

    /**
     * Validation
     * 
     * @return boolean True if buffer is valid
     * 
     */
    function check() {
        return true;
    }

}

?>
