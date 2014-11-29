<?php
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang="pt";
endif;
if ($lang<>'pt'):
	$link=$staticvars['site_path'].'/images/buttons/'.$lang.'/pesquisar.gif';
else:
	$link=$staticvars['site_path'].'/images/buttons/pesquisar.gif';
endif;
?>
<!-- Search Google -->
<center>
<form method="get" action="http://www.google.com/custom" target="_blank">
<table align="center" bgcolor="#ffffff">
<tr><td nowrap="nowrap" valign="top" align="center" height="32">
  <p><a href="http://www.google.com/">
  <img src="http://www.google.com/logos/Logo_25wht.gif" border="0" alt="Google" align="middle"><br>
  </a>
    <input type="text" name="q" size="15" maxlength="255" value="">
    <br>
        </input>
        <input type="image" name="sa" value="Pesquisar" src="<?=$link;?>">
        </input>
        <input type="hidden" name="client" value="pub-7688860196227521">
        </input>
        <input type="hidden" name="forid" value="1">
        </input>
        <input type="hidden" name="ie" value="ISO-8859-1">
        </input>
        <input type="hidden" name="oe" value="ISO-8859-1">
        </input>
        <input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:1;">
        </input>
        <input type="hidden" name="hl" value="pt">
        </input>
    </p>
  </td></tr></table>
</form>
</center>
<!-- Search Google -->

