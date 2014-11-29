<?php
function list_one_news($staticvars['local_root']){
include($staticvars['local_root'].'kernel/staticvars.php'); 
include_once($staticvars['local_root'].'modules/news/system/bbcode_main.php'); 

$header=strip_address('id',$_SERVER['REQUEST_URI']);
$header=strip_address('news',$header);
$header=strip_address('all',$header);
$tmp=strpos($header,"?");
if ($tmp === false):
	$header2=$header.'?id='.$task_id;
else:
	$header2=$header.'&id='.$task_id;
endif;
$query=$db->getquery("select title, texto, data, image from news where active='s' and cod_news='".mysql_escape_string($_GET['news'])."'");
if ($query[0][0]<>''):
	$subject=$query[0][0];
	$message=$query[0][1];
	if ($query[0][3]=='' or $query[0][3]=='no_img.gif'):
		$image=$staticvars['site_path'].'/modules/news/images/no_img.gif';
	else:
		$image=$upload_path.'/news/images/'.$query[0][3];
	endif;
	$txt=load_txt($message);
	?>
	  <tr>
	    <td colspan="3"><img src="<?=$staticvars['site_path'];?>/images/noticias.gif" border="0">&nbsp;<font class="header_text_1"><?=$subject;?>
	    </font></td>
	  </tr>
	  <tr>
	    <td width="1"></td>
		<td width="840"><?='<font class="body_text">'.format_data($query[0][2]).'</font>';?></td>
	    <td width="127" align="right" class="body_text">[<a href="<?=$header2;?>">Ver t&iacute;tulos</a>]</td>
	  </tr>
	  <tr>
	    <td colspan="3" height="10"></td>
      </tr>
	  <tr>
		<td colspan="3" height="10"><hr size="1"></td>
	  </tr>
	  <tr>
		<td colspan="3">
		  <table width="100%">
		    <tr>
			  <td width="20"></td>
			  <td width="80" valign="top"><img src="<?=$image;?>" border="0"></td>
			  <td width="10">&nbsp;</td>
			  <td><div align="justify"><font class="body_text"><?=$txt;?></font></div></td>
	  	      <td width="20"></td>
		  </tr>
		  </table>		</td>
	  <tr>
	    <td colspan="3"height="10"><hr size="1"></td>
      </tr>
	  <tr>
	    <td colspan="3"></td>
      </tr>
<?php
else:
	echo 'notícia nao encontrada!';
endif;
};


function list_all_news($staticvars['local_root']){
include($staticvars['local_root'].'kernel/staticvars.php'); 
include_once($staticvars['local_root'].'modules/news/system/bbcode_main.php'); 
include_once($staticvars['local_root'].'general/return_module_id.php');

$query=$db->getquery("select title, cod_news,data, texto from news where active='s' order by data DESC");
if ($query[0][0]==''):
	return;
endif;
$task_id=return_id('news/main.php');
$header=strip_address('id',$_SERVER['REQUEST_URI']);
$header=strip_address('news',$header);
$header=strip_address('all',$header);
$tmp=strpos($header,"?");
if ($tmp === false):
	$header2=$header.'?id='.$task_id;
	$header.='?id='.$task_id.'&news=';
else:
	$header2=$header.'&id='.$task_id;
	$header.='&id='.$task_id.'&news=';
endif;

for ($i=0;$i<count($query);$i++):
	$subject=$query[$i][0];
	$txt=load_txt($query[$i][3]);
	$txt=substr($txt,0,strpos($txt,".")).'.';
	?>
	  <tr>
		<td colspan="3" valign="middle"><h3><img src="<?=$staticvars['site_path'];?>/images/noticias.gif" border="0" align="baseline">&nbsp;<?=$subject;?></h3></td>
	  </tr>
	  <tr>
		<td><?='<font class="body_text">'.format_data($query[$i][2]).'</font>';?></td>
	    <td>&nbsp;</td>
	    <td class="body_text" align="right"></td>
	  </tr>
	  <tr>
	    <td colspan="3"><font class="body_text"><br /><?=$txt;?></font><br /><br />
		<font class="body_text"><a href="<?=$header.$query[$i][1];?>">ler noticia...</a></font></td>
      </tr>
	  <tr>
	    <td colspan="3"height="10"><hr size="1"></td>
      </tr>
	<?php
endfor;
};

