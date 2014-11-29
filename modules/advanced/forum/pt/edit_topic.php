<?php
$bar=@include('general/site_handler.php');
if (!$bar):
	// erro possible hack
	exit;
endif; 
$task=@$_GET['id'];
$sid=@$_GET['SID'];
include('kernel/staticvars.php');

//implementing security measures
if (isset($_POST['cod_topic'])):
	$cod_topic=mysql_escape_string($_POST['cod_topic']); 
else:
	$link=session($staticvars,'index.php?id='.return_id('forum.php'));
	header("Location: ".$link);
	?>
	<script language="javascript">
		parent.location="<?=$link;?>"
	</script>
	<?php
	exit;
endif;
$topic=$db->getquery("select cod_forum,cod_user, assunto,mensagem,emoticons from forum_topic where cod_topic='".$cod_topic."'");
if($topic[0][0]==''):
 echo 'Error 1';
 exit;
endif;
if($topic[0][4]=='1'):
	$option=1;
else:
	$option=0;
endif;
$admin_code=$db->getquery("select cod_user_type from user_type where name='Administrators'");
if ($admin_code[0][0]<>''):
	$admin_code=$admin_code[0][0];
else:
	$admin_code=-1;
endif;
if (isset($_SESSION['user'])):
	$auth_user=$db->getquery("select cod_user_type,cod_user from users where nick='".mysql_escape_string($_SESSION['user'])."'");
	if ($auth_user[0][0]<>''):
		echo $auth_user[0][1];
		$user_code=$auth_user[0][1];
		$auth_user=$auth_user[0][0];
	else:
		$auth_user=-2;
		$user_code=-2;
	endif;
else:
	$auth_user=-2;
	$user_code=-2;
endif;
if ($auth_user==$admin_code):
	$admin_logged=true;
else:
	$admin_logged=false;
endif;
if($user_code==-2):
	$link=session($staticvars,'index.php?id='.return_id('forum.php'));
	header("Location: ".$link);
	?>
	<script language="javascript">
		parent.location="<?=$link;?>"
	</script>
	<?php
	exit;
elseif($user_code<>$topic[0][1] and $admin_logged==false):
	$link=session($staticvars,'index.php?id='.return_id('forum.php'));
	header("Location: ".$link);
	?>
	<script language="javascript">
		parent.location="<?=$link;?>"
	</script>
	<?php
	exit;
endif;
//end of security measures

