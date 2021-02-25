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

$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('components/com_jsjobs/include/js/colorpicker.js');
$document->addScript('components/com_jsjobs/include/js/eye.js');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_jsjobs/include/css/colorpicker.css');
$document->addStyleSheet(JURI::root() . 'administrator/components/com_jsjobs/include/css/layout.css');

$document->addStyleSheet(JURI::root() . 'components/com_jsjobs/css/style.css');
require_once(JPATH_COMPONENT_SITE.'/css/style_color.php');
$language = JFactory::getLanguage();
if($language->isRtl()){
  $document->addStyleSheet(JURI::root().'components/com_jsjobs/css/style_rtl.css');
}
?>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Theme'); ?></span>
            <div class="right_side">
                <a href="#" id="preset_theme"><img src="components/com_jsjobs/include/images/preset_theme.png" /><span class="theme_presets_theme"><?php echo JText::_('Preset Theme'); ?></span></a>
            </div>
        </div>

        <div class="js_theme_section">
            <form action="index.php" method="POST" name="adminForm" id="adminForm">
                <span class="js_theme_heading">
                    <?php echo JText::_('Color Chooser'); ?>
                </span>
                <div class="color_portion">
                    <span class="color_title"><?php echo JText::_('Color 1'); ?></span>
                    <input type="text" name="color1" id="color1" value="<?php echo $this->theme['color1']; ?>" style="background:<?php echo $this->theme['color1']; ?>;"/>
                    <span class="color_location">
                        <?php echo JText::_('Top Header Line'); ?>
                    </span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo JText::_('Color 2'); ?></span>
                    <input type="text" name="color2" id="color2" value="<?php echo $this->theme['color2']; ?>" style="background:<?php echo $this->theme['color2']; ?>;"/>
                    <span class="color_location">
                        <?php echo JText::_('Top Header Background Color'); ?>,
                        <?php echo JText::_('Button Hover'); ?>,
                        <?php echo JText::_('Logo Border'); ?>,
                        <?php echo JText::_('Heading Text'); ?>
                    </span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo JText::_('Color 3'); ?></span>
                    <input type="text" name="color3" id="color3" value="<?php echo $this->theme['color3']; ?>" style="background:<?php echo $this->theme['color3']; ?>;"/>
                    <span class="color_location"><?php echo JText::_('Top Header Text Color'); ?></span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo JText::_('Color 4'); ?></span>
                    <input type="text" name="color4" id="color4" value="<?php echo $this->theme['color4']; ?>" style="background:<?php echo $this->theme['color4']; ?>;"/>
                    <span class="color_location"><?php echo JText::_('Border Color'); ?></span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo JText::_('Color 5'); ?></span>
                    <input type="text" name="color5" id="color5" value="<?php echo $this->theme['color5']; ?>" style="background:<?php echo $this->theme['color5']; ?>;"/>
                    <span class="color_location"><?php echo JText::_('Content Background Color'); ?></span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo JText::_('Color 6'); ?></span>
                    <input type="text" name="color6" id="color6" value="<?php echo $this->theme['color6']; ?>" style="background:<?php echo $this->theme['color6']; ?>;"/>
                    <span class="color_location"><?php echo JText::_('Content Text Color'); ?></span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo JText::_('Color 7'); ?></span>
                    <input type="text" name="color7" id="color7" value="<?php echo $this->theme['color7']; ?>" style="background:<?php echo $this->theme['color7']; ?>;"/>
                    <span class="color_location"><?php echo JText::_('Button hover text color').', '.JText::_('Tabs text color'); ?></span>
                </div>
                <div class="color_portion">
                    <span class="color_title"><?php echo JText::_('Color 8'); ?></span>
                    <input type="text" name="color8" id="color8" value="<?php echo $this->theme['color8']; ?>" style="background:<?php echo $this->theme['color8']; ?>;"/>
                    <span class="color_location"><?php echo JText::_('Button Text Color').', '.JText::_('Fields title text color'); ?></span>
                </div>
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="c" value="configuration" />
                <input type="hidden" name="view" value="configuration" />
                <input type="hidden" name="layout" value="themes" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHTML::_( 'form.token' ); ?>        
            </form>
        </div>
        <div class="js_effect_preview">
            <span class="js_effect_preview_heading"><?php echo JText::_('Color Effect Preview'); ?></span>
            <main id="js_menu_wrapper">
                <div id="js_menu_wrapper">
                    <a href="#"class="js_menu_link "><?php echo JText::_('Control Panel'); ?></a>
                    <a href="#"class="js_menu_link selected"><?php echo JText::_('Job Categories'); ?></a>
                    <a href="#"class="js_menu_link "><?php echo JText::_('Search Job'); ?></a>
                    <a href="#"class="js_menu_link "><?php echo JText::_('Newest Jobs'); ?></a>
                    <a href="#"class="js_menu_link "><?php echo JText::_('My Resumes'); ?></a>
                </div>
                <link href="../components/com_jsjobs/js/style.css" rel="stylesheet" media="screen">
                <div id="js_main_wrapper">
                     <div class="page_heading"><label class="pageform"><?php echo JText::_('Newest Jobs'); ?></label></div>
                    <div class="js_job_filter_wrapper">
                    </div>
                    <!-- new -->
                    <div id="js-jobs-wrapper">
                        <div class="js-toprow">
                            <div class="js-image">
                                <a href="#">
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/blank_logo.png">
                                </a>
                            </div>
                            <div class="js-data">
                                <div class="js-first-row">
                                    <span class="js-col-xs-12 js-col-md-8 js-title js-title-tablet"> 
                                        <a href="#"><?php echo JText::_('PHP developer');?></a>
                                        <span class="js-status bg-new"><?php echo JText::_('New');?></span>
                                    </span>
                                    <span class="js-col-xs-12 js-col-md-4 js-jobtype js-jobtype-tablet">
                                        <?php echo JText::_('Posted').': 3'. JText::_('Days Ago'); ?>
                                        <span class="js-type"><?php echo JText::_('Part-Time');?></span>
                                    </span>
                                </div>
                                <div class="js-second-row">
                                    <div class="js-col-xs-12 js-col-md-5 js-fields">
                                        <span class="js-bold"><?php echo JText::_('Category'); ?>: </span><?php echo JText::_('Computer/IT'); ?>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-5 js-fields">
                                        <span class="js-bold"><?php echo JText::_('Salary');?>: </span>Rs. 2500 - 3000 <?php echo JText::_('Per Month');?>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-2 js-fields no-padding">
                                        <span class="js-totaljobs">0 <?php echo JText::_('Jobs');?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="js-bottomrow">
                            <div class="js-col-xs-12 js-col-md-6 js-address">
                                <img class="location" src="<?php echo JURI::root(); ?>components/com_jsjobs/images/location.png">
                                    <?php echo JText::_('Lahore, Pakistan'); ?>
                            </div>
                            <div class="js-col-xs-12 js-col-md-6 js-actions">
                                <a class="js-button" href="#" >
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/view-job-information.png" title="Job Information">
                                </a>
                                <a class="js-button" href="#" >
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/short-list.png" title="Short List">
                                </a>
                                <a class="js-button" href="#" >
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/tell-friend.png" title="Tell A Friend">
                                </a>
                                <a class="js-btn-apply" href="#" ><?php echo JText::_('Apply Now');?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="js-jobs-wrapper">
                        <div class="js-toprow">
                            <div class="js-image">
                                <a href="#">
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/blank_logo.png">
                                </a>
                            </div>
                            <div class="js-data">
                                <div class="js-first-row">
                                    <span class="js-col-xs-12 js-col-md-8 js-title js-title-tablet"> 
                                        <a href="#"><?php echo JText::_('PHP developer');?></a>
                                        <span class="js-status bg-new"><?php echo JText::_('New');?></span>
                                        <span class="js-status bg-gold"><?php echo JText::_('Gold');?></span>                                    </span>
                                    <span class="js-col-xs-12 js-col-md-4 js-jobtype js-jobtype-tablet">
                                        <?php echo JText::_('Posted').': 3'. JText::_('Days Ago'); ?>
                                        <span class="js-type"><?php echo JText::_('Part-Time');?></span>
                                    </span>
                                </div>
                                <div class="js-second-row">
                                    <div class="js-col-xs-12 js-col-md-5 js-fields">
                                        <span class="js-bold"><?php echo JText::_('Category'); ?>: </span><?php echo JText::_('Computer/IT'); ?>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-5 js-fields">
                                        <span class="js-bold"><?php echo JText::_('Salary');?>: </span>Rs. 2500 - 3000 <?php echo JText::_('Per Month');?>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-2 js-fields no-padding">
                                        <span class="js-totaljobs">0 <?php echo JText::_('Jobs');?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="js-bottomrow">
                            <div class="js-col-xs-12 js-col-md-6 js-address">
                                <img class="location" src="<?php echo JURI::root(); ?>components/com_jsjobs/images/location.png">
                                    <?php echo JText::_('Islamabad, Pakistan'); ?>
                            </div>
                            <div class="js-col-xs-12 js-col-md-6 js-actions">
                                <a class="js-button" href="#" >
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/view-job-information.png" title="Job Information">
                                </a>
                                <a class="js-button" href="#" >
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/short-list.png" title="Short List">
                                </a>
                                <a class="js-button" href="#" >
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/tell-friend.png" title="Tell A Friend">
                                </a>
                                <a class="js-btn-apply" href="#" ><?php echo JText::_('Apply Now');?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div id="js-jobs-wrapper">
                        <div class="js-toprow">
                            <div class="js-image">
                                <a href="#">
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/blank_logo.png">
                                </a>
                            </div>
                            <div class="js-data">
                                <div class="js-first-row">
                                    <span class="js-col-xs-12 js-col-md-8 js-title js-title-tablet"> 
                                        <a href="#"><?php echo JText::_('Desktop application developer');?></a>
                                        <span class="js-status bg-new"><?php echo JText::_('New');?></span>
                                        <span class="js-status bg-gold"><?php echo JText::_('Gold');?></span>
                                        <span class="js-status bg-feature"><?php echo JText::_('Featured');?></span>
                                    </span>
                                    <span class="js-col-xs-12 js-col-md-4 js-jobtype js-jobtype-tablet">
                                        <?php echo JText::_('Posted').': 3'. JText::_('Days Ago'); ?>
                                        <span class="js-type"><?php echo JText::_('Part-Time');?></span>
                                    </span>
                                </div>
                                <div class="js-second-row">
                                    <div class="js-col-xs-12 js-col-md-5 js-fields">
                                        <span class="js-bold"><?php echo JText::_('Category'); ?>: </span><?php echo JText::_('Computer/IT'); ?>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-5 js-fields">
                                        <span class="js-bold"><?php echo JText::_('Salary');?>: </span>Rs. 2500 - 3000 <?php echo JText::_('Per Month');?>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-2 js-fields no-padding">
                                        <span class="js-totaljobs">0 <?php echo JText::_('Jobs');?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="js-bottomrow">
                            <div class="js-col-xs-12 js-col-md-6 js-address">
                                <img class="location" src="<?php echo JURI::root(); ?>components/com_jsjobs/images/location.png">
                                    <?php echo JText::_('Gujranwala, Pakistan'); ?>
                            </div>
                            <div class="js-col-xs-12 js-col-md-6 js-actions">
                                <a class="js-button" href="#" >
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/view-job-information.png" title="Job Information">
                                </a>
                                <a class="js-button" href="#" >
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/short-list.png" title="Short List">
                                </a>
                                <a class="js-button" href="#" >
                                    <img src="<?php echo JURI::root(); ?>components/com_jsjobs/images/tell-friend.png" title="Tell A Friend">
                                </a>
                                <a class="js-btn-apply" href="#" ><?php echo JText::_('Apply Now');?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<div id="jsjobsfooter">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                <?php echo JText::_('Copyright'); ?> &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>
        
