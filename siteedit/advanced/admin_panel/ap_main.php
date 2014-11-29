<?php
/*
File revision date: 25-set-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;

if(isset($_GET['id'])):
	$task=$_GET['id'];
else:
//erro
endif;
include($globvars['site']['directory'].'kernel/staticvars.php');
//users
$staticvars['users']['user_type']['admin']=1;// admin group code
$staticvars['users']['user_type']['guest']=2;//guest group code
$staticvars['users']['user_type']['default']=3;//default group code
$staticvars['users']['user_type']['auth']=4;// authenticated group code
$staticvars['users']['user_type']['cm']=5;// content management group code
$staticvars['users']['sid']=session_id();// session id
$staticvars['users']['is_auth']=true;// flag true when user auth occurs
$staticvars['users']['name']= isset($_SESSION['user']) ? $_SESSION['user'] : 'admin';// username
$staticvars['users']['code']=1;// db user code
$staticvars['users']['group']=1;// user group
$staticvars['users']['email']='webmaster@moradadigital.com';// user email

?>
<span style='font-size:14.0pt;color:#333333'><img src="<?=$staticvars['site_path'];?>/modules/admin_panel/images/icon.gif" width="37" height="34" align="absbottom" />Gestão Web</span>
<div align="right"><a href="<?=session($staticvars,'index.php?id='.$task);?>"><img border="0" title="go to previous" src="<?=$staticvars['site_path'].'/modules/admin_panel/images/back.png';?>" /></a></div>
<br />
<?php
if (isset($_GET['goto']) and isset($_GET['load'])):
	$goto=mysql_escape_string($_GET['goto']);
	$load=mysql_escape_string($_GET['load']);
	if ($load=='db_optimization.php' or $load=='db_bk.php'):
		include($globvars['local_root'].'modules/advanced/admin_panel/database/'.$load);
		?>
		<table width="100%" border="0" align="center">
		<tr>
        <td align="center"><br /><img src="<?=$globvars['site_path'];?>/advanced/modules/admin_panel/images/back.gif" width="16" height="16" border="0" /> <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task);?>">Voltar ao painel de administra&ccedil;&atilde;o</a></td>
        </tr>
        </table>
<?php
	elseif ($load=='language_presentation.php' and $staticvars['users']['user_type']['admin']==$staticvars['users']['group'] ):
		include($globvars['local_root'].'modules/advanced/admin_panel/language/'.$load);
		?>
		<table width="100%" border="0" align="center" >
		<tr>
        <td align="center"><br /><img src="<?=$globvars['site_path'];?>/modules/admin_panel/images/back.gif" width="16" height="16" border="0" /> <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task);?>">Voltar ao painel de administra&ccedil;&atilde;o</a></td>
        </tr>
        </table>
<?php
	else:
		?>
		<table width="100%" border="0" align="center" >
		<?php
		$is_valid=$db->getquery("select cod_module,link from module where cod_module='".$goto."'");
		if ($is_valid[0][0]<>''):
			$link=explode("/",$is_valid[0][1]);
			if(is_file($globvars['site']['directory'].'modules/'.$link[0].'/admin/authoring.php')):
				include($globvars['site']['directory'].'modules/'.$link[0].'/admin/authoring.php');
			else:
				$auth_type='Administrators';
			endif;
			if(is_file($globvars['site']['directory'].'modules/'.$link[0].'/admin/'.$load) ):
				?>
<tr>
				  <td>
                 <?php
				if (!include($globvars['site']['directory'].'modules/'.$link[0].'/admin/'.$load)):
				?>
				 </td>
				</tr>
				<tr>
				  <td>Erro ao incluir o ficheiro.</td>
				</tr>
				<?php
				endif;
				?>
				 </td>
				</tr>
				<tr>
                <td align="center"><br />
                  <img src="<?=$globvars['site_path'];?>/modules/admin_panel/images/back.gif" width="16" height="16" border="0" /> <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task);?>">Voltar ao painel de administra&ccedil;&atilde;o</a></td>
                </tr>
                <?php
			else:
				?>
				<tr>
				  <td>Ficheiro inv&aacute;lido.</td>
				</tr>
				<?php
			endif;
		else:
			?>
			<tr>
			  <td>Código de m&oacute;dulo inv&aacute;lido</td>
			</tr>
			<?php
		endif;
	endif;
		?>
</table>
<?php

else:
echo 'Para poder começar a utilizar a Gestão Web, recomenda-se que tenha à mão o manual de gestão de módulos.<br />Estes são os módulos que tem actualemnte instalados:<br /><br />';
	$dir=glob($globvars['site']['directory'].'/modules/*',GLOB_ONLYDIR);
	$query=$db->getquery('select link,cod_module from module');
	if ($dir[0]<>''):
		for($i=0; $i<count($dir); $i++):
			$dirX=explode("/",$dir[$i]);
			$install=true;
			for ($j=0; $j<count($query); $j++):
				$link=explode("/",$query[$j][0]);
				if ($link[0]==$dirX[count($dirX)-1]): // module found on DB	
					$install=false;
					break;
				endif;
			endfor;
			if (!$install):// module found
				if (is_dir($dir[$i].'/admin')):
					if(is_file($dir[$i].'/admin/authoring.php')):
						include($dir[$i].'/admin/authoring.php');
					else:
						$auth_type='Administrators';
					endif;
					if(is_file($dir[$i].'/admin/panel.php') and (($auth_type=='Administrators' and $staticvars['users']['user_type']['admin']==$staticvars['users']['group']) or ($auth_type=='Content Management' and ($staticvars['users']['user_type']['cm']==$staticvars['users']['group'] or $staticvars['users']['user_type']['admin']==$staticvars['users']['group'])))):
						$cod_module=$query[$j][1];
						include($dir[$i].'/admin/panel.php');
						echo '<hr size=1>';
					endif;
				endif;
			endif;
		endfor;
	else:
		echo "n&atilde;o ha modulos no directorio!";
	endif;
	include($globvars['local_root']."siteedit/advanced/admin_panel/panel.php");
endif;
?>
		