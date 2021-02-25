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
$session = JFactory::getSession();
//$session->clear('versiondata');
$virtuemarterror = $session->get('virtuemarterror');
if(!empty($virtuemarterror)){
    $session->clear('virtuemarterror');
}
$jomsocialerror = $session->get('jomsocialerror');
if(!empty($jomsocialerror)){
    $session->clear('jomsocialerror');
}
?>
<script language=Javascript>
function opendiv(elm,event){
    event.preventDefault();
    var form = jQuery(elm).parent(); 
    var key = form.find('#licensekey').val().trim();
    if(key == ''){
        jQuery(form).find('#licensekey').css('border','1px solid red');
        return false;
    }else{
        jQuery(form).find('#licensekey').removeAttr('style');
        document.getElementById('jsjob_installer_waiting_div').style.display='block';
        document.getElementById('jsjob_installer_waiting_span').style.display='block';
        form.submit();
    }
}
</script>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading">
            <a id="backimage" href="index.php?option=com_jsjobs"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Home');?>" ></a>
            <span id="heading-text"><?php echo JText::_('Premium Plugins'); ?></span>
        </div>
        <div style="display:none;" id="jsjob_installer_waiting_div" class="jsjob_premium_waiting_div"></div>
        <span style="display:none;" id="jsjob_installer_waiting_span"><?php echo JText::_("Please wait installation in progress"); ?></span>
        <div id="jsjob-main-wrapper" >
            <div class="jsjob_premium_wrapper">
                <!-- virtuemart -->
                <div class="jsjobs-plugin-wrap <?php if(!empty($virtuemarterror)) echo 'jsjobs-error'; else if($this->virtuemart->vmVerified) echo 'jsjobs-success'; ?>">
                    <h1 class="jsjobs-plugin-heading"><?php echo JText::_("JS Jobs for VirtueMart"); ?></h1>
                    <h4 class="jsjobs-plugin-desc"><?php echo JText::_("Enables you to sell JS Jobs employer/jobseeker packages as virtuemart products"); ?></h4>
                    <div class="jsjobs-plugin-content">
                    <?php
                    if( $this->virtuemart->vmEnabled ){
                        if( $this->virtuemart->vmVerified ){
                            ?>
                            <div class="alert alert-success"><?php echo JText::_("JS Jobs plugin for VirtueMart is active"); ?></div>
                            <?php
                        }
                        ?>
                        <form action="index.php" method="post">
                            <?php
                            if( !$this->virtuemart->vmVerified ){
                                if( $this->virtuemart->jsjobsVmEnabled ){
                                    ?>
                                    <div class="alert alert-info"><?php echo JText::_("JS Jobs plugin for VirtueMart is installed"); ?></div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="alert alert-danger"><?php echo JText::_("JS Jobs plugin for VirtueMart not installed"); ?></div>
                                    <?php
                                    if( !$this->writeable ){
                                        ?>
                                        <div class="alert alert-danger"><?php echo JPATH_ROOT.'/tmp/ '.JText::_("is not writeable"); ?></div>
                                        <?php
                                    }
                                }
                            }
                            if(!empty($virtuemarterror)){
                                ?>
                                <div class="alert alert-danger"><?php echo JText::_($virtuemarterror); ?></div>
                                <?php
                            }
                            ?>
                            <input type="text" id="licensekey" name="licensekey" autocomplete="off" placeholder="<?php echo JText::_("Enter license key"); ?>" class="jsjobs-inputbox">
                            <div class="jsjobs-lic-link">
                                <?php echo JText::_("Do not have license key"); ?>
                                <a href="https://www.joomsky.com/products/js-jobs/virtuemart.html" target="_blank"><?php echo JText::_("Purchase it here") ?></a>
                            </div>
                            <?php
                            if( $this->virtuemart->jsjobsVmEnabled ){
                                ?>
                                <button class="jsjobs-button" onclick="return opendiv(this,event);"><?php echo JText::_("Activate"); ?></button>
                                <?php
                            }else{
                                ?>
                                <button class="jsjobs-button" onclick="return opendiv(this,event);" <?php if(!$this->writeable) echo 'disabled'; ?>><?php echo JText::_("Install And Activate"); ?></button>
                                <?php
                            }
                            ?>
                            <input type="hidden" name="domain" id="domain" value="<?php echo JURI::root(); ?>" />
                            <input type="hidden" name="producttype" id="producttype" value="<?php echo $this->versiontype->configvalue;?>" />
                            <input type="hidden" name="productcode" id="productcode" value="jsjobs" />
                            <input type="hidden" name="productversion" id="productversion" value="<?php echo str_replace('.','',$this->versioncode->configvalue);?>" />
                            <input type="hidden" name="JVERSION" id="JVERSION" value="<?php echo JVERSION;?>" />
                            <input type="hidden" name="installerversion" id="installerversion" value="1.1" />
                            <input type="hidden" name="pluginfor" value="virtuemart" />
                            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                            <input type="hidden" name="callfrom" value="<?php echo $this->callfrom; ?>" />
                            <input type="hidden" name="task" value="premiumplugin.activatepremiumplugin" />
                            <?php echo JHTML::_( 'form.token' ); ?>     
                        </form>
                        <?php
                    }else{
                        ?>
                        <div class="alert alert-danger"><?php echo JText::_("VirtueMart not installed"); ?></div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <!-- virtuemart end -->

                <!-- JomSocial -->
                <div class="jsjobs-plugin-wrap <?php if(!empty($jomsocialerror)) echo 'jsjobs-error'; else if($this->jomsocial->jmVerified) echo 'jsjobs-success'; ?>">
                    <h1 class="jsjobs-plugin-heading"><?php echo JText::_("JS Jobs for JomSocial"); ?></h1>
                    <h4 class="jsjobs-plugin-desc"><?php echo JText::_("Shows JS Jobs data in JomSocial profile and enables users to post company/job/resume on JomSocial stream"); ?></h4>
                    <div class="jsjobs-plugin-content">
                    <?php
                    if( $this->jomsocial->jmEnabled ){
                        if( $this->jomsocial->jmVerified ){
                            ?>
                            <div class="alert alert-success"><?php echo JText::_("JS Jobs plugin for JomSocial is active"); ?></div>
                            <?php
                        }
                        ?>
                        <form action="index.php" method="post">
                            <?php
                            if( !$this->jomsocial->jmVerified ){
                                if( $this->jomsocial->jsjobsJmEnabled ){
                                    ?>
                                    <div class="alert alert-info"><?php echo JText::_("JS Jobs plugin for JomSocial is installed"); ?></div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="alert alert-danger"><?php echo JText::_("JS Jobs plugin for JomSocial not installed"); ?></div>
                                    <?php
                                    if( !$this->writeable ){
                                        ?>
                                        <div class="alert alert-danger"><?php echo JPATH_ROOT.'/tmp/ '.JText::_("is not writeable"); ?></div>
                                        <?php
                                    }
                                }
                            }
                            if(!empty($jomsocialerror)){
                                ?>
                                <div class="alert alert-danger"><?php echo JText::_($jomsocialerror); ?></div>
                                <?php
                            }
                            ?>
                            <input type="text" id="licensekey" name="licensekey" autocomplete="off" placeholder="<?php echo JText::_("Enter license key"); ?>" class="jsjobs-inputbox">
                            <div class="jsjobs-lic-link">
                                <?php echo JText::_("Do not have license key"); ?>
                                <a href="https://www.joomsky.com/products/js-jobs/jomsocial.html" target="_blank"><?php echo JText::_("Purchase it here") ?></a>
                            </div>
                            <?php
                            if( $this->jomsocial->jsjobsJmEnabled ){
                                ?>
                                <button class="jsjobs-button" onclick="return opendiv(this,event);"><?php echo JText::_("Activate"); ?></button>
                                <?php
                            }else{
                                ?>
                                <button class="jsjobs-button" onclick="return opendiv(this,event);" <?php if(!$this->writeable) echo 'disabled'; ?>><?php echo JText::_("Install And Activate"); ?></button>
                                <?php
                            }
                            ?>
                            <input type="hidden" name="domain" id="domain" value="<?php echo JURI::root(); ?>" />
                            <input type="hidden" name="producttype" id="producttype" value="<?php echo $this->versiontype->configvalue;?>" />
                            <input type="hidden" name="productcode" id="productcode" value="jsjobs" />
                            <input type="hidden" name="productversion" id="productversion" value="<?php echo str_replace('.','',$this->versioncode->configvalue);?>" />
                            <input type="hidden" name="JVERSION" id="JVERSION" value="<?php echo JVERSION;?>" />
                            <input type="hidden" name="installerversion" id="installerversion" value="1.1" />
                            <input type="hidden" name="pluginfor" value="jomsocial" />
                            <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                            <input type="hidden" name="callfrom" value="<?php echo $this->callfrom; ?>" />
                            <input type="hidden" name="task" value="premiumplugin.activatepremiumplugin" />
                            <?php echo JHTML::_( 'form.token' ); ?>     
                        </form>
                        <?php
                    }else{
                        ?>
                        <div class="alert alert-danger"><?php echo JText::_("JomSocial not installed"); ?></div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <!-- JomSocial end -->
            </div>
        </div>
        

        
    </div>
</div>
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
