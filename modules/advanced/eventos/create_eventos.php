<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
$task=@$_GET['id'];
$msg='';
if (isset($_POST['username']) and isset($_POST['subject']) and isset($_POST['message']) ):
	$option=1;
	if (isset($_POST['disable_smilies'])):
		$option=0;
	endif;	
	
	if (isset($_POST['post'])):
		include('kernel/staticvars.php');
		if (isset($_FILES['up_img']) and $_FILES['up_img']['error']<>4):
			if (stristr($_FILES['up_img']['type'],"jpeg")or stristr($_FILES['up_img']['type'],"gif")):
				$location=$upload_directory.'/eventos/images/'.$_FILES['up_img']['name'];
				if (!move_uploaded_file($_FILES['up_img']['tmp_name'], $location)):
					$_SESSION['update']= 'Erro no Upload tente novamente';
				else:
					$image=mysql_escape_string($_FILES['up_img']['name']);
					// Set a maximum height and width
					$width = 32;
					$height = 32;			
					// Get new dimensions
					list($width_orig, $height_orig) = getimagesize($location);				
					if ($width && ($width_orig < $height_orig)):
					   $width = ($height / $height_orig) * $width_orig;
					else:
					   $height = ($width / $width_orig) * $height_orig;
					endif;
					// Resample
					$image_p = imagecreatetruecolor($width, $height);
					if (stristr($_FILES['up_img']['type'],"jpeg")):
						$image = imagecreatefromjpeg($location);
					else:
						$image = imagecreatefromgif($location);
					endif;
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
					// Output
					if (stristr($_FILES['up_img']['type'],"jpeg")):
						imagejpeg($image_p,$location);
					else:
						imagejpeg($image_p,$location);
