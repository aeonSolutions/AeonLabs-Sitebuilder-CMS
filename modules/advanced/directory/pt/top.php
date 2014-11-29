<?
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Default';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
@include_once('kernel/staticvars.php');
?>
		<div class="header_1">Arquivos</div>
		<?PHP top_items();?>
		  <div align="center"><font class="body_text"><?=count_items();?><br />
          <?=count_publish();?>
		  </font></div>
		

<?php
function count_publish(){
    include('kernel/staticvars.php');
    $query=$db->getquery("select COUNT(*) from items where active='?'");
	if ($query[0][0]<>'' and $query[0][0]<>0):
		return 'Mais '.$query[0][0].' para varar.';
	endif;
};

function count_items(){
    include('kernel/staticvars.php');
    $query=$db->getquery("select COUNT(*) from items where active='s'");
	if ($query[0][0]<>'' and $query[0][0]<>0):
		return 'Há '.$query[0][0].' ficheiros para download no directório';
	else:
		return 'Sem arquivos colocados até ao momento.';
	endif;
};

function top_items(){
    include('kernel/staticvars.php');
	$display_item_id=return_id('ds_files.php');
    $query=$db->getquery("select titulo,cod_item, downloads from items where active='s' order by downloads DESC");
	if ($query[0][0]<>''):
		if (count($query)<4):
			$conta=count($query);
		else:
			$conta=4;
		endif;
		echo '<div align="left">';
		for ($i=0;$i<$conta;$i++):
			$cr=substr($query[$i][0],0,27);
			$cr2=$cr."...";
			$link=session($staticvars,$staticvars['site_path'].'/index.php?id='.$display_item_id.'&cod='.$query[$i][1]);
			printf("&nbsp;&nbsp;<a href='%s' class='body_text'>&nbsp;%s</a><br>",$link,$cr2);
		endfor;
		printf("<BR></div>");
	endif;
};

?>