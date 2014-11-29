<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_POST['submit_revpaper'])):
	include($staticvars['local_root'].'modules/congressos/update_db/reviews.php');
	//session_write_close();
	//sleep(1);
	//header("Location: ".session($staticvars,'index.php?id='.return_id('congress_listings.php')));
endif;
for($i=0;$i<=10;$i++):
	$rev[0][$i]='';
endfor;
if(isset($_POST['abs_code']) and isset($_POST['paper_code'])):
	$cod_abs=mysql_escape_string($_POST['abs_code']);
	$cod_paper=mysql_escape_string($_POST['paper_code']);
	$abs=$db->getquery("select cod_abstract, title, authors from congress_abstracts where cod_abstract='".$cod_abs."'");
	$paper=$db->getquery("select cod_paper, data, file from congress_papers where cod_paper='".$cod_paper."'");
	if($abs[0][0]=='' or $paper[0][0]==''): // error page
		echo 'Error 1';
		exit;
	endif;
else:// error page
	echo 'Error 2';
	exit;

endif;
$type=$db->getquery("select name from user_type where cod_user_type='".$staticvars['users']['type']."'");
if($type[0][0]<>'revisor' and $staticvars['users']['user_type']['admin']<>$staticvars['users']['code'])://error page
	echo 'Error 3';
	exit;
endif;
$reviewer=$db->getquery("select nome from users where cod_user='".$staticvars['users']['code']."'");
?>
<script language="javascript">
// Subject topic
function swit(typ,pos)
{
if(typ=='o'){
	var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.ga_oe;
	alter_box[1] = window.document.revpap.ga_og;
	alter_box[2] = window.document.revpap.ga_of;
	alter_box[3] = window.document.revpap.ga_op;
}
if(typ=='tq'){
	var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.ga_tqe;
	alter_box[1] = window.document.revpap.ga_tqg;
	alter_box[2] = window.document.revpap.ga_tqf;
	alter_box[3] = window.document.revpap.ga_tqp;
}
if(typ=='cp'){
	var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.ga_cpe;
	alter_box[1] = window.document.revpap.ga_cpg;
	alter_box[2] = window.document.revpap.ga_cpf;
	alter_box[3] = window.document.revpap.ga_cpp;
}
if(typ=='if'){
var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.ga_ife;
	alter_box[1] = window.document.revpap.ga_ifg;
	alter_box[2] = window.document.revpap.ga_iff;
	alter_box[3] = window.document.revpap.ga_ifp;
}
if(typ=='t'){
	var alter_box= new Array(2);
	alter_box[0] = window.document.revpap.ta;
	alter_box[1] = window.document.revpap.tn;
}
if(typ=='l'){
	var alter_box= new Array(2);
	alter_box[0] = window.document.revpap.lg;
	alter_box[1] = window.document.revpap.ln;
}
if(typ=='a'){
	var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.aca;
	alter_box[1] = window.document.revpap.asr;
	alter_box[2] = window.document.revpap.asc;
	alter_box[3] = window.document.revpap.am;
}
if(typ=='p'){
	var alter_box= new Array(5);
	alter_box[0] = window.document.revpap.pg;
	alter_box[1] = window.document.revpap.ptb;
	alter_box[2] = window.document.revpap.ptl;
	alter_box[3] = window.document.revpap.pc;
	alter_box[4] = window.document.revpap.ps;
}
if(typ=='stn'){
	var alter_box= new Array(2);
	alter_box[0] = window.document.revpap.stw;
	alter_box[1] = window.document.revpap.stn;
}
if(typ=='afu'){
	var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.afu_c;
	alter_box[1] = window.document.revpap.afu_n;
	alter_box[2] = window.document.revpap.afu_s;
	alter_box[3] = window.document.revpap.afu_a;
}
if(typ=='r'){
	var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.ra;
	alter_box[1] = window.document.revpap.rin;
	alter_box[2] = window.document.revpap.ri;
	alter_box[3] = window.document.revpap.rt;
}
if(typ=='rec'){
	var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.reca;
	alter_box[1] = window.document.revpap.recam;
	alter_box[2] = window.document.revpap.recama;
	alter_box[3] = window.document.revpap.recad;
}
if(typ=='ga'){
	var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.gae;
	alter_box[1] = window.document.revpap.gag;
	alter_box[2] = window.document.revpap.gaw;
	alter_box[3] = window.document.revpap.gam;
}
if(typ=='i'){
	var alter_box= new Array(4);
	alter_box[0] = window.document.revpap.ig;
	alter_box[1] = window.document.revpap.ie;
	alter_box[2] = window.document.revpap.iq;
	alter_box[3] = window.document.revpap.iff;
}
if(typ=='tab'){
	var alter_box= new Array(3);
	alter_box[0] = window.document.revpap.tg;
	alter_box[1] = window.document.revpap.ts;
	alter_box[2] = window.document.revpap.tt;
}

for(var i=0;i<alter_box.length;i++)
	{
		alter_box[i].checked=false;
	}
alter_box[pos].checked=true;
if(typ=='ga' && pos!=3){
	window.document.revpap.ga_txt.value="";
	}
if(typ=='i' && pos!=3){
	window.document.revpap.iff_txt.value="";
	}
if(typ=='tab' && pos!=2){
	window.document.revpap.tt_txt.value="";
	}
}




