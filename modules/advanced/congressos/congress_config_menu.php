<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_POST['save_menu']) or isset($_POST['del_menu']) or isset($_POST['edit_menu']) or isset($_GET['pos'])):
		include($staticvars['local_root'].'modules/congressos/update_db/menu.php');
		session_write_close();
		sleep(1);
		header("Location: ".strip_address("cod",strip_address("pos",$_SERVER['REQUEST_URI'])));
endif;
if(isset($_SESSION['status'])):
	echo $_SESSION['status'];
	$_SESSION['status']=array();
	unset($_SESSION['status']);
endif;
if(isset($_GET['cod'])):
	$cod=mysql_escape_string($_GET['cod']);
	$m=$db->getquery("select cod_category,title, cod_module from congress_menu where cod_menu='".$cod."'");
	if($m[0][0]<>''):
		$edit_title=$m[0][1];
		$cod_cat=$m[0][0];
		$cod_mod=$m[0][2];
		$buttons='<input type="hidden" name="cod" value="'.$cod.'"><input type="submit" name="del_menu" id="del_menu" value="Apagar">&nbsp;<input type="submit" name="edit_menu" id="edit_menu" value="Gravar">';
	else:
		$edit_title='';
		$cod_cat='';
		$cod_mod='';
		$buttons='<input type="submit" name="save_menu" id="save_menu" value="Gravar">';
	endif;
else:
	$edit_title='';
	$cod_cat='';
	$cod_mod='';
	$buttons='<input type="submit" name="save_menu" id="save_menu" value="Gravar">';
endif;
$cat=$db->getquery("select cod_category, nome from congress_category");
$module=$db->getquery("select cod_module, name, link from module order by link");
?>
<h2><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/icone_gestao.gif" width="20" />Menu Lateral</h2>
<form action="" enctype="multipart/form-data" method="post">
<table border="0">
  <tr>
    <td valign="top">
    <?php
	$menu=$db->getquery("select cod_menu, title, cod_category, cod_module from congress_menu order by priority ASC");
	if($menu[0][0]<>''):
		for($i=0;$i<count($menu);$i++):
			if($i==0):
				$pos='<a href="'.strip_address("cod",strip_address("pos",$_SERVER['REQUEST_URI'])).'&pos=down&cod='.$menu[$i][0].'"><img border="0" src="'.$staricvars['site_path'].'/modules/congressos/images/arrow_down.gif"></a><img border="0" src="'.$staricvars['site_path'].'/modules/congressos/images/arrow_empty.gif">';
			elseif($i==(count($menu)-1)):
				$pos='<img border="0" src="'.$staricvars['site_path'].'/modules/congressos/images/arrow_empty.gif"><a href="'.strip_address("cod",strip_address("pos",$_SERVER['REQUEST_URI'])).'&pos=up&cod='.$menu[$i][0].'"><img border="0" src="'.$staricvars['site_path'].'/modules/congressos/images/arrow_up.gif"></a>&nbsp;';
			else:
				$pos='<a href="'.strip_address("cod",strip_address("pos",$_SERVER['REQUEST_URI'])).'&pos=down&cod='.$menu[$i][0].'"><img border="0" src="'.$staricvars['site_path'].'/modules/congressos/images/arrow_down.gif"></a>&nbsp;<a href="'.strip_address("cod",strip_address("pos",$_SERVER['REQUEST_URI'])).'&pos=up&cod='.$menu[$i][0].'"><img border="0" src="'.$staricvars['site_path'].'/modules/congressos/images/arrow_up.gif"></a>&nbsp;';
			endif;
			if($menu[$i][1]==''):
				if($menu[$i][2]<>0):
					for($j=0;$j<count($cat);$j++):
						if($menu[$i][2]==$cat[$j][0]):
							$tit=$cat[$j][1];
							break;
						endif;
					endfor;
					echo $pos.'<a href="'.strip_address("cod",$_SERVER['REQUEST_URI']).'&cod='.$menu[$i][0].'">'.$tit.'</a><br>';
				else:// module defined
					$tit='';
					for($j=0;$j<count($module);$j++):
						if($menu[$i][3]==$module[$j][0]):
							$tit=$module[$j][1];
							break;
						endif;
					endfor;
					if ($tit==''):
						$tit='[Error Module]';
					endif;
					echo $pos.'<a href="'.strip_address("cod",$_SERVER['REQUEST_URI']).'&cod='.$menu[$i][0].'">'.$tit.'</a><br>';
				endif;
			else: // title defined
				if($menu[$i][1]=='[white space]'):
					echo $pos.'<a href="'.strip_address("cod",$_SERVER['REQUEST_URI']).'&cod='.$menu[$i][0].'">'.$menu[$i][1].'</a><br>';
				else:
					if(strpos('-'.$menu[$i][1],'||')):
						$th[0][0]=$menu[$i][1];
						$th[0][1]=$menu[$i][1];
						$tit=translate_cfg($th,$lang);
					else:
						$tit=$menu[$i][1];
					endif;
					echo '<br><h2>'.$pos.'<a href="'.strip_address("cod",$_SERVER['REQUEST_URI']).'&cod='.$menu[$i][0].'">'.$tit.'</a></h2>';
				endif;
			endif;
		endfor;
	else:
		echo 'Menu nao está definido!';
	endif;
	?>
    </p></td>
    <td width="50" align="center">&nbsp;</td>
    <td align="left" valign="top"><p>Título:
      <input name="title" type="text" id="title" value="<?=$edit_title;?>" size="50">
      <br>
      ou<br>
      Categoria:
      <select name="categoria" id="categoria">
        <option value="">Espa&ccedil;o em Branco</option>
		<?php
		if($cat[0][0]<>''):
			for($i=0;$i<count($cat);$i++):
				$sel=($cat[$i][0]==$cod_cat)? 'selected="selected"' : '';
				echo '<option value="'.$cat[$i][0].'" '.$sel.'>'.$cat[$i][1].'</option>';
			endfor;
		endif;
        ?>
      </select>
      <br>
      ou<br>
      M&oacute;dulo:
      <select name="modulo" id="modulo">
        <option value="">Espa&ccedil;o em Branco</option>
				<?php
				$module_option=build_drop_module($module,$_GET['id'],$staticvars['site_path']);
				$sel='';
				for ($i=0 ; $i<count($module_option); $i++):
					$sel=($module_option[$i][0]==$cod_mod)? 'selected="selected"' : '';
					 if ($module_option[$i][0]=='optgroup'):
						echo '<optgroup disabled label="'.$module_option[$i][1].'"></optgroup>';
					 else:
						echo '<option value="'.$module_option[$i][0].'" '.$sel.' >'.$module_option[$i][1].'</option>';
					endif;
				endfor; ?>
      </select>
    </p></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right"><?=$buttons;?></td>
  </tr>
