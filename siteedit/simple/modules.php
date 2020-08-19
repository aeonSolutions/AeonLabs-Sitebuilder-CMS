<?php
/*
File revision date: 14-Nov-2006
*/
if ( !defined('ON_SiTe')):
echo 'not for direct access';
exit;
endif;

if (isset($_POST['modulei'])):
	include_once($globvars['local_root'].'copyfiles/advanced/general/recursive_copy.php');
	$dir=glob($globvars['local_root']."modules/simple/*",GLOB_ONLYDIR);
	if ($dir[0]<>''):
		echo '<font class="body_text"> <font color="#FF0000">Instala&ccedil;&atilde;o Autom&aacute;tica de Modulos:';
		$install=false;
		for($i=0;$i<count($dir);$i++):
			$dirX=explode("/",$dir[$i]);
			if (isset($_POST[$dirX[count($dirX)-1]])):
				unset($_POST[$dirX[count($dirX)-1]]);
				copyr($globvars['local_root'].'modules/simple/'.$dirX[count($dirX)-1],$globvars['site']['directory'].'/modules/'.$dirX[count($dirX)-1],$globvars);
				$install=true;
			endif;
		endfor;
		echo '</font></font>';
	else:
		echo "n&atilde;o ha módulos no directorio!";
	endif;
	header("Location: ".strip_address("step",strip_address("type",strip_address("file",$_SERVER['REQUEST_URI']))));
	exit;
endif;

if (isset($_POST['moduled'])):
	include_once($globvars['local_root'].'copyfiles/advanced/general/recursive_copy.php');
	$dir=glob($globvars['site']['directory']."modules/*",GLOB_ONLYDIR);
	if ($dir[0]<>''):
		echo '<font class="body_text"> <font color="#FF0000">Eliminação de Modulos:';
		for($i=0;$i<count($dir);$i++):
			$dirX=explode("/",$dir[$i]);
			if (isset($_POST[$dirX[count($dirX)-1]])):
				unset($_POST[$dirX[count($dirX)-1]]);
				delr($globvars,$globvars['site']['directory'].'modules/'.$dirX[count($dirX)-1]);
			endif;
		endfor;
		echo '</font></font>';
	else:
		echo "n&atilde;o ha módulos no directorio!";
	endif;
	header("Location: ".strip_address("step",strip_address("type",strip_address("file",$_SERVER['REQUEST_URI']))));
	exit;
endif;

?>
<style>
.equal {
    display:table;
	margin:10px auto;
	border-spacing:10px;
	width:100%;
}
.row {
    display:table-row;
}
.row div {
    display:table-cell;
}

.row div.mleft{
	width:50%;
	border: 1px solid #FFCC00;
	background:#FFFFCC;
	padding:5px;
}
.row div.mright{
	width:50%;
	border: 1px solid #009900;
	background:#CCFF99;
	padding:5px;
}

</style>
<div class="equal">
    <div class="row">

        <div class="mleft">
            <form class="form" action="" enctype="multipart/form-data" method="post">
            <input type="hidden" name="moduled" value="automatic">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$site_path;?>/images/contents.gif">&nbsp;Modules Currently installed<hr size="1" color="#666666" /></td>
              </tr>
            </table>
            <?php
            $dir=glob($globvars['site']['directory']."modules/*",GLOB_ONLYDIR);
            if ($dir[0]<>''):
                for($i=0;$i<count($dir);$i++):
                    $dirX=explode("/",$dir[$i]);
                    $chk='';
                    if($chk==''):
                        $txt=$dirX[count($dirX)-1];
                    else:
                        $txt='<font style="color:#999999">'.$dirX[count($dirX)-1].'</font>';
                    endif;
                    ?>			
                    <input type="checkbox" <?=$chk;?> name="<?=$dirX[count($dirX)-1];?>"><font class="body_text">&nbsp;<?=$txt;?></font><br/>
                    <?php
                endfor;
                ?>
                <input type="submit" name="mdelete" value="Delete" class="button" >
                </form>
                <?php
            else:
                echo "There are no installed modules.";
            endif;
            ?>
        </div>
        <div class="mright">
            <form class="form" action="" enctype="multipart/form-data" method="post">
            <input type="hidden" name="modulei" value="automatic">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$site_path;?>/images/contents.gif">&nbsp;Automatic Module Instalation<hr size="1" color="#666666" /></td>
              </tr>
            </table>
            <?php
            $dir=glob($globvars['local_root']."/modules/simple/*",GLOB_ONLYDIR);
            $dir_dest=glob($globvars['site']['directory']."modules/*",GLOB_ONLYDIR);
            if ($dir[0]<>''):
                $k=0;
                for($i=0;$i<count($dir);$i++):
                    $dirX=explode("/",$dir[$i]);
                    $install=true;
                    $chk='';
            
                    if (@$dir_dest[0]<>''):
                        for ($j=0;$j<count($dir_dest);$j++):
                            $link=explode("/",$dir_dest[$j]);
                            if ($link[count($link)-1]==$dirX[count($dirX)-1]):
                                $install=false;
                                break;
                            endif;
                        endfor;
                    endif;
                    if ($install):
                        if($chk==''):
                            $txt=$dirX[count($dirX)-1];
                        else:
                            $txt='<font style="color:#999999">'.$dirX[count($dirX)-1].'</font>';
                        endif;
                        $k=1;
                        ?>			
                        <input type="checkbox" <?=$chk;?> name="<?=$dirX[count($dirX)-1];?>"><font class="body_text">&nbsp;<?=$txt;?></font><br/>
                        <?php
                    endif;
                endfor;
                if ($k==0):
                    echo "There are modules in the Setup Modules Directory but they are already installed or don't have the automatic install feature.";
                else:
                    ?>
                    <input type="submit" name="auto_install" value="Install" class="button" >
                    </form>
                    <?php
                endif;
            else:
                echo "No modules Found in the Setup Modules Directory!";
            endif;
            ?>
        
        </div>
    </div>
</div>
