<?php
/*
File revision date: 2-Out-2006
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/
$module="
('Fisher Links', '', 'actions/fisher_links.php', 's',".$default_code." , 'no', 'N/A', ".$default_box_code.", 0),
('Gosta desta pagina', 'pt=gosta desta p&aacute;gina?||en=Like this page?', 'actions/like_this_page.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Recomendar o site', 'en=Recommend site||pt=Recomendar o site', 'actions/recommend_site.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Links de referencia ao site', '', 'actions/referral_links.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Top Referral', 'en=Top Referral||pt=Top Diario de referencias', 'actions/referral_top.php', 's',".$default_code." , 'no', 'N/A', ".$default_box_code.", 0)
";

?>