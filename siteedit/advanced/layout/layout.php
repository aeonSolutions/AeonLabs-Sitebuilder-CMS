<?php 
if(isset($_GET['id'])):
	$task=$db->prepare_query($_GET['id']);
endif;
if(isset($_GET['mod'])):
	$mod=$db->prepare_query($_GET['mod']);
endif;
if(isset($_POST['skin'])):
	$skin=$db->prepare_query($_POST['skin']);
else:
	$skin=isset($_GET['skin']) ? $db->prepare_query($_GET['skin']) : '';
endif;
$query=$db->getquery("select ficheiro from skin where cod_skin='".$skin."'");
if($query[0][0]<>''):
	$file=$query[0][0];
else:
	$query=$db->getquery("select cod_skin, ficheiro from skin where active='s'");
	if($query[0][0]<>''):
		$skin=$query[0][0];
		$file=$query[0][1];
	else:
		$globvars['warnings']='layout not found on DB Server! You need to install one first to edit CMS';
		add_error($globvars['warnings'],__LINE__,__FILE__);
		$globvars['error']['critical']=true; // true if critical error occurs and code execution is not allowed
		$globvars['error']['type']='exclamation';// type in {exclamation, question, info, prohibited}
		if($globvars['error']['critical']):
			$_SESSION['cerr']=true;
			sleep(1);
			header("Location: ".session_setup($globvars,"index.php"));
			exit;
		endif;
	endif;	
endif;
if (isset($_POST['del_full']) or isset($_POST['del_pos']) or isset($_POST['drop_add']) or isset($_POST['max_pos'])):
	include($local_root.'update_db/layout_setup.php');
endif;
include($globvars['site']['directory'].'kernel/settings/layout.php');
			if(isset($_GET['mode'])):
				if ($_GET['mode']=='wizard'):
					$address=strip_address($local_root,"step",$_SERVER['REQUEST_URI']);
					$address=strip_address($local_root,"file",$address);
					if (isset($_GET['step'])):
						$step=$_GET['step']+1;
					else:
						$step=$step+1;
					endif;
					$address=$address.'&step='.$step;
					?>
					<img src="<?=$site_path;?>/images/button_ok.png" alt="ok"  height="32"/>Se j&aacute; acabou de configurar o Layout, Clique <a href="<?=$address;?>">aqui</a> para continuar o Wizard. <?php
				endif;
			endif;
			?>	</font>
				<table style="border: 1px dotted #999999" cellpadding="0" cellspacing="0" align="center" width="90%">
					<tr>
						<td>
							<?php
                            if ($layout<>'dynamic'):	
                                $skin=1;
                            endif;
							if ($mod<>'' and $skin<>''):
								include($globvars['local_root'].'wizard/advanced/contents/layout_edit_cell.php');
							else:
							// develop AJAX CODE HERE
								echo'<IFRAME name="target_iframe" align="center" frameBorder="0" width="100%" height="800" src="'.$globvars['site_path'].'/wizard/advanced/contents/layout_frame.php?id='.$_GET['id'].'&SID='.$_GET['SID'].'&file='.$file.'&skin='.$skin.'" scrolling="auto"></IFRAME>';
							endif;
                            ?>
						</td>
					</tr>
					<?php
					if ($mod==''):
						?>
						<tr>
						  <td height="5"></td>
						</tr>
						<tr>
						  <td height="5" align="center">
							<table height="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td align="center">
									<?
									if ($layout=='dynamic'):	
										$query=$db->getquery("select ficheiro, cod_skin from skin where active='s'");
										if ($query[0][0]<>''):
											if ($skin==''):
												$skin=$query[0][1];	
											endif;
											$selected=$query[0][0];
										else:
											$selected='n&atilde;o existe nenhuma skin activa';
										endif;
										$query2=$db->getquery("select cod_skin, ficheiro, num_cells, default_cell from skin");
										$selected=0;
										$option[0][0]='none';
										$option[0][1]='--------------------';
										if ($query2[0][0]<>''):
											for ($i=1;$i<=count($query2);$i++):
												$option[$i][0]=$query2[$i-1][0];
												$option[$i][1]=$query2[$i-1][1];
												if ($skin==$query2[$i-1][0]):
													$selected=$i;
												endif;
											endfor;
										endif;
									else:
										$selected=0;
										$option[0][0]=$layout_name;
										$option[0][1]=$layout_name;
										$query2[0][0]=1;
									endif;
									?>
									<form  method="post" action="<?=session_setup($globvars,$site_path.'/index.php?&id='.$task);?>"  enctype="multipart/form-data">
									<select size="1" name="skin" class="form_input">
										<?php
										for ($k=0 ; $k<count($option); $k++):
											?>
											<option value="<?php echo $option[$k][0];?>" <?php if ($selected==$k){?>selected<?php } ?>>
											<?php echo $option[$k][1]; ?></option>
											<?php
										endfor; ?>
									</select>&nbsp;&nbsp;
									<input class="form_submit" value=" view " type="submit" <? if($layout=='static') echo ' disabled="disabled"';?> name="user_input">
									</form>
									</td>
								</tr>
							</table>
						  </td>
						</tr>
						<tr>
						  <td height="5"></td>
						</tr>
						<tr>
						  <td height="5" align="center">
							<?php
							if ($query2[0][0]<>'' and $layout<>'static'):									
							?>
							<form  method="post" action="<?=session_setup($globvars,$site_path.'/index.php?&id='.$task);?>"  enctype="multipart/form-data">
							<table height="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td align="center">
									<input type="hidden" value="<?=$skin;?>" name="skin" />
									<input type="checkbox" name="del_full">
									<font class="body_text">Apagar por completo o layout da skin actual:&nbsp;</font>
									<input type="image" src="<?=$globvars['site_path'].'/images/buttons/en/';?>apagar.gif">
									</td>
								</tr>
							</table>
							</form>
							<?php
							endif;
							?>
						  </td>
						</tr>
					<?php
					endif;
					?>
				</table>
