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
} else { ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Company Information'); ?></span>
    <?php
    if (isset($this->company)) { ?>
            <div class="jsjobs-company-name">
                <?php if (isset($this->fieldsordering['name']) && $this->fieldsordering['name'] == 1 && $this->config['comp_name'] == 1) { ?>
                    <span class="jsjobs-company-title">
                        <?php echo $this->company->name; ?>
                    </span>
				<?php } ?>
                <div class="jsjobs-data-wrapper-email-location">
                    <?php
                    if (isset($this->fieldsordering['contactemail']) && $this->fieldsordering['contactemail'] == 1 && $this->config['comp_email_address']) {
                     ?>
                        <span class="jsjob-data-value-email"> 
                            <a href="mailto:<?php echo $this->company->contactemail; ?>" target="_blank"><?php echo $this->company->contactemail; ?></a> 
                            <?php
                                if($this->company->isgoldcompany==1 AND $this->company->endgolddate >= date('Y-m-d')){
                                    ?>
                                    <span class="jsjobs-gold"><?php echo JText::_('Gold');?></span>
                                    <?php
                                }
                                if($this->company->isfeaturedcompany==1 AND $this->company->endfeatureddate >= date('Y-m-d')){
                                    ?>
                                    <span class="jsjobs-featured"><?php echo JText::_('Featured');?></span>
                                    <?php
                                }
                                ?>
                        </span>
                        <?php
                        $style_address="";
                    }else{  $style_address = 'id="jsjobs_id_addressfull"'; }
                    if (isset($this->fieldsordering['city']) && $this->fieldsordering['city'] == 1 && $this->config['comp_city'] == 1) { ?>
                           <span <?php echo $style_address;?> class="jsjobs-location-comapny">
                               <span class="jsjob-data-title"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span>
                               <span class="jsjob-data-value"><?php if ($this->company->multicity != '') echo $this->company->multicity; ?></span>
                            </span>
                    <?php } ?>
                 </div>
                 <?php
                if (isset($this->fieldsordering['description']) && $this->fieldsordering['description'] == 1 ) { ?>
                    <div class="jsjobs-full-width-data"><div class="jsjobs-descrptn"><?php echo $this->company->description; ?></div></div>
                <?php } ?>
            
            </div>
            <div class="jsjobs-company-applied-data">
                <?php if (isset($this->fieldsordering['logo']) && $this->fieldsordering['logo'] == 1) { ?>
                    <div class="jsjobs-company-logo">
                       <span class="jsjobs-company-logo-wrap">
                            <span class="jsjobs-left-border">
                                <?php
                                $common = $this->getJSModel('common');
                                $logourl = $common->getCompanyLogo($this->company->id, $this->company->companylogo , $this->config);
                                ?>
                                <img class="js_job_company_logo" src="<?php echo $logourl; ?>" />
                            </span>
                        </span>
                    </div>
                <?php 
                    $div_style="";
                }else{
                    $div_style='id="jsjobs_full_widthdiv"';
                } ?>
                
                    <div <?php echo $div_style;?> class="jsjobs-comoany-data">  <?php
                        $i = 0;
                        $model_cf = $this->getJSModel('customfields');
                        foreach ($this->fieldsordering as $fieldkey => $value) {
                            switch ($fieldkey) {
                                case "jobcategory":
                                    ?>
                                    <?php if ($value == 1) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?> :</span>
                                            <span class="js_job_data_value"><?php echo JText::_($this->company->cat_title); ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    break;
                                case "url":
                                    if ($value == 1 && $this->config['comp_show_url'] == 1) {?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?></span>
                                            <span class="js_job_data_value">
                                                <a class="js_job_company_anchor" target="_blank" href="<?php echo $this->company->url; ?>">
                                                    <?php echo $this->company->url; ?>
                                                </a>
                                            </span>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case "contactname":
                                    if ($value == 1) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value">
                                                <?php echo $this->company->contactname; ?>
                                            </span>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case "contactfax":
                                    if ($value == 1) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value">
                                                <?php echo $this->company->companyfax; ?>
                                            </span>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case "address1":
                                    if ($value == 1) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value"><?php echo $this->company->address1; ?></span>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case "address2":
                                    if ($value == 1) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value"><?php echo $this->company->address2; ?></span>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case "contactphone":
                                    if ($value == 1) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value">
                                                <?php echo $this->company->contactphone; ?>
                                            </span>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case "contactfax":
                                    if ($value == 1) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value">
                                                <?php echo $this->company->companyfax; ?>
                                            </span>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case "zipcode":
                                    if ($value == 1 && $this->config['comp_zipcode']) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value">
                                                <?php echo $this->company->zipcode; ?>
                                            </span>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case "contactemail":
                                    if ($value == 1 && $this->config['comp_email_address']) { ?>
                                       <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value"><?php echo $this->company->contactemail; ?></span>
                                        </div>
                                        <?php
                                    }
                                    break;
                                case "since": ?>
                                    <div class="js_job_data_wrapper">
                                        <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?> :</span>
                                        <span class="js_job_data_value"><?php echo JHtml::_('date', $this->company->since, $this->config['date_format']); ?></span>
                                    </div>
                                
                                    <?php
                                    break;
                                case "companysize":
                                    ?>
                                    <?php if ($value == 1) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value"><?php echo $this->company->companysize; ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    break;
                                case "income":
                                    ?>
                                    <?php if ($value == 1) { ?>
                                        <div class="js_job_data_wrapper">
                                            <span class="js_job_data_title"><?php echo JText::_($model_cf->getFieldTitleByFieldAndFieldfor($fieldkey , 1)); ?>: </span>
                                            <span class="js_job_data_value"><?php echo $this->company->income; ?></span>
                                        </div>
                                    <?php 
                                    }
                                    break;
                                default:
                                    if(!$this->isjobsharing && preg_match('/^ufield\d+$/', $fieldkey)){
                                        $userfield = getCustomFieldClass()->getUserFieldByField($fieldkey);
                                        echo  getCustomFieldClass()->showCustomFields($userfield, 5 ,$this->company , 1);
                                        unset($this->fieldsordering[$fieldkey]);
                                    }
                                    break;
                            }
                        }

                        /*if ($this->isjobsharing) {

                        } else {
                            $customfields = getCustomFieldClass()->userFieldsData( 1 );
                            foreach ($customfields as $field) {
                                echo  getCustomFieldClass()->showCustomFields($field, 5 ,$this->company , 1);
                            }
                        }*/ ?>
                    </div>
                <div class="js_job_apply_button">
                    <?php if ($this->nav = '31' && $this->nav = '41') { ?>
                        <a class="js_job_button" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs&cd=<?php echo $this->company->aliasid; ?>&Itemid=<?php echo $this->Itemid; ?>" ><?php echo JText::_('View All Jobs'); ?></a>
                    <?php } ?>	
                </div>
            </div>
        <?php 
    } else { 
        $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
    }
    ?>
    </div>
    <?php
}
?>	
</div> 
<?php

function isURL($url = NULL) {
    if ($url == NULL)
        return false;
    $protocol = '(http://|https://)';
    if (ereg($protocol, $url) == true)
        return true;
    else
        return false;
}
?>