// confirmation Dlg
function confirmAction() {
	var alter_box= new Array(5);
	alter_box[0] = window.document.revpap.stw;
	alter_box[1] = window.document.revpap.stn;
	 if(alter_box[0].checked==false && alter_box[1].checked==false){
		document.getElementById('p1').style.color ='red';
		document.getElementById('stw').focus();
		return false;
	}else{
		 document.getElementById('p1').style.color ='';
		 }

	alter_box[0] = window.document.revpap.ga_oe;
	alter_box[1] = window.document.revpap.ga_og;
	alter_box[2] = window.document.revpap.ga_of;
	alter_box[3] = window.document.revpap.ga_op;
	 if(alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false){
		document.getElementById('p2').style.color ='red';
		document.getElementById('ga_oe').focus();
		return false;
	}else{
		 document.getElementById('p2').style.color ='';
		 }

	alter_box[0] = window.document.revpap.ga_tqe;
	alter_box[1] = window.document.revpap.ga_tqg;
	alter_box[2] = window.document.revpap.ga_tqf;
	alter_box[3] = window.document.revpap.ga_tqp;
	 if(alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false){
		document.getElementById('p2').style.color ='red';
		document.getElementById('ga_tqe').focus();
		return false;
	}else{
		 document.getElementById('p2').style.color ='';
		 }

	alter_box[0] = window.document.revpap.ga_cpe;
	alter_box[1] = window.document.revpap.ga_cpg;
	alter_box[2] = window.document.revpap.ga_cpf;
	alter_box[3] = window.document.revpap.ga_cpp;
	 if(alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false){
		document.getElementById('p2').style.color ='red';
		document.getElementById('ga_cpe').focus();
		return false;
	}else{
		 document.getElementById('p2').style.color ='';
		 }


	alter_box[0] = window.document.revpap.ga_ife;
	alter_box[1] = window.document.revpap.ga_ifg;
	alter_box[2] = window.document.revpap.ga_iff;
	alter_box[3] = window.document.revpap.ga_ifp;
	 if(alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false){
		document.getElementById('p2').style.color ='red';
		document.getElementById('ga_ife').focus();
		return false;
	}else{
		 document.getElementById('p2').style.color ='';
		 }

	alter_box[0] = window.document.revpap.ta;
	alter_box[1] = window.document.revpap.tn;
	 if(alter_box[0].checked==false && alter_box[1].checked==false){
		document.getElementById('p3').style.color ='red';
		document.getElementById('ta').focus();
		return false;
	}else{
		 document.getElementById('p3').style.color ='';
		 }

	alter_box[0] = window.document.revpap.lg;
	alter_box[1] = window.document.revpap.ln;
	 if(alter_box[0].checked==false && alter_box[1].checked==false){
		document.getElementById('p4').style.color ='red';
		document.getElementById('lg').focus();
		return false;
	}else{
		 document.getElementById('p4').style.color ='';
		 }

	alter_box[0] = window.document.revpap.aca;
	alter_box[1] = window.document.revpap.asr;
	alter_box[2] = window.document.revpap.asc;
	alter_box[3] = window.document.revpap.am;
	 if(alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false){
		document.getElementById('p5').style.color ='red';
		document.getElementById('aca').focus();
		return false;
	}else{
		 document.getElementById('p5').style.color ='';
		 }

	alter_box[0] = window.document.revpap.pg;
	alter_box[1] = window.document.revpap.ptb;
	alter_box[2] = window.document.revpap.ptl;
	alter_box[3] = window.document.revpap.pc;
	alter_box[4] = window.document.revpap.ps;
	 if(alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false){
		document.getElementById('p6').style.color ='red';
		document.getElementById('pg').focus();
		return false;
	}else{
		 document.getElementById('p6').style.color ='';
		 }

	alter_box[0] = window.document.revpap.ig;
	alter_box[1] = window.document.revpap.ie;
	alter_box[2] = window.document.revpap.iq;
	alter_box[3] = window.document.revpap.iff;
	 if((alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false)  || (alter_box[3].checked==true && window.document.revpap.iff_txt.value=='')){
		document.getElementById('p7').style.color ='red';
		document.getElementById('ig').focus();
		return false;
	}else{
		 document.getElementById('p7').style.color ='';
		 }

	alter_box[0] = window.document.revpap.tg;
	alter_box[1] = window.document.revpap.ts;
	alter_box[2] = window.document.revpap.tt;
	 if((alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false) || (alter_box[2].checked==true && window.document.revpap.tt_txt.value=='') ){
		document.getElementById('p8').style.color ='red';
		document.getElementById('tg').focus();
		return false;		
	}else{
		 document.getElementById('p8').style.color ='';
		 }

	alter_box[0] = window.document.revpap.afu_c;
	alter_box[1] = window.document.revpap.afu_n;
	alter_box[2] = window.document.revpap.afu_s;
	alter_box[3] = window.document.revpap.afu_a;
	 if(alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false){
		document.getElementById('p9').style.color ='red';
		document.getElementById('afu_c').focus();
		return false;
	}else{
		 document.getElementById('p9').style.color ='';
		 }

	alter_box[0] = window.document.revpap.ra;
	alter_box[1] = window.document.revpap.rin;
	alter_box[2] = window.document.revpap.ri;
	alter_box[3] = window.document.revpap.rt;
	 if(alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false){
		document.getElementById('p10').style.color ='red';
		document.getElementById('ra').focus();
		return false;
	}else{
		 document.getElementById('p10').style.color ='';
		 }

	alter_box[0] = window.document.revpap.gae;
	alter_box[1] = window.document.revpap.gag;
	alter_box[2] = window.document.revpap.gaw;
	alter_box[3] = window.document.revpap.gam;
	 if((alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false)   || (alter_box[3].checked==true && window.document.revpap.ga_txt.value=='')){
		document.getElementById('p11').style.color ='red';
		document.getElementById('gae').focus();
		return false;
	}else{
		 document.getElementById('p11').style.color ='';
		 }

	alter_box[0] = window.document.revpap.reca;
	alter_box[1] = window.document.revpap.recam;
	alter_box[2] = window.document.revpap.recama;
	alter_box[3] = window.document.revpap.recad;
	 if(alter_box[0].checked==false && alter_box[1].checked==false && alter_box[2].checked==false && alter_box[3].checked==false){
		document.getElementById('p12').style.color ='red';
		document.getElementById('reca').focus();
		return false;
	}else{
		 document.getElementById('p12').style.color ='';
		 }

	 if(window.document.revpap.signature.value==''){
		document.getElementById('sig').style.color ='red';
		document.getElementById('signature').focus();
		return false;
	}else{
		 document.getElementById('sig').style.color ='';
		 }


return confirm("You cannot undo the review. Are you sure you want to continue ?")
  }   

