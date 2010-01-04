<?php
  $pageId = $_GET['fanmap_sig_page_id'];
  $uId = $_GET['fb_sig_user'];
?>

<h2>Latest Fan Map on <?php print date("T F j, Y, g:i a"); ?> for <fb:name uid="<?php echo $pageId; ?>" linked="false" /></h2>

<fb:iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="10" marginwidth="0" src="http://64.124.154.141/fanmap/dragmap.php?pid=<?php echo $pageId'] . '&uid=' . $uid; ?>"></fb:iframe>
