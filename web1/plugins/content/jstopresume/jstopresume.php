<?php

/**
  + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , info@burujsolutions.com
  www.joomsky.com, ahmad@joomsky.com
 * Created on:	Dec 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	Pplugin/jsnewestresume.php
  ^
 * Description: Plugin for JS Jobs
  ^
 * History:		1.0.1 - Nov 27, 2010
  ^
 */
defined('_JEXEC') or die('Restricted access');

// Import Joomla! Plugin library file
jimport('joomla.plugin.plugin');
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

//The Content plugin Loadmodule
class plgContentJSTopResume extends JPlugin {

    // for joomla 1.5	
    public function onPrepareContent(&$row, &$params, $page = 0) {
        if (JString::strpos($row->text, 'jstopresume') === false) {
            return true;
        }

        // expression to search for
        $regex = '/{jstopresume\s*.*?}/i';
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

    // for joomla 1.6
    public function onContentPrepare($context, &$row, &$params, $page = 0) {
        if (JString::strpos($row->text, 'jstopresume') === false) {
            return true;
        }

        // expression to search for
        $regex = '/{jstopresume\s*.*?}/i';
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
            $load = str_replace('jstopresume', '', $matches[0][$i]);
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

        $result['logodatarow'] = $this->params->get('logodatarow',2);
        $result['noofresumes'] = $this->params->get('noofresumes', 7);
        $result['applicationtitle'] = $this->params->get('applicationtitle', 1);
        $result['name'] = $this->params->get('name', 1);
        $result['experience'] = $this->params->get('experience', 1);
        $result['available'] = $this->params->get('available', 1);
        $result['gender'] = $this->params->get('gender', 1);
        $result['nationality'] = $this->params->get('nationality', 1);
        $result['location'] = $this->params->get('location', 1);
        $result['category'] = $this->params->get('category', 1);
        $result['subcategory'] = $this->params->get('subcategory', 1);
        $result['workpreference'] = $this->params->get('workpreference', 1);
        $result['resumephoto'] = $this->params->get('resumephoto', 1);
        $result['posteddate'] = $this->params->get('posteddate', 1);
        $result['separator'] = $this->params->get('separator', 1);
        $result['resumesinrow'] = $this->params->get('resumesinrow',1);
        $result['resumesinrowtab'] = $this->params->get('resumesinrowtab',1);
        $result['moduleheight'] = $this->params->get('moduleheight', '400') . 'px';
        $result['resumeheight'] = $this->params->get('resumeheight', '200') . 'px';
        $result['resumemargintop'] = $this->params->get('resumemargintop', '10') . 'px';
        $result['resumemarginleft'] = $this->params->get('resumemarginleft', '10') . 'px';
        $result['photowidth'] = $this->params->get('photowidth', '200') . 'px';
        $result['photoheight'] = $this->params->get('photoheight', '50') . 'px';
        $result['datacolumn'] = $this->params->get('datacolumn', '2');
        if($result['datacolumn'] == 0) $result['datacolumn'] = 1;
        $result['listtype'] = $this->params->get('listtype', '1');
        $result['title'] = $this->params->get('title');
        $result['showtitle'] = $this->params->get('showtitle');
        $result['speedTest'] = $this->params->get('speed', 5);
        $result['moduleclass_sfx'] = $this->params->get('moduleclass_sfx', '');
        /** scs */
        if($this->params->get('Itemid')) $result['itemid'] = $this->params->get('Itemid');          
        else $result['itemid'] =  JRequest::getVar('Itemid');

        $lang = JFactory::getLanguage();
        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        
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
        $resumeresult = JSModel::getJSModel('resume')->getTopResumes($result['noofresumes'], true);
        $result['resumes'] = $resumeresult[0];
        $result['dateformat'] = $resumeresult[2];
        $result['data_directory'] = $resumeresult[3];
        /** sce */
        $lang = JFactory::getLanguage();
        $lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
        $classname = 'jstopresume'.uniqid();
        $content = JSModel::getJSModel('listjobs')->listModuleResumes($classname,$result['noofresumes'],$result['applicationtitle'],$result['name'],$result['experience'],$result['available'],$result['gender'],$result['nationality'],$result['location'],$result['category'],$result['subcategory'],$result['workpreference'],$result['posteddate'],$result['separator'],$result['moduleheight'],$result['resumeheight'],$result['resumemargintop'],$result['resumemarginleft'],$result['photowidth'],$result['photoheight'],$result['datacolumn'],$result['listtype'],$result['title'],$result['showtitle'],$result['speedTest'],$result['itemid'],$result['sliding'],$result['consecutivesliding'],$result['slidingdirection'],$result['resumes'],$result['dateformat'],$result['data_directory'],$result['moduleclass_sfx'],$result['resumephoto'],$result['resumesinrow'],$result['resumesinrowtab'],$result['logodatarow'],$result['workpreference']);
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
        

        return $content;   
    }

}

?>
