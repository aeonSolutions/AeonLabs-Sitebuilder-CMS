<?php
/*
File revision date: 2-Out-2006
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/
$module="
('Mostra Noticias', 'pt=Notícias||en=News', 'news/main.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Gest&atilde;o de notícias', 'en=News management||pt=Gest&atilde;o de notícias', 'news/manage_news.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Editar noticias', 'en=Edit News||pt=Editar noticias', 'news/edit_news.php', 's', ".$auth_code.", 'no', 'N/A',".$default_box_code." , 0),
('Criar noticias', 'en=Create News||pt=Criar noticia', 'news/create_news.php', 's', ".$auth_code.", 'no', 'N/A',".$default_box_code." , 0)
";
?>