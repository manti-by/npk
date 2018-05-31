function popup (imageURL, caption) {
	var windowTop = 0;
	var windowLeft = 0;
	var defaultWidth = 1024;
	var defaultHeight = 768;
	var scrollbars = 0;
	var onLoseFocusExit = true;
	var undefined;
	var Options = "scrollbars=" + scrollbars + ",width=" + defaultWidth + ",height=" + defaultHeight + ",top=" + windowTop + ",left=" + windowLeft + ""
	var myScript = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n" +
	"<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n" +
	"<head>\n" +
	"<title>" + caption + "\</title>\n" +
	"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n" +
	"<meta http-equiv=\"Content-Language\" content=\"en\">\n" +
	"<meta http-equiv=\"imagetoolbar\" content=\"no\">\n" +
	"<script type=\"text/javascript\">\n" +
	"function resizewindow () {\n" +
	"var width = document.myimage.width;\n" +
	"var height = document.myimage.height;\n";
	if (navigator.appName.indexOf("Netscape") != -1) {
		myScript = myScript +  "  window.innerHeight = height;\n  window.innerWidth = width;\n"
	}
	else if (navigator.appName.indexOf("Opera") != -1) {
		myScript = myScript +  "  window.resizeTo (width+12, height+31);\n"
	}
	else if (navigator.appName.indexOf("Microsoft") != -1) {
		myScript = myScript + "  window.resizeTo (width+12, height+31);\n"
	} else {
		myScript = myScript + "  window.resizeTo (width+14, height+34);\n"
	}
	myScript = myScript + "}\n" + "window.onload = resizewindow;\n" + "</script>\n</head>\n" + "<body ";
	if (onLoseFocusExit) {myScript = myScript + "onblur=\"window.close()\" onmousedown=\"window.close()\" ";}
		myScript = myScript + "style=\"margin: 0px; padding: 0px;\">\n" +
		"<img src=\"" + imageURL + "\" alt=\"" + caption + "\" title=\"" + caption + "\" name=\"myimage\">\n" +
		"</body>\n" +  "</html>\n";
		var imageWindow = window.open ("","imageWin",Options);
		imageWindow.document.write (myScript)
		imageWindow.document.close ();
		if (window.focus) imageWindow.focus();
			return false;
		}
function $() {
	var elements = new Array();
	for (var i = 0; i < arguments.length; i++) {
		var element = arguments[i];
		if (typeof element == 'string')
			element = document.getElementById(element);
		if (arguments.length == 1)
			return element;
		elements.push(element);
	}
	return elements;
}
