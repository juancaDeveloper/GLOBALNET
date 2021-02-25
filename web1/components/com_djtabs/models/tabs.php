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

defined('_JEXEC') or die( 'Restricted access' );

use Joomla\Utilities\ArrayHelper;

require_once (JPATH_BASE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php');
require_once (JPATH_BASE . DS . 'components' . DS . 'com_djtabs' . DS . 'helpers' . DS . 'helper.php');
require_once (JPATH_BASE . DS . 'administrator' . DS . 'components' . DS . 'com_djtabs' . DS . 'lib' . DS . 'djimage.php');
JModelLegacy::addIncludePath(JPATH_BASE . DS . 'components' . DS . 'com_content' . DS . 'models', 'ContentModel');

class DJTabsModelTabs extends JModelList
{

 	public static function getTabs($groupid) {

        $db = JFactory::getDBO();
		
        $query = 'SELECT * FROM #__djtabs_items ' 
        		.'WHERE group_id = '.$groupid.' AND published=1 '
        		.'ORDER BY ordering ';
        $db -> setQuery($query);
        $tabs = $db -> loadObjectList();

        foreach ($tabs as $tab) {
        	    	
			$registry = new JRegistry();
            $registry -> loadString($tab -> params);
            $tab -> params = $registry ;//-> toObject();

            $registry = JComponentHelper::getParams('com_djtabs'); //$app->getParams();

			$param_names = array('date','date_position','title','title_link','title_char_limit','image','image_position','image_link','image_width','image_height','description','description_link','HTML_in_description','description_char_limit','readmore_button','category','category_link','author',
			'articles_display','articles_per_row','articles_space','article_limit','max_category_levels','articles_from_last_x_days',
			'articles_min_date','articles_max_date','articles_ordering','articles_ordering_direction'
			);
			
			//new 1.1.2 - date_format - global param only
			$tab->params->set('date_format',$registry->get('date_format','l, d F Y'));
			//new 1.3 - date_panel_format - global param only
			$tab->params->set('date_panel_format',$registry->get('date_panel_format','y.m.d'));
			
			foreach ($param_names as $name){  //assigning global params if not numeric or not set/set global
				if($tab->params->get($name,'')=='') //if(!is_numeric($tab->params->get($name)) || $tab->params->get($name,'')=='')
					$tab->params->set($name,$registry->get($name));
			}
				
			if ($tab->params->get('readmore_text','')=='')
				$tab->params->set('readmore_text',$registry->get('readmore_text'));

            if ($tab -> type == 1){ //article category
            	$tab->content = self::getArticleCategory($tab->params);
            }else if ($tab -> type == 2){ //article
            	$tab->content = self::getArticle($tab->params);	
            }else if ($tab -> type == 3){ //module
            	$tab->mod_pos = $tab->params->get('module_position');
            }else if ($tab -> type == 4){ //video link
            	$tab->video_link = self::convertVideoLink($tab->params->get('video_link'));
            }else if ($tab -> type == 5){ //K2 category
            	$tab->content = self::getK2Category($tab->params);
            }else if ($tab -> type == 6){ //K2 item
            	$tab->content = self::getK2Item($tab->params);	
            }
                		
        }

        return $tabs;
    }

    static function getArticle($tab_params) {

        $app = JFactory::getApplication();
		$db = JFactory::getDBO();
		
		$now = new JDate();
		$now = $now->toSQL();

        $model_article = JModelLegacy::getInstance('Article', 'ContentModel', array('ignore_request' => true));
        $model_article -> setState('params', $app -> getParams('com_content'));//merging specific article params into global article params

        $article_id = $tab_params -> get('article_id');
        
		$query ="SELECT * FROM #__content WHERE id=$article_id AND state=1 AND ".$db->quote($now)." >= publish_up and (".$db->quote($now)." <= publish_down OR publish_down < publish_up)";
		$db->setQuery($query);
		$exists=$db->loadObject();
		
		if(!$exists){ //setting empty params if article not available to avoid tmpl errors
		
			return self::getEmptyObject();
		
		}else{
        	
			$item = $model_article -> getItem($article_id);

            $item -> link = JRoute::_(ContentHelperRoute::getArticleRoute($item -> id, $item -> catid));			
            $item -> cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($item -> catid));

			self::cleanText($item->introtext);
			//$item->introtext = JHTML::_('content.prepare', $item->introtext);
			self::parseContentPlugins($item);
			
			$item->params = ($item->params ? $item->params : $app -> getParams('com_content'));//in case of not loading article params
			self::mergeArticleParams($tab_params, $item->params);
			self::manageImage($tab_params, $item);

        	return $item;
        }

    }

	static function getArticleCategory($tab_params) {
		
		$db = JFactory::getDbo();
		
		$now = new JDate();
		$now = $now->toSQL();
		
		$cat_ids = $tab_params->get('category_id', 'NULL');
		$tag_ids = $tab_params->get('articles_tags', array());
		$art_limit = $tab_params->get('article_limit', '');
		$art_order = $tab_params->get('articles_ordering','ordering');
		$art_order_dir = $tab_params->get('articles_ordering_direction','');
		$art_min_date = $tab_params->get('articles_min_date','');
		$art_max_date = $tab_params->get('articles_max_date','');
		$max_cat_lvl = $tab_params->get('max_category_levels','1');
		$art_from_last_x_days = $tab_params->get('articles_from_last_x_days','');
		$art_from_last_x_days = is_numeric($art_from_last_x_days) ? $art_from_last_x_days : '';

		$cat_ids = is_array($cat_ids) ? implode(',',$cat_ids) : $cat_ids;
		
		$tagsWhere = '';
		if(!is_array($tag_ids)) $tag_ids = array($tag_ids);
		if(count($tag_ids) > 0) {
			
			$tag_ids = implode(',', ArrayHelper::toInteger($tag_ids));
			
			$subQuery = $db->getQuery(true)
			->select('DISTINCT content_item_id')
			->from($db->quoteName('#__contentitem_tag_map'))
			->where('tag_id IN (' . $tag_ids . ')')
			->where('type_alias = ' . $db->quote('com_content.article'));
			
			$tagsWhere = 'AND i.id IN ('.implode(',',$db->setQuery($subQuery)->loadColumn()).')';
		}
		
		if($art_order == "random"){
			$art_order = "RAND()";
		}else{
			$art_order = "i.".$art_order." ".($art_order_dir == '-1' ? 'DESC' : 'ASC');
		}
		
		$query="SELECT i.*, parent.title as category_title, u.name as author ".
				"FROM #__content AS i LEFT JOIN #__users u ON i.created_by=u.id, ".
				"#__categories AS node, ".
				"#__categories AS parent ".
				"WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.id=i.catid ".
				"AND i.state=1 AND ".$db->quote($now)." >= i.publish_up and ( ".$db->quote($now)." <= i.publish_down or i.publish_down < i.publish_up) ".
					($art_min_date ? " AND i.created>=".$db->quote($art_min_date) : "").
					($art_max_date ? " AND i.created<=".$db->quote($art_max_date) : "").
					($art_from_last_x_days ? " AND i.created>=(".$db->quote($now)." - INTERVAL ".$db->quote($art_from_last_x_days)." DAY)" : "")." ".
				"AND node.level-parent.level<".$max_cat_lvl." AND parent.id IN (".$cat_ids.") ".
				$tagsWhere.
				"ORDER BY ".$art_order.", i.title ".($art_limit ? "LIMIT ".$art_limit : "");

		$db->setQuery((string)$query);
		$items = $db->loadObjectList();

		foreach($items as $item){
			
			$item -> link = JRoute::_(ContentHelperRoute::getArticleRoute($item -> id, $item -> catid));
			$item -> cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($item -> catid));

			self::cleanText($item->introtext);
			// $item->introtext = JHTML::_('content.prepare', $item->introtext);
			self::parseContentPlugins($item);
			
			self::setArticleCategoryParams($tab_params, $item);
			self::manageImage($tab_params, $item);
		}        

     return $items;

    }

	static function getK2Item($tab_params) {
		
		$k2_helper_route = JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'route.php';
		
		if(JFile::exists($k2_helper_route)){
			
			require_once($k2_helper_route);
			
	        $app = JFactory::getApplication();
			$db = JFactory::getDBO();
			
			$now = new JDate();
			$now = $now->toSQL();
	
	        $item_id = $tab_params -> get('k2_item_id');
	        
			$query ="SELECT a.*, b.userName author, c.name category_title, c.alias c_alias 
					FROM #__k2_items a 
					LEFT JOIN #__k2_users b ON a.created_by=b.userID 
					LEFT JOIN #__k2_categories c ON a.catid=c.id 
					WHERE a.id=$item_id AND a.trash=0 AND a.published=1 AND ".$db->quote($now)." >= a.publish_up 
					AND (".$db->quote($now)." <= a.publish_down OR a.publish_down < a.publish_up)";
			$db->setQuery($query);
			$item=$db->loadObject();
			
			if(!$item){ //setting empty params if article not available to avoid tmpl errors
			
				return self::getEmptyObject();
			
			}else{

	            $item->state = 1;
	            
	            $item -> link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->c_alias))));
		        $item -> cat_link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($item->catid.':'.urlencode($item->c_alias))));
	
				self::cleanText($item->introtext);
				//$item->introtext = JHTML::_('content.prepare', $item->introtext);
				self::parseContentPlugins($item);
				
				$item->params = $app -> getParams('com_content');
					
				self::mergeArticleParams($tab_params, $item->params);

				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_M.jpg'))
				{
					$item->image_url = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg';
				}else{
					$item->image_url = '';
				}
				
	        	return $item;
	        }
	
		}
	}

    static function getK2Category($tab_params) {
		
		$k2_helper_route = JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'route.php';
		
		if(JFile::exists($k2_helper_route)){
			
			require_once($k2_helper_route);
			
	        $app = JFactory::getApplication();
			$db = JFactory::getDbo();
			
			$now = new JDate();
			$now = $now->toSQL();
	
			$cat_ids = $tab_params->get('k2_category_id', 'NULL');
			$art_limit = $tab_params->get('article_limit', '');
			$art_order = $tab_params->get('articles_ordering','ordering');
			$art_order_dir = $tab_params->get('articles_ordering_direction','');
			$art_min_date = $tab_params->get('articles_min_date','');
			$art_max_date = $tab_params->get('articles_max_date','');
			//$max_cat_lvl = $tab_params->get('max_category_levels','1');
			$art_from_last_x_days = $tab_params->get('articles_from_last_x_days','');
			$art_from_last_x_days = is_numeric($art_from_last_x_days) ? $art_from_last_x_days : '';
	
			$cat_ids = is_array($cat_ids) ? implode(',',$cat_ids) : $cat_ids;
	
			if($art_order == "random") $art_order = "RAND()";
			else if($art_order == "ordering") $art_order = "i.".$art_order;
			else $art_order = "i.".$art_order." ".($art_order_dir == '-1' ? 'DESC' : 'ASC');
			
			$query="SELECT i.*, c.name category_title, c.alias c_alias, u.userName author ".
					"FROM #__k2_items i ".
					"LEFT JOIN #__k2_users u ON i.created_by=u.userID ".
					"LEFT JOIN #__k2_categories c ON i.catid=c.id ".
					"WHERE i.trash=0 AND i.published=1 AND ".$db->quote($now)." >= i.publish_up ".
					"AND ( ".$db->quote($now)." <= i.publish_down or i.publish_down < i.publish_up) ".
						($art_min_date ? " AND i.created>=".$db->quote($art_min_date) : "").
						($art_max_date ? " AND i.created<=".$db->quote($art_max_date) : "").
						($art_from_last_x_days ? " AND i.created>=(".$db->quote($now)." - INTERVAL ".$db->quote($art_from_last_x_days)." DAY)" : "")." ".
					"AND i.catid IN (".$cat_ids.") ".
					"ORDER BY ".$art_order.", i.title ".($art_limit ? "LIMIT ".$art_limit : "");
	
			$db->setQuery((string)$query);
			$items = $db->loadObjectList();
	
			foreach($items as $item){
				
				$item->state = 1;
	            
	            $item -> link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->c_alias))));
		        $item -> cat_link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($item->catid.':'.urlencode($item->c_alias))));
	
				self::cleanText($item->introtext);
				//$item->introtext = JHTML::_('content.prepare', $item->introtext);
				self::parseContentPlugins($item);
				
				$item->params = $app -> getParams('com_content');
					
				self::setArticleCategoryParams($tab_params, $item);

				if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_M.jpg'))
				{
					$item->image_url = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_M.jpg';
				}else{
					$item->image_url = '';
				}

			}        
	
	     return $items;
	
		}
	}

	static function mergeArticleParams($tab_params, &$article_params) {

		if ($tab_params->get('author')!='')
			$article_params -> set('show_author',$tab_params->get('author'));
		if ($tab_params->get('title')!='')
			$article_params -> set('show_title',$tab_params->get('title'));
		if ($tab_params->get('title_link')!='')
			$article_params -> set('link_titles',$tab_params->get('title_link'));
		if ($tab_params->get('category')!='')
			$article_params -> set('show_category',$tab_params->get('category'));
		if ($tab_params->get('category_link')!='')
			$article_params -> set('link_category',$tab_params->get('category_link'));
		if ($tab_params->get('date')!='')
			$article_params -> set('show_create_date',$tab_params->get('date'));
		if ($tab_params->get('readmore_button')!='')
			$article_params -> set('show_readmore',$tab_params->get('readmore_button'));

	}
	
	static function setArticleCategoryParams($tab_params, &$item) {

		$app = JFactory::getApplication();
        $article_params = $app->getParams('com_content');
		
		$item->show_author = ($tab_params->get('author')!='') ? $tab_params->get('author') : $article_params -> get('show_author',0);
		$item->show_title = ($tab_params->get('title')!='') ? $tab_params->get('title') : $article_params -> get('show_title',0);
		$item->link_titles = ($tab_params->get('title_link')!='') ? $tab_params->get('title_link') : $article_params -> get('link_titles',0);
		$item->show_category = ($tab_params->get('category')!='') ? $tab_params->get('category') : $article_params -> get('show_category',0);
		$item->link_category = ($tab_params->get('category_link')!='') ? $tab_params->get('category_link') : $article_params -> get('link_category',0);
		$item->show_create_date = ($tab_params->get('date')!='') ? $tab_params->get('date') : $article_params -> get('show_create_date',0);
		$item->show_readmore = ($tab_params->get('readmore_button')!='') ? $tab_params->get('readmore_button') : $article_params -> get('show_readmore',0);

	}

	static function cleanText(&$text) {
		
		//$text = preg_replace('/{loadposition\s+(.*?)}/i', '', $text);
		//$text = preg_replace('/{loadmodule\s+(.*?)}/i', '', $text);
		//$text = preg_replace('/{djmedia\s*(\d*)}/i', '', $text);
		$text = preg_replace('/{djsuggester\s+(.*?)}/i', '', $text);
		$text = preg_replace('/{djtabs\s*(\d*)\s*(\-?\d*)\s*(\w*)}/i', '', $text);
		$text = preg_replace('/<img [^>]*alt="djtabs:(\d*),(\-?\d*),(\w*)"[^>]*>/i', '<div style="text-align:center;font-style:italic;color:white;background:tomato;border-radius:5px;">&nbsp;DJ-Tabs within DJ-Tabs not allowed&nbsp;</div>', $text);
		//return $text;
	}

	function getParams() {

		if (!isset($this->_params)) {
			$app = JFactory::getApplication();
			$mparams = $app->getParams(); 
			$this->_params = $mparams;
		}

		return $this->_params;
	}
	
	static function getEmptyObject() {

			$app = JFactory::getApplication();

			$object = new stdClass();
			$params = $app -> getParams('com_content');
			$object->params = $params;
			$object->title = '';
			$object->images = '';
			$object->introtext = '';
			$object->author = '';
			$object->cat_link = '';
			$object->category_title = '';
			$object->state = 0;
			
			return $object;
	}
	
	static function convertVideoLink($link){
		
		if($_link=stristr($link,'youtube')){
			$_link = '//www.youtube.com/embed/'.str_replace('youtube.com/watch?v=','',$_link).'?wmode=opaque&amp;rel=0&amp;enablejsapi=1';
		}
		else if($_link=stristr($link,'youtu.be')){
			$_link = '//www.youtube.com/embed/'.str_replace('youtu.be/','',$_link).'?wmode=opaque&amp;rel=0&amp;enablejsapi=1';
		}
		else if($_link=stristr($link,'vimeo')){
			$_link = '//player.vimeo.com/video/'.str_replace('vimeo.com/','',$_link);
		}
		
		return $_link;
		
	}
	
	static function manageImage($params, &$item){
		
		$app_params = JComponentHelper::getParams('com_djtabs');

		if($params->get('image','0')){
			if($params->get('image','0') == '1' || $params->get('image','0') == '2'){
				if($params->get('image','0') == '1'){
					$image_type = 'image_intro';
				}else if($params->get('image','0') == '2'){
					$image_type = 'image_fulltext';
				}
	            $images = new JRegistry();
				$images->loadString($item->images);
				$old_path = $images->get($image_type);
				$item->image_alt = $images->get($image_type.'_alt');
				$item->image_caption = $images->get($image_type.'_caption');
			}else if($params->get('image','0') == '3'){
				// $xpath = new DOMXPath(@DOMDocument::loadHTML($item->fulltext));
				// $old_path = $xpath->evaluate("string(//img/@src)");
				if(preg_match("/<img [^>]*src=\"([^\"]*)\"[^>]*>/", $item->fulltext, $matches)){
					$old_path = $matches[1];
				}else if(preg_match("/<img [^>]*src=\"([^\"]*)\"[^>]*>/", $item->introtext, $matches)){
					$old_path = $matches[1];
				}
				$item->image_alt = '';
				$item->image_caption = '';
			}

			if(isset($old_path) && $app_params->get('thumbnails','0')=='1' && ($params->get('image_width',0) || $params->get('image_height',0))){
				$old_path_parts = pathinfo($old_path);
				$thumb_name = str_replace('/','__',$old_path_parts['dirname']).'__'.$old_path_parts['filename'].'__'.$params->get('image_width','0').'x'.$params->get('image_height','0').'.'.$old_path_parts['extension'];
				$new_path = 'components'.DS.'com_djtabs'.DS.'thumbs'.DS.$thumb_name;
				if(!file_exists($new_path)){
					DJTabsImage::makeThumb($old_path, $new_path, $params->get('image_width',0), $params->get('image_height',0));
				}
				$item->image_url = $new_path;
			}else{
				$item->image_url = isset($old_path) ? $old_path : '';
			}
		}else{
			$item->image_url = '';
		}
		
	}

	static function parseContentPlugins(&$article){
			$article->introtext = JHTML::_('content.prepare', $article->introtext);
			$params = new JObject;
			$article->text = $article->introtext;
			JPluginHelper::importPlugin('content');
			$dispatcher = JDispatcher::getInstance();
			$dispatcher->trigger('onContentPrepare', array('com_content.article', &$article, &$params, 0));
	}

}
