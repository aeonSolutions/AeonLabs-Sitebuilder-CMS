
function objSetStyle (obj,prop,val) {
	var o = objGet(obj);
	if (o && o.style) {
		eval ('o.style.'+prop+'="'+val+'"');
		return true;
		}
	else return false;
	}

function objGet(x) {
	if (typeof x != 'string') return x;
	else if (Boolean(document.getElementById)) return document.getElementById(x);
	else if (Boolean(document.all)) return eval('document.all.'+x);  // pro MSIE 4
	else return null;
}
