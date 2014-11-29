<?php
/*
File revision date: 7-jun-2014
*/
ob_end_flush();
$time2 = time() + microtime();
$time=round($time2-$time1,3);
if(is_file('version.php')):
	include('version.php');
else:
	$sys_version='0.0';
endif;
echo '<div align="center">
	<font style="font-size:8px;color:#999" >
	Loaded in '.$time.' sec.&nbsp;&nbsp;
	'.$globvars['name'].' build&nbsp;&nbsp;'.date ("dmY", filemtime('index.php')).'-'.$sys_version.'
	</FONT>
</div>';

?>
