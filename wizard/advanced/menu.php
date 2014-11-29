<?php
/*
File revision date: 7-jul-2007
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($local_root.'general/site_handler.php')):
	echo 'Error: Security Not Found(menu wizard)';
	exit;
endif;
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
$code=mysql_escape_string(@$_GET['ut']);
if (isset($_POST['ut'])):
	$code=mysql_escape_string($_POST['ut']);
else:
	$code=mysql_escape_string(@$_GET['ut']);
endif;
if(isset($_POST['menu_nome']) or isset($_POST['add_menu_nome']) or isset($_POST['menu_type']) or isset($_POST['menu_code']) or isset($_POST['del_menu'])):
	include($local_root.'general/staticvars.php');
	include($local_root.'update_db/menu_layout_setup.php');
endif;
include($local_root.'kernel/settings/menu.php');
if($menu_type=='disabled'):
	$txt='<hr class="gradient"><img src="'.$site_path.'/images/info.png" alt="info" /><font class="body_text">The Menu Type you\'ve selected dosn\'t allow you to have a customizable menu<br />To change, go back to step nº2.</font><hr class="gradient">';
else:
	$txt='';
endif;
?>
<link rel="StyleSheet" href="<?=$site_path;?>/core/java/dtree.css" type="text/css" />
<script language="javascript">
function switch_box1()
{
  var cur_box = window.document.menu_type.without_menu;
  var alter_box = window.document.menu_type.with_menu;
  var the_switch = "";
  if (cur_box.checked == false) {
		alter_box.checked=true;
  } else {
		alter_box.checked=false;
  }
}
function switch_box2()
{
  var cur_box = window.document.menu_type.without_menu;
  var alter_box = window.document.menu_type.with_menu;
  var the_switch = "";
  if (alter_box.checked == false) {
		cur_box.checked=true;
  } else {
		cur_box.checked=false;
  }
}
</script>
<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
  <tr valign="top">
    <td align="center"><div class="dtree"><?=$txt;?></div></td>
  </tr>
  <tr>
    <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
  </tr>
  <tr valign="top">
    <td>
    <?php
    if($menu_type<>'disabled'):
        $query=$db->getquery("SHOW TABLES LIKE 'menu'");
        if ($query[0][0]<>''):
            if (isset($_GET['type'])):
                if($_GET['type']=='add'):
                    add_field($local_root);
				else:
					no_code($local_root);
				endif;
			else:
				no_code($local_root);
			endif;
		else:
			no_code($local_root);
        endif;
    else:
        $address=strip_address($local_root,"step",$_SERVER['REQUEST_URI']);
        ?>
            <div align="right"><form action="<?=$address;?>" enctype="multipart/form-data" method="post">
            <input name="continue" type="submit" class="form_submit" id="continue" value="Continue Wiz"></form></div>
        <?php
    endif;
      ?>
    </td>
  </tr>
  <?php
    $box_setup=true;
    if (isset($_GET['type'])):
        if($_GET['type']=='view'):
        ?>
      <tr>
        <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
      </tr>
      <tr valign="top">
        <td class="body_text">
        Skin Menu:<br />
            <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
              <tr>
                <td height="400">
                  <IFRAME name="target_iframe" align="center" frameBorder="0" width="100%" height="100%" src="<?=session_setup($globvars,$site_path.'/layout/view.php?where=menu&file='.$_GET['file']);?>" scrolling="auto"></IFRAME>
                </td>
              </tr>
            </table>
        </td>
      </tr>
      <tr>
        <td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$site_path.'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
      </tr>
  <?php
    endif;
endif;
?>
</table>
<?php


function no_code($local_root){
include($local_root.'general/staticvars.php');
$address=strip_address($local_root,"file",$_SERVER['REQUEST_URI']);
$address=strip_address($local_root,"change",$address);
$address=strip_address($local_root,"type",$address);
$addr_change=$address.'&step=1';
$address=strip_address($local_root,"step",$address);
$addr_continue=$address.'&step=6';
if(is_file($local_root.'kernel/settings/menu.php')):
	include($local_root.'kernel/settings/menu.php');
	if($menu_type=='dynamic'):
		$img='menu_db';
		$txt='Neste momento o menu definido é dinâmico (UMS) e utiliza tabelas na base de dados para fazer a sua gest&atilde;o e manuten&ccedil;&atilde;o.';
	elseif($menu_type=='static'):
		$img='menu_db';
		$txt='Neste momento o menu definido é estático (sem UMS) e utiliza tabelas na base de dados para fazer a sua gest&atilde;o e manuten&ccedil;&atilde;o.';
	else:
		$img='menu_no_db';
		$txt='Neste momento o tipo de menu definido n&atilde;o utiliza tabelas na base de dados para fazer a sua gest&atilde;o e manuten&ccedil;&atilde;o.';
	endif;
else:
	$img='menu_no_db';
	$txt='Neste momento o tipo de menu definido n&atilde;o utiliza tabelas na base de dados para fazer a sua gest&atilde;o e manuten&ccedil;&atilde;o.';
endif;

?>
<script language="javascript" type="text/javascript">
function submit_change(frm){
	frm.action = '<?=$addr_change;?>';
}
function submit_continue(frm){
	frm.action = '<?=$addr_continue;?>';
}
</script>
<table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="55"><img src="<?=$site_path.'/images/'.$img.'.png';?>" alt="ok" /></td>
    <td width="320" class="body_text"><br />O Menu foi instalado com sucesso. <br /><?=$txt;?></td>
  </tr>
</table>

	<table border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left">
			<?php
			if (is_file($local_root.'kernel/settings/menu.php')):
				include($local_root.'kernel/settings/menu.php');
				if($menu_type<>'disabled'):
					?>
					<br /><font class="body_text"><br />Seleccione um template de modo a poder visualizar os detalhes </font>	
					<?php
					put_files($local_root);
				endif;
			endif;
			?>
		</td>
	  </tr>
	</table>
	<div align="right"><form action="<?=$address;?>" enctype="multipart/form-data" method="post">
	<input type="submit" class="form_submit" name="change" value="Change Menu Type" onclick="submit_change(this.form)"/>&nbsp;&nbsp;
	<input name="continue" type="submit" class="form_submit" id="continue" value="Continue Wiz" onclick="submit_continue(this.form)"/></form></div>
	<?php
};


function add_field($local_root){
include($local_root.'general/staticvars.php');
$task=@$_GET['id'];
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang=$main_language;
endif;
if (isset($_GET['file'])):
	$fil=@$_GET['file'];
	$nam=explode(".",$fil);
	$nam=$nam[0];
	$nam=str_replace("_"," ",$nam);
else:
	$fil='';
endif;
?>
	<form method="post" action="<?=session_setup($globvars,$site_path.'/index.php?id='.$task);?>"  enctype="multipart/form-data">
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_menu_nome" maxlength="255" value="<?=$nam;?>" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td colspan="2">
			<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
			<input type="text" name="add_menu_ficheiro" maxlength="255" value="<?=$fil;?>" size="40">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td align="right">
		  <input name="add_sub_menu" type="image" src="<?=$site_path.'/images/buttons/'.$lang;?>/adicionar.gif">
		</td>
	  </tr>
	  <tr>
		<td height="5" colspan="2"></td>
	  </tr>
	  <tr>
		<td height="10" colspan="2">
		<?php
		put_files($local_root);
		?>
		</td>
	  </tr>
	  </table>
	  </form>

<?php
};

function put_files($local_root){
include($local_root.'general/staticvars.php');
$task=@$_GET['id'];
echo '<br><br><font class="body_text">Ficheiros existentes no directório de Templates do Menu:</font><br><br>';
$dir_files = glob($local_root."layout/menu/layouts/*.php");
for($i=0; $i < count($dir_files); $i++):
	$fl=explode("/",$dir_files[$i]);
	$query=$db->getquery("select cod_menu_layout, ficheiro, active from menu_layout where ficheiro='".$fl[count($fl)-1]."'");
	if ($query[0][0]<>''): //file found on the db
		echo '<img src="'.$site_path.'/images/check_mark.gif">';
		echo '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;'.$fl[count($fl)-1]. "&nbsp;(". filesize($dir_files[$i]) . " bytes)</font>&nbsp;";
		if ($query[0][2]=='s'):
			echo '<font class="body_text">&nbsp;[Activado]</font><br>';
		else:
			echo '<font class="body_text">&nbsp;[Inactivo]</font><br>';
		endif;
	else:
		echo '<img src="'.$site_path.'/images/cross_mark.gif">';
		echo '<font class="body_text">[<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=view&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">ver</a>]&nbsp;&nbsp;<a style="text-decoration: none" href="'.session_setup($globvars,'index.php?type=add&id='.$task.'&file='.$fl[count($fl)-1]).'" target="_self">'.$fl[count($fl)-1]. "</a>&nbsp;(". filesize($dir_files[$i]) . " bytes)</font><br>";
	endif;
endfor;
echo '<br><br>';
echo '<img src="'.$site_path.'/images/check_mark.gif"><font class="body_text">Ficheiro instalado</font>&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<img src="'.$site_path.'/images/cross_mark.gif"><font class="body_text">Ficheiro n&atilde;o instalado</font>';

};
?>
