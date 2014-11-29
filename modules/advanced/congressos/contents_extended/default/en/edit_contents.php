<?php
if(isset($_GET['mnu'])):
	$mnu=mysql_escape_string($_GET['mnu']);
	$menu=$db->getquery("select cod_category, cod_module from congress_menu where cod_menu='".$mnu."'");
else:
	$menu=$db->getquery("select cod_category from congress_category where folder='mainpage'");
endif;
$link=session($staticvars,'index.php?id='.return_id('congress_config_cats_adv.php').'&cat='.$menu[0][0]);
?>
<h3>To edit this page click <a href="<?=$link;?>">here</a></h3>