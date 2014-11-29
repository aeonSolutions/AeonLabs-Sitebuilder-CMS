<?
require_once($globvars['local_root']."filemanager/logiclevel/init.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Unzip overview</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/buttons.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/dialog.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/unzip.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/loading.css" rel="stylesheet" type="text/css" />
<link href="css/filetypes.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="jscripts/general.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/unzip.js"></script>
</head>

<body onload="init();">

<div id="loadingbar"><div id="subloadingbar">Loading ...</div></div>

<?
require_once($globvars['local_root']."filemanager/logiclevel/unzip_ll.php");

echo "<script>
var zipType = '".$zip_type."';\n";
$files_array = array();
for($i = 0; $i < count($files_list); ++$i)
	if($zip_type == "zip" || $zip_type == "gz" || $zip_type == "tar" || $zip_type == "tgz") {
		if($zip_type == "zip")
			echo "var file_".$i." = Array('".$files_list[$i]['filename']."','".basename($files_list[$i]['filename'])."','".getBytesConverted($files_list[$i]['size'])."','".getBytesConverted($files_list[$i]['compressed_size'])."','".$files_list[$i]['status']."','".date("d-m-Y h:i",$files_list[$i]['mtime'])."');\n";
		elseif($zip_type == "gz" || $zip_type == "tar" || $zip_type == "tgz")
			echo "var file_".$i." = Array('".$files_list[$i]['filename']."','".basename($files_list[$i]['filename'])."','".getBytesConverted($files_list[$i]['size'])."','".date("d-m-Y h:i",$files_list[$i]['mtime'])."');\n";
		
		$files_array[] = "file_".$i;
	}
echo "var filesList = Array(".implode($files_array,",").");
</script>";
?>
<form id="files" name="unzipForm" method="post" action="unzip.php?<? echo $_SERVER['QUERY_STRING'];?>" onsubmit="return verifyForm();">
<div class="mcBorderBottomWhite">
	<div class="mcHeader mcBorderBottomBlack">
		<div class="mcWrapper">
			<div class="mcHeaderLeft">
				<div class="mcHeaderTitle">Unzip overview</div>
				<div class="mcHeaderTitleText">An overview of the zip file(s) you selected.</div>
			</div>
			<div class="mcHeaderRight">&nbsp;</div>
			<br style="clear: both" />
		</div>
	</div>
</div>
<div class="mcContent">
	<table border="0" cellspacing="0" cellpadding="4">
	  <tr>
		<td nowrap="nowrap">Current folder: </td>
		<td><? echo $path.'/';?></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Zipfile name: </td>
		<td><? echo $zip_file_name;?></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Folder to Unzip: </td>
		<td><input name="mainfoldername" id="mainfoldername" type="text" value="" class="inputText" size="35" maxlength="255" style="width: 150px" /></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap">Overwrite: </td>
		<td>
			<input name="overwrite" id="overwrite" type="checkbox" value="1" class="inputText" checked />
		</td>
	  </tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="4" width="100%">
	  <tr>
		<td align="center" valign="top">
			<div id="toggleall_zip_elements"><a href="#" onclick="toggleAll()">Toggle All</a></div>
			<div id="zipelements">
			<!--table id="zipelementstable" border="0" cellspacing="0" cellpadding="0" width="100%">
			<?
			/*if($zip_type == "zip") {
				echo '<tr class="column">
					<td class="hidden"><img src="images/toolbaritems/box.gif" alt="Toggle Selection" onclick="selectToggle(\'files\')" /></td>
					<td>Name</td>
					<td>Size</td>
					<td>CSize</td>
					<td>Status</td>
					<td>Created</td>
				</tr>';
				
				for($i = 0; $i < count($files_list); ++$i) {
					$class = $class == "trOdd" ? "trEven" : "trOdd";
					$file_name = $files_list[$i]['filename'];
					$file_name = strlen($file_name) > 35 ? substr($file_name,0,35)."..." : $file_name;
					
					$statusred = strtolower($files_list[$i]['status']) != "ok" ? "statusred" : "statusgreen";
					
					echo '<tr class="'.$class.'">
						<td class="hidden"></td>
						<td width="200px">'.$file_name.'</td>
						<td width="70px" align="right">'.getBytesConverted($files_list[$i]['size']).'</td>
						<td width="70px" align="right">'.getBytesConverted($files_list[$i]['compressed_size']).'</td>
						<td width="50px" align="center" class="'.$statusred.'">'.$files_list[$i]['status'].'</td>
						<td width="100px" align="center">'.date("d-m-Y h:i",$files_list[$i]['mtime']).'</td>
					</tr>';
				}
			}
			elseif($zip_type == "gz" || $zip_type == "tar" || $zip_type == "tgz") {
				echo '<tr class="column">
					<td class="hidden"><img src="images/toolbaritems/box.gif" alt="Toggle Selection" onclick="selectToggle(\'files\')" /></td>
					<td>Name</td>
					<td>Size</td>
					<td>Created</td>
				</tr>';
				
				for($i = 0; $i < count($files_list); ++$i) {
					$class = $class == "trEven" ? "trOdd" : "trEven";
					$file_name = $files_list[$i]['filename'];
					$file_name = strlen($file_name) > 45 ? substr($file_name,0,45)."..." : $file_name;
					echo '<tr class="'.$class.'">
						<td class="hidden"></td>
						<td width="300px">'.$file_name.'</td>
						<td width="70px" align="right">'.getBytesConverted($files_list[$i]['size']).'</td>
						<td width="100px" align="center">'.date("d-m-Y h:i",$files_list[$i]['mtime']).'</td>
					</tr>';
				}
			}*/
			?>
			</table-->
			</div>
		</td>
	  </tr>
	</table>
	<input type="hidden" name="path" value="<? echo $path;?>" />
	<input type="hidden" name="files" value="" />
	<input type="hidden" name="selected_action" value="unzip" />

</div>
<div class="mcFooter mcBorderTopBlack">
	<div class="mcBorderTopWhite">
		<div class="mcWrapper">
			<div class="mcFooterLeft"><input type="submit" id="submitBtn" name="submitBtn" value="Unzip" class="button" /></div>
			<div class="mcFooterRight"><input type="button" name="Cancel" value="Cancel" class="button" onclick="top.close();" /></div>
			<br style="clear: both" />
		</div>
	</div>
</div>

</form>
</body>

</html>


