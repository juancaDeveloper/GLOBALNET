<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
				www.joomsky.com, ahmad@joomsky.com
 * Created on:	Dec 30, 2010
 ^
 + Project: 		JS Jobs 
 * File Name:	module/jsjobcategories.php
 ^ 
 * Description: Module for JS Jobs
 ^ 
 * History:		1.0.0 - Dec 30, 2010
 ^ 
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');
 if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}

//The Content plugin Loadmodule
class plgContentJSJobsCountries extends JPlugin
{
	// for joomla 1.5
	public function onPrepareContent( &$row, &$params, $page=0 )  {
		if ( JString::strpos( $row->text, 'jsjobscountries' ) === false ) {
                        return true;
		}
              // expression to search for
                $regex = '/{jsjobscountries\s*.*?}/i';
                if ( !$this->params->get( 'enabled', 1 ) ) {
                        $row->text = preg_replace( $regex, '', $row->text );
                        return true;
                }
                preg_match_all( $regex, $row->text, $matches );
                $count = count( $matches[0] );
                if ( $count ) {
                        // Get plugin parameters
                        $style = $this->params->def( 'style', -2 );
                        $this->_process( $row, $matches, $count, $regex, $style );
                }
	}
		// for joomla 1.5
        public function onContentPrepare( $context, &$row, &$params, $page=0 ){
			if ( JString::strpos( $row->text, 'jsjobscountries' ) === false ) {
                        return true;
		}
              // expression to search for
                $regex = '/{jsjobscountries\s*.*?}/i';
                if ( !$this->params->get( 'enabled', 1 ) ) {
                        $row->text = preg_replace( $regex, '', $row->text );
                        return true;
                }
                preg_match_all( $regex, $row->text, $matches );
                $count = count( $matches[0] );
                if ( $count ) {
                        // Get plugin parameters
                        $style = $this->params->def( 'style', -2 );
                        $this->_process( $row, $matches, $count, $regex, $style );
                }
	}	
        protected function _process( &$row, &$matches, $count, $regex, $style )  {
                for ( $i=0; $i < $count; $i++ )
                {
                        $load = str_replace( 'jsjobscountries', '', $matches[0][$i] );
                        $load = str_replace( '{', '', $load );
                        $load = str_replace( '}', '', $load );
                        $load = trim( $load );

                        $modules       = $this->_load( $load, $style );
                        $row->text         = preg_replace( '{'. $matches[0][$i] .'}', $modules, $row->text );
                }
                $row->text = preg_replace( $regex, '', $row->text );
        }
        protected function _load( $position, $style=-2 ) {
                $document      = JFactory::getDocument();
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
                
                $renderer      = $document->loadRenderer('module');
                $params                = array('style'=>$style);
		$db = JFactory::getDBO();
		
		$noofrecord = $this->params->get('noofjobs', 10);
		if($noofrecord>100) $noofrecord=100;
		$showonlycountryhavejobs = $this->params->get('scohj', 1);
		$theme = $this->params->get('theme', 1);
		$showtitle = $this->params->get('shtitle');
		$title = $this->params->get('title');
		$colperrow = $this->params->get('colperrow',3);
		$separator= $this->params->get('separator');

		//sce
		$sliding= $this->params->get('sliding','0');
		$consecutivesliding= $this->params->get('consecutivesliding','0');
		$slidingdirection= $this->params->get('slidingdirection','1'); // 0 = left  , 1=up
		$slidingleftwidth= $this->params->get('slidingleftwidth','768'); 
		//sce

		$colwidth = Round(100/$colperrow,1);
		$colwidth = $colwidth.'%';
		/** scs */
		$componentPath =  JPATH_SITE.'/components/com_jsjobs';
		require_once $componentPath.'/JSApplication.php';
		$result = JSModel::getJSModel('countries')->getJobsCountry($showonlycountryhavejobs,$theme,$noofrecord);
		$countries = $result[0];
		$dateformat = $result[2];
		/** sce */

        $color = array();
        $color[1] = $this->params->get('color1');
        $color[2] = $this->params->get('color2');
        $color[3] = $this->params->get('color3');
        $colors = $color;

		//scs				
		if($this->params->get('Itemid')) $itemid = $this->params->get('Itemid');			
		else  $itemid =  JRequest::getVar('Itemid');
                $contentstitle = '';
		//sce
	if ($countries) { 
	    if($showtitle == 1){
	        $contentstitle = '
	                    <div id="tp_heading">
	                        <span id="tp_headingtext">
	                                <span id="tp_headingtext_left"></span>
	                                <span id="tp_headingtext_center">'.$title.'</span>
	                                <span id="tp_headingtext_right"></span>             
	                        </span>
	                    </div>
	                ';
	    }
	    $width = 'width:';
	    if($slidingdirection != 1 && $sliding == 1)
	    	$width .= $slidingleftwidth.'px;';
	    else
	    	$width .= '100%;';
	    $classname = 'country'.uniqid();
		$contentswrapperstart = '<div id="jsjobs_module_wrapper" class="'.$classname.'" style="width:100%;">';
		$contentswrapperend = '</div>';
	    $contents = '<div id="jsjobs_modulelist_databar" class="visible-all" style="'.$width.'">';
		if($colperrow == 0 || $colperrow == ''){
			$columnwidth = 0;
		}else{
			$columnwidth = 100 / $colperrow;			
		}
		if($columnwidth <= 0){
			$columnwidth = 30;
		}
		foreach ($countries as $country) {
			$lnks = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs&workpermit='. $country->countryid .'&lt=1&Itemid='.$itemid; 
			$lnks = JRoute::_($lnks);
			$contents .=  '<span id="jsjobs_modulelist_databar" class="module-list visible-all" style="width:'.$columnwidth.'%;"><span id="themeanchor"><a class="anchor" href="'.$lnks.'" >'.$country->countryname;
			$contents .=  ' ('. $country->totaljobsbycountry.')';
			$contents .=  '</a></span></span>';
		}
		$contents .= '</div>';
		if ($sliding == 1) {			
			if($slidingdirection == 1 ){			
				for ($a = 0; $a < $consecutivesliding; $a++){
					$contents .= $contents;
					}
				$contents =  $contentstitle.'<marquee id="mod_jsjobscountry"  direction="up" scrollamount="2" onmouseover="this.stop();" onmouseout="this.start()";>'.$contentswrapperstart.$contents.$contentswrapperend.'</marquee>';
				$contents = $contents.'<br clear="all">';
			}else{
				
				$tcontents = '<table cellpadding="0" cellspacing="0" border="1" width="100%" class="contentpane"> <tr>';
				$scontents = '';
				for ($a = 0; $a < $consecutivesliding; $a++){
					$scontents .= '<td>'.$contents.'</td>';
				}
				$contents = $tcontents.$scontents.'</tr></table>';
				$contents =  $contentstitle.'<marquee id="mod_jsjobscountry"  scrollamount="2" onmouseover="this.stop();" onmouseout="this.start()";>'.$contents.'</marquee>';
			}
			
			$contents = $contents;			
		}else{
			$contents = $contentstitle.$contentswrapperstart.$contents.$contentswrapperend;
		}
	}
	$contents .= '<style>';
    if(isset($colors[1]) && !empty($colors[1])){
        $contents .= 'div#jsjobs_module_wrapper.'.$classname.' a{color:'.$colors[1].';}';
    }
    if(isset($colors[2]) && !empty($colors[2])){
        $contents .= 'div.'.$classname.' div#jsjobs_module{background:'.$colors[2].';}';
        $contents .= 'div.'.$classname.' div#jsjobs_modulelist_databar{background:'.$colors[2].';}';
        $contents .= 'div.'.$classname.' div#jsjobs_modulelist_titlebar{background:'.$colors[2].';}';
    }
    if(isset($colors[3]) && !empty($colors[3])){
        $contents .= 'div.'.$classname.' div#jsjobs_module{border: 1px solid '.$colors[3].';}';
        $contents .= 'div.'.$classname.' div#jsjobs_modulelist_titlebar{border: 1px solid '.$colors[3].';}';
        $contents .= 'div.'.$classname.' div#jsjobs_modulelist_databar{border: 1px solid '.$colors[3].';}';
    }
	$contents .= '</style>';

	return $contents;

	}	
	
}
?>

