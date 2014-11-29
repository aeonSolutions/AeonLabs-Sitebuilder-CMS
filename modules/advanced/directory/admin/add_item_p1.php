<?php
/*
File revision date: 25-Set-2006
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found (add item p1)';
	exit;
endif;
$address=strip_address('type',$_SERVER['REQUEST_URI']);
$address=strip_address('cod',$address);
$address=strip_address('step',$address);
?>
	<table border="0" align="left" width="100%">
		<tr>
		 <td>
		   <table border="0">
		     <tr>
		       <td width="23" height="23"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_completed.jpg" width="23" height="23" /></td>
		       <td width="23" height="23"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_off.jpg" width="23" height="23" /></td>
		       <td width="23" height="23"><img src="<?=$staticvars['site_path'];?>/modules/directory/images/icon_off.jpg" alt="o" width="23" height="23" /></td>
	         </tr>
	       </table>
		</td>
		</tr>
		<tr>
		<td ><div class="bxthdr">1 - Condi&ccedil;&otilde;es de publica&ccedil;&atilde;o </div></td>
		</tr>
		<tr>
		<td >
		  <p align="left">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Se j&aacute; conhece o direct&oacute;rio, deve ter reparado que existem alguns conte&uacute;dos que deveriam estar incluidos noutra categoria.<br />
			<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Assim e para melhor servir os utilizadores deste site (e a si próprio),
			na p&aacute;gina seguinte, demore o tempo que entender necess&aacute;rio a procurar a categoria que melhor serve  o conteúdo que pretende adicionar. Lembre-se que ao ajudar os outros est&aacute; a ajudar-se a si pr&oacute;prio. <br />
			<br />
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para finalizar, indique um titulo bem ilustrativo, o autor e uma breve descri&ccedil;&atilde;o que defina adequadamente o que est&aacute; a partilhar com a comunidade.<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			</p>
		  <form action="<?=$address.'&type='.$type;?>" enctype="multipart/form-data" method="post">
            <div align="left">
              <?php
			if ($type==''):?>
              <img src="<?=$staticvars['site_path'];?>/modules/directory/images/clip_check.gif" width="15" height="12" />&nbsp;Come&ccedil;e por indicar o tipo de conte&uacute;do que pretende inserir, podem ser colocados diversos tipos de arquivos, links ou mesmo p&aacute;ginas de internet. <br />
              <font class="body_text"><strong>Tipo</strong></font>&nbsp;&nbsp;&nbsp;
              <select size="1" name="type" class="form_input">
                <?php
					$query=$db->getquery("select cod_items_types, nome from items_types where tipos<>'modulo'");
					$selected=0;
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
              </select>
              &nbsp;&nbsp;
              <?php
				endif;
				?>
            </div>
		    <br />
            <?php
				if ($enable_user_groups):
				?>
            <img src="<?=$staticvars['site_path'];?>/modules/directory/images/clip_check.gif" width="15" height="12" />&nbsp;Pode tamb&eacute;m de definir quem &eacute; que vai poder ter acesso ao conte&uacute;do que est&aacute; agora a colocar <br />
            <font class="body_text">O conte&uacute;do a colocar vai estar visivel para </font>
            <select size="1" name="user_group" class="form_input" >
              <?php
				$query=$db->getquery("select cod_user_type, name from user_type");
				unset($option);
				$option[0][0]='0';
				$option[0][1]='TODOS';
				if ($query[0][0]<>''):
					for ($i=0;$i<count($query);$i++):
						$option[$i+1][0]=$query[$i][0];
						$option[$i+1][1]=$query[$i][1];
					endfor;
					for ($i=0 ; $i<count($option); $i++):
						?>
					  <option value="<?php echo $option[$i][0];?>">
					  <?=$option[$i][1]; ?>
					  </option>
					  <?php
					endfor;
				else:?>
					<option value="&lt;0">o meu grupo apenas</option>
					<?php
				endif;?>
            </select>
            <?php
				else:
					?>
            <input type="hidden" name="user_group" value="0" />
            <?
				 endif;
				 ?>
            <div align="right">
              <input type="submit" name="add_item_p1" value="Continuar" class="form_submit" />
            </div>
	      </form></td>
		</tr>
	</table>
