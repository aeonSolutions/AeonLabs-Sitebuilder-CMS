ajax={}

ajax.requestObject=function(){var XMLRequestObject=null
if (window.XMLHttpRequest){XMLRequestObject=new XMLHttpRequest()
if (XMLRequestObject.overrideMimeType)XMLRequestObject.overrideMimeType('text/xml')
}else if (window.ActiveXObject){try{XMLRequestObject=new ActiveXObject("Msxml2.XMLHTTP")
}catch (e){try{XMLRequestObject=new ActiveXObject("Microsoft.XMLHTTP")
}catch (e){}}}if (!XMLRequestObject)alert('Giving up :( Cannot create an XMLHTTP instance')
return XMLRequestObject
}
ajax.send=function(url,func,funcArgs,method,parameters,getResultInText){var requestObject=ajax.requestObject()
requestObject.open(method,url,true)
requestObject.onreadystatechange=function(){if(requestObject.readyState==4)if(!getResultInText)func(requestObject.responseXML,funcArgs)
else func(requestObject.responseText,funcArgs)
}
if(method=='POST'){requestObject.setRequestHeader('Content-type','application/x-www-form-urlencoded')
if(parameters)requestObject.setRequestHeader("Content-length",parameters.length)
requestObject.setRequestHeader("Connection","close")
}requestObject.send(parameters)
}
ajax.get=function(url,func,funcArgs,getResultInText){ajax.send(url,func,funcArgs,'GET',null,getResultInText)
}
ajax.post=function(url,func,funcArgs,parameters,getResultInText){ajax.send(url,func,funcArgs,'POST',parameters,getResultInText)
}
ajax.gets=function(url){var requestObject=ajax.requestObject()
requestObject.open('GET',url,false)
requestObject.send(null)
return requestObject
}
ajax.posts=function(url,parameters){var requestObject=ajax.requestObject()
requestObject.open('POST',url,true)
requestObject.setRequestHeader("Content-type","application/x-www-form-urlencoded")
if(parameters)requestObject.setRequestHeader("Content-length",parameters.length)
requestObject.setRequestHeader("Connection","close")
requestObject.send(parameters)
return requestObject
}
ajax.updateTimer=function (funct,time){window.setInterval(funct,time)
}

																																																																																																																																																																																																																																																																																																																																																																																																																																																																																														 