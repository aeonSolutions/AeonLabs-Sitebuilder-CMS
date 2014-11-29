<?
include('staticvars.php');
$qw=$_SESSION['qw'];
if (isset($_SESSION['up']) and isset($_SESSION['down'])):
	$_SESSION['up']=$_SESSION['up']+50;
	if ($_SESSION['up']>=count($qw)):
		$_SESSION['up']=count($qw)-1;
		$_SESSION['terminate']=true;
	endif;
	$_SESSION['down']=$_SESSION['down']+50;
else:
	$_SESSION['t']=0;
	$_SESSION['terminate']=false;
	$_SESSION['up']=50;
	$_SESSION['down']=0;
	if ($_SESSION['up']>=count($qw)):
		$_SESSION['up']=count($qw)-1;
		$_SESSION['terminate']=true;
	endif;
endif;
$t=$_SESSION['t'];
for ($i=$_SESSION['down'];$i<=$_SESSION['down'];$i++):
	if (!@fsockopen('http://'.$qw[$i][0], '80', $errnum, $errstr, 5)):
		 // link not found
		$_SESSION['lk'][$t][0]=$qw[$i][0];
		$_SESSION['lk'][$t][1]=$qw[$i][1];
		$t++;
	endif;
endfor;
$_SESSION['t']=$t;
?>