</script>

<style type="text/css">
<!--
table_brd {
	border: 1px solid #000;
}
.table_bdr {
	border: 1px solid #000;
}
-->
</style>
<h2>Paper Revision Form</h2>
<form class="form" name="revpap" id="revpap" method="post" action="">
<input type="hidden" name="cod_abs" value="<?=$cod_abs;?>" />
<input type="hidden" name="cod_paper" value="<?=$cod_paper;?>" />

  <table width="98%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="left"><h4>Paper n&ordm;</h4></td>
      <td width="15" rowspan="6">&nbsp;</td>
      <td align="left"><h4>Authors</h4></td>
    </tr>
    <tr>
      <td align="left" class="table_bdr">&nbsp;p-<?=$cod_paper;?></td>
      <td rowspan="2" align="left" class="table_bdr">&nbsp;<?=$abs[0][2];?></td>
    </tr>
    <tr>
      <td align="left"><h4>Date sent</h4></td>
    </tr>
    <tr>
      <td align="left" class="table_bdr">&nbsp;<?=$paper[0][1];?></td>
      <td align="left"><h4>Title</h4></td>
    </tr>
    <tr>
      <td align="left"><h4>Reviewer</h4></td>
      <td rowspan="2" align="left" class="table_bdr">&nbsp;<?=$abs[0][1];?></td>
    </tr>
    <tr>
      <td align="left" class="table_bdr">&nbsp;<?=$reviewer[0][0];?></td>
    </tr>
  </table>
  <p></p>
  <p><strong>Please tick as appropriate and expand where necessary on the comments for editors field bellow</strong></p>
  <p id="p1"><strong>1.Subject topic</strong></p>
  <blockquote style="text-align:left">
    <p>
      <input type="checkbox" name="stw" id="stw" onClick="swit('stn',0);" />
      Within the scope of <?=$staticvars['name'];?><br />
      <input type="checkbox" name="stn" id="stn" onClick="swit('stn',1);"/>
