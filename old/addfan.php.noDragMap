<?php 

  require_once "common/styles.inc";
  require_once "common/facebook.inc";
  $facebook = getFacebookClient();

  $fanmapPageId = $_GET['fanmap_sig_page_id'];
  // echo "$fanmapPageId";

  $addr = $_SERVER['HTTP_X_FB_USER_REMOTE_ADDR'];
  if(empty($addr)){
     echo "fanmap HTTP_X_FB_USER_REMOTE_ADDR is empty";
  } else {
     // echo "ipaddress is $addr";
  }

  // for testing
  // $fanmapPageId = 159937845274;

  $aboutMe = array(' uid','name','pic_square','profile_url'); 
  // $fbid = $facebook->user;
  $fbid = $_POST['fb_sig_user'];
  if($fbid == null) {
    $fbid = $_POST['fb_sig_canvas_user'];
  }
  // echo "$fbid";
  // $fbid = 637943667;

  // $fanDetails = $facebook->api_client->users_getInfo(array($fbid), $aboutMe);
  $fanDetails = $facebook->api_client->users_getInfo($fbid, 'uid,name,pic_square,profile_url');
  $debug = "Fan Details for " . $fbid . ' ' . print_r($fanDetails,true);
  syslog(LOG_DEBUG, $debug);

  $pageInfo = $facebook->api_client->pages_getInfo($fanmapPageId, 'name,page_url', null, null);
  $pageUrl = $pageInfo[0]['page_url'];
  $pageName = $pageInfo[0]['name'];
  
  require_once 'db/db.inc';

  // for testing
  // $addr = "64.30.175.242";

  if(!empty($fanDetails) && isset($addr)) {
     $location = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$addr));
     // print_r($location);
  }

  // only do if we have a valid latitude we can display
  // assume others are also valid if this is
  if(!empty($location['geoplugin_latitude'])) {

    $fan = array('fb_page_id' => $fanmapPageId, 'fb_user_id' => $fbid);
    $fan['name'] = $fanDetails[0]['name'];
    $fan['pic_square'] = $fanDetails[0]['pic_square'];
    $fan['profile_url'] = $fanDetails[0]['profile_url'];

    $fan['latitude'] = $location['geoplugin_latitude'];
    $fan['longitude'] = $location['geoplugin_longitude'];
    $fan['city'] = $location['geoplugin_city'];
    $fan['countryName'] = $location['geoplugin_countryName'];
    $fan['countryCode'] = $location['geoplugin_countryCode'];

    // print_r($fan);
    updateFan($fan);
    $resultString = sprintf("<p>Hi <fb:name uid=\"%s\" linked=\"false\" useyou=\"false\" firstnameonly=\"true\" />, we have located you in %s, %s and have added you to the map.  To update your location in the future return to this page.</p>", $fbid, $fan['city'], $fan['countryName']);
  } else {
    $resultString = sprintf("<p>Hi <fb:name uid=\"%s\" linked=\"false\" useyou=\"false\" firstnameonly=\"true\" />, unfortunately we could not locate you from ip address %s.  Please return to to this link in the future and try again.</p>", $fbid, $addr);
  }

?>

<fb:fbml>

<!-- BEGIN TAB DISPLAY -->
<div class="fb-tabs clearfix"><center>

   <div class="left_tabs">
      <ul class="fb-tabitems clearfix">
         <?php
           echo "<li><a id=\"tab1\" href=\"$pageUrl\" >Return back to $pageName</a></li>";
 	 ?>
      </ul>
   </div>


</center></div>
<!-- END TAB DISPLAY -->

<h1>
  <fb:name uid="<?php echo $fanmapPageId; ?>" linked="false" /> Fan Map 
</h1>
<?php echo $resultString; ?> 
<div id="page_content">
  <fb:iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="10" marginwidth="0" src="http://64.124.154.141/fanmap/map.php?fanmap_sig_page_id=<?php echo $_GET['fanmap_sig_page_id']; ?>"></fb:iframe>
</div>
</fb:fbml>
