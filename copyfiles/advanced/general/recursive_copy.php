<?php

function copyr($srcdir, $dstdir,$globalvars, $offset = '')
{
    // A function to copy files from one directory to another one, including subdirectories and
    // nonexisting or newer files. Function returns number of files copied.
    // This function is PHP implementation of Windows xcopy  A:\dir1\* B:\dir2 /D /E /F /H /R /Y
    // Syntaxis: [$returnstring =] dircopy($sourcedirectory, $destinationdirectory [, $offset] [, $verbose]);
    // Example: $num = dircopy('A:\dir1', 'B:\dir2', 1);

    // Original by SkyEye.  Remake by AngelKiha.
    // Linux compatibility by marajax.
    // ([danbrown AT php DOT net): *NIX-compatibility noted by Belandi.]
    // Offset count added for the possibilty that it somehow miscounts your files.  This is NOT required.
    // Remake returns an explodable string with comma differentiables, in the order of:
    // Number copied files, Number of files which failed to copy, Total size (in bytes) of the copied files,
    // and the files which fail to copy.  Example: 5,2,150000,\SOMEPATH\SOMEFILE.EXT|\SOMEPATH\SOMEOTHERFILE.EXT
    // If you feel adventurous, or have an error reporting system that can log the failed copy files, they can be
    // exploded using the | differentiable, after exploding the result string.
    //
    if ($globalvars['debugger']===true):
		echo '<font style=" font-size: 8px; font-family: Verdana; color: #FF0000">DEBUGGER ENABLED (copy functions) !<br><strong>srcdir:</strong> '.$srcdir.' <strong>To dstdir:</strong>'.$dstdir.'<br>';
	endif;
if (!is_dir($srcdir)):
	$result=copy($srcdir, $dstdir);
else:
	if(!isset($offset)) $offset=0;
	if(!isset($ret)) $ret=0;
    $num = 0;
    $fail = 0;
    $sizetotal = 0;
    $fifail = '';
    if(!is_dir($dstdir)) mkdir($dstdir, 0755, true);
    if($curdir = opendir($srcdir)):
        while($file = readdir($curdir)):
            if($file != '.' && $file != '..'):
                $srcfile = $srcdir . '/' . $file;    # added by marajax
                $dstfile = $dstdir . '/' . $file;    # added by marajax
                if(is_file($srcfile)):
                    if(is_file($dstfile)) $ow = filemtime($srcfile) - filemtime($dstfile); else $ow = 1;
                    if($ow > 0):
                        if($globalvars['debugger']):
							echo "		Copying '$srcfile' to '$dstfile'...";
						endif;
                        if(copy($srcfile, $dstfile)):
                            touch($dstfile, filemtime($srcfile)); $num++;
                            chmod($dstfile, 0777);    # added by marajax
                            $sizetotal = ($sizetotal + filesize($dstfile));
                            if($globalvars['debugger']):
								echo "OK<br>";
							endif;
                        else:
                            if($globalvars['debugger']):
	                            echo "Error: File '$srcfile' could not be copied!<br />";
							endif;
                            $fail++;
                            $fifail = $fifail.$srcfile.'|';
                        endif;
                    endif;
                elseif(is_dir($srcfile)):
                    $res = explode(',',$ret);
                    $ret = copyr($srcfile, $dstfile, $verbose); # added by patrick
                    $mod = explode(',',$ret);
                    $imp = array($res[0] + $mod[0],$mod[1] + $res[1],$mod[2] + $res[2],$mod[3].$res[3]);
                    $ret = implode(',',$imp);
                endif;
            endif;
        endwhile;
        closedir($curdir);
	endif;
    if ($globalvars['debugger']===true):
		echo'</font>';
	endif;
    $red = explode(',',$ret);
    $ret = ($num + $red[0]).','.(($fail-$offset) + $red[1]).','.($sizetotal + $red[2]).','.$fifail.$red[3];
    return $ret;
endif;
}

function delr($globalvars, $source){
    if ($globalvars['debugger']===true):
		echo '<font style=" font-size: 8px; font-family: Verdana; color: #FF0000">DEBUGGER ENABLED (copy functions) !<br><strong>srcdir:</strong> '.$srcdir.' <strong>To dstdir:</strong>'.$dstdir.'<br>';
	endif;    // Simple del for a file
    if (is_file($source)):
        return unlink($source);
    endif;
    if (!is_dir($source)):
	    if ($globalvars['debugger']===true):
			echo "Not a directory to delete:".$source;
			echo'</font>';
		endif;
        return false;
    elseif(@rmdir($source)):
		return;
	endif;
 
    // Loop through the folder
    if(!@$dir = dir($source)):
		if ($globalvars['debugger']===true):
			echo 'Directory not found: '.$source;
			echo'</font>';
		endif;
		return false;
	endif;
    while (false !== $entry = $dir->read()):
        // Skip pointers
        if ($entry == '.' || $entry == '..'):
            continue;
        endif;
        // Deep delete directories
        delr($globvars,$source."/".$entry);
 		if (is_dir($source."/".$entry)):
			@rmdir($source."/".$entry);
		endif;
    endwhile;
 
    // Clean up
    $dir->close();
    return true;
}; 
?>