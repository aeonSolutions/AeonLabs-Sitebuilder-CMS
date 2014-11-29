<!-- JavaScript Document

<!-- example code of fade image
<!--	<A onclick="return img_onclick(this);" href="screenshots/s1.gif" target=_blank>
<!--		<IMG src="screenshots/s1.gif" border="0" class=sc onmouseover=img_onover(this) onmouseout=img_onout(this)></A> 
<!--NOTA:
<!--	é necessario colocar o codigo acima dentro de um body
<!--		<BODY onload=body_onload()></body>


<SCRIPT>
function body_onload() {
	for (i=0; i < document.images.length; i++) {
		el = document.images(i);
		if (el) {
			SetFilter(el, true);
		}
	}
}
function SetFilter(el, enabled) {
	if (enabled)
		el.style.filter = "	progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
	else el.style.filter = "";
}
function img_onclick(el) {
	window.open(el.href, "_self", 
		"tmenubar=no, toolbar=no, status=no, location=no, resizable=yes, width=815, height=735);");
	return false;
}
function img_onover(el) {
	SetFilter(el, false);
}
function img_onout(el) {
	SetFilter(el, true);
}
</SCRIPT>