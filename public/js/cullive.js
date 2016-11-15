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
		setTimeout(wsConnect(callback), 2000);
	};
}

function devOptCtrl(devsn, gwsn, method, channel, index, data) {
	if(method == 'trigger') {
		ctrls = JSON.parse(data);

		data = $('#devsta'+devsn).text();
		darr = new Array(channel);
		for(i=0; i<channel; i++) {
			darr[i] = data.substr(i*ctrls.on.length, ctrls.on.length);
		}

		if(darr[index] == ctrls.off) {
			darr[index] = ctrls.on;
		}
		else {
			darr[index] = ctrls.off;
		}

		ctrldata = '';
		for(i=0; i<channel; i++) {
			ctrldata += darr[i];
		}

		devCtrlPost(ctrldata, devsn, gwsn);
	}
	else if(method == 'switch') {
		devCtrlPost(data, devsn, gwsn);
	}
}

function devCtrlPost(sw, devsn, gwsn) {
  ws = getWs();
  ws.send('{ "gwsn":"' + gwsn + '", "devsn":"' + devsn + '", "data":"' + sw + '" }');
}

function updateDevListPost(path, hid, pg, token) {
  $.post('/'+path,
    { _token:token, way:hid, page:pg },
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