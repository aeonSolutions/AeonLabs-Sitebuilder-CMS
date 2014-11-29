<script language="JavaScript" type="text/JavaScript">
<!--
// Set slideShowSpeed (milliseconds)
var slideShowSpeed = 5000

// Duration of crossfade (seconds)
var crossFadeDuration = 3

// Specify the image files
var Pic = new Array() 
// to add more images, just continue
// the pattern, adding to the array below

Pic[0] = '<?=$site_path;?>/modules/web_packs/pt/images/slideshow/civiltek.gif'
Pic[1] = '<?=$site_path;?>/modules/web_packs/pt/images/slideshow/caminho.gif'
Pic[2] = '<?=$site_path;?>/modules/web_packs/pt/images/slideshow/riva.gif'

var t
var j = 0
var p = Pic.length

var preLoad = new Array()
for (i = 0; i < p; i++){
   preLoad[i] = new Image()
   preLoad[i].src = Pic[i]
}

function runSlideShow(){
   if (document.all){
      document.images.SlideShow.style.filter="blendTrans(duration=2)"
      document.images.SlideShow.style.filter="blendTrans(duration=crossFadeDuration)"
      document.images.SlideShow.filters.blendTrans.Apply()      
   }
   document.images.SlideShow.src = preLoad[j].src
   if (document.all){
      document.images.SlideShow.filters.blendTrans.Play()
   }
   j = j + 1
   if (j > (p-1)) j=0
   t = setTimeout('runSlideShow()', slideShowSpeed)
}

function MM_preload_events() {
	//preloading images
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preload_events.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
//  fade and switch image effect
	runSlideShow();
}
//-->
</script>
<table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td colspan="3" height="40"></td>
  </tr>
  <tr>
    <td colspan="3" width="30"></td>
    <td id="VU" height="75" width="100"><img src="<?=$site_path;?>/modules/web_packs/pt/images/civiltek.gif" name='SlideShow' width="100" height="75" border="1"></td>
    <td align="center" valign="bottom"><font class="links">&nbsp;&nbsp;<a href="<?=session('index.php?taskid=');?>" class="links">mais >></a></font></td>
  </tr>
</table>
