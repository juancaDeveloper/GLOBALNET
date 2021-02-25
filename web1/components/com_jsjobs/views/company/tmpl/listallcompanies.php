<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     https://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.pane');
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_jsjobs/css/token-input-jsjobs.css');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('components/com_jsjobs/js/jquery.tokeninput.js');
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>
<?php
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Companies'); ?></span>
    <?php
    $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(1);
    $_field = array();
    foreach($fieldsordering AS $field){
        if($field->showonlisting == 1){
            $_field[$field->field] = $field->fieldtitle;
        }
    }
    if ($this->sortlinks['sortorder'] == 'ASC')
        $img = JURI::root()."components/com_jsjobs/images/sort0.png";
    else
        $img = JURI::root()."components/com_jsjobs/images/sort1.png";  
    $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=listallcompanies&Itemid=' . $this->Itemid;
    ?>
    <form action="<?php echo $link.'&sortby='.$this->sortlinks['sorton'].strtolower($this->sortlinks['sortorder']); ?>" method="post" name="adminForm" id="adminForm">
        <div id="sortbylinks">
            <ul>
                <?php if (isset($_field['name'])) { ?>
                <li><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['name']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'name') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'name') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Name'); ?></a></li>
                <?php } ?>
                <?php if (isset($_field['jobcategory'])) { ?>
                <li><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['category']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'category') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'category') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Category'); ?></a></li>
                <?php } ?>
                <?php //if (isset($_field['city'])) { ?>
                <li><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['city']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'city') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'city') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Location'); ?></a></li>
                <?php //} ?>
                <li><a href="<?php echo $link ?>&sortby=<?php echo $this->sortlinks['created']; ?>" class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected' ?>"><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Posted'); ?></a></li>
            </ul>
        </div>
        <div class="companies filterwrapper">
            <input type="text" id="companyname" name="companyname" placeholder="<?php echo JText::_("Company name"); ?>" value="<?php echo $this->filter_search['companyname']; ?>" />
            <span class="filterlocation">
                <img src="<?php echo JURI::root()."components/com_jsjobs/images/filternav.png"; ?>">
                <input type="text" id="companycity" name="companycity">                  
            </span>
            <input type="submit" class="jsjobs-go" value="<?php echo JText::_('Search'); ?>" />
            <input type="button" class="jsjobs-reset" value="<?php echo JText::_('Reset'); ?>" />
        </div>
    </form>
    <?php
    if ($this->companies) {
        $common = JSModel::getJSModel('common');
        foreach ($this->companies AS $company) {
            $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($company->id);
            $link_viewcomp = "index.php?option=com_jsjobs&c=company&view=company&layout=view_company&cd=".$companyaliasid."&nav=42&Itemid=".$this->Itemid; ?>
            <div class="jsjobs-main-wrapper-listcompany">
               <div class="jsjobs-wrapper-listcompany">
                    <div class="jsjobs-listcompany">
                        <?php if (isset($_field['logo'])) { ?>
                            <div class="jsjobs-image-area">
                                <a href="<?php echo $link_viewcomp;?>">
                                <div class="jsjobs-image-wrapper-mycompany">
                                   <div class="jsjobs-image-border">
                                    <?php
                                    $imgsrc = $common->getCompanyLogo($company->id, $company->companylogo , $this->config);
                                    ?>
                                    <img  src="<?php echo $imgsrc; ?>" />
                                    </div>
                                </div>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="jsjobs-data-area">
                        <div class="jsjob-data-1">
                            <?php if (isset($_field['name'])) { ?>
                                 <span class="jsjobs-data-jobtitle-title">
                                    <a class="jsjobs-titlelink" href="<?php echo $link_viewcomp;?>">
                                        <span class="jsjobs-data-jobtitle">
                                            <?php echo htmlspecialchars($company->companyname);?>
                                        </span>
                                    </a>
                                    <?php
                                    if($company->isgoldcompany==1 AND $company->endgolddate > date('Y-m-d')){ ?>
                                        <span class="js_gold"><?php echo JText::_('Gold');?></span>
                                    <?php
                                    }
                                    if($company->isfeaturedcompany==1 AND $company->endfeatureddate > date('Y-m-d')){ ?>
                                        <span class="js_feature"><?php echo JText::_('Featured');?></span>
                                    <?php
                                    } ?>
                                </span>
                                <?php } ?>
                                <?php if (isset($_field['url'])) { ?>
                                    <span class="jsjobs-listcompany-location">
                                        <span class="jsjobs-listcompany-website"><?php echo JText::_($_field['url']);?>: </span>
                                        <?php 
                                        if ($company->companyurl) {
                                            echo '<a class="companyanchor" target="_blank" href="' . $company->companyurl . '">' . $company->companyurl . '</a>';
                                        } ?>
                                    </span>
                                <?php
                                }?>
                                <?php 
                                    $customfields = getCustomFieldClass()->userFieldsData( 1 , 1);
                                    foreach ($customfields as $field) {
                                        echo  getCustomFieldClass()->showCustomFields($field, 4 ,$company , 1);
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jsjobs-listcompany-button">
                    <span class="jsjobs-location">
                        <img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png">
                        <?php if (isset($company->multicity) AND ! empty($company->multicity)) { ?>
                            <span class="jsjobs-data-location-value">              
                                <?php echo htmlspecialchars($company->multicity); ?>
                            </span>
                        <?php } ?>
                    </span>
                    <span class="jsjobs-viewalljobs-btn">
                        <a class="js_listcompany_button" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs&cd=<?php echo $company->alias . '-' . $company->id; ?>&Itemid=<?php echo $this->Itemid; ?>"><?php echo JText::_('View All Jobs'); ?></a>
                    </span>
                </div>
            </div>
            <?php
        } ?>
        <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=listallcompanies&Itemid=' . $this->Itemid ,false); ?>" method="post">
           <div id="jsjobs_jobs_pagination_wrapper">
                    <div class="jsjobs-resultscounter">
                        <?php echo $this->pagination->getResultsCounter(); ?>
                    </div>
                    <div class="jsjobs-plinks">
                        <?php echo $this->pagination->getPagesLinks(); ?>
                    </div>
                    <div class="jsjobs-lbox">
                        <?php echo $this->pagination->getLimitBox(); ?>
                    </div>
                </div>
        </form>	
    <?php } else { // no result found in this category 
        $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
    }
    ?>
    </div>
    <?php
}  //ol
?>	
 </div>
<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>
<script type="text/javascript" language="javascript">
jQuery(document).ready(function () {
    jQuery("#companycity").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
        theme: "jsjobs",
        preventDuplicates: true,
        hintText: "<?php echo JText::_('Type In A Search'); ?>",
        noResultsText: "<?php echo JText::_('No Results'); ?>",
        searchingText: "<?php echo JText::_('Searching...'); ?>",
        prePopulate: <?php if(empty($this->multicities))  echo "''"; else echo $this->multicities;?>
    });

    jQuery(".jsjobs-reset").click(function(){
        jQuery("#companyname").val('');
        jQuery("#companycity").val('');
        jQuery("#adminForm").submit();
    });

});

</script>