<?php
$type=@$_GET['type'];
$task=@$_GET['id'];
@$_SESSION['non']=@$_POST['name'];
@$_SESSION['e-mail']=@$_POST['email'];
if (validacao_canalmail()==false): // erro de validação
	if (isset($_POST['email']) and $_POST['email']<>'' and strpos("-".$_POST['email'],"@") and strpos("-".$_POST['email'],".")):
		$qw=$db->getquery("select email from email where email='".mysql_escape_string($_POST['email'])."'");
		if ($qw[0][0]<>''):
			@$_SESSION['new_user']='';
			$_SESSION['goback']=true;
			//O Email que inseriu já existe.
			$_SESSION['erro_email']="O Email que inseriu já existe na nossa base de dados.";
		else:
			// todos os campos estao correctamente preeenchidos - fixe: adicionar a BD!
			$_SESSION['goback']=false;
		endif;
	else:
	$_SESSION['goback']=true;
	$_SESSION['email']="Email Inválido!";
	endif;
	if ($_SESSION['goback']==false):
		// Preparar as listas para fopen
		$intereses='';
		 if (strcmp(@$_POST['listas1'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas1'];
		 endif;
		 if (strcmp(@$_POST['listas2'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas2'];
		 endif;
		 if (strcmp(@$_POST['listas3'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas3'];
		 endif;
		 if (strcmp(@$_POST['listas4'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas4'];
		 endif;
		 if (strcmp(@$_POST['listas5'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas5'];
		 endif;
		 if (strcmp(@$_POST['listas6'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas6'];
		 endif;
		 if (strcmp(@$_POST['listas7'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas7'];
		 endif;
		 if (strcmp(@$_POST['listas8'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas8'];
		 endif;
		 if (strcmp(@$_POST['listas9'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas9'];
		 endif;
		 if (strcmp(@$_POST['listas10'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas10'];
		 endif;
		 if (strcmp(@$_POST['listas11'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas11'];
		 endif;
		 if (strcmp(@$_POST['listas12'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas12'];
		 endif;
		 if (strcmp(@$_POST['listas13'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas13'];
		 endif;
		 if (strcmp(@$_POST['listas14'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas14'];
		 endif;
		 if (strcmp(@$_POST['listas15'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas15'];
		 endif;
		 if (strcmp(@$_POST['listas16'],"")  != 0 ):
			$intereses .= '&listas='.$_POST['listas16'];
		 endif;
		
		#Execução fopen não eskecer associadoFuente;red;nombreWeb                         
		
		$asociadoFuente = "thepath";
		$nombreweb = "Construtec.org";// colocar o nome do site
		$red =str_replace("http://","",$staticvars['site_path']);//
								 
		$url= "http://www.canalmail.pt/Contenido/Suscriptores/SuscriptorExterno.jsp?rol_usuario=suscriptor&trabajo=alta&estado=validar&empresa=canalmail&asociadoFuente=".$asociadoFuente."&nombreweb=".$nombreweb."&red=".$red."&listas=".$intereses."&pais=".$_POST['pais']."&provincia=".$_POST['provincia']."&sexo=".$_POST['sexo']."&email=".$_POST['email']."&fec_ncto=".$_POST['fec_ncto']."&ocupacion=".$_POST['ocupacion']."&sector=".$_POST['sector'];
		$fp = fopen($url,'r');
		$db->setquery("insert into email set email='".mysql_escape_string($_POST['email'])."'");
		
		// CANALMAIL - Fim adicionar BD 
		@$_SESSION['non']='success';
		$cod=$_GET['cod'];
		
		$today=date("d");			
		if ($myrow[0][12]<>$today):
			$db->setquery("update items set downloads_today='0', today='".$today."' where cod_item='".mysql_escape_string($cod)."'");
		endif;
		$down=1+$myrow[0][5];
		$downt=1+$myrow[0][11];
		$db->setquery("update items set downloads='".$down."' where cod_item='".mysql_escape_string($cod)."'");
		$db->setquery("update items set downloads_today='".$downt."', today='".$today."' where cod_item='".mysql_escape_string($cod)."'");
		include($staticvars['local_root'].'kernel/initialize_download.php');
		initialize_download('items/'.$myrow[0][3]);// no initial splash / in the string
		$location=$temporary_path.'/'.$myrow[0][3];

		include_once($absolute_path."/classes/email_engine.php");
		$email = new email_engine_class;
		$email->to=mysql_escape_string($_POST['email']);
		$email->from=$admin_mail;
		$email->return_path=$admin_mail;
		$email->subject='Pedido de download no Construtec.org';
		$email->preview=false;
		$email->template='download';
		$email->message='Pode efectuar download do arquivo que pediu através do seguinte link:<br>
		<a href="'.$location.'">'.$location.'</a>
		<br />Não se esqueça que o arquivo só estará disponível durante 24 horas.';
		$message=$email->send_email($staticvars['local_root']);

	endif;
else:
	$_SESSION['goback']=true;
	$_SESSION['all_fields']="Tem de preencher os campos obrigatórios todos!";
endif;

//////////////////////// FUCTIONS ZONE ////////////////////////////////////////////////////////////////////

function validacao_canalmail(){
	$error_msg='! ';
	if (strcmp(@$_POST['sexo'],"") == 0 ):
	   $_SESSION['sexo']='tem que indicar o genero';
	  	$error_msg='ups!';
	endif;
	if (strcmp(@$_POST['fec_ncto'],"") == 0 ):
	   $_SESSION['data_nascimento']= 'Selecciona o Ano de Nascimento. ';
	  	$error_msg='ups!';
	endif;
	if (strcmp(@$_POST['pais'],"") == 0 ):
	   $$_SESSION['pais']= 'Selecciona o País. ';
	  	$error_msg='ups!';
	endif;
	if (strcmp(@$_POST['provincia'],"") == 0 ):
	   $$_SESSION['distrito']= 'Selecciona o Distrito. ';
	  	$error_msg='ups!';
	endif;
	if (strcmp(@$_POST['ocupacion'],"") == 0 ):
	   $$_SESSION['ocupacao']= 'Selecciona uma Ocupação. ';
	  	$error_msg='ups!';
	endif;
	if (strcmp(@$_POST['sector'],"") == 0 ):
	   $$_SESSION['sector']= 'Selecciona o Sector. ';
	  	$error_msg='ups!';
	endif;
	
	if ( (strcmp(@$_POST['listas1'],"") == 0 ) && (strcmp(@$_POST['listas2'],"") == 0 ) && (strcmp(@$_POST['listas3'],"") == 0 ) && (strcmp(@$_POST['listas4'],"") == 0 )
	 && (strcmp(@$_POST['listas5'],"") == 0 ) && (strcmp(@$_POST['listas6'],"") == 0 ) && (strcmp(@$_POST['listas7'],"") == 0 ) && (strcmp(@$_POST['listas8'],"") == 0 )
	 && (strcmp(@$_POST['listas9'],"") == 0 ) && (strcmp(@$_POST['listas10'],"") == 0 ) && (strcmp(@$_POST['listas11'],"") == 0 ) && (strcmp(@$_POST['listas12'],"") == 0 )
	 && (strcmp(@$_POST['listas13'],"") == 0 ) && (strcmp(@$_POST['listas14'],"") == 0 ) && (strcmp(@$_POST['listas15'],"") == 0 ) && (strcmp(@$_POST['listas14'],"") == 0 )    
	):
	  	$error_msg='ups!';
	   $_SESSION['interesses']= 'Selecciona pelo menos uma área de interesse';
	endif;
	if ($error_msg=='! '):
		return false;
	else:
		$_SESSION['all_fields']="Tem de preencher os campos obrigatórios todos!";
		return true;
	endif;
};
?>



