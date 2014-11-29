<?
$bar=@include('general/site_handler.php');
if (!$bar):
	// erro possible hack
	exit;
endif; 
$sid=@$_GET['SID'];
if (isset($_GET['SID'])):
	session_id($_GET['SID']);
else:
	session_id('943f7a5dc10e0430c990937bb04426d8');
endif;
@session_start();@session_start();
if (isset($_SESSION['user'])):
	if (!isset($_SESSION['horizontal'])):
		?>
		<table  width="200" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>
					<table border="0" class="main_module_table_body" cellpadding="0" cellspacing="0" width="200">
					  <tr>
						<td  colspan="4" >
							<table class="main_module_table_header" border="0" cellpadding="0" cellspacing="0" width="100%">
							  <tr>
								<td height="10" ><div align="center"><b>Estatísticas</b></div></td>
							  </tr>
							</table>
						</td>
					  </tr>
					  <tr>
						<td width="8" height="10" >
						</td>
						<td width="111" height="10" >
						  <div align="right"><font class="blue">Utilizadores :</font></div>
						</td>
						<td width="65" height="10" >
					 <?PHP echo all_users1();?>   </td>
						<td width="6" height="10" >
						</td>
					  </tr>
					  <tr>
						<td height="10" ></td>
						<td height="10" >
						<font class="blue">
						<div align="right">Último Utilizador:</div></font></td>
						<td height="10" >
						<?PHP echo " ".last_user1();?>
						</td>
						<td height="10"></td>
					  </tr>
					  <tr>
						<td width="8" height="10" rowspan="3">
						</td>
						<td  height="5">
						<font class="blue">
						<div align="right">Visitantes:</div></font></td>
						<td height="5">
						<?PHP echo " ".visitors1();?>
						</td>
						<td height="10" rowspan="3">
						</td>
					  </tr>
					</table>
			</td>
		  </tr>
		  <tr>
			<td height="15">&nbsp;</td>
		  </tr>
		</table>
	<?php
	else:
		unset($_SESSION['horizontal']);
	?>
		<style type="text/css">
		<!--
		.user_info {
			border-top-width: 1px;
			border-bottom-width: 1px;
			border-top-style: solid;
			border-right-style: none;
			border-bottom-style: solid;
			border-left-style: none;
			border-top-color: #000099;
			border-bottom-color: #000099;
			background-color: #6666CC;
		}
		-->
		</style>
		<table  width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td>
			<table width="100%" class="user_info">
				<tr>
				<td width="10"></td>
					<td height="20">
						<table width="100%" border="0">
							<tr>
								<td width="150">
								<font color="White" face="Arial" size="1">
								<?='Bem vindo '.$_SESSION['user'] ?>					
								</font>
								</td>
								<td>
								<font color="White" face="Arial" size="1">
								<? write_message(); ?>						
								</font>
								</td>
							</tr>
						</table>
					</td>
				<td width="10"></td>
				</tr>
			</table>
			</td>
		  </tr>
	</table>
	
	<?PHP 
	endif;
endif;

function write_message(){
$msg='';
$warning_pic='<div id="Layer1" style="position:absolute; width:30px; height:31px; z-index:1; left: 255px; top: 158px;"><img src="images/warning.gif" border="0"></div>';
@session_start();
if (isset($_SESSION['warning'])):
	$warning=$_SESSION['warning'];
	echo $warning_pic;
	$msg='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$_SESSION['warning'];
	$_SESSION['warning']=NULL;
	unset($_SESSION['warning']);
else:
	include('kernel/staticvars.php');
	$qwd=$db->getquery("select cod_user, cod_user_type from users where nick='".$_SESSION['user']."'");
	if ($qwd[0][1]=='3'):// user type student
		$qw=$db->getquery("select downloads from user_student where cod_user='".$qwd[0][0]."'");
		if ($qw[0][0]<>''):
			$down=10-$qw[0][0];
		else:
			$db->setquery("insert into user_student set curriculum='', universidade='',
			 contacto='', cod_user='".$qwd[0][0]."', downloads='0'");
			$down='10';
		endif;
		if ($down<=0):
			echo $warning_pic;
			$msg='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para poderes fazer downloads tens que adicionar um programa/trabalho no directório';
		else:
			$msg='Tens '.$down.' downloads antes de teres de adicionar um programa/trabalho no directório';
		endif;
	endif;
endif;
echo $msg;
};
?>