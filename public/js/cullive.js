function devstaChange(devsn, data, at) {
  if(data.length > 0) {
    $('#devsta'+devsn).removeClass('label-danger');
	$('#devsta'+devsn).addClass('label-success');
	$('#devsta'+devsn).text(data);
	$('#devat'+devsn).text(at);
  }
  else {
    $('#devsta'+devsn).addClass('label-danger');
    $('#devsta'+devsn).removeClass('label-success');
    $('#devsta'+devsn).text('离线');
  }
}

function setWs(ws) {
	this.ws = ws;
}

function getWs() {
	return this.ws;
}

function wsConnect(callback) {
	var url = 'ws://' + window.location.host + ':8021';
	var ws = new WebSocket(url);

	ws.onopen = function(evt) {
		var clirand = String(Math.random()).substring(2, 16);
		ws.send('{"clirand":"' + clirand + '"}');
		setWs(ws);
	};

	ws.onerror = function(evt) {
	};

	ws.onmessage = function(evt) {
		callback(evt.data);
	};

	ws.onclose = function(evt) {
		setTimeout(wsConnect(), 2000);
	};
}

function devCtrlPost(sw, devsn, gwsn) {
  ws = getWs();
  ws.send('{ "gwsn":"' + gwsn + '", "devsn":"' + devsn + '", "data":"' + sw + '" }');
}

function updateDevListPost(hid, pg) {
  $.post('/'+'{{ $request->path() }}',
    { _token:'{{ csrf_token() }}', way:hid, page:pg },
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		$('#'+hid).html(data);
	  }
    }
  );
}