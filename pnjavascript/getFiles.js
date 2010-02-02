function FilesFindItemXinha(editor, maURL)
{
  var pWidth = screen.width * 0.75;
  var pHeight = screen.height * 0.66;
  window.open(maURL, "", "width="+pWidth+",height="+pHeight+",scrollbars,resizable");
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