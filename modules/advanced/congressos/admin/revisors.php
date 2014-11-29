<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_POST['del']) or isset($_POST['del_topic']) or isset($_POST['select_theme'])):
		include($staticvars['local_root'].'modules/congressos/update_db/revisors.php');
		session_write_close();
		sleep(1);
		header("Location: ".$_SERVER['REQUEST_URI']);
endif;


if(isset($_SESSION['message'])):
	echo $_SESSION['message'];
	unset($_SESSION['message']);
	
endif;
?>
<h1><img src="modules/congressos/images/accounts_big.gif">Gestao de Revisores</h1>
<p align="center">
<a href="<?=$_SERVER['REQUEST_URI'];?>" >Ver todos os revisores</a></p>
<hr size="1" />
<?php
if(isset($_POST['edit'])):// assign
	$ucode=mysql_escape_string($_POST['cod_user']);
	$query=$db->getquery("select cod_user, nome, email from users where cod_user='".$ucode."'");
	if ($query[0][0]<>''):

		$congress_revisor=$db->getquery("select cod_theme, cod_revisor from congress_revisor where cod_user='".$ucode."'");
		$theme=$db->getquery("select cod_theme, name, cod_topic from congress_themes where cod_topic='0'");
		$topic=$db->getquery("select cod_theme, name, cod_topic from congress_themes where cod_topic<>'0'");
		
		$cloud=array();
		$b=0;
		$tag='<ul>';
		for($v=0;$v<count($congress_revisor);$v++):
			$g=0;
			for($j=0;$j<count($theme);$j++):
				if($congress_revisor[$v][0]==$theme[$j][0]):
					$cloud[$b]=$theme[$j][0];
					$b++;
					$in='';
					for($l=0;$l<count($topic);$l++):
						if($topic[$l][0]==$theme[$j][2]):
							$nam=rand(0,5000);
						    $in='lkjh';
							$tag=$tag.'<li><form action="" name="th'.$nam.'" id="th'.$nam.'" method="post" enctype="multipart/form-data">'.$theme[$j][1].'>'.$topic[$l][1].'<input type="hidden" name="cod_user" value="'.$congress_revisor[$v][1].'"><input type="hidden" name="theme" value="'.$topic[$l][0].'"><input type="hidden" name="del_topic" value="">&nbsp;&nbsp;&nbsp;&nbsp;[<a href="javascript:document.th'.$nam.'.submit();">Apagar</a>]</form></';
						endif;
					endfor;
					if($in==''):
						$nam=rand(0,5000);
						$tag=$tag.'<li><form action="" name="th'.$nam.'" id="th'.$nam.'" method="post" enctype="multipart/form-data">'.$theme[$j][1].'<input type="hidden" name="cod_user" value="'.$congress_revisor[$v][1].'"><input type="hidden" name="theme" value="'.$theme[$j][0].'"><input type="hidden" name="del_topic" value="">&nbsp;&nbsp;&nbsp;&nbsp;[<a href="javascript:document.th'.$nam.'.submit();">Apagar</a>]</form></li>';
					endif;
				endif;
			endfor;
		endfor;
		$tag.='</ul>';
		if ($tag=='<ul>'):
			$tag='No theme assigned';
		endif;

		$query2=$theme;
		$sub_query=$topic;
		if ($query2[0][0]<>''):
			$option[0][0]='';
			$option[0][1]='SELECT ONE';
			$k=1;
			for ($i=0;$i<count($query2);$i++):
				if(in_array($query2[$i][0],$cloud)):
					$option[$k][0]='optgroup';
					$option[$k][1]=$query2[$i][1].' [Theme]';
				else:
					$option[$k][0]=$query2[$i][0];
					$option[$k][1]=$query2[$i][1].' [Theme]';
				endif;
				$k++;
				for ($j=0;$j<count($sub_query);$j++):
					if($query2[$i][0]==$sub_query[$j][2]):
						if(in_array($sub_query[$j][0],$cloud)):
							$option[$k][0]='disabled';
							$option[$k][1]=$sub_query[$j][1];
						else:
							$option[$k][0]=$sub_query[$j][0];
							$option[$k][1]='&nbsp;&nbsp;&nbsp;&nbsp;'.$sub_query[$j][1].' [Topic]';
						endif;
						$k++;
					endif;
				endfor;
			endfor;
		endif;
		?>
        <h2>Editar Temas geridos</h2>
		<p><strong>Nome:</strong> <?=$query[0][1];?><br />
		<strong>Email:</strong> <?=$query[0][2];?><br /></p>
        <p></p>
		<p>Temas atribuidos:<br />
		<?php
			echo $tag;
		?>
		</p>
        <p></p>
        <form action="" method="post" enctype="multipart/form-data" class="form" name="theme_form" id="theme_form">
            <h4>Adicionar Tema<br />
                <select size="1" name="theme" class="text">
                    <?php
                    for ($i=0 ; $i<count($option); $i++):
						 if ($option[$i][0]=='optgroup'):
						 ?>
							<optgroup disabled label="<?=$option[$i][1];?>"></optgroup>
						 <?php
						 elseif ($option[$i][0]=='disabled'):
							?>
							<option disabled="disabled" value="" ><?=$option[$i][1]; ?></option>
							<?php
						 else:
							?>
							<option value="<?=$option[$i][0];?>" ><?=$option[$i][1]; ?></option>
							<?php
						endif;
                    endfor; ?>
                </select>
                <input type="hidden" value="<?=$ucode;?>" name="cod_user" />
              <div align="right"><input type="submit" name="select_theme" id="select_theme" value="Adicionar" class="button" /></div>
            </h4>
        </form>
        <?php
	else:
		echo 'Revisor nao encontrado!';
	endif;

