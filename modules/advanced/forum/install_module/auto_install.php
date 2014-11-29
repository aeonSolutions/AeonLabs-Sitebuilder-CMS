<?php
/*
File revision date: 2-Out-2006
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/

$module="
('Forum', 'en=Forum||pt=Forum', 'forum/forum.php', 's', ".$default_code.", 'yes', 'N/A', ".$default_box_code.", 0),
('forum - Main page', '', 'forum/display_bate.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Adicionar topicos/Respostas ao forum', 'pt=Adicionar Tópico||en=Add Topic', 'forum/new_topic.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Editar Tópicos no forum', 'pt=Editar tópico||en=Edit Post', 'forum/edit_topic.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0)
";
?>