<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

if (isset($_POST['del_cat'])): // apagar 
	$cat=mysql_escape_string($_POST['cat']);
	$ex=$db->getquery("select cod_category, nome, folder from congress_category where nome='".mysql_escape_string($_POST['nome'])."'");
	if($ex[0][0]<>''):// apagar categoria
		include($staticvars['local_root'].'general/recursive_copy.php');
		 delr($staticvars['local_root'].'modules/congressos/contents/'.$ex[0][2]);
		 @rmdir($staticvars['local_root'].'modules/congressos/contents/'.$ex[0][2]);
		 $db->setquery("delete from congress_category where cod_category='".$ex[0][0]."'");
		$db->setquery("delete from congress_category where cod_category='".$cat."'");
		$db->setquery("delete from congress_menu where cod_category='".$cat."'");
		$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Categoria apagada</font></font>';
	endif;
elseif (isset($_POST['edit_cat']))://editar
		$cat=mysql_escape_string($_POST['cat']);
		$db->setquery("update congress_category set translations='".mysql_escape_string($_POST['translations'])."',
		nome='".mysql_escape_string($_POST['nome'])."' where cod_category='".$cat."'");
		$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Categoria editada com sucesso</font></font>';
elseif (isset($_POST['insert_cat']))://adicionar
	$ex=$db->getquery("select cod_category, nome, folder from congress_category where nome='".mysql_escape_string($_POST['nome'])."'");
	if($ex[0][0]<>''):// apagar categoria
		include($staticvars['local_root'].'general/recursive_copy.php');
		 delr($staticvars['local_root'].'modules/congressos/contents/'.$ex[0][2]);
		 @rmdir($staticvars['local_root'].'modules/congressos/contents/'.$ex[0][2]);
		 $db->setquery("delete from congress_category where cod_category='".$ex[0][0]."'");
	endif;
	if (!is_dir($staticvars['local_root'].'modules/congressos/contents')):
		@mkdir($staticvars['local_root'].'modules/congressos/contents');
	endif;
	$folder=str_replace(" ","",normalize_chars(mysql_escape_string($_POST['nome'])));
	$len= strlen($folder)>10 ? 10 : strlen($folder);
	$folder=substr($folder,0,$len);
	if (is_dir($staticvars['local_root'].'modules/congressos/contents/'.$folder)):
		$folder.= rand(1,1000);
		@mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder);
	else:
		@mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder);	
	endif;

	$db->setquery("insert into congress_category set translations='".mysql_escape_string($_POST['translations'])."',
		   nome='".mysql_escape_string($_POST['nome'])."', priority='3000', folder='".$folder."'");

	$lang=explode(";",$staticvars['language']['available']);
	$admin=return_id('ap_main.php');
	$main=return_id('congress_main.php');
	$ex=$db->getquery("select cod_category from congress_category where nome='".mysql_escape_string($_POST['nome'])."'");
	for($i=0;$i<count($lang);$i++):
		$link=session($staticvars,$staticvars['site_path'].'/index.php?id='.$admin.'&load=categories.php&cat='.$ex[0][0].'&goto='.$main);
		mkdir($staticvars['local_root'].'modules/congressos/contents/'.$folder.'/'.$lang[$i]);		
		$filename=$staticvars['local_root'].'modules/congressos/contents/'.$folder.'/'.$lang[$i].'/main.php';
		$file_content="<!-- ".mysql_escape_string($_POST['nome'])." -->".chr(13)."<h2>".mysql_escape_string($_POST['nome'])."</h2>
		<?php
		if(isset("."$"."_GET['lang'])):
			"."$"."lang="."$"."_GET['lang'];
		else:
			"."$"."lang="."$"."staticvars['language']['main'];
		endif;
		include("."$"."staticvars['local_root'].'modules/congressos/contents_extended/default/'."."$"."lang.'/edit_contents.php');
		?>
		";
		if (!$handle = fopen($filename, 'a')):
			$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Cannot open file ('.$filename.')</font></font>';
		endif;
		if (fwrite($handle, $file_content) === FALSE):
			$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Cannot write file ('.$filename.')</font></font>';
		endif;
		fclose($handle);
	endfor;
	
	$_SESSION['status']='<font class="body_text"> <font color="#FF0000">Categoria adicionada</font></font>';
endif;
?>