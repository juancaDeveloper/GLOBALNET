<?php
/**
 * @version 1.0
 * @package DJ-Tabs
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Piotr Dobrakowski - piotr.dobrakowski@design-joomla.eu
 *
 * DJ-Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Tabs. If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die('Restricted access');

class DjTabsHelper{
	
	private static $modules = null;
	
	public static function addThemeCSS(&$params){
		
		$document= JFactory::getDocument();
		$db = JFactory::getDBO();
		
		$theme_id = $params->get('theme',0);

		if ($theme_id==0) //random theme
			$query = 'SELECT * FROM #__djtabs_themes '
					.'WHERE id!='.$theme_id.' and published=1 AND random=1 ORDER BY RAND() LIMIT 1';
		elseif ($theme_id>0)
        	$query = 'SELECT * FROM #__djtabs_themes ' 
        			.'WHERE id = '.$theme_id;
		
		if ($theme_id>=0){
	        $db -> setQuery($query);
	        $theme = $db -> loadObject();
			
			$css_params = new JRegistry();
			$css_params->loadString($theme->params);
				
		}
		
		if ($theme_id==0) 
			$theme_id = $theme->id;
		
		if($theme_id==-1){	//default-theme	
			$theme_title = 'default-theme';
			$file = 'components/com_djtabs/assets/css/default/'.$theme_title.'.css';
			$document->addStyleSheet($file);
		}
		elseif($theme->custom==0){ //solid theme
			$theme_title = str_replace(' ','-',$theme->title);
			$file1 = 'components/com_djtabs/assets/css/default/solid-theme.css';
			$file2 = 'components/com_djtabs/assets/css/default/'.$theme_title.'.css';
			$document->addStyleSheet($file1);
			$document->addStyleSheet($file2);
			$theme_title = 'solid-theme '.$theme_title;
		}
		else{
			$theme_title = str_replace(' ','-',$theme->title);
			$file = 'components/com_djtabs/assets/css/'.$theme_title.'.css';
			$path = JPATH_ROOT.'/'.$file;
			if(file_exists($path)){
				$document->addStyleSheet($file);
			}		
			else {
				self::generateThemeCSS($theme_id);
				$document->addStyleSheet($file);
			}
		}
		
		$params->set('class_theme_title',$theme_title);

	}

	public static function generateThemeCSS($theme_id){
		
		$db = JFactory::getDBO();
		
    	$query = 'SELECT * FROM #__djtabs_themes ' 
    			.'WHERE id = '.$theme_id;
					
        $db -> setQuery($query);
        $theme = $db -> loadObject();
		
		$css_params = new JRegistry();
		$css_params->loadString($theme->params);
		$theme_title = str_replace(' ','-',$theme->title);
		if (!$theme_title) $theme_title = 'default-theme';
		
		$file = JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'assets'.DS.'css'.DS.$theme_title.'.css';
		$path = JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'assets'.DS.'custom.css.php';
		
		ob_start();		
			include($path);		
		$buffer = ob_get_clean();
		
		JFile::write($file, $buffer);
		
	}
		
	public static function loadModules($position, $style = 'xhtml')
	{
		if (!isset(self::$modules[$position])) {
			self::$modules[$position] = '';
			$document	= JFactory::getDocument();
			$renderer	= $document->loadRenderer('module');
			$modules	= JModuleHelper::getModules($position);
			$params		= array('style' => $style);
			ob_start();
			
			foreach ($modules as $module) {
				echo $renderer->render($module, $params);
			}
	
			self::$modules[$position] = ob_get_clean();
		}
		return self::$modules[$position];
	}
	
	public static function addTabsScriptDeclaration($layout, $params, $mod = false, $prfx = '')
	{
		$document = JFactory::getDocument();
		$global_params = JComponentHelper::getParams('com_djtabs');
		
		$acc_disp = 0;
		if(!$mod){
			if($layout == 'default'){
				if(JRequest::getInt('tab', '1') > -1){
					$acc_disp = JRequest::getInt('tab', '1') - 1;
				}
			}else{
				if(JRequest::getInt('tab', '0') > 0){
					$acc_disp = JRequest::getInt('tab', '0') - 1;
				}else{
					if($params->get('accordion_display',1)==2){
						$acc_disp = -1;
					}
				}
			}
		}else{
			if($layout == 'default'){
				if($params->get('tab', '1') > -1){
					$acc_disp = $params->get('tab', '1') - 1;
				}
			}else{
				if($params->get('tab', '0') > 0){
					$acc_disp = $params->get('tab', '0') - 1;
				}else{
					if($params->get('accordion_display',1)==2){
						$acc_disp = -1;
					}
				}
			}
		}
		
		$accordion_script = "
			var DJTabsWCAG = ".($global_params->get('wcag_script','0') == '1' ? 'true' : 'false').";
			
			window.addEvent('resize', function(){
				".($layout == 'default' ? 'resetTabsWidth("'.$prfx.'");' : '')."
				".($layout == 'default' ? 'setTabsWidth('.$params->get('rows_number',1).',"'.$prfx.'");' : '')."
				resetPanelsText('".$prfx."');
				setPanelsText('".$prfx."');
			});
			
			window.addEvent('domready', function(){
			
				var scroll_to_accordion = '".$params->get('scroll_to_accordion','0')."';
			
				var clicked = false;
				$$('.djtabs-title, .djtabs-panel').addEvent('click',function(){
					clicked = true;
				});
			
				window['".$prfx."djtabs'] = new Fx.Accordion(document.id('".$prfx."djtabs'), '#".$prfx."djtabs .djtabs-title', '".($layout == 'default' ? '#'.$prfx.'djtabs .djtabs-body' : '#'.$prfx.'djtabs .djtabs-in-border')."',
					{
						display: ".$acc_disp.",
						duration: ".$params->get('transition_speed','500').",
						initialDisplayFx: ".($layout == 'default' ? 'false' : ((JRequest::getInt('tab', '1') > -1 && ($params->get('scroll_to_accordion','0')=='1' || $params->get('scroll_to_accordion','0')=='3')) ? 'true' : 'false')).",
						trigger: '".($layout == 'default' ? ($params->get('tabs_trigger','1')=='2' ? 'mouseenter' : 'click') : 'click')."',
						".($layout != 'default' ? 'alwaysHide: true,' : '')."
						onActive: function(toggler, element){
							toggler.addClass('djtabs-active');
							toggler.setProperty('aria-expanded', 'true');
							toggler.getParent().addClass('djtabs-active-wrapper');
							toggler.getParent().removeClass('djtabs-prev');
							toggler.getParent().removeClass('djtabs-next');
							toggler.getParent().getSiblings().removeClass('djtabs-prev');
							toggler.getParent().getSiblings().removeClass('djtabs-next');
							var prev = toggler.getParent().getPrevious('.djtabs-title-wrapper');
							var next = toggler.getParent().getNext('.djtabs-title-wrapper');
							if(prev) prev.addClass('djtabs-prev');
							if(next) next.addClass('djtabs-next');
							".($params->get('video_autopause',2)==1 ? 'toggleVideo(element,1);' : '')."
						},
						onBackground: function(toggler, element){
							toggler.removeClass('djtabs-active');
							toggler.setProperty('aria-expanded', 'false');
							toggler.getParent().removeClass('djtabs-active-wrapper');
							".($params->get('video_autopause',2)==1 || $params->get('video_autopause',2)==2 ? 'toggleVideo(element,0);' : '')."
						}
						".($layout != 'default' ? 
						",onComplete: function(){
							if(scroll_to_accordion=='1' || scroll_to_accordion=='3'){
								Array.each(arguments, function(el){
									if (el.getStyle('opacity') && clicked){
										if(el.getProperty('data-no')){
											var myFx = new Fx.Scroll(window,{offset: {'x': 0, 'y': -115}}).toElement(document.id('".$prfx."djtab'+el.getProperty('data-no')), 'y');
										}
									}
								});
							}
						}" 
						: "" )."
					}
				);
			
				var categoryAccordionOptions = {
					duration: ".$params->get('transition_speed','500').",
					alwaysHide: true,
					onActive: function(toggler, element){
						toggler.addClass('djtabs-panel-active');
						toggler.setProperty('aria-expanded', 'true');
						toggler.getParent().addClass('djtabs-group-active');
					},
					onBackground: function(toggler, element){
						toggler.removeClass('djtabs-panel-active');
						toggler.setProperty('aria-expanded', 'false');
						toggler.getParent().removeClass('djtabs-group-active');
					},
					onComplete: function(){
						if(scroll_to_accordion=='1' || scroll_to_accordion=='3'){
							Array.each(arguments, function(el){
								if (el.getParent().hasClass('djtabs-group-active') && clicked){
									if(el.getProperty('data-no')){
										var myFx = new Fx.Scroll(window,{offset: {'x': 0, 'y': 0}}).toElement(document.id('".$prfx."inner_accordion_panel'+el.getProperty('data-no')+'_'+el.getProperty('data-tab-no')), 'y');
									}
								}
							});
						}
					}
				}
			
				var accordionsArray = $$('#".$prfx."djtabs .accordion_first_out');
				for (i=1; i<=accordionsArray.length; i++)
				{
					var accordion_id = accordionsArray[i-1].id;
					window[accordion_id] = new Fx.Accordion(document.id(accordion_id), '#'+accordion_id+' .djtabs-panel', '#'+accordion_id+' .djtabs-article-body',categoryAccordionOptions);
				}
				
				var accordionsArray = $$('#".$prfx."djtabs .accordion_all_in');
				categoryAccordionOptions.display = -1;
				for (i=1; i<=accordionsArray.length; i++)
				{
					var accordion_id = accordionsArray[i-1].id;
					window[accordion_id] = new Fx.Accordion(document.id(accordion_id), '#'+accordion_id+' .djtabs-panel', '#'+accordion_id+' .djtabs-article-body',categoryAccordionOptions);
				}
			
				".($layout == 'default' ? 'setTabsWidth('.$params->get('rows_number',1).',"'.$prfx.'");' : '')."
				setPanelsText('".$prfx."');
				document.id('".$prfx."djtabs').setStyle('visibility','visible');
				document.id('".$prfx."djtabs_loading').hide();
				
			});
		";

		$document->addScriptDeclaration($accordion_script);
	}
	
}

?>