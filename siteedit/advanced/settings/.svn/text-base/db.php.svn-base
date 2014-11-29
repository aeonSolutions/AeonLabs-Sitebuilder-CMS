<?php
/*
File revision date: 12-Abr-2008
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;

$linker=mysql_connect("localhost", "root", "");
if (!$linker):
   echo 'Could not connect to mysql';
   exit;
endif;
$res = mysql_db_query("mysql", 'SHOW DATABASES', $linker) or die('Could not connect: ' . mysql_error());
$num=mysql_num_rows( $res );
if ($num>0):
	$j=0;
	while ( $dir = mysql_fetch_array($res) ):
		$dbss[$j]=$dir[0];
		$j++;
	endwhile;
else:
	$dbss[0]='';
endif;
?>

<script language="JavaScript" type="text/javascript">
<!--
var num_dbs=<?=count($dbss).';'.chr(13);?>
var db=new Array(num_dbs);
<?php
$i=0;
foreach ($dbss as $one):
	echo 'db['.$i.']="'.$one.'";'.chr(13);
	$i++;
endforeach;

?>

function checkform ( form )
{
  if (form.name.value == "") {
    document.getElementById('t_name').style.color="#FF0000";
	form.name.focus();
    return false;
  }
  if (form.host.value == "") {
    document.getElementById('t_host').style.color="#FF0000";
	form.host.focus();
    return false;
  }
  if (form.username.value == "") {
    document.getElementById('t_user').style.color="#FF0000";
	form.username.focus();
    return false;
  }
  if (form.password2.value != form.password.value) {
    document.getElementById('t_pass').style.color="#FF0000";
    document.getElementById('t_pass2').style.color="#FF0000";
	form.password2.focus();
    return false;
  }

  // ** END **
  return true;
}

function cleanform ( form )
{
document.getElementById('name_img').innerHTML="<img src='<?=$globvars['site_path'];?>/images/check_mark.gif'>";
document.getElementById('resetdb').innerHTML="";
  if (form.name.value != "") {
    document.getElementById('t_name').style.color="#2b2b2b";
  }
  if (form.host.value != "") {
    document.getElementById('t_host').style.color="#2b2b2b";
  }
  if (form.username.value != "") {
    document.getElementById('t_user').style.color="#2b2b2b";
  }
  if (form.password.value != "") {
    document.getElementById('t_pass').style.color="#2b2b2b";
  }
  if (form.password2.value != "") {
    document.getElementById('t_pass2').style.color="#2b2b2b";
  }
  if (form.password2.value == form.password.value) {
    document.getElementById('t_pass').style.color="#2b2b2b";
    document.getElementById('t_pass2').style.color="#2b2b2b";
    document.getElementById('img').innerHTML="<img src='<?=$globvars['site_path'];?>/images/check_mark.gif'>";
  }else{
    document.getElementById('t_pass').style.color="#FF0000";
    document.getElementById('t_pass2').style.color="#FF0000";
    document.getElementById('img').innerHTML="<img src='<?=$globvars['site_path'];?>/images/cross_mark.gif'>";
  }
for(i=0;i<=num_dbs;i++)
	{
	  if (form.name.value == db[i]) {
		document.getElementById('t_name').style.color="#2b2b2b";
		document.getElementById('name_img').innerHTML="<img width='20' height='20' src='<?=$globvars['site_path'];?>/images/reload.gif'>";
		document.getElementById('resetdb').innerHTML="<input type='hidden' name='db_exists' value='"+db[i]+"' />Database exists.<br>If you proceed Database will be reseted.";
		return false;
	  }
	}

  // ** END **
}
//-->
</script>
<script type="text/javascript" src="<?=$globvars['site_path'];?>/core/java/dtree.js"></script>
<table width="100%" border="0">
  <tr>
    <td><h3><img src="<?=$globvars['site_path'];?>/images/set_misc.gif" alt="Paths">&nbsp;DATABASE</h3>
    </td>
    <td width="30"><a href="<?=session_setup($globvars,'index.php?id='.$_GET['id']);?>"><img src="<?=$globvars['site_path'];?>/images/back.png" alt="go back" border="0" /></a> </td>
  </tr>
</table>



<form name="form_db" id="form_db" class="form" action="<?=strip_address("set",$_SERVER['REQUEST_URI']);?>"  onsubmit="return checkform(this)" enctype="multipart/form-data" method="post">
<table width="100%" border="0">
  <tr>
    <td valign="top">
			<script type="text/javascript">
				<!--
				<?php
				if ($dbss[0]<>''):
					echo "d = new dTree('d');";
					echo "d.add(0,-1,'Databases found');";
					$i=1;
					foreach ($dbss as $one):
						echo "d.add(".$i.",0,'".$one."','');";
						$i++;
					endforeach;
				else:
					echo 'document.write("No Databases found");';
				endif;
				?>
		
				document.write(d);
				//-->
			</script>
    </td>
    <td valign="top">
      <p><strong>Type</strong><br>
        <select class="text" size="1" name="db_type" >
          <option value="mysql" <?php if ($db->type=='mysql'){?>selected<?php } ?>>MySql Database</option>
          <option value="mssql" <?php if ($db->type=='mssql'){?>selected<?php } ?>>MicroSoft Sql Database</option>
        </select>
        <br>
        <h4 id="t_name">Name</h4>
        <table border="0">
          <tr>
            <td><input onchange="cleanform(document.form_db)" name="name" type="text" class="text" id="name" value="<?=$db->name;?>" size="30" maxlength="30"></td>
            <td align="left"><div id="name_img"></div></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><div id="resetdb"></div></td>
          </tr>
        </table>        
        <br>
        <h4 id="t_host">Host</h4>
        <input onchange="cleanform(document.form_db)" name="host" type="text" class="text" id="host" value="<?=$db->host;?>" size="30">
        <br>
        <h4 id="t_user">username</h4>
        <input onchange="cleanform(document.form_db)" name="username" type="text" class="text" id="username" value="<?=$db->user;?>" size="30" maxlength="30">
        <br>
        <h4 id="t_pass">Password</h4>
        <input onchange="cleanform(document.form_db)" name="password" type="password" class="text" id="password" value="<?=$db->password;?>" size="30" maxlength="40">
        <br>
        <h4 id="t_pass2">Repeat password</h4>
        <table border="0">
          <tr>
            <td><input onchange="cleanform(document.form_db)" name="password2" type="password" class="text" id="password2" value="<?=$db->password;?>" size="30" maxlength="40"></td>
            <td align="left"><div id="img"></div></td>
          </tr>
        </table>
        <br />
        No database changes are made here. If you wish to change database please select the server management option.<br>
        <br>
      </p>
      <p align="right">
        <input class="button" type="submit" name="save_db" id="save_misc" value="Save" tabindex="3">
        </p>

    </td>
  </tr>
</table>

</form>
