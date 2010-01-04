<?php
  require_once "common/styles.inc";
  $tfgPageId = "158578370983";
?>

<script type="text/javascript">
<!-- 

  function sub(post_url, id){
    var ajax                = new Ajax();
    ajax.responseType = Ajax.FBML;

    ajax.ondone = function(data){
      document.getElementById('page_content').setInnerFBML(data);
    }

    ajax.onerror = function(){
      new Dialog(Dialog.DIALOG_POP).showMessage('Error', 'Loading error! Please try again!', button_confirm = 'Okay');
    }

    var params = {'name' : 'mahmud'};
    ajax.post(post_url, params);
    return true;
  }

//--> 
</script>


<fb:fbml>

<h1>
  Welcome to the <b>Fan Map</b> Application
</h1>
<p>If you are a page admin for a fan page, you can add this application it.  It maps your fans using their ip addresses and automatically updates a map where everyone can see a map of their fellow fans.  Please note your fans are always in control and choose if they want to be added via the "Add/Update Me" tab</p>
<p>
This application was first designed for use on the <a href="http://facebook.com/technologyforgood">Technology for Good</a> Fan Page and we decided to make it available to everyone for free.  If you use this application then please promote the Technology for Good page on your site.  We would love you to become a fan and join our conversation.
</p>
<p>
To add this application to your page: 
<ol>
  <li>Go to the Fan Map Application About Page <a href="http://www.facebook.com/apps/application.php?id=381742235225">here</a></li>
  <li>Click on "Add to my Page"</li>
  <li>Find the page you wish to add the Fan Map application to and click "Add to Page"</li>
  <li>Close the pop up window, go to to your page and click "Edit Page"</li>
  <li>Find the Fan Map application, click on "Application Settings"</li>
  <li>Where it says Tab: Available click "add"</li>
  <li>A tab called "Fan Map" should now be available on your page</>
  <li>Enjoy and encourage your fans to map themselves</li>
</ol>
</p>
<p>
Find below a list of Fan Pages that have already added the application and view their fan maps.
</p>

<div id="page_content">
  <h2>Latest Fan Map on <?php print date("T F j, Y, g:i a"); ?> for <fb:name uid="<?php echo $tfgPageId; ?>" linked="false" /></h2>
  <fb:iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="10" marginwidth="0" src="http://64.124.154.141/fanmap/map.php?fanmap_sig_page_id=<?php echo $tfgPageId; ?>"></fb:iframe>
</div>

<?php 
  require_once "viewall.php";
?>
</fb:fbml>
