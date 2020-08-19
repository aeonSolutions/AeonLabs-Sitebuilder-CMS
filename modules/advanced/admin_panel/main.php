<?php
/*
File revision date: 12-jan-2009
*/

if ( !defined('ON_SiTe')):
	echo 'not for direct access';
	exit;
endif;

if (is_file($staticvars['local_root'].'modules/advanced/admin_panel/version.php')):
	include($staticvars['local_root'].'modules/advanced/admin_panel/version.php');
	$server_version=$module_version;
else:
	$server_version='0.0';
endif;

if (is_file($$staticvars['local_root'].'modules/admin_panel/version.php')):
	include($$staticvars['local_root'].'modules/admin_panel/version.php');
else:
	$module_version='0.0';
endif;


?>
<span style='font-size:14.0pt;color:#333333'><img src="<?=$staticvars['site_path'];?>/modules/admin_panel/images/icon.gif" width="37" height="34" align="absbottom" />Gestão Web<font style="font-size:10px; color:#666666;">(Ver. <?=$module_version;?> - latest:<?=$server_version;?> )</font></span><br />
<?php
if (isset($_GET['goto']) and isset($_GET['load'])):
	$goto=mysql_escape_string($_GET['goto']);
	$load=mysql_escape_string($_GET['load']);
	if ($load=='db_optimization.php' or $load=='db_bk.php'):
		include($staticvars['local_root'].'modules/admin_panel/database/'.$load);
		?>
		<table width="100%" border="0" align="center">
		<tr>
        <td align="center"><br /><img src="<?=$staticvars['site_path'];?>/modules/admin_panel/images/back.gif" width="16" height="16" border="0" /> <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task);?>">Voltar ao painel de administra&ccedil;&atilde;o</a></td>
        </tr>
        </table>
<?php
	elseif ($load=='language_presentation.php' and $staticvars['users']['user_type']['admin']==$staticvars['users']['group'] ):
		include($staticvars['local_root'].'modules/admin_panel/language/'.$load);
		?>
		<table width="100%" border="0" align="center" >
		<tr>
        <td align="center"><br /><img src="<?=$staticvars['site_path'];?>/modules/admin_panel/images/back.gif" width="16" height="16" border="0" /> <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task);?>">Voltar ao painel de administra&ccedil;&atilde;o</a></td>
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
			if(is_file($staticvars['local_root'].'modules/'.$link[0].'/admin/authoring.php')):
				include($staticvars['local_root'].'modules/'.$link[0].'/admin/authoring.php');
			else:
				$auth_type='Administrators';
			endif;
			if(is_file($staticvars['local_root'].'modules/'.$link[0].'/admin/'.$load) and (($auth_type=='Administrators' and $staticvars['users']['user_type']['admin']==$staticvars['users']['type']) or ($auth_type=='Content Management' and ($staticvars['users']['user_type']['cm']==$staticvars['users']['type'] or $staticvars['users']['user_type']['admin']==$staticvars['users']['type'])))):
				?>
<tr>
				  <td>
                 <?php
				if (!include($staticvars['local_root'].'modules/'.$link[0].'/admin/'.$load)):
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
                  <img src="<?=$staticvars['site_path'];?>/modules/admin_panel/images/back.gif" width="16" height="16" border="0" /> <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task);?>">Voltar ao painel de administra&ccedil;&atilde;o</a></td>
                </tr>
                <?php
			else:
				?>
				<tr>
				  <td>Ficheiro inv&aacute;lido.(apmain)</td>
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
	$dir=glob($staticvars['local_root'].'modules/*',GLOB_ONLYDIR);
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
					if(is_file($dir[$i].'/admin/panel.php') and (($auth_type=='Administrators' and $staticvars['users']['user_type']['admin']==$staticvars['users']['type']) or ($auth_type=='Content Management' and ($staticvars['users']['user_type']['cm']==$staticvars['users']['type'] or $staticvars['users']['user_type']['admin']==$staticvars['users']['type'])))):
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
	include($staticvars['local_root']."modules/admin_panel/panel.php");
endif;
?>
		