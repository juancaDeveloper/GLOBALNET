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
<div id="js_job_black_friend" style="display:none;"></div>
<div id="tellafriend" class="tellafriend">
    <form action="index.php" method="POST" class="jsautoz_form">
        <div id="tellafriend_headline">
            <?php echo JText::_('Tell A Friend'); ?>
            <img class="closeimg" onclick="closetellafriend();" src="<?php echo JURI::root();?>components/com_jsjobs/images/popup-close.png">
        </div>
        <div id="borderfieldwrapper">
        <div class="fieldwrapper">
            <div class="fieldtitle"><?php echo JText::_('Your Name'); ?><font color="red">*</font></div>
            <div class="fieldvalue"><input class="inputbox required" type="text" name="sendername" id="sendername" value=""/></div>
        </div>
        <div class="fieldwrapper">
            <div class="fieldtitle"><?php echo JText::_('Your Email'); ?><font color="red">*</font></div>
            <div class="fieldvalue"><input class="inputbox required" type="text" name="senderemail" id="senderemail" value=""/></div>
        </div>
        <div class="fieldwrapper">
            <div class="fieldtitle"><?php echo JText::_('Job Title'); ?><font color="red">*</font></div>
            <div class="fieldvalue"><input class="inputbox required" type="text" name="jobtitle" id="jobtitle" value="" disabled="disabled"/></div>
        </div>
        <div class="fieldwrapper">
            <div class="fieldtitle"><?php echo JText::_('Friend Email'); ?><font color="red">*</font></div>
            <div class="fieldvalue"><input class="inputbox required validate-email" type="text" name="email1" id="email1" value=""/></div>
        </div>
        <div class="fieldwrapper">
            <div class="fieldtitle"><?php echo JText::_('Friend Email'); ?></div>
            <div class="fieldvalue"><input class="inputbox validate-email" type="text" name="email2" id="email2" value="" /></div>
        </div>
        <div class="fieldwrapper">
            <div class="fieldtitle"><?php echo JText::_('Friend Email'); ?></div>
            <div class="fieldvalue"><input class="inputbox validate-email" type="text" name="email3" id="email3" value="" /></div>
        </div>
        <div class="fieldwrapper">
            <div class="fieldtitle"><?php echo JText::_('Friend Email'); ?></div>
            <div class="fieldvalue"><input class="inputbox validate-email" type="text" name="email4" id="email4" value=""/></div>
        </div>
        <div class="fieldwrapper">
            <div class="fieldtitle"><?php echo JText::_('Friend Email'); ?></div>
            <div class="fieldvalue"><input class="inputbox validate-email" type="text" name="email5" id="email5" value=""/></div>
        </div>
        <div class="fieldwrapper fullwidth">
            <div class="fieldtitle"><?php echo JText::_('Message'); ?><font color="red">*</font></div>
            <div class="fieldvalue">
                <textarea class="inputbox required" name="message" id="message" cols="45" rows="3" maxlength="250" style="resize:none;"></textarea>
                <div class="righttext"><?php echo JText::_('Max Length Is 250 Chars'); ?></div>
            </div>
        </div>
        <div class="fieldwrapper fullwidth button">
            <input class="js_job_tellafreind_button save" type="button" onclick="Javascript: friendValidate();" value="<?php echo JText::_('Send To Friends'); ?>"/>&nbsp;&nbsp;
            <input class="js_job_tellafreind_button" type="button" onclick="Javascript: closetellafriend();" value="<?php echo JText::_('Close'); ?>" />
        </div>
        <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
        <input type="hidden" name="task" value="savecompany" />
        <input type="hidden" name="c" value="company" />
        <input type="hidden" name="jobid" id="jobid" value="" />
    </div>
    </form>
    <div id="tellafriendsuccessmsg" class="tellafriendsuccessmsg">
        <div id="tellafriend_headline">
            <?php echo JText::_('Tell A Friend'); ?>
        </div>
        <div id="successmsg" class="successmsg">
            <span><?php echo JText::_('Job successfully sent to friends'); ?></span>
        </div>
        <div class="fieldwrapper fullwidth button">
            <input class="js_job_tellafreind_button" type="button" onclick="Javascript: closetellafriend();" value="<?php echo JText::_('Close'); ?>" />
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_jsjobs/js/tinybox.js"></script>
<link media="screen" rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_jsjobs/js/style.css" />
<script language="javascript">
    jQuery(document).ready(function () {
        jQuery("div#js_job_black_friend").click(function () {
            jQuery("div#tellafriend").fadeOut();
            jQuery("div#js_job_black_friend").fadeOut();
        });
    })

    function closetellafriend() {
        (function ($) {
            $('#tellafriend').slideUp("slow");
            $('#js_job_black_friend').fadeOut();
        })(jQuery);
    }
    function showtellafriend(jobid, jobtitle) {
        (function ($) {
            $('#js_job_black_friend').fadeIn();
            $('#tellafriend').slideDown("slow");
            document.getElementById('jobid').value = jobid;
            $("div#jspopup_title").html("<?php echo JText::_('Tell A Friend');?>");
            document.getElementById('jobtitle').value = jobtitle;
        })(jQuery);
    }

    function friendValidate() {
        var arr = new Array();
        if (document.getElementById('sendername').value == '') {
            alert("<?php echo JText::_('Your name is required').'!'; ?>");
            document.getElementById('sendername').focus();
            return false;
        }
        arr[0] = document.getElementById('sendername').value;
        if (document.getElementById('senderemail').value == '') {
            alert("<?php echo JText::_('Your email is required').'!'; ?>");
            document.getElementById('senderemail').focus();
            return false;
        } else {
            var result = echeck(document.getElementById('senderemail').value);
            if (result == false) {
                alert("<?php echo JText::_('Invalid Email'); ?>");
                document.getElementById('senderemail').focus();
                return false;
            }
        }
        arr[1] = document.getElementById('senderemail').value;
        if (document.getElementById('email1').value == '') {
            alert("<?php echo JText::_('Enter atleast one friend email'); ?>");
            document.getElementById('email1').focus();
            return false;
        } else {
            var result = echeck(document.getElementById('email1').value);
            if (result == false) {
                alert("<?php echo JText::_('Invalid Email'); ?>");
                document.getElementById('email1').focus();
                return false;
            }
        }
        arr[2] = document.getElementById('email1').value;
        if (document.getElementById('email2').value != '') {
            var result = echeck(document.getElementById('email2').value);
            if (result == false) {
                alert("<?php echo JText::_('Invalid Email'); ?>");
                document.getElementById('email2').focus();
                return false;
            }
        }
        arr[3] = document.getElementById('email2').value;
        if (document.getElementById('email3').value != '') {
            var result = echeck(document.getElementById('email3').value);
            if (result == false) {
                alert("<?php echo JText::_('Invalid Email'); ?>");
                document.getElementById('email3').focus();
                return false;
            }
        }
        arr[4] = document.getElementById('email3').value;
        if (document.getElementById('email4').value != '') {
            var result = echeck(document.getElementById('email4').value);
            if (result == false) {
                alert("<?php echo JText::_('Invalid Email'); ?>");
                document.getElementById('email4').focus();
                return false;
            }
        }
        arr[5] = document.getElementById('email4').value;
        if (document.getElementById('email5').value != '') {
            var result = echeck(document.getElementById('email5').value);
            if (result == false) {
                alert("<?php echo JText::_('Invalid Email'); ?>");
                document.getElementById('email5').focus();
                return false;
            }
        }
        arr[6] = document.getElementById('email5').value;
        if (document.getElementById('message').value == '') {
            alert("<?php echo JText::_('Please enter message'); ?>");
            document.getElementById('message').focus();
            return false;
        }
        arr[7] = document.getElementById('message').value;
        arr[8] = document.getElementById('jobid').value;
        sendtofriend(arr);
    }
    function sendtofriend(vars) {
        var itemid= '<?php echo JRequest::getVar("Itemid",105);?>'
        jQuery.post("<?php echo JURI::root(); ?>index.php?option=com_jsjobs&task=emailtemplate.sendtofriend", {val: JSON.stringify(vars),itemid:itemid}, function (data) {
            if (data || data == true) {
                jQuery('#tellafriend form').css('display', 'none');
                jQuery('#tellafriendsuccessmsg').toggle();
                // TINY.box.show({html: "<?php echo JText::_('Job Successfully Sent To Friends'); ?>", animate: true, boxid: 'frameless', close: true});
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            }
        });
    }
    function echeck(str) {
        var at = "@";
        var dot = ".";
        var lat = str.indexOf(at);
        var lstr = str.length;
        var ldot = str.indexOf(dot);

        if (str.indexOf(at) == -1)
            return false;
        if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr)
            return false;
        if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr)
            return false;
        if (str.indexOf(at, (lat + 1)) != -1)
            return false;
        if (str.substring(lat - 1, lat) == dot || str.substring(lat + 1, lat + 2) == dot)
            return false;
        if (str.indexOf(dot, (lat + 2)) == -1)
            return false;
        if (str.indexOf(" ") != -1)
            return false;
        return true;
    }
</script>
