<?php
  require_once "common/styles.inc";
  require_once "common/js.inc";
?>

<fb:fbml>

<!-- BEGIN TAB DISPLAY -->
<div class="fb-tabs clearfix"><center>

   <div class="left_tabs">
      <ul class="fb-tabitems clearfix">
         <?php
 	  $currentPage = basename($_SERVER['PHP_SELF']);
          $baseUrl = 'http://64.124.154.141/fanmap/';
 	  $tabs=array("$baseUrl" . 'home.php' => 'Home', 
		      "$baseUrl" . 'fanmap.php?fanmap_sig_page_id=' . $_POST["fb_sig_page_id"] => 'Fan Map'
 		     );
 	  
	  $count = 1;
 	  foreach($tabs as $key => $value) {
            if($count == 1) {
              $selected = 'class="selected"';
            } else {
              $selected = "";
            }
            $tabId = 'fanmap_tab_' . $count++;
            echo "<li><a id=\"$tabId\" href='#' onclick=\"sub('$key', '$tabId'); return false\" $selected>$value</a></li>";
 	  }

          $tabId = 'fanmap_tab_' . $count++;
          $addMeUrl = "http://apps.facebook.com/fanmapping/addfan.php?fanmap_sig_page_id=" . $_POST['fb_sig_page_id']; 
          echo "<li><a id=\"$tabId\" href=\"$addMeUrl\" >Add/Update Me</a></li>";

          $tabId = 'fanmap_tab_' . $count++;
          $addMeUrl = $baseUrl . "viewall.php?fanmap_sig_page_id=" . $_POST['fb_sig_page_id']; 
          echo "<li><a id=\"$tabId\" href='#' onclick=\"sub('$addMeUrl', '$tabId'); return false\" $selected>View Other Fan Maps</a></li>";
 	?>
      </ul>
   </div>


   <div class="right_tabs">
      <ul class="fb-tabitems clearfix">
        <?php
          $addMeUrl = $baseUrl . "invite.php?fanmap_sig_page_id=" . $_POST['fb_sig_page_id']; 
          echo "<li><a id=\"fanmap_tab_5\" href='#' onclick=\"sub('$addMeUrl', 'fanmap_tab_5'); return false\" $selected>Tell A Friend</a></li>";
        ?>
      </ul>
   </div>


</center></div>
<!-- END TAB DISPLAY -->

<h1>
  <fb:name uid="<?php echo $_POST['fb_sig_page_id']; ?>" linked="false" /> Fan Map
</h1>
<div id="page_content">
  <?php 
    require_once "home.php";
  ?>
</div>
</fb:fbml>
