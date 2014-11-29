<?php
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
// boxvenue only defs
$_SESSION['database']['username']='boxvenue_main';
$_SESSION['database']['password']='migalhas';
$_SESSION['database']['name']='boxvenue_';

$linker=mysql_connect("localhost", "boxvenue_main", "migalhas");
if (!$linker):
   echo 'Could not connect to mysql';
   exit;
endif;

$res = mysql_query("mysql", 'SHOW DATABASES');
if(mysql_query("mysql", 'SHOW DATABASES')):
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
else:
	$dbss[0]='';
endif;
?>

<script language="JavaScript" type="text/javascript">
<!--
var site_path='<?=$globvars['site_path'];?>';
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

<h3><img src="<?=$globvars['site_path'];?>/images/set_misc.gif" alt="Paths">&nbsp;DATABASE</h3>
<form name="form_db" id="form_db" class="form" action="<?=strip_address("set",$_SERVER['REQUEST_URI']).'&set=5';?>"  onsubmit="return checkform(this)" enctype="multipart/form-data" method="post">
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
          <option value="mysql" <?php if ($_SESSION['database']['type']=='mysql'){?>selected<?php } ?>>MySql Database</option>
          <option value="mssql" <?php if ($_SESSION['database']['type']=='mssql'){?>selected<?php } ?>>MicroSoft Sql Database</option>
        </select>
        <br>
        <h4 id="t_name">Name</h4>
        <table border="0">
          <tr>
            <td><input onchange="cleanform(document.form_db)" name="name" type="text" class="text" id="name" value="<?=$_SESSION['database']['name'];?>" size="30" maxlength="30"></td>
            <td align="left"><div id="name_img"></div></td>
          </tr>
          <tr>
            <td colspan="2" align="left"><div id="resetdb"></div></td>
          </tr>
        </table>        
        <br>
        <h4 id="t_host">Host</h4>
        <input onchange="cleanform(document.form_db)" name="host" type="text" class="text" id="host" value="<?=$_SESSION['database']['host'];?>" size="30">
        <br>
        <h4 id="t_user">username</h4>
        <input onchange="cleanform(document.form_db)" name="username" type="text" class="text" id="username" value="<?=$_SESSION['database']['username'];?>" size="30" maxlength="30">
        <br>
        <h4 id="t_pass">Password</h4>
        <input onchange="cleanform(document.form_db)" name="password" type="password" class="text" id="password" value="<?=$_SESSION['database']['password'];?>" size="30" maxlength="40">
        <br>
        <h4 id="t_pass2">Repeat password</h4>
        <table border="0">
          <tr>
            <td><input onchange="cleanform(document.form_db)" name="password2" type="password" class="text" id="password2" value="<?=$_SESSION['database']['password'];?>" size="30" maxlength="40"></td>
            <td align="left"><div id="img"></div></td>
          </tr>
        </table>
        <br>
        <br>
        <br>
        <h4>Credentials to access DB Server (not mandatory)</h4>
        <h5>user</h5>
        <input onchange="" name="cred_user" type="text" class="text" id="cred_user" value="" size="30" maxlength="40">
        <br>
        <h5>password</h5>
        <input onchange="" name="cred_pass" type="password" class="text" id="cred_pass" value="" size="30" maxlength="40">
        <br>
      </p>
      <p align="right">
        <input class="button" type="submit" name="save_db" id="save_db" value="Save" tabindex="3">
        </p>

    </td>
  </tr>
</table>

</form>
