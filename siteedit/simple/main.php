<?php
/*
File revision date: 2-Mai-2008
*/
include($globvars['site']['directory'].'kernel/staticvars.php');
?>
          <TABLE cellSpacing="0" cellPadding="0" width="100%" border="0">
            <TBODY>
              <TR>
                <TD width="26"></TD>
                <TD width="45"></TD>
                <TD width="880"></TD>
              </TR>
              <TR>
                <TD colspan="3" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$globvars['site_path'];?>//images/design.jpg">&nbsp;Design<hr size="1" color="#666666" /></TD>
              </TR>
              <tr>
                <td height="10" align="left">&nbsp;</td>
                <td height="10" colspan="2" align="left">Theme&nbsp; <a href="<?=session_setup($globvars,'index.php?id=1');?>"><img src="<?=$globvars['site_path'];?>//images/instalar.gif" alt="instalar" border="0" /></a> </td>
              </tr>
              <tr>
                <td height="10" colspan="2" align="left">&nbsp;</td>
                <td height="10"  align="left" ><?php
				if ($staticvars['layout']['file']<>''):
					$dir=explode(".",$staticvars['layout']['file']);
					?>
					<img src='<?=$globvars['site_path'];?>/images/check_mark.gif'>&nbsp;&nbsp;<font style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9;' color='#00cc33'>Static Mode. Installed.</font><br />
					<img src='<?=$staticvars['site_path'];?>/layout/<?=$dir[0];?>/preview.jpg'><br />
					Filename: <?=$staticvars['layout']['file'];?>
				<?php
				else:
					echo "<img src='".$globvars['site_path']."/images/cross_mark.gif'>&nbsp;&nbsp;<font style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9;' color='red'>Static Mode. Not Installed.</font>";
				endif;
				?>
                </td>
              </tr>
              <TR>
                <TD colspan="3" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$globvars['site_path'];?>//images/contents.jpg">&nbsp;Contents
                  <hr size="1" color="#666666" /></TD>
              </TR>
              <TR>
                <TD height="10" align="left">&nbsp;</TD>
                <TD height="10" colspan="2" align="left">Modules&nbsp;
				<a href="<?=session_setup($globvars,'index.php?id=2');?>"><img src="<?=$globvars['site_path'];?>//images/instalar.gif" alt="instalar" border="0"></a>				</TD>
              </TR>
              <TR>
                <TD height="10" colspan="2" align="left">&nbsp;</TD>
                <TD height="10"  align="left" >
				<?php
				$query=glob($globvars['site']['directory']."modules/*",GLOB_ONLYDIR);
				if ($query<>''):
					echo "<img src='".$globvars['site_path']."/images/check_mark.gif'>&nbsp;&nbsp;<font style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9;' color='#00cc33'>Installed ".count($query)." modules</font>";
				else:
					echo "<img src='".$globvars['site_path']."//images/cross_mark.gif'>&nbsp;&nbsp;<font style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9;' color='#FF0000'><strong>No modules had been installed.</strong></font>";
				endif;
				?>				</TD>
              </TR>

              <TR>
                <TD colspan="3" style="font-family:Georgia, 'Times New Roman', Times, serif; font-size:medium; font-weight:bold"><img src="<?=$globvars['site_path'];?>//images/general.jpg">&nbsp;General Config.
                  <hr size="1" color="#666666" /></TD>
              </TR>
              <TR>
                <TD height="10" align="left">&nbsp;</TD>
                <TD height="10" colspan="2" align="left">Static Variables&nbsp;
				<a href="<?=session_setup($globvars,'index.php?id=3');?>"><img src="<?=$globvars['site_path'];?>//images/instalar.gif" alt="instalar" border="0"></a>				</TD>
              </TR>
              <TR>
                <TD height="10" colspan="2" align="left">&nbsp;</TD>
                <TD height="10"  align="left" >
				<?php
				?>				</TD>
              </TR>
          </TBODY>
		</TABLE>
