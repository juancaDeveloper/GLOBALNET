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
jimport('joomla.html.pane');
$document = JFactory::getDocument();
if (JVERSION < 3) {
JHtml::_('behavior.mootools');
$document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
JHtml::_('behavior.framework');
JHtml::_('jquery.framework');
}

$document->addScript('components/com_jsjobs/include/js/jquery_idTabs.js');


global $mainframe;

$ADMINPATH = JPATH_BASE . '\components\com_jsjobs';

$yesno = array(
'0' => array('value' => 1, 'text' => JText::_('Yes')),
 '1' => array('value' => 0, 'text' => JText::_('No')), );
$alipay_mode = array(
'0' => array('value' => "Partner", 'text' => JText::_('Partner')),
 '1' => array('value' => "Direct", 'text' => JText::_('Direct')), );
$alipay_transport = array(
'0' => array('value' => "Http", 'text' => JText::_('Http')),
 '1' => array('value' => "Https", 'text' => JText::_('Https')), );
$bluepaid_currency = array(
'0' => array('value' => "Eur", 'text' => JText::_('Eur')),
 '1' => array('value' => "Usd", 'text' => JText::_('Usd')),
 '2' => array('value' => "Jpy", 'text' => JText::_('Jpy')),
 '3' => array('value' => "Cad", 'text' => JText::_('Cad')),
 '4' => array('value' => "Aud", 'text' => JText::_('Aud')),
 '5' => array('value' => "Gbp", 'text' => JText::_('Gbp')),
 '6' => array('value' => "Chf", 'text' => JText::_('Chf')), );
$bluepaid_lang = array(
'0' => array('value' => "EN", 'text' => JText::_('English')),
 '1' => array('value' => "DE", 'text' => JText::_('German')),
 '2' => array('value' => "ES", 'text' => JText::_('Spanish')),
 '3' => array('value' => "FR", 'text' => JText::_('French')),
 '4' => array('value' => "IT", 'text' => JText::_('Italian')),
 '5' => array('value' => "NL", 'text' => JText::_('Dutch')),
 '6' => array('value' => "PT", 'text' => JText::_('Portuguese')), );
$eway_lang = array(
'0' => array('value' => "EN", 'text' => JText::_('English')),
 '1' => array('value' => "DE", 'text' => JText::_('German')),
 '2' => array('value' => "ES", 'text' => JText::_('Spanish')),
 '3' => array('value' => "FR", 'text' => JText::_('French')),
 '4' => array('value' => "NL", 'text' => JText::_('Dutch')), );
$eway_country = array(
'0' => array('value' => "UK", 'text' => JText::_('United Kingdom')),
 '1' => array('value' => "AS", 'text' => JText::_('Australia')),
 '2' => array('value' => "NZ", 'text' => JText::_('New Zealand')), );
$windowstate_epay = array(
'0' => array('value' => "1", 'text' => JText::_('Popup')),
 '1' => array('value' => "2", 'text' => JText::_('Same Window')), );
$md5mode_epay = array(
'0' => array('value' => "2", 'text' => JText::_('From Epay')),
 '1' => array('value' => "3", 'text' => JText::_('To And From Epay')), );
$yesno_epay = array(
'0' => array('value' => "1", 'text' => JText::_('No')),
 '1' => array('value' => "2", 'text' => JText::_('Yes')), );

$currency_alipay = array('0' => array('value' => "Cny", 'text' => JText::_('Cny')));

$currencycode_googlecheckout = array(
'0' => array('value' => "Usd", 'text' => JText::_('Usd')),
 '1' => array('value' => "Gbp", 'text' => JText::_('Gbp')), );

$hsbc_currency = array(
'0' => array('value' => "978", 'text' => JText::_('Eur')),
 '1' => array('value' => "840", 'text' => JText::_('Usd')),
 '2' => array('value' => "124", 'text' => JText::_('Cad')),
 '3' => array('value' => "036", 'text' => JText::_('Aud')),
 '4' => array('value' => "826", 'text' => JText::_('Gbp')), );
$moneybookers_currency = array(
'0' => array('value' => "Eur", 'text' => JText::_('Eur')), '1' => array('value' => "Jpy", 'text' => JText::_('Jpy')),
 '2' => array('value' => "Usd", 'text' => JText::_('Usd')), '3' => array('value' => "Hkd", 'text' => JText::_('Hkd')),
 '4' => array('value' => "Sgd", 'text' => JText::_('Sgd')), '5' => array('value' => "Gbp", 'text' => JText::_('Gbp')),
 '6' => array('value' => "Cad", 'text' => JText::_('Cad')), '7' => array('value' => "Aud", 'text' => JText::_('Aud')),
 '8' => array('value' => "Chf", 'text' => JText::_('Chf')), '9' => array('value' => "Dkk", 'text' => JText::_('Dkk')),
 '10' => array('value' => "Sek", 'text' => JText::_('Sek')), '11' => array('value' => "Nok", 'text' => JText::_('Nok')),
 '12' => array('value' => "Ils", 'text' => JText::_('Ils')), '13' => array('value' => "Myr", 'text' => JText::_('Myr')),
 '14' => array('value' => "Try", 'text' => JText::_('Try')), '15' => array('value' => "Nzd", 'text' => JText::_('Nzd')),
 '16' => array('value' => "Aed", 'text' => JText::_('Aed')), '17' => array('value' => "Mad", 'text' => JText::_('Mad')),
 '18' => array('value' => "Sar", 'text' => JText::_('Sar')), '19' => array('value' => "Qar", 'text' => JText::_('Qar')),
 '20' => array('value' => "Inr", 'text' => JText::_('Inr')), '21' => array('value' => "Isk", 'text' => JText::_('Isk')),
 '22' => array('value' => "Bgn", 'text' => JText::_('Bgn')), '23' => array('value' => "Pln", 'text' => JText::_('Pln')),
 '24' => array('value' => "Eek", 'text' => JText::_('Eek')), '25' => array('value' => "Skk", 'text' => JText::_('Skk')),
 '26' => array('value' => "Czk", 'text' => JText::_('Czk')), '27' => array('value' => "Huf", 'text' => JText::_('Huf')),
 '28' => array('value' => "Thb", 'text' => JText::_('Thb')), '29' => array('value' => "Twd", 'text' => JText::_('Twd')),
 '30' => array('value' => "Krw", 'text' => JText::_('Krw')), '31' => array('value' => "Lvl", 'text' => JText::_('Lvl')),
 '32' => array('value' => "Zar", 'text' => JText::_('Zar')), '33' => array('value' => "Ron", 'text' => JText::_('Ron')),
 '34' => array('value' => "Ltl", 'text' => JText::_('Ltl')), '35' => array('value' => "Hrk", 'text' => JText::_('Hrk')),
 '36' => array('value' => "Jod", 'text' => JText::_('Jod')), '37' => array('value' => "Omr", 'text' => JText::_('Omr')),
 '38' => array('value' => "Tnd", 'text' => JText::_('Tnd')), '39' => array('value' => "Rsd", 'text' => JText::_('Rsd')),
);
$moneybookers_language = array(
'0' => array('value' => "EN", 'text' => JText::_('English')),
 '1' => array('value' => "DE", 'text' => JText::_('German')),
 '2' => array('value' => "ES", 'text' => JText::_('Spanish')),
 '3' => array('value' => "FR", 'text' => JText::_('French')),
 '4' => array('value' => "IT", 'text' => JText::_('Italian')),
 '5' => array('value' => "PL", 'text' => JText::_('Polish')),
 '6' => array('value' => "GR", 'text' => JText::_('Greek')),
 '7' => array('value' => "RO", 'text' => JText::_('Romanian')),
 '8' => array('value' => "RU", 'text' => JText::_('Russian')),
 '9' => array('value' => "TR", 'text' => JText::_('Turkish')),
 '10' => array('value' => "CN", 'text' => JText::_('Chinese')),
 '11' => array('value' => "CZ", 'text' => JText::_('Czech')),
 '12' => array('value' => "DA", 'text' => JText::_('Danish')),
 '13' => array('value' => "SV", 'text' => JText::_('Swedish')),
 '14' => array('value' => "FI", 'text' => JText::_('Finnish')),
 '15' => array('value' => "NL", 'text' => JText::_('Dutch')), );
