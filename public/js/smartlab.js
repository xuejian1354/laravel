$(document).ready(function() {
  $(".nav-tabs .nav-li").click(function() {
    $(".nav-tabs .active").removeClass("active");
    $(this).addClass("active");
  });

  $(".nav-li-gw").click(function() {
    $(".table-gw").removeClass("hidden");
    $(".table-dev").addClass("hidden");
  });

  $(".nav-li-dev").click(function() {
    $(".table-dev").removeClass("hidden");
    $(".table-gw").addClass("hidden");
  });

  $(".roomcheckall").click(function() {
	  var tr = $('#roomtbody').children('tr');
	  var roomCheck = tr.children('td.roomedtcheck').children('input.roomcheck');

	  if($(this).prop('checked'))
	  {
		  roomCheck.prop('checked', true);
	  }
	  else
	  {
		  roomCheck.prop('checked', false);
	  }

	  roomCheck.trigger("roomEdtEvent");
  });

  $(".roomcheck").click(function() {
	  $(this).trigger("roomEdtEvent");
  });

  $(".roomcheck").bind("roomEdtEvent", function() {
	  var roomtab = $(this).parent().parent();

	  var roomsn = roomtab.children('td.roomsn');
	  var roomname = roomtab.children('td.roomname');
	  var roomtype = roomtab.children('td.roomtype');
	  var roomaddr = roomtab.children('td.roomaddr');
	  var roomstatus = roomtab.children('td.roomstatus');
	  var roomuser = roomtab.children('td.roomuser');
	  var roomadmin = roomtab.children('td.roomadmin');

	  var x;
	  var roomedts = new Array(roomname, roomtype, roomaddr, roomstatus, roomuser, roomadmin);

	  if($(this).prop('checked'))
	  {
		if($('.roomcheckall').prop('checked') == false)
		{
			var isSet = true;
			$('.roomcheck').each(function(){
				if($(this).prop('checked') == false)
				{
					isSet = false;
				}
			});

			if(isSet)
			{
				$('.roomcheckall').prop('checked', true);
			}
		}

		$('.roomEdtBtn').removeClass('hidden');

	    for(x in roomedts)
		{
	      if(x == 1)
	      {
	    	  var nowType = roomedts[x].children('span').text();
	    	  if(nowType == '')
	    	  {
	    		  sType = roomedts[x].children('select').attr('defval');
	    		  if(sType != undefined)
	    		  {
	    			continue;
	    		  }
	    	  }

	    	  var types = $('span#typexml').text();
	    	  var tobj = JSON.parse(types);

	    	  var ttext = '<select defval="' + nowType + '">'

	    	  var tx;
	    	  for(tx in tobj)
	    	  {
	    		  if(tobj[tx] == nowType)
	    		  {
	    			  ttext += '<option selected="selected">' + tobj[tx] + '</option>';
	    		  }
	    		  else
	    		  {
		    		  ttext += '<option>' + tobj[tx] + '</option>';  
	    		  }
	    	  }
	    	  ttext += '</select>';

	    	  roomedts[x].html(ttext); 
	      }

	      if(x == 2)
	      {
	    	  var nowAddr = roomedts[x].children('span').text();
	    	  if(nowAddr == '')
	    	  {
	    		sAddr = roomedts[x].children('select').attr('defval');
	    		if(sAddr != undefined)
	    		{
	    			continue;
	    		}
	    	  }

	    	  var addrs = $('span#addrxml').text();
	    	  var aobj = JSON.parse(addrs);

	    	  var atext = '<select defval="' + nowAddr + '">'

	    	  var ax;
	    	  for(ax in aobj)
	    	  {
	    		  if(aobj[ax] == nowAddr)
	    		  {
	    			  atext += '<option selected="selected">' + aobj[ax] + '</option>';
	    		  }
	    		  else
	    		  {
		    		  atext += '<option>' + aobj[ax] + '</option>';  
	    		  }
	    	  }
	    	  atext += '</select>';

	    	  roomedts[x].html(atext); 
	      }

	      if(x == 3)
	      {
	    	  var nowStatus = roomedts[x].children('span').text();
	    	  if(nowStatus == '')
	    	  {
	    		  sStatus = roomedts[x].children('select').attr('defval');
	    		  if(sStatus != undefined)
	    		  {
	    			continue;
	    		  }
	    	  }

	    	  if(nowStatus.match('1'))
	    	  {
	    		roomedts[x].html('<select defval="' + nowStatus + '">'
	    							+ '<option selected="selected">正使用(1)</option>'
			  			  			+ '<option >未使用(0)</option>'
			  			  			+ '</select>');  
	    	  }
	    	  else
	    	  {
	    		roomedts[x].html('<select defval="' + nowStatus + '">'
	    							+ '<option>正使用(1)</option>'
			  			  			+ '<option selected="selected">未使用(0)</option>'
			  			  			+ '</select>');  
	    	  }
	    	  continue;
	      }

	      if(x == 4 || x == 5)
	      {
	    	  var nowUser = roomedts[x].children('span').text();
	    	  if(nowUser == '')
	    	  {
	    		sUser = roomedts[x].children('select').attr('defval');
	    		if(sUser != undefined)
	    		{
	    			continue;
	    		}
	    	  }

	    	  var users = $('span#userxml').text();
	    	  var uobj = JSON.parse(users);

	    	  var utext = '<select defval="' + nowUser + '">'

	    	  var ux;
	    	  for(ux in uobj)
	    	  {
	    		  if(uobj[ux] == nowUser)
	    		  {
	    			  utext += '<option selected="selected">' + uobj[ux] + '</option>';
	    		  }
	    		  else
	    		  {
		    		  utext += '<option>' + uobj[ux] + '</option>';  
	    		  }
	    	  }
	    	  utext += '</select>';

	    	  roomedts[x].html(utext); 
	      }

          if(roomedts[x].children('span').width() > 0)
          {
            roomedts[x].html('<input type="text" value="' + roomedts[x].children('span').text() + '" style="width:' + roomedts[x].children('span').width() + 'pt;"></input>');
          }
		}
	  }
	  else
	  {
	    if($('.roomcheckall').prop('checked'))
		{
		  $('.roomcheckall').prop('checked', false);
		}

	    var isDisappear = true;
	    $('.roomcheck').each(function(){
	    	if($(this).prop('checked'))
	    	{
	    		isDisappear = false;
	    	}
	    });

	    if(isDisappear)
	    {
	    	$('.roomEdtBtn').addClass('hidden');
	    }

		for(x in roomedts)
		{
          if(roomedts[x].children('input').val() != undefined)
          {
            roomedts[x].html('<span>' + roomedts[x].children('input').val() + '</span>');
          }
          else if(roomedts[x].children('select').attr('defval') != undefined)
          {
            roomedts[x].html('<span>' + roomedts[x].children('select').attr('defval') + '</span>');
          }
		}
	  }
  });
})

