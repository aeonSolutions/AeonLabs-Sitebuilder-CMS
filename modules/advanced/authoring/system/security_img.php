<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function security_image(){
//Generate Reference ID
if (isset($HTTP_GET_VARS["refid"]) && $HTTP_GET_VARS["refid"]!="") {
   $referenceid = stripslashes($HTTP_GET_VARS["refid"]);
} else {
   $referenceid = md5(mktime()*rand());
}

//Select Font
$font = "C:\\WINDOWS\\Fonts\\Verdana.ttf";

//Select random background image
$img_num = rand(1, 4);
$im = ImageCreateFromjpeg("modules/authoring/images/security_img".$img_num.".jpg");

//Generate the random string
$chars = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p",
"q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9");
$length = 8;
$textstr = "";
for ($i=0; $i<$length; $i++):
   $textstr .= $chars[rand(0, count($chars)-1)];
endfor;
//Create random size, angle, and dark color
$size = rand(15, 19);
$angle = rand(-5, 5);
$color = ImageColorAllocate($im, rand(0, 100), rand(0, 100), rand(0, 100));

//Determine text size, and use dimensions to generate x & y coordinates
$textsize = imagettfbbox($size, $angle, $font, $textstr);
$twidth = abs($textsize[2]-$textsize[0]);
$theight = abs($textsize[5]-$textsize[3]);
$x = (imagesx($im)/2)-($twidth/2)+(rand(-20, 20));
$y = (imagesy($im))-($theight/2);

//Add text to image
ImageTTFText($im, $size, $angle, $x, $y, $color, $font, $textstr);

//Output JPG Image
$it=glob("modules/authoring/*.jpg");
for ($i=0;$i<count($it);$i++):
	unlink($it[$i]);
endfor;
Imagejpeg($im,"modules/authoring/".$textstr.".jpg");

//Destroy the image to free memory
imagedestroy($im);
return $textstr;
};


function basic_nav($location){
?>
<script>
	document.location.href="<?=$location;?>"
</script>
<?php
};

?>