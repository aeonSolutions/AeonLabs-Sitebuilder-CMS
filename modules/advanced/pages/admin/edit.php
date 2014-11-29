<?php
/*
File revision date: 2-Ãgo-2008
*/
include($staticvars['local_root'].'kernel/staticvars.php');
$tmp=true;
if (isset($_GET['file'])): 
	if (file_exists($staticvars['local_root'].'modules/iwfs/webpages/'.$_GET['path'])):
		include($globvars['local_root'].'editor/editor.php');
	else:
		$tmp=false;
	endif;
else:
	$tmp=false;
endif;
if($tmp==false):
?>
<link rel="StyleSheet" href="<?=$staticvars['site_path'];?>/modules/iwfs/system/dtree.css" type="text/css" />
<script type="text/javascript">
var site_path='<?=$staticvars['site_path'];?>/'
</script>
<script type="text/javascript" src="<?=$staticvars['site_path'];?>/modules/iwfs/system/dtree.js"></script>
<h3><img src="<?=$staticvars['site_path'].'/modules/iwfs';?>/images/editor.jpg" />Editar P&aacute;ginas Web  </h3><br />
<table width="100%" border="0" cellPadding="15" cellSpacing="0">
<tr>
  <td>
	<div class="dtree">
		<p align="center">
		<a href="<?=session($staticvars,'index.php?id='.$_GET['id'].'&goto='.$_GET['goto'].'&load=add.php');?>" >Adicionar P&aacute;gina</a> | <a href="<?=session($staticvars,'index.php?id='.$_GET['id'].'&goto='.$_GET['goto'].'&load=add_cat.php');?>" >Adicionar Categoria</a></p>
		<font class="body_text">Seleccione uma p&aacute;gina na &aacute;rvore de p&aacute;ginas de modo a poder editar o seu conteúdo</font>
		<hr class="gradient">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr valign="top">
			<td>
			<div class="dtree"><a href="javascript: d.openAll();">Abrir conteúdos</a> | <a href="javascript: d.closeAll();">Fechar conteúdos</a></div>
			<script type="text/javascript">
				<!--
				<?php
				$dir=glob($staticvars['local_root']."modules/iwfs/webpages/*",GLOB_ONLYDIR);
				$j=1;
				if ($dir[0]<>''):
					echo "d = new dTree('d');";
					echo "d.add(0,-1,'P&aacute;ginas existentes no directório de p&aacute;ginas');";
					for($i=0; $i<count($dir);$i++):
						$dirX=explode("/",$dir[$i]);
						echo "d.add($j,0,'".$dirX[count($dirX)-1]."','".strip_address("load",$_SERVER['REQUEST_URI'])."&load=edit_cat.php&dir=".$dirX[count($dirX)-1]."');";
						$j++;
					endfor;
				else:
					echo 'document.write("n&atilde;o ha p&aacute;ginas no directorio!");';
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