function roomEditAlert(token) {
	var data = new Array();
	
	$('.roomcol').each(function(){
		var checked = $(this).children('td.roomedtcheck').children('input.roomcheck').prop('checked');
		if(checked == true && $(this).children('td.roomname').children('input').val() != undefined)
		{
			addRoomToData(data, getRoomData(this));
		}
	});
	
	roomEdtPost(JSON.stringify(data), token);
}

function roomDelAlert(token) {
	var data = new Array();
	
	$('.roomcol').each(function(){
		var checked = $(this).children('td.roomedtcheck').children('input.roomcheck').prop('checked');
		if(checked == true && $(this).children('td.roomname').children('input').val() != undefined)
		{
			addRoomToData(data, getRoomId(this));
		}
	});
	
	roomDelPost(JSON.stringify(data), token);
}

function getRoomId(tr)
{
	var tobj = new Object();
	tobj.id = $(tr).children('td.roomid').text();
	tobj.sn = $(tr).children('td.roomsn').text(); 
	
	return tobj;
}

function getRoomData(tr)
{
	var tobj = new Object();
	tobj.id = $(tr).children('td.roomid').text();
	tobj.sn = $(tr).children('td.roomsn').text(); 
	tobj.name = $(tr).children('td.roomname').children('input').val();
	tobj.roomtypestr = $(tr).children('td.roomtype').children('select').val();
	tobj.roomaddrstr = $(tr).children('td.roomaddr').children('select').val();
	tobj.statustr = $(tr).children('td.roomstatus').children('select').val();
	tobj.user = $(tr).children('td.roomuser').children('select').val();
	tobj.owner = $(tr).children('td.roomadmin').children('select').val();
	
	return tobj;
}

