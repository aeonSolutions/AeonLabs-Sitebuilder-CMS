<?php 
include($globvars['site']['directory'].'kernel/staticvars.php');
if (isset($_POST['users_del_all'])):
	if (isset($_GET['uo'])):
		$to_do='&uo=true';					
		$data_year=date('Y');
		$data_month=date('m');
		$data_day=date('d');
		$data_hour=date('His');
		$data_month=$data_month-6;
		if ($data_month<0):
			$data_month=12+$data_month;
			$data_year=$data_year-1;
		endif;
		$query=$db->getquery("select data from users");
		if (strpos("-".$query[0][0]," ")):
			$data=$data_year.'-'.$data_month.'-'.$data_day;
		else:
			$data=$data_year.$data_month.$data_day;
		endif;
		$query=$db->getquery("select cod_user from users where data<'".$data."'");
		if ($query[0][0]<>''):
			for($i=0;$i<count($query);$i++):
				$db->setquery("delete from users where cod_user='".$query[$i][0]."'");
				$db->setquery("delete from sessions where cod_user='".$query[$i][0]."'");
			endfor;
			echo '<font class="body_text"> <font color="#FF0000"><strong>TODOS</strong>os utilizadores inactvos foram apagados</font></font>';
		endif;
	elseif(isset($_GET['ui'])):
		$query=$db->getquery("select cod_user from users where active='n'");
		if ($query[0][0]<>''):
			for($i=0;$i<count($query);$i++):
				$db->setquery("delete from users where cod_user='".$query[$i][0]."'");
				$db->setquery("delete from sessions where cod_user='".$query[$i][0]."'");
			endfor;
			echo '<font class="body_text"> <font color="#FF0000"><strong>TODOS</strong>os utilizadores inactvos foram apagados</font></font>';
		endif;
	endif;
