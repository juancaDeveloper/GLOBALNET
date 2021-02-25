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

class TableShortListCandidate extends JTable {

    /** @var int Primary key */
    var $id = null;
    var $uid = null;
    var $jobid = null;
    var $jobseekerid = null;
    var $cvid = null;
    var $status = null;
    var $created = null;

    function __construct(&$db) {
        parent::__construct('#__js_job_shortlistcandidates', 'id', $db);
    }

    function check() {
        return true;
    }

}

?>