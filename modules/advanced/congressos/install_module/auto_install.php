<?php
/*
File revision date: 30-jan-2009
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/


$module="
('Menu Congresso', 'en=Menu||pt=Menu', 'congressos/congress_menu.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Main Loader', 'en=Congress||pt=Congresso', 'congressos/congress_main.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Info Box', 'en=Info||pt=Info', 'congressos/congress_info.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Submissao de Resumos', 'en=Abstract Submission||pt=Submeter Resumo', 'congressos/abstract_submit.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Listagem', 'en=Listings||pt=Listagem', 'congressos/congress_listings.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Downloads', 'en=Donwloads||pt=Donwloads', 'congressos/downloads.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Review Papers', 'en=Review Papers||pt=Revisao de Artigos', 'congressos/review_papers.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Review Abstracts', 'en=Review Abstracts||pt=Revisao de Resumos', 'congressos/review_abstracts.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('User Management', 'en=User Management||pt=Gestao utilizadores', 'congressos/congress_config_users.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Config Deadlines', 'en=Deadlines Management||pt=Gestao datas importantes', 'congressos/congress_config_deadlines.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Config Categories', 'en=Categories Management||pt=Gestao Categorias', 'congressos/congress_config_cats.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Config Categories Modo Avançado', 'en=Categories Management||pt=Gestao de Categorias', 'congressos/congress_config_cats_adv.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('General Config', 'en=User Management||pt=Gestao utilizadores', 'congressos/congress_config_general.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Menu Config', 'en=Menu Management||pt=Gestao Menu', 'congressos/congress_config_menu.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Themes Config', 'en=Themes Management||pt=Gestao Temas', 'congressos/congress_config_themes.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Downloads Config', 'en=Downloads Management||pt=Gestao Downloads', 'congressos/congress_config_downloads.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Revisors Config', 'en=Revisors Management||pt=Gestao Revisores', 'congressos/congress_config_revisors.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Estatisticas', 'en=Statistics||pt=Estatísticas', 'congressos/statistics.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Submissao de Artigos', 'en=Paper Submission||pt=Submeter Artigo', 'congressos/paper_submit.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0)
";
?>