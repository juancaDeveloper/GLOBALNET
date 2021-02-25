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
class Tableresumerating extends JTable {

    var $id = null;
    var $uid = null;
    var $jobid = null;
    var $resumeid = null;
    var $rating = null;
    var $votes = null;
    var $meonly = 1;
    var $created = null;

    function __construct(&$db) {
        parent::__construct('#__js_job_resumerating', 'id', $db);
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
