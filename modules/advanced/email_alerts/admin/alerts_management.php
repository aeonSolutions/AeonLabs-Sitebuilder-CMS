<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
$user=@$_GET['ut'];
if (isset($_POST['ut'])):
	$user=$_POST['ut'];
else:
	$user=@$_GET['ut'];
endif;
$task=@$_GET['id'];
$message='';
if (isset($_POST['add_alert_title']) or isset($_POST['alert_title']) or isset($_POST['box_code'])or isset($_POST['del_box'])):
	include($staticvars['local_root'].'modules/email_alerts/admin/alerts_setup.php');
endif;
?>
<font class="header_text_3">Configura&ccedil;&atilde;o dos Avisos do Site</font>
<br /><font class="body_text"><font color="#FF0000"><?=$message;?></font></font>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tbody><tr>
    <td valign="top"><br>
	<img src="<?=$staticvars['site_path'];?>/modules/email_alerts/images/alert.gif" alt="" width="34" height="34">
    </td>
    <td valign="center">
	<p><br>
	Gest&atilde;o dos avisos disponíveis aos utilizadores no site.
    </p></td>
  </tr>
</tbody></table>
<p>
<br>
</p>
<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
  <tr>
	<td align="center">
	<br>
		<form method="post" action="<?=session($staticvars,'index.php?id='.$task.'&nav=modules/email_alerts/admin/alerts_management.php');?>" enctype="multipart/form-data">
		<select size="1" name="ut" class="form_input">
			<?php
			$query=$db->getquery("select cod_alerts, descricao, titulo from alerts");
			$selected=0;
			$option[0][0]='';
			$option[0][1]='-----------------';
			if($query[0][0]<>''):
				for ($i=0;$i<count($query);$i++):
					$option[$i+1][0]=$query[$i][0];
					$option[$i+1][1]=$query[$i][2];
					if ($query[$i][0]==$user):
						$selected=$i;
					endif;
				endfor;
			endif;
			for ($i=0 ; $i<count($option); $i++):
				 if ($option[$i][0]=='optgroup'):
				 ?>
					<optgroup disabled label="<?=$option[$i][1];?>"></optgroup>
				 <?php
				 else:
					?>
					<option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
					<?php echo $option[$i][1]; ?></option>
				<?php
				endif;
			endfor; ?>
		</select>&nbsp;&nbsp; 
		<input type="image" src="<?=$staticvars['site_path'].'/images/buttons/'.$lang.'/';?>ver.gif" name="user_input">
		</form>
	<hr class="gradient">
		<a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&nav=modules/email_alerts/admin/alerts_management.php&type=add');?>">
		<img src="<?=$staticvars['site_path'];?>/modules/email_alerts/images/flash.gif" alt="" width="16" height="16" border="0">&nbsp;&nbsp;Adicionar </a>
	<hr class="gradient">
	</td>
  </tr>
  <tr>
	<td height="14" style="BACKGROUND-POSITION: right top; BACKGROUND-IMAGE: url(<?=$staticvars['site_path'].'/images/dividers/horz_divider.gif';?>); BACKGROUND-REPEAT: repeat-x;">&nbsp;</td>
  </tr>
  <tr>
	<td height="400" valign="top">
	<?php
		 include($staticvars['local_root'].'modules/email_alerts/admin/alerts_iframe/iframe_default.php');
	?>
	</td>
  </tr>
</table>