$sagepay_mode = array(
'0' => array('value' => "LIVE", 'text' => JText::_('Live')),
 '1' => array('value' => "TEST", 'text' => JText::_('Test')),
 '2' => array('value' => "Simu", 'text' => JText::_('Simu')), );

$checkout_language = array(
'0' => array('value' => "en", 'text' => JText::_('English')), '1' => array('value' => "zh", 'text' => JText::_('Chinese')),
 '2' => array('value' => "da", 'text' => JText::_('Danish')),
 '3' => array('value' => "fr", 'text' => JText::_('French')), '4' => array('value' => "gr", 'text' => JText::_('German')),
 '5' => array('value' => "it", 'text' => JText::_('Italian')), '6' => array('value' => "el", 'text' => JText::_('Greek')),
 '7' => array('value' => "jp", 'text' => JText::_('Japanese')), '8' => array('value' => "no", 'text' => JText::_('Norwegian')),
 '9' => array('value' => "sl", 'text' => JText::_('Slovenian')), '10' => array('value' => "pt", 'text' => JText::_('Portuguese')),
 '11' => array('value' => "nl", 'text' => JText::_('Dutch')),
);

$checkout_currencycode = array(
'0' => array('value' => "Ars", 'text' => JText::_('Ars')), '1' => array('value' => "Aud", 'text' => JText::_('Aud')),
 '2' => array('value' => "Brl", 'text' => JText::_('Brl')), '3' => array('value' => "Gbp", 'text' => JText::_('Gbp')),
 '4' => array('value' => "Dkk", 'text' => JText::_('Dkk')), '5' => array('value' => "Cad", 'text' => JText::_('Cad')),
 '6' => array('value' => "Eur", 'text' => JText::_('Eur')), '7' => array('value' => "Hkd", 'text' => JText::_('Hkd')),
 '8' => array('value' => "Ils", 'text' => JText::_('Ils')), '9' => array('value' => "Inr", 'text' => JText::_('Inr')),
 '10' => array('value' => "Jpy", 'text' => JText::_('Jpy')), '11' => array('value' => "Ltl", 'text' => JText::_('Ltl')),
 '12' => array('value' => "Mxn", 'text' => JText::_('Mxn')), '13' => array('value' => "Myr", 'text' => JText::_('Myr')),
 '14' => array('value' => "Nzd", 'text' => JText::_('Nzd')), '15' => array('value' => "Nok", 'text' => JText::_('Nok')),
 '16' => array('value' => "Ron", 'text' => JText::_('Ron')), '17' => array('value' => "Php", 'text' => JText::_('Php')),
 '18' => array('value' => "Rub", 'text' => JText::_('Rub')), '19' => array('value' => "Sgd", 'text' => JText::_('Sgd')),
 '20' => array('value' => "Sek", 'text' => JText::_('Sek')), '21' => array('value' => "Zar", 'text' => JText::_('Zar')),
 '22' => array('value' => "Chf", 'text' => JText::_('Chf')), '23' => array('value' => "Try", 'text' => JText::_('Try')),
 '24' => array('value' => "Usd", 'text' => JText::_('Usd')), '25' => array('value' => "Aed", 'text' => JText::_('Aed')), );

