<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Authenticated Users';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (edit news)';
	exit;
endif;
$task=@$_GET['id'];
if (!isset($_POST['message'])):
	$message='';
	$subject='';
	$option=true;
else:
	include($staticvars['local_root'].'modules/news/system/update_news.php');
	$address=strip_address("update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);
endif;
if (isset($_POST['news'])):
	$mod=$_POST['news'];
	$cur_news=$db->getquery("select title, texto, emoticons, active, image,cod_user from news where cod_news='".mysql_escape_string($_POST['news'])."'");
	if ($cur_news[0][0]<>''):
		$_SESSION['news']=$mod;
		$message=$cur_news[0][1];
		$subject=$cur_news[0][0];
		$usr=$db->getquery("select nick from users where cod_user='".$cur_news[0][5]."'");
		$usr=$usr[0][0];
		if ($cur_news[0][4]=='' or $cur_news[0][4]=='no_img.gif'):
			$image=$staticvars['site_path'].'/modules/news/images/no_img.gif';
		else:
			$image=$upload_path.'/news/images/'.$cur_news[0][4];
		endif;
		if ($cur_news[0][2]=='1'):
			$option=true;
		else:
			$option=false;
		endif;
		if ($cur_news[0][3]=='s'):
			$active=true;
		else:
			$active=false;
		endif;
	else:
		$mod=0;
	endif;
else:
	$mod=0;
endif;
$address=strip_address("update",$_SERVER['REQUEST_URI']);
if (!file_exists($staticvars['local_root'].'modules/news/system/settings.php')):
	$smilies=false;
else:
	include($staticvars['local_root'].'modules/news/system/settings.php');
endif;

?>
<SCRIPT src="<?=$staticvars['site_path'].'/modules/news/system/bbcode.js';?>" type=text/javascript></SCRIPT>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
    <TR>
      <TD colspan="2" vAlign=top class="header-bk"><H3>Editar nota informativa</H3></TD>
    </TR>
    <TR>
      <TD colspan="2" vAlign=top height="5"></TD>
    </TR>
    <TR>
      <TD width="36" vAlign=top><img src="<?=$staticvars['site_path'];?>/modules/news/images/icon_news.gif" alt="Colocar nota informativa"/><BR></TD>
      <TD vAlign=top><p>As notas informativas servem para avisar ou informar algo que requer aten&ccedil;&atilde;o de forma mais imediata.</p>
      <p>&nbsp;</p></TD>
    </TR>
  </TBODY>
</TABLE>
<br />
<?php
if (!isset($active)):
 ?>
<form class="form" action="<?=$address;?>" method="post" enctype="multipart/form-data" name="post" onsubmit="return checkForm(this)">	
<input type="hidden" name="cod_news" value="<?=@mysql_escape_string($_POST['news'])?>" />
<table border="0" cellpadding="3" cellspacing="1" width="100%" >
	<tr>
	  <td ><div align="right"><span class="body_text"><b>Not&iacute;cia a editar </b></span></div></td>
	  <td >
				<?php
				$query=$db->getquery("select cod_news,title from news");
				$selected=0;
				$option1[0][0]='';
				$option1[0][1]='------------------------------------';
				if ($query[0][0]<>''):
					for ($i=1;$i<=count($query);$i++):
						$option1[$i][0]=$query[$i-1][0];
						$option1[$i][1]=$query[$i-1][1];
						if ($query[$i-1][0]==$mod):
							$selected=$i;
						endif;
					endfor;
				endif;
				?>	<select name="news" class="text"> <?php
				for ($i=0 ; $i<count($option1); $i++):
					?>
					<option value="<?php echo $option1[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
					<?php echo $option1[$i][1]; ?></option>
				<?php
				endfor; ?>
		</select>
	  &nbsp;<input type="submit" value=" ver "  name="active" class="button"/>	  </td>
    </tr>
    </table>
<?php
elseif (isset($active)):
 ?>
<form class="form" action="<?=$address.'&update=8';?>" method="post" enctype="multipart/form-data" name="post" onsubmit="return checkForm(this)">	
<input type="hidden" name="cod_news" value="<?=@mysql_escape_string($_POST['news'])?>" />
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr>
	  <td colspan="2" >
		<?php
		if (isset($_POST['preview'])):
			echo '<table style="background-color:#FFFDF0;border-color:#7598BF;border-style:solid;border-width:1px;color:#003366;width:100%;margin-bottom:10PX;">
				<tr>
				<td height="100%" valign="top" align="center">';			
					echo '<font class="header_text_1">Previs&atilde;o do Post Informativo:</font>
					<hr size="1" />';
					$_SESSION['message']=$_POST['message'];
					$_SESSION['subject']=$_POST['subject'];
					$_SESSION['option']=$option;
					include($staticvars['local_root'].'modules/news/system/news_funcs.php');
					put_preview($staticvars['local_root']);
			echo '</td>
				</tr>
			</table>';
		endif;
			?>
		</td>
    </tr>
	<tr>
	  <td height="5" colspan="2" ><hr size="1"></td>
    </tr>
	<tr>
	  <td ><div align="right"><span class="body_text"><b>Estado</b></span></div></td>
	  <td >
		<?php
		if ($active):
		 	$tmp='Desactivar';
			echo '<img src="'.$staticvars['site_path'].'/modules/news/images/active.gif" alt="Estado"/> O Post encontra-se Activo.';
		 else:
		 	$tmp='Activar';
			echo '<img src="'.$staticvars['site_path'].'/modules/news/images/inactive.gif" alt="Estado"/> O Post encontra-se Inactivo.';
		endif; ?>		</td>
	  </tr>
	<tr> 
		<td ><div align="right"><span class="body_text"><b>Colocado por</b></span></div></td>
		<td ><input type="text" class="text" tabindex="1" name="username" size="25" maxlength="25" value="<?=$usr;?>" disabled="disabled"/></td>
	</tr>
	<tr>
	  <td >&nbsp;</td>
	  <td ><div align="center">Imagem Actual<br /><img src="<?=$image;?>" border="1"></div></td>
    </tr>
	<tr>
	  <td ><div align="right"><span class="body_text"><b>Nova Imagem</b></span></div></td>
	  <td ><input name="up_img" type="file" class="text" id="up_img" style="width:90%"></td>
    </tr>
	<tr> 
	  <td  width="22%"><div align="right"><span class="body_text"><b>T&iacute;tulo</b></span></div></td>
	  <td  width="78%"> <span class="body_text"><span class="body_text">
	    <input type="text" name="subject" size="45" maxlength="60" style="width:90%" tabindex="2" class="post" value="<?=$subject;?>" />
	  </span></span> </td>
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
          </table>
            </td>
        </tr>
      </table>
		  <?php
			endif;
			?>
      </td>
	  <td  valign="top"><span class="body_text"> <span class="body_text"> </span> 
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		  <tr align="center" valign="middle"> 
			<td><span class="body_text"> 
			  <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline('b')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline('i')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline('u')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbstyle(6)" onMouseOver="helpline('q')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbstyle(8)" onMouseOver="helpline('c')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbstyle(10)" onMouseOver="helpline('l')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onMouseOver="helpline('p')" />
			  </span></td>
			<td><span class="body_text"> 
			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="8"> 
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr> 
				  <td width="78%"><span class="body_text">&nbsp;Cor:
				  <select class="text" name="addbbcode18" onChange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('s')">
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
					</select>&nbsp;Fonte:<select name="addbbcode20" onChange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
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
			  <input type="text" name="helpbox" maxlength="100" style="width:90%; font-size:10px; text-align:center;" class="helpline" value="Ideia: Estilos podem ser aplicados rapidamente a texto seleccionado" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="8"><span class="body_text"> 
			  <textarea name="message" rows="15"  wrap="virtual" style="width:90%" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"><?=$message;?></textarea>
			  </span></td>
		  </tr>
		</table>
		</span></td>
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
	  ?>
      </td>
	  <td >
      <?php
	  if($smilies):
	  ?>
		<table cellspacing="0" cellpadding="1" border="0">
		  <tr> 
			<td> 
			  <input class="text" type="checkbox" name="disable_smilies" <? if (!$option): echo 'checked'; endif;?> />			</td>
			<td><span class="body_text">Desactivar Emoticons </span></td>
		  </tr>
		</table>
       <?php
	  endif;
	  ?> 
      </td>
	</tr> 
	<tr> 
	  <td colspan="2" align="center" height="28">
	  
	  &nbsp;<input type="submit" accesskey="s" tabindex="6" name="post" class="button" value="Submeter" />
	&nbsp;<input type="submit" accesskey="d" tabindex="7" name="apagar" class="button" value="Apagar" />
	&nbsp;<input type="submit" class="button" name="duo_active" value="<?=$tmp;?>">	  </td>
	</tr>
<?php
else:
?>
	  <tr> 
		<td colspan="2" align="left" class="body_text"> 
		Na caixa de texto acima encontra-se uma lista com as nóticias que tem colocadas no site até a data. Escolha a notícia que pretende editar e clique de seguida no bot&atilde;o ver		</td>
	  </tr>
	  <tr height="100%"> 
		<td colspan="2"></td>
	  </tr>
<?php
endif;
 ?>
  </table>
</form>
