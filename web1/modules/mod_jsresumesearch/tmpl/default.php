<?php
/**
  + Created by: Ahmad Bilal
 * Company:     Buruj Solutions
  + Contact:        www.burujsolutions.com , info@burujsolutions.com
  www.joomsky.com, ahmad@joomsky.com
 * Created on:  Dec 2, 2009
  ^
  + Project:        JS Jobs
 * File Name:   module/hotjsjobs.php
  ^
 * Description: Module for JS Jobs
  ^
 * History:     1.0.2 - Nov 27, 2010
  ^
 */
defined('_JEXEC') or die;

$document = JFactory::getDocument();
$version = new JVersion;
$joomla = $version->getShortVersion();
$jversion = substr($joomla, 0, 3);
if ($jversion < 3) {
    $document->addScript('components/com_jsjobs/js/jquery.js');
    JHtml::_('behavior.mootools');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addStyleSheet(JURI::root().'components/com_jsjobs/css/style.css', 'text/css');
require_once(JPATH_ROOT.'/components/com_jsjobs/css/style_color.php');
$language = JFactory::getLanguage();
if($language->isRtl()){
    $document->addStyleSheet(JURI::root().'components/com_jsjobs/css/style_rtl.css', 'text/css');
}

if ($result['showtitle'] == 1) {
    $moduleclass_sfx = $params->get('moduleclass_sfx');
    if (!empty($moduleclass_sfx) || $moduleclass_sfx != '') {
        echo '
                            <div class="' . $moduleclass_sfx . '"><h3>
                                <span>
                                        <span id="tp_headingtext_left"></span>
                                        <span id="tp_headingtext_center">' . $result['title'] . '</span>
                                        <span id="tp_headingtext_right"></span>             
                                </span></h3>
                            </div>
                        ';
    } else {
        echo '
                            <div id="tp_heading">
                                <span id="tp_headingtext">
                                        <span id="tp_headingtext_left"></span>
                                        <span id="tp_headingtext_center">' . $result['title'] . '</span>
                                        <span id="tp_headingtext_right"></span>             
                                </span>
                            </div>
                        ';
    }
}
?>
<form class="jsjobs-form" action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid=' . $result['itemid']); ?>" method="post" name="js-jobs-form-mod" id="js-jobs-form-mod">
<?php if ($result['sh_title'] == 1) { ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Application title'); ?>
            </div>
            <div class="text-left">
                <input class="inputbox" type="text" name="title" size="27" maxlength="255"  />
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_name'] == 1) { ?> 
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Name'); ?>
            </div>
            <div class="text-left">
                <input class="inputbox" type="text" name="name" size="27" maxlength="255"  />
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_nationality'] == 1) { ?> 
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Nationality'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['nationality']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_gender'] == 1) { ?> 
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Gender'); ?> 
            </div>
            <div class="text-left">
    <?php echo $result['gender']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_category'] == 1) { ?> 
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Categories'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['job_categories']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_subcategory'] == 1) { ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Sub categories'); ?>
            </div>
            <div class="text-left" id="modresumefj_subcategory">
    <?php echo $result['job_subcategories']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_jobtype'] == 1) { ?> 
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Job type'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['job_type']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_salaryrange'] == 1) { ?> 
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Salary range'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['currency'] . ' ' . $result['salary_range']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_heighesteducation'] == 1) { ?> 
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Highest education'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['heighest_finisheducation']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_experience'] == 1) { ?> 
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Experience'); ?>
            </div>
            <div class="text-left">
                <?php echo $result['expmin'].$result['expmax']; ?>
            </div>
        </div>  
<?php } ?>

    <?php if ($result['sh_iamavailable'] == 1) { ?> 
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left">
    <?php echo JText::_('Available'); ?>
            </div>
            <div class="text-left">
                <input type='checkbox' name='iamavailable' value='1'  />
            </div>
        </div>  
<?php } ?>
    <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
        <input type="submit" class="button" id="button" name="submit_app" onclick="document.mrsadminForm.submit();" value="<?php echo JText::_('Search resume'); ?>" />&nbsp;&nbsp;&nbsp;
        <a id="button" style="white-space:nowrap;"class="button minpad" href="index.php?option=com_jsjobs&c=jsjobs&view=resume&layout=resumesearch&Itemid=<?php echo $result['itemid']; ?>"><?php echo JText::_('Advanced search'); ?></a>
    </div>
    <input type="hidden" name="isresumesearch" value="1" />
    <input type="hidden" name="view" value="resume" />
    <input type="hidden" name="layout" value="resume_searchresults" />
    <input type="hidden" name="uid" value="" />
    <input type="hidden" name="option" value="com_jsjobs" />
    <input type="hidden" name="zipcode" value="" />
</form>
<script language="javascript" type="text/javascript">
    function modfj_getsubcategories(src, val) {
        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=subcategory&task=listsubcategoriesForSearch",{val:val,md:1},function(data){
            if(data){
                jQuery('#'+src).html(data);                
            }
        });
    }

</script>