function addRoomToData(target, data)
{
	target.push(data);
}

function roomEdtPost(data, token) {

  if(confirm("确定修改教室信息?")) {
    var postForm = document.createElement("form");
    postForm.method="post";
    postForm.action = "admin/roomedt";

    var dataInput = document.createElement("input");
    dataInput.setAttribute("name", "data");
    dataInput.setAttribute("value", data);
    postForm.appendChild(dataInput);

    var tokenInput = document.createElement("input");
    tokenInput.setAttribute("name", "_token");
    tokenInput.setAttribute("value", token);
    postForm.appendChild(tokenInput);

    document.body.appendChild(postForm);
    postForm.submit();
    document.body.removeChild(postForm);
  }
}

function roomDelPost(data, token) {

  if(confirm("确定删除选中教室?")) {
    var postForm = document.createElement("form");
    postForm.method="post";
    postForm.action = "admin/roomdel";

    var dataInput = document.createElement("input");
    dataInput.setAttribute("name", "data");
    dataInput.setAttribute("value", data);
    postForm.appendChild(dataInput);

    var tokenInput = document.createElement("input");
    tokenInput.setAttribute("name", "_token");
    tokenInput.setAttribute("value", token);
    postForm.appendChild(tokenInput);

    document.body.appendChild(postForm);
    postForm.submit();
    document.body.removeChild(postForm);
  }
}

function loadUserGrade(id) {
  $(".nav-li"+id).addClass("active");
  $(".targ").addClass("hidden");
  $(".targlist"+id).removeClass("hidden");
}

function loadDeviceTab(pos) {
  if(pos == 1) {	//device
    $(".nav-li-gw").removeClass("active");
    $(".table-gw").addClass("hidden");
    $(".nav-li-dev").addClass("active");
    $(".table-dev").removeClass("hidden");
  }
  else {	//gateway
    $(".nav-li-dev").removeClass("active");
    $(".table-dev").addClass("hidden");
    $(".nav-li-gw").addClass("active");
    $(".table-gw").removeClass("hidden");
  }
}

function loadDeviceContent(pos) {
  var xmlhttp;
  var bodyid;

  if(pos == 1) {
    bodyid = "devtbody";
  }
  else {
    bodyid = "gwtbody";
  }

  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById(bodyid).innerHTML=xmlhttp.responseText;
    }
  }

  xmlhttp.open("GET", "/admin?action=devstats/async&tabpos="+pos, true);
  xmlhttp.send();
}

function userDelAlert(id, userid, tabpos, token) {
  if(id == userid) {
	  alert("该用户为当前登录用户，无法删除");
	  return;
  }

  if(confirm("确定要删除该用户?")) {
    var postForm = document.createElement("form");
    postForm.method="post";
    postForm.action = "admin/userdel";

    var tokenInput = document.createElement("input");
    tokenInput.setAttribute("name", "_token");
    tokenInput.setAttribute("value", token);
    postForm.appendChild(tokenInput);

    var idInput = document.createElement("input");
    idInput.setAttribute("name", "id");
    idInput.setAttribute("value", id);
    postForm.appendChild(idInput);

    var tabposInput = document.createElement("input");
    tabposInput.setAttribute("name", "tabpos");
    tabposInput.setAttribute("value", tabpos);
    postForm.appendChild(tabposInput);

    document.body.appendChild(postForm);
    postForm.submit();
    document.body.removeChild(postForm);
  }
}

