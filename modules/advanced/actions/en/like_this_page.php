<?php 
include_once('kernel/staticvars.php');
//////include_once('general/return_module_id.php');
$recommend=return_id('recommend_site.php');
$linkit=return_id('referral_links.php');
?>

<table width="100%" border="0">
  <tr>
    <td colspan="2" class="header_text_2">Do you like this page? </td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'];?>/modules/actions/images/sfavorites.gif" width="16" height="16" alt="Favorites"></td>
    <td><a class="body_text" href="javascript:window.external.AddFavorite('<?=$staticvars['site_path'].'/index.php';?>','<?=$site_name." - ".$page_title;?>')">Add to favorites...</a></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'];?>/modules/actions/images/shome.gif" width="16" height="16" alt="Start page"></td>
    <td><A class="body_text" style="BEHAVIOR: url(#default#homepage)" 
         onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('<?=$staticvars['site_path'].'/index.php';?>');" 
         href="<?=session($staticvars,$staticvars['site_path'].'/index.php');?>">Make it your start page...</A></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'];?>/modules/actions/images/srecommend.gif" width="16" height="16" alt="recommend"></td>
    <td><a class="body_text" href="<?=session($staticvars,'index.php?id='.$recommend);?>">Recommend...</a></td>
  </tr>
  
  <tr>
    <td><img src="<?=$staticvars['site_path'];?>/modules/actions/images/slink.gif" width="16" height="16" alt="link it"></td>
    <td><a class="body_text" href="#" onclick="window.external.AddSearchProvider('<?=$staticvars['site_path'];?>/modules/actions/add_search.xml');">IE7 - Add Search Provider ...</a> </td>
  </tr>
</table>


