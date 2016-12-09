/*
* HashMap for WebSocket Connection
*/
var HashMap = require('hashmap');
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
console.log(new Date().format('yyyy-MM-dd hh:mm:ss') + " WebSocket Server of Camera Start ...");

/*
* Http server
*/
var express = require('express');
var app = express();

var bodyParser = require('body-parser');
//create application/json parser
//var jsonParser = bodyParser.json();
// create application/x-www-form-urlencoded parser
var urlencodedParser = bodyParser.urlencoded({ extended: false });

app.post('/ffrtmp', urlencodedParser, function (req, res) {

	if(req.body.opt == 'list') {
		var camobjs = new Array();
		camlist.forEach(function (cam, camrand) {
			var camobj = {
				name: cam.name,
				protocol: 'rtsp',
				source: cam.url,
				host: req.hostname,
				rtmp_port: 1935,
				rtmp_path: '/ffrtmp/' + cam.name
			};
	
			camobjs.push(camobj);
		});
	
		if(camobjs.length > 0) {
			var jpcams = JSON.stringify(camobjs);
			return res.send(jpcams);
		}
	}
	else if(req.body.opt == 'add') {
		if(camlist.has(req.body.name)) {
			return res.send('');;
		}

		var inputPath = req.body.url;
		var outputPath = 'rtmp://localhost:1935/ffrtmp/' + req.body.name;

		var ffmpeg = require('fluent-ffmpeg');
		var mypeg = ffmpeg(inputPath);
		mypeg.isset = 'init';
		mypeg.name = req.body.name;
		mypeg.url = req.body.url;
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
	else if(req.body.opt == 'del') {
		var mcam = camlist.get(req.body.name);
		if(mcam) {
			mcam.isset = 'end';
			mcam.kill();
		}
		camlist.remove(req.body.name);
		console.log('Camera del from list, name: ' + req.body.name);
	}

	return res.send('');
});

app.post('/ffstorage', urlencodedParser, function (req, res) {

	if(req.body.opt == 'list') {
		var camobjs = new Array();
		storagecamlist.forEach(function (cam, camrand) {
			var camobj = {
				host: req.hostname,
				name: cam.name,
				protocol: 'rtsp',
				source: cam.url,
				storage_path: cam.outurl
			};
	
			camobjs.push(camobj);
		});
	
		if(camobjs.length > 0) {
			var jpcams = JSON.stringify(camobjs);
			return res.send(jpcams);
		}
	}
	else if(req.body.opt == 'add') {
		if(storagecamlist.has(req.body.name)) {
			return res.send('');;
		}

		var inputPath = req.body.url;
		var savePath = req.body.path_dir + '/' + req.body.name + '.mp4';
		var outputPath = req.body.path_dir + '/' + req.body.name + '_' + new Date().format('yyMMddhhmmss') + '.mp4';

		var ffmpeg = require('fluent-ffmpeg');
		var mypeg = ffmpeg(inputPath);
		mypeg.isset = 'init';
		mypeg.name = req.body.name;
		mypeg.path_dir = req.body.path_dir;
		mypeg.timelong = req.body.timelong;	//mins
		mypeg.url = req.body.url;
		mypeg.saveurl = savePath;
		mypeg.outurl = outputPath;

		try {
			var fs =  require("fs");
			fs.exists(mypeg.saveurl, function(exists) {
				if (exists) {
					fs.renameSync(mypeg.saveurl, mypeg.outurl);
				}
			});
		} catch(e) {
			console.log(e);
		}

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
						cam.outurl = cam.path_dir
										+ '/' + cam.name
										+ '_' + new Date().format('yyMMddhhmmss')
										+ '.mp4';

						try {
							var fs =  require("fs");
							fs.exists(cam.saveurl, function(exists) {
								if (exists) {
									fs.renameSync(cam.saveurl, cam.outurl);
								}
							});
						} catch(e) {
							console.log(e);
						}

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

			this.outurl = this.path_dir
							+ '/' + this.name
							+ '_' + new Date().format('yyMMddhhmmss')
							+ '.mp4';

			try {
				var fs =  require("fs");
				fs.exists(this.saveurl, function(exists) {
					if (exists) {
						fs.renameSync(this.saveurl, this.outurl);
			  		}
				});
			} catch(e) {
				console.log(e);
			}

			this.isset = 'end';
			if(storagecamlist.has(this.name)) {
				storagecamlist.remove(this.name);
				console.log('Progress storage, del cam from list, name: ' + this.name);
			}
		})
		.addOptions([
			'-vcodec copy',
			'-acodec aac',
			'-metadata title=' + req.body.name,
		])
		.save(savePath);
	}
	else if(req.body.opt == 'del') {
		var mcam = storagecamlist.get(req.body.name);
		if(mcam) {
			mcam.isset = 'end';
			mcam.kill('SIGINT');

			try {
				var fs =  require("fs");
				fs.exists(mcam.saveurl, function(exists) {
					if (exists) {
						fs.renameSync(mcam.saveurl, mcam.outurl);
			  		}
				});
			} catch(e) {
				console.log(e);
			}

			if(storagecamlist.has(mcam.name)) {
				storagecamlist.remove(mcam.name);
				console.log('Progress storage, del cam from list, name: ' + mcam.name);
			}
		}

		console.log('Camera storage del from list, name: ' + req.body.name);
	}

	return res.send('');
});

app.listen(8081);

/*var redis = require('redis');
var redisClient = redis.createClient();
redisClient.subscribe('ffmpeg-rtmp');
redisClient.subscribe('ffmpeg-storage');

redisClient.on("message", function(channel, message) {
	console.log(message);

	if(channel == 'ffmpeg-storage') {
		var mobj = JSON.parse(message);

		if(typeof(mobj.opt) == "undefined") {
			return;
		}

		if(mobj.opt == 'storage'
			&& typeof(mobj.name) != "undefined"
			&& typeof(mobj.url) != "undefined") {

			
		}
		else if(mobj.opt == 'del' && typeof(mobj.name) != "undefined") {
			
		}
	}
});*/
