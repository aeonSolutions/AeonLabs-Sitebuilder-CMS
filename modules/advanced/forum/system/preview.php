<?php 
include('../../../kernel/staticvars.php'); 
@include_once('../../../general/SID.php');
if ($static_css):
	$css[0][0]='normal.css';
else:
	if (isset($_SESSION['user'])):
		$tmp=$db->getquery("select cod_css, cod_skin from users where nick='".$_SESSION['user']."'");
		$css=$db->getquery("select ficheiro from css where cod_css='".$tmp[0][0]."'");
	else:
		$css=$db->getquery("select ficheiro from css where active='s'");
	endif;
endif;
echo '<link href="'.$staticvars['site_path'].'/layout/css/'.$css[0][0].'" rel="stylesheet" type="text/css">';
$sid=@$_GET['SID'];
if (isset($_GET['SID'])):
	session_id($_GET['SID']);
else:
	session_id('943f7a5dc10e0430c990937bb04426d8');
endif;
@session_start();
?>
<style type="text/css">
<!--
body {
	background-color: #dddddd;
}
</style>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" align="center" class="header_text_1">
		Prever T&oacute;pico
	</td>
  </tr>
	<tr>
		<td height="25" colspan="3"  valign="bottom"><div align="center"></div></td>
  </tr>
		  <tr>
		    <td width="20"  valign="bottom">&nbsp;
			</td>
		    <td  valign="bottom"><?php
			 put_preview();
			?></td>
		    <td width="20"  valign="bottom">&nbsp;</td>
		  </tr>
  <tr>
    <td height="20" colspan="3" >&nbsp;</td>
  </tr>
</table>
<?php

function put_preview(){
	$message=$_SESSION['message'];
	$subject=$_SESSION['subject'];
	$option=$_SESSION['option'];
	include('bbcode.php');
	$txt=load_txt($message);
	?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><font class="header_text_1"><?=$subject;?></font></td>
	  </tr>
	  <tr>
		<td>
		<?php
			$oldlocale = setlocale(LC_TIME, NULL); #save current locale
			setlocale(LC_TIME, 'pt_PT');
			echo '<font class="body_text">'.date ("l dS of F Y @ G:i").'</font>';
			setlocale(LC_TIME, $oldlocale);
		?>		</td>
	  </tr>
	  <tr>
		<td height="10"></td>
	  </tr>
	  <tr>
		<td><hr size="1"><br><?=$txt;?><br><hr size="1"></td>
	  </tr>
	  <tr>
	    <td height="15"></td>
      </tr>
	  <tr>
		<td height="30" align="center" valign="bottom"><font class="body_text"><a href="javascript:window.close();">Fechar Janela</a></font></td>
	  </tr>
	</table>	
	<?php
};
?>
