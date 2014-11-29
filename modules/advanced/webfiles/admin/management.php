<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if (isset ($_POST['addfile'])):
	if (isset($_FILES['ficheiro']) and $_FILES['ficheiro']['error']<>4):
		$location=$staticvars['upload'].'/webfiles/'.$_FILES['ficheiro']['name'];
		if (!move_uploaded_file($_FILES['ficheiro']['tmp_name'], $location)):
			$_SESSION['update']= 'Erro no Upload tente novamente';
		else:
			$_SESSION['update']= 'Ficheiro Gravado com sucesso';				
		endif;
	else:
		$_SESSION['update']= 'Erro no Upload tente novamente';
	endif;
	$address=strip_address("update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);
endif;
?>
<br />
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>WebFiles</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD width="36" vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/webfiles/images/panel.gif" alt="Colocar nota informativa"/><BR></TD>
      <TD vAlign=top><p>WebFiles s&atilde;o ficheiros que pode colocar na p&aacute;gina web via upload e depois utiliza-los atrav&eacute;s do link correspondente.</p>
        <p>&nbsp;</p></TD>
    </TR>
  </TBODY>
</TABLE>
<br />
<script language="javascript" type="text/javascript">
function display_link(name){
document.webfile_form.code.value='<a href="<?=$staticvars['upload_path'];?>/webfiles/'+ name +'" target="_blank">Descarregar ficheiro</a>'
}
</script>
<form class="form" action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data" name="webfile_form">
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <h4>Adicionar um ficheiro<br>
          <br>
          <input style=" width:98%" name="ficheiro" type="file" class="text" id="ficheiro">
          <br>
      </h4>
      <div align="right"><br>
        <input type="submit" class="button" name="addfile" id="addfile" value="Gravar Ficheiro">
      </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><h4><a name="fich"></a>C&oacute;digo html para aceder ao ficheiro<br>
        </h4>
      <div class="form">
          <textarea style=" width:98%" name="code" cols="100" rows="6" wrap="virtual" class="text" id="code"></textarea>
      </div>
        <br>
    </p>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><h4>Ficheiros existentes no direct&oacute;rio webfiles</h4></td>
  </tr>
  <tr>
    <td>
    <?php
	$dir_files = glob($staticvars['upload']."/webfiles/*.*");
	for($i=0; $i < count($dir_files); $i++):
		$fl=explode("/",$dir_files[$i]);
			echo '<img src="'.$staticvars['site_path'].'/modules/webfiles/images/check_mark.gif"  style="background:; padding:0px; border: solid 0px; margin:0px"  border="0">';
			echo '<a onclick="javascript:display_link(\''.$fl[count($fl)-1].'\');" href="#fich">'.$fl[count($fl)-1]. "</a>&nbsp;(". filesize($dir_files[$i]) . " bytes)<br>";
	endfor;
	?>
    </td>
  </tr>
</table>
   </form>

<?php
?>
