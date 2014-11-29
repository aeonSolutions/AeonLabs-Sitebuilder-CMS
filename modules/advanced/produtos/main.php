<?php
if (isset($_GET['navigate'])):
	$page_to_open=$staticvars['local_root'].'modules/produtos/'.$_GET['navigate'].'/main.php';
	if(!is_file($page_to_open)):
		$page_to_open='';
	endif;
else:
	$page_to_open='';
endif;
if ($page_to_open<>''):
	include($page_to_open);
else:
?>
<h3 style="border-bottom:solid 2px"> Produtos</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="71"><a href="<?=session($staticvars,$staticvars['site_path'].'/index.php?id=21&navigate=atsutaro');?>"><img src="<?=$staticvars['site_path'];?>/modules/produtos/images/atsutaro.jpg" width="71" height="53" border="0" /></a></td>
    <td width="10" rowspan="3">&nbsp;</td>
    <td>Colector Solar Atsu Taro</td>
  </tr>
  <tr>
    <td width="71">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="71">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php
endif;
?>