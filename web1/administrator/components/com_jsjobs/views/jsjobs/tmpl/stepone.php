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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
$session = JFactory::getSession();
//$session->clear('versiondata');
$error = $session->get('installererror');
if(!empty($error)){
    $session->clear('installererror');
}
?>
<script language=Javascript>
function opendiv(){
    document.getElementById('jsjob_installer_waiting_div').style.display='block';
    document.getElementById('jsjob_installer_waiting_span').style.display='block';
}
</script>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Update'); ?></span></div>
        
        <div style="display:none;" id="jsjob_installer_waiting_div"></div>
        <span style="display:none;" id="jsjob_installer_waiting_span"><?php echo JText::_("Please wait installation in progress"); ?></span>
        <div id="jsjob-main-wrapper" >
            <div id="jsjob-lower-wrapper">
                <div class="jsjob_installer_wrapper" id="jsjob-installer_id">    
                    <div class="jsjob_top">
                        <div class="jsjob_logo_wrp">
                            <img src="components/com_jsjobs/include/images/installerlogo.png">
                        </div>
                        <div class="jsjob_heading_text"><?php echo JText::_("JS Jobs Pro"); ?></div>
                        <div class="jsjob_subheading_text"><?php echo JText::_("Most Poweful Job Board Plugin"); ?></div>
                    </div>
                    <form id="proinstaller_form" action="#" method="post">
                        <div class="jsjob_middle" id="jsjob_middle">
                            <div class="jsjob_form_field_wrp">
                                <div class="jsjob_bg_overlay <?php if(!empty($error)) echo 'error'; ?>">
                                    <input type="text" name="transactionkey" id="transactionkey" class="jsjob_key_field" value="" placeholder="<?php echo JText::_('Activation key paste here'); ?>"/>
                                </div>
                            </div>
                            <div id="jsjob_error_message" class="jsjob_error_messages" style="display: none">
                                <span class="jsjob_msg"></span>
                            </div>
                            <?php if ($this->phpversion < 5) { ?>
                                <div class="jsjob_error_messages">
                                    <span class="jsjob_msg"><?php echo JText::_('PHP version smaller then recomended'); ?></span>
                                </div>
                            <?php } ?>
                            <?php if ($this->curlexist != 1) { ?>
                                <div class="jsjob_error_messages">
                                    <span class="jsjob_msg"><?php echo JText::_('CURL not exist'); ?></span>
                                </div>
                            <?php } ?>  
                            <?php if ($this->gd_lib != 1) { ?>
                                <div class="jsjob_error_messages">
                                    <span class="jsjob_msg"><?php echo JText::_('GD library not exist'); ?></span>
                                </div>
                            <?php } ?>
                            <?php if ($this->zip_lib != 1) { ?>
                                <div class="jsjob_error_messages">
                                    <span class="jsjob_msg"><?php echo JText::_('Zip library not exist'); ?></span>
                                </div>
                            <?php } ?>  
                            <?php if ($this->result['admin_dir'] < 755 || $this->result['site_dir'] < 755 || $this->result['tmp_dir'] < 755) { ?>
                                <div class="jsjob_error_messages">
                                    <span class="jsjob_msg"><?php echo JText::_('Directory permissions error'); ?></span>
                                    <?php if($this->result['admin_dir'] < 755){ ?>
                                          <span class="jsjob_msg">"<?php echo JPATH_ROOT."/administrator/components/com_jsjobs"; ?>"&nbsp;<?php echo JText::_('is not writeable'); ?></span>
                                    <?php } ?>
                                    <?php if($this->result['site_dir'] < 755){ ?>
                                          <span class="jsjob_msg">"<?php echo JPATH_ROOT."/components/com_jsjobs"; ?>"&nbsp;<?php echo JText::_('is not writeable'); ?></span>
                                    <?php } ?>
                                    <?php if($this->result['tmp_dir'] < 755){ ?>
                                          <span class="jsjob_msg">"<?php echo JPATH_ROOT."/tmp"; ?>"&nbsp;<?php echo JText::_('is not writeable'); ?></span>
                                    <?php } ?>
                                </div>    
                            <?php } ?>
                                <?php if ($this->result['create_table'] != 1) { ?>
                                    <div class="jsjob_error_messages">    
                                        <span class="jsjob_msg"><?php echo JText::_('Database create table not allowed'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($this->result['insert_record'] != 1) { ?>
                                    <div class="jsjob_error_messages">    
                                        <span class="jsjob_msg"><?php echo JText::_('Database insert record not allowed'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($this->result['update_record'] != 1) { ?>
                                    <div class="jsjob_error_messages">    
                                        <span class="jsjob_msg"><?php echo JText::_('Database update record not allowed'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($this->result['delete_record'] != 1) { ?>
                                    <div class="jsjob_error_messages">    
                                        <span class="jsjob_msg"><?php echo JText::_('Database delete record not allowed'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($this->result['drop_table'] != 1) { ?>
                                    <div class="jsjob_error_messages">    
                                        <span class="jsjob_msg"><?php echo JText::_('Database drop table not allowed'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php if ($this->result['file_downloaded'] != 1) { ?>
                                    <div class="jsjob_error_messages">    
                                        <span class="jsjob_msg"><?php echo JText::_('Error file not downloaded'); ?></span>
                                    </div>
                                <?php } ?>
                                <?php
                                if(!empty($error)){
                                    ?>
                                    <div class="jsjob_error_messages">    
                                        <span class="jsjob_msg"><?php echo $error; ?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                        </div>
                        <?php if (($this->phpversion > 5) && ($this->curlexist == 1) && ($this->gd_lib == 1) && ($this->zip_lib == 1) && ($this->result['admin_dir'] >= 755 && $this->result['site_dir'] >= 755 && $this->result['tmp_dir'] >= 755 ) && ($this->result['create_table'] == 1) && ($this->result['insert_record'] == 1) && ($this->result['update_record'] == 1 ) && ($this->result['delete_record'] == 1 ) && ($this->result['drop_table'] == 1 ) && ($this->result['file_downloaded'] == 1 )) { ?>
                            <div class="jsjob_bottom">
                                <div class="jsjob_submit_btn">
                                    <button type="submit" id="startpress" class="jsjob_btn" role="submit" onclick="return opendiv();"><?php echo JText::_("Start"); ?></button>
                                </div>
                            </div>
                        <?php } ?>    
                        <input type="hidden" name="check" value="" />
                        <input type="hidden" name="domain" id="domain" value="<?php echo JURI::root(); ?>" />
                        <input type="hidden" name="producttype" id="producttype" value="<?php echo $this->versiontype->configvalue;?>" />
                        <input type="hidden" name="productcode" id="productcode" value="jsjobs" />
                        <input type="hidden" name="productversion" id="productversion" value="<?php echo str_replace('.','',$this->versioncode->configvalue);?>" />
                        <input type="hidden" name="count_config" id="count_config" value="<?php echo $this->count_config;?>" />
                        <input type="hidden" name="JVERSION" id="JVERSION" value="<?php echo JVERSION;?>" />
                        <input type="hidden" name="installerversion" id="installerversion" value="1.1" />
                        <input type="hidden" name="c" value="installer" />
                        <input type="hidden" name="task" value="startinstallation" />
                        <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    </form>
                </div>
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
<script type="text/javascript">
    /*jQuery(document).ready(function($){
        $("button#startpress").click(function(e){
            e.preventDefault();
            getVersionList();    
        });

        jQuery('form#proinstaller_form').submit(function(e){
            e.preventDefault();
            getVersionList();
        });
        
        function getVersionList(){
            $('div#jsjob_installer_waiting_div').show();
            $('span#jsjob_installer_waiting_span').show();
            var transactionkey = $("input#transactionkey").val();
            var productcode = $("input#productcode").val();
            var productversion = $("input#productversion").val();
            var producttype = $("input#producttype").val();
            var domain = $("input#domain").val();
            var JVERSION = $("input#JVERSION").val();
            var config_count = $("input#config_count").val();
            $("div#jsjob_error_message span.jsjob_msg").html("");
            $.post("index.php?option=com_jsjobs&c=proinstaller&task=getmyversionlist",{transactionkey:transactionkey,productcode:productcode,productversion:productversion,domain:domain,JVERSION:JVERSION,producttype:producttype,config_count:config_count},function(data){
                if(data){
                    var array = $.parseJSON(data);
                    if(array[0] == 0){
                        $("div#jsjob_error_message").show();
                        $("div#jsjob_error_message span.jsjob_msg").html(array[1]).show();
                    }else{
                        $('div.jsjob_bottom').hide();
                        $('div#jsjob_middle').hide();
                        $('form#proinstaller_form').remove();
                        $("div#jsjob_next_form").html(array[2]).show();
                        $('span#jsjob_installer_helptext').hide();
                        $('div#jsjob_installer_formlabel').hide();
                    }
                    $('div#jsjob_installer_waiting_div').hide();
                    $('span#jsjob_installer_waiting_span').hide();
                }
            });
        }
    });*/
</script>
