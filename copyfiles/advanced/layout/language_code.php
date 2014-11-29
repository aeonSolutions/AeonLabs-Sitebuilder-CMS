<?php
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
$address=strip_address('lang',$_SERVER['REQUEST_URI']);
if (strpos("-".$address,"?")):
	$address.= "&lang=";
else:
	$address.= "?lang=";
endif;
if (is_file($staticvars['local_root'].'kernel/settings/language.php')):
	include($staticvars['local_root'].'kernel/settings/language.php');
else:
	$lang_type='flags';
endif;
$avail=explode(";",$staticvars['language']['available']);
if ($lang_type=='flags'):
	$code='<table width="1%" border="0" cellspacing="0" cellpadding="0"><tr>';
	if ($lang<>'pt' and in_array('pt',$avail)):
		$code.= '<td><A title="Escolha a sua língua" href="'.$address.'pt"><IMG height=15 src="kernel/images/flags/pt.gif" width=20 border=0></A></td>';
	endif;
	if ($lang<>'fr' and in_array('fr',$avail)):
		$code.= '<td><A title="Choisissez votre langage" href="'.$address.'fr"><IMG height=15 src="kernel/images/flags/fr.gif" width=20 border=0></A></td>';
	endif;
	if ($lang<>'es'  and in_array('es',$avail)):
		$code.='<td><A title="Escoja su idioma" href="'.$address.'es"><IMG height=15 src="kernel/images/flags/es.gif" width=20 border=0></A></td>';
	endif;
	if ($lang<>'en'  and in_array('en',$avail)):
		$code.='<td><A title="Choose your language" href="'.$address.'en"><IMG height=15 src="kernel/images/flags/en.gif" width=20 border=0></A></td>';
	endif;
	$code.='</tr></table>';
	echo $code;
else:// dropdown menu
	$address=explode('/',$_SERVER['REQUEST_URI']);
	$address=$address[count($address)-1];
	$address=str_replace('&lang='.$lang,'',$address);
	$address=str_replace('?lang='.$lang,'',$address);
	if (strpos("-".$address,"?")):
		$link= $address."&lang=";
	else:
		$link= $address."?lang=";
	endif;
	?>
	<form class="form" action="" method="get" style="margin:0px;" enctype="application/x-www-form-urlencoded">
        <select name="lang" style="height:20px" size="1" class="text" onChange="window.location='<?=$link;?>'+this.value+''">
        <?php
		for($i=0;i<count($avail);$i++):
		?>
        <option value="<?=$avail[$i];?>" <?php if ($lang==$avail[$i]){?>selected<?php } ?>><?=$avail[$i];?></option>
		<?php
        endfor;
		?>
        </select>
    </form>
	<?php
endif;
?>