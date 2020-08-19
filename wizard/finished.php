<?php
if(isset($_POST['cleanup'])):
	$_SESSION['site']=array();
	$_SESSION['type']=array();
	$_SESSION['directory']=array();
	unset($_SESSION['site']);
	unset($_SESSION['type']);
	unset($_SESSION['directory']);
	delr($globvars,$globvars['local_root'].'tmp');
	unlink($globvars['local_root'].'core/status.php');
	mkdir($globvars['local_root'].'tmp', 0755, true);
	header("Location: index.php?SID=".$_GET['SID']);
	exit;
endif;
?>
    <TABLE height="210" cellSpacing=0 cellPadding=10 width="500" border="0" background="wizard/images/keyboard.gif" align="center">
      <TBODY>
        <TR>
          <TD height="20">&nbsp;</TD>
        </TR>
        <TR>
          <TD valign="top"><h2>You have finished the wizard!</h2><br />
                  <br />
                  <h3>if you wish to go to advanced setup, please click  <a style="background-color:" href="javascript:document.form_fin.submit();">here</a>.<br />
              </h3></TD>
        </TR>
      </TBODY>
    </TABLE>
    <form action="" method="post" enctype="multipart/form-data" name="form_fin" class="form" id="form_fin">
    <input type="hidden" value="cleanup" name="cleanup" />
    </form>
