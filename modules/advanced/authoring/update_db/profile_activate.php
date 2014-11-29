<?php
@session_start();
$sid=@$_GET['SID'];
if (isset($_GET['SID'])):
	session_id($_GET['SID']);
else:
	session_id('943f7a5dc10e0430c990937bb04426d8');
endif;
@session_start();
include('../../../kernel/staticvars.php');
@include_once('../../../kernel/functions.php');
if (isset($_POST['add_user'])):
	$universidade=mysql_escape_string($_POST['universidade']);
	$contacto=mysql_escape_string($_POST['contacto']);
	$user=mysql_escape_string($_POST['cod_user']);
	$file=upload_file();
	$qw=$db->getquery("select cod_user_student,curriculum from user_student where cod_user='".$user."'");		
	if ($file[0]):
		if ($qw[0][0]<>''):
			@unlink($location=$upload_directory.'/curriculum/'.$qw[0][1]);
			$query="update user_student set curriculum='".$file[1]."', universidade='".$universidade."', contacto='".$contacto."'
			 where cod_user_student='".$qw[0][0]."'";
		else: // no entry found
			$query="insert into user_student set curriculum='".$file[1]."', universidade='".$universidade."',
			 contacto='".$contacto."', cod_user='".$user."'";
		endif;
	else:
		if ($qw[0][0]<>''):
			@unlink($location=$upload_directory.'/curriculum/'.$qw[0][1]);
			$query="update user_student set universidade='".$universidade."', contacto='".$contacto."' 
			where cod_user_student='".$qw[0][0]."'";
		else: // no entry found
			$query="insert into user_student set universidade='".$universidade."',
			 contacto='".$contacto."', cod_user='".$user."'";
		endif;
	endif;
	$db->setquery($query);
	@session_destroy();
	@session_id($sid);
	@session_start();
	$qw=$db->getquery("select nick from users where cod_user='".$user."'");		
	$_SESSION['user']=$qw[0][0];
	?>
	<script>
		window.alert("A sua conta foi activada.J&aacute; pode autenticar-se no site.");
		document.location.href="<?=$staticvars['site_path'].'/index.php?SID='.$sid;?>"
	</script>
	<?php
else:
	?>
	<script language="javascript">
		window.alert("Erro ao actualizar dados.Por favor tente mais tarde.");
	</script> 
	<?php			
	  header("Location: ".$staticvars['site_path']."/index.php?SID=".$sid);
endif;

function upload_file(){
$tmp1[0]=false;
$tmp1[1]='no file';
include('../../../kernel/staticvars.php');
if (isset($_FILES['curriculum'])):
	if (stristr($_FILES['curriculum']['type'],"zip")):
		if (check_files($upload_directory.'/curriculum',$_FILES['curriculum']['name'])):
			include_once('general/pass_generator.php');
			$tmp=explode(".",$_FILES['curriculum']['name']);
			$tmp[0].=generate('5','No','Yes','No');
			$tmp1[1]=$tmp[0].'.'.$tmp[1];
			$location=$upload_directory.'/curriculum/'.$tmp1[1];
		else:
			$location=$upload_directory.'/curriculum/'.$_FILES['curriculum']['name'];					
			$tmp1[1]=$_FILES['curriculum']['name'];
		endif;
		if (!move_uploaded_file($_FILES['curriculum']['tmp_name'], $location)):
			?>
			<script language="javascript">
				window.alert("Erro no Upload. Por favor tente de novo.");
			</script>
			<?php
		else:
			$tmp1[0]=true;
		endif;
	endif;
endif;
return $tmp1;
};

function check_files($dir,$filename){
$filename=$dir.'/'.$filename;
$files = glob($dir."/*.*");
$tmp=false;
for($i = 0; $i < count($files); $i++):
	if ($files[$i]==$filename):
		$tmp=true;
	endif;
endfor;
return $tmp;
};

?>
