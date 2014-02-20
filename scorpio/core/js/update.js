	function image_switch(genre,this_id) {
		img_name = genre.split(".");
		document.getElementById(this_id).src="files/" + img_name[0] + "_m." + img_name[1];
	}	
	
	function valid_delete(message,redirect) {
		if (confirm(message)) {
			window.location.href = redirect;
		} else {
			return false;
		}
	}	
