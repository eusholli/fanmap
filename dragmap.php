<?php
  $uid = $_GET['uid'];
  $pid = $_GET['pid'];

  require_once 'db/db.inc';
  $query = "SELECT * FROM Fan where fb_page_id=\"" . $pid . "\" AND fb_user_id = \"" . $uid . "\"";
  $thisFan = queryDB($query);
  if($thisFan != null) {
    $thisFan = $thisFan[0];
    $initLocation = $thisFan['latitude'] . ',' . $thisFan['longitude'];
    $cityName = $thisFan['city'] ;
    $countryName = $thisFan['countryName'] ;
    $countryCode = $thisFan['countryCode'] ;
    $resultString = sprintf("Hi %s, we have found a location for you.  Drag the marker to the right if you want to manually change your position.  If you want to be re-positioned using your ip address again, please click <a href=\"http://apps.facebook.com/fanmapping/addfan.php?fanmap_page_id=%s\">here</a>.", $thisFan['name'], $pid);
  } else {
    $initLocation = "";
  }
  $query = "SELECT * FROM Fan where fb_page_id=\"" . $pid . "\"";
  // echo $query;
  $rows = queryDB($query);
?>

<html>
<head>
<?php
  require_once 'common/styles.inc';
?>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://64.124.154.141/fanmap/fluster/lib/Fluster2.packed.js"></script>
<script type="text/javascript">

  var openWindow = null;
  var openMarker = null;
  var thisUserMarker = null;
  var uid = null;
  var pid = null;

  <?php if($thisFan != null) { ?>
    uid = <?php echo $uid; ?>;
    pid = <?php echo $pid; ?>;
    var thisFanLat = <?php echo $thisFan['latitude']; ?>;
    var thisFanLong = <?php echo $thisFan['longitude']; ?>;
    var geocoder = new google.maps.Geocoder();
    var cityName = '<?php echo $cityName; ?>';
    var countryName = '<?php echo $countryName; ?>';
    var countryCode = '<?php echo $countryCode; ?>';

    function updatePosition(latLng) {
      cityName = 'Unknown';
      countryName = 'Unknown';
      countryCode = 'Unknown';
      if (geocoder) {
	geocoder.geocode( { 'latLng': latLng}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
	    var addressComponents = results[0].address_components;
	    var adminAreaLevel1 = null;
	    var adminAreaLevel2 = null;
	    for (var i = 0; i < addressComponents.length; i++) {
	      var addressComponent = results[0].address_components[i];
	      for (var j = 0; j < addressComponent.types.length; j++) {
		var type = addressComponent.types[j];
		if(type == 'locality') {
		  cityName = addressComponent.long_name;
		} else if(type == 'country') {
		  countryName = addressComponent.long_name;
		  countryCode = addressComponent.short_name;
		
		} else if(type == 'administrative_area_level_1') {
		  adminAreaLevel1 = addressComponent.long_name;

		} else if(type == 'administrative_area_level_2') {
		  adminAreaLevel2 = addressComponent.long_name;
		}
	      }
	    }

	    } else {
	    alert("Geocode was not successful for the following reason: " + status);
	  }

	  if(cityName == 'Unknown') {
	    if(adminAreaLevel1 != null) {
	      cityName = adminAreaLevel1;
	    } else if(adminAreaLevel2 != null) {
	      cityName = adminAreaLevel2;
	    }
	  }

	  document.getElementById("cityName").innerHTML=cityName;
	  document.getElementById("countryName").innerHTML=countryName;
	  // document.getElementById("countryCode").innerHTML=countryCode;

	  // alert('&city=' + cityName + '&countryName=' + countryName + '&countryCode=' + countryCode);
	  var latitude = latLng.lat();
	  var longitude = latLng.lng();
	  var http = getHTTPObject();
	  var updateUrl ='http://64.124.154.141/fanmap/positionupdate.php?uid=' + uid + '&pid=' + pid + '&latitude=' + latitude + '&longitude=' + longitude + '&city=' + cityName + '&countryName=' + countryName + '&countryCode=' + countryCode; 
	  http.open("GET", updateUrl, true); 
	  http.onreadystatechange = function() {
	    if (http.readyState == 4) { 
	      // alert('Position Updated');
	      if(thisUserMarker != null) {
		thisUserMarker.setPosition(latLng);
	      }
	    } 
	  }; 
	  http.send(null);
	});
      }
    }


    function getHTTPObject() { 
      if (typeof XMLHttpRequest != 'undefined') { 
	return new XMLHttpRequest(); 
      } 
      try { 
	return new ActiveXObject("Msxml2.XMLHTTP"); 
      } catch (e) { 
	try { 
	  return new ActiveXObject("Microsoft.XMLHTTP"); 
	} catch (e) 
	{
	} 
      } 
      return false; 
    }

  <?php } ?>
    
  function initialize() {
    <?php if($thisFan != null) { ?>
      var latlng = new google.maps.LatLng(thisFanLat, thisFanLong);
      var myOptions = {
	zoom: 10,
	center: latlng,
	mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      var mapPicker = new google.maps.Map(document.getElementById("map_picker"), myOptions);

      var marker = new google.maps.Marker({
      position: latlng,
      draggable: true,
      map: mapPicker
      });

      google.maps.event.addListener(marker, "drag", function(){
	document.getElementById("location").value=marker.getPosition().toUrlValue();
      });

      google.maps.event.addListener(marker,'dragend',function(){
	// document.getElementById("location").value=markerD2.getPoint().toUrlValue();
	var position = marker.getPosition();
	updatePosition(position);
      });

   <?php } ?>

  // From original map.php
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 1,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    // Initialize Fluster and give it a existing map
    var fluster = new Fluster2(map);
	
    <?php 
    if($rows != null) {
      $count=1;
      $overlap = array();
      $overlap[] = array();
      $thisMarker = null;

      foreach($rows as $row) {
      $contentString = '\'<div style="font-family:sans-serif;"><table><tr><td> <a style="text-decoration: none; " href="' . $row['profile_url'] . '"><img border="0" src="' . $row['pic_square'] . '"/></a></td><td><a style="text-decoration: none;" href="' . $row['profile_url'] . '">' . $row['name'] . '</a><br />' . $row['city'] . '<br />' . $row['countryName'] . '</td></tr></table></div>\'';
      $infiwindowVar = 'infiwindow' . $count;
      $markerVar = 'marker' . $count++;
      // $latitude = $row['latitude'];
      // $longitude = $row['longitude'];
      $latitude = floatval($row['latitude']);
      $longitude = floatval($row['longitude']);

      $factor = 0.0;
      while($overlap[strval($latitude)][strval($longitude)] == true) {
	$latitude = $latitude + $factor;
	$factor += 0.0002;
	$longitude = $longitude + $factor;
      }
      $overlap[strval($latitude)][strval($longitude)] = true;

      ?>
	var <?php echo $markerVar ?> = new google.maps.Marker({
	position: new google.maps.LatLng(<?php echo $latitude . ',' . $longitude; ?>), 
	title: "<?php echo $row['name']; ?>",
	// icon: 'http://64.124.154.141/fanmap/images/friends.png',
	clickable: true
	});

	// Add the marker to the Fluster
	fluster.addMarker(<?php echo $markerVar ?>);

	var <?php echo $infiwindowVar ?> = new google.maps.InfoWindow(
	{
	content: <?php echo $contentString ?>

	});

	google.maps.event.addListener(<?php echo $markerVar ?>,'click',function(){
	  if(openWindow != null) {

	    openWindow.close(map,openMarker);
	  }
	  openWindow = <?php echo $infiwindowVar ?>;
	  openMarker = <?php echo $markerVar ?>;
	  <?php echo $infiwindowVar ?>.open(map,<?php echo $markerVar ?>);
	});

      <?php 
          if(($thisMarker == null) && ($pid == $row['fb_page_id']) && ($uid == $row['fb_user_id'])) {
	    echo 'thisUserMarker = ' . $markerVar . ';' ;
	  }
	}
      }
      ?>

    // Initialize Fluster
    // This will set event handlers on the map and calculate clusters the first time.
    fluster.initialize();
  }
</script>
<style type="text/css">
  #fan_details, #map_picker, #map_canvas { margin : 5px; }
</style>
</head>
<body onload="initialize()">
  <?php if($thisFan != null) { ?>
    <div id="fan_details" style="float:left; width:390px">
       <p><?php echo $resultString; ?></p>
       <p>Current Location: <br />
       <input type="text" size="30" readonly="true" id="location" value="<?php echo $initLocation; ?>"><br />
       City: <span id="cityName"><?php echo $cityName; ?></span><br />
       Country: <span id="countryName"><?php echo $countryName; ?></span><br />
    </div>
    <div id="map_picker" style="width:350px; height:190px"></div>
  <?php } ?>
  <div id="map_canvas" style="width:750px; height:390px"></div>
</body>
</html>
