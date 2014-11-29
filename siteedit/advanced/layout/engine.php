<?php
/*
File revision date: 15-Ago-2006
*/

function draw_header(){
$path=explode("/",$_SERVER['SCRIPT_NAME']);
$local=$_SERVER['DOCUMENT_ROOT'].'/'.$path[1];
?>
<table align="center">
  <tr>
    <td><img src="<?=$local.'/images/layout_header.gif';?>" width="550" height="50" border="0"></td>
  </tr>
</table>
<?php
};
?>