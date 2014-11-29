var DOMCompatible;
DOMCompatible = document.getElementById ? 1 : 0;
var InIE, InOldIE = 0;

function MeMSOObjectUpdate(objectname, newcontent) {
	var ourpointer = MeMSOObjectGetPointer(objectname, 0);
	if (InIE || DOMCompatible) {
		if (typeof(ourpointer.innerHTML) != 'undefined') {
			ourpointer.innerHTML = newcontent;

		} else {
			ourpointer.firstChild.nodeValue = newcontent;

		}

	} else if (InNS4) {
		ourpointer.document.open();
		ourpointer.document.write(newcontent);
		ourpointer.document.close();

	}
}

function MeMSOObjectGetPointer(objectname, parentlayer) {
	var layerarray;
	if (DOMCompatible)
		return document.getElementById(objectname);
	if (InIE)
		return document.all[objectname];
	if (InNS4) {
		layerarray = (parentlayer ? parentlayer : self).document.layers;
		if (layerarray[objectname])
			return layerarray[objectname];
		for (i = 0; i < layerarray.length; i++)
			return MeMSOObjectGetPointer(objectname, layerarray[i]);
	}
	return 0;
}

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