//						imagegif($image_p,$location);
					endif;
				endif;
			else:
				$_SESSION['update']= 'Apenas ficheiros GIF e JPEG(1)';
			endif;
		else:
			$image='no_img.gif';
		endif;
		if ($msg==''):
			$user=$db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
			$db->setquery("insert into eventos set cod_user='".$user[0][0]."', title='".normalize_chars(stripslashes(mysql_escape_string($_POST['subject'])))."',
			 texto='".normalize_chars(stripslashes(mysql_escape_string($_POST['message'])))."', data=NOW(), emoticons='".$option."',
			 image='".$image."'");
			$_SESSION['update']= 'Noticia adicionada com sucesso';
		endif;
	endif;
	$address=strip_address("update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);

endif;
if (!isset($_POST['message'])):
	$message='';
	$subject='';
	$option=true;
else:
	$message=$_POST['message'];
	$subject=$_POST['subject'];
	$option=true;
	if (isset($_POST['disable_smilies'])):
		$option=false;
	endif;	
endif;
if (isset($_SESSION['user'])):
	$usr=$_SESSION['user'];
else:
	$usr='';
endif;
echo $msg;
$test3=$db->getquery("select cod_categoria from eventos");
if ( $test3[0][0]<>''):
	add_new_event($staticvars['local_root']);
else:
	if ($test3[0][0]==''):
		$flags[0]='Adicionar categorias';
	else:
		$flags[0]='';
	endif;
	warnings($staticvars['site_path'],$flags);
endif;

function add_new_even($staticvars['local_root']){
?>
<SCRIPT src="<?=$staticvars['site_path'].'/modules/eventos/system/bbcode.js';?>" type=text/javascript></SCRIPT>
<br />
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>Adicionar um evento</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD width="36" vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/eventos/images/icon_eventos.gif" alt="Adicionar Evento"/><BR></TD>
      <TD vAlign=top><p>Gest&atilde;o da programa&ccedil;&atilde;o de eventos.</p>
      <p>&nbsp;</p></TD>
    </TR>
  </TBODY>
</TABLE>
<br />
<?php
if (isset($_POST['preview'])):
	echo '<table style="background-color:#FFFDF0;border-color:#7598BF;border-style:solid;border-width:1px;color:#003366;width:100%;margin-bottom:10PX;">
		<tr>
		<td height="100%" valign="top" align="center">';			
			echo '<font class="header_text_1">Previs&atilde;o do Evento:</font>
			<hr size="1" />';
			include_once($staticvars['local_root'].'modules/eventos/system/eventos_funcs.php');
			put_preview_admin($staticvars['local_root'],$_POST['message'],$_POST['subject'],$option);
	echo '</td>
		</tr>
	</table>';
endif;
?>
<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data" name="post" onsubmit="return checkForm(this)">
<table border="0" align="left" cellpadding="3" cellspacing="1" >
	<tr> 
	  <td align="right" class="body_text"><b>T&iacute;tulo</b></td>
	  <td>
	    <input type="text" name="subject" size="23" maxlength="60" style="width:99%" tabindex="2" class="body_text" value="<?=$subject;?>" />
	  <input type="hidden" name="username" value="<?=$usr;?>" /></td>
	</tr>
	<tr>
	  <td align="right" valign="middle" ><strong>Categoria</strong></td>
	  <td valign="top"><select size="1" name="cat" class="form_input">
        <?php
			$query=$db->getquery("select cod_categoria, nome from eventos_categorias where cod_sub_cat='".$cod_categoria."'");
			$option[0][0]='';
			$option[0][1]='-----------------';
			if($query[0][0]<>''):
				for ($i=0;$i<count($query);$i++):
					$option[$i+1][0]=$query[$i][0];
					$option[$i+1][1]=$query[$i][1];
				endfor;
			endif;
			for ($i=0 ; $i<count($option); $i++):
				?>
        <option value="<?php echo $option[$i][0];?>" >
          <?=$option[$i][1];?>
          </option>
        <?php
			endfor; ?>
      </select></td>
    </tr>
	<tr>
	  <td align="right" valign="middle" ><strong>Data de realiza&ccedil;&atilde;o</strong></td>
	  <td valign="top"><label>
<select name="dia" id="dia">
  <option value="1" selected="selected">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
</select>	    
/
      <select name="mes" id="mes">
        <option value="1" selected="selected">Janeiro</option>
        <option value="2">Fevereiro</option>
        <option value="3">Março</option>
        <option value="4">Abril</option>
        <option value="5">Maio</option>
        <option value="6">Junho</option>
        <option value="7">Julho</option>
        <option value="8">Agosto</option>
        <option value="9">Setembro</option>
        <option value="10">Outubro</option>
        <option value="11">Novembro</option>
        <option value="12">Dezembro</option>
        </select> 
      / 
      
	  <select name="ano" id="ano">
	    <option value="2006">2006</option>
	    <option value="2007">2007</option>
	    <option value="2008" selected="selected">2008</option>
	    <option value="2009">2009</option>
	    <option value="2010">2010</option>
	    <option value="2011">2011</option>
	    <option value="2012">2012</option>
	    <option value="2013">2013</option>
                  </select>
	  </label></td>
    </tr>
	<tr> 
	  <td align="center" valign="middle" >
	        <?php
			if ($smilies):
			?>
		<table width="100" border="0" cellspacing="0" cellpadding="5">
        <tr align="center" valign="middle">
          <td>
          <table width="100" border="0" align="center" cellpadding="5" cellspacing="0">
              <tr align="center">
                <td colspan="4" class="body_text"><b>Emoticons</b></td>
              </tr>
              <tr align="center" valign="middle">
                <td><a href="javascript:emoticon(':D')"><img src="images/smiles/icon_biggrin.gif" border="0" alt="Very Happy" title="Very Happy" /></a></td>
                <td><a href="javascript:emoticon(':)')"><img src="images/smiles/icon_smile.gif" border="0" alt="Smile" title="Smile" /></a></td>
                <td><a href="javascript:emoticon(':(')"><img src="images/smiles/icon_sad.gif" border="0" alt="Sad" title="Sad" /></a></td>
                <td><a href="javascript:emoticon(':o')"><img src="images/smiles/icon_surprised.gif" border="0" alt="Surprised" title="Surprised" /></a></td>
              </tr>
              <tr align="center" valign="middle">
                <td><a href="javascript:emoticon(':shock:')"><img src="images/smiles/icon_eek.gif" border="0" alt="Shocked" title="Shocked" /></a></td>
                <td><a href="javascript:emoticon(':?')"><img src="images/smiles/icon_confused.gif" border="0" alt="Confused" title="Confused" /></a></td>
                <td><a href="javascript:emoticon('8)')"><img src="images/smiles/icon_cool.gif" border="0" alt="Cool" title="Cool" /></a></td>
                <td><a href="javascript:emoticon(':lol:')"><img src="images/smiles/icon_lol.gif" border="0" alt="Laughing" title="Laughing" /></a></td>
              </tr>
              <tr align="center" valign="middle">
                <td><a href="javascript:emoticon(':x')"><img src="images/smiles/icon_mad.gif" border="0" alt="Mad" title="Mad" /></a></td>
                <td><a href="javascript:emoticon(':P')"><img src="images/smiles/icon_razz.gif" border="0" alt="Razz" title="Razz" /></a></td>
                <td><a href="javascript:emoticon(':oops:')"><img src="images/smiles/icon_redface.gif" border="0" alt="Embarassed" title="Embarassed" /></a></td>
                <td><a href="javascript:emoticon(':cry:')"><img src="images/smiles/icon_cry.gif" border="0" alt="Crying or Very sad" title="Crying or Very sad" /></a></td>
              </tr>
              <tr align="center" valign="middle">
                <td><a href="javascript:emoticon(':evil:')"><img src="images/smiles/icon_evil.gif" border="0" alt="Evil or Very Mad" title="Evil or Very Mad" /></a></td>
                <td><a href="javascript:emoticon(':twisted:')"><img src="images/smiles/icon_twisted.gif" border="0" alt="Twisted Evil" title="Twisted Evil" /></a></td>
                <td><a href="javascript:emoticon(':roll:')"><img src="images/smiles/icon_rolleyes.gif" border="0" alt="Rolling Eyes" title="Rolling Eyes" /></a></td>
                <td><a href="javascript:emoticon(':wink:')"><img src="images/smiles/icon_wink.gif" border="0" alt="Wink" title="Wink" /></a></td>
              </tr>
              <tr align="center" valign="middle">
                <td><a href="javascript:emoticon(':!:')"><img src="images/smiles/icon_exclaim.gif" border="0" alt="Exclamation" title="Exclamation" /></a></td>
                <td><a href="javascript:emoticon(':?:')"><img src="images/smiles/icon_question.gif" border="0" alt="Question" title="Question" /></a></td>
                <td><a href="javascript:emoticon(':idea:')"><img src="images/smiles/icon_idea.gif" border="0" alt="Idea" title="Idea" /></a></td>
                <td><a href="javascript:emoticon(':arrow:')"><img src="images/smiles/icon_arrow.gif" border="0" alt="Arrow" title="Arrow" /></a></td>
              </tr>
              <tr align="center">
                <td><a href="javascript:emoticon(':|')"><img src="images/smiles/icon_neutral.gif" border="0" alt="Neutral" title="Neutral" /></a></td>
                <td><a href="javascript:emoticon(':mrgreen:')"><img src="images/smiles/icon_mrgreen.gif" border="0" alt="Mr. Green" title="Mr. Green" /></a></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
          </table>            </td>
        </tr>
      </table>
		  <?php
			endif;
			?></td>
	  <td valign="top"><span class="body_text"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		  <tr align="center" valign="middle"> 
			<td><span class="body_text"> 
			  <input type="button" class="form_submit" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline('b')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="form_submit" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline('i')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="form_submit" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline('u')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="form_submit" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbstyle(6)" onMouseOver="helpline('q')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="form_submit" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbstyle(8)" onMouseOver="helpline('c')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="form_submit" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbstyle(10)" onMouseOver="helpline('l')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="form_submit" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onMouseOver="helpline('p')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="form_submit" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="8"> 
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr> 
				  <td width="78%"><span class="body_text">&nbsp;Cor:				  
				    <select name="addbbcode18" onchange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onmouseover="helpline('s')" class="body_text">
                      <option style="color:black" value="defeito" class="body_text">Defeito</option>
                      <option style="color:darkred" value="darkred" class="body_text">Vermelho escuro</option>
                      <option style="color:red" value="red" class="body_text">Vermelho</option>
                      <option style="color:orange" value="orange" class="body_text">Laranja</option>
                      <option style="color:brown" value="brown" class="body_text">Castanho</option>
                      <option style="color:yellow" value="yellow" class="body_text">Amarelo</option>
                      <option style="color:green" value="green" class="body_text">Verde</option>
                      <option style="color:olive" value="olive" class="body_text">Azeitona</option>
                      <option style="color:cyan" value="cyan" class="body_text">Ciano</option>
                      <option style="color:blue" value="blue" class="body_text">Azul</option>
                      <option style="color:darkblue" value="darkblue" class="body_text">Azul escuro</option>
                      <option style="color:indigo" value="indigo" class="body_text">Indigo</option>
                      <option style="color:violet" value="violet" class="body_text">Violeta</option>
                      <option style="color:white" value="white" class="body_text">Branco</option>
                      <option style="color:black" value="black" class="body_text">Preto</option>
                    </select>
				    &nbsp;Fonte:
				  <select  class="body_text" name="addbbcode20" onChange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
					  <option value="7" class="body_text">Minúscula</option>
					  <option value="9" class="body_text">Pequena</option>
					  <option value="12" selected class="body_text">Normal</option>
					  <option value="18" class="body_text">Grande</option>
					  <option  value="24" class="body_text">Enorme</option>
					</select>
				  </span></td>
				  <td width="22%" align="right" nowrap="nowrap"><span class="body_text"><a href="javascript:bbstyle(-1)" class="body_text" onMouseOver="helpline('a')">Fechar marcas</a></span></td>
				</tr>
			  </table>			</td>
		  </tr>
		  <tr align="center" valign="middle"> 
			<td height="50" colspan="8"> <span class="body_text"> 
			  <input type="text" name="helpbox" size="30" maxlength="100" style="width:99%; font-size:10px; text-align:center;" class="helpline" value="Ideia: Estilos podem ser aplicados rapidamente a texto seleccionado" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="8"><span class="body_text"> 
			  <textarea name="message" rows="15" cols="23" wrap="virtual" style="width:99%" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"><?=$message;?></textarea>
			  </span></td>
		  </tr>
		</table>
		</span></td>
	</tr>
	<tr>
	  <td align="right"><b>Imagem</b><font size="1">(Opcional)</font></td>
	  <td><input name="up_img" type="file" accept="image/gif,image/jpeg"  class="body_text" id="up_img" size="30"></td>
    </tr>
	<tr> 
	  <td  valign="top">
      <?php
      if($smilies):
		  ?>
		  <span class="body_text"><b>Op&ccedil;&otilde;es</b></span><br />
		  <span class="body_text">&nbsp;&nbsp;&nbsp;<? if ($option): echo 'Smiles activado'; else: echo 'Smiles desactivado'; endif;?></span>
		  <?php
	  endif;
	  ?>      </td>
	  <td> 
    <?php
	  if($smilies):
	  ?>
		<table cellspacing="0" cellpadding="1" border="0">
		  <tr> 
			<td> 
			  <input type="checkbox" name="disable_smilies" <? if (!$option): echo 'checked'; endif;?> />			</td>
			<td><span class="body_text">Desactivar Emoticons </span></td>
		  </tr>
		</table>
       <?php
	  endif;
	  ?>	  </td>
	</tr> 
	<tr> 
	  <td colspan="2" align="center" height="28">&nbsp;<input type="submit" accesskey="s" tabindex="6" name="post" class="form_submit" value="Submeter" /></td>
	</tr>
  </table>
</form>
<?php
function warnings($staticvars['site_path'],$flags){
?>
<table width="100%" border="0">
  <tr valign="top">
    <td width="40"><img src="<?=$staticvars['site_path'];?>/modules/eventos/images/warning.png" alt="warning" />&nbsp;</td>
    <td><p>Para poder adicionar um evento &agrave; base de dados, tem primeiro que:</p>
      <ul>
      <?php
		for($i=0;$i<count($flags);$i++):
        	if ($flags[$i]<>''):
				echo '<li>'.$flags[$i].'</li>'.chr(13);
			endif;
		endfor;
		?>
      </ul>
    </td>
  </tr>
</table>

<?php
};

?>