endif;
if (isset($_POST['users_del'])):
	$nick=$db->getquery("select nick from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$db->setquery("delete from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$db->setquery("delete from sessions where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	echo '<font class="body_text"> <font color="#FF0000">O utilizador,<strong>'.$nick[0][0].', </strong>foi apagado</font></font>';
endif;
if (isset($_POST['users_activar'])):
	$nick=$db->getquery("select nick from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$db->setquery("update users set active='s' where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	echo '<font class="body_text"> <font color="#FF0000">O utilizador,<strong>'.$nick[0][0].', </strong>foi activado</font></font>';
endif;
if (isset($_POST['users_desactivar'])):
	$nick=$db->getquery("select nick from users where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	$db->setquery("update users set active='n' where cod_user='".mysql_escape_string($_POST['cod_user'])."'");
	echo '<font class="body_text"> <font color="#FF0000">O utilizador,<strong>'.$nick[0][0].', </strong>foi desactivado</font></font>';
endif;
if (isset($_POST['users_edit']) or isset($_POST['users_email'])):
	$_SESSION['cod_user']=$_POST['cod_user'];
	if (isset($_POST['users_edit'])):
		$_SESSION['users_edit']=$_POST['cod_user'];
	else:
		$_SESSION['users_email']=$_POST['cod_user'];
	endif;
	include($globvars['local_root'].'siteedit/advanced/user_management/edit.php');
else:
	$task=@$_GET['id'];
	$skin=@$_GET['css'];
	$alfa=@$_GET['alfa'];
	if ($alfa==''):
		$alfa='none';
	endif;
	if (isset($_GET['nav'])):
		$nav=$_GET['nav'];
	else:
		$nav='default';
	endif;
	$delta=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$sr='';
	for ($i=0;$i<count($delta);$i++):
			$tmp=$delta[$i];
		if ($i==$alfa):
			$tmp='<b>'.$delta[$i].'</b>';
		endif;
			$sr .= '<a href="'.session_setup($globvars,'index.php?nav='.$nav.'&id='.$task.'&alfa='.$i).'">'.$tmp.'</a>&nbsp;&nbsp;';
	endfor;
	?>
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td height="25" colspan="3" valign="bottom"></td>
		</tr>
		<tr>
				<td>
				  <FORM name="form_users" action="<?=session_setup($globvars,'index.php?alfa=-1&nav='.$nav.'&id='.$task);?>" method="post" encType="multipart/form-data">
				  <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
					<TBODY>
					  <TR>
						<TD align="left" class="form_title">&nbsp;&nbsp;&nbsp;Procurar utilizador:</TD>
					  </TR>
					  <TR>
						<TD align="left"><INPUT class="form_input" maxLength="25" size="60" name="search_query">&nbsp;&nbsp;
						<INPUT class="form_submit" type="submit" value="Procurar" name="search_user"></TD>
					  </TR>
					  <TR>
						<TD align="left" height="5"></TD>
					  </TR>
					  <tr>
						<TD align="center"><INPUT class="form_submit" type="submit" value="Utilizadores Desactivados" name="users_inactive">
						&nbsp;&nbsp;
						<INPUT class="form_submit" type="submit" value="Utilizadores sem acesso &agrave; 6 meses" name="users_old"></TD>
					  </TR>
					  <TR>
					   <TD align="left">&nbsp;</td> 
					 </TR>
				</TBODY>
				</TABLE>
				</FORM>
			</tr>
			  <tr>
				<td class="Body_text" align="center">
				  <FORM name="form_users" action="<?=session_setup($globvars,'index.php?nav='.$nav.'&id='.$task);?>" method="post" encType="multipart/form-data">
				  <TABLE cellSpacing=0 cellPadding=0 width="100%" align=center border=0>
					<TBODY>
					  <TR>
						<TD align="center" class="body_text"><?=$sr;?></TD>
					  </TR>
					</TBODY>
				   </TABLE>
				  </FORM>
				</td>
			 </tr>
			 <tr>
			   <td>
				<?php
				if ($alfa<>'none'):
					if ( (isset($_POST['search_query']) and $_POST['search_query']<>'') or (isset($_GET['search']) and $_GET['search']<>'')):
						if (isset($_POST['search_query']) and $_POST['search_query']<>''):
							$query=finder($_POST['search_query'],$local_root);
							$to_do='&search='.$_POST['search_query'];
						else:
							$query=finder($_GET['search'],$local_root);
							$to_do='&search='.$_GET['search'];
						endif;
					elseif (isset($_POST['users_inactive'])or isset($_GET['ui'])):
						$query=$db->getquery("select nome, email, nick, data, active, cod_user from users where active='n'");
							$to_do='&ui=true';
					elseif (isset($_POST['users_old'])or isset($_GET['uo'])):
						$to_do='&uo=true';					
						$data_year=date('Y');
						$data_month=date('m');
						$data_day=date('d');
						$data_hour=date('His');
						$data_month=$data_month-6;
						if ($data_month<0):
							$data_month=12+$data_month;
							$data_year=$data_year-1;
						endif;
						$query=$db->getquery("select data from users");
						if (strpos("-".$query[0][0]," ")):
							$data=$data_year.'-'.$data_month.'-'.$data_day;
						else:
							$data=$data_year.$data_month.$data_day;
						endif;
						
						$query=$db->getquery("select nome, email, nick, data, active, cod_user from users where data<'".$data."'");
					else:
						$query=$db->getquery("select nome, email, nick, data, active, cod_user from users where nick like '".chr(65+$alfa)."%' or nick like '".chr(97+$alfa)."%'");
						$to_do='';
					endif;
					if ($query[0][0]<>''):
						echo '<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">';
						echo '<tr height="15"><td colspan="2">';
						echo '</td></tr>';
						$total=count($query)-1;
						$lower=@$_GET['lower'];
						$upper=@$_GET['upper'];
						if ($lower==''):
							$lower=0;
						endif;
						if ($upper==''):
							$upper=15;
						endif;
						if ($upper > $total):
							$upper=$total;
						endif;
						put_previous_next_page($lower,$upper,$total,session_setup($globvars,'index.php?alfa='.$alfa.'&nav='.$nav.'&id='.$task));
						for ($i=$lower;$i<=$upper;$i++):
							echo'<form name="add_user" enctype="multipart/form-data" action="'.session_setup($globvars,'index.php?alfa='.$alfa.'&nav='.$nav.'&id='.$task.$to_do).'" method="post">';
							echo '<tr><td>';
							if ($query[$i][4]=='s'):
								$tmp='Activo';
								$tmp2='desactivar';
							elseif ($query[$i][4]=='n'):
								$tmp='Inactivo';
								$tmp2='activar';
							elseif ($query[$i][4]=='?'):
								$tmp='Por Activar';
								$tmp2='activar';
							elseif ($query[$i][4]=='d'):
								$tmp='Desactivado (+6meses)';
								$tmp2='activar';
							endif;
							$last_date=$db->getquery("select data from sessions where cod_user='".$query[$i][5]."'");
							if ($last_date[0][0]<>''):
								$last_date=$last_date[0][0];
							else:
								$last_date='Never logged in';
							endif;
							echo '<div align="left"><font class="body_text">&nbsp;&nbsp;Nick: <b>'.$query[$i][2].'</b>&nbsp;( '.$query[$i][0].' )<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email: '.$query[$i][1].'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado: '.$tmp.'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Último Login: '.$last_date.'</font></div>';
							echo'</td></tr><tr><td>';
							echo '<div align="right"><input class="form_submit" name="users_edit" type="submit" value=" Editar ">&nbsp;&nbsp;<input type="hidden" name="cod_user" value="'.$query[$i][5].'"><input class="form_submit" name="users_'.$tmp2.'" type="submit" value=" '.$tmp2.' ">&nbsp;&nbsp;<input class="form_submit" name="users_email" type="submit" value=" Email ">&nbsp;&nbsp;<input class="form_submit" name="users_del" type="submit" value=" Apagar "></div>';
							echo '</td></tr>';
							echo '<tr height="1"><td colspan="2"><hr size="1">';
							echo '</td></tr></form>';
						endfor;
						echo '<tr height="15"><td colspan="2">';
						echo '</td></tr></table>';
						put_previous_next_page($lower,$upper,$total,session_setup($globvars,'index.php?alfa='.$alfa.'&nav='.$nav.'&id='.$task));
						echo'<form name="add_user" enctype="multipart/form-data" action="'.session_setup($globvars,'index.php?alfa='.$alfa.'&nav='.$nav.'&id='.$task.$to_do).'" method="post">';
						echo '<div align="right"><input class="form_submit" name="users_del_all" type="submit" value=" Apagar Todos ">';
						echo '</form>';
					else:
						if (isset($_POST['search_query']) and $_POST['search_query']<>''):
							echo 'n&atilde;o existem utilizadores para a pesquisa: '.$_POST['search_query'];	
						else:
							echo 'n&atilde;o existem utilizadores em '.chr(65+$alfa);	
						endif;
				 endif; //query not empty
			endif;// alfa<>none
		 ?>
			   </td>
			 </tr>
			  <tr>
				<td height="25" colspan="3" valign="bottom"></td>
			  </tr>
	</table>
<?
endif;

function put_previous_next_page($lower,$upper,$total,$link){
if ($lower==0 )
  	$p_antes='<font class="body_text" ><font color="#999999">P&aacute;g. Anterior</font></font>';

if ($lower<>0)
{
  	$lower_a=$lower-4;
  	if ($lower_a<0)
			$lower_a=0;
	$upper_a=$upper-4;
	if ($upper_a<0)
			$upper_a=$upper-$upper_a;
	if ($upper_a==0 && $lower_a==0)
			$upper_a=4;
  	$p_antes='<font class="body_text"><a href="'.$link.'&lower='.$lower_a.'&upper='.$upper_a.'"><font color="#000000">P&aacute;g. Anterior</font></a></font>';
}//else

if ($upper==$total )
	  $p_depois='<font class="body_text" ><font color="#999999">P&aacute;g. seguinte</font></font>';
if ($upper<>$total)
	{
		$lower_d=$lower+4;
		$upper_d=$upper+4;
		if ($upper_d>$total)
			$upper_d=$total;
		$p_depois='<font class="body_text"><a href="'.$link.'&lower='.$lower_d.'&upper='.$upper_d.'"><font color="#000000">P&aacute;g. seguinte</font></a></font>';
	}

echo '<div align="right">'.$p_antes.'<font class="body_text" color="#000000"> | </font>'.$p_depois.'</div>';
};

function finder($text_to_find,$local_root){
/* This function returns a matrix of the matches found:

"select nome, email, nick, data, active, cod_user from users...

*/
include ($local_root.'general/staticvars.php');
$order[0][0]='';
$t=0;
$fields='nick, email, nome ';
$res=$db->getquery("select nome,email,nick,data,active,cod_user from users ");
if ($res[0][0]<>''):
	for($k=0;$k<count($res);$k++): // for each query entry
			$j=0;
			while($j<=2): // for each field table until the first find
				$isit='';
				$isit=@strpos('- '.normalize($res[$k][$j]).' -',normalize($text_to_find));
				if ($isit <> '' ): // string match not found
					$order[$t]=$res[$k];
					$t++;
					$j=100;
				endif;
				$j++;
			endwhile;
	endfor;
endif;

return $order;
};


function normalize($text){
// eliminates special characters and convert to lower case a text string
	$dim=array("&ccedil;","&ccedil;");
	$text = str_replace($dim, "c", $text);

	$dim=array("&atilde;","&aacute;","à","â","&atilde;","&aacute;","À","Â");
	$text = str_replace($dim, "a", $text);

	$dim=array("é","ê","Ê","É");
	$text = str_replace($dim, "e", $text);

	$dim=array("í","Í");
	$text = str_replace($dim, "i", $text);

	$dim=array("&otilde;","ó","ô","&otilde;","Ó","Ô");
	$text = str_replace($dim, "o", $text);

	$text=strtolower($text);
return $text;
};
?>

