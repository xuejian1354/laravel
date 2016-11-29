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
var clilist = new HashMap();
var camlist = new HashMap();
var storagecamlist = new HashMap();

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
* WebSocket for Gateway
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
* WebSocket for Client
*/
cliserver = new WebSocketServer({port: 8021});
cliserver.on('connection', function(cli) {

	cli.on('close', function(code, message) {
		if(typeof(this.clirand) != "undefined" && clilist.has(this.clirand) == true) {
			clilist.remove(this.clirand);
		}

		console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + " Websocket Close, clirand=" + this.clirand  + " ========>>>");
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
				console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + " New Client Connection, clirand=" + this.clirand);
			}
		}
		else if(typeof(this.gwsn) != "undefined"
			&& typeof(this.devsn) != "undefined"
			&& typeof(this.data) != "undefined") {
			var ws = gwlist.get(this.gwsn);
			if(typeof(ws) !== "undefined") {
				console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + ' Send ctrl messsage, devsn=' + this.devsn + ', data=' + this.data);
				ws.send(controlToFrame(this.gwsn, this.devsn, this.data));
			}
			else {
				console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + ' No gateway found, gwsn=' + this.gwsn);
			}
		}
	});
});

/*
* Http server
*/
var express = require('express');
var app = express();

app.post('/getffrtmplist', function (req, res) {

	var camobjs = new Array();
	camlist.forEach(function (cam, camrand) {
		var camobj = {
			name: cam.name,
			protocol: 'rtsp',
			source: cam.url,
			host: 'localhost',
			rtmp_port: 1935,
			rtmp_path: '/ffrtmp/' + cam.name
		};

		camobjs.push(camobj);
	});

	if(camobjs.length > 0) {
		var jpcams = JSON.stringify(camobjs);
		res.send(jpcams);
	}
	else {
		res.send('');
	}
});

app.post('/getffstoragelist', function (req, res) {

	var camobjs = new Array();
	storagecamlist.forEach(function (cam, camrand) {
		var camobj = {
			name: cam.name,
			protocol: 'rtsp',
			source: cam.url,
			storage_path: cam.outurl
		};

		camobjs.push(camobj);
	});

	if(camobjs.length > 0) {
		var jpcams = JSON.stringify(camobjs);
		res.send(jpcams);
	}
	else {
		res.send('');
	}
});

app.listen(8081);


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

var redis = require('redis');
var redisClient = redis.createClient();
redisClient.subscribe('devdata-updating');
redisClient.subscribe('ffmpeg-rtmp');
redisClient.subscribe('ffmpeg-storage');

