
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
	
	url = document.location.pnbaseURL + document.location.entrypoint + "?module=Files&type=external&func=getFiles";
	window.open(url,"Files","width=600,height=300,scrollbars=YES");
}