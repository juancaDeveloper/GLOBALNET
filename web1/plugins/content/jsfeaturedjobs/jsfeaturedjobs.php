<?php

/**
  + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , info@burujsolutions.com
  www.joomsky.com, ahmad@joomsky.com
 * Created on:	Aug 25, 2010
  ^
  + Project: 		JS Jobs
 * File Name:	Pplugin/jsfeaturedjobs.php
  ^
 * Description: Plugin for JS Jobs
  ^
 * History:		NONE
  ^
 */
defined('_JEXEC') or die('Restricted access');

// Import Joomla! Plugin library file
jimport('joomla.plugin.plugin');
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

//The Content plugin Loadmodule
class plgContentJSFeaturedJobs extends JPlugin {  //for joomla 1.5

    public function onPrepareContent(&$row, &$params, $page = 0) {
        if (JString::strpos($row->text, 'jsfeaturedjobs') === false) {
            return true;
        }

        // expression to search for
        $regex = '/{jsfeaturedjobs\s*.*?}/i';
        if (!$this->params->get('enabled', 1)) {
            $row->text = preg_replace($regex, '', $row->text);
            return true;
        }
        preg_match_all($regex, $row->text, $matches);
        $count = count($matches[0]);
        if ($count) {
            // Get plugin parameters
            $style = $this->params->def('style', -2);
            $this->_process($row, $matches, $count, $regex, $style);
        }
    }

//	 for joomla 1.6
    public function onContentPrepare($context, &$row, &$params, $page = 0) {
        if (JString::strpos($row->text, 'jsfeaturedjobs') === false) {
            return true;
        }

        // expression to search for
        $regex = '/{jsfeaturedjobs\s*.*?}/i';
        if (!$this->params->get('enabled', 1)) {
            $row->text = preg_replace($regex, '', $row->text);
            return true;
        }
        preg_match_all($regex, $row->text, $matches);
        $count = count($matches[0]);
        if ($count) {
            // Get plugin parameters
            $style = $this->params->def('style', -2);
            $this->_process($row, $matches, $count, $regex, $style);
        }
    }

    protected function _process(&$row, &$matches, $count, $regex, $style) {
        for ($i = 0; $i < $count; $i++) {
            $load = str_replace('jsfeaturedjobs', '', $matches[0][$i]);
            $load = str_replace('{', '', $load);
            $load = str_replace('}', '', $load);
            $load = trim($load);

            $modules = $this->_load($load, $style);
            $row->text = preg_replace('{' . $matches[0][$i] . '}', $modules, $row->text);
        }
        $row->text = preg_replace($regex, '', $row->text);
    }

