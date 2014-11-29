<?php
/*
File revision date: 13-mar-2008
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/
$module="
('Eventos - Main', 'pt=Eventos||en=events', 'eventos/main.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Editar eventos', 'en=Edit events||pt=Editar eventos', 'eventos/edit_eventos.php', 's', ".$auth_code.", 'no', 'N/A',".$default_box_code." , 0),
('Criar eventos', 'en=Create events||pt=Criar eventos', 'eventos/create_eventos.php', 's', ".$auth_code.", 'no', 'N/A',".$default_box_code." , 0)
";
?>