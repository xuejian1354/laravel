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
* SQL Operations API
*/
var mysql = require('mysql');
var db_config = {
	host : '127.0.0.1',
	user : 'root',
	password : 'loong123',
	port : '3306',
	database : 'smartlab',
};

var sql_conn;

function handleDisconnect() {
  sql_conn = mysql.createConnection(db_config); // Recreate the connection, since
                                                  // the old one cannot be reused.
  sql_conn.connect(function(err) {              // The server is either down
    if(err) {                                     // or restarting (takes a while sometimes).
      console.log('error when connecting to db:', err);
      setTimeout(handleDisconnect, 2000); // We introduce a delay before attempting to reconnect,
    }                                     // to avoid a hot loop, and to allow our node script to
  });                                     // process asynchronous requests in the meantime.
                                          // If you're also serving http, display a 503 error.
  sql_conn.on('error', function(err) {
    console.log(new Date().format('yyyy-MM-dd hh:mm:ss'), err);
    if(err.code === 'PROTOCOL_CONNECTION_LOST') { // Connection to the MySQL server is usually
      handleDisconnect();                         // lost due to either server restart, or a
    } else {                                      // connnection idle timeout (the wait_timeout
      throw err;                                  // server variable configures this)
    }
  });
}

handleDisconnect();

/*
* WebSocket Service
*/
var WebSocketServer = require('ws').Server, wss = new WebSocketServer({port: 8010});
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

				var date = new Date().format('yyyy-MM-dd hh:mm:ss');
				sql_conn.query('INSERT INTO gateways (name, gw_sn, transtocol, area, ispublic, owner, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', 
					["网关"+mobj.gw_sn.substring(12), mobj.gw_sn, "websocket", "未设置", "0", "root", date, date], 
					function(err){});

				for(var i=0; i<mobj.devices.length; i++){
					var device = mobj.devices[i];
					if(typeof(device.dev_sn) != "undefined"
						&& typeof(device.znet_status) != "undefined"
						&& typeof(device.dev_data) != "undefined")
					{
						sql_conn.query('INSERT INTO devices (dev_sn, name, dev_type, znet_status, dev_data, gw_sn, area, ispublic, owner, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
							[device.dev_sn, device.name, device.dev_type, device.znet_status, device.dev_data, mobj.gw_sn, "未设置", "0", "root", date, date], 
							function(err){});

						sql_conn.query('UPDATE devices SET dev_type = ?, znet_status = ?, dev_data = ?, gw_sn = ? WHERE dev_sn = ?', 
							[device.dev_type, device.znet_status, device.dev_data, mobj.gw_sn, device.dev_sn], 
							function(err, result){
								if(err){
									console.log(err);
								}

								//console.log(JSON.stringify(result));
								if(result.changedRows > 0){
									sql_conn.query('UPDATE devices SET updated_at = ?', [date]);
								}
							});
					}
				}

				ws.send(tocolresToFrame(report, mobj.random));

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

				sql_conn.query('SELECT dev_data,znet_status FROM devices WHERE gw_sn = ? ORDER BY dev_sn ASC',
					[mobj.gw_sn],
					function(err, rows, fields){
						if(err){
							console.log(err);
						}
						var datas = "";
						for(var i=0; i<rows.length; i++){
							datas += rows[i].dev_data;
							datas += rows[i].znet_status;
						}

						var md5 = require('crypto').createHash('md5');
						md5.update(datas);
						if(md5.digest('hex').toUpperCase() == mobj.code[0].code_data){
							ws.send(tocolresToFrame(check, mobj.random));
						}
						else {
							ws.send(refreshToFrame(mobj.gw_sn, mobj.random));
						}
					});
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

				sql_conn.query('UPDATE devices SET dev_data = ?, gw_sn = ? WHERE dev_sn = ?', 
					[mobj.dev_data, mobj.gw_sn, mobj.dev_sn], 
					function(err, result){
						if(err){
							console.log(err);
						}

						//console.log(JSON.stringify(result));
						if(result.changedRows > 0){
							sql_conn.query('UPDATE devices SET updated_at = ?', [date]);
						}
					});

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
