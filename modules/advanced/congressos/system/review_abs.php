<?php
/*
File revision date: 09-set-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_POST['submit_revabs'])):
	include($staticvars['local_root'].'modules/congressos/update_db/reviews.php');
	session_write_close();
	sleep(1);
	header("Location: ".session($staticvars,'index.php?id='.return_id('congress_listings.php')));
endif;
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;

$cod=mysql_escape_string($_POST['abs_code']);
$prod=$db->getquery("select cod_abstract,cod_user, cod_theme, file, title, keywords, authors, abstract, data,idc, revised, revision_data from congress_abstracts where cod_abstract='".$cod."'");
$th=$db->getquery("select name, translations from congress_themes where cod_theme='".$prod[0][2]."'");
if($th[0][1]<>''):// there are translations
	$pipes=explode("||",$th[0][1]);
	$display_name='';
	for($l=0; $l<count($pipes);$l++):
		$names=explode("=",$pipes[$l]);
		if ($lang==$names[0]):
			$display_name=$names[1];
		endif;
	endfor;
	if ($display_name==''):
		$display_name=" - - ";
	endif;
else:
	$display_name=$th[0][0];
endif;
$theme=$display_name;
$title=$prod[0][4];
$authors=$prod[0][6];
$keywords=$prod[0][5];
$abstract=$prod[0][7];
$paper=$db->getquery("select file from congress_papers where cod_abstract='".$prod[0][0]."'");
if($paper[0][0]<>''):
	include($staticvars['local_root'].'kernel/initialize_download.php');
	$paper='<STRONG>'.$cl[3].': </STRONG>'.initialize_download('congress/papers/'.$paper[0][0]).'<br>';
else:
	$paper=$cl[4].' <a href="'.session($staticvars,'index.php?id='.return_id('abstract_submit.php')).'">'.$cl[5].'</a>';
endif;
$topic=$db->getquery("select reference, name, translations, cod_topic from congress_themes where cod_theme='".$prod[0][2]."'");
$idc=$topic[0][0].'-'.$prod[0][0];

?>
	<div align='right'>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/congressos/system/pdf.php?abs=<?=$prod[0][0];?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="PDF">
		<img src="<?=$staticvars['site_path'];?>/modules/congressos/images/pdf_button.png" alt="PDF" name="PDF" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/congressos/system/print.php?abs=<?=$prod[0][0];?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="Print">
		<img src="<?=$staticvars['site_path'];?>/modules/congressos/images/printButton.png" alt="Print" name="Print" align="middle" border="0"></a>
		<a href="" target="_blank" onclick="window.open('<?=$staticvars['site_path'];?>/modules/congressos/system/email.php?abs=<?=$prod[0][0];?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="E-mail">
		<img src="<?=$staticvars['site_path'];?>/modules/congressos/images/emailButton.png" alt="E-mail" name="E-mail" align="middle" border="0"></a>
	 </div>
<?php
echo '<div style="font-family:\'Times New Roman\', Times, serif;font-size:medium">';
echo '<div align="center"><h2>'.$title.'</h2>'.$cl[0].': '.$theme.'<br><font style="font-size:small">'.$authors.'</font></div>';
echo '</div>';
echo '<hr size="1"><div align="left" style="font-family:\'Times New Roman\', Times, serif"><strong>'.$cl[1].'</strong><br>'.$abstract.'<br><br><font style="font-size:small"><strong>'.$cl[2].':</strong>'.$keywords.'</font><hr size="1"><br /><h3>'.$cl[25].'</h3><blockquote>'.$cl[24].' <strong>'.$idc.'</strong><br />'.$revision.'</blockquote></div>';

?>
<script language="javascript">
function switch_aceitar()
{
  var cur_box = window.document.revabs.aceitar;
  var alter_box = window.document.revabs.recusar;
  var the_switch = "";
  if (cur_box.checked == false) {
		alter_box.checked=true;
  } else {
		alter_box.checked=false;
  }
}
function switch_recusar()
{
  var cur_box = window.document.revabs.aceitar;
  var alter_box = window.document.revabs.recusar;
  if (alter_box.checked == false) {
		cur_box.checked=true;
  } else {
		cur_box.checked=false;
  }
}
  function confirmAction() {
	return confirm("You cannot undo the review. Are you sure you want to continue ?")
  }   

</script>

<form class="form" name="revabs" method="post" action="">
<input type="hidden" name="abs_code" value="<?=$cod;?>">
  <p>
  <?=$re[0];?>
<br>
    <textarea class="text" style=" width:95%" name="obs" rows="8" id="obs"></textarea>
  </p>
  <p>
    <input class="text" type="checkbox" name="aceitar" onClick="switch_aceitar();" id="aceitar" checked>
  <?=$re[1];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  <input class="text" type="checkbox" name="recusar" onClick="switch_recusar();" id="recusar">
  <?=$re[2];?><br>
  <br>
  <div align="right"><input class="button" type="submit" onclick="return confirmAction()" name="submit_revabs" id="submit_revabs" value="<?=$re[3];?>"></div>
  </p>
</form>
