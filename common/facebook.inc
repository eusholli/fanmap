<?php // Get these from http://developers.facebook.com
  require_once 'facebook-platform/php/facebook.php';

  function getFacebookClient() {
    $api_key = 'cca190992729f695a194c6e996c46563';
    $secret = '034429cd8700f50c14ac867082961aa2';
    
    $facebook = new Facebook($api_key, $secret, true);
    return $facebook;
  }
?>