$big_field_width = 40;
$med_field_width = 25;
$sml_field_width = 15;
?>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div> 
      <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Configurations'); ?></span></div>
        
        <form action="index.php" method="POST" name="adminForm" id="adminForm" >
            <input type="hidden" name="check" value="post"/>
                <div id="tabs_wrapper" class="tabs_wrapper">
                  <div class="idTabs">
                    <a class="selected" href="#payza"><?php echo JText::_('Payza Setting'); ?></a> 
                    <a  href="#alipay"><?php echo JText::_('Alipay Setting'); ?></a> 
                    <a  href="#authorize"><?php echo JText::_('Authorize Setting'); ?></a> 
                    <a  href="#worldpay"><?php echo JText::_('Worldpay Setting'); ?></a> 
                    <a  href="#bluepaid"><?php echo JText::_('Bluepaid Setting'); ?></a> 
                    <a  href="#epay"><?php echo JText::_('Epay Setting'); ?></a> 
                    <a  href="#eway"><?php echo JText::_('Eway Setting'); ?></a> 
                    <a  href="#googlecheckout"><?php echo JText::_('Google Checkout Setting'); ?></a> 
                    <a  href="#hsbc"><?php echo JText::_('Hsbc Setting'); ?></a> 
                    <a  href="#moneybookers"><?php echo JText::_('Skrill Setting'); ?></a> 
                    <a  href="#paypal"><?php echo JText::_('Paypal Setting'); ?></a> 
                    <a  href="#sagepay"><?php echo JText::_('Sagepay Setting'); ?></a> 
                    <a  href="#westernunion"><?php echo JText::_('Western Union Setting'); ?></a> 
                    <a  href="#2checkout"><?php echo JText::_('2checkout Setting'); ?></a> 
                    <a  href="#fastspring"><?php echo JText::_('Fastspring Setting'); ?></a> 
                    <a  href="#avangate"><?php echo JText::_('Avangate Setting'); ?></a> 
                    <a  href="#pagseguro"><?php echo JText::_('Pagseguro Setting'); ?></a> 
                    <a  href="#payfast"><?php echo JText::_('Payfast Setting'); ?></a> 
                    <a  href="#ideal"><?php echo JText::_('Ideal Setting'); ?></a> 
                    <a  href="#virtuemart"><?php echo JText::_('VirtueMart Setting'); ?></a> 
                    <a  href="#others"><?php echo JText::_('Other Setting'); ?></a> 
                  </div><!--tabs closed-->
                <div id="payza">
                  <div class="headtext"><?php echo JText::_('Payza Setting'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantemail_payza">
                                <?php echo JText::_('Merchant Email'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="merchantemail_payza" id="merchantemail_payza" value="<?php echo $this->paymentmethodconfig['merchantemail_payza']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="merchantemail_payza"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="ipnsecuritycode_payza">
                                <?php echo JText::_('Ipn Security Code'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="ipnsecuritycode_payza" id="ipnsecuritycode_payza" value="<?php echo $this->paymentmethodconfig['ipnsecuritycode_payza']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="ipnsecuritycode_payza"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                <?php echo JText::_('Notify Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input id="notifyurl" value="<?php echo JURI::root() . $this->paymentmethodconfig['notifyurl_payza']; ?>" class="inputfieldsizeful inputbox" size="80" readonly="true" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="cancelurl_payza">
                                <?php echo JText::_('Cancel Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="cancelurl_payza" id="cancelurl_payza" value="<?php echo $this->paymentmethodconfig['cancelurl_payza']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="cancelurl_payza"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                     
                     </div><!-- left closed -->
                     
                     <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="returnurl_payza">
                                <?php echo JText::_('Return Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="returnurl_payza" id="returnurl_payza" value="<?php echo $this->paymentmethodconfig['returnurl_payza']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="returnurl_payza"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_payza">
                                <?php echo JText::_('Payza Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_payza', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['isenabled_payza']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="isenabled_payza"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="testmode_payza">
                                <?php echo JText::_('Test Mode'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'testmode_payza', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['testmode_payza']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="testmode_payza"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                      </div><!-- right closed -->
                </div><!--payza closed-->
                <div id="alipay">
                   <div class="headtext"><?php echo JText::_('Alipay Settings'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantemail_alipay">
                                <?php echo JText::_('Merchant Email'); ?>
                            </label>
                            <div class="jobs-config-value">
                              <input type="text" name="merchantemail_alipay" id="merchantemail_alipay" value="<?php echo $this->paymentmethodconfig['merchantemail_alipay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="merchantemail_alipay"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="securitycode_alipay">
                                <?php echo JText::_('Security Code'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="securitycode_alipay" id="securitycode_alipay" value="<?php echo $this->paymentmethodconfig['securitycode_alipay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="securitycode_alipay"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="paymentmode_alipay">
                                <?php echo JText::_('Payment Mode'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $alipay_mode, 'paymentmode_alipay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['paymentmode_alipay']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="paymentmode_alipay"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="partnerid_alipay">
                                <?php echo JText::_('Partner Id'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="partnerid_alipay" id="partnerid_alipay" value="<?php echo $this->paymentmethodconfig['partnerid_alipay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="partnerid_alipay"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="currency_alipay">
                                <?php echo JText::_('Accepted Currency'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $currency_alipay, 'currency_alipay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['currency_alipay']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="currency_alipay"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                     
                     </div><!-- left closed -->
                     
                     <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="transport_alipay">
                                <?php echo JText::_('Transport'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $alipay_transport, 'transport_alipay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['transport_alipay']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="transport_alipay"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                <?php echo JText::_('Notify Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input id="notifyurl" value="<?php echo JURI::root() . $this->paymentmethodconfig['notifyurl_alipay']; ?>" class="inputfieldsizeful inputbox" size="80" readonly="true" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                         <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="returnurl_alipay">
                                <?php echo JText::_('Return Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="returnurl_alipay" id="returnurl_alipay" value="<?php echo $this->paymentmethodconfig['returnurl_alipay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="returnurl_alipay"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                         <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_alipay">
                                <?php echo JText::_('Alipay Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_alipay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['isenabled_alipay']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="isenabled_alipay"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
  
                      </div><!-- right closed --> 
                </div><!--alipay closed-->
                <div id="authorize">
                   <div class="headtext"><?php echo JText::_('Authorize Settings'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="loginid_authorize">
                                <?php echo JText::_('Login Id'); ?>
                            </label>
                            <div class="jobs-config-value">
                              <input type="text" name="loginid_authorize" id="loginid_authorize" value="<?php echo $this->paymentmethodconfig['loginid_authorize']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="loginid_authorize"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="transactionkey_authorize">
                                <?php echo JText::_('Transaction Key'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="transactionkey_authorize" id="transactionkey_authorize" value="<?php echo $this->paymentmethodconfig['transactionkey_authorize']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="transactionkey_authorize"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                         <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="testmode_authorize">
                                <?php echo JText::_('Test Mode Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'testmode_authorize', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['testmode_authorize']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="testmode_authorize"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                         <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                <?php echo JText::_('Notify Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input id="notifyurl" value="<?php echo JURI::root() . $this->paymentmethodconfig['notifyurl_authorize']; ?>" class="inputfieldsizeful inputbox" size="80" readonly="true" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                     
                     </div><!-- left closed -->
                     
                     <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="returnurl_authorize">
                                <?php echo JText::_('Return Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                               <input type="text" name="returnurl_authorize" id="returnurl_authorize" value="<?php echo $this->paymentmethodconfig['returnurl_authorize']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />  
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="returnurl_authorize"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="cancelurl_authorize">
                                <?php echo JText::_('Cancel Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="cancelurl_authorize" id="cancelurl_authorize" value="<?php echo $this->paymentmethodconfig['cancelurl_authorize']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="cancelurl_authorize"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_authorize">
                                <?php echo JText::_('Authorize Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_authorize', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['isenabled_authorize']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="isenabled_authorize"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="">
                                <?php echo JText::_('Note'); ?>
                            </label>
                            <div class="jobs-config-value">
                            
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for=""><?php echo JText::_('Only Sim Payment Method'); ?></label>     
                            </div>
                        </div>

                       
                      </div><!-- right closed --> 
                </div><!--authorize closed-->
                <div id="worldpay">
                    <div class="headtext"><?php echo JText::_('Worldpay Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="paymenturl_worldpay">
                                    <?php echo JText::_('Payment Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="paymenturl_worldpay" id="paymenturl_worldpay" value="<?php echo $this->paymentmethodconfig['paymenturl_worldpay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="paymenturl_worldpay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="instid_worldpay">
                                    <?php echo JText::_('Installation Id'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="instid_worldpay" id="instid_worldpay" value="<?php echo $this->paymentmethodconfig['instid_worldpay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="instid_worldpay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="testmode_worldpay">
                                    <?php echo JText::_('Test Mode Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                     <?php echo JHTML::_('select.genericList', $yesno, 'testmode_worldpay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['testmode_worldpay']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="testmode_worldpay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input id="notifyurl" value="<?php echo JURI::root() . $this->paymentmethodconfig['notifyurl_worldpay']; ?>" class="inputfieldsizeful inputbox" size="80" readonly="true" /> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_worldpay">
                                    <?php echo JText::_('Worldpay Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_worldpay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['isenabled_worldpay']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_worldpay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed -->
                </div><!--worldpay closed-->
                <div id="bluepaid">
                  <div class="headtext"><?php echo JText::_('Bluepaid Setting'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="paymenturl_bluepaid">
                                <?php echo JText::_('Payment Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                              <input type="text" name="paymenturl_bluepaid" id="paymenturl_bluepaid" value="<?php echo $this->paymentmethodconfig['paymenturl_bluepaid']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="paymenturl_bluepaid"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="bluepaidid_bluepaid">
                                <?php echo JText::_('Bluepaid Id'); ?>
                            </label>
                            <div class="jobs-config-value">
                                 <input type="text" name="bluepaidid_bluepaid" id="bluepaidid_bluepaid" value="<?php echo $this->paymentmethodconfig['bluepaidid_bluepaid']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />  
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="bluepaidid_bluepaid"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="currencycode_bluepaid">
                                <?php echo JText::_('Currency Code'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $bluepaid_currency, 'currencycode_bluepaid', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['currencycode_bluepaid']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="currencycode_bluepaid"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                     
                     </div><!-- left closed -->
                     
                     <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="language_bluepaid">
                                <?php echo JText::_('Language'); ?>
                            </label>
                            <div class="jobs-config-value">
                                 <?php echo JHTML::_('select.genericList', $bluepaid_lang, 'language_bluepaid', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['language_bluepaid']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="language_bluepaid"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                <?php echo JText::_('Notify Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input id="notifyurl" value="<?php echo JURI::root() . $this->paymentmethodconfig['notifyurl_bluepaid']; ?>" class="inputfieldsizeful inputbox" size="80" readonly="true" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                          <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_bluepaid">
                                <?php echo JText::_('Bluepaid Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_bluepaid', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['isenabled_bluepaid']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="isenabled_bluepaid"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
  
                      </div><!-- right closed -->  
                </div><!--bluepaid closed-->  
                <div id="epay">
                    <div class="headtext"><?php echo JText::_('Epay Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantnumber_epay">
                                    <?php echo JText::_('Merchant Number'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="merchantnumber_epay" id="merchantnumber_epay" value="<?php echo $this->paymentmethodconfig['merchantnumber_epay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="merchantnumber_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="windowstate_epay">
                                    <?php echo JText::_('Window State'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $windowstate_epay, 'windowstate_epay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['windowstate_epay']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="windowstate_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                            
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="md5mode_epay">
                                    <?php echo JText::_('Md5 Mode'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $md5mode_epay, 'md5mode_epay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['md5mode_epay']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="md5mode_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="md5mode_epay">
                                    <?php echo JText::_('Md5 Mode'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $md5mode_epay, 'md5mode_epay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['md5mode_epay']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="md5mode_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="authsms_epay">
                                    <?php echo JText::_('Auth Sms'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="authsms_epay" id="authsms_epay" value="<?php echo $this->paymentmethodconfig['authsms_epay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="authsms_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="authmail_epay">
                                    <?php echo JText::_('Auth Mail'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="authmail_epay" id="authmail_epay" value="<?php echo $this->paymentmethodconfig['authmail_epay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="authmail_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="group_epay">
                                    <?php echo JText::_('Group'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="group_epay" id="group_epay" value="<?php echo $this->paymentmethodconfig['group_epay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="group_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="instantcapture_epay">
                                    <?php echo JText::_('Instant Capture'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno_epay, 'instantcapture_epay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['instantcapture_epay']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="instantcapture_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="splitpayment_epay">
                                    <?php echo JText::_('Split Payment'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <?php echo JHTML::_('select.genericList', $yesno_epay, 'splitpayment_epay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['splitpayment_epay']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="splitpayment_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="addfee_epay">
                                    <?php echo JText::_('Add Fee'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <?php echo JHTML::_('select.genericList', $yesno_epay, 'addfee_epay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['addfee_epay']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="addfee_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="returnurl_epay">
                                    <?php echo JText::_('Return Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="returnurl_epay" id="returnurl_epay" value="<?php echo $this->paymentmethodconfig['returnurl_epay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="returnurl_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="cancelurl_epay">
                                    <?php echo JText::_('Cancel Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="cancelurl_epay" id="cancelurl_epay" value="<?php echo $this->paymentmethodconfig['cancelurl_epay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="cancelurl_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input id="notifyurl" value="<?php echo JURI::root() . $this->paymentmethodconfig['notifyurl_epay']; ?>" class="inputfieldsizeful inputbox" size="80" readonly="true" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_epay">
                                    <?php echo JText::_('Epay Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_epay', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['isenabled_epay']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_epay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                          </div><!-- right closed -->
                </div><!--EPAY closed-->  
                <div id="eway">
                   <div class="headtext"><?php echo JText::_('Eway Setting'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="customerid_eway">
                                <?php echo JText::_('Customer Id'); ?>
                            </label>
                            <div class="jobs-config-value">
                              <input type="text" name="customerid_eway" id="customerid_eway" value="<?php echo $this->paymentmethodconfig['customerid_eway']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="customerid_eway"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="username_eway">
                                <?php echo JText::_('Username'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="username_eway" id="username_eway" value="<?php echo $this->paymentmethodconfig['username_eway']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="username_eway"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                         <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="countrycode_eway">
                                <?php echo JText::_('Country'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $eway_country, 'countrycode_eway', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['countrycode_eway']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="countrycode_eway"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                         <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="">
                                <?php echo JText::_('Currency Code'); ?>
                            </label>
                            <div class="jobs-config-value">
                                
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for=""><?php echo JText::_('Currency Code Were Set According To Country I-e Aud, Nzd, Gbp'); ?></label>     
                            </div>
                        </div>
                     
                     </div><!-- left closed -->
                     
                     <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="language_eway">
                                <?php echo JText::_('Language'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $eway_lang, 'language_eway', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->paymentmethodconfig['language_eway']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="language_eway"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                <?php echo JText::_('Return Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root() . $this->paymentmethodconfig['returnurl_eway']; ?>" class="inputfieldsizeful inputbox" maxlength="255" size="80" readonly="true" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_('Dont Change It'); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="cancelurl_eway">
                                <?php echo JText::_('Cancel Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="cancelurl_eway" id="cancelurl_eway" value="<?php echo $this->paymentmethodconfig['cancelurl_eway']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="cancelurl_eway"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_eway">
                                <?php echo JText::_('Eway Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_eway', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_eway']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="isenabled_eway"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                      </div><!-- right closed --> 
                </div><!--Eway closed-->
                <div id="googlecheckout">
                   <div class="headtext"><?php echo JText::_('Google Checkout Settings'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantid_googlecheckout">
                                <?php echo JText::_('Merchant Id'); ?>
                            </label>
                            <div class="jobs-config-value">
                              <input type="text" name="merchantid_googlecheckout" id="merchantid_googlecheckout" value="<?php echo $this->paymentmethodconfig['merchantid_googlecheckout']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="merchantid_googlecheckout"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantkey_googlecheckout">
                                <?php echo JText::_('Merchant Key'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="merchantkey_googlecheckout" id="merchantkey_googlecheckout" value="<?php echo $this->paymentmethodconfig['merchantkey_googlecheckout']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="merchantkey_googlecheckout"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="currencycode_googlecheckout">
                                <?php echo JText::_('Currency Code'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $currencycode_googlecheckout, 'currencycode_googlecheckout', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['currencycode_googlecheckout']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="currencycode_googlecheckout"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="servertoserver_googlecheckout">
                                <?php echo JText::_('Server To Server'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList ', $yesno, 'servertoserver_googlecheckout', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['servertoserver_googlecheckout']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="servertoserver_googlecheckout"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                     
                     </div><!-- left closed -->
                     
                     <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                <?php echo JText::_('Notify Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_googlecheckout']; ?>" class="inputfieldsizeful inputbox"  maxlength="255" size="80" readonly="true" /> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="testmode_googlecheckout">
                                <?php echo JText::_('Test Mode'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'testmode_googlecheckout ', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['testmode_googlecheckout']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="testmode_googlecheckout"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_googlecheckout">
                                <?php echo JText::_('Google Checkout Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_googlecheckout', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_googlecheckout']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="isenabled_googlecheckout"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                       
                      </div><!-- right closed --> 
                </div><!--googlecheckout closed-->
                <div id="hsbc">
                   <div class="headtext"><?php echo JText::_('Hsbc Setting'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantid_hsbc">
                                <?php echo JText::_('Merchant Number'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="merchantid_hsbc" id="merchantid_hsbc" value="<?php echo $this->paymentmethodconfig['merchantid_hsbc']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="merchantid_hsbc"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="cpihash_hsbc">
                                <?php echo JText::_('Cpi Store'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="cpihash_hsbc" id="cpihash_hsbc" value="<?php echo $this->paymentmethodconfig['cpihash_hsbc']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="cpihash_hsbc"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="acceptedcurrencycode_hsbc">
                                <?php echo JText::_('Currency Code'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $hsbc_currency, 'acceptedcurrencycode_hsbc', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['acceptedcurrencycode_hsbc']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="acceptedcurrencycode_hsbc"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="instantcapture_hsbc">
                                <?php echo JText::_('Instant Capture'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'instantcapture_hsbc', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['instantcapture_hsbc']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="instantcapture_hsbc"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                     
                     </div><!-- left closed -->
                     
                     <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="returnurl_hsbc">
                                <?php echo JText::_('Return Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="returnurl_hsbc" id="returnurl_hsbc" value="<?php echo $this->paymentmethodconfig['returnurl_hsbc']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />  
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="returnurl_hsbc"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                <?php echo JText::_('Notify Url'); ?>
                            </label>
                            <div class="jobs-config-value">
                               <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_hsbc']; ?>" class="inputfieldsizeful inputbox"  maxlength="255" size="80" readonly="true" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="testmode_hsbc">
                                <?php echo JText::_('Test Mode'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'testmode_hsbc', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['testmode_hsbc']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="testmode_hsbc"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_hsbc">
                                <?php echo JText::_('Hsbc Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_hsbc', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_hsbc']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="isenabled_hsbc"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                       
                      </div><!-- right closed -->  
                </div><!--hsbc closed-->
                <div id="moneybookers">
                    <div class="headtext"><?php echo JText::_('Skrill Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="paymenturl_moneybookers">
                                    <?php echo JText::_('Payment Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="paymenturl_moneybookers" id="paymenturl_moneybookers" value="<?php echo $this->paymentmethodconfig['paymenturl_moneybookers']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="paymenturl_moneybookers"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantemail_moneybookers">
                                    <?php echo JText::_('Merchant Email'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="merchantemail_moneybookers" id="merchantemail_moneybookers" value="<?php echo $this->paymentmethodconfig['merchantemail_moneybookers']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="merchantemail_moneybookers"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                             <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantid_moneybookers">
                                    <?php echo JText::_('Merchant Id'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="merchantid_moneybookers" id="merchantid_moneybookers" value="<?php echo $this->paymentmethodconfig['merchantid_moneybookers']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="merchantid_moneybookers"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                             <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="secretword_moneybookers">
                                    <?php echo JText::_('Merchant Secret Word'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="secretword_moneybookers" id="secretword_moneybookers" value="<?php echo $this->paymentmethodconfig['secretword_moneybookers']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="secretword_moneybookers"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                             <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="acceptedcurrency_moneybookers">
                                    <?php echo JText::_('Currency Code'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $moneybookers_currency, 'acceptedcurrency_moneybookers', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['acceptedcurrency_moneybookers']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="acceptedcurrency_moneybookers"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="language_moneybookers">
                                    <?php echo JText::_('Language'); ?>
                                </label>
                                <div class="jobs-config-value">
                                     <?php echo JHTML::_('select.genericList', $moneybookers_language, 'language_moneybookers', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['language_moneybookers']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="language_moneybookers"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="returnurl_moneybookers">
                                    <?php echo JText::_('Return Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="returnurl_moneybookers" id="returnurl_moneybookers" value="<?php echo $this->paymentmethodconfig['returnurl_moneybookers']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="returnurl_moneybookers"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="cancelurl_moneybookers">
                                    <?php echo JText::_('Cancel Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="cancelurl_moneybookers" id="cancelurl_moneybookers" value="<?php echo $this->paymentmethodconfig['cancelurl_moneybookers']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="cancelurl_moneybookers"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_moneybookers']; ?>" class="inputfieldsizeful inputbox"  maxlength="255" size="80" readonly="true" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_moneybookers">
                                    <?php echo JText::_('Skrill Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_moneybookers', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_moneybookers']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_moneybookers"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed -->
                </div><!--Skrill closed-->
                <div id="paypal">
                    <div class="headtext"><?php echo JText::_('Paypal Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="accountid_paypal">
                                    <?php echo JText::_('Username'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="accountid_paypal" id="accountid_paypal" value="<?php echo $this->paymentmethodconfig['accountid_paypal']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="accountid_paypal"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="authtoken_paypal">
                                    <?php echo JText::_('Signature'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="authtoken_paypal" id="authtoken_paypal" value="<?php echo $this->paymentmethodconfig['authtoken_paypal']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="authtoken_paypal"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="returnurl_paypal">
                                    <?php echo JText::_('Return Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <input type="text" name="returnurl_paypal" id="returnurl_paypal" value="<?php echo $this->paymentmethodconfig['returnurl_paypal']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="returnurl_paypal"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="cancelurl_paypal">
                                    <?php echo JText::_('Cancel Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="cancelurl_paypal" id="cancelurl_paypal" value="<?php echo $this->paymentmethodconfig['cancelurl_paypal']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="authtoken_paypal"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="password_paypal">
                                    <?php echo JText::_('Password'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="password_paypal" id="password_paypal" value="<?php echo $this->paymentmethodconfig['password_paypal']; ?>" class="inputfieldsizeful inputbox" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="authtoken_paypal"><?php echo JText::_('API Password'); ?></label>
                                </div>
                            </div>
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="lang_paypal">
                                    <?php echo JText::_('Language Code'); ?>
                                </label>
                                <div class="jobs-config-value">
                                     <input type="text" name="lang_paypal" id="lang_paypal" value="<?php echo $this->paymentmethodconfig['lang_paypal']; ?>" class="inputfieldsizeful inputbox" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_('For example en'); ?></label>
                                </div>
                            </div>
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="logo_paypal">
                                    <?php echo JText::_('Site logo'); ?>
                                </label>
                                <div class="jobs-config-value">
                                     <input type="text" name="logo_paypal" id="logo_paypal" value="<?php echo $this->paymentmethodconfig['logo_paypal']; ?>" class="inputfieldsizeful inputbox" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>
                                </div>
                            </div>
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                     <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_paypal']; ?>" class="inputfieldsizeful inputbox" maxlength="255" size="80" readonly="true" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="testmode_paypal">
                                    <?php echo JText::_('Test Mode'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'testmode_paypal', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['testmode_paypal']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="testmode_paypal"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_paypal">
                                    <?php echo JText::_('Paypal Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_paypal', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_paypal']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_paypal"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed -->
                </div><!--paypal closed-->
                <div id="sagepay">
                    <div class="headtext"><?php echo JText::_('Sagepay Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="vendorname_sagepay">
                                    <?php echo JText::_('Vendor Name'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="vendorname_sagepay" id="vendorname_sagepay" value="<?php echo $this->paymentmethodconfig['vendorname_sagepay']; ?>" class="inpufielsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="vendorname_sagepay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="password_sagepay">
                                    <?php echo JText::_('Password'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="password_sagepay" id="password_sagepay" value="<?php echo $this->paymentmethodconfig['password_sagepay']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="password_sagepay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="mode_sagepay">
                                    <?php echo JText::_('Mode'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <?php echo JHTML::_('select.genericList', $sagepay_mode, 'mode_sagepay', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['mode_sagepay']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="mode_sagepay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                     <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_sagepay']; ?>" class="inputfieldsize inputbox" maxlength="255" size="80" readonly="true" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_sagepay">
                                    <?php echo JText::_('Sagepay Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_sagepay', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_sagepay']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_sagepay"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed -->
                </div><!--sagepay closed-->
                <div id="westernunion">
                    <div class="headtext"><?php echo JText::_('Western Union Settings'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="name_westernunion">
                                    <?php echo JText::_('Name'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="name_westernunion" id="name_westernunion" value="<?php echo $this->paymentmethodconfig['name_westernunion']; ?>" class="inputfieldsize inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                  <label class="jobs-mini-descp"><input type="checkbox"  name="showname_westernunion" id="showname_westernunion" value="1" <?php if($this->paymentmethodconfig['showname_westernunion'] == '1') 
                                   echo 'checked = "true"'; ?> />
                                  </label>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="showname_westernunion"><?php echo JText::_('Mark Checkbox If You Want To Show It'); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="countryname_westernunion">
                                    <?php echo JText::_('Country Name'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="countryname_westernunion" id="countryname_westernunion" value="<?php echo $this->paymentmethodconfig['countryname_westernunion']; ?>" class="inputfieldsize inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                  <label class="jobs-mini-descp"> <input type="checkbox" name="showcountryname_westernunion" id="showcountryname_westernunion" value="1" <?php if($this->paymentmethodconfig['showcountryname_westernunion'] == '1') 
                                   echo 'checked = "true"'; ?> />
                                  </label>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="showcountryname_westernunion"><?php echo JText::_('Mark Checkbox If You Want To Show It'); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="cityname_westernunion">
                                    <?php echo JText::_('City Name'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="cityname_westernunion" id="cityname_westernunion" value="<?php echo $this->paymentmethodconfig['cityname_westernunion']; ?>" class="inputfieldsize inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                  <label class="jobs-mini-descp"> <input type="checkbox" name="showcountryname_westernunion" id="showcountryname_westernunion" value="1" <?php if($this->paymentmethodconfig['showcountryname_westernunion'] == '1') 
                                   echo 'checked = "true"'; ?> />
                                  </label>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="showcountryname_westernunion"><?php echo JText::_('Mark Checkbox If You Want To Show It'); ?></label>     
                                </div>
                            </div>


                            
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="emailaddress_westernunion">
                                <?php echo JText::_('Email Address'); ?>
                            </label>
                            <div class="jobs-config-value">
                              <input type="text" name="emailaddress_westernunion" id="emailaddress_westernunion" value="<?php echo $this->paymentmethodconfig['emailaddress_westernunion']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                              
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="emailaddress_westernunion"><?php echo JText::_('Note: Email Address Shown For Mtcn Number'); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="accountinfo_westernunion">
                                <?php echo JText::_('Account Information'); ?>
                            </label>
                            <div class="jobs-config-value">
                              <textarea class="inputfieldsize" name="accountinfo_westernunion" id="accountinfo_westernunion" cols="50" rows="10"><?php echo $this->paymentmethodconfig['accountinfo_westernunion']; ?></textarea>
                              <label class="jobs-mini-descp"><input type="checkbox" name="showaccountinfo_westernunion" id="showaccountinfo_westernunion" value="1" <?php if($this->paymentmethodconfig['showaccountinfo_westernunion'] == '1') 
                            echo 'checked = "true"'; ?> />
                              </label>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="showaccountinfo_westernunion"><?php echo JText::_('Mark Checkbox If You Want To Show It'); ?></label>     
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="accountinfo_westernunion"><?php echo JText::_('Note: Email Address Shown For Mtcn Number'); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_westernunion">
                                <?php echo JText::_('Western Union Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                             <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_westernunion', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_westernunion']); ?>
                              
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="isenabled_westernunion"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
  
                          </div><!-- right closed -->
                </div><!--western union closed-->
                <div id="2checkout">
                   <div class="headtext"><?php echo JText::_('2checkout Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="sid_2checkout">
                                    <?php echo JText::_('Seller Id'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="sid_2checkout" id="sid_2checkout" value="<?php echo $this->paymentmethodconfig['sid_2checkout']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="sid_2checkout"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="currencycode_2checkout">
                                    <?php echo JText::_('Currency Code'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <?php echo JHTML::_('select.genericList', $checkout_currencycode, 'currencycode_2checkout', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['currencycode_2checkout']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="currencycode_2checkout"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="language_2checkout">
                                    <?php echo JText::_('Language'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $checkout_language, 'language_2checkout', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['language_2checkout']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="language_2checkout"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="demo_2checkout">
                                    <?php echo JText::_('Demo'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'demo_2checkout', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['demo_2checkout']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="demo_2checkout"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_2checkout']; ?>" class="inputfieldsizeful inputbox" maxlength="255" size="80" readonly="true" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_2checkout">
                                    <?php echo JText::_('2checkout Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_2checkout', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_2checkout']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_2checkout"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed --> 
                </div><!--2checkout closed-->
                <div id="fastspring">
                    <div class="headtext"><?php echo JText::_('Fast Springs Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="privatekey_fastspring">
                                    <?php echo JText::_('Private Key'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="privatekey_fastspring" id="privatekey_fastspring" value="<?php echo $this->paymentmethodconfig['privatekey_fastspring']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="privatekey_fastspring"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_fastspring']; ?>" class="inputfieldsizeful inputbox" maxlength="255" size="80" readonly="true" /> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_('Paste Url In Fastspring Notification Url'); ?></label>     
                                </div>
                            </div>
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_fastspring">
                                    <?php echo JText::_('Fastspring Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_fastspring', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_fastspring']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_fastspring"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="">
                                    <?php echo JText::_('Note: Paste The Product Url In Seller Package Form'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for=""><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed -->
                </div><!--fastspring closed-->
                <div id="avangate">
                     <div class="headtext"><?php echo JText::_('Avangate Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="privatekey_avangate">
                                    <?php echo JText::_('Private Key'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="privatekey_avangate" id="privatekey_avangate" value="<?php echo $this->paymentmethodconfig['privatekey_avangate']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="privatekey_avangate"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_avangate']; ?>" class="inputfieldsizeful inputbox" maxlength="255" size="80" readonly="true" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_('Paste Url In Avangate Notification Url'); ?></label>     
                                </div>
                            </div>
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_avangate">
                                    <?php echo JText::_('Avangate Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_avangate', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_avangate']); ?>  
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_avangate"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="">
                                    <?php echo JText::_('Note: Paste The Product Url In Seller Package Form'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for=""><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed -->
                </div><!--avangate closed-->
                <div id="pagseguro">
                    <div class="headtext"><?php echo JText::_('Pagseguro Settings'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="emailaddress_pagseguro">
                                    <?php echo JText::_('Email Address'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="emailaddress_pagseguro" id="emailaddress_pagseguro" value="<?php echo $this->paymentmethodconfig['emailaddress_pagseguro']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="emailaddress_pagseguro"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="token_pagseguro">
                                    <?php echo JText::_('Token'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="token_pagseguro" id="token_pagseguro" value="<?php echo $this->paymentmethodconfig['token_pagseguro']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="token_pagseguro"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_pagseguro']; ?>" class="inputfieldsizeful inputbox" maxlength="255" size="80" readonly="true" /> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_('Paste Url In Pagseguro Notification Url'); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_pagseguro">
                                    <?php echo JText::_('Pagseguro Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_pagseguro', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_pagseguro']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_pagseguro"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed -->
                </div><!--pagseguro closed-->
                <div id="payfast">
                   <div class="headtext"><?php echo JText::_('Payfast Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="username_payfast">
                                    <?php echo JText::_('Username'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="username_payfast" id="username_payfast" value="<?php echo $this->paymentmethodconfig['username_payfast']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="username_payfast"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantid_payfast">
                                    <?php echo JText::_('Merchant Id'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="merchantid_payfast" id="merchantid_payfast" value="<?php echo $this->paymentmethodconfig['merchantid_payfast']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="merchantid_payfast"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="merchantkey_payfast">
                                    <?php echo JText::_('Merchant Key'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="merchantkey_payfast" id="merchantkey_payfast" value="<?php echo $this->paymentmethodconfig['merchantkey_payfast']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />  
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="merchantkey_payfast"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="pdtkey_payfast">
                                    <?php echo JText::_('Pdt Key'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="pdtkey_payfast" id="pdtkey_payfast" value="<?php echo $this->paymentmethodconfig['pdtkey_payfast']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="pdtkey_payfast"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="returnurl_payfast">
                                    <?php echo JText::_('Return Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <input type="text" name="returnurl_payfast" id="returnurl_payfast" value="<?php echo $this->paymentmethodconfig['returnurl_payfast']; ?>" class="inputfieldsizeful inputbox" maxlength="255" size="80" readonly="true" /> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="returnurl_payfast"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <input type="text" name="notifyurl" id="notifyurl" value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_payfast']; ?>" class="inputfieldsizeful inputbox" maxlength="255" size="80" readonly="true" /> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="testmode_payfast">
                                    <?php echo JText::_('Test Mode'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <?php echo JHTML::_('select.genericList', $yesno, 'testmode_payfast', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['testmode_payfast']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="stestmode_payfast"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_payfast">
                                    <?php echo JText::_('Payfast Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_payfast', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_payfast']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_payfast"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed --> 
                </div><!--payfast closed-->
                <div id="ideal">
                    <div class="headtext"><?php echo JText::_('Ideal Settings'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="subcategories">
                                    <?php echo JText::_('Partner Id'); ?>
                                </label>
                                <div class="jobs-config-value">
                                  <input type="text" name="partnerid_ideal" id="partnerid_ideal" value="<?php echo $this->paymentmethodconfig['partnerid_ideal']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="subcategories"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="returnurl_ideal">
                                    <?php echo JText::_('Return Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <input type="text" name="returnurl_ideal" id="returnurl_ideal" value="<?php echo $this->paymentmethodconfig['returnurl_ideal']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $big_field_width; ?>" maxlength="255" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="returnurl_ideal"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="notifyurl">
                                    <?php echo JText::_('Notify Url'); ?>
                                </label>
                                <div class="jobs-config-value">
                                 <input id="notifyurl"  value="<?php echo JURI::root().$this->paymentmethodconfig['notifyurl_ideal']; ?>" class="inputfieldsizeful inputbox" size="80" readonly="true" />
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="notifyurl"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                         
                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="testmode_ideal">
                                    <?php echo JText::_('Test Mode'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'testmode_ideal', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['testmode_ideal']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="testmode_ideal"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_ideal">
                                    <?php echo JText::_('Ideal Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_ideal', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_ideal']); ?>
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_ideal"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                           
                          </div><!-- right closed -->
                </div><!--ideal closed-->
                <div id="others">
                     <div class="headtext"><?php echo JText::_('Others Setting'); ?></div>
                         <div id="jsjobs_left_main">
                            <div id="jsjob_configuration_wrapper">
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="title_others">
                                    <?php echo JText::_('Title'); ?>
                                </label>
                                <div class="jobs-config-value">
                                 <input type="text" name="title_others" id="title_others" value="<?php echo $this->paymentmethodconfig['title_others']; ?>" class="inputfieldsizeful inputbox" maxlength="255" /> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="title_others"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>
                       
                        <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="isenabled_others">
                                    <?php echo JText::_('Other Enabled'); ?>
                                </label>
                                <div class="jobs-config-value">
                                    <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_others', 'class = "inputfieldsizeful inputbox" '. ' ', 'value', 'text', $this->paymentmethodconfig['isenabled_others']); ?> 
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for="isenabled_others"><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                         </div><!-- left closed -->
                         
                         <div id="jsjobs_right_main">
                            <div id="jsjob_configuration_wrapper" >
                                <label class="jobs-config-title stylelabeltop labelcolortop" for="">
                                   <?php echo JText::_('Note: Paste The Product Url In Seller Package Form').'</br>'.JText::_('Package Notification Will Not Work'); ?>
                                </label>
                                <div class="jobs-config-value">
                                   
                                </div>
                                <div class="jobs-config-descript">
                                    <label class=" stylelabelbottom labelcolorbottom" for=""><?php echo JText::_(''); ?></label>     
                                </div>
                            </div>

                          </div><!-- right closed -->
                </div><!--others closed-->
                <div id="virtuemart">
                     <div class="headtext"><?php echo JText::_('VirtueMart Setting'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="title_others">
                                <?php echo JText::_('VirtueMart Enabled'); ?>
                            </label>
                            <div class="jobs-config-value">
                             <?php echo JHTML::_('select.genericList', $yesno, 'isenabled_virtuemart', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['isenabled_virtuemart']); ?>
                            </div>
                        </div>
                     </div><!-- left closed --> 
                </div><!--virtuemart closed-->

                </div><!--tabs wraper closed-->
            <input type="hidden" name="task" value="paymentmethodconfiguraiton.savepaymentconf" />
            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            </form>
        </div><!--Content closed-->
</div><!--main wraper closed-->        
<div id="bottomend"></div>
<div id="jsjobs-footer">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>

