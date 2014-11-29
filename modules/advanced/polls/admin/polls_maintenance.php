<?php 
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Content Management';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
$task=@$_GET['id'];
$cod=@$_GET['cod'];
if ($cod==''):
	$cod='none';
endif;
$type=@$_GET['type'];
if ($type==''):
	$type=3;
endif;
$address=strip_address("type",$_SERVER['REQUEST_URI']);
if (isset($_POST['polls_del']) or isset($_POST['polls_active']) or isset($_POST['polls_title'])):
	include($staticvars['local_root'].'modules/polls/system/polls_update_db.php');
	$address=strip_address("update",$_SERVER['REQUEST_URI']);
	session_write_close();
	header("Location:".$address);	
	exit;
endif;
?>
  <SCRIPT LANGUAGE="JavaScript">
  <!--
  function ChangeAction() {
    var number = document.edit_poll.polls_dropdown.selectedIndex;
    document.edit_poll.action ='<?=$address."&type=1";?>&cod='+document.edit_poll.polls_dropdown.options[number].value;
	document.edit_poll.submit();
  }
  // -->
</SCRIPT>
<table border="0" cellpadding="3" width="100%">
	  <tr>
		<td valign="top" width="39"><img src="<?=$staticvars['site_path'];?>/modules/polls/images/icon_polls.jpg" alt="Colocar nota informativa"/></td>
		<td valign="bottom" align="left" class="header_text_1"><font class="header_text_3">Gest&atilde;o de inqu&eacute;ritos</font><br></td>
	</tr>
</table><br />
<table class="main_module_table_body" width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="25" colspan="3" valign="bottom"><div align="center"></div></td>
		  </tr>
		  <tr>
			<td width="20">&nbsp;
			</td>
		    <td>
                <fieldset><legend class="header_text_1">.: Editar \ Apagar :.</legend>
                  <form name="edit_poll" id="edit_poll" action="<?=$address.'&type=1&update=7';?>" method="post" enctype="multipart/form-data">
			<?php
			if ($type==1):
				$query=$db->getquery("select cod_poll, name, active, questions from polls");
				if ($query[0][0]==''):
						echo "<font class='body_text'>N&atilde;o existem vota&ccedil;&otilde;es.</font>";				
				else:
					$option[0][0]='-------';
					$option[0][1]='-----------------------------';
					$selected=0;
					for ($i=0;$i<count($query);$i++):
						$option[$i+1][0]=$query[$i][0];
						$option[$i+1][1]=$query[$i][1];
						if (($query[$i][2]=='s' and $cod=='none') or $query[$i][0]==$cod):
							$selected=$i+1;
						endif;
					endfor;
					if ($query[$selected-1][2]=='s'):
						$name='polls_inactive';
						$value=' Desactivar ';
					else:
						$name='polls_active';
						$value=' Activar ';
					endif;
					?>
                    Inquérito:&nbsp;<select name="polls_dropdown" class="form_input"  onChange="ChangeAction();"> <?php
                    for ($i=0 ; $i<count($option); $i++):
                        ?>
                        <option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
                        <?php echo $option[$i][1]; ?></option>
                    <?php
                    endfor; ?>
	              </select>
                  <br />
				  <br />
                    <?php
					if ($selected>0):
					?>
                        Pergunta:&nbsp;<input name="polls_title" type="text" value="<?=$query[$selected-1][1];?>" size="50" maxlength="100" />
                      <br />
                      <br />
                      <br />
                      <font class='body_text'>Introduza as respostas de vota&ccedil;&atilde;o,separadas por virgula.</font>
                      <br />
                      Respostas:&nbsp;
                      <textarea name="polls_questions" cols="40" rows="3"><?=$query[$selected-1][3];?></textarea>
                      <br />
                      <br />
                      <input type="submit" class="form_submit" value=" Modificar " name="polls_add" />&nbsp;&nbsp;&nbsp;
                      <input type="submit" class="form_submit" value="<?=$value;?>" name="<?=$name;?>" />&nbsp;&nbsp;&nbsp;
                      <input type="submit" class="form_submit" value=" Apagar " name="polls_del" />&nbsp;&nbsp;&nbsp;
                      <?php
					endif;
				endif;
			else:
				echo('<div align="center"><font size="2" font="verdana" color="#2c4563"><a href="'.$address.'&type=1'.'"> Clique aqui para Editar um Inquérito</a></font></div>');
			endif;
			?>
             </form>
             </fieldset>
			</td>
		    <td width="20">&nbsp;</td>
		  </tr>
		  <tr>
		    <td height="25" colspan="3" valign="bottom"><div align="center"></div></td>
		  </tr>
		  <tr>
			<td width="20">&nbsp;
			</td>
		    <td>
                <fieldset><legend class="header_text_1">.: Adicionar :.</legend>
                <form name="add_poll" id="add_poll" action="<?=$address.'&type=2&update=8';?>" method="post" enctype="multipart/form-data">
			<?php
			if ($type==2):
			?>
                Pergunta:&nbsp;<input name="polls_title" type="text" size="50" maxlength="100" />
              <br />
              <br />
              <br />
              <font class='body_text'>Introduza as respostas de vota&ccedil;&atilde;o,separadas por virgula.</font>
              <br />
              Respostas:&nbsp;
              <textarea name="polls_questions" cols="40" rows="3"></textarea>
              <br />
              <br />
              <input type="submit" class="form_submit" value=" Criar inquérito " name="polls_send" />
                <?php
			else:
				echo('<div align="center"><font size="2" font="verdana" color="#2c4563"><a href="'.$address.'&type=2'.'"> Clique aqui para Adicionar um Inquérito</a></font></div>');
			endif;
			?></form></fieldset></td>
		    <td width="20">&nbsp;</td>
		  </tr>
		  <tr>
		    <td height="25" colspan="3" valign="bottom"></td>
		  </tr>
</table>

