// LIVE ENGINE
	var xmlhttp;
	var globdivid;
	var fill_id;
	var items_ini=new Array();
	var e;
	var method;
	
	function live_css(div_id, css_name, thisform) {
		//pos = getMouseXY(e)
		
		live_php(div_id,'?p=live_contents&m=css&live_id=' + css_name + '&live=true','post',thisform);
		
		//document.getElementById(div_id).innerHTML = '--->' + pos['x'] + css_name + pos['y'] + '<---'; 
 
		//div_pop(css_name, 'live_content', 'live_content', pos, div_id);
	}

	function div_pop(html,div_id,div_class,pos, rel_id) {
		rel = document.getElementById(rel_id);
		rel_x = rel.style.width;
		rel_y = rel.style.top;
		alert(rel.style);
		div = document.getElementById(div_id);
		div.innerHTML = '--->' + rel_x + html + rel_y + '<---';
		//div.style.left = pos['x'] + 'px';		
		//div.style.top = pos['y'] + 'px';
		div.style.left = rel_x + 'px';		
		div.style.top = rel_y + 'px';
		div.style.position = 'absolute';
		div.style.margin = '0px 0px 0px 0px';
		div.style.visibility = "visible";
	} 
	
	function getMouseXY(e) {
		var pos = new Array();
		
		pos['x'] = e.pageX
		pos['y'] = e.pageY
	  
		return pos
	}	
		
	function live_php(div_id,url,method,thisform) {
		fill_id=div_id;		
		wait('processing...' + method);
		document.getElementById(fill_id).style.visibility="visible"; 
		xmlhttp=null;

		if (window.XMLHttpRequest) {// code for Firefox, Opera, IE7, etc.
			xmlhttp=new XMLHttpRequest();
		} else if (window.ActiveXObject) {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		 
		if (xmlhttp!=null) { 	
			xmlhttp.onreadystatechange=div_fill;
			
			if (method=='post') {
				xmlhttp.open('POST',url,true); 
				xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");				
				xmlhttp.send(buildQuery(thisform)); 
			} else {
				xmlhttp.open('GET',url,true);
				xmlhttp.send(null);
			}  
		} else {
			alert("Your browser does not support XMLHTTP.");
		}		
	}	
	
	function buildQuery (formElement) {  
	    var query = "";
		
		for (var i=0; i< formElement.length; i++) {
             query += formElement[i].name + '=' + formElement[i].value + '&';
	    } 
		
		return query;
	} 
	
	
	function set_ini(ini_key,ini_value) {
		items_ini[ini_key] = ini_value;
	}

	function div_fill() {
		if (xmlhttp.readyState==4) {// 4 = "loaded"
			if (xmlhttp.status==200){// 200 = "OK"
				//alert(xmlhttp.responseText);
				document.getElementById(fill_id).innerHTML=xmlhttp.responseText;
			} else {
				alert("Problem retrieving data:" + xmlhttp.statusText);
			}
		}
	}	

	function wait(wait_message) {
		document.getElementById(fill_id).innerHTML=wait_message;
	}
	