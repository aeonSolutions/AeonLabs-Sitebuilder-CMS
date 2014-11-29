<?php
/*
File revision date: 22-set-2008
*/
function sweap($needle, $haystack)
  {
  for($ii=0;$ii<count($haystack);$ii++):
 	if($needle == $haystack[$ii]):
		return $ii;
		break;
	endif;
  endfor;
  return false;
  };

function select_page($page,$total,$link,$staticvars){
if ($total==0):
	return;
endif;
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/publicacoes/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/publicacoes/language/pt.php');
else:
	include($staticvars['local_root'].'modules/publicacoes/language/'.$lang.'.php');
endif;
?>
    <style>
.page_select{
	text-align: center;color:#000;
	border: 1px solid #fff;
	padding: 2px 5px;
	font-size: 11px;
	font-family: Arial,Verdana, Helvetica, sans-serif;
	background: #f0f0f0;
	width: 50px;
	font-weight: bold;
}
</style>

<?php
$address=strip_address("page",$link);
$string='<div style="padding: 5px 5px 5px 5px;" align="center">';
if ($page==1 ):
	$string.='<span class="page_select">'.$ps[1].'</span>&nbsp;<span class="page_select">'.$ps[0].'</span>&nbsp;';
else:
	$string.='<span class="page_select"><a href="'.$address.'&page=1">'.$ps[1].'</a></span>&nbsp;<span class="page_select"><a href="'.$address.'&page='.($page-1).'">'.$ps[0].'</a></span>&nbsp;';
endif;
$page= $page>$total ? $total : $page;
$page= $page<0 ? 1 : $page;
if($page==$total and $total>4):
	$lower=$total-4;
	$uper=$total;
elseif($page==($total-1) and $total>4):
	$lower=$total-3;
	$uper=$total;
elseif($page<3 and $total>4):
	$lower=1;
	$uper= 5>$total ? $total: 5;
elseif($page<3 and $total<=4):
	$lower=1;
	$uper= 5>$total ? $total: 5;
else:
	$lower=$page-2;
	$uper= $page+2;
endif;
for($i=$lower;$i<=$uper;$i++):
	if($i<>$page):
		$string.='<span class="page_select"><a href="'.$address.'&page='.($i).'">'.$i.'</a></span>&nbsp;';
	else:
		$string.='<span class="page_select">'.$i.'</span>&nbsp;';
	endif;
endfor;
if ($page==$total ):
	$string.='<span class="page_select">'.$ps[2].'</span>&nbsp;<span class="page_select">'.$ps[3].'</span>';
else:
	$string.='<span class="page_select"><a href="'.$address.'&page='.($page+1).'">'.$ps[2].'</a></span>&nbsp;<span class="page_select"><a href="'.$address.'&page='.$total.'">'.$ps[3].'</a></span>';
endif;

return $string.'</div>';
};
?>