<?php
$document = JFactory::getDocument();
$document->addScript('../components/com_jsjobs/js/canvas_script.js');
?>
<script type="text/javascript" >
    jQuery(document).ready(function () {
        makeColorPicker('<?php echo $this->theme['color1']; ?>', '<?php echo $this->theme['color2']; ?>', '<?php echo $this->theme['color3']; ?>', '<?php echo $this->theme['color4']; ?>', '<?php echo $this->theme['color5']; ?>', '<?php echo $this->theme['color6']; ?>', '<?php echo $this->theme['color7']; ?>', '<?php echo $this->theme['color8']; ?>');
    });
    function makeColorPicker(color1, color2, color3, color4, color5, color6, color7, color8) {
        jQuery('input#color1').ColorPicker({
            color: color1,
            onShow: function (colpkr) {
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                jQuery("div#js_menu_wrapper").css('backgroundColor', '#' + hex);
                jQuery("div.js-image").css('border-color', '#' + hex);
                jQuery("span.js-title a").css('color', '#' + hex);
                jQuery('input#color1').css('backgroundColor', '#' + hex).val('#' + hex);
                //jQuery("div#js_menu_wrapper").css('borderColor', '#' + hex);
                // new
                //jQuery("a.js-title").each(function(){
                //    jQuery(this).css('color', '#' + hex);
                //});
                jQuery("a.js-th-title-clr").each(function(){
                    jQuery(this).css('color', '#' + hex);
                });
                jQuery("img.js-th-imgborder").each(function(){
                    jQuery(this).css('borderColor', '#' + hex);
                });
            }
        });
        var backcount = 1;
        jQuery('input#color2').ColorPicker({
            color: color2,
            onShow: function (colpkr) {
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                jQuery('input#color2').css('backgroundColor', '#' + hex).val('#' + hex);
                jQuery('div#js_menu_wrapper').css('border-color', '#' + hex).val('#' + hex);
                jQuery("div.page_heading").css('border-Color', '#' + hex);
                
                jQuery("button.tp_filter_button, a.js_job_quick_view_link, a.js_job_data_button").each(function () {
                    if (backcount == 1)
                        localStorage.setItem('BackColor', jQuery(this).css('backgroundColor'));
                    jQuery(this).hover(function () {
                        jQuery(this).css('backgroundColor', '#' + hex);
                        count++;
                    }, function () {
                        jQuery(this).css('backgroundColor', localStorage.getItem('BackColor'));
                    });
                });
                var menucount = 1;
                jQuery("a.js_menu_link ").each(function () {
                    if (menucount == 1)
                        localStorage.setItem('menuColor', jQuery(this).css('color'));
                    jQuery(this).hover(function () {
                        jQuery(this).css('color', '#' + hex);
                        count++;
                    }, function () {
                        jQuery(this).css('color', localStorage.getItem('menuColor'));
                    });
                });
                jQuery("span.js_controlpanel_section_title").each(function () {
                    jQuery(this).css({'color': '#' + hex, 'borderColor': '#' + hex});
                });
                jQuery("div.js_job_filter_wrapper,div.js_job_image_wrapper").each(function () {
                    jQuery(this).css('borderColor', '#' + hex);
                });
                jQuery("a.js_job_title, a.js_job_data_2_company_link").each(function () {
                    jQuery(this).css('color', '#' + hex);
                });
                jQuery("div.js_job_number").each(function () {
                    jQuery(this).css('backgroundColor', '#' + hex);
                });
            }
        });
        var count = 1;
        jQuery('input#color3').ColorPicker({
            color: color3,
            onShow: function (colpkr) {
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                jQuery('input#color3').css('backgroundColor', '#' + hex).val('#' + hex);
                jQuery('div.js-bottomrow').css('backgroundColor', '#' + hex).val('#' + hex);
            }
        });
        jQuery('input#color4').ColorPicker({
            color: color4,
            onShow: function (colpkr) {
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                jQuery('input#color4').css('backgroundColor', '#' + hex).val('#' + hex);
                jQuery('div.js-bottomrow').css('color', '#' + hex).val('#' + hex);
            }
        });
        jQuery('input#color5').ColorPicker({
            color: color5,
            onShow: function (colpkr) {
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                jQuery('input#color5').css('backgroundColor', '#' + hex).val('#' + hex);
                jQuery('div#js-jobs-wrapper').css('border-color', '#' + hex).val('#' + hex);
            }
        });
        jQuery('input#color6').ColorPicker({
            color: color6,
            onShow: function (colpkr) {
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                jQuery('input#color6').css('backgroundColor', '#' + hex).val('#' + hex);
                jQuery("span.js_job_data_2_title, span.js_job_data_2_value, span.js_job_data_location_title,span.js_job_data_location_value,span.js_job_posted").each(function () {
                    jQuery(this).css('color', '#' + hex)
                });
                // new
                jQuery(".js-button").each(function(){
                    jQuery(this).css("backgroundColor","#"+hex);
                });
                jQuery("button.tp_filter_button").each(function(){
                    jQuery(this).css("backgroundColor","#"+hex);
                });

            }
        });
        jQuery('input#color7').ColorPicker({
            color: color7,
            onShow: function (colpkr) {
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                jQuery('input#color7').css('backgroundColor', '#' + hex).val('#' + hex);
                jQuery('a.js-btn-apply').css('color', '#' + hex).val('#' + hex);
                 jQuery("div#js_menu_wrapper a").css('color', '#' + hex);
            }
        });
        jQuery('input#color8').ColorPicker({
            color: color8,
            onShow: function (colpkr) {
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                jQuery('input#color8').css('backgroundColor', '#' + hex).val('#' + hex);
                jQuery('span.js-bold').css('color', '#' + hex).val('#' + hex);
                jQuery('label.pageform').css('color', '#' + hex).val('#' + hex);
            }
        });

    }
