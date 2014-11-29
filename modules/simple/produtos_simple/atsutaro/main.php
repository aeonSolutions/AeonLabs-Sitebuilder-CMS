<?php
if (isset($_GET['page'])):
	$page_to_open=$staticvars['local_root'].'modules/produtos/atsutaro/'.$_GET['page'].'.php';
	if(!is_file($page_to_open)):
		$page_to_open='';
	endif;
else:
	$page_to_open='';
endif;
if ($page_to_open<>''):
	include($page_to_open);
else:
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="3" align="left" valign="top"><p align="justify"><strong><a href="<?=session($staticvars,$staticvars['site_path'].'/index.php?id=36&navigate=atsutaro');?>"><img src="<?=$staticvars['site_path'];?>/modules/produtos/images/atsutaro.jpg" width="71" height="53" border="0" /></a>COLECTOR SOLAR ATSU-TARO</strong><br>
      <br>
      O Colector Solar ATSU-TARO capta a energia do Sol  sendo o calor  transferido para a &aacute;gua, a qual &eacute; usada directamente para aquecimento.<br>
      A pel&iacute;cula selectiva azul tem uma efici&ecirc;ncia mais  elevada do que as superf&iacute;cies pintadas de preto e poder&aacute; originar temperaturas de &aacute;gua  superiores a 100&deg;C.<br>
    Os colectores s&atilde;o modulares e adapt&aacute;veis a  qualquer tipo e  tamanho de sistema de aproveitamento solar, tanto para edif&iacute;cios novos como para edif&iacute;cios j&aacute; existentes.  O painel Solar   foi concebido para a aplica&ccedil;&atilde;o em sistemas de aquecimento de &aacute;gua  sanit&aacute;ria.</p>
      <p align="justify">&nbsp;</p>
      <p align="justify"><br>
      </p>
      <p><strong>CARACTER</strong><strong>&Iacute;</strong><strong>STICAS</strong></p>
      <ul>
        <li>A superf&iacute;cie  selectiva de patente YAZAKI transforma a  radia&ccedil;&atilde;o solar directa e difusa em energia t&eacute;rmica, com elevado rendimento (&iacute;ndice de absor&ccedil;&atilde;o=0.93;  emit&acirc;ncia=0.11). </li>
        <li>A superf&iacute;cie selectiva  tem uma longa dura&ccedil;&atilde;o e n&atilde;o &eacute; danificada por altas  temperaturas e humidade. </li>
        <li>A placa de absor&ccedil;&atilde;o  em chapa canelada tem uma perda de carga m&iacute;nima  e &eacute; adequada para liga&ccedil;&otilde;es  em s&eacute;rie. </li>
        <li>Placa de absor&ccedil;&atilde;o em a&ccedil;o inoxid&aacute;vel  especial com elevada resist&ecirc;ncia mec&acirc;nica e &agrave; corros&atilde;o. </li>
        <li>Cobertura simples, de vidro  temperado, de baixo teor em ferro, estruturalmente forte e resistente &agrave; eros&atilde;o. </li>
        <li>As interliga&ccedil;&otilde;es  existentes na placa de absor&ccedil;&atilde;o est&atilde;o colocadas de maneira a garantir  uma distribui&ccedil;&atilde;o uniforme da &aacute;gua. </li>
        <li>Liga&ccedil;&otilde;es do lado direito e esquerdo permitem uma maior flexibilidade na coloca&ccedil;&atilde;o dos colectores solares em s&eacute;rie ou circuitos paralelos. </li>
        <li>Inv&oacute;lucro constru&iacute;do em a&ccedil;o galvanizado com uma  deposi&ccedil;&atilde;o electrol&iacute;tica  de esmalte acr&iacute;lico. </li>
        <li>Mantas de fibra de vidro revestidas de alum&iacute;nio por baixo e &agrave; volta das  extremidades da placa de absor&ccedil;&atilde;o isolam  contra as perdas t&eacute;rmicas. </li>
      </ul>
      <p>&nbsp;</p>
      <ol>
      <ul>
        <li>Est&atilde;o dispon&iacute;veis placas de cobertura  para acabamento entre os colectores,  como acess&oacute;rios. <br />
          <br />
          <br />
          <br />
        </li>
      </ul>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="3" align="left">Continuar para ... </td>
        </tr>
        <tr>
          <td width="45%" align="center"><a href="<?=strip_address('page',$_SERVER['REQUEST_URI']).'&page=performance';?>"><img src="<?=$staticvars['site_path'];?>/modules/produtos/atsutaro/images/icon_redimento.gif" alt="Rendimento" width="44" height="40" border="0" /></a></td>
          <td width="7%">&nbsp;</td>
          <td width="48%" align="center"><a href="<?=strip_address('page',$_SERVER['REQUEST_URI']).'&page=results';?>"><img src="<?=$staticvars['site_path'];?>/modules/produtos/atsutaro/images/icon_house.gif" alt="Resultados Energ&eacute;ticos" width="44" height="37" border="0" /></a></td>
        </tr>
        <tr>
          <td><div align="center">Rendimento</div></td>
          <td>&nbsp;</td>
          <td><div align="center">Resultados Energ&eacute;ticos </div></td>
        </tr>
      </table>      <p align="justify">&nbsp;          </p></td>
    <td width="10" rowspan="3">&nbsp;</td>
    <td align="center"><img src="<?=$staticvars['site_path'];?>/modules/produtos/atsutaro/intro_files/kid.jpg" width="188" height="178"></td>
  </tr>
  <tr>
    <td align="center"><img src="<?=$staticvars['site_path'];?>/modules/produtos/atsutaro/intro_files/fotovoltaico.jpg" width="233" height="126"></td>
  </tr>
  <tr>
    <td width="384" align="center"><img src="<?=$staticvars['site_path'];?>/modules/produtos/atsutaro/intro_files/house.png" width="250" height="253" /></td>
  </tr>
</table>
<?php
endif;
?>