Not appropriate for <?=$staticvars['name'];?>    </p>
  </blockquote>
  <p id="p2"><strong>2.General Assessment</strong></p>
  <blockquote style="text-align:left">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="150">&nbsp;</td>
        <td width="20" rowspan="5">&nbsp;</td>
        <td align="center"><strong>Excellent</strong></td>
        <td width="20" rowspan="5" align="center">&nbsp;</td>
        <td align="center"><strong>Good</strong></td>
        <td width="20" rowspan="5" align="center">&nbsp;</td>
        <td align="center"><strong>Fair</strong></td>
        <td width="20" rowspan="5" align="center">&nbsp;</td>
        <td align="center"><strong>Poor</strong></td>
      </tr>
      <tr>
        <td align="left">Originality</td>
        <td width="70" align="center"><input type="checkbox" name="ga_oe" id="ga_oe" onClick="swit('o',0);" /></td>
        <td width="70" align="center"><input type="checkbox" name="ga_og" id="ga_og" onClick="swit('o',1);" /></td>
        <td width="70" align="center"><input type="checkbox" name="ga_of" id="ga_of" onClick="swit('o',2);" /></td>
        <td width="70" align="center"><input type="checkbox" name="ga_op" id="ga_op" onClick="swit('o',3);" /></td>
      </tr>
      <tr>
        <td align="left">Technical Quality</td>
        <td align="center"><input type="checkbox" name="ga_tqe" id="ga_tqe" onClick="swit('tq',0);" /></td>
        <td align="center"><input type="checkbox" name="ga_tqg" id="ga_tqg" onClick="swit('tq',1);" /></td>
        <td align="center"><input type="checkbox" name="ga_tqf" id="ga_tqf" onClick="swit('tq',2);" /></td>
        <td align="center"><input type="checkbox" name="ga_tqp" id="ga_tqp" onClick="swit('tq',3);" /></td>
      </tr>
      <tr>
        <td align="left">Clarity of Presentation</td>
        <td align="center"><input type="checkbox" name="ga_cpe" id="ga_cpe" onClick="swit('cp',0);" /></td>
        <td align="center"><input type="checkbox" name="ga_cpg" id="ga_cpg" onClick="swit('cp',1);" /></td>
        <td align="center"><input type="checkbox" name="ga_cpf" id="ga_cpf" onClick="swit('cp',2);" /></td>
        <td align="center"><input type="checkbox" name="ga_cpp" id="ga_cpp" onClick="swit('cp',3);" /></td>
      </tr>
      <tr>
        <td align="left">Importance in Field</td>
        <td align="center"><input type="checkbox" name="ga_ife" id="ga_ife" onClick="swit('if',0);" /></td>
        <td align="center"><input type="checkbox" name="ga_ifg" id="ga_ifg" onClick="swit('if',1);" /></td>
        <td align="center"><input type="checkbox" name="ga_iff" id="ga_iff" onClick="swit('if',2);" /></td>
        <td align="center"><input type="checkbox" name="ga_ifp" id="ga_ifp" onClick="swit('if',3);" /></td>
      </tr>
    </table>
  </blockquote>
  <table width="98%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="49%"><p id="p3"><strong>3.Title</strong></p></td>
      <td width="15" rowspan="17">&nbsp;</td>
      <td valign="top"><p id="p4"><strong>4.Language</strong></p></td>
    </tr>
    <tr>
      <td width="49%" valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="ta" id="ta" onClick="swit('t',0);" />
        Accuratly reflects contents<br />
        <input type="checkbox" name="tn" id="tn" onClick="swit('t',1);" />
        Needs revision (suggest alternative)
      </blockquote></td>
      <td valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="lg" id="lg" onClick="swit('l',0);"/>
        Grammatically good
        <br />
        <input type="checkbox" name="ln" id="ln" onClick="swit('l',1);"/>
        Needs revision
      </blockquote></td>
    </tr>
    <tr>
      <td width="49%" height="20" valign="top">&nbsp;</td>
      <td height="20" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="49%" valign="top"><p id="p5"><strong>5.Abstract</strong></p></td>
      <td valign="top"><p id="p6"><strong>6.Presentation</strong></p></td>
    </tr>
    <tr>
      <td width="49%" valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="aca" id="aca" onClick="swit('a',0);"/>
        Clear and adequate<br />
        <input type="checkbox" name="asr" id="asr" onClick="swit('a',1);"/>
        Should be rewritten<br />
        <input type="checkbox" name="asc" id="asc" onClick="swit('a',2);"/>
        Should be condensed<br />
        <input type="checkbox" name="am" id="am" onClick="swit('a',3);"/>
      Missing</blockquote></td>
      <td valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="pg" id="pg" onClick="swit('p',0);"/>
        Good<br />
        <input type="checkbox" name="ptb" id="ptb" onClick="swit('p',1);"/>
        Too Brief<br />
        <input type="checkbox" name="ptl" id="ptl" onClick="swit('p',2);"/>
        Too lengthy<br />
        <input type="checkbox" name="pc" id="pc" onClick="swit('p',3);"/>
        Containing irrelevant material<br />
        <input type="checkbox" name="ps" id="ps" onClick="swit('p',4);"/>
      Should be rearranged</blockquote></td>
    </tr>
    <tr>
      <td width="49%" height="20" valign="top">&nbsp;</td>
      <td height="20" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="49%" valign="top"><p id="p7"><strong>7.Illustrations</strong></p></td>
      <td valign="top"><p id="p8"><strong>8.Tables</strong></p></td>
    </tr>
    <tr>
      <td width="49%" valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="ig" id="ig" onClick="swit('i',0);"/>
        Good<br />
        <input type="checkbox" name="ie" id="ie" onClick="swit('i',1);"/>
        Extra figures required<br />
        <input type="checkbox" name="iq" id="iq" onClick="swit('i',2);"/>
        Quality inadequate<br />
        <input type="checkbox" name="iff" id="iff" onClick="swit('i',3);"/>
      Fig(s) 
      <input name="iff_txt" type="text" id="iff_txt" size="10" maxlength="255" onClick="swit('i',3);"/>
      may be omitted</blockquote></td>
      <td valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="tg" id="tg" onClick="swit('tab',0);"/>
        Good<br />
        <input type="checkbox" name="ts" id="ts" onClick="swit('tab',1);"/>
        Should be rearranged<br />
        <input type="checkbox" name="tt" id="tt" onClick="swit('tab',2);"/>
        Tables 
       
        <input name="tt_txt" type="text" id="tt_txt" size="10" maxlength="255" onClick="swit('tab',2);"/>