if (isset($_POST['subject']) and isset($_POST['message']) ):
	$option=1;
	if (isset($_POST['disable_smilies'])):
		$option=0;
	endif;	
	if (isset($_POST['preview'])):
		$_SESSION['message']=$_POST['message'];
		$_SESSION['subject']=$_POST['subject'];
		$_SESSION['option']=$option;
		$link=session($staticvars,'modules/forum/system/preview.php');
		?>
		<script language="javascript">
		window.open( "<?=$link;?>", "Preview", "status = 1, height = 500, width = 800, resizable = 0, scrollbars=yes" )
		
		</script>	
		<?php
	elseif (isset($_POST['post'])):
		$user=$db->getquery("select cod_user from users where nick='".$_SESSION['user']."'");
		$db->setquery("update forum_topic set assunto='".mysql_escape_string($_POST['subject'])."',
		 mensagem='".mysql_escape_string($_POST['message'])."', emoticons='".$option."',
		 cod_forum='".mysql_escape_string($topic[0][0])."' where cod_topic='".mysql_escape_string($cod_topic)."'");
		$link=session($staticvars,'index.php?id='.return_id('forum.php').'&view='.$topic[0][0]);
		?>
		<script language="javascript">
			window.alert("Tópico editado e adicionado com sucesso ao Forum!");
			parent.location="<?=$link;?>"
		</script>
		
		<?php			
	endif;
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
$forum_name=$db->getquery("select nome from forum_forum where cod_forum='".$topic[0][0]."'");
$forum_name=$forum_name[0][0];
?>
<script language="javascript">
// Helpline messages
b_help = "Texto Negrito: [b]texto[/b]  (alt+b)";
i_help = "Texto it&aacute;lico: [i]texto[/i]  (alt+i)";
u_help = "Texto sublinhado: [u]texto[/u]  (alt+u)";
q_help = "Texto citado: [quote]texto[/quote]  (alt+q)";
c_help = "Marca de código: [code]código[/code]  (alt+c)";
l_help = "Lista: [list]texto;texto;texto[/list] (alt+l)";
p_help = "Inserir imagem: [img]http://url_da_imagem[/img]  (alt+p)";
w_help = "Inserir URL: [url]http://url[/url] ou [url=http://url]URL texto[/url]  (alt+w)";
a_help = "Fechar todas as marcas de bbCode";
s_help = "Cor: [color=red]texto[/color] ";
f_help = "Fonte: [size=x-small]texto pequeno[/size]";
</script>
<SCRIPT src="<?=$staticvars['site_path'].'/modules/forum/system/bbcode.js';?>" type=text/javascript></SCRIPT>

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><img src="<?=$staticvars['site_path'].'/modules/forum/images/'.$lang.'/edit_post.gif';?>" /></td>
  </tr>
	
	<tr>
	  <td>
		<form action="<?=session($staticvars,'index.php?id='.$task.'&forum='.$topic[0][0]);?>" method="post" enctype="multipart/form-data" name="post" onsubmit="return checkForm(this)">
		<input type="hidden" name="cod_topic" value="<?=$cod_topic;?>"/>
		<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
			
			<tr> 
				<td class="body_text" align="right"><b>Utilizador:</b></td>
				<td class="body_text"><?=$usr;?></td>
			</tr>
			<tr>
				<td class="body_text" align="right"><b>Forum:</b></td>
				<td class="body_text"><?=$forum_name;?></td>
			</tr>
			<tr> 
			  <td class="body_text" width="22%"><div align="right"><span class="body_text"><strong>Assunto</strong></span></div></td>
			  <td class="body_text" width="78%"> <span class="body_text"><span class="body_text">
				<input type="text" name="subject" size="25" maxlength="60" style="width:100%" tabindex="2" class="body_text" value="<?=$topic[0][2];?>" />
			  </span></span> </td>
			</tr>
			<tr> 
			  <td align="center" valign="middle" class="body_text">
			  <table width="100" border="0" cellspacing="0" cellpadding="5">
				<tr align="center" valign="middle">
				  <td>
					<table width="100" border="0" align="center" cellpadding="5" cellspacing="0">
					  <tr align="center">
						<td colspan="4" class="body_text"><b>Emoticons</b></td>
					  </tr>
					  <tr align="center" valign="middle">
						<td><a href="javascript:emoticon(':D')"><img src="modules/forum/images/smiles/icon_biggrin.gif" border="0" alt="Very Happy" title="Very Happy" /></a></td>
						<td><a href="javascript:emoticon(':)')"><img src="modules/forum/images/smiles/icon_smile.gif" border="0" alt="Smile" title="Smile" /></a></td>
						<td><a href="javascript:emoticon(':(')"><img src="modules/forum/images/smiles/icon_sad.gif" border="0" alt="Sad" title="Sad" /></a></td>
						<td><a href="javascript:emoticon(':o')"><img src="modules/forum/images/smiles/icon_surprised.gif" border="0" alt="Surprised" title="Surprised" /></a></td>
					  </tr>
					  <tr align="center" valign="middle">
						<td><a href="javascript:emoticon(':shock:')"><img src="modules/forum/images/smiles/icon_eek.gif" border="0" alt="Shocked" title="Shocked" /></a></td>
						<td><a href="javascript:emoticon(':?')"><img src="modules/forum/images/smiles/icon_confused.gif" border="0" alt="Confused" title="Confused" /></a></td>
						<td><a href="javascript:emoticon('8)')"><img src="modules/forum/images/smiles/icon_cool.gif" border="0" alt="Cool" title="Cool" /></a></td>
						<td><a href="javascript:emoticon(':lol:')"><img src="modules/forum/images/smiles/icon_lol.gif" border="0" alt="Laughing" title="Laughing" /></a></td>
					  </tr>
					  <tr align="center" valign="middle">
						<td><a href="javascript:emoticon(':x')"><img src="modules/forum/images/smiles/icon_mad.gif" border="0" alt="Mad" title="Mad" /></a></td>
						<td><a href="javascript:emoticon(':P')"><img src="modules/forum/images/smiles/icon_razz.gif" border="0" alt="Razz" title="Razz" /></a></td>
						<td><a href="javascript:emoticon(':oops:')"><img src="modules/forum/images/smiles/icon_redface.gif" border="0" alt="Embarassed" title="Embarassed" /></a></td>
						<td><a href="javascript:emoticon(':cry:')"><img src="modules/forum/images/smiles/icon_cry.gif" border="0" alt="Crying or Very sad" title="Crying or Very sad" /></a></td>
					  </tr>
					  <tr align="center" valign="middle">
						<td><a href="javascript:emoticon(':evil:')"><img src="modules/forum/images/smiles/icon_evil.gif" border="0" alt="Evil or Very Mad" title="Evil or Very Mad" /></a></td>
						<td><a href="javascript:emoticon(':twisted:')"><img src="modules/forum/images/smiles/icon_twisted.gif" border="0" alt="Twisted Evil" title="Twisted Evil" /></a></td>
						<td><a href="javascript:emoticon(':roll:')"><img src="modules/forum/images/smiles/icon_rolleyes.gif" border="0" alt="Rolling Eyes" title="Rolling Eyes" /></a></td>
						<td><a href="javascript:emoticon(':wink:')"><img src="modules/forum/images/smiles/icon_wink.gif" border="0" alt="Wink" title="Wink" /></a></td>
					  </tr>
					  <tr align="center" valign="middle">
						<td><a href="javascript:emoticon(':!:')"><img src="modules/forum/images/smiles/icon_exclaim.gif" border="0" alt="Exclamation" title="Exclamation" /></a></td>
						<td><a href="javascript:emoticon(':?:')"><img src="modules/forum/images/smiles/icon_question.gif" border="0" alt="Question" title="Question" /></a></td>
						<td><a href="javascript:emoticon(':idea:')"><img src="modules/forum/images/smiles/icon_idea.gif" border="0" alt="Idea" title="Idea" /></a></td>
						<td><a href="javascript:emoticon(':arrow:')"><img src="modules/forum/images/smiles/icon_arrow.gif" border="0" alt="Arrow" title="Arrow" /></a></td>
					  </tr>
					  <tr align="center">
						<td><a href="javascript:emoticon(':|')"><img src="modules/forum/images/smiles/icon_neutral.gif" border="0" alt="Neutral" title="Neutral" /></a></td>
						<td><a href="javascript:emoticon(':mrgreen:')"><img src="modules/forum/images/smiles/icon_mrgreen.gif" border="0" alt="Mr. Green" title="Mr. Green" /></a></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
				  </table></td>
				</tr>
			  </table></td>
			  <td class="body_text" valign="top"><span class="body_text"> <span class="body_text"> </span> 
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
						  <select class="body_text" name="addbbcode18" onChange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('s')">
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
						  </select>&nbsp;Fonte:<select class="body_text" name="addbbcode20" onChange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
							  <option value="7" class="body_text">Minúscula</option>
							  <option value="9" class="body_text">Pequena</option>
							  <option value="12" selected class="body_text">Normal</option>
							  <option value="18" class="body_text">Grande</option>
							  <option  value="24" class="body_text">Enorme</option>
							</select>
							</span></td>
						  <td width="22%" align="right" nowrap="nowrap"><span class="body_text"><a href="javascript:bbstyle(-1)" class="body_text" onMouseOver="helpline('a')">Fechar marcas</a></span></td>
						</tr>
					  </table>					</td>
				  </tr>
				  <tr align="center" valign="middle"> 
					<td height="50" colspan="8"> <span class="body_text"> 
					  <input type="text" name="helpbox" size="45" maxlength="100" style="width:100%; font-size:10px; text-align:center; background-color:#E3E3E3; border:none;" class="helpline" value="Ideia: Estilos podem ser aplicados rapidamente a texto seleccionado" />
					  </span></td>
				  </tr>
				  <tr> 
					<td colspan="8"><span class="body_text"> 
					  <textarea name="message" rows="15" cols="25" wrap="virtual" style="width:100%" tabindex="3" class="body_text" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"><?=$topic[0][3];?></textarea>
					  </span></td>
				  </tr>
				</table>
				</span></td>
			</tr>
			<tr> 
			  <td class="body_text" valign="top"><span class="body_text"><b>Op&ccedil;&otilde;es</b></span><br />
			  <span class="body_text">&nbsp;&nbsp;&nbsp;<? if ($option): echo 'Smiles activado'; else: echo 'Smiles desactivado'; endif;?></span></td>
			  <td class="body_text"><span class="body_text"> </span> 
				<table cellspacing="0" cellpadding="1" border="0">
				  <tr> 
					<td> 
					  <input type="checkbox" name="disable_smilies" <? if (!$option): echo 'checked'; endif;?> />					</td>
					<td><span class="body_text">Desactivar Emoticons </span></td>
				  </tr>
				</table>			  </td>
			</tr> 
			<tr> 
			  <td class="catBottom" colspan="2" align="center" height="28">
			  <input type="submit" tabindex="5" name="preview" class="form_submit" value="Prever" />&nbsp;
			  <input type="submit" accesskey="s" tabindex="6" name="post" class="form_submit" value="Submeter" /></td>
			</tr>
		  </table>
		</form>	  </td>
  </tr>
		  <tr>
		    <td height="25" valign="bottom"><div align="center"></div></td>
		  </tr>
</table>
