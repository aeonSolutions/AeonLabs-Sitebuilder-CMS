<? 
$globvars['local_root']=substr(__FILE__,0,strpos(__FILE__,"filemanager"));// local harddrive path
include($globvars['local_root'].'copyfiles/advanced/general/db_class.php');
include($globvars['local_root'].'core/globvars.php');
include($globvars['local_root'].'core/functions.php');
include($globvars['local_root'].'copyfiles/advanced/kernel/functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="StyleSheet" href="<?=$globvars['site_path'];?>/core/java/dtree.css" type="text/css" />
<script type="text/javascript">
var site_path='<?=$globvars['site_path'];?>/';
var img_node='core/java/img/folder.gif';
</script>
<script type="text/javascript" src="<?=$globvars['site_path'];?>/core/java/dtree.js"></script>
</head>

<body>
			<script type="text/javascript">
				<!--
				<?php
				$dir=glob($globvars['site']['directory']."*",GLOB_ONLYDIR);
				$j=1;
				if ($dir[0]<>''):
					echo "d = new dTree('d');";
					echo "d.add(0,-1,'".$globvars['site']['name']."');";
					for($i=0; $i<count($dir);$i++):
						$dirX=explode("/",$dir[$i]);
						echo "d.add($j,0,'".$dirX[count($dirX)-1]."','".$globvars['site_path'].'/index.php?id='.$_GET['id'].'&SID='.$globvars['site']['sid'].'&path='.$dirX[count($dir[$i])]."','','_parent');";
						$j++;
						$file_in_dir=glob($dir[$i]."/*",GLOB_ONLYDIR);
						if (isset($file_in_dir[0])):
							for($k=0;$k<count($file_in_dir);$k++):
								$fileX=explode("/",$file_in_dir[$k]);
								$paths=$dirX[count($dir[$i])]."/".$fileX[count($file_in_dir[$k])+1];
									echo "d.add($j+$k,$j-1,'".$fileX[count($file_in_dir[$k])+1]."','".$globvars['site_path'].'/index.php?id='.$_GET['id'].'&SID='.$globvars['site']['sid'].'&path='.$paths."','','_parent');";
							endfor;
							$j=$j+count($file_in_dir);
						endif;
					endfor;
				else:
					echo 'document.write("n&atilde;o ha modulos no directorio!");';
				endif;
				?>
		
				document.write(d);
				//-->
			</script>
</body>
</html>


