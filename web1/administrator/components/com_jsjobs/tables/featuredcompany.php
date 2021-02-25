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

class TableFeaturedCompany extends JTable {

    /** @var int Primary key */
    var $id = null;
    var $uid = null;
    var $packageid = null;
    var $companyid = null;
    var $startdate = null;
    var $enddate = null;
    var $status = null;
    var $created = null;

    function __construct(&$db) {
        parent::__construct('#__js_job_featuredcompanies', 'id', $db);
    }

    /**
     * Validation
     * 
     * @return boolean True if buffer is valid
     * 
     */
    /*
      function bind( $array, $ignore = '' )
      {
      if (key_exists( 'jobcategory', $array ) && is_array( $array['jobcategory'] )) {
      $array['jobcategory'] = implode( ',', $array['jobcategory'] );
      }
      return parent::bind( $array, $ignore );
      }
     */

    function check() {
        return true;
    }

}

?>