function userEditAlert(id, token) {
	var postForm = document.createElement("form");
	postForm.method="post";
	postForm.action = "admin/useredit";

	var tokenInput = document.createElement("input");
	tokenInput.setAttribute("name", "_token");
	tokenInput.setAttribute("value", token);
	postForm.appendChild(tokenInput);

	var idInput = document.createElement("input");
	idInput.setAttribute("name", "id");
	idInput.setAttribute("value", id);
	postForm.appendChild(idInput);

	var nameInput = document.createElement("input");
	nameInput.setAttribute("name", "name");
	nameInput.setAttribute("value", $("#username"+id).val());
	postForm.appendChild(nameInput);

	var gradeInput = document.createElement("input");
	gradeInput.setAttribute("name", "grade");
	gradeInput.setAttribute("value", $("#usergrade"+id).find("option:selected").text());
	postForm.appendChild(gradeInput);

	var privilegeInput = document.createElement("input");
	privilegeInput.setAttribute("name", "privilege");
	privilegeInput.setAttribute("value", $("#userprivilege"+id).find("option:selected").text());
	postForm.appendChild(privilegeInput);

	var areaInput = document.createElement("input");
	areaInput.setAttribute("name", "area");
	areaInput.setAttribute("value", $("#userarea"+id).find("option:selected").text());
	postForm.appendChild(areaInput);

	document.body.appendChild(postForm);
	postForm.submit();
	document.body.removeChild(postForm);
}

function gatewayDelAlert(id, gwsn, tabpos, token)
{
  if(confirm("确定要删除网关?\n\n序列号="+gwsn)) {
    var postForm = document.createElement("form");
    postForm.method="post";
    postForm.action = "admin/gwdel";

    var tokenInput = document.createElement("input");
    tokenInput.setAttribute("name", "_token");
    tokenInput.setAttribute("value", token);
    postForm.appendChild(tokenInput);

    var idInput = document.createElement("input");
    idInput.setAttribute("name", "id");
    idInput.setAttribute("value", id);
    postForm.appendChild(idInput);

    var tabposInput = document.createElement("input");
    tabposInput.setAttribute("name", "tabpos");
    tabposInput.setAttribute("value", tabpos);

    postForm.appendChild(tabposInput);
    document.body.appendChild(postForm);
    postForm.submit();
    document.body.removeChild(postForm);
  }
}

function gatewayEditAlert(id, token) {
	var postForm = document.createElement("form");
	postForm.method="post";
	postForm.action = "admin/gwedit";

	var tokenInput = document.createElement("input");
	tokenInput.setAttribute("name", "_token");
	tokenInput.setAttribute("value", token);
	postForm.appendChild(tokenInput);

	var idInput = document.createElement("input");
	idInput.setAttribute("name", "id");
	idInput.setAttribute("value", id);
	postForm.appendChild(idInput);

	var nameInput = document.createElement("input");
	nameInput.setAttribute("name", "name");
	nameInput.setAttribute("value", $("#gwname"+id).val());
	postForm.appendChild(nameInput);

	var areaInput = document.createElement("input");
	areaInput.setAttribute("name", "area");
	areaInput.setAttribute("value", $("#gwarea"+id).val());
	postForm.appendChild(areaInput);

	var ispublicInput = document.createElement("input");
	ispublicInput.setAttribute("name", "ispublic");
	ispublicInput.setAttribute("value", $("#gwispublic"+id).val());
	postForm.appendChild(ispublicInput);

	var ownerInput = document.createElement("input");
	ownerInput.setAttribute("name", "owner");
	ownerInput.setAttribute("value", $("#gwowner"+id).val());
	postForm.appendChild(ownerInput);

	document.body.appendChild(postForm);
	postForm.submit();
	document.body.removeChild(postForm);
}

function deviceOptDialog(title, gwsn, devsn, devtype, iscmdfound)
{
	document.getElementById("devOptHeader").innerHTML = "<h3>操作:" + title + "</h3>";
	document.getElementById("devOptHeader").setAttribute("gwsn", gwsn);
	document.getElementById("devOptHeader").setAttribute("devsn", devsn);
	document.getElementById("optAddDev").setAttribute("devtype", devtype);

	$(".devOptArgs").addClass("hidden");

	if(iscmdfound == 0)
	{
		$(".devOptArgFF").removeClass("hidden");
	}
	else
	{
        $(".devOptArg"+devtype).removeClass("hidden");
	}
}

function deviceOptAddDialog()
{
	document.getElementById("devOptAddHeader").innerHTML = "<h3>添加操作</h3>";
	var devtype = document.getElementById("optAddDev").getAttribute("devtype");
	document.getElementById("devAddAction").setAttribute("value", $("#actionDefault" + devtype).val());
	document.getElementById("devAddData").setAttribute("value", $("#dataDefault" + devtype).val());
}

