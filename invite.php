<?php // Get these from http://developers.facebook.com

  require_once "common/facebook.inc";
  $facebook = getFacebookClient();

  $pageId = $_GET['fanmap_sig_page_id'];
  
  $pageInfo = $facebook->api_client->pages_getInfo($pageId, 'page_id,name,pic_square,page_url', null, null);
  $pageName = $pageInfo[0]['name'];
  $pageUrl = $pageInfo[0]['page_url'];

  if(isset($_POST["ids"])) { echo "<center>Thank you for inviting ".sizeof($_POST["ids"])." of your friends on <b><a href=\"".$pageUrl ."/\">".$pageName."</a></b>.<br><br>\n"; echo "<h2><a href=\"" . $pageUrl ."/\">Click here to return to ".$pageName."</a>.</h2></center>"; } else {
    // Retrieve array of friends who've already authorized the app.
    // $fql = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$user.') AND is_app_user = 1';
    // $_friends = $facebook->api_client->fql_query($fql);
    // Extract the user ID's returned in the FQL request into a new array.
    // $friends = array(); if (is_array($_friends) && count($_friends)) { foreach ($_friends as $friend) { $friends[] = $friend['uid']; } }
    // Convert the array of friends into a comma-delimeted string.
    // $friends = implode(',', $friends);

    // Prepare the invitation text that all invited users will receive.
    $content = "I have become a fan of <a href=\"".$pageUrl."/\">".$pageName."</a> and thought it's so cool even you should try it out!\n". "<fb:req-choice url=\"" . $pageUrl . "\" label=\"Become a fan today\" />";
    ?>

  <fb:request-form action="#" method="post"
	  type="<?php echo $pageName; ?>"
	  invite = "true"
	  content="<?php echo htmlentities($content,ENT_COMPAT,'UTF-8'); ?>">
	  <fb:multi-friend-selector
		  actiontext="Invite more of your friends to this Fan Map powered Fan Page" />

  </fb:request-form>
    <?php
  }
?>
