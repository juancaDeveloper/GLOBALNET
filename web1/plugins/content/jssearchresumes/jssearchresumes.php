<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Al-Barr Technologies
 + Contact:		www.al-barr.com , info@al-barr.com
			www.joomsky.com, ahmad@joomsky.com
 * Created on:	Dec 11, 2009
 ^
 + Project: 		JS Jobs 
 * File Name:	Pplugin/jssearchjobs.php
 ^ 
 * Description: Plugin for JS Jobs
 ^ 
 * History:		NONE
 ^ 
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Import Joomla! Plugin library file
jimport('joomla.plugin.plugin');
 if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}

//The Content plugin Loadmodule
class plgContentJSSearchResumes extends JPlugin
{
	// for joomla 1.5
	public function onPrepareContent( &$row, &$params, $page=0 )  {
		if ( JString::strpos( $row->text, 'jssearchresumes' ) === false ) {
                        return true;
		}
              // expression to search for
                $regex = '/{jssearchresumes\s*.*?}/i';
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
		public function onContentPrepare( $context, &$row, &$params, $page=0 )
        {
                if ( JString::strpos( $row->text, 'jssearchresumes' ) === false ) {
                        return true;
                }

              // expression to search for
                $regex = '/{jssearchresumes\s*.*?}/i';
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

        protected function _process( &$row, &$matches, $count, $regex, $style )
        {
                for ( $i=0; $i < $count; $i++ )
                {
                        $load = str_replace( 'jssearchresumes', '', $matches[0][$i] );
                        $load = str_replace( '{', '', $load );
                        $load = str_replace( '}', '', $load );
                        $load = trim( $load );
 
                        $modules       = $this->_load( $load, $style );
                        $row->text         = preg_replace( '{'. $matches[0][$i] .'}', $modules, $row->text );
                }
                $row->text = preg_replace( $regex, '', $row->text );
        }

        protected function _load( $position, $style=-2 )
        {
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
                $renderer      = $document->loadRenderer('module');
                $params                = array('style'=>$style);
 
                $db = JFactory::getDBO();
				$lang = JFactory::getLanguage();
				$lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
				$showtitle = $this->params->get('shtitle', 1);
				$title = $this->params->get('title', 1);
				$sh_name = $this->params->get('name', 1);
				$sh_nationality = $this->params->get('natinality', 1);
				$sh_gender = $this->params->get('gender', 1);
				$sh_iamavailable = $this->params->get('iamavailable', 1);

				$sh_category = $this->params->get('category', 1);
				$sh_subcategory = $this->params->get('subcategory', 1);
				$sh_jobtype = $this->params->get('jobtype', 1);
				$sh_salaryrange = $this->params->get('salaryrange', 1);
				$sh_heighesteducation = $this->params->get('heighesteducation', 1);
				$sh_experience = $this->params->get('experience', 1);
				$colperrow = $this->params->get('colperrow', 3);


				$colwidth = Round(100/$colperrow,1);
				$colwidth = $colwidth.'%';
				$colcount = 1;

				//scs				
				if($this->params->get('Itemid')) $itemid = $this->params->get('Itemid');			
				else  $itemid =  JRequest::getVar('Itemid');
				$componentPath =  JPATH_SITE.'/components/com_jsjobs/';
				require_once $componentPath.'/JSApplication.php';
				$divclass=array('odd','even');
				$result = JSModel::getJSModel('resume')->resumesearch($sh_gender,$sh_nationality,$sh_category,$sh_subcategory,$sh_jobtype,$sh_heighesteducation,$sh_salaryrange,1);

				$gender = isset($result[0]) ? $result[0] : 0;
				$nationality = isset($result[1]) ? $result[1] : 0;
				$job_categories = isset($result[2]) ? $result[2] : 0;
				$job_type = isset($result[3]) ? $result[3] : 0;
				$heighest_finisheducation= isset($result[4]) ? $result[4] : 0;
				$salary_range = isset($result[5]) ? $result[5] : 0;
				$currency = isset($result[6]) ? $result[6] : 0;
				$job_subcategories = isset($result[7]) ? $result[7] : 0;
				$expmin = isset($result[8]) ? $result[8] : 0;
				$expmax = isset($result[9]) ? $result[9] : 0;
				//sce
                                $contents = '';
			    if($showtitle == 1){
	                $contents = '
	                            <div id="tp_heading">
	                                <span id="tp_headingtext">
	                                        <span id="tp_headingtext_left"></span>
	                                        <span id="tp_headingtext_center">'.$title.'</span>
	                                        <span id="tp_headingtext_right"></span>				
	                                </span>
	                            </div>
	                        ';
			    }

				$contents .= '<form class="jsautoz_form" action="index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid='.$itemid.'" method="post" name="js-jobs-form-mod" id="js-jobs-form-mod">';
				$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
								      <div class="text-left">
								        '.JText::_('Application title').'
								      </div>
								      <div class="text-left">
								        <input class="inputbox" type="text" name="title" size="27" maxlength="255"  />
								      </div>
						    	</div>';
				if ( $sh_name == 1 ) {
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Name').'
										      </div>
										      <div class="text-left">
										        <input class="inputbox" type="text" name="name" size="27" maxlength="255"  />
										      </div>
								    	</div>';
				}
				if ( $sh_nationality == 1 ) { if($colcount == $colperrow){ $contents .= '</tr><tr>'; $colcount = 0; } $colcount++; 
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Nationality').'
										      </div>
										      <div class="text-left">
										        '.$nationality.'
										      </div>
								    	</div>';
				}
				if ( $sh_gender == 1 ) { if($colcount == $colperrow){ $contents .= '</tr><tr>'; $colcount = 0; } $colcount++; 
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Gender').'
										      </div>
										      <div class="text-left">
										        '.$gender.'
										      </div>
								    	</div>';
				}

				if ( $sh_category == 1 ) { if($colcount == $colperrow){ $contents .= '</tr><tr>'; $colcount = 0; } $colcount++; 
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Categories').'
										      </div>
										      <div class="text-left">
										        '.$job_categories.'
										      </div>
								    	</div>';
				}
				if ( $sh_subcategory == 1 ) { if($colcount == $colperrow){ $contents .= '</tr><tr>'; $colcount = 0; } $colcount++;
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Sub categories').'
										      </div>
										      <div class="text-left" id="plgresumefj_subcategory">
										        '.$job_subcategories.'
										      </div>
								    	</div>';
				}
				if ( $sh_jobtype == 1 ) { if($colcount == $colperrow){ $contents .= '</tr><tr>'; $colcount = 0; } $colcount++; 
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Job type').'
										      </div>
										      <div class="text-left">
										        '.$job_type.'
										      </div>
								    	</div>';
				}
				if ( $sh_salaryrange == 1 ) { if($colcount == $colperrow){ $contents .= '</tr><tr>'; $colcount = 0; } $colcount++; 
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Salary range').'
										      </div>
										      <div class="text-left">
										        '.$currency.' '.$salary_range.'
										      </div>
								    	</div>';
				}
				if ( $sh_heighesteducation == 1 ) { if($colcount == $colperrow){ $contents .= '</tr><tr>'; $colcount = 0; } $colcount++; 
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Highest education').'
										      </div>
										      <div class="text-left">
										        '.$heighest_finisheducation.'
										      </div>
								    	</div>';
				}
				if ( $sh_experience == 1 ) { if($colcount == $colperrow){ $contents .= '</tr><tr>'; $colcount = 0; } $colcount++; 
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Experience').'
										      </div>
										      <div class="text-left">
										        '.$expmin.$expmax.'
										      </div>
								    	</div>';
				}
				if ( $sh_iamavailable == 1 ) { if($colcount == $colperrow){ $contents .= '</tr><tr>'; $colcount = 0; } $colcount++; 
						$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
										      <div class="text-left">
										        '.JText::_('Available').'
										      </div>
										      <div class="text-left">
										        <input type="checkbox" name="iamavailable" value="1"  />
										      </div>
								    	</div>';
				}
				$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'"><input id="button" type="submit" class="button" name="submit_app" onclick="document.prsadminForm.submit();" value="'. JText::_('Search resume').'" />&nbsp;&nbsp;&nbsp;<span id="themeanchor"><a id="button" style="white-space:nowrap;" class="button minpad" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resumesearch&Itemid='.$itemid.'">'.JText::_('Advanced search').'</a></span></div>';
	 			$contents .= '<input type="hidden" name="isresumesearch" value="1" />';
				$contents .= '<input type="hidden" name="view" value="resume" />';
				$contents .= '<input type="hidden" name="layout" value="resume_searchresults" />';
				$contents .= '<input type="hidden" name="option" value="com_jsjobs" />';
				$contents .= '<input type="hidden" name="zipcode" value="" />';
				$contents .= '</form>'."<script language=\"javascript\" type=\"text/javascript\"> function plgfj_getsubcategories(src, val){
                                                                    var xhr;
                                                                    try {  xhr = new ActiveXObject('Msxml2.XMLHTTP');   }
                                                                    catch (e){
                                                                            try {   xhr = new ActiveXObject('Microsoft.XMLHTTP');    }
                                                                            catch (e2) {
                                                                              try {  xhr = new XMLHttpRequest();     }
                                                                              catch (e3) {  xhr = false;   }
                                                                            }
                                                                     }

                                                                    xhr.onreadystatechange = function(){
                                                                        if(xhr.readyState == 4 && xhr.status == 200){
                                                                            document.getElementById(src).innerHTML=xhr.responseText; //retuen value
                                                                        }
                                                                    }

                                                                    xhr.open(\"GET\",\"index.php?option=com_jsjobs&c=subcategory&task=listsubcategoriesForSearch&val=\"+val+\"&md=\"+1,true);
                                                                    xhr.send(null);
                                                            }</script>";
               return $contents;
        }
}



?>
