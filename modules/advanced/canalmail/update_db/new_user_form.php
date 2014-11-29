<?php
/*
File revision date: 30-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if (validacao_canalmail()==false): // erro de validação
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
	if (!file_exists($staticvars['local_root'].'modules/canalmail/system/settings.php')):
		$nombreweb =$staticvars['name'];// colocar o nome do site
		$red =str_replace("http://","",$staticvars['site_path']);//
		$asociadoFuente = "thepath";
	else:
		include($staticvars['local_root'].'modules/canalmail/system/settings.php');
	endif;							 
	$url= "http://www.canalmail.pt/Contenido/Suscriptores/SuscriptorExterno.jsp?rol_usuario=suscriptor&trabajo=alta&estado=validar&empresa=canalmail&asociadoFuente=".$asociadoFuente."&nombreweb=".$nombreweb."&red=".$red."&listas=".$intereses."&pais=".$_POST['pais']."&provincia=".$_POST['provincia']."&sexo=".$_POST['sexo']."&email=".$_POST['email']."&fec_ncto=".$_POST['fec_ncto']."&ocupacion=".$_POST['ocupacion']."&sector=".$_POST['sector'];
	$fp = fopen($url,'r');
	
	// CANALMAIL - Fim adicionar BD 
	@$_SESSION['non']='success';
else:
	@$_SESSION['new_user']='';
	$_SESSION['goback']=true;
	$_SESSION['canalmail']="Verifique os campos obrigatórios";
	echo '<font class="body_text"> <font color="#FF0000">Verifique os campos obrigatórios - Canalmail.</font></font>';
endif;


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
