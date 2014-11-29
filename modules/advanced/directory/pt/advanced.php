<?php
$query=$db->getquery("select count(*) from imoveis_tipo");
$numtipos=range(1,count($query[0][0]));
for($i=0;$i<count($query);$i++):
	$numtipos[$i+1]='none';
endfor;
$query=$db->getquery("select idtipo from imoveis");
for($i=0;$i<count($query);$i++):
	$numtipos[$query[$i][0]]=$query[$i][0];
endfor;

$query=$db->getquery("select count(*) from concelho");
$numconcelhos=range(1,count($query[0][0]));
for($i=0;$i<count($query);$i++):
	$numconcelhos[$i+1]='none';
endfor;
$query=$db->getquery("select idconcelho from imoveis");
for($i=0;$i<count($query);$i++):
	$numconcelhos[$query[$i][0]]=$query[$i][0];
endfor;
?>
<form method="POST" action="<?=session($staticvars,$staticvars['site_path'].'/index.php?id=81');?>">
<TABLE width="100%" border="0" cellPadding="0" cellSpacing="0">
  <TBODY>
  <TR>
    <TD id=leftcolumn>
      <DIV class="main-box">
      	<DIV class="main-box-title">Pesquisa avan&ccedil;ada</DIV>
		<DIV class="main-box-data">
			<table width="74%" height="176" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
                <td width="24%" height="14" >&nbsp;</td>
                <td width="76%" height="14" >&nbsp;</td>
			    </tr>
			  <tr>
                <td height="14" align="right" ><font class="body_text"><strong>Concelho:</strong></font></td>
                <td height="14" >
                  <select size="1" name="concelho" class="form_input">
                    <option value="none" selected>Seleccione...</option>
                    <?php
				  $query=$db->getquery('select nome,idconcelho from concelho');
				  for($i=0;$i<count($query);$i++):
				  	if ($numconcelhos[$query[$i][1]]<>'none' and $numconcelhos[$query[$i][1]]<>''):
					  	echo '<option value="'.$query[$i][1].'">'.$query[$i][0].'</option>';
					endif;
				  endfor;
				  ?>
                  </select>
                </td>
			    </tr>
			  <tr>
                <td height="14" ></td>          
                <td height="14" ></td>              
			    </tr>
			  <tr>
                <td height="14" align="right" ><font class="body_text"><strong>Tipo im&oacute;vel:</strong></font> </td>
                <td height="14">
                  <select name="tipo" size="1" class="form_input" id="tipo">
                    <option value="none" selected>Seleccione...</option>
                    <?php
				  $query=$db->getquery('select nome,idtipo from imoveis_tipo');
				  for($i=0;$i<count($query);$i++):
				  	if ($numtipos[$query[$i][1]]<>'none' and $numtipos[$query[$i][1]]<>''):
						echo '<option value="'.$query[$i][1].'">'.$query[$i][0].'</option>';
					endif;
				  endfor;
				  ?>
                  </select>
                  <font class="body_text">&nbsp;<strong>Constru&ccedil;&atilde;o:</strong></font>
                  <select size="1" name="construcao" class="form_input">
                    <option value="none" selected>Indiferente</option>
                    <option value="Nova" >Nova</option>
                    <option value="Usada" >Usada</option>
                  </select>
                </td>
			    </tr>
			  <tr>
                <td height="14" >&nbsp;</td>           
                <td height="14" >&nbsp;</td>              
			    </tr>
			  <tr>
                <td height="14" align="right" ><font class="body_text"><strong>Pre&ccedil;o:</strong></font></td>
                <td height="14" >&nbsp;</td>
			    </tr>
			  <tr>
                <td height="14" >              
                <td height="14" ><font class="body_text">
				de&nbsp;<input name="preco_inicial" type="text" class="form_input" id="preco" value="0" size="10">
				&#8364;&nbsp;
				at&eacute;&nbsp;<input name="preco_fim" type="text" class="form_input" id="preco" value="500000" size="10">
&#8364; </font>            
			    </tr>
			  <tr>
				<td height="16" colspan="2" align="left"  >&nbsp;</td>
			  </tr>
			  <tr>
				<td height="16" colspan="2" align="left"  >
					<div align="right">
					  <INPUT name="pesquisar" type=image src="images/buttons/pesquisar.gif">
					  </div></td>
			  </tr>
			  <tr>
				<td height="16" colspan="2">&nbsp;</td>
			  </tr>
			</table>
		</DIV>
	  </DIV>
      </TD>
    </TR></TBODY></TABLE>
	  </form>
