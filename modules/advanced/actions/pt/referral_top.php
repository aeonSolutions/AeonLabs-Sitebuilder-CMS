<?php 
include_once('kernel/staticvars.php');
$ref=$db->getquery("select link,contador,total from stats_referral where dia='".date('d')."' order by contador DESC limit 0,3");
if ($ref[0][0]<>''):
?>
<table width="100%" border="0">
  <tr>
    <td colspan="2" class="header_text_2">Top diário de refer&ecirc;ncias </td>
  </tr>
 <?php
 for ($i=0;$i<count($ref);$i++): 
	$text=$ref[$i][0];
	$text=str_replace('http://','',$text);
	$rt=explode('/',$text);
	if(isset($rt[0])):
		$text=$rt[0];
	endif;
	?>
	  <tr>
		<td valign="top"><img src="<?=$staticvars['site_path'];?>/modules/actions/images/slink.gif" width="16" height="16" alt="Link"></td>
		<td valign="top" class="body_text"><a class="body_text" href="<?=$ref[$i][0];?>" target="_blank"><?=$text;?></a><br />
		(hoje:<?=$ref[$i][1];?>;total:<?=$ref[$i][2];?>)</td>
	  </tr>
	<?php
endfor;
?>
</table>
<?php
else:
?>
<table width="100%" border="0">
  
  <tr>
    <td colspan="2" class="header_text_2">Top diário de refer&ecirc;ncias </td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'];?>/modules/actions/images/slink.gif" width="16" height="16" alt="Link"></td>
    <td class="body_text">Sem referencias</td>
  </tr>
</table>
<?php
endif;
?>