<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if((isset($_POST['gravar_novo']) and $_POST['gravar_novo']<>'') or (isset($_POST['gravar_detalhes']) and $_POST['gravar_detalhes']<>'') or isset($_POST['del_pages']) or isset($_POST['elm1'])):
	include($staticvars['local_root'].'modules/congressos/update_db/contents.php');
	session_write_close();
	sleep(1);
	header("Location: ".strip_address("cat",strip_address("idioma",strip_address("see",$_SERVER['REQUEST_URI']))));
endif;
if(isset($_POST['edit_cat']) or isset($_POST['insert_cat']) or isset($_POST['del_cat'])):
	include($staticvars['local_root'].'modules/congressos/update_db/categories.php');
	session_write_close();
	sleep(1);
	header("Location: ".strip_address("cat",$_SERVER['REQUEST_URI']));
endif;
if(isset($_SESSION['status'])):
	echo $_SESSION['status'];
	$_SESSION['status']=array();
	unset($_SESSION['status']);
endif;
include($staticvars['local_root'].'kernel/staticvars.php');
$tmp=true;
if (isset($_POST['editar_file'])):
	$cat=$db->getquery("select cod_category, nome, folder from congress_category where cod_category='".mysql_escape_string($_GET['cat'])."'");
	if($cat[0][0]<>''):
		if(is_file($staticvars['local_root'].'modules/congressos/contents/'.$cat[0][2].'/'.$_GET['idioma'].'/'.$_GET['see'].'.php')):
			$code=file_get_contents($staticvars['local_root'].'modules/congressos/contents/'.$cat[0][2].'/'.$_GET['idioma'].'/'.$_GET['see'].'.php');
			include($staticvars['local_root'].'editor/editor.php');
		else:
			$tmp=false;
		endif;
	else:
		$tmp=false;
	endif;
else:
	$tmp=false;
endif;
if($tmp==false):
?>
<h3><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/editor.gif" />Editar P&aacute;ginas Web  </h3><br />
<table width="100%" border="0" cellPadding="15" cellSpacing="0">
<tr>
  <td>
	<div class="dtree">
		<p align="center">
		<a href="<?=strip_address("cat",strip_address("idioma",strip_address("contents",strip_address("see",$_SERVER['REQUEST_URI']))));?>" >Adicionar Nova Categoria</a></p>
		<font class="body_text">Seleccione uma p&aacute;gina na &aacute;rvore de p&aacute;ginas de modo a poder editar o seu conteúdo</font>
		<hr class="gradient">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr valign="top">
			<td>
				<?php
				$cat=$db->getquery("select cod_category, nome from congress_category");
				if ($cat[0][0]<>''):
					echo '<ul id="navlist">';
					for($i=0; $i<count($cat);$i++):
						echo '<li class="cat-item"><a href="'.strip_address("load",$_SERVER['REQUEST_URI']).'&load=categories.php&cat='.$cat[$i][0].'"></li>'.$cat[$i][1].'</a>';
					endfor;
					echo '</ul></div>';
				else:
					echo "nao há categorias!";
				endif;
				?>
			</td>
			<td>
			<?php
			if(isset($_GET['cat'])):
				$cat=$db->getquery("select cod_category, nome, folder from congress_category where cod_category='".mysql_escape_string($_GET['cat'])."'");
				if($cat[0][0]<>''):
					if(isset($_GET['contents']) or isset($_POST['edit_contents'])):// edit contents
						include($staticvars['local_root'].'modules/congressos/admin/edit_contents.php');	
					else:
						include($staticvars['local_root'].'modules/congressos/admin/edit_category.php');
					endif;
				else:
					include($staticvars['local_root'].'modules/congressos/admin/edit_category.php');	
				endif;
			else:
				include($staticvars['local_root'].'modules/congressos/admin/edit_category.php');	
			endif;
			?></td>
		  </tr>
		</table>
		<hr class="gradient">
	</div>		  
  </td>
</tr>
</table>
<?php
endif;
?>
