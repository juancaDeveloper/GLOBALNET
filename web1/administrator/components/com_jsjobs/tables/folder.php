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
class Tablefolder extends JTable {

    var $id = null;
    var $uid = null;
    var $globel = null;
    var $jobid = null;
    var $paymenthistoryid = null;
    var $name = null;
    var $alias = null;
    var $decription = null;
    var $status = 0;
    var $created = null;

    function __construct(&$db) {
        parent::__construct('#__js_job_folders', 'id', $db);
    }

    /**
     * Validation
     * 
     * @return boolean True if buffer is valid
     * 
     */
    function check() {
        if (trim( $this->name ) == '') {
          return false;
        } elseif (trim( $this->decription) == '') {
          return false;
        }
        return true;
    }

}

?>
