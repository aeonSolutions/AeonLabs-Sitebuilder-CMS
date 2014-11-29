<?php
/*
File revision date: 2-Out-2007
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/

$module="
('Dicionário - main', 'en=Dictionary||pt=Dicionário', 'dictionary/dic_main.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Propor Dicionário', 'en=Dictionary Proposal||pt=Propôr Dicionário', 'dictionary/dic_propose.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Dicionário Fisher Links', '', 'dictionary/dic_fisher_links.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0)
";

?>