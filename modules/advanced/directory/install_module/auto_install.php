<?php
/*
File revision date: 2-Out-2006
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/

$module="
('Directory - vers&atilde;o reduzida', 'en=Directory||pt=Directório', 'directory/directory_main.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Directório', 'en=Directory Browsing||pt=Directório', 'directory/directory_browsing.php', 's', ".$default_code.", 'yes', 'N/A', ".$default_box_code.", 0),
('Adicionar Conteúdos', 'en=Add Content||pt=Adicionar conteúdos', 'directory/ds_add_item.php', 's', ".$auth_code.", 'yes', 'N/A', ".$default_box_code.", 0),
('Editar Conteúdos', 'en=Edit Contents||pt=Editar conteúdos', 'directory/ds_my_items.php', 's', ".$auth_code.", 'yes', 'N/A', ".$default_box_code.", 0),
('Top', 'en=Top Directory||pt=Top Directório', 'directory/top_main.php', 's', ".$default_code.", 'yes', 'N/A', ".$default_box_code.", 0),
('P&aacute;ginas', 'en=webpage||pt=P&aacute;gina Web', 'directory/ds_webpages.php', 's', ".$default_code.", 'yes', 'N/A', ".$default_box_code.", 0),
('Pesquisas R&aacute;pidas no directório', 'en=Directory Search||pt=Pesquisar', 'directory/quick_search.php', 's', ".$default_code.", 'yes', 'N/A', ".$default_code.", 0),
('Pesquisa Avan&ccedil;ada no directório', 'en=Directory Search||pt=Pesquisar', 'directory/advanced_search.php', 's', ".$default_code.", 'yes', 'N/A', ".$default_code.", 0),
('Detalhes do item', 'en=Content Details||pt=Conteúdo', 'directory/ds_files.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 2)
";

?>