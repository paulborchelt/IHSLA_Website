<script type="text/javascript" src="../javascript/html_form_input_mask.js"></script>
<script type="text/javascript" src="prototype.js"></script>

<script type="text/javascript">
<!--
/*Multiple onload function created by: Simon Willison
http://simonwillison.net/2004/May/26/addLoadEvent/

*/
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

addLoadEvent(function() {
  Xaprb.InputMask.setupElementMasks();
});
//-->
</script>


<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <table>
        <tr>
            <td><?$calendar->writeScript()?></td>
            <td><textarea name="info" rows="5" cols="50"><?=$additionalcomments?></textarea></td>
            <input type="HIDDEN" name="action" value="EnterContactRecord">
            <input type="HIDDEN" name="idcontactinfo" value="<?=$contactid?>">
            <input type="submit" name="Submit" value="SUBMIT" >
        </tr>
        
    </table>
</form>