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
jimport('joomla.application.component.model');
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>
<?php
function makesymbolalign($price, $symbol, $align){ if($align == 1) $p = $symbol.$price; elseif($align == 2) $p = $price.$symbol; return $p; }
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    if (isset($this->userrole->rolefor) && $this->userrole->rolefor == 1) { // employer
        $currency_align = $this->config['currency_align'];
        ?>
        <form action="index.php" method="post" name="adminForm">
            <?php if (isset($this->package)) {
                $layoutfor = $this->layoutfor;
                if($layoutfor=='detail'){
                    $style = "style=display:none;";
                    $layout_title = JText::_('Package Detail');
                }
                else{
                    $style = "";
                    $layout_title = JText::_('Buy Now');
                }
                //price and disscount related code
                    $discflag = 0;
                    $discountamount = 0;
                    if ($this->package->price != 0) {
                        $curdate = date('Y-m-d H:i:s');
                        if (($this->package->discountstartdate <= $curdate) && ($this->package->discountenddate >= $curdate)) {
                            if ($this->package->discounttype == 2) {
                                $discflag = 1;
                                $discountamount = ($this->package->price * $this->package->discount) / 100;
                                $price = $this->package->price - $discountamount;
                                if($price > 0){
                                    $price = makesymbolalign($price, $this->package->symbol, $currency_align);
                                }else{
                                    $price = JText::_('Free');
                                }
                            } elseif ($this->package->discounttype == 1) {
                                $discflag = 1;
                                $discountamount = $this->package->discount;
                                $price = $this->package->price - $discountamount;
                                if($price > 0){
                                    $price = makesymbolalign($price, $this->package->symbol, $currency_align);
                                }else{
                                    $price = JText::_('Free');
                                }
                            }
                        } else
                            $price = makesymbolalign($this->package->price, $this->package->symbol, $currency_align);
                    }else {
                        $price =  JText::_('Free');
                    }
                ?>
                <div id="jsjobs-main-wrapper">
                    <span class="jsjobs-main-page-title"><?php echo $layout_title; ?></span>
                    <div class="jsjobs-package-data">
                        <span class="jsjobs-package-title">
                            <span class="jsjobs-package-name">
                                <?php
                                echo $this->package->title;
                                if($discflag == 1){ ?>
                                    <strike>
                                        <span class="total-amount"><?php echo makesymbolalign($this->package->price, $this->package->symbol, $currency_align); ?></span>
                                    </strike>
                                <?php }?>
                            </span>	
                            <span class="jsjobs-package-price-details">
                                <span class="stats_data_value">
                                     <?php
                                        echo $price;
                                    ?>
                                </span>
                            </span>			
                        </span>
                    <div class="jsjobs-package-listing-wrapper">
                        <div class="jsjobs-listing-datawrap-details"> 
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Companies Allowed'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->companiesallow == -1)
                                            echo JText::_('Unlimited');
                                        else
                                            echo $this->package->companiesallow;
                                        ?>
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Jobs Allowed'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->jobsallow == -1)
                                            echo JText::_('Unlimited');
                                        else
                                            echo $this->package->jobsallow;
                                        ?>
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('View Resume In Details'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->viewresumeindetails == -1)
                                                echo JText::_('Unlimited');
                                            else
                                                echo $this->package->viewresumeindetails;
                                        ?>
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Resume Search	'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->resumesearch == 1)
                                                $imgscr  = JURI::root().'components/com_jsjobs/images/publish-icon.png' ;
                                               else
                                            $imgscr  = JURI::root().'components/com_jsjobs/images/reject-s.png' ;
                                        ?> 
                                            <img src="<?php echo $imgscr ;?>">
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Featured Companies'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->featuredcompaines == -1)
                                            echo JText::_('Unlimited');
                                        else
                                            echo $this->package->featuredcompaines;
                                        ?>
                                    </span>
                                    <span class="stats_data_values">( <?php echo  JText::_('Expire in') .' '. $this->package->featuredcompaniesexpireindays.' '.JText::_('Days'); ?> )</span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Gold Companies'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->goldcompanies == -1)
                                               echo JText::_('Unlimited');
                                            else
                                                echo $this->package->goldcompanies;
                                        ?>
                                    </span>
                                     <span class="stats_data_values">( <?php echo JText::_('Expire in') .' '.$this->package->goldcompaniesexpireindays.' '.JText::_('Days'); ?> )</span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Featured Jobs'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->featuredjobs == -1)
                                            echo JText::_('Unlimited');
                                        else
                                            echo $this->package->featuredjobs;
                                        ?>
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Gold Jobs'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->goldjobs == -1)
                                            echo JText::_('Unlimited');
                                        else
                                            echo $this->package->goldjobs;
                                        ?>
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Folders'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->folders == -1)
                                            echo JText::_('Unlimited');
                                        else
                                            echo $this->package->folders;
                                        ?>
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Enforce Unpublish job'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php 
                                        if($this->package->enforcestoppublishjob == 1){
                                            switch ($this->package->enforcestoppublishjobtype) {
                                                case '1':
                                                    $val = JText::_('Days');
                                                    break;
                                                case '2':
                                                    $val = JText::_('Weeks');
                                                    break;
                                                case '3':
                                                    $val = JText::_('Months');
                                                    break;
                                            }
                                            echo $this->package->enforcestoppublishjobvalue.'&nbsp;'.$val;
                                        }else{
                                            $imgscr  = JURI::root().'components/com_jsjobs/images/publish-icon.png'; ?>
                                            <img src="<?php echo $imgscr; ?>">
                                            <?php
                                        }
                                        ?>
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values">
                                    <span class="stats_data_title"><?php echo JText::_('Messages Allow'); ?>:</span>
                                    <span class="stats_data_value">
                                       <?php if ($this->package->messageallow == 1)
                                           $imgscr  = JURI::root().'components/com_jsjobs/images/publish-icon.png' ;
                                               else
                                            $imgscr  = JURI::root().'components/com_jsjobs/images/reject-s.png' ;
                                        ?> 
                                            <img src="<?php echo $imgscr ;?>">
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values">
                                    <span class="stats_data_title"><?php echo JText::_('Resume Save Search'); ?>:</span>
                                    <span class="stats_data_value">
                                       <?php if ($this->package->saveresumesearch == 1)
                                           $imgscr  = JURI::root().'components/com_jsjobs/images/publish-icon.png' ;
                                               else
                                            $imgscr  = JURI::root().'components/com_jsjobs/images/reject-s.png' ;
                                        ?> 
                                            <img src="<?php echo $imgscr ;?>">
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-package-data-detail">
                                <span class="jsjobs-package-values"> 
                                    <span class="stats_data_title"><?php echo JText::_('Job Seeker Short List'); ?>:</span>
                                    <span class="stats_data_value">
                                        <?php if ($this->package->jobseekershortlist == 1)
                                            $imgscr  = JURI::root().'components/com_jsjobs/images/publish-icon.png' ;
                                               else
                                            $imgscr  = JURI::root().'components/com_jsjobs/images/reject-s.png' ;
                                        ?> 
                                            <img src="<?php echo $imgscr ;?>">
                                    </span>
                                </span>
                            </div>
                            <div class="jsjobs-descriptions">
                                <div class="jsjob-description-data">
                                   <span class="stats_data_title"><?php echo JText::_('Description'); ?>:</span> 
                                   <span class="stats_data_value">
                                       <?php echo $this->package->description; ?>
                                   </span>
                                </div>
                            </div> 
                             
                        
                        </div>
                    </div>
                        <?php
                        // to handle if 100% discount or discount amount equals to price
                        if ($price == JText::_('Free')) {

                            $showpaymentmethod = false;
                        } else {
                            $showpaymentmethod = true;
                        }?>

                        <div id="" class="jsjobs-package-listing-wrapper">
                            <div class="js_listing_wrapper">
                                <div class="jsjobs-expireindays"> 
                                    <?php echo JText::_('Expire In Days'); ?>:
                                    <?php echo $this->package->packageexpireindays; ?>
                                </div>
                                <?php
                                //this code handles buy now button 
                                  if($layoutfor=='detail'){ 
                                    if ($showpaymentmethod == false) {?>
                                        <input class="js_job_button" type="button" rel="button" onclick="setpaymentmethods('free')" name="submit_app" value="<?php echo JText::_('Buy Now'); ?>" />
                                    <?php }else{?>
                                        <a id="jsjobs_buy_nowbtn_a" href="#"><?php echo JText::_('Buy Now');?></a>
                            <?php  } }elseif ($showpaymentmethod == false) {?>
                                <div class="paymentmethod text-right">  
                                        <input class="js_job_button" type="button" rel="button" onclick="setpaymentmethods('free')" name="submit_app" value="<?php echo JText::_('Buy Now'); ?>" />
                                </div> <?php }
                                // end of buy now button`s code
                                ?>
                            </div>
                        </div>
                        <?php
                                $curdate = date('Y-m-d H:i:s');
                                if (($this->package->discountstartdate <= $curdate) && ($this->package->discountenddate >= $curdate)) {?>
                                    <div class="disc-message">
                                    <?php if ($this->package->discountmessage != '')
                                        echo $this->package->discountmessage;?>
                                    </div>
                                <?php } ?>
            <?php if ($showpaymentmethod == true) {
                                    ?>
                        <div <?php echo $style;?> id="jsjobs-show_buynow_div" class="jsjobs-package-listing-wrapper">
                            <span class="jsjobs-paymentmethods-title"><?php echo JText::_('Payment Methods'); ?></span>
                                        <?php
                                        if (isset($this->paymentmethod)) {
                                            $n = 1;
                                            foreach ($this->paymentmethod AS $key => $paymethod) {
                                                $methodname = 'isenabled_' . $key;
                                                if ($key == 'ideal') {
                                                    $partner_id = $this->idealdata['ideal']['partnerid_ideal'];
                                                    $ideal_testmode = $this->idealdata['ideal']['testmode_ideal'];
                                                    $idealhelperclasspath = "components/com_jsjobs/classes/ideal/Payment.php";
                                                    include_once($idealhelperclasspath);
                                                    $idealhelperobject = new Mollie_iDEAL_Payment($partner_id);
                                                    if ($ideal_testmode == 1)
                                                        $bank_array = $idealhelperobject->getBanks();
                                                }
                                                if ($paymethod[$methodname] == 1) {
                                                    ?>
                                        <div class="jsjobs-listing-wrapperes <?php if ($n == 1) echo 'first-child'; ?>">
                                            <div class="jsjobs-list-wrap">
                                            <span class="payment_method_title">
                                                    <?php echo $paymethod['title_' . $key]; ?>
                                                    <?php if ($key == 'ideal') { ?>
                                                <select name="bank_id">
                                                    <option value=''><?php echo JText::_('Select Bank') ?></option>
                                                        <?php
                                                            if (isset($bank_array) AND ( is_array($bank_array))) {
                                                                foreach ($bank_array as $bank_id => $bank_name) {
                                                         ?>
                                                    <option value="<?php echo htmlspecialchars($bank_id) ?>"><?php echo htmlspecialchars($bank_name) ?></option>
                                                        <?php
                                                              }
                                                            } else {
                                                        ?>
                                                           <option value="0"><?php echo JText::_('No Bank Found') ?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php } ?>
                                            </span>
                                                <span class="payment_method_button"><input id="jsjobs_button"  class="js_job_button" rel="button" type="button" onclick="setpaymentmethods('<?php echo $key; ?>')" name="submit_app" value="<?php echo JText::_('Buy Now'); ?>" /></span>
                                            </div>
                                        </div>			
                            <?php
                            $n = $n + 1;
                        }
                    }
                }
                ?>
                            <?php
                            if( $this->package->virtuemartproductid && $this->getJSModel(JSJOBSVMS)->{JSJOBSVMSFUN}('VEhKR2ZzdmlydHVlbWFyYm5abWpi') ){
                                JPluginHelper::importPlugin('vmextended');
                                $dispatcher = JEventDispatcher::getInstance();
                                $dispatcher->trigger('JSjobsRenderVirtueMartBuyNow',array($this->package->virtuemartproductid));
                            }
                            ?>

                        </div>			

            <?php } ?>




            <?php
            //}
        }
        ?>

                <input type="hidden" name="task" value="saveemployerpayment" />
                <input type="hidden" name="c" value="purchasehistory" />
                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                <input type="hidden" name="packageid" value="<?php if (isset($this->package)) echo $this->package->id; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />

                <input type="hidden" name="packagefor" id="packagefor" value="1"  />
                <input type="hidden" name="paymentmethod" id="paymentmethod"  />
                <input type="hidden" name="paymentmethodid" id="paymentmethodid"  />
            </div>
         </div>
        </form>
        <?php
    } else { // not allowed job posting 
        if($this->uid < 1){ // not logind
            $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
        }else{    
            $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view this page', 0);
        }
    }
}//ol
?>	
</div>
 
<script type="text/javascript">

    jQuery(document).ready(function(){
        jQuery('#jsjobs_buy_nowbtn_a').click(function(e){
            e.preventDefault();
            jQuery('div#jsjobs-show_buynow_div').slideToggle();
        });
    });

    function setpaymentmethods(paymethod) {
        var paymethodvalue = document.getElementById('paymentmethod').value = paymethod;
        document.adminForm.submit();
    }

</script>
