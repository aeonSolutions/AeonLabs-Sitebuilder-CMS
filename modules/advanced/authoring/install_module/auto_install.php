<?php
/*
File revision date: 30-jan-2009
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/


$module="
('Autentica&ccedil;&atilde;o no site', 'en=User Login||pt=Autentica&ccedil;&atilde;o no site', 'authoring/login.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Recupera&ccedil;&atilde;o da password', 'en=Retrieve password||pt=recupera&ccedil;&atilde;o da password', 'authoring/lost_pass.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Criar nova conta no site', 'en=create an account||pt=criar nova conta', 'authoring/new_register.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Edi&ccedil;&atilde;o do perfil de utilizador', 'en=Edit profile||pt=Editar perfil utilizador', 'authoring/profile_edit.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Login Lateral', 'en=Site Autentication||pt=Area Reservada', 'authoring/lateral_login.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Registo novo utilizador com sucesso', 'en=Success Register||pt=Registo com sucesso', 'authoring/success_register.php', 's', ".$guest_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Necessita de autentica&ccedil;&atilde;o', 'en=Login Requiered||pt=Necessita de autentica&ccedil;&atilde;o', 'authoring/login_requiered.php', 's',".$guest_code." , 'no', 'N/A', ".$default_box_code.", 0),
('Registo efectuado com sucesso', 'en=Success Register||pt=Registo efectuado', 'authoring/success_register.php', 's',".$guest_code." , 'no', 'N/A', ".$default_box_code.", 0),
('Informa&ccedil;&atilde;o da conta de utilizador', 'en=Profile info||pt=A minha conta', 'authoring/profile_info.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0)
";
?>