redisClient.on("message", function(channel, message) {
	console.log(message);

	if(channel == 'devdata-updating') {
		clilist.forEach(function (cli, clirand) {
			cli.send(message);
		});
	}
	else if(channel == 'ffmpeg-rtmp') {
		var mobj = JSON.parse(message);

		if(typeof(mobj.opt) == "undefined") {
			return;
		}

		if(mobj.opt == 'add'
			&& typeof(mobj.name) != "undefined"
			&& typeof(mobj.url) != "undefined") {

			if(camlist.has(mobj.name)) {
				return;
			}

			var inputPath = mobj.url;
			var outputPath = 'rtmp://localhost:1935/ffrtmp/' + mobj.name;

			var ffmpeg = require('fluent-ffmpeg');
			var mypeg = ffmpeg(inputPath);
			mypeg.isset = 'init';
			mypeg.name = mobj.name;
			mypeg.url = mobj.url;
			mypeg.outurl = outputPath;

			mypeg.on('start', function(commandLine) {
				console.log('Spawned FFmpeg with command: ' + commandLine);
				if(this.isset == 'init') {
					if(camlist.has(this.name)) {
						this.kill();
					}
				}
			})
			.on('progress', function(progress) {
				if(this.isset == 'init') {
					if(camlist.has(this.name)) {
						console.log('reaction, no progress camstream, name: ' + this.name);
					}
					else {
						this.isset = 'work';
						camlist.set(this.name, this);
						console.log('Camera add for ffmpeg handle, name: ' + this.name + ', url: ' + this.url);
					}
				}
				else if(this.isset == 'work') {}
				else if(this.isset == 'end') {
					console.log('Camera no progressing');
				}
			})
			.on('error', function(err, stdout, stderr) {
				console.log(err.message);
				//console.log('stdout: ' + stdout);
				//console.log('stderr: ' + stderr);
			})
			.on('end', function() {
				console.log('Processing finished !');
			})
			.addOptions([
				'-vcodec copy',
				'-acodec aac'
			])
			.format('flv')
			.pipe(outputPath, { end: true });
		}
		else if(mobj.opt == 'del' && typeof(mobj.name) != "undefined") {
			var mcam = camlist.get(mobj.name);
			if(mcam) {
				mcam.isset = 'end';
				mcam.kill();
			}
			camlist.remove(mobj.name);
			console.log('Camera del from list, name: ' + mobj.name);
		}
	}
	else if(channel == 'ffmpeg-storage') {
		var mobj = JSON.parse(message);

		if(typeof(mobj.opt) == "undefined") {
			return;
		}

		if(mobj.opt == 'storage'
			&& typeof(mobj.name) != "undefined"
			&& typeof(mobj.url) != "undefined") {

			if(storagecamlist.has(mobj.name)) {
				return;
			}

			var inputPath = mobj.url;
			var savePath = mobj.path_dir + '/' + mobj.name + '.mp4';
			var outputPath = mobj.path_dir + '/' + mobj.name + '_' + new Date().format('yyMMddhhmmss') + '.mp4';

			var ffmpeg = require('fluent-ffmpeg');
			var mypeg = ffmpeg(inputPath);
			mypeg.isset = 'init';
			mypeg.name = mobj.name;
			mypeg.path_dir = mobj.path_dir;
			mypeg.timelong = mobj.timelong;	//mins
			mypeg.url = mobj.url;
			mypeg.saveurl = savePath;
			mypeg.outurl = outputPath;

			mypeg.on('start', function(commandLine) {
				console.log('Spawned FFmpeg with command: ' + commandLine);
			})
			.on('progress', function(progress) {
				if(this.isset == 'init') {
					this.isset = 'work';
					if(storagecamlist.has(this.name) == false) {
						storagecamlist.set(this.name, this);

						var timefunc = function(cam) {
							return function() {
								cam.isset = 'rework';
								cam.kill('SIGINT');
							}
						};
						setTimeout(timefunc(this), this.timelong*60000-1000);

						console.log('Camera storage for ffmpeg handle, name: ' + this.name + ', url: ' + this.url);
					}
					else {
						var obcam = storagecamlist.get(this.name);
						obcam.kill();
						storagecamlist.remove(this.name);

						storagecamlist.set(this.name, this);
						console.log('reaction, no progress storage, name: ' + this.name);
					}
				}
				else if(this.isset == 'work') {}
				else if(this.isset == 'rework') {
					var reworkfunc = function(cam) {
						return function() {
							var fs =  require("fs");
							fs.rename(cam.saveurl, cam.outurl);
							cam.outurl = cam.path_dir
											+ '/' + cam.name
											+ '_' + new Date().format('yyMMddhhmmss')
											+ '.mp4';

							cam.isset = 'work';
							cam.run();

							var timefunc = function(cam) {
							return function() {
									cam.isset = 'rework';
									cam.kill('SIGINT');
								}
							};
							setTimeout(timefunc(cam), cam.timelong * 60000);

							console.log('Camera storage rework, name: ' + cam.name);
						}
					};
					setTimeout(reworkfunc(this), 500);
				}
				else if(this.isset == 'end') {
					if(storagecamlist.has(this.name)) {
						storagecamlist.remove(this.name);
						console.log('Progress storage, del cam from list, name: ' + this.name);
					}
				}
			})
			.on('error', function(err, stdout, stderr) {
				console.log(err.message);
				//console.log('stdout: ' + stdout);
				//console.log('stderr: ' + stderr);
			})
			.on('end', function() {
				console.log('Processing finished !');
			})
			.addOptions([
				'-vcodec copy',
				'-acodec aac',
				'-metadata title=' + mobj.name,
			])
			.save(savePath);
		}
		else if(mobj.opt == 'del' && typeof(mobj.name) != "undefined") {
			var mcam = storagecamlist.get(mobj.name);
			if(mcam) {
				mcam.isset = 'end';
				mcam.kill('SIGINT');

				var fs =  require("fs");
				fs.rename(mcam.saveurl, mcam.outurl);

				if(storagecamlist.has(mcam.name)) {
					storagecamlist.remove(mcam.name);
					console.log('Progress storage, del cam from list, name: ' + mcam.name);
				}
			}

			console.log('Camera storage del from list, name: ' + mobj.name);
		}
	}
});

/*
* Handler Frame Operations
*/
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

function refreshToFrame(gw_sn, random)
{
	var ret = '{"action":"' +
				refresh + '", "obj":{"owner":"server", "custom":"gateway"}, "gw_sn":"' +
				gw_sn + '", "random":"' +
				random + '"}';

	return ret;
}
