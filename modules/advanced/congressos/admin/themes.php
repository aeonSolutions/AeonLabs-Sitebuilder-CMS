<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if((isset($_POST['gravar_novo']) and $_POST['gravar_novo']<>'') or (isset($_POST['gravar_detalhes']) and $_POST['gravar_detalhes']<>'') or isset($_POST['del_pages'])):
	include($staticvars['local_root'].'modules/congressos/update_db/themes.php');
	header("Location: ".strip_address("cat",strip_address("idioma",strip_address("see",$_SERVER['REQUEST_URI']))));
endif;
if(isset($_POST['edit_cat']) or isset($_POST['insert_cat']) or isset($_POST['del_cat'])):
		include($staticvars['local_root'].'modules/congressos/update_db/themes.php');
		session_write_close();
		sleep(1);
		header("Location: ".strip_address("cat",$_SERVER['REQUEST_URI']));
endif;
if(isset($_SESSION['status'])):
	echo $_SESSION['status'];
	$_SESSION['status']=array();
	unset($_SESSION['status']);
endif;
$nome='';
$translations='';
$cod_cat=0;
$cod_topic=0;
$button='insert_cat';
if(isset($_GET['cat'])):
	$cat=$db->getquery("select cod_theme, name, translations, cod_topic from congress_themes where cod_theme='".mysql_escape_string($_GET['cat'])."'");
	if($cat[0][0]<>''):
		$nome=$cat[0][1];
		$translations=$cat[0][2];
		$button='edit_cat';
		$cod_cat=$cat[0][0];
		$cod_topic=$cat[0][3];
	endif;
endif;
?>
<script language="JavaScript" type="text/javascript">
function checkform ( form )
{
  if (form.nome.value == "") {
    document.getElementById('t_nome').style.color="#FF0000";
	form.nome.focus();
    return false;
  }

  // ** END **
  return true;
}

function cleanform ( form )
{
  if (form.nome.value != "") {
    document.getElementById('t_name').style.color="#2b2b2b";
  }

  // ** END **
}
//-->
</script>
<script type="text/javascript" src="<?=$staticvars['site_path'];?>/core/java/dtree.js"></script>

<h3><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/editor.gif" />Configura&ccedil;&atilde;o de  Temas e Revisores</h3><br />
<p align="center">
<a href="<?=strip_address("cat",strip_address("idioma",strip_address("contents",strip_address("see",$_SERVER['REQUEST_URI']))));?>" >Adicionar Novo Tema</a></p>
<font class="body_text">Seleccione no menu lateral de modo a poder editar o seu conteúdo</font>
<hr class="gradient">
<h3><img src="<?=$staticvars['site_path'].'/modules/congressos';?>/images/adcionar.gif" /> Gest&atilde;o de temas  </h3>        
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr valign="top">
    <td>
        <?php
        $cat=$db->getquery("select cod_theme, name from congress_themes where cod_topic='0'");
        if ($cat[0][0]<>''):
            for($i=0; $i<count($cat);$i++):
                echo '<h2><a href="'.strip_address("load",$_SERVER['REQUEST_URI']).'&load=themes.php&cat='.$cat[$i][0].'"></li>'.$cat[$i][1].'</a></h2>';
                $st=$db->getquery("select cod_theme, name from congress_themes where cod_topic='".$cat[$i][0]."'");
                if($st[$i][0]<>''):
                    echo '<ul id="navlist">';
                    for($j=0;$j<count($st);$j++):
                        echo '<li class="cat-item"><a href="'.strip_address("load",$_SERVER['REQUEST_URI']).'&load=themes.php&cat='.$st[$j][0].'">'.$st[$j][1].'</a></li>';
                    endfor;
                    echo '</ul>';
                endif;
            endfor;
        else:
            echo "nao há Temas!";
        endif;
        ?>
    </td>
    <td>
        <form class="form" name="tree" id="tree" method="post" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data" onsubmit="return checkform(this)">
        <h4>Tema<br />
        <select class="text" name="topics" id="topics">
          <option value="0">Tema (novo)</option>
          <optgroup label="Sub Tema(s)"></optgroup>
          <?php
          $th=$db->getquery("select cod_theme, name from congress_themes where cod_topic='0'");
          if($th[0][0]<>''):
            for($i=0;$i<count($th);$i++):
                $sel= ($th[$i][0]==$cod_topic) ? 'selected="selected"' :'';
                $sel= ($th[$i][0]==$cod_cat) ? 'disabled="disabled"' :$sel;
                echo '<option value="'.$th[$i][0].'" '.$sel.'>'.$th[$i][1].'</option>';
            endfor;
          endif;
          ?>
        </select></h4>
        <h4 id="t_nome">T&iacute;tulo<br />
            <input onKeyPress="cleanform(document.form_db)" onMouseMove="cleanform(document.form_db)"  onchange="cleanform(document.form_db)" value="<?=$nome;?>"  class="text" type="text" name="nome" id="nome">
        </h4>
        <h4>  Tradu&ccedil;&otilde;es<br />
        <input class="text" type="text" value="<?=$translations;?>" name="translations" id="translations" size="60" />
        </h4>
        <div align="right">
        <?php
        if($button=='edit_cat'):
            echo '<input type="hidden" name="cat" value="'.$cod_cat.'" />';
            echo '<input type="submit" class="button" name="del_cat" class="button" value="Apagar" />&nbsp;&nbsp;';
        endif;
        ?>
        <input onMouseOver="cleanform(document.form_db)" class="button" type="submit" name="<?=$button;?>" id="<?=$button;?>" value="Gravar"></div>
      </form>
    </td>
  </tr>
</table>
