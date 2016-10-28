/*
* Define for Frame Fields
*/
var tocolreq = "1";
var report = "2";
var check = "3";
var respond = "4";
var refresh = "5";
var control = "6";
var tocolres = "7";

/*
* HashMap for WebSocket Connection
*/
var HashMap = require('hashmap');
var gwlist = new HashMap();

/*
* Date
*/
Date.prototype.format =function(format)
{
	var o = {
		"M+" : this.getMonth()+1, //month
		"d+" : this.getDate(),    //day
		"h+" : this.getHours(),   //hour
		"m+" : this.getMinutes(), //minute
		"s+" : this.getSeconds(), //second
		"q+" : Math.floor((this.getMonth()+3)/3),  //quarter
		"S" : this.getMilliseconds() //millisecond
	}

	if(/(y+)/.test(format))
		format=format.replace(RegExp.$1, (this.getFullYear()+"").substr(4- RegExp.$1.length));

	for(var k in o)
		if(new RegExp("("+ k +")").test(format))
			format = format.replace(RegExp.$1, RegExp.$1.length==1? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));

	return format;
}

//Start log ...
console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + " WebSocket Server Start ...");

/*
* WebSocket Service
*/
var WebSocketServer = require('ws').Server, wss = new WebSocketServer({port: 8020});
wss.on('connection', function(ws) {

	ws.on('close', function(code, message) {
		if(typeof(this.gw_sn) != "undefined" && gwlist.has(this.gw_sn) == true) {
			gwlist.remove(this.gw_sn);
		}

		console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + " Websocket Close, gw_sn=" + this.gw_sn  + " ========>>>");
	});

	ws.on('message', function(data, flags) {
		var mobj = JSON.parse(data);
		switch(mobj.action)
		{
		case tocolreq:
			if(mobj.protocol == "websocket"
				&& typeof(mobj.gw_sn) != "undefined"
				&& typeof(mobj.protocol) != "undefined"
				&& typeof(mobj.random) != "undefined")
			{
				this.gw_sn = mobj.gw_sn;
				this.action = mobj.action;
				this.random = mobj.random;

				if(gwlist.has(this.gw_sn) == false) {
					gwlist.set(this.gw_sn, ws);
				}

				ws.send(tocolresToFrame(tocolreq, mobj.random));

				console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + ", gw_sn=" + this.gw_sn + ", The action is tocolreq " + this.action + ", random=" + this.random);
			}
			break;

		case report:
			if(typeof(mobj.gw_sn) != "undefined"
				&& typeof(mobj.devices) != "undefined"
				&& typeof(mobj.random) != "undefined")
			{
				this.gw_sn = mobj.gw_sn;
				this.action = mobj.action;
				this.random = mobj.random;

				if(gwlist.has(this.gw_sn) == false) {
					gwlist.set(this.gw_sn, ws);
				}

				for(var i=0; i<mobj.devices.length; i++){
					var device = mobj.devices[i];
					if(typeof(device.dev_sn) != "undefined"
						&& typeof(device.dev_data) != "undefined")
					{
						devDataRequest(mobj.gw_sn, device.dev_sn, device.dev_data, function(info, msg){
							ws.send(msg);
						});
					}
				}

				//ws.send(tocolresToFrame(report, mobj.random));

				console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + ", gw_sn=" + this.gw_sn + ", The action is report " + this.action + ", random=" + this.random);
			}
			break;

		case check:
			if(typeof(mobj.gw_sn) != "undefined"
				&& mobj.code[0].code_check == "md5"
				&& typeof(mobj.random) != "undefined"){

				this.gw_sn = mobj.gw_sn;
				this.action = mobj.action;
				this.random = mobj.random;

				if(gwlist.has(this.gw_sn) == false) {
					gwlist.set(this.gw_sn, ws);
				}

				ws.send(tocolresToFrame(check, mobj.random));

				console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + ", gw_sn=" + this.gw_sn + ", The action is check " + this.action + ", random=" + this.random);
			}
			break;

		case respond:
			if(typeof(mobj.gw_sn) != "undefined"
				&& typeof(mobj.dev_sn) != "undefined"
				&& typeof(mobj.random) != "undefined")
			{
				this.gw_sn = mobj.gw_sn;
				this.action = mobj.action;
				this.random = mobj.random;

				if(gwlist.has(this.gw_sn) == false) {
					gwlist.set(this.gw_sn, ws);
				}

				ws.send(tocolresToFrame(respond, mobj.random));

				console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + ", gw_sn=" + this.gw_sn + ", The action is respond " + this.action + ", random=" + this.random);
			}
			break;

		default:
			console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + " Unrecognize frame, cannot parse for it. Handle action is " + mobj.action);
		}
	});
});

/*
* Socket.IO Service
*/
var io = require('socket.io')();
io.on('connection', function(socket){
	socket.on('DevOpt', function(data) {
		var optObj = JSON.parse(data);
		var gw_sn = optObj[0].gw_sn;
		if(typeof(gw_sn) != "undefined") {
			var ws = gwlist.get(gw_sn);
			if(typeof(ws) !== "undefined") {
				var senData = JSON.stringify(optObj[0]);
				console.log(senData);
				ws.send(senData);
			}
			else {
				console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + ' No client exist');
			}
		}
	});
});
io.listen(8033);

function devDataRequest(psn, sn, data, callback)
{
	var http = require('http');

	var options =
	{
		hostname : '127.0.0.1',
		port : 80,
		method : 'GET',
		path : '/devdata?psn='+psn+'&sn='+sn+'&data='+data
	};

	var req = http.request(options, function(res){
		//console.log(res);
		//console.log('STATUS:' + res.statusCode);
		//console.log('HEADERS:' + JSON.stringify(res.headers));
		res.setEncoding('utf8');
		res.on('data', function(chunk){
		   callback('data', chunk);
		});
	});

	req.on('error', function(e){
	   callback('error', e.message);
	});

	req.end();
}

/*
* Handler Frame Operations
*/
function tocolresToFrame(action, random)
{
	var ret = '{"action":"' +
				tocolres + '", "obj":{"owner":"server", "custom":"gateway"}, "req_action":"' +
				action + '", "random":"' +
				random + '"}';

	return ret;
}

function refreshToFrame(gw_sn, random)
{
	var ret = '{"action":"' +
				refresh + '", "obj":{"owner":"server", "custom":"gateway"}, "gw_sn":"' +
				gw_sn + '", "random":"' +
				random + '"}';

	return ret;
}
