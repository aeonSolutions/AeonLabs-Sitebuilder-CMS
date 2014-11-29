<?php
$random=rand(1,2);
if ($random==1):
	include($staticvars['local_root'].'modules/varity/adsense_referral_banner.php');
else:
	include($staticvars['local_root'].'modules/varity/caminho.php');
endif;
?>
