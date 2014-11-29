<?php
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;
$cat=mysql_escape_string($_GET['dir']);
if(!is_dir($staticvars['local_root'].'modules/iwfs/webpages/'.$cat)):
	echo 'invalid category selected IWFS (catedit)';
	exit;
endif;
$lang=isset($_GET['lang'])?$_GET['lang']:$staticvars['language']['main'];
if(isset($_POST['idioma'])):
	$idioma=isset($_POST['idioma'])?$_POST['idioma']:$lang;
else:
	$idioma=isset($_GET['idioma'])?$_GET['idioma']:$lang;
endif;

if(!is_dir($staticvars['local_root'].'modules/iwfs/webpages/'.$cat.'/'.$idioma)):
	echo 'Invalid Language Selection IWFS (catedit)';
	exit;
endif;
if(isset($_POST['save']) or (isset($_POST['gravar_novo']) and $_POST['gravar_novo']<>'') or (isset($_POST['gravar_detalhes']) and $_POST['gravar_detalhes']<>'') ):
	include($staticvars['local_root'].'modules/iwfs/update_db/web_management.php');
endif;
$tmp=true;
if (isset($_GET['file'])): 
	$file=$_GET['file'];
	if (file_exists($staticvars['local_root']."modules/iwfs/webpages/".$file)):
		$code=file_get_contents($staticvars['local_root']."modules/iwfs/webpages/".$file);
		include($staticvars['local_root'].'editor/editor.php');
	else:
		$tmp=false;
	endif;
else:
	$tmp=false;
