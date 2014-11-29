<?php
/*
File revision date: 2-Out-2007
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/

$module="
('Livros - main', 'en=Books||pt=Livros', 'books/book_main.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Propor Livros', 'en=Book Proposal||pt=Propôr Livros', 'books/book_propose.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Livros Fisher Links', '', 'books/book_fisher_links.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0)
";

?>