else:
	$ut=$db->getquery("select cod_user_type from user_type where name='revisor'");
	$query=$db->getquery("select cod_user, cod_user_type, nome, email from users where cod_user_type='".$ut[0][0]."'");
	if ($query[0][0]<>''):
		$congress_revisor=$db->getquery("select cod_revisor, cod_user, cod_theme from congress_revisor");
		$theme=$db->getquery("select cod_theme, name, cod_topic from congress_themes where cod_topic='0'");
		$topic=$db->getquery("select cod_theme, name, cod_topic from congress_themes where cod_topic<>'0'");
		
		echo '<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">';
		echo '<tr height="15"><td colspan="2">';
		echo '</td></tr>';
		for ($k=0;$k<count($query);$k++):
			$pos[0]=-1;
			$h=0;
			for($j=0;$j<count($congress_revisor);$j++):
				if($congress_revisor[$j][1]==$query[$k][0]):
					$pos[$h]=$j;
					$h++;
				endif;
			endfor;
			$tag='';
			for($h=0;$h<count($pos);$h++):
				for($j=0;$j<count($theme);$j++):
					if($congress_revisor[$pos[$h]][2]==$theme[$j][0]):
						$tag=$tag.$theme[$j][1];
						for($l=0;$l<count($topic);$l++):
							if($topic[$l][0]==$theme[$j][2]):
								$tag=$tag.'>'.$topic[$l][1].'&nbsp;&nbsp;';
								break;
							endif;
						endfor;
						$tag.='<br>';
					endif;
				endfor;
			endfor;
			if ($tag==''):
				$tag='No theme assigned';
			endif;
			echo '<tr><td><div align="left"><b>'.$query[$k][2].'</b>&nbsp;( '.$query[$k][3].')<br>';
			echo '<font style="font-size:x-small">'.$tag.'</font></div>';
			echo'</td></tr><tr><td><form class="form" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'" method="post">';
			echo '<div align="right"><input class="button" name="edit" type="submit" value=" Editar "><input type="hidden" name="cod_user" value="'.$query[$k][0].'"></div>';
			echo '</form></td></tr>';
		endfor;
		echo '<tr height="15"><td colspan="2">';
		echo '</td></tr></table>';
	else:
		echo 'nao há revisores inseridos no sistema';
	endif;
endif;



?>