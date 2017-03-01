exports.listen = function() {
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

	var matrix = 'server';
	//var matrix = 'raspberrypi';

	var hostserver = 'cullive.com';

	/*
	* HashMap for WebSocket Connection
	*/
	var HashMap = require('hashmap');
	var gwlist = new HashMap();
	var clilist = new HashMap();

	var ftime = require('./ftime');

	//Start log ...
	console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + " WebSocket Server of Node Start ...");

	if(matrix == 'raspberrypi') {

		var macmodule = require('getmac');
		var macflag = '0000';
		var gwsn = 'FFFFFF';
		macmodule.getMac(function(err, macAddress) {
			var marr = macAddress.toUpperCase().split(':');
			macflag = marr[4] + marr[5];
			gwsn = marr[3] + marr[4] + marr[5];
		});

		/* Operation for SerialPort */
		var SerialPort = require('serialport');
		var readBuf = '';
		var port = new SerialPort("/dev/ttyUSB0", {
			autoOpen: true,
			lock: true,
			baudRate: 9600,
			dataBits: 8,
			stopBits: 1,
			parity: 'none',
			vmin: 9,
			vtime: 1
		});

		port.dmap = new HashMap();

		port.on('data', function(data) {
			readBuf += data.toString('hex').toUpperCase();
			var devmac = macflag + readBuf.substr(0, 2);
			var data = readBuf.substr(6, 8);

			if(readBuf.length >= 18) {
				var beforedata = this.dmap.get(devmac);
				if(beforedata == data) {
					//console.log('repeat serial port data, ["' + devmac + '" => "' + data + '"]');
					return;
				}
				else {
					//console.log('setting serial port data, ["' + devmac + '" => "' + data + '"]');
					this.dmap.set(devmac, data);
				}

				var frame = reportToFrame(gwsn, devmac, data);
				updataHandler(port, frame, matrix);
				if(wsock.isopen) {
					wsock.send(frame);
				}
			}
		});

		port.on('error', function(err) {
			console.log(err.message);
		});

		/* Operation for WebSocket */
		var wsock;
		wsConnect();

		function wsConnect() {
			var WebSocket = require('ws');
			wsock = new WebSocket('ws://' + hostserver + ':8020');

			wsock.on('open', function open() {
				console.log('connected to server...');
				this.isopen = true;
				this.send(tocolreqToFrame(gwsn));
			}).on('close', function close() {
				console.log('disconnected with server');
				this.isopen = false;
				setTimeout(function() { wsConnect(); }, 2000);
			}).on('error', function error(code, description) {
				console.log('error: ' + code + (description ? ' ' + description : ''));
				this.isopen = false;
			}).on('message', function message(data, flags) {
				//console.log(data);
				if(data.charAt(0) != '{'
					&& data.charAt(0) != ' ') {
					return;
				}

				var mobj = JSON.parse(data);
				if(mobj.action == control
					&&typeof(mobj.gw_sn) != "undefined"
					&& typeof(mobj.ctrls) != "undefined"
					&& typeof(mobj.random) != "undefined")
				{
					for(var i=0; i<mobj.ctrls.length; i++) {
						var ctrl = mobj.ctrls[i];
						if(typeof(ctrl.dev_sn) != "undefined"
							&& typeof(ctrl.cmd) != "undefined")
						{
							var devid = parseInt(ctrl.dev_sn.slice(-2), 16);
							var data = parseInt(ctrl.cmd, 16);
							var frame = devCtrl(devid, data);

							console.log('SerialPort Write: ');
							console.log(frame);

							port.write(frame);
						}
					}

					console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + ", gw_sn=" + mobj.gw_sn + ", The action is control " + mobj.action + ", random=" + mobj.random);
				}
			});
		}
	
		/* Operation for node-schedule */
		var schedule = require('node-schedule');
		var rule = new schedule.RecurrenceRule();
		var times = [];
		for(var i=1; i<60; i++) {
			times.push(i);
		}
		rule.second = times;

		var c = 1;
		schedule.scheduleJob(rule, function() {
			var frame = getDevoptFrame(c++, 0, 2);
			//console.log('Query-to-Serial: ' + frame.toString('hex').toUpperCase());
			readBuf = '';
			if(c < 30){
				port.write(frame);
			}

			if(c > 60) {
				c = 1;
			}
		});
	}
	else {
		/*
		* WebSocket for Gateway
		*/
		var WebSocketServer = require('ws').Server, wss = new WebSocketServer({port: 8020});
		wss.on('connection', function(ws) {

			ws.on('close', function(code, message) {
				if(typeof(this.gw_sn) != "undefined" && gwlist.has(this.gw_sn) == true) {
					gwlist.remove(this.gw_sn);
				}

				console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + " Websocket Close, gw_sn=" + this.gw_sn  + " ========>>>");
			});

			ws.on('message', function(data, flags) {
				updataHandler(ws, data, matrix);
			});
		});
	}

	/*
	* WebSocket for Client
	*/
	var WebSocketServer = require('ws').Server, cliserver = new WebSocketServer({port: 8021});
	cliserver.on('connection', function(cli) {

		cli.on('close', function(code, message) {
			if(typeof(this.clirand) != "undefined" && clilist.has(this.clirand) == true) {
				clilist.remove(this.clirand);
			}

			console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + " Websocket Close, clirand=" + this.clirand  + " ========>>>");
		});

		cli.on('message', function(data, flags) {
			var optObj = JSON.parse(data);

			if(typeof(this.clirand) == "undefined" && typeof(optObj.clirand) != "undefined") {
				this.clirand = optObj.clirand;
			}

			this.gwsn = optObj.gwsn;
			this.devsn = optObj.devsn;
			this.data = optObj.data;

			if(typeof(optObj.clirand) != "undefined") {
				if(clilist.has(this.clirand) == false) {
					clilist.set(this.clirand, cli);
					console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + " New Client Connection, clirand=" + this.clirand);
				}
			}
			else if(typeof(this.gwsn) != "undefined"
				&& typeof(this.devsn) != "undefined"
				&& typeof(this.data) != "undefined") {
				var ws = gwlist.get(this.gwsn);
				if(typeof(ws) !== "undefined") {
					console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + ' Send ctrl messsage, devsn=' + this.devsn + ', data=' + this.data);
					if(matrix == 'raspberrypi') {
						var devid = parseInt(this.devsn.slice(-2), 16);
						var data = parseInt(this.data, 16);
						var frame = devCtrl(devid, data);
						console.log(frame);
						ws.write(frame);
					}
					else {
						ws.send(controlToFrame(this.gwsn, this.devsn, this.data));
					}
				}
				else {
					console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + ' No gateway found, gwsn=' + this.gwsn);
				}
			}
		});
	});

	var redis = require('redis');
	var redisClient = redis.createClient();
	redisClient.subscribe('devdata-updating');

	redisClient.on("message", function(channel, message) {
		console.log(message);

		if(channel == 'devdata-updating') {
			clilist.forEach(function (cli, clirand) {
				cli.send(message);
			});
		}
	});

	function getDevoptFrame(devid, data, len)
	{
		var frame = new Buffer(8);

		frame[0] = devid;
		frame[1] = 0x03;
		frame[2] = (data>>8) & 0xFF;
		frame[3] = data & 0xFF;
		frame[4] = (len>>8) & 0xFF;
		frame[5] = len & 0xFF;

		var crcval = crcCheck(frame, 6);
		frame[6] = (crcval>>8) & 0xFF;
		frame[7] = crcval & 0xFF;

		return frame;
	}

	function devCtrl(devid, data)
	{
		var frame = new Buffer(8);

		frame[0] = devid;
		frame[1] = 0x04;
		frame[2] = (data>>24) & 0xFF;
		frame[3] = (data>>16) & 0xFF;
		frame[4] = (data>>8) & 0xFF;
		frame[5] = data & 0xFF;

		var crcval = crcCheck(frame, 6);
		frame[6] = (crcval>>8) & 0xFF;
		frame[7] = crcval & 0xFF;

		return frame;
	}

	function crcCheck(msg, len)
	{
		var crc = 0xFFFF;
		for (var i=0; i<len; i++) {
			var current = msg[i] & 0xFF;
			crc ^= current;
			for (var j=0; j < 8; j++) {
				if (crc & 0x0001) {
					crc >>= 1;
					crc ^= 0xA001;
				}
				else {
					crc >>= 1;
				}
			}
		}

		crc = (crc>>8) + (crc<<8);
		return crc;
	}

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

	function updataHandler(ws, data, matrix) {
		var mobj = JSON.parse(data);
		switch(mobj.action)
		{
		case tocolreq:
			if(mobj.protocol == "websocket"
				&& typeof(mobj.gw_sn) != "undefined"
				&& typeof(mobj.protocol) != "undefined"
				&& typeof(mobj.random) != "undefined")
			{
				ws.gw_sn = mobj.gw_sn;
				ws.action = mobj.action;
				ws.random = mobj.random;

				if(gwlist.has(ws.gw_sn) == false) {
					gwlist.set(ws.gw_sn, ws);
				}

				if(matrix != 'raspberrypi') {
					ws.send(tocolresToFrame(tocolreq, mobj.random));
				}

				console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + ", gw_sn=" + ws.gw_sn + ", The action is tocolreq " + ws.action + ", random=" + ws.random);
			}
			break;

		case report:
			if(typeof(mobj.gw_sn) != "undefined"
				&& typeof(mobj.devices) != "undefined"
				&& typeof(mobj.random) != "undefined")
			{
				ws.gw_sn = mobj.gw_sn;
				ws.action = mobj.action;
				ws.random = mobj.random;

				if(gwlist.has(ws.gw_sn) == false) {
					gwlist.set(ws.gw_sn, ws);
				}

				for(var i=0; i<mobj.devices.length; i++){
					var device = mobj.devices[i];
					if(typeof(device.dev_sn) != "undefined"
						&& typeof(device.dev_data) != "undefined")
					{
						devDataRequest(mobj.gw_sn, device.dev_sn, device.dev_data, function(info, msg){
							if(matrix != 'raspberrypi') {
								ws.send(msg);
							}
						});
					}
				}

				console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + ", gw_sn=" + ws.gw_sn + ", The action is report " + ws.action + ", random=" + ws.random);
			}
			break;

		case check:
			if(typeof(mobj.gw_sn) != "undefined"
				&& mobj.code[0].code_check == "md5"
				&& typeof(mobj.random) != "undefined"){

				ws.gw_sn = mobj.gw_sn;
				ws.action = mobj.action;
				ws.random = mobj.random;

				if(gwlist.has(ws.gw_sn) == false) {
					gwlist.set(ws.gw_sn, ws);
				}

				if(matrix != 'raspberrypi') {
					ws.send(tocolresToFrame(check, mobj.random));
				}

				console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + ", gw_sn=" + ws.gw_sn + ", The action is check " + ws.action + ", random=" + ws.random);
			}
			break;

		case respond:
			if(typeof(mobj.gw_sn) != "undefined"
				&& typeof(mobj.dev_sn) != "undefined"
				&& typeof(mobj.random) != "undefined")
			{
				ws.gw_sn = mobj.gw_sn;
				ws.action = mobj.action;
				ws.random = mobj.random;

				if(gwlist.has(ws.gw_sn) == false) {
					gwlist.set(ws.gw_sn, ws);
				}

				if(matrix == 'raspberrypi') {
					ws.write(tocolresToFrame(respond, mobj.random));
				}
				else {
					ws.send(tocolresToFrame(respond, mobj.random));
				}

				console.log(ftime.date('yyyy-MM-dd hh:mm:ss') + ", gw_sn=" + ws.gw_sn + ", The action is respond " + ws.action + ", random=" + ws.random);
			}
			break;

		default:
			console.log(ftime.datet('yyyy-MM-dd hh:mm:ss') + " Unrecognize frame, cannot parse for it. \n\t\t    data=" + data);
		}
	}

	/*
	* Handler Frame Operations
	*/
	function tocolreqToFrame(gwsn)
	{
		var ret = '{"action":"1", "gw_sn":"'
					+ gwsn + '", "protocol":"websocket", "random":"'
					+ String(Math.random()).substring(4, 8) + '"}';

		return ret;
	}

	function reportToFrame(gwsn, devsn, data)
	{
		var ret = '{"action":"2", "gw_sn":"'
					+ gwsn + '", "devices":[{"dev_sn":"'
					+ devsn + '", "dev_data":"'
					+ data + '"}], "random":"'
					+ String(Math.random()).substring(4, 8) + '"}';

		return ret;
	}

	function controlToFrame(gwsn, devsn, data)
	{
		var ret = '{"action":"6", "gw_sn":"'
					+ gwsn + '", "ctrls":[{"dev_sn":"'
					+ devsn + '", "cmd":"'
					+ data + '"}], "random":"'
					+ String(Math.random()).substring(4, 8) + '"}';

		return ret;
	}

	function tocolresToFrame(action, random)
	{
		var ret = '{"action":"' +
					tocolres + '", "obj":{"owner":"server", "custom":"gateway"}, "req_action":"' +
					action + '", "random":"' +
					random + '"}';

		return ret;
	}
}