function deviceDelAlert(id, devsn, tabpos, token)
{
  if(confirm("确定要删除设备?\n\n序列号="+devsn)) {
    var postForm = document.createElement("form");
    postForm.method="post";
    postForm.action = "admin/devdel";

    var tokenInput = document.createElement("input");
    tokenInput.setAttribute("name", "_token");
    tokenInput.setAttribute("value", token);
    postForm.appendChild(tokenInput);

    var idInput = document.createElement("input");
    idInput.setAttribute("name", "id");
    idInput.setAttribute("value", id);
    postForm.appendChild(idInput);

    var tabposInput = document.createElement("input");
    tabposInput.setAttribute("name", "tabpos");
    tabposInput.setAttribute("value", tabpos);

    postForm.appendChild(tabposInput);
    document.body.appendChild(postForm);
    postForm.submit();
    document.body.removeChild(postForm);
  }
}

function deviceEditAlert(id, token) {
	var postForm = document.createElement("form");
	postForm.method="post";
	postForm.action = "admin/devedit";

	var tokenInput = document.createElement("input");
	tokenInput.setAttribute("name", "_token");
	tokenInput.setAttribute("value", token);
	postForm.appendChild(tokenInput);

	var idInput = document.createElement("input");
	idInput.setAttribute("name", "id");
	idInput.setAttribute("value", id);
	postForm.appendChild(idInput);

	var nameInput = document.createElement("input");
	nameInput.setAttribute("name", "name");
	nameInput.setAttribute("value", $("#devname"+id).val());
	postForm.appendChild(nameInput);

	var areaInput = document.createElement("input");
	areaInput.setAttribute("name", "area");
	areaInput.setAttribute("value", $("#devarea"+id).val());
	postForm.appendChild(areaInput);

	var ispublicInput = document.createElement("input");
	ispublicInput.setAttribute("name", "ispublic");
	ispublicInput.setAttribute("value", $("#devispublic"+id).val());
	postForm.appendChild(ispublicInput);

	var ownerInput = document.createElement("input");
	ownerInput.setAttribute("name", "owner");
	ownerInput.setAttribute("value", $("#devowner"+id).val());
	postForm.appendChild(ownerInput);

	document.body.appendChild(postForm);
	postForm.submit();
	document.body.removeChild(postForm);
}

function deviceOptSend(typeindex, index, devtype, token) {
	var gwsn = document.getElementById("devOptHeader").getAttribute("gwsn");
	var devsn = document.getElementById("devOptHeader").getAttribute("devsn");
	//var action;
	var data;

	if(typeindex <= 1) {
		//action = $("#actionDefault"+devtype).val();
		data = $("#dataDefault"+devtype).val();
	}
	else {
		//action = $("#devOptAction"+index).val();
		data = $("#devOptData"+index).text();
	}

	var key = '[{"action":"6", "gw_sn":"'
		+ gwsn + '", "ctrls":[{"dev_sn":"'
		+ devsn + '", "cmd":"'
		+ data + '"}], "random":"'
		+ String(Math.random()).substring(4, 8) + '"}]';

	var url = 'http://' + window.location.host + ':8033';
	io.connect(url).emit('DevOpt', key);

	/*var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function()
	{
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	      alert(xmlhttp.responseText);
	    }
	}

	xmlhttp.open("POST", "/devicedata?_token="+token+"&key="+key+"&datatype=6", true);
	xmlhttp.send(null);*/
}

function deviceOptDel(id, token) {
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function()
	{
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    	document.getElementById("devopt").innerHTML=xmlhttp.responseText;
	    }
	}

	xmlhttp.open("POST", "/admin/devoptdel?_token="+token+"&id="+id, true);
	xmlhttp.send(null);
}

function deviceOptAdd(token) {
	var devtype = document.getElementById("optAddDev").getAttribute("devtype");
	var action = $("#devAddAction").val();
	var data = $("#devAddData").val();

	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function()
	{
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    	document.getElementById("devopt").innerHTML=xmlhttp.responseText;
	    }
	}

	xmlhttp.open("POST", "/admin/devoptadd?_token="+token+"&devtype="+devtype+"&action="+action+"&data="+data, true);
	xmlhttp.send(null);
}