</script>
<div id="jsjobs-preset-theme-back" style=""></div>
<div id="jsjobs-preset-theme-popup" style="">
    <div id="js_job_wrapper">
        <span class="js_job_controlpanelheading"><?php echo JText::_('Preset Theme'); ?></span>        
        <div class="js_theme_wrapper">
            <div class="theme_platte">
                <div class="color_wrapper">
                    <div class="color 1" style="background:#36BC9B;"></div>
                    <div class="color 2" style="background:#4D4D4D;"></div>
                    <div class="color 3" style="background:#FAFAFA;"></div>
                    <div class="color 4" style="background:#797B7E;"></div>
                    <div class="color 5" style="background:#D4D4D5;"></div>
                    <div class="color 6" style="background:#F0F0F0;"></div>
                    <div class="color 7" style="background:#FFFFFF;"></div>
                    <div class="color 8" style="background:#3C3435;"></div>
                    <span class="theme_name"><?php echo JText::_('Mint'); ?></span>
                    <img class="preview" src="components/com_jsjobs/include/images/themes/preview1.png" />
                    <a href="#" class="preview"></a>
                    <a href="#" class="set_theme"></a>
                </div>
            </div>
            <div class="theme_platte">
                <div class="color_wrapper">
                    <div class="color 1" style="background:#e43039;"></div>
                    <div class="color 2" style="background:#4D4D4D;"></div>
                    <div class="color 3" style="background:#FAFAFA;"></div>
                    <div class="color 4" style="background:#797B7E;"></div>
                    <div class="color 5" style="background:#D4D4D5;"></div>
                    <div class="color 6" style="background:#F0F0F0;"></div>
                    <div class="color 7" style="background:#FFFFFF;"></div>
                    <div class="color 8" style="background:#3C3435;"></div>
                    <span class="theme_name"><?php echo JText::_('Red'); ?></span>
                    <img class="preview" src="components/com_jsjobs/include/images/themes/preview2.png" />
                    <a href="#" class="preview"></a>
                    <a href="#" class="set_theme"></a>
                </div>
            </div>
            <div class="theme_platte">
                <div class="color_wrapper">
                    <div class="color 1" style="background:#3BAEDA;"></div>
                    <div class="color 2" style="background:#4FC0E8;"></div>
                    <div class="color 3" style="background:#EFF8FB;"></div>
                    <div class="color 4" style="background:#797B7E;"></div>
                    <div class="color 5" style="background:#D4D4D5;"></div>
                    <div class="color 6" style="background:#FFFFFF;"></div>
                    <div class="color 7" style="background:#FFFFFF;"></div>
                    <div class="color 8" style="background:#3C3435;"></div>
                    <span class="theme_name"><?php echo JText::_('Aqua'); ?></span>
                    <img class="preview" src="components/com_jsjobs/include/images/themes/preview3.png" />
                    <a href="#" class="preview"></a>
                    <a href="#" class="set_theme"></a>
                </div>
            </div>
            <div class="theme_platte">
                <div class="color_wrapper">
                    <div class="color 1" style="background:#4D89DC;"></div>
                    <div class="color 2" style="background:#4D4D4D;"></div>
                    <div class="color 3" style="background:#F5F5F5;"></div>
                    <div class="color 4" style="background:#666666;"></div>
                    <div class="color 5" style="background:#D4D4D5;"></div>
                    <div class="color 6" style="background:#F0F0F0;"></div>
                    <div class="color 7" style="background:#FFFFFF;"></div>
                    <div class="color 8" style="background:#3C3435;"></div>
                    <span class="theme_name"><?php echo JText::_('Blue Jeans'); ?></span>
                    <img class="preview" src="components/com_jsjobs/include/images/themes/preview4.png" />
                    <a href="#" class="preview"></a>
                    <a href="#" class="set_theme"></a>
                </div>
            </div>
            <div class="theme_platte">
                <div class="color_wrapper">
                    <div class="color 1" style="background:#8CC051;"></div>
                    <div class="color 2" style="background:#A0D465;"></div>
                    <div class="color 3" style="background:#F5F5F5;"></div>
                    <div class="color 4" style="background:#666666;"></div>
                    <div class="color 5" style="background:#D4D4D5;"></div>
                    <div class="color 6" style="background:#F0F0F0;"></div>
                    <div class="color 7" style="background:#FFFFFF;"></div>
                    <div class="color 8" style="background:#3C3435;"></div>
                    <span class="theme_name"><?php echo JText::_('Grass'); ?></span>
                    <img class="preview" src="components/com_jsjobs/include/images/themes/preview5.png" />
                    <a href="#" class="preview"></a>
                    <a href="#" class="set_theme"></a>
                </div>
            </div>
            <div class="theme_platte">
                <div class="color_wrapper">
                    <div class="color 1" style="background:#DB4453;"></div>
                    <div class="color 2" style="background:#ED5564;"></div>
                    <div class="color 3" style="background:#F5F5F5;"></div>
                    <div class="color 4" style="background:#666666;"></div>
                    <div class="color 5" style="background:#D4D4D5;"></div>
                    <div class="color 6" style="background:#F0F0F0;"></div>
                    <div class="color 7" style="background:#FFFFFF;"></div>
                    <div class="color 8" style="background:#3C3435;"></div>
                    <span class="theme_name"><?php echo JText::_('Grape Fruit'); ?></span>
                    <img class="preview" src="components/com_jsjobs/include/images/themes/preview6.png" />
                    <a href="#" class="preview"></a>
                    <a href="#" class="set_theme"></a>
                </div>
            </div>
            <div class="theme_platte">
                <div class="color_wrapper">
                    <div class="color 1" style="background:#967BDC;"></div>
                    <div class="color 2" style="background:#AC92ED;"></div>
                    <div class="color 3" style="background:#F5F5F5;"></div>
                    <div class="color 4" style="background:#666666;"></div>
                    <div class="color 5" style="background:#D4D4D5;"></div>
                    <div class="color 6" style="background:#F0F0F0;"></div>
                    <div class="color 7" style="background:#FFFFFF;"></div>
                    <div class="color 8" style="background:#3C3435;"></div>
                    <span class="theme_name"><?php echo JText::_('Lavander'); ?></span>
                    <img class="preview" src="components/com_jsjobs/include/images/themes/preview7.png" />
                    <a href="#" class="preview"></a>
                    <a href="#" class="set_theme"></a>
                </div>
            </div>
            <div class="theme_platte">
                <div class="color_wrapper">
                    <div class="color 1" style="background:#000000;"></div>
                    <div class="color 2" style="background:#333333;"></div>
                    <div class="color 3" style="background:#F5F5F5;"></div>
                    <div class="color 4" style="background:#1A1A1A;"></div>
                    <div class="color 5" style="background:#D4D4D5;"></div>
                    <div class="color 6" style="background:#F0F0F0;"></div>
                    <div class="color 7" style="background:#FFFFFF;"></div>
                    <div class="color 8" style="background:#1A1A1A;"></div>
                    <span class="theme_name"><?php echo JText::_('Black'); ?></span>
                    <img class="preview" src="components/com_jsjobs/include/images/themes/preview8.png" />
                    <a href="#" class="preview"></a>
                    <a href="#" class="set_theme"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('a#preset_theme').click(function (e) {
            e.preventDefault();
            jQuery("div#jsjobs-preset-theme-popup").fadeIn();
            jQuery("div#jsjobs-preset-theme-back").fadeIn();
        });
        jQuery("div#jsjobs-preset-theme-back").click(function () {
            jQuery("div#jsjobs-preset-theme-popup").fadeOut();
            jQuery("div#jsjobs-preset-theme-back").fadeOut();
        });
        jQuery('a.preview').each(function (index, element) {
            jQuery(this).hover(function () {
                if (index > 2)
                    jQuery(this).parent().find('img.preview').css('top', "-110px");
                jQuery(jQuery(this).parent().find('img.preview')).show();
            }, function () {
                jQuery(jQuery(this).parent().find('img.preview')).hide();
            });
        });
        jQuery('a.set_theme').each(function (index, element) {
            jQuery(this).click(function (e) {
                e.preventDefault();
                var div = jQuery(this).parent();
                var color1 = rgb2hex(jQuery(div.find('div.1')).css('backgroundColor'));
                var color2 = rgb2hex(jQuery(div.find('div.2')).css('backgroundColor'));
                var color3 = rgb2hex(jQuery(div.find('div.3')).css('backgroundColor'));
                var color4 = rgb2hex(jQuery(div.find('div.4')).css('backgroundColor'));
                var color5 = rgb2hex(jQuery(div.find('div.5')).css('backgroundColor'));
                var color6 = rgb2hex(jQuery(div.find('div.6')).css('backgroundColor'));
                var color7 = rgb2hex(jQuery(div.find('div.7')).css('backgroundColor'));
                var color8 = rgb2hex(jQuery(div.find('div.8')).css('backgroundColor'));
                jQuery('input#color1').val(color1).css('backgroundColor', color1).ColorPickerSetColor(color1);
                jQuery('input#color2').val(color2).css('backgroundColor', color2).ColorPickerSetColor(color2);
                jQuery('input#color3').val(color3).css('backgroundColor', color3).ColorPickerSetColor(color3);
                jQuery('input#color4').val(color4).css('backgroundColor', color4).ColorPickerSetColor(color4);
                jQuery('input#color5').val(color5).css('backgroundColor', color5).ColorPickerSetColor(color5);
                jQuery('input#color6').val(color6).css('backgroundColor', color6).ColorPickerSetColor(color6);
                jQuery('input#color7').val(color7).css('backgroundColor', color7).ColorPickerSetColor(color7);
                jQuery('input#color8').val(color8).css('backgroundColor', color8).ColorPickerSetColor(color8);
                themeSelectionEffect(color1, color2, color3, color4, color5, color6, color7, color8);
                jQuery("div#jsjobs-preset-theme-popup").fadeOut();
                jQuery("div#jsjobs-preset-theme-back").fadeOut();
            });
        });
    });
    function rgb2hex(rgb) {
        rgb = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);
        function hex(x) {
            return ("0" + parseInt(x).toString(16)).slice(-2);
        }
        return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    }
    function themeSelectionEffect(color1, color2, color3, color4, color5, color6, color7, color8) {
        jQuery("div#js_menu_wrapper").css('borderColor', color1);
        jQuery("div#js_menu_wrapper").css('backgroundColor', color2);
        jQuery("button.tp_filter_button, a.js_job_quick_view_link, a.js_job_data_button").each(function () {
            localStorage.setItem('BackColor', jQuery(this).css('backgroundColor'));
            jQuery(this).hover(function () {
                jQuery(this).css('backgroundColor', color2);
            }, function () {
                jQuery(this).css('backgroundColor', localStorage.getItem('BackColor'));
            });
        });
        jQuery("a.js_menu_link ").each(function () {
            localStorage.setItem('menuColor', jQuery(this).css('color'));
            jQuery(this).hover(function () {
                jQuery(this).css('color', color2);
            }, function () {
                jQuery(this).css('color', localStorage.getItem('menuColor'));
            });
        });
        jQuery("span.js_controlpanel_section_title").each(function () {
            jQuery(this).css({'color': color2, 'borderColor': color2});
        });
        jQuery("div.js_job_filter_wrapper,div.js_job_image_wrapper").each(function () {
            jQuery(this).css('borderColor', color2);
        });
        jQuery("a.js_job_title, a.js_job_data_2_company_link").each(function () {
            jQuery(this).css('color', color2);
        });
        jQuery("div.js_job_number").each(function () {
            jQuery(this).css('backgroundColor', color2);
        });
        jQuery("button.tp_filter_button, a.js_job_quick_view_link, a.js_job_data_button").each(function () {
            localStorage.setItem('preColor', jQuery(this).css('color'));
            jQuery(this).hover(function () {
                jQuery(this).css('color', color3);
            }, function () {
                jQuery(this).css('color', localStorage.getItem('preColor'));
            });
        });
        jQuery("a.js_menu_link").each(function () {
            jQuery(this).css('color', color3);
        });
        jQuery("div.js_job_main_wrapper,div.js_job_data_1,div.js_job_data_3").each(function () {
            jQuery(this).css('borderColor', color4);
        });
        jQuery("button.tp_filter_button, a.js_job_quick_view_link, a.js_job_data_button").each(function () {
            jQuery(this).css('borderColor', color4);
        });
        jQuery("div.js_job_main_wrapper").each(function () {
            jQuery(this).css('backgroundColor', color5);
        });
        jQuery("span.js_job_data_2_title, span.js_job_data_2_value, span.js_job_data_location_title,span.js_job_data_location_value,span.js_job_posted").each(function () {
            jQuery(this).css('color', color6)
        });
        localStorage.setItem('BackColor', color7);
        jQuery("button.tp_filter_button, a.js_job_quick_view_link, a.js_job_data_button, div.js_job_image_wrapper").each(function () {
            jQuery(this).css('backgroundColor', color7)
        });
        localStorage.setItem('preColor', color8);
        jQuery("button.tp_filter_button, a.js_job_quick_view_link, a.js_job_data_button").each(function () {
            jQuery(this).css('color', color8)
        });
    }
</script>