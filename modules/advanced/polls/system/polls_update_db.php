<?php
$type=@$_GET['type'];
include($staticvars['local_root'].'kernel/staticvars.php');
if ($type==1): // edit / activate / delete skin
	if (isset($_POST['polls_del']) and isset($_POST['polls_dropdown']) and $_POST['polls_dropdown']<>'none'):
		$db->setquery("delete from polls where cod_poll='".mysql_escape_string($_POST['polls_dropdown'])."'");
		$_SESSION['update']= 'Inquérito apagado';
	elseif (isset($_POST['polls_active']) and isset($_POST['polls_dropdown']) and $_POST['polls_dropdown']<>'none'):
		$query=$db->getquery("select cod_poll from polls where active='s'");
		$db->setquery("update polls set active='n' where cod_poll='".$query[0][0]."'");
		$db->setquery("update polls set active='s' where cod_poll='".mysql_escape_string($_POST['polls_dropdown'])."'");
		$_SESSION['update']= 'Inquérito activado';
	elseif (isset($_POST['polls_inactive']) and isset($_POST['polls_dropdown']) and $_POST['polls_dropdown']<>'none'):
		$db->setquery("update polls set active='n' where cod_poll='".mysql_escape_string($_POST['polls_dropdown'])."'");
		$_SESSION['update']= 'Inquérito desactivado';
	elseif (isset($_POST['polls_add']) and isset($_POST['polls_dropdown']) and $_POST['polls_dropdown']<>'none'):
		$st=$db->getquery("select name,questions, votes from polls where active='s'");
		$questions=explode(",",$_POST['polls_questions']);
		$votes='';
		for($i=0;$i<count($questions);$i++):
			$votes .='0:';
		endfor;
		$db->setquery("update polls set  questions='".mysql_escape_string($_POST['polls_questions'])."', name='".mysql_escape_string($_POST['polls_title'])."'
		  , votes='".$votes."' where cod_poll='".mysql_escape_string($_POST['polls_dropdown'])."'");
		$_SESSION['update']= 'Inquérito editado com sucesso';
	else:
		$_SESSION['update']= 'unk bug line 27';
	endif;
	$type=1;
elseif ($type==2): // add poll
	if ( isset($_POST['polls_send']) and isset($_POST['polls_questions']) and isset($_POST['polls_title']) and $_POST['polls_questions']<>'' and $_POST['polls_title']<>''):
			@session_start();
			$user=$db->getquery("select cod_user from users where nick='".mysql_escape_string($_SESSION['user'])."'");
			$st=$db->getquery("select name,questions, votes from polls where active='s'");
			$questions=explode(",",$_POST['polls_questions']);
			$votes='';
			for($i=0;$i<count($questions);$i++):
				$votes .='0:';
			endfor;
			$votes=substr($votes,0,-1);
			$db->setquery("insert into polls set active='n', cod_user='".$user[0][0]."', data=now(), name='".mysql_escape_string($_POST['polls_title'])."', questions='".mysql_escape_string($_POST['polls_questions'])."', votes='".$votes."'");
			$_SESSION['update']= 'Inquérito adicionado';
		else:
			$_SESSION['update']= 'Tem que preencher todos os campos.';
		endif;
endif;
?>
