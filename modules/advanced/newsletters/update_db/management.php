<?php
if(isset($_POST['email']) or isset($_POST['cod_user'])):
	if (isset($_POST['cod_user'])):
		$query=', cod_user="'.mysql_escape_string($_POST['cod_user']).'"';
	else:
		$query=$db->getquery('select cod_user from users where email="'.mysql_escape_string($_POST['delete']).'"');
		if($query[0][0]<>''):
			$query=', cod_user="'.$query[0][0].'"';
		else:
			$query=', cod_user="0"';
		endif;
	endif;
	$db->setquery('insert into newsletters_users set email="'.mysql_escape_string($_POST['delete']).'"'.$query);
	echo '<font class="body_text"> <font color="#FF0000">Email adicionado</font></font>';
elseif(isset($_POST['delete'])):
	$db->setquery('delete from newsletters_users where email="'.mysql_escape_string($_POST['delete']).'"');
	echo '<font class="body_text"> <font color="#FF0000">Email apagado</font></font>';
endif;
?>