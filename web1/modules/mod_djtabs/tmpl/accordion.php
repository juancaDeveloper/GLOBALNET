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
 
defined ('_JEXEC') or die('Restricted access');
JHTML::_('behavior.framework','More'); 

if (isset($module)){
	$mod_prefix = 'mod'.$module->id.'_';
}else{
	$mod_prefix = $params->get('prefix','modArt').'_';
}

?>

<img id="<?php echo $mod_prefix; ?>djtabs_loading" class="loading" src="components/com_djtabs/assets/images/ajax-loader.gif" alt="loading..." />

<div id="<?php echo $mod_prefix; ?>djtabs" class="djtabs <?php echo ($params->get('class_theme_title')); ?> accordion<?php echo $params->get('truncate_titles','1')=='0' ? ' full-titles' : ''; ?>">

<?php $tab_i = 0; ?>
<?php foreach($tabs  as $tab){
	$tab_i++; ?>
	<div class="djtabs-title-wrapper">
		<div id="<?php echo $mod_prefix; ?>djtab<?php echo $tab_i; ?>" class="djtabs-title djtabs-accordion <?php echo $mod_prefix; ?>djtabs_help_class" data-tab-no="<?php echo $tab_i;?>" tabindex="0">
			<?php require(JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'views'.DS.'tabs'.DS.'tmpl'.DS.'inc'.DS.'tab_text.php'); ?>
		</div>
	</div>
	<div class="djclear"></div>
	<div class="djtabs-in-border" data-no="<?php echo $tab_i;?>"> 
		<div class="djtabs-in">
			<div class="djtabs-body accordion-body djclear <?php switch($tab->type){
				case 1: echo 'type-article-category'; break;
				case 2: echo 'type-article'; break;
				case 3: echo 'type-module'; break;
				case 4: echo 'type-video'; break;
				case 5: echo 'type-k2-category'; break;
				case 6: echo 'type-k2-item'; break;
			}?>" data-tab-no="<?php echo $tab_i;?>" tabindex="0">
			<?php if($tab->type==1 || $tab->type==5){ // article category or k2 category ?>
			<?php 
				$art_display=$tab->params->get('articles_display','1');
				if ($art_display=='1'){
					$accordion_classes=$mod_prefix."accordion_help_class accordion_first_out";
				}else if ($art_display=='2'){
					$accordion_classes=$mod_prefix."accordion_help_class accordion_all_in";
				}else{
					$accordion_classes="";
				}
			?>
			<div id="<?php echo $mod_prefix; ?>djtabs_accordion<?php echo $tab_i; ?>" class="<?php echo $accordion_classes; ?> djtabs-body-in">
				<?php require(JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'views'.DS.'tabs'.DS.'tmpl'.DS.'inc'.DS.'art_space_count.php'); ?>
			
			<?php foreach($tab->content as $con){ ?>
			<?php $art_i++; ?>
				<div tabindex="0" class="djtabs-article-group<?php echo (($tab->params->get('articles_display','1')==3) ? ' djtabs-article-out' : '');?>"<?php echo $art_width ? ' style="'.$art_width.($art_i%$art_per_row ? $art_space : '').'"' : ''; ?>>
					<div id="<?php echo $mod_prefix; ?>inner_accordion_panel<?php echo $art_i;?>_<?php echo $tab_i;?>" class="djtabs-panel">
					<?php require(JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'views'.DS.'tabs'.DS.'tmpl'.DS.'inc'.DS.'panel_title.php'); ?>
						<?php if ($art_display!='3'){ ?>
							<span class="djtabs-panel-toggler"></span>
						<?php } ?>
					</div>
					<div data-tab-no="<?php echo $tab_i;?>" data-no="<?php echo $art_i;?>" class="djtabs-article-body">
						<?php require(JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'views'.DS.'tabs'.DS.'tmpl'.DS.'inc'.DS.'article_content.php'); ?>
					</div>
				</div>
			<?php } ?>
			</div>
			<?php }else if($tab->type==2 || $tab->type==6){ // article or k2 item ?>
			<?php $con = $tab->content; ?>
			<div class="djtabs-body-in djtabs-article-body-in">
				<div class="djtabs-article-group djtabs-group-active">
					<?php if($tab->content->params->get('show_create_date','1')=='1' || $tab->content->params->get('show_title','1')=='1'){ ?>
					<div class="djtabs-panel djtabs-panel-active djtabs-panel-article">
						<?php require(JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'views'.DS.'tabs'.DS.'tmpl'.DS.'inc'.DS.'panel_title.php'); ?>
					</div>
					<?php } ?>
					<?php require(JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'views'.DS.'tabs'.DS.'tmpl'.DS.'inc'.DS.'article_content.php'); ?>
				</div>
			</div>
			<?php }else if($tab->type==3){ //module ?>
			<div class="djtabs-body-in djtabs-module">
				<?php echo DjTabsHelper::loadModules($tab->mod_pos); ?>
			</div>
			<?php }else if($tab->type==4){ //video ?>
				<?php if (!$tab->video_link){
					echo JText::_('COM_DJTABS_VIDEO_UNSUPPORTED');
				}else { ?>
				<div class="djVideoWrapper">
					<iframe src="<?php echo $tab->video_link; ?>" allowfullscreen></iframe>
				</div>                      
				<?php } ?>
			<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
</div>