may be omitted</blockquote></td>
    </tr>
    <tr>
      <td width="49%" height="20" valign="top">&nbsp;</td>
      <td height="20" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="49%" valign="top"><p id="p9"><strong>9.Abbreviations, formulae, units</strong></p></td>
      <td valign="top"><p id="p10"><strong>10.References</strong></p></td>
    </tr>
    <tr>
      <td width="49%" valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="afu_c" id="afu_c" onClick="swit('afu',0);"/>
        Conform to acceptable standards<br />
        <input type="checkbox" name="afu_n" id="afu_n" onClick="swit('afu',1);"/>
        Need revision<br />
        <input type="checkbox" name="afu_s" id="afu_s" onClick="swit('afu',2);"/>
        Should be explained<br />
        <input type="checkbox" name="afu_a" id="afu_a" onClick="swit('afu',3);"/>
      A notation list is necessary</blockquote></td>
      <td valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="ra" id="ra" onClick="swit('r',0);"/>
        Appropriate<br />
        <input type="checkbox" name="rin" id="rin" onClick="swit('r',1);"/>
        Incorrect<br />
        <input type="checkbox" name="ri" id="ri" onClick="swit('r',2);"/>
        Insufficient<br />
        <input type="checkbox" name="rt" id="rt" onClick="swit('r',3);"/>
      Too extensive</blockquote></td>
    </tr>
    <tr>
      <td width="49%" height="20" valign="top">&nbsp;</td>
      <td height="20" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td width="49%" valign="top"><p id="p11"><strong>11.Grading of article</strong></p></td>
      <td valign="top"><p id="p12"><strong>12.Recommendation</strong></p></td>
    </tr>
    <tr>
      <td width="49%" valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="gae" id="gae" onClick="swit('ga',0);"/>
        Excellent<br />
        <input type="checkbox" name="gag" id="gag" onClick="swit('ga',1);"/>
        Good<br />
        <input type="checkbox" name="gaw" id="gaw" onClick="swit('ga',2);"/>
        Weak<br />
        <input type="checkbox" name="gam" id="gam" onClick="swit('ga',3);"/>
      Mark Awarded (%) 
      <input name="ga_txt" type="text" id="ga_txt" size="5" maxlength="3" onClick="swit('ga',3);"/>
      </blockquote></td>
      <td valign="top"><blockquote style="text-align:left">
        <input type="checkbox" name="reca" id="reca" onClick="swit('rec',0);"/>
        Accept<br />
        <input type="checkbox" name="recam" id="recam" onClick="swit('rec',1);"/>
        Accept after minor amendments<br />
        <input type="checkbox" name="recama" id="recama" onClick="swit('rec',2);"/>
        Major amendments required<br />
        <input type="checkbox" name="recad" id="recad"onClick="swit('rec',3);" />
      Do not accept</blockquote></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top"><p id="sig"><strong>Signature</strong> <font style="font-size:9px">(write your full name)</font></p></td>
      <td valign="top"><p id="dat"><strong>Date</strong></p></td>
    </tr>
    <tr>
      <td width="49%" valign="top"><input style="width:98%" name="signature" type="text" id="signature" maxlength="255" /></td>
      <td valign="top"><input name="date" disabled="disabled"  value="<?=date('Y/m/d');?>" type="text" id="date" size="25" maxlength="255" /></td>
    </tr>
  </table>
  <p><strong>Comments for the editors</strong></p>
  <p>
    <textarea name="comment_editor" rows="10" id="comment_editor" style="width:98%"></textarea>
    <br />
</p>
  <p> <strong>Comments for the authors</strong></p>
  <p>
    <textarea name="comment_author" rows="10" id="comment_author" style="width:98%"></textarea>
  </p>
<p>&nbsp;</p>
  <p align="center">
    <input type="submit" onclick="return confirmAction()" name="submit_revpaper" id="submit_revpaper" value="Submit review" />
  </p>
  <p>&nbsp;</p>
</form>

