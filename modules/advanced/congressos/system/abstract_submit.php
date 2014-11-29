<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');

if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;
$th=$db->getquery("select cod_theme, cod_topic, name, translations from congress_themes where cod_topic='0'");
if($th[0][0]==''):
	echo 'You need to build topics file first!';
	exit;
endif;
if(isset($_SESSION['congress'])):
	echo '<font color="red">'.$_SESSION['congress'].'</font>';
endif;
if(isset($_SESSION['success'])):
	include($staticvars['local_root'].'modules/congressos/system/abstract_success.php');
	$_SESSION['success']=array();
	unset($_SESSION['success']);
else:
if(isset($_POST['code'])):
	$submit='edit_abs';
	$cod=mysql_escape_string($_POST['code']);
	$prod=$db->getquery("select cod_abstract,cod_user, cod_theme, file, title, keywords, authors, abstract, data,idc, revised, revision_data from congress_abstracts where cod_abstract='".$cod."'");
else:
	$submit='submit_btn';
	$prod[0][0]='';
	$prod[0][1]='';
	$prod[0][2]='';
	$prod[0][3]='';
	$prod[0][4]='';
	$prod[0][5]='';
	$prod[0][6]='';
	$prod[0][7]='';
	$prod[0][8]='';
endif;
?>
<script language="JavaScript" type="text/javascript"> 

function abstract_counter() {
var maxlimit=3000;
if (document.abstract_submition.abstract.value.length > maxlimit) // if too long...trim it!
	document.abstract_submition.abstract.value = document.abstract_submition.abstract.value.substring(0, maxlimit);
else // otherwise, update 'characters left' counter
	document.getElementById('abs_chr_left').innerHTML = "( " + (maxlimit - document.abstract_submition.abstract.value.length) + " <?=$as[10];?>)";
}

<!--
function checkform ( form )
{
  if (form.topic.value == "") {
    document.getElementById('u_topic').style.color="#FF0000";
	form.topic.focus();
    return false;
  }
  if (form.title.value == "") {
    document.getElementById('u_title').style.color="#FF0000";
	form.title.focus();
    return false;
  }
  if (form.authors.value == "" ) {
    document.getElementById('u_authors').style.color="#FF0000";
	form.authors.focus();
    return false;
  }
  if (form.keywords.value == "") {
    document.getElementById('u_keywords').style.color="#FF0000";
	form.keywords.focus();
    return false;
  }
  if (form.abstract.value == "") {
    document.getElementById('u_abstract').style.color="#FF0000";
	form.abstract.focus();
    return false;
  }

  // ** END **
  return true;
}

function cleanform ( form )
{
  if (form.topic.value != "") {
    document.getElementById('u_topic').style.color="#2b2b2b";
  }
   if (form.title.value != "") {
    document.getElementById('u_title').style.color="#2b2b2b";
  }
  if (form.authors.value != "" ) {
    document.getElementById('u_authors').style.color="#2b2b2b";
  }
  if (form.keywords.value != "") {
    document.getElementById('u_keywords').style.color="#2b2b2b";
  }
  if (form.abstract.value != "") {
    document.getElementById('u_abstract').style.color="#2b2b2b";
  }
}
//-->
</script> 

<form class="form" name="abstract_submition" action="<?=session($staticvars,'index.php?id='.return_id('abstract_submit.php'));?>" onsubmit="return checkform(this)" method="post" enctype="multipart/form-data">
  <table class="default" cellspacing="2" cellpadding="2" border="0">
      <tr valign="top">
        <td align="left"></td>
        <td align="right"><img src="<?=$staticvars['site_path'];?>/modules/congressos/images/atencao.gif" alt="warning" width="15" height="13" /><?=$as[0];?></td>
      </tr>
      <tr valign="center">
        <td colspan="2" align="left"><b><?=$as[1];?></b></td>
      </tr>
      <tr valign="center">
        <td align="right"><b><div id="u_topic"><?=$as[2];?></div></b></td>
        <td>
          <select class="text" onchange="cleanform(document.abstract_submition);"  name="topic" id="topic" tabindex="0">
		<?php
        $cat=$db->getquery("select cod_theme, name from congress_themes where cod_topic='0'");
        if ($cat[0][0]<>''):
            for($i=0; $i<count($cat);$i++):
                $st=$db->getquery("select cod_theme, name from congress_themes where cod_topic='".$cat[$i][0]."'");
                if($st[$i][0]<>''):
	                echo '<optgroup disabled label="'.$cat[$i][1].'"></optgroup>';
                    echo '<ul id="navlist">';
                    for($j=0;$j<count($st);$j++):
						if($prod[0][2]==$st[$j][0]):
							$sel='selected="selected"';
						else:
							$sel='';
						endif;
                        echo '<option '.$sel.' value="'.$st[$j][0].'">'.$st[$j][1].'</a></li>';
                    endfor;
                    echo '</ul>';
				else:
					if($prod[0][2]==$cat[$i][0]):
						$sel='selected="selected"';
					else:
						$sel='';
					endif;
					echo '<option '.$sel.' value="'.$cat[$i][0].'">'.$cat[$i][1].'</a></li>';
                endif;
            endfor;
        endif;
        ?>
          </select>
        </td>
      </tr>
      <tr valign="center">
        <td align="right"><b>
<div id="u_title"><?=$as[3];?></div></b></td>
        <td><input class="text" onchange="cleanform(document.abstract_submition);"  name="title" type="text" id="title" tabindex="1" size="50" maxlength="255" value="<?=$prod[0][4];?>"/><font style="font-size:11px;"><?=$as[9];?></font></td>
      </tr>
      <tr valign="center">
        <td align="right"><strong><div id="u_authors"><?=$as[4];?></div></strong></td>
        <td><input class="text" onchange="cleanform(document.abstract_submition);"  name="authors" type="text" id="authors" tabindex="2" size="50" maxlength="255"  value="<?=$prod[0][6];?>"/><font style="font-size:11px;"><?=$as[9];?></font></td>
      </tr>
      <tr valign="center">
        <td align="right"><b>
<div id="u_keywords"><?=$as[5];?></div></strong></td>
        <td><input class="text" onchange="cleanform(document.abstract_submition);"  name="keywords" type="text" id="keywords" tabindex="3" size="50" maxlength="255"  value="<?=$prod[0][5];?>"/><font style="font-size:11px;"><?=$as[9];?></font></td>
      </tr>
      <tr valign="center">
        <td align="right" valign="top"><strong>
<div id="u_abstract"><?=$as[6];?></div></strong></td>
        <td align="center"> <div align="left"><font style="font-size:11px;"><?=$as[7];?></font></div>
          <textarea class="text"  name="abstract" cols="60" rows="14" tabindex="4" onKeyDown="abstract_counter();" onKeyUp="abstract_counter();"><?=$prod[0][7];?></textarea>
        <div id="abs_chr_left" style="font-size:11px;"><?=$as[8];?> </div></td>
      </tr>
    <tr valign="center">
      <td><br /></td>
      <td align="right" valign="top"><input class="button" type="submit" value="<?=$as[11];?>"  name="<?=$submit;?>" />
          <br />
          <br /></td>
    </tr>
  </table>
  <input type="hidden" value="<?=$prod[0][0];?>" name="code" />
</form>
<?php
endif;
?>
