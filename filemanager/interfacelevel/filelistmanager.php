<? 
$globvars['local_root']=substr(__FILE__,0,strpos(__FILE__,"filemanager"));// local harddrive path
include($globvars['local_root'].'copyfiles/advanced/general/db_class.php');
include($globvars['local_root'].'core/globvars.php');
require_once($globvars['local_root']."filemanager/config/config.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>File List</title>

</head>

<frameset id="filemanager_subframeset" rows="*" cols="7,*,7" framespacing="0px" frameborder="no" border="0px">
	<frame id="hidedirlistframe" name="hidedirlistframe" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/hideframevertical.php?direction=left&frame_name=dirlist" noresize="noresize" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" />
	<? if($CONFIG['upload_permission']) {?>
		<frameset id="filelistmanager_subframeset" rows="*,7,140" cols="*" framespacing="0px" frameborder="no" border="0px" subframesnames="filelist,hidefileuploadframe,fileupload">
			<frame id="filelist" name="filelist" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/filelist.php?<? echo $_SERVER['QUERY_STRING'];?>" noresize="noresize" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" framerows="*" />
			<frame id="hidefileuploadframe" name="hidefileuploadframe" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/hideframehorizontal.php?direction=bottom&frame_name=fileupload" noresize="noresize" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" framerows="7" />
			<frame id="fileupload" name="fileupload" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/fileupload.php?<? echo $_SERVER['QUERY_STRING'];?>" noresize="noresize" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" framerows="140" />
		</frameset>
	<? }else {?>
		<frameset id="filelistmanager_subframeset" rows="*,*" cols="*" framespacing="0px" frameborder="no" border="0px" subframesnames="filelist,hidefileuploadframe,fileupload">
			<frame id="filelist" name="filelist" src="<?=$globvars['site_path'];?>/filemanager/interfacelevel/filelist.php?<? echo $_SERVER['QUERY_STRING'];?>" noresize="noresize" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" framerows="*" />
		<frame src="UntitledFrame-1"></frameset>
	<? }?>
	<frame id="hidepreviewframe" name="hidepreviewframe" src="hideframevertical.php?direction=right&frame_name=preview" noresize="noresize" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" />
</frameset>

<noframes><body></body></noframes>

</html>
