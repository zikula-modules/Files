	
function FilesFindItemXinha(editor, maURL)
{
    var pWidth = screen.width * 0.75;
    var pHeight = screen.height * 0.66;
    var pTop = (screen.height - pHeight) / 2;
    var pLeft = (screen.width - pWidth) / 2;
    
    editor._popupDialog(maURL , function(value){editor.insertHTML('<img src="'+ value + '" alt="' + getFileName(value) + '" title="' + getFileName(value) + '"/>')})
}

function getFileName (value) {
    var filename = value.substr(value.lastIndexOf('/')+1,value.length);
    return filename;
}

function modifySize(folder,image,factor,action)
{
    var pars = "module=Files&func=externalModifyImg&folder=" + folder + "&image=" + image + "&factor=" + factor + "&action=" + action;
    Element.update('image_' + image, '<img src="images/ajax/circle-ball-dark-antialiased.gif" />');
	var myAjax = new Ajax.Request("ajax.php", 
	{
		method: 'get', 
		parameters: pars, 
		onComplete: modifySize_response,
		onFailure: modifySize_failure
	});
}

function modifySize_response(req)
{
   	if (req.status != 200 ) { 
		pnshowajaxerror(req.responseText);
		return;
	}
	var json = pndejsonize(req.responseText);
	Element.update('image_' + json.image, json.content);
}

function modifySize_failure()
{
    
}

function Loadwindow(){
	
	url = document.location.pnbaseURL + document.location.entrypoint + "?module=Files&type=external&func=getFiles&hook=1";
	popup=window.open(url,"Files",toolbar=yes);
	popup.window.document.getElementsByTagName('body')[0].setAttribute('class','external_window');
	popup.window.document.getElementsByTagName('body')[0].setAttribute('onblur','self.focus()');
	//self.onfocus=alert("hola");
	//popup.window.document.getElementsByTagName('body')[0].setAttribute('onload','alert("hola")');
	//onUnload.popup = popup.alert("adeu");
	
	
	
	window.captureEvents(Event.KEYPRESS);
	window.onkeypress=nothing;
	//window.onkeypress=restore;
	
	
	/*document.onmousedown=nothing;
	document.onkeydown=nothing;
	document.onkeypress=nothing;
	document.onclick=nothing;
	document.onmouseup=nothing;
	document.onSubmit=nothing;
	if (document.layers) window.captureEvents(Event.MOUSEDOWN);
	if (document.layers) window.captureEvents(Event.KEYPRESS);
	if (document.layers) window.captureEvents(Event.KEYDOWN);
	if (document.layers) window.captureEvents(Event.CLICK);
	if (document.layers) window.captureEvents(Event.MOUSEUP);
	if (document.layers) window.captureEvents(Event.SUBMIT);
	window.onmousedown=nothing;
	window.onkeydown=nothing;
	window.onkeypress=nothing;
	window.onclick=nothing;
	window.onmouseup=nothing;
	window.onsubmit=nothing;*/
}

function nothing(e){return false;}

function restore(e){return true;}

function restore_events(){alert("adeu");}
