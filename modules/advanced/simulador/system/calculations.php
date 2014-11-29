<?php




$error_free=true;
if(!isset($_POST['simul_terms']))://termos gerais de utilizaчуo do simulador
	$_POST['simul_terms']='error';
	$error_free=false;
endif;
if(!isset($_POST['simul_localidade']))://termos gerais de utilizaчуo do simulador
	$_POST['simul_localidade']='error';
	$error_free=false;
else:
	//valores de insulacao em horas anuais
	$insolacao['aveiro']=2600;
	$insolacao['braga']=2400;
	$insolacao['braganca']=2900;
	$insolacao['beja']=3100;
	$insolacao['castelo branco']=3000;
	$insolacao['coimbra']=2700;
	$insolacao['evora']=3100;
	$insolacao['faro']=3100;
	$insolacao['guarda']=2800;
	$insolacao['leiria']=2500;
	$insolacao['lisboa']=2900;
	$insolacao['portalegre']=2600;
	$insolacao['porto']=2500;
	$insolacao['santarem']=2800;
	$insolacao['setubal']=3000;
	$insolacao['viana do castelo']=2500;
	$insolacao['vila real']=2700;
	$insolacao['viseu']=2500;
	$insolacao['acores']=2500;// falta corrigir este valor
	$insolacao['madeira']=2500;// falta corrigir este valor
endif;
if($_POST['simul_nome']==''):
	$_POST['simul_nome']='error';
	$error_free=false;
endif;
if($_POST['simul_telef']==''):
	$_POST['simul_telef']='error';
	$error_free=false;
endif;
if($_POST['simul_email']==''):
	$_POST['simul_email']='error';
	$error_free=false;
endif;
if($_POST['simul_localidade']==''):
	$_POST['simul_localidade']='error';
	$error_free=false;
endif;
if($_POST['reg_type']=='--------'):
	$_POST['reg_type']='error';
	$error_free=false;
elseif($_POST['reg_type']=='ac')://aquecimento central
	if($_POST['simul_isola']==''):
		$_POST['simul_isola']='error';
		$error_free=false;
	endif;
	if($_POST['simul_tipo']==''):
		$_POST['simul_tipo']='error';
		$error_free=false;
	endif;
	if($_POST['simul_area_util']==''):
		$_POST['simul_area_util']='error';
		$error_free=false;
	elseif(!is_numeric($_POST['simul_area_util'])):
		$_POST['simul_area_util']='error';
		$error_free=false;
	endif;
	if(isset($_POST['simul_pe_drt_27'])):
		$altura=2.7;
	else:
		if($_POST['simul_pe_drt_outro_txt']==''):
			$altura=2.7;
		else:
			if (is_numeric($_POST['simul_pe_drt_outro_txt'])):	
				$altura=$_POST['simul_pe_drt_outro_txt'];
			else:
				$altura=2.7;
			endif;
		endif;
	endif;
	if($error_free):// do calculations
	endif;

elseif($_POST['reg_type']=='ap')://aquecimento piscinas
	if($_POST['simul_comp']=='' or !is_numeric($_POST['simul_comp']))://comprimento
		$_POST['simul_comp']='error';
		$error_free=false;
	endif;
	if($_POST['simul_largura']=='' or !is_numeric($_POST['simul_largura']))://largura
		$_POST['simul_largura']='error';
		$error_free=false;
	endif;
	if($error_free):// do calculations
	endif;

elseif($_POST['reg_type']=='aqs')://aguas quentes sanitсrias
	if($_POST['simul_consumo']=='' or !is_numeric($_POST['simul_consumo'])):// consumo l/pessoa/dia
		$_POST['simul_consumo']='error';
		$error_free=false;
	endif;
	if($_POST['simul_pessoas']=='' or !is_numeric($_POST['simul_pessoas'])):// nК de pessoas
		$_POST['simul_pessoas']='error';
		$error_free=false;
	endif;
	if($_POST['simul_aqs_tipo']==''):// tipo de aplicaчуo
		$_POST['simul_aqs_tipo']='error';
		$error_free=false;
	endif;
	if($error_free):// do calculations
		$cp=4.19; //KJ/Kg.K
		$te=50;// temperatura a saida da torneira
		$ts_verao=18;
		$ts_inverno=13;
		// calculo das necessidades de inverno e de verao
		$consumo_diario=$_POST['simul_consumo']*$_POST['simul_pessoas'];
		$q_verao=($consumo_diario*$cp*($te-$ts_verao))/3600;
		$q_inverno=($consumo_diario*$cp*($te-$ts_inverno))/3600;
		$n0=0.789;
		$a1=6.5;
		//area de abertura m2
		$ab=1.91;
		// caudal recomendado l/s.m2
		$cr=0.007;
		$volume=2.5;
		$inc=40;
		// calculo para o verao do colector
		$g=$gi*1000/$i_verao;
		$n=$n0-$a1*(($te+$ts_verao)/2-$ta_verao)/$g
		$qc_verao=$g*$ab*$n
		// calculo para o inverno docoloector
	endif;
endif;


?>