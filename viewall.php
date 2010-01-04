<?php
  require_once "common/facebook.inc";
  $facebook = getFacebookClient();
?>

<p></p>
<h2>Other Fan Maps</h2>
<p>To learn how to add to any of fan pages you administer click <a href="http://apps.facebook.com/fanmapping">here!</a></p>
<?php
  require_once 'db/db.inc';
  $query = "SELECT DISTINCT fb_page_id FROM Fan";
  // echo $query;
  $rows = queryDB($query);

  if(sizeof($rows) > 0) {

    echo "<table class=\"fanmap_list\"><tbody class=\"fanmap_list\">";
    foreach($rows as $row) {
      $page= $facebook->api_client->pages_getInfo($row['fb_page_id'], 'page_id,name,pic_square,page_url', null, null);
      $pageName = $page[0]['name'];
      $pageUrl = $page[0]['page_url'];
      $pagePic = $page[0]['pic_square'];
      $pageId = $page[0]['page_id'];
      echo "<tr class=\"fanmap_list\">";
      $addMeUrl = "http://64.124.154.141/fanmap/fanmap.php?fanmap_sig_page_id=" . $pageId;
      $fanMapFetch = "<a id=\"fanmap_tab_2\" href='#' onclick=\"sub('$addMeUrl', 'fanmap_tab_2'); return false\">View Fan Map</a>";
      $outString = sprintf ("<td class=\"fanmap_list\"><img src=\"%s\" /></td><td class=\"fanmap_list\">%s</td><td class=\"fanmap_list\">%s</td><td class=\"fanmap_list\"><a href=\"%s\">Goto Fan Page</a></td>", $pagePic, $pageName, $fanMapFetch, $pageUrl);
      echo $outString;
      echo "<td>";
      echo "</tr>";
    }
    echo "</tbody></table>";

  } else {
    print "<p>No Fan Pages currently using Fan Map. Come back in the future when the word is out...</p>";
  }
?>