endif;
if($tmp==false):
	?>
	<h3><img src="<?=$staticvars['site_path'].'/modules/iwfs';?>/images/editor.jpg" />Editar Categoria de P&aacute;gina Web  </h3>
	<br />
	<style>
	.equal {
		display:table;
		margin:0px auto;
		border-spacing:5px 5px 5px 5px;
		width:100%;
	}
	.row {
		display:table-row;
	}
	
	.row div {
		display:table-cell;
	}
	.row div.full{
		width:100%;
		border: 1px solid #FFCC00;
		background:#FFFFCC;
		padding:5px;
	}
	.row div.mleft{
		width:50%;
		border: 1px solid #FFCC00;
		background:#FFFFCC;
		padding:5px;
	}
	.row div.mright{
		width:50%;
		border: 1px solid #009900;
		background:#CCFF99;
		padding:5px;
	}
	.inside{
		padding: 10px 0px 0px 30px;
	}
	</style>
	<script language="JavaScript" type="text/javascript">
	function update_fields ( form, title, file )
	{
	form.nome.value=file;
	form.titulo.value=title;
	form.nome.focus();
	  }
	
	</script>
	<div class="equal">
		<div class="row">
			<div class="mleft">
			<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data" name="cat_edit" class="form">
			<h4>Nome da categoria:&nbsp;<?=$cat;?></h4>
			<div class="inside">
			  Apagar categoria?&nbsp;
			  <input type="submit" value="Apagar" class="button" name="del_cat">
			</div>
			</form>
			</div>
			<div class="mright">
			<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data" name="file_edit" class="form">
			<h4>Ficheiros existentes no idioma [<?=$idioma;?>]:</h4><br>
			<div class="inside">
			<?php
				$tmp=glob($staticvars['local_root'].'modules/iwfs/webpages/'.$cat.'/'.$idioma."/*.php");
				$file_in_dir='';
				if (isset($tmp[0])):
					$file_in_dir=$tmp;
				endif;						
				$tmp=glob($staticvars['local_root'].'modules/iwfs/webpages/'.$cat.'/'.$idioma."/*.htm");
				if (isset($tmp[0])):
					if ($file_in_dir==''):
						$file_in_dir=$tmp;
					else:
						$file_in_dir=array_merge($file_in_dir,$tmp);
					endif;
				endif;						
				$tmp=glob($staticvars['local_root'].'modules/iwfs/webpages/'.$cat.'/'.$idioma."/*.html");
				if (isset($tmp[0])):
					if ($file_in_dir==''):
						$file_in_dir=$tmp;
					else:
						$file_in_dir=array_merge($file_in_dir,$tmp);
					endif;
				endif;						
				if (isset($file_in_dir[0])):
					for($k=0;$k<count($file_in_dir);$k++):
						$fileX=explode("/",$file_in_dir[$k]);
						$title=$fileX[count($fileX)-1];
						$filename=$title;
						$java_file=explode(".",$title);
						$java_file=$java_file[0];
						$java_title='';
						$title=file_get_contents($file_in_dir[$k]);
						if (preg_match("/<!--/", $title)):
							$init=strpos($title,"!--")+3;
							$final=strpos($title,"--",$init);
							$title=substr($title,$init,$final-init-4);
							$java_title=str_replace("\r\n","",$title);
							$java_title=str_replace(chr(13),"",$title);
							$java_title=str_replace(" ",".",$title);
							$java_title= $title[0]==' ' ? substr($title,1,strlen($title)):$title;
						else:
							$fileX=explode("/",$file_in_dir[$k]);
							$title=$fileX[count($fileX)-1];
						endif;
						echo "<input type='checkbox' name='".$java_file."' class='button'>&nbsp;<a href='#nolink' onClick='update_fields(document.form_detalhes,\"".$java_title."\",\"".$java_file."\")' >".$title."</a>&nbsp;[<a href='".strip_address('see',strip_address('idioma',$_SERVER['REQUEST_URI']))."&idioma=".$idioma."&see=".$java_file."'>ver</a>]<br>";
					endfor;
					$j=$j+count($file_in_dir);
				endif;
			
			?>
			</div>
			<br><br>
			  Apagar p&aacute;ginas seleccionadas?&nbsp;<input type="submit" value="Apagar" class="button" name="del_pages">
			  <br> Novo Ficheiro:<br>
			 <div class="inside">
				<input name="novo_nome" type="text" class="text" size="10" maxlength="8">.php&nbsp;<input type="submit" value="Gravar" name="gravar_novo" class="button">
			</div><br>
				<a name="nolink" id="nolink"></a>	
			  Mudar idioma:<select name="idioma" style="height:20px" size="1" class="text">
				<option value="pt" <?php if ($idioma=='pt'){?>selected<?php } ?>>Português</option>
				<option value="en" <?php if ($idioma=='en'){?>selected<?php } ?>>English</option>
				<option value="es" <?php if ($idioma=='es'){?>selected<?php } ?>>Espanol</option>
				<option value="fr" <?php if ($idioma=='fr'){?>selected<?php } ?>>Français</option>
				</select>&nbsp;<input type="submit" value="Mudar" name="muda_idioma" class="button">
				<input type="hidden" name="categoria" value="<?=$cat;?>">
			</form>        
			</div>
		</div>
	</div>
	<div class="equal">
		<div class="row">
			<div class="full">
			<h4>Detalhes do ficheiro</h4>
			<div class="inside">
			<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data" name="form_detalhes" class="form">
			Nome:&nbsp;<input name="nome" type="text" class="text" size="10" maxlength="8">.php<br><br>
			Título:&nbsp;<input name="titulo" type="text" class="text" size="50" maxlength="150">&nbsp;<input name="gravar_detalhes" type="submit" class="button" value="Gravar">
			<input type="hidden" name="idioma" value="<?=$idioma;?>">
			<input type="hidden" name="categoria" value="<?=$cat;?>">
			</form>
			</div>
			</div>
		 </div>
	</div>
	<?php
	if (isset($_GET['see'])):
		if(is_file($staticvars['local_root'].'modules/iwfs/webpages/'.$_GET['dir'].'/'.$_GET['idioma'].'/'.$_GET['see'].'.php')):
			?>
			<div class="equal">
				<div class="row">
					<div class="full">
			<form action="<?=strip_address("file",strip_address("type",$_SERVER['REQUEST_URI'])).'&type=iwfs&file='.$cat.'/'.$idioma.'/'.$_GET['see'].'.php';?>" method="post" enctype="multipart/form-data" name="form_view" class="form">
					<h4>Conteúdo:</h4><input name="editar" type="submit" class="button" value="Editar">
			</form>
					<?php
					include($staticvars['local_root'].'modules/iwfs/webpages/'.$_GET['dir'].'/'.$_GET['idioma'].'/'.$_GET['see'].'.php');
					?>
					</div>
				 </div>
			</div>
			<?php
		endif;
	endif;
endif;
?>