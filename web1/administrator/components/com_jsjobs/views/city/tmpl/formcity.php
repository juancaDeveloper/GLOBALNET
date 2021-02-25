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
JHTML::_('behavior.formvalidation');
?>

<script type="text/javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'city.save') {
                returnvalue = validate_form(document.adminForm);
            } else
                returnvalue = true;
            if (returnvalue) {
                Joomla.submitform(task);
                return true;
            } else
                return false;
        }
    }
    function validate_form(f)
    {
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php if (JVERSION < '3')
    echo JUtility::getToken();
else
    echo JSession::getFormToken();
?>';//send token
        }
        else {
            alert("<?php echo JText::_("Some values are not acceptable").'. '.JText::_("Please retry"); ?>");
            return false;
        }
        return true;
    }
</script>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=city&view=city&layout=cities&sd=<?php echo $this->stateid; ?>&ct=<?php echo $this->countryid; ?>"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
        <?php if (isset($this->city->id)){ ?>
        <span id="heading-text"><?php echo JText::_('Edit City'); ?></span>
        <?php }else{ ?>
        <span id="heading-text"><?php echo JText::_('Form City'); ?></span>
         <?php } ?>
        </div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm" >
            <div class="js-form-area">
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="name"><?php echo JText::_('Title'); ?></label>
                    <div class="jsjobs-value"><?php echo $this->list['states']; ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="name"><?php echo JText::_('Name'); ?></label>
                    <div class="jsjobs-value"><input class="inputbox required" type="text" name="name" id="name" size="40" maxlength="255" value="<?php if (isset($this->city)) echo $this->city->name; ?>" />
                        <small><a href="#" onclick="loadLatLng();"><?php echo JText::_("Show Map"); ?></a></small>
                    </div>
                </div>
                <div id="js-form-wrapper">
                    <label class="jsjobs-title" for="name"></label>
                    <div class="jsjobs-value">
                        <div id="googlemapcontainer"></div>
                    </div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="latitude"><?php echo JText::_('Latitude'); ?></label>
                    <div class="jsjobs-value"><input class="inputbox" type="text" name="latitude" id="latitude" size="40" maxlength="255" value="<?php if (isset($this->city)) echo $this->city->latitude; ?>" /></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="longitude"><?php echo JText::_('Longitude'); ?></label>
                    <div class="jsjobs-value"><input class="inputbox" type="text" name="longitude" id="longitude" size="40" maxlength="255" value="<?php if (isset($this->city)) echo $this->city->longitude; ?>" /></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Status'); ?></label>
                    <div class="jsjobs-value"><div class="div-white"><span class="js-cross"><input type="checkbox" name="enabled" id="status" value="1" <?php
                                                     if (isset($this->city)) {
                                                         if ($this->city->enabled == '1')
                                                             echo 'checked';
                                                     }
?>/></span> <label class="js-publish" for="status" ><?php echo JText::_('Publish'); ?></label>
                                                     </div>
                    </div>
                </div>

               <input type="hidden" name="id" value="<?php if (isset($this->city)) echo $this->city->id; ?>" />
<?php if (isset($this->city->id) AND ( $this->city->id != 0)) { ?>
                    <input type="hidden" name="isedit" value="1" />
<?php } ?>
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="task" value="city.savecity" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" id="countryname" value="<?php echo $this->getJSModel('country')->getCountryById($this->countryid)->name; ?>" />
                <input type="hidden" id="edit_latitude" value="<?php if (isset($this->city)) echo $this->city->latitude; ?>" />
                <input type="hidden" id="edit_longitude" value="<?php if (isset($this->city)) echo $this->city->longitude; ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>        
            </div>
            <div class="js-buttons-area">
                <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=city&view=city&layout=cities&ct=97"><?php echo JText::_('Cancel'); ?></a>
                <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save City'); ?>" />
            </div>
        </form>
    </div>
</div>
<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
?>    
<script type="text/javascript" src="<?php echo $protocol; ?>maps.googleapis.com/maps/api/js?key=<?php echo $this->config['google_map_api_key']; ?>"></script>
<script type="text/javascript">

var map,marker;

function loadLatLng(){

    if(!map){        

        jQuery("#js-form-wrapper").addClass("js-form-wrapper");
        jQuery("#googlemapcontainer").css("height","200px");

        var edit_latitude = jQuery("#edit_latitude").val();
        var edit_longitude = jQuery("#edit_longitude").val();
        var cityname = jQuery("#name").val().trim();

        if(edit_latitude != '' && edit_longitude != ''){
            renderMap(new google.maps.LatLng(edit_latitude,edit_longitude));
            addMarker(new google.maps.LatLng(edit_latitude,edit_longitude));
        }else if(cityname != ''){
            if(jQuery("#stateid").val() != '')
                cityname += ', '+jQuery("#stateid option:selected").text();
            cityname += ', '+jQuery("#countryname").val();

            var geocoder =  new google.maps.Geocoder();
            geocoder.geocode( { 'address': cityname}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var n_latitude = results[0].geometry.location.lat();
                    var n_longitude = results[0].geometry.location.lng();
                    renderMap(new google.maps.LatLng(n_latitude,n_longitude));
                } else {
                    renderMap();
                }
            });
        }else{
            renderMap();
        }
    }
}

function renderMap(latlng){
    if(!latlng)
        latlng = new google.maps.LatLng("<?php echo $this->config['default_latitude'] ?>","<?php echo $this->config['default_longitude'] ?>");
    var myOptions = {
        zoom: 9,
        center: latlng,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("googlemapcontainer"), myOptions);
    google.maps.event.addListener(map, "click", function (e) {
        var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                addMarker(results[0].geometry.location);
            } else {
                alert("Geocode was not successful for the following reason: " + status);
                jQuery("#latitude").val('');
                jQuery("#longitude").val('');
            }
        });
    });
}

function addMarker(latlang){
    if(marker){
        marker.setMap(null);
        marker = null;
    }
    marker = new google.maps.Marker({
        position: latlang,
        map: map
    });
    marker.setMap(map);
    map.setCenter(latlang);
    jQuery("#latitude").val(latlang.lat());
    jQuery("#longitude").val(latlang.lng());
}

</script>
<div id="jsjobsfooter">
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



