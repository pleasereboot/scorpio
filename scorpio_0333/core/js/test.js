function ajaxFunction()
  {
  var xmlHttp;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      try
        {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      catch (e)
        {
        alert("Your browser does not support AJAX!");
        return false;
        }
      }
    }
    xmlHttp.onreadystatechange=function()
      {
      if(xmlHttp.readyState==4)
        {
        document.myForm.time.value=xmlHttp.responseText;
		document.getElementById("sn").innerHTML=xmlHttp.responseText;
        }
      }
	myurl = "index.php?layout=none";
	  
    xmlHttp.open("GET",myurl,true);
    xmlHttp.send(null);
  }



//function ecrilapatente() {
//	document.writeln('GENRE FULL' + i);
//}
//
//
//
//			function makeRequest(url) {
//				var httpRequest;
//		
//				if (window.XMLHttpRequest) { // Mozilla, Safari, ...
//					httpRequest = new XMLHttpRequest();
//					if (httpRequest.overrideMimeType) {
//						httpRequest.overrideMimeType('text/xml');
//						// See note below about this line
//					}
//				} 
//				else if (window.ActiveXObject) { // IE
//					try {
//						httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
//						} 
//						catch (e) {
//								   try {
//										httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
//									   } 
//									 catch (e) {}
//								  }
//											   }
//		
//				if (!httpRequest) {
//					alert('Giving up :( Cannot create an XMLHTTP instance');
//					return false;
//				}
//				httpRequest.onreadystatechange = function() { alertContents(httpRequest); };
//				httpRequest.open('GET', url, true);
//				httpRequest.send('');
//		
//			}
//		
//			function alertContents(httpRequest) {
//		
//				if (httpRequest.readyState == 4) {
//					if (httpRequest.status == 200) {
//						alert(httpRequest.responseText);
//					} else {
//						alert('There was a problem with the request.');
//					}
//				}
//		
//			}
