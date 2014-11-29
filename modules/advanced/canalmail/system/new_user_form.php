<?php
/*
File revision date: 30-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
?>
<table>
    <tr>
    <td width="150" class="body_text">
    <font size="1" color="#FF0000">&#8226;</font>
    <? if (isset($_SESSION['sexo'])):
        ?><font size="1" color="#FF0000">Genero:</font><?
    else:
         ?><font class="body_text">Genero:</font><?
    endif; ?>						</td>
    <td><INPUT class="text" type=radio value=H name=sexo><font class="body_text">Masculino</FONT>
    <INPUT class="text" type=radio value=M name=sexo> <font class="body_text">Feminino</FONT></td></tr>
    <tr>
      <td colspan="2" height="5"></td>
  </tr>
    <tr>
    <td width="150" class="bosy_text">
    <font size="1" color="#FF0000">&#8226;</font>
    <? if (isset($_SESSION['data_nascimento'])):
        ?><font size="1" color="#FF0000">Data Nascimento:</font><?
    else:
         ?><font class="body_text">Data Nascimento:</font><?
    endif; ?>						</td>
    <td><SELECT class="text" name="fec_ncto"> 
    <OPTION value=01-01-2000>2000</OPTION>
    <OPTION value=01-01-1999>1999</OPTION>
    <OPTION value=01-01-1998>1998</OPTION>
    <OPTION value=01-01-1997>1997</OPTION>
    <OPTION value=01-01-1996>1996</OPTION>
    <OPTION value=01-01-1995>1995</OPTION>
    <OPTION value=01-01-1994>1994</OPTION>
    <OPTION value=01-01-1993>1993</OPTION>
    <OPTION value=01-01-1992>1992</OPTION>
    <OPTION value=01-01-1991>1991</OPTION>
    <OPTION value=01-01-1990>1990</OPTION>
    <OPTION value=01-01-1989>1989</OPTION>
    <OPTION value=01-01-1988>1988</OPTION>
    <OPTION value=01-01-1987>1987</OPTION>
    <OPTION value=01-01-1986>1986</OPTION>
    <OPTION value=01-01-1985>1985</OPTION>
    <OPTION value=01-01-1984>1984</OPTION>
    <OPTION value=01-01-1983>1983</OPTION>
    <OPTION value=01-01-1982>1982</OPTION>
    <OPTION value=01-01-1981>1981</OPTION>
    <OPTION value=01-01-1980>1980</OPTION>
    <OPTION value=01-01-1979>1979</OPTION>
    <OPTION value=01-01-1978>1978</OPTION>
    <OPTION value=01-01-1977>1977</OPTION>
    <OPTION value=01-01-1976>1976</OPTION>
    <OPTION value=01-01-1975>1975</OPTION>
    <OPTION value=01-01-1974>1974</OPTION>
    <OPTION value=01-01-1973>1973</OPTION>
    <OPTION value=01-01-1972>1972</OPTION>
    <OPTION value=01-01-1971>1971</OPTION>
    <OPTION value=01-01-1970>1970</OPTION>
    <OPTION value=01-01-1969>1969</OPTION>
    <OPTION value=01-01-1968>1968</OPTION>
    <OPTION value=01-01-1967>1967</OPTION>
    <OPTION value=01-01-1966>1966</OPTION>
    <OPTION value=01-01-1965>1965</OPTION>
    <OPTION value=01-01-1964>1964</OPTION>
    <OPTION value=01-01-1963>1963</OPTION>
    <OPTION value=01-01-1962>1962</OPTION>
    <OPTION value=01-01-1961>1961</OPTION>
    <OPTION value=01-01-1960>1960</OPTION>
    <OPTION value=01-01-1959>1959</OPTION>
    <OPTION value=01-01-1958>1958</OPTION>
    <OPTION value=01-01-1957>1957</OPTION>
    <OPTION value=01-01-1956>1956</OPTION>
    <OPTION value=01-01-1955>1955</OPTION>
    <OPTION value=01-01-1954>1954</OPTION>
    <OPTION value=01-01-1953>1953</OPTION>
    <OPTION value=01-01-1952>1952</OPTION>
    <OPTION value=01-01-1951>1951</OPTION>
    <OPTION value=01-01-1950>1950</OPTION>
    <OPTION value=01-01-1949>1949</OPTION>
    <OPTION value=01-01-1948>1948</OPTION>
    <OPTION value=01-01-1947>1947</OPTION>
    <OPTION value=01-01-1946>1946</OPTION>
    <OPTION value=01-01-1945>1945</OPTION>
    <OPTION value=01-01-1944>1944</OPTION>
    <OPTION value=01-01-1943>1943</OPTION>
    <OPTION value=01-01-1942>1942</OPTION>
    <OPTION value=01-01-1941>1941</OPTION>
    <OPTION value=01-01-1940>1940</OPTION>
    <OPTION value="" selected>[Seleccione]</OPTION>
    </SELECT>						</td></tr>
    <tr>
      <td colspan="2" height="5"></td>
  </tr>
    <tr>
    <td width="150" class="body_text">
    <font size="1" color="#FF0000">&#8226;</font>
    <? if (isset($_SESSION['pais'])):
        ?><font size="1" color="#FF0000">País:</font><?
    else:
         ?><font class="body_text">País:</font><?
    endif; ?>						</td>

    <td><SELECT class="text" onchange="CargaProvincias()" name="pais">
    <OPTION value="">------------------</OPTION>
    <OPTION value=POR selected>PORTUGAL</OPTION>
    <OPTION value="">------------------</OPTION>
    <OPTION value=ESP>Espanha</OPTION>
    <OPTION value=MEX>México</OPTION>
    <OPTION value=ARG>Argentina</OPTION>
    <OPTION value=CHL>Chile</OPTION> <OPTION 
    value=PER>Perú</OPTION> <OPTION 
    value=COL>Colômbia</OPTION> <OPTION 
    value=VEN>Venezuela</OPTION> <OPTION 
    value="">------------------</OPTION> <OPTION 
    value=BOL>Bolívia</OPTION> <OPTION 
    value=BRA>Brasil</OPTION> <OPTION 
    value=CAB>C.Verde</OPTION> <OPTION 
    value=CRI>Costa Rica</OPTION> <OPTION 
    value=CUB>Cuba</OPTION> <OPTION 
    value=ECU>Ecuador</OPTION> <OPTION value=ESA>El 
    Salvador</OPTION> <OPTION 
    value=FIL>Filipinas</OPTION> <OPTION 
    value=GUA>Guatemala</OPTION> <OPTION 
    value=HON>Honduras</OPTION> <OPTION 
    value=NIC>Nicarágua</OPTION> <OPTION 
    value=PAN>Panamá</OPTION> <OPTION 
    value=PAR>Paraguai</OPTION> <OPTION 
    value=AND>Andorra</OPTION> <OPTION 
    value=PUE>Puerto Rico</OPTION> <OPTION 
    value=DOM>Rep.Dom.</OPTION> <OPTION 
    value=USA>USA</OPTION> <OPTION 
    value=URU>Uruguai</OPTION> <OPTION 
    value="">------------------</OPTION> <OPTION 
    value=ZZZ>OTROS</OPTION> <OPTION 
    value="">[Escolhe um País]</OPTION></SELECT>						</td></tr>
    <tr>
      <td colspan="2" height="5"></td>
  </tr>
    <tr>
    <td width="150" class="body_text">
    <font size="1" color="#FF0000">&#8226;</font>
    <? if (isset($_SESSION['distrito'])):
        ?><font size="1" color="#FF0000">Distrito:</font><?
    else:
         ?><font class="body_text">Distrito:</font><?
    endif; ?>						</td>
    <td><select class="text" name="provincia">
      <option value="" selected>[Escolhe um Distrito]</option>
      <option 
    value="">-------------------------------</option>
      <option value=AH>Angra do Heroísmo</option>
      <option value=AVE>Aveiro</option>
      <option 
    value=BE>Beja</option>
      <option 
    value=BRG>Braga</option>
      <option 
    value=BG>Bragança</option>
      <option 
    value=CBR>Castelo Branco</option>
      <option 
    value=COI>Coimbra</option>
      <option 
    value=EV>Evora</option>
      <option 
    value=F>Faro</option>
      <option 
    value=FU>Funchal</option>
      <option 
    value=G>Guarda</option>
      <option 
    value=HO>Horta</option>
      <option 
    value=LI>Leiria</option>
      <option 
    value=LB>Lisboa</option>
      <option value=PD>Ponta 
        Delgada</option>
      <option 
    value=PT>Portalegre</option>
      <option 
    value=PR>Porto</option>
      <option 
    value=STR>Santarém</option>
      <option 
    value=SB>Setúbal</option>
      <option value=VC>Viana 
        Do Castelo</option>
      <option value=VR>Vila 
        Real</option>
      <option 
    value=VS>Viseu</option>
      </select></td></tr>
    <tr>
      <td colspan="2" height="5"></td>
  </tr>
    <tr>
    <td width="150" class="body_text">
    <font size="1" color="#FF0000">&#8226;</font>
    <? if (isset($_SESSION['ocupacao'])):
        ?><font size="1" color="#FF0000">Ocupação:</font><?
    else:
         ?><font class="body_text">Ocupação:</font><?
    endif; ?>						</td>
    <td><SELECT class="text" name="ocupacion">
     <OPTION value=6>Estudante / Universitário</OPTION>
     <OPTION value=1>Executivo / Empresário</OPTION>
     <OPTION value=3>Empregado por conta de outrem</OPTION>
     <OPTION value=5>Dona de Casa</OPTION>
     <OPTION value=9>Licenciado/Mestrado/Douturado</OPTION> 
    <OPTION value=12 selected="selected">Autónomo / Profissional liberal</OPTION>
    <OPTION value="" >[Escolhe uma 	Ocupação]</OPTION>
    </SELECT>						</td></tr>
    <tr>
      <td colspan="2" height="5"></td>
  </tr>
    <tr>
    <td width="150" class="body_text">
    <font size="1" color="#FF0000">&#8226;</font>
    <? if (isset($_SESSION['sector'])):
        ?><font size="1" color="#FF0000">Sector:</font><?
    else:
         ?><font class="body_text">Sector:</font><?
    endif; ?>						</td>
    <td><SELECT class="text" name=sector>
    <OPTION value=15>Publicidade/Comunicações</OPTION> 
    <OPTION value=2>Informática (IS, MIS, DP)</OPTION>
    <OPTION value=3>Informática (Internet)</OPTION>
    <OPTION value=4>Informática (Desenvolvimento de Software)</OPTION>
    <OPTION value=5>Consultoria</OPTION>
    <OPTION value=6>Educação</OPTION>
    <OPTION value=7>Arquitectura/Engenharia/Construção</OPTION> 
    <OPTION value=8>Governo/Exército</OPTION> 
    <OPTION value=9>Serviços Jurídicos</OPTION> 
    <OPTION value=10>Produção/Fabricação</OPTION> 
    <OPTION value=11>Serviços Médicos</OPTION> 
    <OPTION value=12>Investigação e Desenvolvimento</OPTION>
    <OPTION value=13>Vendas/Comércio</OPTION>
    <OPTION value=1>Contabilidade e Finanças</OPTION> 
    <OPTION value=14>Outros</OPTION>
    <OPTION value="" selected>[Escolha um Sector]</OPTION>
    </SELECT> </td></tr>
    <tr>
      <td colspan="2">
        <HR noShade SIZE=1></td>
      <td>&nbsp;</td>
    </tr>
    <tr height="8">
      <td colspan="3"></td>
    </tr>
    <tr>
    <td width="150" valign="top" class="header_text_1">
    <font size="1" color="#FF0000">&#8226;</font>
    <? if (isset($_SESSION['interesses'])):
        ?><font size="1" color="#FF0000">Interesses:</font><?
    else:
         ?><font class="body_text">Interesses:</font><?
    endif; ?>						</td>
    <td valig="center">
<font class="body_text">Ajude a manter esta p&aacute;gina online. Seleccione as areas de interesse para receber as melhores promoções através da<A href="http://www.canalmail.pt/" target=_blank>
    <img src="http://promociones.canalmail.com/pruebas/canalmailpastilla.gif" align="middle" border="0"></A></font>                        </td>
    <tr>
    <td width="150">&nbsp;</td>
    <td>
    <TABLE cellSpacing=0 cellPadding=0 width=400 
    border=0>
    <tr>
    <td width=100 height=22><INPUT class="text" type=checkbox 
    CHECKED value=1 name=listas1> <A name=1><FONT 
    style="FONT-SIZE: 7pt">Lazer</FONT></A></td>
    <td width=100 height=22><INPUT class="text" type=checkbox 
    CHECKED value=8 name=listas2> <A name=8><FONT 
    style="FONT-SIZE: 7pt">Ofertas</FONT></A></td>
    <td width=100 height=22><INPUT class="text" name=listas3 type=checkbox 
    value=30 checked="checked"> 
    <A name=30><FONT 
    style="FONT-SIZE: 7pt">Bancos</FONT></A></td>
    <td width=100 height=22><INPUT class="text" type=checkbox CHECKED value=90 name=listas4>
    <A name=90><FONT style="FONT-SIZE: 7pt">Emprego</FONT></A></td></tr>
    <tr>
    <td width=100 height=22><INPUT class="text" name=listas5 type=checkbox 
    value=41 checked="checked"> 
    <A name=41><FONT 
    style="FONT-SIZE: 7pt">Carros</FONT></A></td>
    <td width=100 height=22><INPUT class="text" type=checkbox CHECKED value=7 name=listas6>
    <A name=7><FONT style="FONT-SIZE: 7pt">Música</FONT></A></td>
    <td width=100 height=22><INPUT class="text" type=checkbox 
    CHECKED value=2418 name=listas7> <A 
    name=2418><FONT 
    style="FONT-SIZE: 7pt">Compras</FONT></A></td>
    <td width=100 height=22><INPUT class="text" type=checkbox  CHECKED value=9 name=listas8>
    <A name=9><FONT style="FONT-SIZE: 7pt">Desporto</FONT></A></td></tr>
    <tr>
    <td width=100 height=22><INPUT class="text" name=listas9 type=checkbox 
    value=13 checked="checked"> 
    <A name=13><FONT 
    style="FONT-SIZE: 7pt">Cursos</FONT></A></td>
    <td width=100 height=22><INPUT class="text" name=listas10 type=checkbox 
    value=690 checked="checked"> 
    <A name=690><FONT 
    style="FONT-SIZE: 7pt">Ele</FONT></A></td>
    <td width=100 height=22>
    <INPUT class="text" name=listas11 type=checkbox value=11 checked="checked">
    <A name=11><FONT style="FONT-SIZE: 7pt">Viagens</FONT></A>						</td>
    <td width=100 height=22>
    <INPUT class="text" type=checkbox CHECKED value=1133 name=listas12>
    <A name=1133><FONT style="FONT-SIZE: 7pt">Informática</FONT></A>						</td>
    </tr>
    <tr>
    <td width=100 height=22>
    <INPUT class="text" name=listas13 type=checkbox value=691 checked="checked">
    <A name=691><FONT style="FONT-SIZE: 7pt">Crianças</FONT></A>						</td>
    <td width=100 height=22>
    <INPUT class="text" name=listas14 type=checkbox value=5 checked="checked">
    <A name=5><FONT style="FONT-SIZE: 7pt">Saúde</FONT></A>						</td>
    <td width=100 height=22><INPUT name=listas15 type=checkbox value=692 checked="checked">
    <A name=692><FONT style="FONT-SIZE: 7pt">Adultos</FONT></A>						</td>
    <td width=100 height=22><INPUT class="text" type=checkbox  CHECKED value=2420 name=listas16>
    <A name=2420><FONT style="FONT-SIZE: 7pt">Notícias</FONT></A>						</td></tr>
    </TABLE>					</td>
<td >&nbsp;</td>
</tr>
</table>
<p>
  <INPUT type=hidden value=new_confirm name=op>
</p>
<p><span class="form">Ao clicar no bot&atilde;o 'Registar', declara que aceita todos os <a class="tituloNEGRIB" href="http://www.canalmail.com/Contenido/Suscriptores/contrato_suscriptoresp.html" target="_blank"> Termos e Condi&ccedil;&otilde;es</a> para o uso do servi&ccedil;o da Canalmail</span>. </p>
