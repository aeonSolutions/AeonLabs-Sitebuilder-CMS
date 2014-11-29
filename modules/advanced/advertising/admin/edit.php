<?php
/*
File revision date: 2-Ãgo-2008
*/
include($staticvars['local_root'].'kernel/staticvars.php');
$tmp=true;
if (isset($_GET['file'])): 
	if (file_exists($staticvars['local_root'].'modules/advertising/formats/'.$_GET['file'])):
		$code=file_get_contents($staticvars['local_root']."modules/advertising/formats/".$_GET['file']);
		?>
        <form action="" method="get">
        <textarea name="code" cols="50" rows="15"><?=$code;?></textarea><br />
        <input name="submit" type="button" value="Gravar" />&nbsp;<input name="apagar" type="button" value="Apagar" /></form>
        <?php
	else:
		$tmp=false;
	endif;
else:
	$tmp=false;
endif;
if($tmp==false):
?>
<link rel="StyleSheet" href="<?=$staticvars['site_path'];?>/modules/advertising/system/dtree.css" type="text/css" />
<script type="text/javascript">
var site_path='<?=$staticvars['site_path'];?>/'
</script>
<script type="text/javascript" src="<?=$staticvars['site_path'];?>/modules/advertising/system/dtree.js"></script>
  <h3><img src="<?=$staticvars['site_path'].'/modules/advertising';?>/images/editor.jpg" />Editar
  Cont&uacute;dos publicit&aacute;rios  </h3><br />
<table width="100%" border="0" cellPadding="15" cellSpacing="0">
<tr>
  <td>
	<div class="dtree">
		<p align="center">
		<a href="<?=session($staticvars,'index.php?id='.$_GET['id'].'&goto='.$_GET['goto'].'&load=add_cat.php');?>" >Adicionar formato </a>
		</p>
		<font class="body_text">Seleccione uma p&aacute;gina na &aacute;rvore de p&aacute;ginas de modo a poder editar o seu conteúdo</font>
		<hr class="gradient">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr valign="top">
			<td>
			<div class="dtree"><a href="javascript: d.openAll();">Abrir conteúdos</a> | <a href="javascript: d.closeAll();">Fechar conteúdos</a></div>
			<script type="text/javascript">
				<!--
				<?php
				$dir=glob($staticvars['local_root']."modules/advertising/formats/*",GLOB_ONLYDIR);
				$j=1;
				if ($dir[0]<>''):
					echo "d = new dTree('d');";
					echo "d.add(0,-1,'Formatos existentes');";
					for($i=0; $i<count($dir);$i++):
						$dirX=explode("/",$dir[$i]);
						echo "d.add($j,0,'".$dirX[count($dirX)-1]."','');";
						$j++;
						$tmp=glob($dir[$i]."/*.php");
						$file_in_dir='';
						if (isset($tmp[0])):
							$file_in_dir=$tmp;
						endif;						
						$tmp=glob($dir[$i]."/*.htm");
						if (isset($tmp[0])):
							if ($file_in_dir==''):
								$file_in_dir=$tmp;
							else:
								$file_in_dir=array_merge($file_in_dir,$tmp);
							endif;
						endif;						
						$tmp=glob($dir[$i]."/*.html");
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
								$path=$dirX[count($fileX)-2]."/".$fileX[count($fileX)-1];
								echo "d.add($j+$k,$j-1,'".$fileX[count($fileX)-1]."','".$_SERVER['REQUEST_URI'].'&type=advertising&file='.$path."','','');";
							endfor;
							$j=$j+count($file_in_dir);
						endif;
					endfor;
				else:
					echo 'document.write("n&atilde;o ha formatos no directorio!");';
				endif;
				?>
		
				document.write(d);
				//-->
			</script>
			</td>
			<td></td>
		  </tr>
		</table>
		<hr class="gradient">
		<font class="body_text">Seleccione uma p&aacute;gina na &aacute;rvore de p&aacute;ginas de modo a poder editar o seu conteúdo</font>
	</div>		  
  </td>
</tr>
</table>
<?php
endif;
?>
