<?php
  require_once 'db/db.inc';
  $latitude = $_GET['latitude'];
  $longitude = $_GET['longitude'];
  $city = $_GET['city'];
  $countryName = $_GET['countryName'];
  $countryCode = $_GET['countryCode'];
  $uid = $_GET['uid'];
  $pid = $_GET['pid'];
  $fan = array('fb_page_id' => $pid, 'fb_user_id' => $uid, 'latitude' => $latitude, 'longitude' => $longitude, 'city' => $city, 'countryName' => $countryName, 'countryCode' => $countryCode);
  updateFan($fan);
  echo "OK";
?>


