<?php
  require_once 'db/db.inc';
  $query = "SELECT * FROM Fan where fb_page_id=\"" . $_GET['fanmap_sig_page_id'] . "\"";
  // echo $query;
  $rows = queryDB($query);
?>

<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://64.124.154.141/fanmap/fluster/lib/Fluster2.packed.js"></script>
<script type="text/javascript">
  var openWindow = null;
  var openMarker = null;
  function initialize() {
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 1,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    // Initialize Fluster and give it a existing map
    var fluster = new Fluster2(map);
	
//    var latlngbounds = new google.maps.LatLngBounds();
//    <?php
//    foreach($rows as $row) {
//    ?>
//      // latlng: an array of instances of GLatLng
//      latlngbounds.extend( new google.maps.LatLng(<?php echo $row['latitude'] . ',' . $row['longitude']; ?>) );
//    <?php 
//    }
//    ?>
//    map.fitBounds(latlngbounds);

    <?php 
    if($rows != null) {
      $count=1;
      $overlap = array();
      $overlap[] = array();

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
	}
      }
      ?>

    // Initialize Fluster
    // This will set event handlers on the map and calculate clusters the first time.
    fluster.initialize();
  }

</script>
</head>
<body onload="initialize()">
  <div id="map_canvas" style="width:100%; height:100%"></div>
</body>
</html>