</table>
</form>
<?php
function build_drop_module($query,$task,$staticvars){
// a query tem que ser sempre nesta forma senao da erro! 
//       : select cod_module, name, link from module order by link
	$t[0]='';
	$t[1]='';
	$k=0;
	$allowed[0]=return_id('login.php');
	$allowed[1]=return_id('lost_pass.php');
	$allowed[2]=return_id('new_register.php');
	$allowed[3]=return_id('abstract_submit.php');
	$allowed[4]=return_id('paper_submit.php');
	$allowed[5]=return_id('congressos/downloads.php');
	if (isset($query[1][2])):
		for ($i=1;$i<=count($query);$i++):
			$last_t=$t;
			$t=explode("/",$query[$i-1][2]);
			if (!isset($t[1])):
				$t[1]="ModulesRoot";
			endif;
			if(in_array($query[$i-1][0],$allowed)):
				$option[$k][0]=$query[$i-1][0];
				$option[$k][1]='&nbsp;&nbsp;&nbsp;&nbsp;'.$query[$i-1][1];
				$k++;
			endif;
		endfor;
	endif;
return $option;
};
function translate_cfg($th,$lang){
	if($th[0][1]<>''):// there are translations
		$pipes=explode("||",$th[0][1]);
		$display_name='';
		for($l=0; $l<count($pipes);$l++):
			$names=explode("=",$pipes[$l]);
			if ($lang==$names[0]):
				$display_name=$names[1];
			endif;
		endfor;
		if ($display_name==''):
			$display_name=" - - ";
		endif;
	else:
		$display_name=$th[0][0];
	endif;
	return $display_name;
};

?>