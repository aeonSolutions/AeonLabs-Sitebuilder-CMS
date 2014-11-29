<?php
/*
File revision date: 11-Set-2008
*/
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
if(isset($_POST['insert_cat'])):
	include($staticvars['local_root'].'modules/iwfs/update_db/web_management.php');
endif;
$dbss=glob($staticvars['local_root']."modules/iwfs/webpages/*",GLOB_ONLYDIR);
?>
<link rel="StyleSheet" href="<?=$staticvars['site_path'];?>/modules/iwfs/system/dtree.css" type="text/css" />
<script type="text/javascript">
var site_path='<?=$staticvars['site_path'];?>/'
var num_dbs=<?=count($dbss).';'.chr(13);?>
var db=new Array(num_dbs);
<?php
$i=0;
foreach ($dbss as $one):
	$one=explode("/",$one);
	echo 'db['.$i.']="'.$one[count($one)-1].'";'.chr(13);
	$i++;
endforeach;

?>
function cleanform ( form )
{
document.getElementById('name_img').innerHTML="<img src='<?=$staticvars['site_path'];?>/modules/iwfs/images/check_mark.gif'>";
document.getElementById('resetdb').innerHTML="";
for(i=0;i<=num_dbs;i++)
	{
	  if (form.cat_name.value == db[i]) {
		document.getElementById('t_name').style.color="#2b2b2b";
		document.getElementById('name_img').innerHTML="<img width='20' height='20' src='<?=$staticvars['site_path'];?>/modules/iwfs/images/reload.gif'>";
		document.getElementById('resetdb').innerHTML="<input type='hidden' name='db_exists' value='"+db[i]+"' />Category exists.<br>If you proceed Category will be reseted.";
		return false;
	  }
	}

  // ** END **
}
//-->

</script>
<script type="text/javascript" src="<?=$staticvars['site_path'];?>/modules/iwfs/system/dtree.js"></script>
<h3><img src="<?=$staticvars['site_path'].'/modules/iwfs';?>/images/adcionar.gif" /> Adcionar  Categoria de P&aacute;ginas Web  </h3><br />
<table border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td width="300">
    			<script type="text/javascript">
				<!--
				<?php
				if ($dbss[0]<>''):
					echo "d = new dTree('d');";
					echo "d.add(0,-1,'Categories found');";
					$i=1;
					foreach ($dbss as $one):
						$one=explode("/",$one);
						echo "d.add(".$i.",0,'".$one[count($one)-1]."','');".chr(13);
						$i++;
					endforeach;
				else:
					echo 'document.write("No Categories found");';
				endif;
				?>
		
				document.write(d);
				//-->
			</script></td>
    <td>
                <form class="form" name="form_db" method="post" action="<?=$_SERVER['REQUEST_URI'];?>" enctype="multipart/form-data">
               <h4 id="t_name">Nome da Categoria:</h4>
              <input onKeyPress="cleanform(document.form_db)" onMouseMove="cleanform(document.form_db)"  onchange="cleanform(document.form_db)"  class="text" type="text" name="cat_name" id="cat_name">
              <input onMouseOver="cleanform(document.form_db)" class="button" type="submit" name="insert_cat" id="insert_cat" value="Gravar">
            </form></td><td><div id="name_img"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div id="resetdb"></div></td>
    <td>&nbsp;</td>
  </tr>
</table>


