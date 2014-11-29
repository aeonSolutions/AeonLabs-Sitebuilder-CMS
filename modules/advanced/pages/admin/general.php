<?php
/*
File revision date: set-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;
$task=@$_GET['id'];
$cod_category=0;
if (isset($_POST['update'])):
	include($staticvars['local_root'].'kernel/staticvars.php');
endif;
include($staticvars['local_root'].'kernel/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$staticvars['language']['main'];
endif;
if (isset($_POST['gravar'])):
	load_text($staticvars);
elseif (isset($_POST['indexar'])):
	include($staticvars['local_root'].'modules/iwfs/system/functions.php');
	rebuild_id_file($staticvars);
	echo '<font class="body_text"> <font color="#FF0000">Success. File id settings Saved.</font></font><br />';
endif;
if (!file_exists($staticvars['local_root'].'modules/iwfs/system/settings.php')):
	$enable_mainpage=true;
	$cell_space=0;
else:
	include($staticvars['local_root'].'modules/iwfs/system/settings.php');
endif;

$address=$_SERVER['REQUEST_URI'];

if (is_file($staticvars['local_root'].'modules/iwfs/system/id_file.php')):
	include($staticvars['local_root'].'modules/iwfs/system/id_file.php');
endif;

?>
<img src="<?=$staticvars['site_path'].'/modules/iwfs';?>/images/icone_gestao.gif" /><font class="Header_text_4">Configura&ccedil;&atilde;o geral </font><br />
<br />
<form method="post" action="<?=$address;?>"  enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td colspan="2"><strong>MainPage</strong></td>
    </tr>
	<tr>
	  <td colspan="2"><font class="body_text">O modo mainpage permite que seja carregada uma p&aacute;gina por defeito quando n&atilde;o &eacute; especificada nenhuma p&aacute;gina.<br />
	      <br />
        Activar mainpage&nbsp;&nbsp;&nbsp;
	    <select size="1" name="mainpage" class="form_input" >
		<option value="true" <?php if ($enable_mainpage){?>selected="selected"<?php } ?>>Sim</option>
		<option value="false" <?php if (!$enable_mainpage){?>selected="selected"<?php } ?>>N&atilde;o</option>
	</select>&nbsp;&nbsp; 
	<br />
	<br />
	a p&aacute;gina ter&aacute; que se encontrar no direct&oacute;rio com o nome mainpage e o ficheiro principal ter&aacute; que ter o mesmo nome.</font></td>
	</tr>
	<tr>
	  <td height="15"></td>
    </tr>
	<tr>
	  <td height="15"><strong>CellSpacing</strong></td>
	</tr>
	<tr>
	  <td colspan="2" class="body_text">A op&ccedil;&atilde;o CellSpacing permir definir uma margem em pixeis &agrave; volta da p&aacute;gina a carregar.<br />
	    Caso pretenda controlar as margens manualmente. Introduza o valor 0.<br />
        <br />
	    CellSpacing 
	    <label>
	    <input name="cellspacing" type="text" id="cellspacing" value="<?=$cell_space;?>" size="5" maxlength="2" class="form" />
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">(max&iacute;mo recomendado 10)</font></label></td>
	</tr>
	<tr>
	  <td height="15"></td>
	</tr>
	<tr>
	  <td colspan="2" align="right"><input name="gravar" class="button" type="submit" value="Gravar" /></td>
	</tr>
	<tr>
	  <td height="15">&nbsp;</td>
	</tr>
	<tr>
	  <td colspan="2"><strong>Indexar as P&aacute;ginas</strong> </td>
	</tr>
	<tr>
	  <td height="15" class="body_text">Antes de poder utilizar as p&aacute;ginas ter&aacute; que criar o ficheiro de indices.</td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <td height="15"></td>
	</tr>
	<tr>
	  <td align="right" valign="bottom"><input name="indexar" class="button" type="submit" value="Indexar P&aacute;ginas" id="indexar" /></td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <td height="15"><strong>P&aacute;ginas Indexadas</strong></td>
    </tr>
	<tr>
	  <td height="15">Categoria:<br />
	<?php
	if(isset($file_id)):	
		for($i=0;$i<count($file_id);$i++):
			echo $file_id[$i].' --> did='.$i.'<br>';
		endfor;
	else:
		echo 'Por favor indexar as páginas primeiro';
	endif;
	?>
      </td>
	</tr>
  </table>
</form>
<?php	

function load_text($staticvars){

$file_content='
<?PHP
// CMS general config
$enable_mainpage='.$_POST['mainpage'].';
$cell_space='.$_POST['cellspacing'].';
?>';
$filename=$staticvars['local_root'].'modules/iwfs/system/settings.php';
if (file_exists($filename)):
	unlink($filename);
endif;
if (!$handle = fopen($filename, 'a')):
	echo '<font class="body_text"> <font color="#FF0000">Cannot open file ('.$filename.')</font></font>';
endif;
if (fwrite($handle, $file_content) === FALSE):
	echo '<font class="body_text"> <font color="#FF0000">Cannot write file ('.$filename.')</font></font>';
endif;
	echo '<font class="body_text"> <font color="#FF0000">Success. Settings Saved.</font></font><br />';

fclose($handle);
};

?>
