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
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelConfiguration extends JSModel {

    var $_config = null;
    var $_siteurl = null;
    var $_data_directory = null;
    var $_comp_editor = null;
    var $_job_editor = null;
    var $_defaultcountry = null;

    function __construct() {
        parent::__construct();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getConfig() {
        if (isset($this->_config) == false) {
            $db = $this->getDBO();
            $query = "SELECT * FROM `#__js_job_config`";
            $db->setQuery($query);
            $this->_config = $db->loadObjectList();
            foreach ($this->_config as $conf) {
                if ($conf->configname == "defaultcountry") {
                    $this->_defaultcountry = $conf->configvalue;
                } elseif ($conf->configname == "job_editor")
                    $this->_job_editor = $conf->configvalue;
                elseif ($conf->configname == "comp_editor")
                    $this->_comp_editor = $conf->configvalue;
                elseif ($conf->configname == "data_directory")
                    $this->_data_directory = $conf->configvalue;
            }
        }
        return $this->_config;
    }

    function getConfigurationsForForm() {
        if (isset($this->_config) == false) {
            $db = $this->getDBO();
            $query = "SELECT * FROM `#__js_job_config`";
            $db->setQuery($query);
            $this->_config = $db->loadObjectList();
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == "defaultcountry") {
                $this->_defaultcountry = $conf->configvalue;
            } elseif ($conf->configname == "employer_defaultpackage")
                $employer_defaultpackage = $conf->configvalue;
            elseif ($conf->configname == "jobseeker_defaultpackage")
                $jobseeker_defaultpackage = $conf->configvalue;
            elseif ($conf->configname == "data_directory")
                $this->_data_directory = $conf->configvalue;
            elseif ($conf->configname == "jobseeker_defaultgroup")
                $jobseeker_defaultgroup = $conf->configvalue;
            elseif ($conf->configname == "employer_defaultgroup")
                $employer_defaultgroup = $conf->configvalue;
            elseif ($conf->configname == "default_sharing_country")
                $default_sharing_country = $conf->configvalue;
            elseif ($conf->configname == "default_sharing_state")
                $default_sharing_state = $conf->configvalue;
            elseif ($conf->configname == "default_sharing_city")
                $default_sharing_city = $conf->configvalue;
            elseif ($conf->configname == "system_timeout")
                $system_timeout = $conf->configvalue;
        }
        $countries = $this->getJSModel('country')->getSharingCountries(JText::_('Select Country'));
        if (empty($default_sharing_country))
            $default_sharing_country = 0;
        if (empty($default_sharing_state))
            $default_sharing_state = 0;
        if (empty($default_sharing_city))
            $default_sharing_city = 0;
        if ($default_sharing_state != 0)
            $states = $this->getJSModel('state')->getDefaultStatesForSharing(JText::_('Select State'), $default_sharing_country);
        if (($default_sharing_state != 0) AND ( $default_sharing_city != 0)) {
            $cities = $this->getJSModel('state')->getDefaultStateCitiesForSharing(JText::_('Select City'), $default_sharing_state);
        } elseif (($default_sharing_city != 0) AND ( $default_sharing_country != 0)) {
            $cities = $this->getJSModel('city')->getDefaultCitiesForSharing(JText::_('Select City'), $default_sharing_country);
        }
        $joomla_groups = $this->getJSModel('jsjobs')->getUserGroups();
        $employerpackages = $this->getJSModel('employerpackages')->getFreeEmployerPackageForCombo(JText::_('No'));
        $jobseekerpacakges = $this->getJSModel('jobseekerpackages')->getFreeJobSeekerPackageForCombo(JText::_('No'));
        $system_timeoutarray = $this->getTimeoutArray();
        $lists['defaultcountry'] = JHTML::_('select.genericList', $countries, 'defaultcountry', 'class="inputbox" ' . '', 'value', 'text', $this->_defaultcountry);
        $lists['defaultsharingcountry'] = JHTML::_('select.genericList', $countries, 'default_sharing_country', 'class="inputbox" ' . 'onChange="dochange(\'defaultsharingstate\', this.value)"', 'value', 'text', $default_sharing_country);
        if (isset($states[1]))
            $lists['defaultsharingstate'] = JHTML::_('select.genericList', $states, 'default_sharing_state', 'class="inputbox" ' . 'onChange="dochange(\'defaultsharingcity\', this.value)"', 'value', 'text', $default_sharing_state);
        if (isset($cities[1]))
            $lists['defaultsharingcity'] = JHTML::_('select.genericList', $cities, 'default_sharing_city', 'class="inputbox" ' . '', 'value', 'text', $default_sharing_city);
        $lists['employer_defaultpackage'] = JHTML::_('select.genericList', $employerpackages, 'employer_defaultpackage', 'class="inputbox" ' . '', 'value', 'text', $employer_defaultpackage);
        $lists['jobseeker_defaultpackage'] = JHTML::_('select.genericList', $jobseekerpacakges, 'jobseeker_defaultpackage', 'class="inputbox" ' . '', 'value', 'text', $jobseeker_defaultpackage);
        $lists['jobseeker_group'] = JHTML::_('select.genericList', $joomla_groups, 'jobseeker_defaultgroup', 'class="inputbox" ' . '', 'value', 'text', $jobseeker_defaultgroup);
        $lists['employer_group'] = JHTML::_('select.genericList', $joomla_groups, 'employer_defaultgroup', 'class="inputbox" ' . '', 'value', 'text', $employer_defaultgroup);


        $result[0] = $this->_config;
        $result[1] = $lists;
        return $result;
    }

    function getTimeoutArray() {
        $array = array(array('value' => '-24 hours', 'text' => '-24:00'), array('value' => '-23 hours 30 minutes', 'text' => '-23:30'), array('value' => '-23 hours', 'text' => '-23:00'), array('value' => '-22 hours 30 minutes', 'text' => '-22:30'), array('value' => '-22 hours', 'text' => '-22:00'), array('value' => '-21 hours 30 minutes', 'text' => '-21:30'), array('value' => '-21 hours', 'text' => '-21:00'), array('value' => '-20 hours 30 minutes', 'text' => '-20:30'), array('value' => '-20 hours', 'text' => '-20:00'), array('value' => '-19 hours 30 minutes', 'text' => '-19:30'), array('value' => '-19 hours', 'text' => '-19:00'), array('value' => '-18 hours 30 minutes', 'text' => '-18:30'), array('value' => '-18 hours', 'text' => '-18:00'), array('value' => '-17 hours 30 minutes', 'text' => '-17:30'), array('value' => '-17 hours', 'text' => '-17:00'), array('value' => '-16 hours 30 minutes', 'text' => '-16:30'), array('value' => '-16 hours', 'text' => '-16:00'), array('value' => '-15 hours 30 minutes', 'text' => '-15:30'), array('value' => '-15 hours', 'text' => '-15:00'), array('value' => '-14 hours 30 minutes', 'text' => '-14:30'), array('value' => '-14 hours', 'text' => '-14:00'), array('value' => '-13 hours 30 minutes', 'text' => '-13:30'), array('value' => '-13 hours', 'text' => '-13:00'), array('value' => '-12 hours 30 minutes', 'text' => '-12:30'), array('value' => '-12 hours', 'text' => '-12:00'), array('value' => '-11 hours 30 minutes', 'text' => '-11:30'), array('value' => '-11 hours', 'text' => '-11:00'), array('value' => '-10 hours 30 minutes', 'text' => '-10:30'), array('value' => '-10 hours', 'text' => '-10:00'), array('value' => '-09 hours 30 minutes', 'text' => '-09:30'), array('value' => '-09 hours', 'text' => '-09:00'), array('value' => '-08 hours 30 minutes', 'text' => '-08:30'), array('value' => '-08 hours', 'text' => '-08:00'), array('value' => '-07 hours 30 minutes', 'text' => '-07:30'), array('value' => '-07 hours', 'text' => '-07:00'), array('value' => '-06 hours 30 minutes', 'text' => '-06:30'), array('value' => '-06 hours', 'text' => '-06:00'), array('value' => '-05 hours 30 minutes', 'text' => '-05:30'), array('value' => '-05 hours', 'text' => '-05:00'), array('value' => '-04 hours 30 minutes', 'text' => '-04:30'), array('value' => '-04 hours', 'text' => '-04:00'), array('value' => '-03 hours 30 minutes', 'text' => '-03:30'), array('value' => '-03 hours', 'text' => '-03:00'), array('value' => '-02 hours 30 minutes', 'text' => '-02:30'), array('value' => '-02 hours', 'text' => '-02:00'), array('value' => '-01 hours 30 minutes', 'text' => '-01:30'), array('value' => '-01 hours', 'text' => '-01:00'), array('value' => '-00 hours 30 minutes', 'text' => '-00:30'), array('value' => '', 'text' => '00:00'), array('value' => '+00 hours 30 minutes', 'text' => '+00:30'), array('value' => '+01 hours', 'text' => '+01:00'), array('value' => '+01 hours 30 minutes', 'text' => '+01:30'), array('value' => '+02 hours', 'text' => '+02:00'), array('value' => '+02 hours 30 minutes', 'text' => '+02:30'), array('value' => '+03 hours', 'text' => '+03:00'), array('value' => '+03 hours 30 minutes', 'text' => '+03:30'), array('value' => '+04 hours', 'text' => '+04:00'), array('value' => '+04 hours 30 minutes', 'text' => '+04:30'), array('value' => '+05 hours', 'text' => '+05:00'), array('value' => '+05 hours 30 minutes', 'text' => '+05:30'), array('value' => '+06 hours', 'text' => '+06:00'), array('value' => '+06 hours 30 minutes', 'text' => '+06:30'), array('value' => '+07 hours', 'text' => '+07:00'), array('value' => '+07 hours 30 minutes', 'text' => '+07:30'), array('value' => '+08 hours', 'text' => '+08:00'), array('value' => '+08 hours 30 minutes', 'text' => '+08:30'), array('value' => '+09 hours', 'text' => '+09:00'), array('value' => '+09 hours 30 minutes', 'text' => '+09:30'), array('value' => '+10 hours', 'text' => '+10:00'), array('value' => '+10 hours 30 minutes', 'text' => '+10:30'), array('value' => '+11 hours', 'text' => '+11:00'), array('value' => '+11 hours 30 minutes', 'text' => '+11:30'), array('value' => '+12 hours', 'text' => '+12:00'), array('value' => '+12 hours 30 minutes', 'text' => '+12:30'), array('value' => '+13 hours', 'text' => '+13:00'), array('value' => '+13 hours 30 minutes', 'text' => '+13:30'), array('value' => '+14 hours', 'text' => '+14:00'), array('value' => '+14 hours 30 minutes', 'text' => '+14:30'), array('value' => '+15 hours', 'text' => '+15:00'), array('value' => '+15 hours 30 minutes', 'text' => '+15:30'), array('value' => '+16 hours', 'text' => '+16:00'), array('value' => '+16 hours 30 minutes', 'text' => '+16:30'), array('value' => '+17 hours', 'text' => '+17:00'), array('value' => '+17 hours 30 minutes', 'text' => '+17:30'), array('value' => '+18 hours', 'text' => '+18:00'), array('value' => '+18 hours 30 minutes', 'text' => '+18:30'), array('value' => '+19 hours', 'text' => '+19:00'), array('value' => '+19 hours 30 minutes', 'text' => '+19:30'), array('value' => '+20 hours', 'text' => '+20:00'), array('value' => '+20 hours 30 minutes', 'text' => '+20:30'), array('value' => '+21 hours', 'text' => '+21:00'), array('value' => '+21 hours 30 minutes', 'text' => '+21:30'), array('value' => '+22 hours', 'text' => '+22:00'), array('value' => '+22 hours 30 minutes', 'text' => '+22:30'), array('value' => '+23 hours', 'text' => '+23:00'), array('value' => '+23 hours 30 minutes', 'text' => '+23:30'), array('value' => '+24 hours', 'text' => '+24:00'));
        return $array;
    }

    function getConfigur() {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__js_job_config WHERE configname = 'refercode' OR configname = 'versioncode' OR configname = 'versiontype'";
        $db->setQuery($query);
        $confs = $db->loadObjectList();
        foreach ($confs AS $conf) {
            if ($conf->configname == 'refercode')
                $rcode = $conf->configvalue;
            if ($conf->configname == 'versioncode')
                $vcode = $conf->configvalue;
            if ($conf->configname == 'versiontype')
                $vtype = $conf->configvalue;
        }
        if ($rcode == '0') {
            $row = $this->getTable('config');
            $reser_med = date('misyHd');
            $reser_med = md5($reser_med);
            $reser_med = md5($reser_med);
            $reser_med = substr($reser_med, 0, 10);
            $string = md5(time());
            $reser_start = substr($string, 0, 5);
            $reser_end = substr($string, 4, 3);
            $value = $reser_start . $reser_med . $reser_end;

            $config['configname'] = 'refercode';
            $config['configvalue'] = $value;
            if (!$row->bind($config)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
            if (!$row->store()) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
        } else
            $value = $rcode;

        $result[0] = $value;
        $result[1] = $vcode;
        $result[2] = $vtype;

        return $result;
    }

    function storeConfig() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $row = $this->getTable('config');
        $data = JRequest::get('post');
        $config = array();
        if($data['applybuttonredirecturl']!=""){
            if (! (strpos($data['applybuttonredirecturl'],"http://") !== false)) {
                $data['applybuttonredirecturl'] = 'http://'.$data['applybuttonredirecturl'];
            }
        }

        if( ! $data['data_directory'])
            $data['data_directory'] = 'jsjobsdata';

        if ($data['notgeneralbuttonsubmit'] != 1) {
            if (!isset($data['employer_share_fb_like']))
                $data['employer_share_fb_like'] = 0;
            if (!isset($data['jobseeker_share_fb_like']))
                $data['jobseeker_share_fb_like'] = 0;
            if (!isset($data['employer_share_fb_share']))
                $data['employer_share_fb_share'] = 0;
            if (!isset($data['jobseeker_share_fb_share']))
                $data['jobseeker_share_fb_share'] = 0;
            if (!isset($data['employer_share_fb_comments']))
                $data['employer_share_fb_comments'] = 0;
            if (!isset($data['jobseeker_share_fb_comments']))
                $data['jobseeker_share_fb_comments'] = 0;
            if (!isset($data['employer_share_google_like']))
                $data['employer_share_google_like'] = 0;
            if (!isset($data['jobseeker_share_google_like']))
                $data['jobseeker_share_google_like'] = 0;
            if (!isset($data['employer_share_google_share']))
                $data['employer_share_google_share'] = 0;
            if (!isset($data['jobseeker_share_google_share']))
                $data['jobseeker_share_google_share'] = 0;
            if (!isset($data['employer_share_blog_share']))
                $data['employer_share_blog_share'] = 0;
            if (!isset($data['jobseeker_share_blog_share']))
                $data['jobseeker_share_blog_share'] = 0;
            if (!isset($data['employer_share_friendfeed_share']))
                $data['employer_share_friendfeed_share'] = 0;
            if (!isset($data['jobseeker_share_friendfeed_share']))
                $data['jobseeker_share_friendfeed_share'] = 0;
            if (!isset($data['employer_share_linkedin_share']))
                $data['employer_share_linkedin_share'] = 0;
            if (!isset($data['jobseeker_share_linkedin_share']))
                $data['jobseeker_share_linkedin_share'] = 0;
            if (!isset($data['employer_share_digg_share']))
                $data['employer_share_digg_share'] = 0;
            if (!isset($data['jobseeker_share_digg_share']))
                $data['jobseeker_share_digg_share'] = 0;
            if (!isset($data['employer_share_twitter_share']))
                $data['employer_share_twitter_share'] = 0;
            if (!isset($data['jobseeker_share_twiiter_share']))
                $data['jobseeker_share_twiiter_share'] = 0;
            if (!isset($data['employer_share_myspace_share']))
                $data['employer_share_myspace_share'] = 0;
            if (!isset($data['jobseeker_share_myspace_share']))
                $data['jobseeker_share_myspace_share'] = 0;
            if (!isset($data['employer_share_yahoo_share']))
                $data['employer_share_yahoo_share'] = 0;
            if (!isset($data['jobseeker_share_yahoo_share']))
                $data['jobseeker_share_yahoo_share'] = 0;
        }
        $db = $this->getDbo();
        foreach ($data as $key => $value) {
            $query = "UPDATE `#__js_job_config` SET `configvalue` = " . $db->quote($value) . " WHERE `configname` = " . $db->quote($key) . ";";
            $db->setQuery($query);
            $db->query();
        }

        if(isset($_FILES['companydefaultlogo'])){
            $str = JPATH_BASE;
            $base = substr($str, 0, strlen($str) - 14); //remove administrator
            if (!isset($this->_config))
                $this->_config = $this->getConfig();
            foreach ($this->_config as $conf) {
                if ($conf->configname == 'data_directory')
                    $datadirectory = $conf->configvalue;
                if ($conf->configname == 'image_file_type')
                    $image_file_types = $conf->configvalue;
            }
            $path = $base . '/' . $datadirectory;
            if (!file_exists($path)) { // create user directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/data';
            if (!file_exists($path)) { // create user directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/default_logo_company';
            if (!file_exists($path)) { // create user directory
                $this->getJSModel('common')->makeDir($path);
            }

            $isupload = false;
            if ($_FILES['companydefaultlogo']['size'] > 0) {
                $file_name = $_FILES['companydefaultlogo']['name']; // file name
                $file_tmp = $_FILES['companydefaultlogo']['tmp_name']; // actual location
                if ($file_name != '' AND $file_tmp != "") {
                    $check_image_extension = $this->getJSModel('common')->checkImageFileExtensions($file_name, $file_tmp, $image_file_types);
                    if ($check_image_extension == 1) {
                        $isupload = true;
                    }
                }
            }
            if ($isupload) {
                $userpath = $path;
                $files = glob($userpath . '/*.*');
                array_map('unlink', $files);  //delete all file in directory
                if(move_uploaded_file($file_tmp, $userpath . '/' . $file_name)){
                    $key = 'companydefaultlogopath';
                    $value = $datadirectory.'/data/default_logo_company/'.$file_name;
                    $query = "UPDATE `#__js_job_config` SET `configvalue` = " . $db->quote($value) . " WHERE `configname` = " . $db->quote($key) . ";";
                    $db->setQuery($query);
                    $db->query();
                }
            }
        }

        return true;
    }

    function getConfigByFor($configfor) {
        $db = $this->getDBO();

        $query = "SELECT * FROM `#__js_job_config` WHERE configfor = " . $db->quote($configfor);

        $db->setQuery($query);
        $config = $db->loadObjectList();
        $configs = array();
        foreach ($config as $conf) {
            $configs[$conf->configname] = $conf->configvalue;
        }

        return $configs;
    }

    function makeDefaultTheme($id, $defaultvalue) {
        if (is_numeric($id) == false)
            return false;
        if (is_numeric($defaultvalue) == false)
            return false;
        switch ($id) {
            case '1':$theme = "black/css/jsjobsblack.css";
                break;
            case '2':$theme = "pink/css/jsjobspink.css";
                break;
            case '3':$theme = "orange/css/jsjobsorange.css";
                break;
            case '4':$theme = "golden/css/jsjobsgolden.css";
                break;
            case '5':$theme = "blue/css/jsjobsblue.css";
                break;
            case '6':$theme = "gray/css/jsjobsgray.css";
                break;
            case '7':$theme = "green/css/jsjobsgreen.css";
                break;
            case '8':$theme = "graywhite/css/jsjobsgraywhite.css";
                break;
            case '9':$theme = "template/css/jsjobstemplate.css";
                break;
        }
        $db = $this->getDBO();
        $query = "update `#__js_job_config` as config SET config.configvalue = " . $db->quote($theme) . " WHERE config.configname = 'theme'";

        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        return true;
    }

    function getCheckCronKey() {
        $db = $this->getDbo();
        $query = "SELECT configvalue FROM `#__js_job_config` WHERE configname = " . $db->quote('cron_job_alert_key');
        $db->setQuery($query);
        $key = $db->loadResult();
        if ($key)
            return true;
        else
            return false;
    }

    function genearateCronKey() {
        $key = md5(date('Y-m-d'));
        $db = $this->getDbo();
        $query = "UPDATE `#__js_job_config` SET configvalue = " . $db->quote($key) . " WHERE configname = " . $db->quote('cron_job_alert_key');
        $db->setQuery($query);
        if (!$db->query()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
        } else
            return true;
    }

    function getCronKey($passkey) {
        if ($passkey == md5(date('Y-m-d'))) {
            $db = $this->getDbo();
            $query = "SELECT configvalue FROM `#__js_job_config` WHERE configname = " . $db->quote('cron_job_alert_key');
            $db->setQuery($query);
            $key = $db->loadResult();
            return $key;
        } else
            return false;
    }

    function getCountConfig() {
        $db = $this->getDbo();
        $query = "SELECT COUNT(*) FROM `#__js_job_config`";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function getConfigValue($configname) {
        $db = $this->getDbo();
        $query = "SELECT configvalue FROM `#__js_job_config` WHERE configname = " . $db->quote($configname);
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function isTestMode() {
        $db = $this->getDbo();
        $query = "SELECT configvalue FROM `#__js_job_config` WHERE configname = 'testing_mode'";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function storeTheme() {
        $data = JRequest::get('post');
        $filepath = JPATH_COMPONENT_SITE . '/css/style_color.php';
        $filestring = file_get_contents($filepath);
        $this->replaceString($filestring, 1, $data);
        $this->replaceString($filestring, 2, $data);
        $this->replaceString($filestring, 3, $data);
        $this->replaceString($filestring, 4, $data);
        $this->replaceString($filestring, 5, $data);
        $this->replaceString($filestring, 6, $data);
        $this->replaceString($filestring, 7, $data);
        $this->replaceString($filestring, 8, $data);
        $script_content = "
            function draw() {
                var objects = document.getElementsByClassName('canvas_color_bg');
                for (var i = 0; i < objects.length; i++){
                    var canvas = objects[i];
                    if (canvas.getContext){
                      var ctx = canvas.getContext('2d');
                      ctx.fillStyle = \"" . $data['color3'] . "\";
                      ctx.beginPath();
                      ctx.moveTo(0,0);
                      ctx.lineTo(10,10);
                      ctx.lineTo(0,20);
                      ctx.fill();
                    }
                }
                var objects = document.getElementsByClassName('canvas_white_bg');
                for (var i = 0; i < objects.length; i++){
                    var canvas = objects[i];
                    if (canvas.getContext){
                      var ctx = canvas.getContext('2d');
                      ctx.fillStyle = \"#FFFFFF\";
                      ctx.beginPath();
                      ctx.moveTo(0,0);
                      ctx.lineTo(10,10);
                      ctx.lineTo(0,20);
                      ctx.fill();
                    }
                }
            }
            window.onload = function(){
                draw();
            }";

        $pathfile = JPATH_SITE . '/components/com_jsjobs/js/canvas_script.js';
        file_put_contents($pathfile, $script_content);
        if (file_put_contents($filepath, $filestring)) {
            return true;
        } else {
            return false;
        }
    }

    function replaceString(&$filestring, $colorNo, $data) {
        if (strstr($filestring, '$color' . $colorNo)) {
            $path1 = strpos($filestring, '$color' . $colorNo);
            $path2 = strpos($filestring, ';', $path1);
            $filestring = substr_replace($filestring, '$color' . $colorNo . ' = "' . $data['color' . $colorNo] . '";', $path1, $path2 - $path1 + 1);
        }
    }

    function getColorCode($filestring, $colorNo) {
        if (strstr($filestring, '$color' . $colorNo)) {
            $path1 = strpos($filestring, '$color' . $colorNo);
            $path1 = strpos($filestring, '#', $path1);
            $path2 = strpos($filestring, ';', $path1);
            $colorcode = substr($filestring, $path1, $path2 - $path1 - 1);
            return $colorcode;
        }
    }

    function getCurrentTheme() {
        $filepath = JPATH_COMPONENT_SITE . '/css/style_color.php';
        $filestring = file_get_contents($filepath);
        $theme['color1'] = $this->getColorCode($filestring, 1);
        $theme['color2'] = $this->getColorCode($filestring, 2);
        $theme['color3'] = $this->getColorCode($filestring, 3);
        $theme['color4'] = $this->getColorCode($filestring, 4);
        $theme['color5'] = $this->getColorCode($filestring, 5);
        $theme['color6'] = $this->getColorCode($filestring, 6);
        $theme['color7'] = $this->getColorCode($filestring, 7);
        $theme['color8'] = $this->getColorCode($filestring, 8);
        return $theme;
    }

}

?>