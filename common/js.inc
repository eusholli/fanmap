<script type="text/javascript">
<!-- 

  function sub(post_url, id){
    var ajax                = new Ajax();
    ajax.responseType = Ajax.FBML;

    ajax.ondone = function(data){
      document.getElementById('page_content').setInnerFBML(data);
//       new Dialog(Dialog.DIALOG_POP).showMessage('Status', id, button_confirm = 'Okay');
      setselected(id);
    }

    ajax.onerror = function(){
      new Dialog(Dialog.DIALOG_POP).showMessage('Error', 'Loading error! Please try again!', button_confirm = 'Okay');
    }

    var params = {'name' : 'mahmud'};
    ajax.post(post_url, params);
    return true;
  }

  function setselected(id) { 
    // new Dialog(Dialog.DIALOG_POP).showMessage('Status', id, button_confirm = 'Okay');
    document.getElementById("fanmap_tab_1").setClassName("");
    document.getElementById("fanmap_tab_2").setClassName("");
    document.getElementById("fanmap_tab_3").setClassName("");
    document.getElementById("fanmap_tab_4").setClassName("");
    document.getElementById("fanmap_tab_5").setClassName("");

    document.getElementById(id).setClassName("selected");
    return;
  }

//--> 
</script>