function general_news($task,$staticvars['local_root']){
include($staticvars['local_root'].'kernel/staticvars.php');
include_once($staticvars['local_root'].'general/return_module_id.php');
$task_id=return_id('news/main.php');
$query=$db->getquery("select texto, title, image, cod_news,data from news where active='s' order by data DESC");
$header=strip_address('id',$_SERVER['REQUEST_URI']);
$header=strip_address('news',$header);
$header=strip_address('all',$header);
if ($query[0][0]<>''):
?>
		  <tr>
		    <td width="20"  valign="bottom">&nbsp;</td>
		    <td  valign="bottom">
			<?php
			if (count($query)>0):
			 put_preview($query[0],$header,$task,$staticvars['local_root']);
			 endif;
			?>
			</td>
		    <td width="20"  valign="bottom">&nbsp;</td>
		  </tr>
		  <tr>
		    <td width="20"  valign="bottom">&nbsp;
			</td>
		    <td  valign="bottom">
			<?php
			if (count($query)>1):
			 put_preview($query[1],$header,$task,$staticvars['local_root']);
			 endif;
			?>
			</td>
		    <td width="20"  valign="bottom">&nbsp;</td>
		  </tr>
		  <tr>
		    <td width="20"  valign="bottom">&nbsp;
			</td>
		    <td  valign="bottom">
			<?php
			if (count($query)>2):
			 put_preview($query[2],$header,$task,$staticvars['local_root']);
			 endif;
			?>
			</td>
		    <td width="20"  valign="bottom">&nbsp;</td>
		  </tr>
<?php
else:
?>
		  <tr>
		    <td width="20"  valign="bottom">&nbsp;</td>
		    <td  valign="bottom" class="body_text" align="center">Sem Informa&ccedil;&otilde;es relevantes de momento.<br />Por favor tente mais tarde.</td>
		    <td width="20"  valign="bottom">&nbsp;</td>
		  </tr>
<?php
endif;
};




function put_preview($query,$header,$task,$staticvars['local_root']){
include($staticvars['local_root'].'kernel/staticvars.php'); 
include_once($staticvars['local_root'].'modules/news/system/bbcode_main.php'); 
include_once($staticvars['local_root'].'general/return_module_id.php');
$task_id=return_id('news/main.php');
	$message=$query[0];
	$subject=$query[1];
	$image=$query[2];
	$txt=load_txt($message);
	$tmp=strpos($header,"?");
	if ($tmp === false):
		$header2=$header.'?id='.$task_id.'&all=true';
		$header.='?id='.$task_id.'&news='.$query[3];
	else:
		$header2=$header.'&id='.$task_id.'&all=true';
		$header.='&id='.$task_id.'&news='.$query[3];
	endif;
	$txt=load_txt($query[0]);
	$txt=substr($txt,0,strpos($txt,".")).'.';
?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td colspan="2"><h3><img src="<?=$staticvars['site_path'];?>/images/noticias.gif" border="0">&nbsp;<?=$subject;?></h3></td>
	    <td width="11%" valign="baseline"></td>
	  </tr>
	  <tr>
		<td width="30%"><?='<font class="body_text">'.format_data($query[4]).'</font>';?>		</td>
	    <td width="59%">&nbsp;</td>
	    <td class="body_text" align="right">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="3"><font class="body_text"><font class="body_text"><br /><?=$txt;?></font><br /><br />
        <a href="<?=$header;?>">ler noticia...</a></font></td>
	  </tr>
	  <tr>
	    <td colspan="3"height="10"><hr size="1"></td>
      </tr>
	</table>	
<?php
};
?>