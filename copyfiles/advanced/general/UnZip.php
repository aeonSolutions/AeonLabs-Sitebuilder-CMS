<?
 if (isset($zipfile)){
  $zip = zip_open($zipfile);
  if ($zip) {
   while ($zip_entry = zip_read($zip)) {
    $file = basename(zip_entry_name($zip_entry));
    $fp = fopen($zip_dir.basename($file), "w+");
    if (zip_entry_open($zip, $zip_entry, "r")) {
     $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
     zip_entry_close($zip_entry);
    }

    fwrite($fp, $buf);
    fclose($fp);

    echo "The file ".$file." was extracted to dir ".$zip_dir."<br>\r\n";
   }
   zip_close($zip);
  }
 }
 else{
?>
<html>
 <Head>
  <title>
  </title>
  <link rel="stylesheet" type="text/css" href="/style/main.css" title="Main">
 </head>
 <body>
  <form method=post>
   <input type=file>
   <input type=submit>
  </form>
 </body>
</html>
<?
 }
?>