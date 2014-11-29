<?php
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if (isset($_GET['id'])):
	$id='id='.$_GET['id'].'&';
else:
	$id='';
endif;
if ($cell<>-1):
	$link=session_setup($globvars,$globvars['site_path'].'/index.php?'.$id.'mod='.$cell.'&skin='.$skin);
	?>
	<div onClick="javascript:window.parent.location.href='<?=$link;?>';" style=" background-color:#FFFF99; width:95%; height:95%; padding:5px; cursor:hand; border: 1px dotted #000000; filter:alpha(opacity=50)" onMouseOver="this.filters.alpha.opacity=100" onMouseOut="this.filters.alpha.opacity=50">
	<?='<h4><img src="'.$globvars['site_path'].'/images/design.gif" />Editar C&eacute;lula '.$cell.' </h4>';?>
	</div>
	<?php
elseif ($cell==-1):
	?>
	<div style=" background-color:#FFFF99; width:95%; height:95%; padding:5px; cursor:hand; border: 1px dotted #000000; filter:alpha(opacity=50)" onMouseOver="this.filters.alpha.opacity=100" onMouseOut="this.filters.alpha.opacity=50">
		<?='<h4><img src="'.$globvars['site_path'].'/images/design.gif" />Menu</h4>';?></td>
	</div>
	<?php
endif;
?>