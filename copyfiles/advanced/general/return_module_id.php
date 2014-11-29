<?php
// function to return the id code of  module name
function return_id($name){
// returns the current hard drive directory not the root directory
$local = __FILE__ ;
$local= ''.substr( $local, 0, strpos( $local, "general" ) ) ;
include($local.'kernel/staticvars.php');
$query=$db->getquery("select cod_module, link from module");
for ($i=0; $i<count($query);$i++):
		//link is always on the for [directory]/[filename]
		if ($query[$i][1]==$name):
			return $query[$i][0];
		else:
			$linkx=explode("/",$query[$i][1]);
			if ($linkx[1]==$name):
				return $query[$i][0];
			endif;
		endif;
endfor;
return -1;
};
?>