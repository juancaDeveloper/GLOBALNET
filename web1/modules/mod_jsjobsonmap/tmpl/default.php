<?php
/**
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , info@burujsolutions.com
				www.joomsky.com, ahmad@joomsky.com
 * Created on:	Dec 2, 2009
 ^
 + Project: 		JS Jobs 
 * File Name:	module/hotjsjobs.php
 ^ 
 * Description: Module for JS Jobs
 ^ 
 * History:		1.0.2 - Nov 27, 2010
 ^ 
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
$map_key = $result['config']['google_map_api_key'];
?>
<script type="text/javascript" >
if (typeof google === 'object' && typeof google.maps === 'object'){
  // arlready loaded
}else{
  document.write('<scri'+'pt src="<?php echo $protocol; ?>maps.googleapis.com/maps/api/js?key=<?php echo $map_key; ?>&sensor=false"></'+'script>');
}
</script>

<?php

$contentswrapperstart = '';
if ($result['jobs']) {
    if($result['showtitle'] == 1){
        $moduleclass_sfx = $params->get('moduleclass_sfx');
        if(!empty($moduleclass_sfx) || $moduleclass_sfx != ''){
            $contentswrapperstart .= '
                        <div class="'.$moduleclass_sfx.'"><h3>
                            <span>
                                    <span id="tp_headingtext_left"></span>
                                    <span id="tp_headingtext_center">'.$result['title'].'</span>
                                    <span id="tp_headingtext_right"></span>             
                            </span></h3>
                        </div>
                    ';
        }else{
            $contentswrapperstart .= '
                        <div id="tp_heading">
                            <span id="tp_headingtext">
                                    <span id="tp_headingtext_left"></span>
                                    <span id="tp_headingtext_center">'.$result['title'].'</span>
                                    <span id="tp_headingtext_right"></span>             
                            </span>
                        </div>
                    ';
        }
    }
    foreach ($result['jobs'] as $job) {
        $html = '<a target="_blank" href="'.JRoute::_("index.php?option=com_jsjobs&view=job&layout=view_job&bd=".$job->aliasid).'">'.$job->title.'</a><br/>';
        $job->url = $html;
    }
?>
  <div id="map-canvas" class="map-canvas-module" style="height:<?php echo $result['moduleheight']; ?>;width:100%;" ></div>
  <script type="text/javascript">
    var jobsarray = <?php echo json_encode($result['jobs']); ?>;
    var showCategory = <?php echo $result['category']; ?>;
    var showCompany = <?php echo $result['company']; ?>;

    var map = new google.maps.Map(document.getElementById("map-canvas"), {
      zoom: <?php echo $result['zoom']; ?>,
      center: new google.maps.LatLng(<?php echo $result['config']['default_latitude']; ?>,<?php echo $result['config']['default_longitude']; ?>),
    });
    var markers = [];
    for(i = 0; i < jobsarray.length; i++){
      var geocoder =  new google.maps.Geocoder();
      if(jobsarray[i].multicity !== undefined){
        var job = jobsarray[i];
        for(k = 0; k < jobsarray[i].multicity.length; k++){
          geocoder.geocode( { "address": jobsarray[i].multicity[k].cityname + ',' + jobsarray[i].multicity[k].countryname}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              latitude = results[0].geometry.location.lat();
              longitude = results[0].geometry.location.lng();
              setMarker(map,job,latitude,longitude);
            } else {
              latitude = 0;
              longitude = 0;
            }
          });
        }        
      }else{
		if(jobsarray[i].latitude.indexOf(",") > -1){ // multi location
			var latarray = jobsarray[i].latitude.split(",");
			var longarray = jobsarray[i].longitude.split(",");
			for(l = 0; l < latarray.length; l++){
				var latitudemap = latarray[l];
				var longitudemap = longarray[l];
				var marker = setMarker(map,jobsarray[i],latitudemap,longitudemap);
				markers.push(marker);
			}
		}else{
			var marker = setMarker(map,jobsarray[i],jobsarray[i].latitude,jobsarray[i].longitude);
			markers.push(marker);
		}
      }
    }

    function setMarker(map,jobObject,latitude,longitude){
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(latitude, longitude),
        map: map
      });
      var infowindow = new google.maps.InfoWindow();
      google.maps.event.addListener(marker, "click", (function(marker) {
        return function() {
          var markerContent = jobObject.url;
          if(showCompany === 1){
            markerContent += jobObject.companyname+'<br/>';
          }
          if(showCategory === 1){
            markerContent += jobObject.cat_title;
          }
          infowindow.setContent(markerContent);
          infowindow.open(map, marker);
        }
      })(marker));
      return marker;
    }
    /*
    function autoCenter() {
      //  Create a new viewpoint bound
      var bounds = new google.maps.LatLngBounds();
      //  Go through each...
      jQuery.each(markers, function (index, marker) {
        bounds.extend(marker.position);
      });
      //  Fit these bounds to the map
      map.fitBounds(bounds);
    }
    autoCenter();
    */
  </script>
<?php } ?>
