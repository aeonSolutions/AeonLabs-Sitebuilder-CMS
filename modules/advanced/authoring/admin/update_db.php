<?php
$task=@$_GET['id'];
$type=@$_GET['type'];
$sid=*$_GET['SID'];
include('../../kernel/staticvars.php');
@include_once('../../kernel/functions.php');
if ($type==1): // edit / activate / delete skin
	if (isset($_POST['skin_active']) and isset($_POST['skin_dropdown']) and $_POST['skin_dropdown']<>'none'):
		$query=$db->getquery("select cod_skin from skin where active='s'");
		$db->setquery("update skin set active='n' where cod_skin='".$query[0][0]."'");
		$db->setquery("update skin set active='s' where cod_skin='".mysql_escape_string($_POST['skin_dropdown'])."'");
	endif;
	if (isset($_POST['skin_inactive']) and isset($_POST['skin_dropdown']) and $_POST['skin_dropdown']<>'none'):
		$db->setquery("update skin set active='n' where cod_skin='".mysql_escape_string($_POST['skin_dropdown'])."'");
	endif;
	if (isset($_POST['skin_del']) and isset($_POST['skin_dropdown']) and $_POST['skin_dropdown']<>'none'):
		$query=$db->getquery("select ficheiro from skin where cod_skin='".mysql_escape_string($_POST['skin_dropdown'])."'");
		$pt=unlink($absolute_path.'/layout/skin/'.$query[0][0]);
		$db->setquery("delete from skin where cod_skin='".mysql_escape_string($_POST['skin_dropdown'])."'");
	endif;
	if (isset($_POST['skin_add']) and isset($_POST['skin_dropdown']) and $_POST['skin_dropdown']<>'none'):
		$db->setquery("update skin set ficheiro='".mysql_escape_string($_POST['skin_file_upload'])."',
		 default_cell='".mysql_escape_string($_POST['skin_default_cell'])."', num_cells='".mysql_escape_string($_POST['skin_num_cells'])."'
		  where cod_skin='".mysql_escape_string($_POST['skin_dropdown'])."'");
	endif;
	$type=1;
elseif ($type==2): // add skin
	if (isset($_FILES['skin_file_upload']) and isset($_POST['skin_send']) and isset($_POST['skin_num_cells']) and isset($_POST['skin_default_cell'])):
		if (stristr($_FILES['skin_file_upload']['type'],"application/octet-stream")):
			$location=$absolute_path.'/layout/skin/'.$_FILES['skin_file_upload']['name'];
			if (!move_uploaded_file($_FILES['skin_file_upload']['tmp_name'], $location)):
				?>
				<script language="javascript">
					window.alert("Erro no Upload. Por favor tente de novo.");
				</script>
				<?php
			endif;
			$db->setquery("insert into skin set active='n', default_cell='".mysql_escape_string($_POST['skin_default_cell'])."', ficheiro='".mysql_escape_string($_FILES['skin_file_upload']['name'])."',num_cells='".mysql_escape_string($_POST['skin_num_cells'])."'");
		else:
		?>
		<script language="javascript">
			window.alert("Apenas ficheiros skin");
		</script>
		<?php
		endif;
	endif;
endif;
?>
<script language="javascript">
 document.location.href="<?=session($staticvars,'../../index.php?id='.$task.'&type='.$type); ?>"
</script>
