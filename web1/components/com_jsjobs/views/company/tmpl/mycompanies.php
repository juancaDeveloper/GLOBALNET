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
?>
<script language=Javascript>
    function confirmdeletecompany() {
        return confirm("<?php echo JText::_('Are you sure to delete the company').'!'; ?>");
    }
</script>
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
    if ($this->mycompany_allowed == VALIDATE) {
    ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><span class="jsjobs-title-componet"><?php echo JText::_('My Companies'); ?></span>
        <span class="jsjobs-add-resume-btn"><a class="jsjobs-resume-a" href="index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=<?php echo $this->Itemid; ?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/add-icon.png"><span class="jsjobs-add-resume-btn"> <?php echo JText::_('Add New Company'); ?></span></a></span>
        </span>
    <?php
        if ($this->companies) {?>
            <div class="jsjobs-folderinfo">
                <form action="index.php" method="post" name="adminForm">
                    <?php
                    $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(1);
                    $_field = array();
                    foreach($fieldsordering AS $field){
                        if($field->showonlisting == 1){
                            $_field[$field->field] = $field->fieldtitle;
                        }
                    }
                    $common = JSModel::getJSModel('common');
                    foreach ($this->companies AS $company) {
						$companyid = ($this->isjobsharing != "") ? $company->saliasid : $company->aliasid;
						$companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($companyid);
						$com_view_link = "index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=31&cd=" . $companyaliasid . "&Itemid=" . $this->Itemid;
?>

                        <div class="jsjobs-main-wrapper-mycompanies">
                        <div class="jsjobs-main-companieslist"> 
                               <div class="jsjobs-main-wrap-imag-data">
                               <div class="com-logo">
                               <?php if (isset($_field['logo'])) { ?>
                                <a class="img" href="<?php echo $com_view_link; ?>">
                                    <?php
                                    $imgsrc = $common->getCompanyLogo($company->id, $company->logofilename , $this->config);
                                    ?>
                                    <img src="<?php echo $imgsrc; ?>" />
                                </a>
                            <?php }else{
                                $imgsrc = $common->getCompanyLogo( 1 , "" , $this->config);
                                echo '<a class="img" href="'.$com_view_link.'"><img src="'.$imgsrc.'"/></a>';
                                } ?>
                               </div>            
                            <div class="jsjobs-data-area">
                                <div class="jsjobs-data-1">
                                    <?php if (isset($_field['name']) && $this->config['comp_name'] == 1) { ?>
                                        <a href="<?php echo $com_view_link; ?>"><span class="jsjobs-title"><?php echo $company->name; ?></span></a>
                                    <span class="jsjobs-gold-featured">
                                     <?php
                                     $showgold = true;
                                     $showfeatured = true;
                                    if($company->isgoldcompany == 1 AND date('Y-m-d',strtotime($company->endgolddate)) > date('Y-m-d')){
                                        $showgold = false;
                                        ?>
                                        <span class="goldnew" data-id="<?php echo $company->id; ?>"><span class="jsjobs-goldstatus"><?php echo JText::_('Gold'); ?></span><span class="goldnew-onhover" id="gold<?php echo $company->id; ?>" style="display:none"><?php echo JText::_("Expiry Date").': '.JHtml::_('date',$company->endgolddate,$this->config['date_format']); ?><img src="administrator/components/com_jsjobs/include/images/bottom-tool-tip.png" alt="downhover-part"></span></span>
                                <?php
                                    }elseif($company->isgoldcompany == 0){
                                        $showgold = false;
                                        ?>
                                        <span class="goldnew" data-id="<?php echo $company->id; ?>"><span class="jsjobs-goldstatus"><?php echo JText::_('Wating...'); ?></span></span>
                                    <?php
                                    }
                                    if($company->isfeaturedcompany == 1 AND date('Y-m-d',strtotime($company->endfeatureddate)) > date('Y-m-d')){
                                        $showfeatured = false;
                                        ?>
                                        <span class="featurednew"><span class="jsjobs-faturedstatus"><?php echo JText::_('Featured'); ?></span><span class="featurednew-onhover" style="display:none"><?php echo JText::_("Expiry Date").': '.JHtml::_('date',$company->endfeatureddate,$this->config['date_format']); ?><img src="administrator/components/com_jsjobs/include/images/bottom-tool-tip.png" alt="downhover-part"></span></span>
                                <?php
                                    }elseif($company->isfeaturedcompany == 0){
                                        $showfeatured = false;
                                        ?>
                                        <span class="featurednew"><span class="jsjobs-faturedstatus"><?php echo JText::_('Waiting...'); ?></span></span>
                                <?php
                                    }
                                ?>
                                    </span>
                                    <?php } ?>
                                    <span class="jsjobs-posted"><?php echo JText::_('Created') . ': ' . JHtml::_('date', $company->created, $this->config['date_format']); ?></span>
                                </div>
                                <div class="jsjobs-data-2">
                                    <?php if (isset($_field['url']) && $this->config['comp_show_url'] == 1) { ?>

                                        <div class="jsjobs-data-2-wrapper">
                                            <span class="jsjobs-data-2-title"><?php echo JText::_($_field['url']) . ":"; ?></span>
                                                <span class="jsjobs-data-2-value">
                                                    <a class="js_job_company_anchor" target="_blank" href="<?php echo $company->url; ?>">
                                                        <?php echo $company->url; ?>
                                                    </a>
                                                </span>
                                            </span></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($_field['jobcategory'])) { ?>
                                        <div class="jsjobs-data-2-wrapper">
                                            <span class="jsjobs-data-2-title"><?php echo JText::_($_field['jobcategory']) . ":"; ?></span>
                                            <span class="jsjobs-data-2-value"><?php echo htmlspecialchars($company->cat_title); ?></span>
                                        </div>
                                    <?php } ?>
                                    
                                    <?php 
                                        $customfields = getCustomFieldClass()->userFieldsData( 1 , 1);
                                        foreach ($customfields as $field) {
                                            echo  getCustomFieldClass()->showCustomFields($field, 8 ,$company , 1);
                                        }
                                        ?>
                                </div>

                            </div>
                           </div>
                        </div>

                        <div class="jsjobs-main-companieslist-btn"> 
                            <?php if ($this->config['comp_city'] == 1) { ?>
                                <div class="jsjobs-data-3">
                                    <span class="js-jobs-data-location-title"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png">&nbsp;</span>
                                        <?php if (isset($company->city) AND ! empty($company->city)) { ?>
                                            <span class="jsjobs-data-location-value">
                                                <?php    echo $company->multicity; ?>
                                            </span>
                                        <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="jsjobs-data-4">
                                <?php
                                $companyid = ($this->isjobsharing != "") ? $company->saliasid : $company->aliasid;
                                $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($companyid);
                                $com_view_link = "index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=31&cd=" . $companyaliasid . "&Itemid=" . $this->Itemid;
                                ?>
                                    <?php 
                                        if ($company->status == 0) { ?>
                                            <font id="jsjobs-status-btn"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Waiting for approval');?></font>
                                        <?php
                                        } elseif ($company->status == -1) { ?>
                                            <font id="jsjobs-status-btn-rejected"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Rejected');?></font>
                                        <?php
                                        } elseif ($company->status == 1) { ?>
                                        <a class="company-icon" href="index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&cd=<?php echo $company->aliasid . "&Itemid=" . $this->Itemid; ?>"  title="<?php echo JText::_('Edit'); ?>">
                                            <img class="icon" src="<?php echo JURI::root();?>components/com_jsjobs/images/edit.png" />
                                        </a>                    
                                        <a class="company-icon" href="<?php echo $com_view_link; ?>"  title="<?php echo JText::_('View'); ?>">
                                            <img src="<?php echo JURI::root();?>components/com_jsjobs/images/view.png" />
                                        </a>
                                        <?php 
                                            if($this->companyconfig['show_fe_goldcompany_button'] == 1){
                                                if (! ($company->isgoldcompany == 1 AND date('Y-m-d',strtotime($company->endgolddate)) > date('Y-m-d'))) {?>
                                                <?php $link = JRoute::_('index.php?option=com_jsjobs&task=company.addtogoldcompany&cd=' . $company->aliasid . '&Itemid=' . $this->Itemid.'&'.JSession::getFormToken().'=1' ,false); ?>
                                                <a class="company-icon-gold" href="<?php echo $link; ?>" ><img src="<?php echo JURI::root();?>components/com_jsjobs/images/add-gold.png" title="<?php echo JText::_('Gold Company'); ?>"/><span class="jsjobs-gold"><?php echo JText::_('Gold'); ?></span></a>
                                                <?php }
                                            }   
                                        if($this->companyconfig['show_fe_featuredcompany_button'] == 1){
                                            if (! ($company->isfeaturedcompany == 1 AND date('Y-m-d',strtotime($company->endfeatureddate)) > date('Y-m-d'))) {?>
                                                <?php $link = JRoute::_('index.php?option=com_jsjobs&task=company.addtofeaturedcompany&cd=' . $company->aliasid . '&Itemid=' . $this->Itemid.'&'.JSession::getFormToken().'=1' ,false); ?>
                                                <a class="company-icon-featured" href="<?php echo $link;?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/add-featured.png" title="<?php echo JText::_('Featured Company'); ?>"/><span class="jsjobs-featured"><?php echo JText::_('Featured'); ?></span></a>
                                            <?php 
                                                }
                                        } ?>
                                        <a class="company-icon" href="index.php?option=com_jsjobs&task=company.deletecompany&cd=<?php echo $company->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>&<?php echo JSession::getFormToken(); ?>=1" onclick=" return confirmdeletecompany();"  title="<?php echo JText::_('Delete'); ?>">
                                            <img  src="<?php echo JURI::root();?>components/com_jsjobs/images/force-delete.png" />
                                        </a>
                                        <?php if( $this->getJSModel(VIRTUEMARTJSJOBS)->{VIRTUEMARTJSJOBSFUN}("UDZiWndkam9tc29jaWFsZ3RDV3VQ") &&
                                                  $this->getJSModel('configurations')->getConfigValue('jomsocial_allowpostcompany') == 1 ){ ?>
                                        <a class="company-icon jsjobs-jomsocial-icon" href="index.php?option=com_jsjobs&task=company.postcompanyonjomsocial&id=<?php echo $company->id; ?>&Itemid=<?php echo $this->Itemid; ?>&<?php echo JSession::getFormToken(); ?>=1" title="<?php echo JText::_('Post On JomSocial'); ?>">
                                            <img src="<?php echo JURI::root();?>components/com_jsjobs/images/social-share.png">
                                        </a>
                                        <?php } ?>
                                    <?php
                                    } ?>
                                </div>
                            </div>           
                        </div>    
                <?php
            }
            ?>
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="task" value="deletecompany" />
                    <input type="hidden" name="c" value="company" />
                    <input type="hidden" id="id" name="id" value="" />
                </form>
                </div>
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=' . $this->Itemid ,false); ?>" method="post">
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
    } else {
        switch ($this->mycompany_allowed) {
            case JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Job seeker not allowed', 'Job seeker is not allowed in employer private area', 0);
            break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role',$vartext, $link);
                break;
            case VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
                break;
        }
    }
}
?>

</div>

<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery(".goldnew").hover(function(){
            jQuery(this).find(".goldnew-onhover").show();
        },function() {
            jQuery(this).find('span.goldnew-onhover').fadeOut("slow");
        });    
        jQuery(".featurednew").hover(function(){            
            jQuery(this).find("span.featurednew-onhover").show();
        },function() {
            jQuery(this).find('.featurednew-onhover').fadeOut("slow");
        });
    });
</script>
