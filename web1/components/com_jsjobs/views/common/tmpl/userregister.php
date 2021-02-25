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
 
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.parameter');

JHTML::_('behavior.formvalidation');
$regplugin = JPluginHelper::getPlugin('system', 'jsjobsregister');
if (!empty($regplugin)) {
    $regpluginParams = new JRegistry();
    $regpluginParams->loadString($regplugin->params);
    $rolevalue = $regpluginParams->get('userregisterinrole');
    if (!empty($rolevalue))
        $isplugininstalled = 1;
    else
        $isplugininstalled = 0;
} else
    $isplugininstalled = 0;
if ($this->config['captchause'] == 0) {
    $regplugin = JPluginHelper::importPlugin('captcha');
    if (!empty($regplugin)) {
        $joomlarecaptcha = 1;
        //$dispatcher = JDispatcher::getInstance();
        //$dispatcher->trigger('onInit', 'dynamic_recaptcha_1');
    } else
        $joomlarecaptcha = 0;
}

$app = JFactory::getApplication();
$params = JComponentHelper::getParams('com_users');
$allowUserRegistration = $params->get('allowUserRegistration');
?>
<script type="text/javascript" language="javascript">
    function myValidate(f) {
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php if (JVERSION < 3)
    echo JUtility::getToken();
else
    echo JSession::getFormToken();
?>';//send token
        } else {
            alert("<?php echo JText::_('Some values are not acceptable, please retry'); ?>");
            return false;
        }
        return true;
    }
</script>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>

