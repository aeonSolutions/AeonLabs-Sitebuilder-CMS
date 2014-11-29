<?php
function get_table_def($table, $crlf,$dbname){

$schema_create = "DROP TABLE IF EXISTS $table;$crlf";
$dbd = $table;
$schema_create .= "CREATE TABLE $table ($crlf";
$result = mysql_query("SHOW FIELDS FROM " .$dbname.".". $table) or die();

while($row = mysql_fetch_array($result)):
	$schema_create .= " $row[Field] $row[Type]";
	if(isset($row["Default"]) && (!empty($row["Default"]) || $row["Default"] == "0")):
		$schema_create .= " DEFAULT '$row[Default]'";
	endif;
	if($row["Null"] != "YES"):
		$schema_create .= " NOT NULL";
	endif;
	if($row["Extra"] != ""):
		$schema_create .= " $row[Extra]";
	endif;
	$schema_create .= ",$crlf";
endwhile;

$schema_create = ereg_replace(",".$crlf."$", "", $schema_create);
$result = mysql_query("SHOW KEYS FROM " .$dbname.".".$table) or die();
while($row = mysql_fetch_array($result)):
		$kname=$row['Key_name'];
		$comment=(isset($row['Comment'])) ? $row['Comment'] : '';
		$sub_part=(isset($row['Sub_part'])) ? $row['Sub_part'] : '';
		if(($kname != "PRIMARY") && ($row['Non_unique'] == 0)):
			$kname="UNIQUE|$kname";
		endif;
		if($comment=="FULLTEXT"):
			$kname="FULLTEXT|$kname";
		endif;
		if(!isset($index[$kname])):
			$index[$kname] = array();
		endif;
		if ($sub_part>1):
			$index[$kname][] = $row['Column_name'] . "(" . $sub_part . ")";
		else:
			$index[$kname][] = $row['Column_name'];
		endif;
endwhile;

while(list($x, $columns) = @each($index)):
			$schema_create .= ",$crlf";
			if($x == "PRIMARY"):
				$schema_create .= " PRIMARY KEY (";
			elseif (substr($x,0,6) == "UNIQUE"):
				$schema_create .= " UNIQUE " .substr($x,7)." (";
			elseif (substr($x,0,8) == "FULLTEXT"):
				$schema_create .= " FULLTEXT ".substr($x,9)." (";
			else:
				$schema_create .= " KEY $x (";
			endif;
			$schema_create .= implode($columns,", ") . ")";
endwhile;
$schema_create .= "$crlf)"." ENGINE=MyISAM AUTO_INCREMENT=8 ; \r\n\r\n";
;
if(get_magic_quotes_gpc()):
	return (stripslashes($schema_create));
else:
	return $schema_create;
endif;
};


function datadump ($link,$db_name,$table){
	$result='';
    $result .= "# Dump of $table \r\n";
    $result .= "# Dump DATE : " . date("d-M-Y") ."\r\n\r\n";
	$query = mysql_query("select * from ".$table);
    $num_fields = @mysql_num_fields($query);
    $list_fields = @mysql_list_fields($query);
    $numrow = mysql_num_rows($query);

	$fields = mysql_list_fields($db_name, $table, $link);
	$columns = mysql_num_fields($fields);
    for ($i =0; $i<$numrow; $i++):
		$row=mysql_fetch_row($query);
		$result .= "INSERT INTO ".$table." VALUES(";
    	for($j=0; $j<$num_fields; $j++):
    		$row[$j] = addslashes($row[$j]);
    		$row[$j] = ereg_replace("\n","\\n",$row[$j]);
    		$row[$j] = ereg_replace("\r","\\r",$row[$j]);
    		if (isset($row[$j])):
				$result .= "\"$row[$j]\"" ;
			else:
				$result .= "\"\"";
			endif;
    		if ($j<($num_fields-1)):
				$result .= ",";
			endif;
		endfor;    
      	$result .= ");\r\n";
	endfor;
    return $result . "\r\n\r\n\r\n";
};





include('../general/staticvars.php');

$db_name=$db->name;
$link=mysql_connect($db->host,$db->user,$db->password);
@mysql_select_db($db->name) or die("Unable to select database.");
$content='';
$result = mysql_list_tables($db->name);
if (!$result):
	echo "Unable to list the  tables!";
	echo 'MySQL Error: ' . mysql_error();
	exit;
endif;
$i=0;
while ($row = mysql_fetch_row($result)):
	$table_name[$i]=$row[0];
	$i++;
endwhile;
mysql_free_result($result);
$file_name="../Sql/".date("d-M-Y").".sql";
@unlink($file_name);
$fd = fopen( $file_name,"a");
for($i=0;$i<count($table_name);$i++):
	$table[$i] = get_table_def($table_name[$i], "\r\n",$db->name);
	$table[$i] .= datadump($link,$db_name,$table_name[$i]);
	$content=$content.$table[$i];
	fwrite($fd, $table[$i]);
endfor;
fclose($fd);
?> 