    protected function _load($position, $style = -2) {
        $document = JFactory::getDocument();
        $version = new JVersion;
        $joomla = $version->getShortVersion();
        $jversion = substr($joomla,0,3);
        if($jversion < 3){
                $document->addScript('components/com_jsjobs/js/jquery.js');
                JHtml::_('behavior.mootools');
        }else{
                JHtml::_('behavior.framework');
                JHtml::_('jquery.framework');
        }	
        
        $document->addStyleSheet(JPATH_ROOT.'components/com_jsjobs/css/style.css', 'text/css');
        require_once(JPATH_ROOT.'/components/com_jsjobs/css/style_color.php');
        $language = JFactory::getLanguage();
        if($language->isRtl()){
            $document->addStyleSheet(JPATH_ROOT.'components/com_jsjobs/css/style_rtl.css', 'text/css');
        }

        $result['noofjobs'] = $this->params->get('noofjobs', 7);
        $result['category'] = $this->params->get('category', 1);
        $result['subcategory'] = $this->params->get('subcategory', 1);
        $result['company'] = $this->params->get('company', 1);
        $result['jobtype'] = $this->params->get('jobtype', 1);
        $result['posteddate'] = $this->params->get('posteddate', 1);
        $result['theme'] = $this->params->get('theme', 1);
        $result['separator'] = $this->params->get('separator', 1);
        $result['moduleheight'] = $this->params->get('moduleheight','400').'px';
        $result['jobsinrow'] = $this->params->get('jobsinrow',1);
        $result['jobsinrowtab'] = $this->params->get('jobsinrowtab',1);
        $result['jobfloat'] = $this->params->get('jobfloat',0);
        $result['location'] = $this->params->get('location',1);
        $result['jobmargintop'] = $this->params->get('jobmargintop','10').'px';
        $result['jobmarginleft'] = $this->params->get('jobmarginleft','10').'px';
        $result['companylogo'] = $this->params->get('companylogo',1);
        $result['logodatarow'] = $this->params->get('logodatarow',2);
        $result['datacolumn'] = $this->params->get('datacolumn',1);
        if($result['datacolumn'] == 0) $result['datacolumn'] = 1;
        $result['listtype'] = $this->params->get('listtype','1');
        $result['jobheight'] = $this->params->get('jobheight','200');
        $result['companylogowidth'] = $this->params->get('companylogowidth','150');
        $result['companylogoheight'] = $this->params->get('companylogoheight','90');
        $result['moduleclass_sfx'] = $this->params->get('moduleclass_sfx');

        $result['title'] = $this->params->get('title');
        $result['showtitle'] = $this->params->get('showtitle');
        $result['speedTest'] = $this->params->get('speed',5);
        /** scs */
        if($this->params->get('Itemid')) $result['itemid'] = $this->params->get('Itemid');          
        else $result['itemid'] =  JRequest::getVar('Itemid');

        $lang = JFactory::getLanguage();
        $dump = $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        $componentPath =  'components/com_jsjobs/';
        require_once $componentPath.'JSApplication.php';
        //scs
        $result['sliding'] = $this->params->get('sliding',0);
        $result['consecutivesliding'] = $this->params->get('consecutivesliding',0);
        $result['slidingdirection'] = $this->params->get('slidingdirection',0); // 0 = left  , 1=up
        
        $color = array();
        $color[1] = $this->params->get('color1');
        $color[2] = $this->params->get('color2');
        $color[3] = $this->params->get('color3');
        $color[4] = $this->params->get('color4');
        $color[5] = $this->params->get('color5');
        $color[6] = $this->params->get('color6');
        $result['color'] = $color;

        //sce
        $jobresult = JSModel::getJSModel('job')->getFeaturedJobs($result['noofjobs'], $result['theme']);
        $result['jobs'] = $jobresult[0];
        $result['dateformat'] = $jobresult[2];
        $result['data_directory'] = $jobresult[3];
        /** sce */
        $lang = JFactory::getLanguage();
        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        $contentswrapperstart = '';
        $finalcontent = '';
        $classname = 'jsfeaturedjobs'.uniqid();
        $content = JSModel::getJSModel('listjobs')->listModuleJobs($classname,$result['jobs'],$result['location'],$result['showtitle'],$result['title'],$result['listtype'],$result['noofjobs'],$result['category'],$result['subcategory'],$result['company'],$result['jobtype'],$result['posteddate'],$result['theme'],$result['separator'],$result['moduleheight'],$result['jobsinrow'],$result['jobsinrowtab'],$result['jobmargintop'],$result['jobmarginleft'],$result['companylogo'],$result['logodatarow'],$result['sliding'],$result['datacolumn'],$result['speedTest'],$result['slidingdirection'],$result['dateformat'],$result['data_directory'],$result['consecutivesliding'],$result['moduleclass_sfx'],$result['itemid'],$result['jobheight'],$result['companylogowidth'],$result['companylogoheight']);
        $content .= '<style>';
        if(isset($result['color'][1]) && !empty($result['color'][1])){
            $content .= 'div.'.$classname.' div#jsjobs_module span#themeanchor a{color:'.$result['color'][1].';}';
        }
        if(isset($result['color'][2]) && !empty($result['color'][2])){
            $content .= 'div.'.$classname.' div#jsjobs_module{background:'.$result['color'][2].';}';
            $content .= 'div.'.$classname.' div#jsjobs_modulelist_databar{background:'.$result['color'][2].';}';
            $content .= 'div.'.$classname.' div#jsjobs_modulelist_titlebar{background:'.$result['color'][2].';}';
        }
        if(isset($result['color'][3]) && !empty($result['color'][3])){
            $content .= 'div.'.$classname.' div#jsjobs_module{border: 1px solid '.$result['color'][3].';}';
            $content .= 'div.'.$classname.' div#jsjobs_modulelist_titlebar{border: 1px solid '.$result['color'][3].';}';
            $content .= 'div.'.$classname.' div#jsjobs_modulelist_databar{border: 1px solid '.$result['color'][3].';}';
        } 
        if(isset($result['color'][4]) && !empty($result['color'][4])) {
            $content .= 'div#jsjobs_module_wrapper.'.$classname.' div#jsjobs_module_wrap div#jsjobs_module_data_fieldwrapper span#jsjobs_module_data_fieldtitle{color:'.$result['color'][4].';}';
            $content .= 'div.'.$classname.' div#jsjobs_modulelist_databar{color:'.$result['color'][4].';}';
            $content .= 'div.'.$classname.' div#jsjobs_modulelist_titlebar span#jsjobs_modulelist_titlebar{color:'.$result['color'][4].';}';
        } 
        if(isset($result['color'][5]) && !empty($result['color'][5])) {
            $content .= 'div#jsjobs_module_wrapper.'.$classname.' div#jsjobs_module_wrap div#jsjobs_module_data_fieldwrapper span#jsjobs_module_data_fieldvalue{color:'.$result['color'][5].';}';
        } 
        if(isset($result['color'][6]) && !empty($result['color'][6])) {
            $content .= 'div.'.$classname.'  div#jsjobs_module span#jsjobs_module_heading {border-bottom: 1px solid '.$result['color'][6].';}';
        }
        $content .= '</style>';
        echo $content;
	}
}
?>