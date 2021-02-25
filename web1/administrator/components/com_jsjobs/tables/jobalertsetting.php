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

class TableJobAlertSetting extends JTable {

    /** @var int Primary key */
    var $id = null;
    var $uid = null;
    var $categoryid = null;
    var $subcategoryid = null;
    var $contactemail = null;
    var $country = null;
    var $state = null;
    var $county = null;
    var $city = null;
    var $zipcode = null;
    var $sendtime = null;
    var $status = null;
    var $created = null;
    var $keywords = null;
    var $alerttype = null;

    function __construct(&$db) {
        parent::__construct('#__js_job_jobalertsetting', 'id', $db);
    }

}

?>
