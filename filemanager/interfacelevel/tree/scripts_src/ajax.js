ajax = {};

ajax.requestObject = function(){
	var XMLRequestObject = null; /* XMLHttpRequest Object */
	
	if (window.XMLHttpRequest) { /* Mozilla, Safari,...*/
		XMLRequestObject = new XMLHttpRequest();
		if (XMLRequestObject.overrideMimeType)
			XMLRequestObject.overrideMimeType('text/xml');
	
	} else if (window.ActiveXObject) { /* IE */
		try {
			XMLRequestObject = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				XMLRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	
	if (!XMLRequestObject)
		alert('Giving up :( Cannot create an XMLHTTP instance');
	
	return XMLRequestObject;
};

ajax.send = function(url,func,funcArgs,method,parameters,getResultInText){
	var requestObject = ajax.requestObject();
	requestObject.open(method,url,true);
	requestObject.onreadystatechange = function(){
		if(requestObject.readyState == 4)
			if(!getResultInText)
				func(requestObject.responseXML,funcArgs);
			else func(requestObject.responseText,funcArgs);
	};
	
	if(method == 'POST') {
		requestObject.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		if(parameters)
			requestObject.setRequestHeader("Content-length", parameters.length);
		requestObject.setRequestHeader("Connection", "close");
	}

	requestObject.send(parameters);
};

/*ajax.get("event.php?action=delete&path=../../exp", createContentXPTO);*/
ajax.get = function(url,func,funcArgs,getResultInText){
	ajax.send(url,func,funcArgs,'GET',null,getResultInText);
};

/*var parameters = "mytextarea1=" + encodeURI( document.getElementById("mytextarea1").value ) + "&mytextarea2=" + encodeURI( document.getElementById("mytextarea2").value );
ajax.post("event.php", createContentXPTO,null,parameters);*/
ajax.post = function(url,func,funcArgs,parameters,getResultInText){
	ajax.send(url,func,funcArgs,'POST',parameters,getResultInText);
};

/*ajax.gets("event.php?action=delete&path=../../exp");*/
ajax.gets = function(url){
	var requestObject = ajax.requestObject();
	requestObject.open('GET',url,false);
	requestObject.send(null);
	
	return requestObject;
};

/*var parameters = "mytextarea1=" + encodeURI( document.getElementById("mytextarea1").value ) + "&mytextarea2=" + encodeURI( document.getElementById("mytextarea2").value );
ajax.posts('post.php', parameters);*/
ajax.posts = function(url,parameters){
	var requestObject = ajax.requestObject();
	requestObject.open('POST',url,true);
    requestObject.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	if(parameters)
	    requestObject.setRequestHeader("Content-length", parameters.length);
    requestObject.setRequestHeader("Connection", "close");
    requestObject.send(parameters);
	
	return requestObject;
};

ajax.updateTimer = function (funct,time) {
	window.setInterval(funct, time);
};
