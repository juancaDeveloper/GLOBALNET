<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
			www.joomsky.com, ahmad@joomsky.com
 * Created on:	Dec 11, 2009
 ^
 + Project: 		JS Jobs 
 * File Name:	Pplugin/jssearchjobs.php
 ^ 
 * Description: Plugin for JS Jobs
 ^ 
 * History:		1.0.1 - Nov 28, 2010
 ^ 
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Import Joomla! Plugin library file
jimport('joomla.plugin.plugin');
if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}

$document = JFactory::getDocument();
// $document->addScript( JURI::base() . '/includes/js/joomla.javascript.js');
 JHTML::_('behavior.calendar');

//The Content plugin Loadmodule
class plgContentJSSearchJobs extends JPlugin
{		
		// for joomla 1.5
		public function onPrepareContent( &$row, &$params, $page=0 )
        {
                if ( JString::strpos( $row->text, 'jssearchjobs' ) === false ) {
                        return true;
                }

              // expression to search for
                $regex = '/{jssearchjobs\s*.*?}/i';
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
		// for joomla 1.6
		public function onContentPrepare( $context, &$row, &$params, $page=0 )
        {
                if ( JString::strpos( $row->text, 'jssearchjobs' ) === false ) {
                        return true;
                }

              // expression to search for
                $regex = '/{jssearchjobs\s*.*?}/i';
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
                        $load = str_replace( 'jssearchjobs', '', $matches[0][$i] );
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
				$version = new JVersion;
				$joomla = $version->getShortVersion();
				$jversion = substr($joomla,0,3);
				if($jversion < 3){
					JHtml::_('behavior.mootools');
					$document->addScript('components/com_jsjobs/js/jquery.js');
				}else{
					JHtml::_('behavior.framework');
					JHtml::_('jquery.framework');
				}	
				$document->addStyleSheet('components/com_jsjobs/css/token-input-jsjobs.css');
				$document->addScript('components/com_jsjobs/js/jquery.tokeninput.js');

				$lang = JFactory::getLanguage();
				$lang->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);

				// Language variable start
				$jobtitle_title = JText::_('Job title');
				$jobstatustitle = JText::_('Job status');
				$salaryrangetitle = JText::_('Salary range');
				$fromtitle = JText::_('From');
				$totitle = JText::_('To');
				$shifttitle = JText::_('Shift');
				$durationtitle = JText::_('Duration');
				$startpublishingtitle = JText::_('Start publish');
				$stoppublishingtitle = JText::_('Stop publish');

				$companytitle = JText::_('Company');
				$citytitle = JText::_('City');
				$categorytitle = JText::_('Category');
				$subcategorytitle = JText::_('Sub category');
				$typetitle = JText::_('Job type');
				$searchjobtitle = JText::_('Search job');
				// Language variable end
				$showtitle = $this->params->get('shtitle', 1);
				$title = $this->params->get('title', 'Search Jobs');
				$sh_category = $this->params->get('category', 1);
				$sh_subcategory = $this->params->get('subcategory', 1);
				$sh_jobtype = $this->params->get('jobtype', 1);
				$sh_jobstatus = $this->params->get('jobstatus', 1);
				$sh_salaryrange = $this->params->get('salaryrange', 1);
				$sh_heighesteducation = $this->params->get('heighesteducation', 1);
				$sh_shift = $this->params->get('shift', 1);
				$sh_experience = $this->params->get('experience', 1);
				$sh_durration = $this->params->get('durration', 1);
				$sh_startpublishing = $this->params->get('startpublishing', 1);
				$sh_stoppublishing = $this->params->get('stoppublishing', 1);
				$sh_company = $this->params->get('company', 1);
				$sh_addresses = $this->params->get('addresses', 1);
				$colperrow = $this->params->get('colperrow', 3);


				$colwidth = Round(100/$colperrow,1);
				$colwidth = $colwidth.'%';
				$colcount = 1;
				//scs				
				if($this->params->get('Itemid')) $itemid = $this->params->get('Itemid');			
				else  $itemid =  JRequest::getVar('Itemid');
				//sce
				/** scs */
				$componentPath =  JPATH_SITE.'/components/com_jsjobs';
				require_once $componentPath.'/JSApplication.php';
				$result = JSModel::getJSModel('job')->jobsearch($sh_category,$sh_subcategory,$sh_company,$sh_jobtype,$sh_jobstatus,$sh_shift,$sh_salaryrange,1);
		
				
				
				$js_dateformat = isset($result[0]) ? $result[0] : 0;
				$currency = isset($result[1]) ? $result[1] : 0;
				$job_categories = isset($result[2]) ? $result[2] : 0;
				$search_companies = isset($result[3]) ? $result[3] : 0;
				$job_type= isset($result[4]) ? $result[4] : 0;
				$job_status = isset($result[5]) ? $result[5] : 0;
				$search_shift = isset($result[6]) ? $result[6] : 0;
				$salaryrangefrom =isset($result[7]) ? $result[7] : 0;
				$salaryrangeto =isset($result[8]) ? $result[8] : 0;
				$salaryrangetypes =isset($result[9]) ? $result[9] : 0;
				$job_subcategories = isset($result[10]) ? $result[10] : 0;
				$cities = isset($result[11]) ? $result[11] : 0;
                                $contents = '';
				/** sce */
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

				$slink = JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=jobs&Itemid='.$itemid);
				    $contents .= '<form class="jsautoz_form" action="'.$slink.'" method="post" name="js-jobs-form-mod" id="js-jobs-form-mod">';
					$contents .= '<input type="hidden" name="isjobsearch" value="1" />';
		      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
											<div class="text-left">
												'.$jobtitle_title.'
											</div>
											<div class="text-left">
												<input class="inputbox" type="text" name="jobtitle" size="16" maxlength="255"  />
											</div>
										</div>';
					if( $sh_category == 1 ){ 
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$categorytitle.'
													</div>
													<div class="text-left">
														'.$job_categories.'
													</div>
												</div>';
					} 
			       	if ( $sh_subcategory == 1 ) {
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$subcategorytitle.'
													</div>
													<div class="text-left" id="plgfj_subcategory">
														'.$job_subcategories.'
													</div>
												</div>';
		    		}
			      	if ( $sh_jobtype == 1 ) { 
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$typetitle.'
													</div>
													<div class="text-left">
														'.$job_type.'
													</div>
												</div>';
	    			} 
			      	if ( $sh_jobstatus == 1 ) {
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$jobstatustitle.'
													</div>
													<div class="text-left">
														'.$job_status.'
													</div>
												</div>';
			    	} 
		    		if ( $sh_salaryrange == 1 ) {
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$salaryrangetitle.'
													</div>
													<div class="text-left">
														'.$salaryrangefrom.$salaryrangeto.'
													</div>
												</div>';
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.JText::_('Salary type').'
													</div>
													<div class="text-left">
														'.$currency.$salaryrangetypes.'
													</div>
												</div>';
			       	} 
			      	if ( $sh_shift == 1 ) {
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$shifttitle.'
													</div>
													<div class="text-left">
														'.$search_shift.'
													</div>
												</div>';
			       	} 
			      	if ( $sh_durration == 1 ) {
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$durationtitle.'
													</div>
													<div class="text-left">
														<input class="inputbox" type="text" name="durration" size="10" maxlength="15"  />
													</div>
												</div>';
			       	} 
			      	if ( $sh_startpublishing == 1 ) {
						$startdatevalue = '';	  
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$startpublishingtitle.'
													</div>
													<div class="text-left">
														'.JHTML::_('calendar', $startdatevalue,'startpublishing', 'startpublishing',$js_dateformat,array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19')).'
													</div>
												</div>';
					} 
			      	if ( $sh_stoppublishing == 1 ) {
						$stopdatevalue = '';	  
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$stoppublishingtitle.'
													</div>
													<div class="text-left">
														'.JHTML::_('calendar', $stopdatevalue,'stoppublishing', 'stoppublishing',$js_dateformat,array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19')).'
													</div>
												</div>';
			       	} 
			      	if ( $sh_company == 1 ) {
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$companytitle.'
													</div>
													<div class="text-left">
														'.$search_companies.'
													</div>
												</div>';
			       	} 
			      	if ( $sh_addresses == 1 ) {
			      		$contents .= '		<div class="fieldwrapper" style="float:left;width:'.$colwidth.'">
													<div class="text-left">
														'.$citytitle.'
													</div>
													<div class="text-left">
														'.$cities.'
													</div>
												</div>';
			       	} 
					$contents .= '<div class="fieldwrapper" style="float:left;width:'.$colwidth.'"><input id="button" type="submit" class="button" name="submit_app" onclick="document.pjsadminForm.submit();" value="'. $searchjobtitle.'" />&nbsp;&nbsp;&nbsp;<span id="themeanchor"><a id="button" class="button minpad" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobsearch&Itemid='.$itemid.'">'.JText::_('Advanced search').'</a></span></div>';
					$contents .= '<input type="hidden" name="view" value="job" />';
					$contents .= '<input type="hidden" name="layout" value="jobs" />';
					$contents .= '<input type="hidden" name="option" value="com_jsjobs" />';
							
						  
						  
							  
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
                                                                    }";


					    if ($sh_addresses == 1) {
					    $contents .= ' 
					        jQuery(document).ready(function () {
					            jQuery("#cityplug").tokenInput("'.JURI::root() .'index.php?option=com_jsjobs&task=cities.getaddressdatabycityname", {
					                theme: "jsjobs",
					                width: jQuery("span#plugsearchjob_city").width(),
					                preventDuplicates: true,
					                hintText: "'. JText::_('Type in a search term') .'",
					                noResultsText: "'. JText::_('No results').'",
					                searchingText: "'. JText::_('Searching...').'",
					                tokenLimit: 1

					            });
					        });
					     	'; 
						}


						$contents .="</script>";



	
               return $contents;
        }
}



?>
