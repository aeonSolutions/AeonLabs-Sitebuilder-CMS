<?php
/*
File revision date: 2-Out-2006
*/

/* Auto instalation:
(`name`, `display_name`, `link`, `published`, `cod_user_type`, `self_skin`, `aditional_params`, `box_code`, `cod_skin`)
*/
$module="
('Fisher de Alertas via email', 'en=Email Alerts||pt=Aviso de Actualiza&ccedil;&otilde;es', 'email_alerts/alerts_fisher.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Configura&ccedil;&atilde;o de Alertas Email', 'En=Configure your Email Alerts||pt=Configura&ccedil;&atilde;o de alertas email', 'email_alerts/email_alert.php', 's', ".$auth_code.", 'no', 'N/A', ".$default_box_code.", 0),
('Ajuda Email alerts', 'en=Email Alerts Help||pt=Ajuda Avisos Email', 'email_alerts/email_alert_help.php', 's', ".$default_code.", 'no', 'N/A', ".$default_box_code.", 0)
";
?>