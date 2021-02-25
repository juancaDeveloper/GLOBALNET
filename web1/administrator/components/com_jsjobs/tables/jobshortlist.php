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
class Tablejobshortlist extends JTable {

    var $id = null;
    var $uid = null;
    var $jobid = null;
    var $comments = null;
    var $rate = null;
    var $created = null;
    var $status = null;
    var $sharing = 0; // by default sharing value is 0 its one when sharing on

    function __construct(&$db) {
        parent::__construct('#__js_job_jobshortlist', 'id', $db);
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