<?php
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    if ($allowUserRegistration == 1) {
        ?>
        <div id="jsjobs-main-wrapper">
            <span class="jsjobs-main-page-title">
                <?php
                if($this->config['showemployerlink'] == 0){
                    $this->userrole = 2;
                }                
                if ($this->userrole == 1) {
                    echo JText::_('User Registration');
                } elseif ($this->userrole == 2) {
                    echo JText::_('Job Seeker Registration');
                } elseif ($this->userrole == 3) {
                    echo JText::_('Employer Registration');
                }
                ?>
            </span>
             <div class="jsjobs-folderinfo">
            <form action="<?php echo JRoute::_('index.php' ,false); ?>" enctype="multipart/form-data" method="post" id="josForm" name="josForm" class="form-validate jsautoz_form">
                <div id="userform" class="userform">
                    <div class="fieldwrapper">
                        <div class="fieldtitle">
                            <label id="namemsg" for="name"><?php echo JText::_('Name'); ?>: *</label> 
                        </div>
                        <div class="fieldvalue">
                            <input type="text" name="jform[name]" id="name" size="30" value="" class="inputbox required" maxlength="50" />
                        </div>
                    </div>				        
                    <div class="fieldwrapper">
                        <div class="fieldtitle">
                            <label id="namemsg" for="name"><?php echo JText::_('User Name'); ?>: * </label> 
                        </div>
                        <div class="fieldvalue">
                            <input type="text" id="username" name="jform[username]" size="30" value="" class="inputbox required validate-username" maxlength="25" onBlur="checkjsusername();"/>
                            <div id="usernameerror"></div>
                        </div>
                    </div>				        
                    <div class="fieldwrapper">
                        <div class="fieldtitle">
                            <label id="emailmsg" for="email"><?php echo JText::_('User Email'); ?>: </label>
                        </div>
                        <div class="fieldvalue">
                            <input type="text" id="email" name="jform[email1]" size="30" value="" class="inputbox required validate-email" maxlength="100" onBlur="checkjsemail();"/>
                            <div id="emailerror"></div>
                        </div>
                    </div>				        
                    <div class="fieldwrapper">
                        <div class="fieldtitle">
                            <label id="email2msg" for="email2"><?php echo JText::_('Confirm Email'); ?>: </label>
                        </div>
                        <div class="fieldvalue">
                            <input type="text" id="email2" name="jform[email2]" size="30" value="" class="inputbox required validate-email" maxlength="100" onBlur="checkjsemailmatch();"/>
                            <div id="emailmatcherror"></div>
                        </div>
                    </div>				        
                    <div class="fieldwrapper">
                        <div class="fieldtitle">
                            <label id="pwmsg" for="password"><?php echo JText::_('Password'); ?>: </label>
                        </div>
                        <div class="fieldvalue">
                            <input class="inputbox required validate-password" type="password" id="password" name="jform[password1]" size="30" value="" />
                        </div>
                    </div>				        
                    <div class="fieldwrapper">
                        <div class="fieldtitle">
                            <label id="pw2msg" for="password2"><?php echo JText::_('Verify Password'); ?>: </label>
                        </div>
                        <div class="fieldvalue">
                            <input class="inputbox required validate-passverify" type="password" id="password2" name="jform[password2]" size="30" value="" onBlur="checkjspasswordmatch();"/>
                            <div id="passwordmatcherror"></div>
                        </div>
                    </div>				        
                    <div class="fieldwrapper">
                        <div class="fieldtitle">
                            <label id="userrole" for="userrole"><?php echo JText::_('User Role'); ?>: </label>
                        </div>
                        <div class="fieldvalue">
        <?php if ($isplugininstalled == 1) { ?>	
            <?php if ($this->userrole == 1) {//Both  ?>
                                    <select name='userrole'>
                                        <option value='1'><?php echo JText::_('Employer'); ?></option>
                                        <option value='2'><?php echo JText::_('Job Seeker'); ?></option>
                                    </select>
                                    <?php
                                } elseif ($this->userrole == 2) { //jobseeker
                                    echo "<input type='hidden' name='userrole' value='2'>" . JText::_('Job Seeker');
                                } elseif ($this->userrole == 3) { // employer
                                    echo "<input type='hidden' name='userrole' value='1'>" . JText::_('Employer');
                                }
                                ?>
                                <?php
                            } else {
                                echo JText::_('Please install or enable js jobs register plugin');
                                if ($this->config['captchause'] == 0 && $joomlarecaptcha == 0)
                                    echo '<br/>' . JText::_('Please install or enable joomla recaptcha');
                            }
                            ?>
                        </div>
                        <?php
                        if ($this->config['user_registration_captcha'] == 1 && $isplugininstalled == 1) {
                            if ($this->config['captchause'] == 1) {
                                ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="captchamsg" for="captcha"><?php echo JText::_('Captcha'); ?>&nbsp;<font color="red">*</font></label>
                                    </div>
                                    <div class="fieldvalue">
                                <?php echo $this->captcha; ?>
                                    </div>
                                </div>				        
            <?php } else { ?>
                                <div class="fieldwrapper">
                                    <div class="fieldtitle">
                                        <label id="captchamsg" for="captcha"><?php echo JText::_('Captcha'); ?></label><?php echo '&nbsp;<font color="red">*</font>'; ?>
                                    </div>
                                    <div class="fieldvalue">
                                    <?php
                                        JPluginHelper::importPlugin('captcha');
                                        $dispatcher = JDispatcher::getInstance();
                                        $dispatcher->trigger('onInit', array('dynamic_recaptcha_1'));
                                        $recaptcha = $dispatcher->trigger('onDisplay', array(null, 'dynamic_recaptcha_1' , 'class=""'));
                                        echo isset($recaptcha[0]) ? $recaptcha[0] : '';     
                                    ?>
                                    </div>
                                </div>				                        
            <?php
            }
        }
        ?>
                    </div>
                     <div class="fieldwrapper-btn">
                    <div class="jsjobs-folder-info-btn">
                        <sapn class="jsjobs-folder-btn">
                            <input id="button" class="button validate" type="button" onclick="return checkformagain();" value="<?php echo JText::_('Register'); ?>"/>
                        </sapn>
                    </div>
                </div>			        
                </div>
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="registration.register" />
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="id" value="0" />
                <input type="hidden" name="gid" value="0" />
                <input type="hidden" name="fromjsjobsregister" value="1" />
                <input type="hidden" name="jversion" id="jversion" value="<?php echo JVERSION; ?>" />
        <?php echo JHTML::_('form.token'); ?>
            </form>
            </div>
        </div>
        <script type="text/javascript" language="javascript">
            function checkformagain() {
                var cansend = false;
                var username = document.getElementById('username').value;
                jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=userrole.checkuserdetail&fr=username", {val: username}, function (data) {
                    if (data != 0) {
                        document.getElementById('username').className += " invalid";
                        document.getElementById('usernameerror').innerHTML = "<?php echo JText::_('Username is already exist'); ?>"
                        cansend = false;
                    } else {
                        document.getElementById('usernameerror').innerHTML = ""
                        document.getElementById('username').className = "inputbox required";
                        cansend = true;
                    }
                });
                //for email validation
                var email = document.getElementById('email').value;
                jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=userrole.checkuserdetail&fr=email", {val: email}, function (data) {
                    if (data != 0) {
                        document.getElementById('email').className += " invalid";
                        document.getElementById('emailerror').innerHTML = "<?php echo JText::_('Email is already exist'); ?>"
                    } else {
                        document.getElementById('emailerror').innerHTML = ""
                        document.getElementById('email').className = "inputbox required validate-email";
                        if (cansend == true) {
                            var issend = myValidate(document.josForm);
                            if (issend == true)
                                document.josForm.submit();
                        }
                    }
                });
            }
            function checkjsusername() {
                var username = document.getElementById('username').value;
                jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=userrole.checkuserdetail&fr=username", {val: username}, function (data) {
                    if (data != 0) {
                        document.getElementById('username').className += " invalid";
                        document.getElementById('usernameerror').innerHTML = "<?php echo JText::_('Username is already exist'); ?>"
                    } else {
                        document.getElementById('usernameerror').innerHTML = ""
                        document.getElementById('username').className = "inputbox required";
                    }
                });
            }
            function checkjsemail() {
                var email = document.getElementById('email').value;
                jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=userrole.checkuserdetail&fr=email", {val: email}, function (data) {
                    if (data != 0) {
                        document.getElementById('email').className += " invalid";
                        document.getElementById('emailerror').innerHTML = "<?php echo JText::_('Email is already exist'); ?>"
                    } else {
                        document.getElementById('emailerror').innerHTML = ""
                        document.getElementById('email').className = "inputbox required validate-email";
                    }
                });
            }
            function checkjsemailmatch() {
                var email = document.getElementById('email').value;
                var email2 = document.getElementById('email2').value;
                if (email2 != email) {
                    document.getElementById('email2').className += " invalid";
                    document.getElementById('emailmatcherror').innerHTML = "<?php echo JText::_('Email does not match'); ?>"
                } else {
                    document.getElementById('emailmatcherror').innerHTML = ""
                    document.getElementById('email2').className = "inputbox required validate-email";
                }
            }
            function checkjspasswordmatch() {
                var password = document.getElementById('password').value;
                var password2 = document.getElementById('password2').value;
                if (password2 != password) {
                    document.getElementById('password2').className += " invalid";
                    document.getElementById('passwordmatcherror').innerHTML = "<?php echo JText::_('Password does not match'); ?>"
                } else {
                    document.getElementById('passwordmatcherror').innerHTML = ""
                    document.getElementById('password2').className = "inputbox required";
                }
            }

        </script>
        <?php
    } else { // user registration is allowed or not
        $this->jsjobsmessages->getAccessDeniedMsg(JText::_('User registration not allowed'), JText::_('Administrator disable user registration'));
    }
} //ol 
?>
</div>
