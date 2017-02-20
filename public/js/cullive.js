function updateViewPost(path, id, content, token) {
  $.post(path, { _token:token, _id:id, _content:content },
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		$('#'+id).html(data);
	  }
    }
  );
}
