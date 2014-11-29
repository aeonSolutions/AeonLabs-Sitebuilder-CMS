<?php
include($globvars['site']['directory'].'kernel/staticvars.php');
$task=@$_GET['id'];
include($globvars['site']['directory'].'kernel/settings/layout.php');
$link=strip_address("type",$_SERVER['REQUEST_URI']);
?>
<div align="right"><a href="<?=$link;?>"><img border="0" title="go to previous" src="<?=$globvars['site_path'].'/images/back.png';?>" /></a></div><h3><img src="<?=$globvars['site_path'];?>/images/layout.gif" alt="Layout" /> With this option you can publish or unpublish a layout, delete or change a template filename.</h3></p>
<p>&nbsp;</p>
<form method="post" action="" enctype="multipart/form-data">
  <div align="center">Choose a layout file to see the details:    
    <select size="1" name="ut" class="form_input" <? if($layout=='static') echo ' disabled="disabled"';?>>
      <?php
        if ($layout=='dynamic'):	
            $query=$db->getquery("select cod_skin, ficheiro from skin");
            $selected=0;
            $option[0][0]='';
            $option[0][1]='-----------------';
            if($query[0][0]<>''):
                for ($i=0;$i<count($query);$i++):
                    $option[$i+1][0]=$query[$i][0];
                    $option[$i+1][1]=$query[$i][1];
                    if ($query[$i][0]==$user):
                        $selected=$i;
                    endif;
                endfor;
            endif;
        else:
            $selected=0;
            $option[0][0]=$layout_name;
            $option[0][1]=$layout_name;
        endif;
        for ($i=0 ; $i<count($option); $i++):
            ?>
      <option value="<?php echo $option[$i][0];?>" <?php if ($selected==$i){?>selected<?php } ?>>
      <?=$option[$i][1];?>
      </option>
      <?php
        endfor; ?>
    </select>
    &nbsp;&nbsp; 
    <input class="form_submit" value=" view " type="submit" <? if($layout=='static') echo ' disabled="disabled"';?> name="user_input">
  </div>
</form>

<?php
if (isset($_POST['user_input'])):
	$mod=mysql_escape_string($_POST['ut']);
	$query_a=$db->getquery("select ficheiro, cod_skin, active, default_cell, num_cells from skin where cod_skin='".$mod."'");
	if ($query_a[0][0]==''):
		no_code();
		exit;
	endif;
	if($query_a[0][2]=='s'):
		$pub='Sim';
		$name='unpublish';
		$value='nao_publicar';
	else:
		$name='publish';
		$value='publicar';
		$pub='N&atilde;o';
	endif;
	$file=$query_a[0][0];
	$skin=$query_a[0][1];
	?>
	<table border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td>
		<form method="post" action="<?=session_setup($globvars,$site_path.'/index.php?id='.$task.'&mod='.$mod);?>"  enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td colspan="2" align="center">
			<font class="body_text"><strong>Código da Skin: <?=$query_a[0][1];?>,&nbsp;Skin activa: <?=$pub;?></strong></font>		</td>
		  </tr>
		  <tr>
			<td height="5" colspan="2"></td>
		  </tr>
		  <tr>
			<td colspan="2">
				<font class="body_text">Nome do ficheiro</font>&nbsp;&nbsp;&nbsp;
				<input type="text" name="skin_name" value="<?=$query_a[0][0];?>" maxlength="255" size="40">		</td>
		  </tr>
		  <tr>
			<td height="5" colspan="2"></td>
		  </tr>
		  
		  <tr>
			<td align="right" valign="bottom">
		      <input name="add_sub_menu" type="image" src="<?=$globvars['site_path'].'/images/buttons/en/gravar.gif';?>">		</td>
		  </tr>
		  </table>
		  </form>    </td>
		<td valign="bottom" align="left">
			<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>" target="_parent">
			  &nbsp;&nbsp;
			  <input type="hidden" name="skin_code" value="<?=$name;?>" />
			  <input name="apagar" src="<?=$globvars['site_path'].'/images/buttons/en/'.$value.'.gif';?>" type="image">
			</form>	</td>
		<td valign="bottom" align="left">
			<form method="POST" action="<?=session_setup($globvars,$globvars['site_path'].'/index.php?id='.$task.'&mod='.$mod);?>" target="_parent">
			  &nbsp;&nbsp;<input type="hidden" name="del_skin" value="<?=$query_a[0][1];?>">
				<input name="apagar" src="<?=$globvars['site_path'].'/images/buttons/en/';?>apagar.gif" type="image">
			</form>    </td>
	  </tr>
		  <tr>
			<td height="10" colspan="2"></td>
		  </tr>
	</table>
	<br />
	<iframe src="<?=session_setup($globvars,$globvars['site_path'].'/siteedit/advanced/layout/layout_frame.php?file='.$file.'&skin='.$skin.'&id=3');?>" name="target_iframe" width="100%" height="600" align="center" scrolling="Auto" frameborder="0" id="target_iframe"></iframe>
<?php
endif;

?>