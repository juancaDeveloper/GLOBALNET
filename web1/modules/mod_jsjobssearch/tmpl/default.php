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
$document->addStyleSheet('components/com_jsjobs/css/token-input-jsjobs.css');

JHTML::_('behavior.calendar');
$version = new JVersion;
$joomla = $version->getShortVersion();
$jversion = substr($joomla, 0, 3);

if ($jversion < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('components/com_jsjobs/js/jquery.tokeninput.js');


$divclass = array('odd', 'even');
$colcount = 1;

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
<form class="jsautoz_form" action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=job&view=job&layout=jobs&Itemid=' . $result['itemid']); ?>" method="post" name="js-jobs-form-mod" id="js-jobs-form-mod">
    <input type="hidden" name="isjobsearch" value="1" />
    <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
        <div class="text-left">
<?php echo JText::_('Job title'); ?>
        </div>
        <div class="text-left">
            <input class="inputbox" type="text" name="jobtitle" size="27" maxlength="255"/>
        </div>
    </div>  
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
            <div class="text-left" >
    <?php echo JText::_('Sub categories'); ?>
            </div>
            <div class="text-left" id="modfj_subcategory">
    <?php echo $result['job_subcategories']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_jobtype'] == 1) { ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
    <?php echo JText::_('Job type'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['job_type']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_jobstatus'] == 1) { ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
    <?php echo JText::_('Job status'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['job_status']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_salaryrange'] == 1) { ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
    <?php echo JText::_('Salary range'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['salaryrangefrom'] . ' ' . $result['salaryrangeto']; ?>
            </div>
        </div>  
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
    <?php echo JText::_('Salary type'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['currency'] . ' ' . $result['salaryrangetypes']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_shift'] == 1) { ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
    <?php echo JText::_('Shift'); ?>
            </div>
            <div class="text-left">
    <?php echo $result['search_shift']; ?>
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_durration'] == 1) { ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
    <?php echo JText::_('Duration'); ?>
            </div>
            <div class="text-left">
                <input class="inputbox" type="text" name="durration" size="10" maxlength="15"  />
            </div>
        </div>  
<?php } ?>
    <?php if ($result['sh_startpublishing'] == 1) {
        $startdatevalue = '';
        ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
                <?php echo JText::_('Start publishing'); ?>
            </div>
            <div class="text-left">
                <?php echo JHTML::_('calendar', $startdatevalue, 'startpublishing', 'id_startpublishing', $result['js_dateformat'], array('class' => 'inputbox', 'size' => '10', 'maxlength' => '19')); ?>
            </div>
        </div>  
    <?php } ?>
    <?php if ($result['sh_stoppublishing'] == 1) {
        $stopdatevalue = '';
        ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
                <?php echo JText::_('Stop publishing'); ?>
            </div>
            <div class="text-left">
                <?php echo JHTML::_('calendar', $stopdatevalue, 'stoppublishing', 'id_stoppublishing', $result['js_dateformat'], array('class' => 'inputbox', 'size' => '10', 'maxlength' => '19')); ?>
            </div>
        </div>  
    <?php } ?>
    <?php if ($result['sh_company'] == 1) { ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
                <?php echo JText::_('Company name'); ?>
            </div>
            <div class="text-left">
                <?php echo $result['search_companies']; ?>
            </div>
        </div>  
    <?php } ?>
    <?php if ($result['sh_addresses'] == 1) { ?>
        <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
            <div class="text-left" >
                <?php echo JText::_('City'); ?>
            </div>
            <div class="text-left">
                <span id="modsearchjob_city">
                    <input class="inputbox" type="text" name="city" id="citymod" size="27" maxlength="100"  />
                </span>
            </div>
        </div>  
    <?php } ?>
    <div class="fieldwrapper" style="float:left;width:<?php echo $result['colwidth']; ?>">
        <input id="button" type="submit" class="button" name="submit_app" onclick="document.mjsadminForm.submit();" value="<?php echo JText::_('Search Job'); ?>" />&nbsp;&nbsp;&nbsp;
        <span id="themeanchor">
            <a id="button" class="button minpad" style="white-space:nowrap;"href="index.php?option=com_jsjobs&c=job&view=job&layout=jobsearch&Itemid=<?php echo $result['itemid']; ?>"><?php echo JText::_('Advanced Search'); ?></a>
        </span>
    </div>
    <input type="hidden" name="view" value="job" />
    <input type="hidden" name="layout" value="jobs" />
    <input type="hidden" name="uid" value="" />
    <input type="hidden" name="option" value="com_jsjobs" />

    
<script language=Javascript>
    <?php if ($result['sh_addresses'] == 1) { ?>
        jQuery(document).ready(function () {
            jQuery("#citymod").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&task=cities.getaddressdatabycityname"; ?>", {
                theme: "jsjobs",
                width: jQuery("span#modsearchjob_city").width(),
                preventDuplicates: true,
                hintText: "<?php echo JText::_('Type in a search term'); ?>",
                noResultsText: "<?php echo JText::_('No results'); ?>",
                searchingText: "<?php echo JText::_('Searching...'); ?>",
                tokenLimit: 1

            });
        });
    <?php } ?>            

    function modsearchjob_dochange(src, val) {
        var xhr;
        try {
            xhr = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (e)
        {
            try {
                xhr = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch (e2)
            {
                try {
                    xhr = new XMLHttpRequest();
                }
                catch (e3) {
                    xhr = false;
                }
            }
        }

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {

                document.getElementById("modsearchjob_" + src).innerHTML = xhr.responseText; //retuen value

                if (src == 'state') {
                    countyhtml = "<input class='inputbox' type='text' name='county' size='27' maxlength='100'  />";
                    cityhtml = "<input class='inputbox' type='text' name='city' size='27' maxlength='100'  />";
                    document.getElementById('modsearchjob_county').innerHTML = countyhtml; //retuen value
                    document.getElementById('modsearchjob_city').innerHTML = cityhtml; //retuen value
                } else if (src == 'county') {
                    cityhtml = "<input class='inputbox' type='text' name='city' size='27' maxlength='100'  />";
                    document.getElementById('modsearchjob_city').innerHTML = cityhtml; //retuen value
                }

            }
        }

        xhr.open("GET", "index2.php?option=com_jsjobs&task=listmodsearchaddressdata&data=" + src + "&val=" + val + "&for=modsearchjob_", true);
        xhr.send(null);

    }
    function modfj_getsubcategories(src, val) {
        var xhr;
        try {
            xhr = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (e) {
            try {
                xhr = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch (e2) {
                try {
                    xhr = new XMLHttpRequest();
                }
                catch (e3) {
                    xhr = false;
                }
            }
        }

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById(src).innerHTML = xhr.responseText; //retuen value
            }
        }

        xhr.open("GET", "index.php?option=com_jsjobs&task=subcategory.listsubcategoriesForSearch&val=" + val + "&md=" + 1, true);
        xhr.send(null);
    }
    //window.onLoad=modsearchjob_dochange('country', -1);         // value in first dropdown
</script>
</form>