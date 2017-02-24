function updateViewPost(path, id, content, token) {
  $.post(path, { _token:token, _id:id, _content:content },
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else if(id != ''){
		$('#'+id).html(data);
	  }
    }
  );
}

function updateAlertPost(path, content, token, callback) {
  $.post(path, { _token:token, _content:content },
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else if(typeof callback == 'function'){
		callback();
	  }
    }
  );
}
