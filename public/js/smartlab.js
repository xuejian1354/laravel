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
	    	  if(setSelectXml(roomedts[x], $('span#typexml').text()) < 0)
	    	  {
	    		  continue;
	    	  }
	      }

	      if(x == 2)
	      {
	    	  if(setSelectXml(roomedts[x], $('span#addrxml').text()) < 0)
	    	  {
	    		  continue;
	    	  }
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

	      if(x == 4)
	      {
	    	  if(setSelectXml(roomedts[x], $('span#userxml').text()) < 0)
	    	  {
	    		  continue;
	    	  }
	      }

	      if(x == 5)
	      {
	    	  if(setSelectXml(roomedts[x], $('span#ownerxml').text()) < 0)
	    	  {
	    		  continue;
	    	  }
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
  
  $(".coursecheckall").click(function() {
	  var tr = $('#coursetbody').children('tr');
	  var courseCheck = tr.children('td.courseedtcheck').children('input.coursecheck');

	  if($(this).prop('checked'))
	  {
		  courseCheck.prop('checked', true);
	  }
	  else
	  {
		  courseCheck.prop('checked', false);
	  }

	  courseCheck.trigger("courseEdtEvent");
  });

  $(".coursecheck").click(function() {
	  $(this).trigger("courseEdtEvent");
  });

  $(".coursecheck").bind("courseEdtEvent", function() {
	  var coursetab = $(this).parent().parent();

	  var coursesn = coursetab.children('td.coursesn');
	  var course = coursetab.children('td.course');
	  var courseroom = coursetab.children('td.courseroom');
	  var coursetime = coursetab.children('td.coursetime');
	  var coursecycle = coursetab.children('td.coursecycle');
	  var courseterm = coursetab.children('td.courseterm');
	  var courseteacher = coursetab.children('td.courseteacher');

	  var x;
	  var courseedts = new Array(course, courseroom, coursetime, coursecycle, courseterm, courseteacher);

	  if($(this).prop('checked'))
	  {
		if($('.coursecheckall').prop('checked') == false)
		{
			var isAllSet = true;
			$('.coursecheck').each(function(){
				if($(this).prop('checked') == false)
				{
					isAllSet = false;
				}
			});

			if(isAllSet)
			{
				$('.coursecheckall').prop('checked', true);
			}
		}

		$('.courseedt').removeClass('hidden');

	    for(x in courseedts)
		{
	      if(x == 1)
	      {
	    	if(setSelectXml(courseedts[x], $('span#roomxml').text()) < 0)
		    {
	    		continue;
		    }
	      }
	    	
	      if(x == 3)
	      {
	    	  if(setSelectXml(courseedts[x], $('span#cyclexml').text()) < 0)
	    	  {
	    		  continue;
	    	  }
	      }

	      if(x == 4)
	      {
	    	  if(setSelectXml(courseedts[x], $('span#termxml').text()) < 0)
	    	  {
	    		  continue;
	    	  }
	      }
	      
	      if(x == 5)
	      {
	    	  if(setSelectXml(courseedts[x], $('span#teacherxml').text()) < 0)
	    	  {
	    		  continue;
	    	  }
	      }

          if(courseedts[x].children('span').width() > 0)
          {
            courseedts[x].html('<input type="text" value="' + courseedts[x].children('span').text() + '" style="width:' + courseedts[x].children('span').width() + 'pt;"></input>');
          }
		}
	  }
	  else
	  {
	    if($('.coursecheckall').prop('checked'))
		{
		  $('.coursecheckall').prop('checked', false);
		}

	    var isDisappear = true;
	    $('.coursecheck').each(function(){
	    	if($(this).prop('checked'))
	    	{
	    		isDisappear = false;
	    	}
	    });

	    if(isDisappear)
	    {
	    	$('.courseedt').addClass('hidden');
	    }

		for(x in courseedts)
		{
          if(courseedts[x].children('input').val() != undefined)
          {
            courseedts[x].html('<span>' + courseedts[x].children('input').val() + '</span>');
          }
          else if(courseedts[x].children('select').attr('defval') != undefined)
          {
            courseedts[x].html('<span>' + courseedts[x].children('select').attr('defval') + '</span>');
          }
		}
	  }
  });
})

function setSelectXml(target, jstr)
{
  var nowT = target.children('span').text();
  if(nowT == '')
  {
	  if(target.children('select').attr('defval') != undefined)
	  {
		return -1;
	  }
  }

  var jobj = JSON.parse(jstr);

  var jtext = '<select defval="' + nowT + '">'

  var jx;
  for(jx in jobj)
  {
	  if(jobj[jx] == nowT)
	  {
		  jtext += '<option selected="selected">' + jobj[jx] + '</option>';
	  }
	  else
	  {
		  jtext += '<option>' + jobj[jx] + '</option>';
	  }
  }
  jtext += '</select>';

  target.html(jtext);
  return 0;
}

function courseAddAlert(token) {
	var type = 1;
	if($('#caddtype').val() == '动态')
	{
		type = 2;
	}

	var tobj = new Object(); 
	tobj.course = $('#caddcourse').val();
	tobj.room = $('#caddroom').val();
	tobj.time = $('#caddtime').val();
	tobj.cycle = $('#caddcycle').val();
	tobj.term = $('#caddterm').val();
	tobj.teacher = $('#caddteacher').val();
	
	if($.trim(tobj.course).length > 0)
	{
		 if(confirm('确定要添加 "' + tobj.course + '"?')) {
		    var postForm = document.createElement("form");
		    postForm.method="post";
		    postForm.action = '/admin/courseadd';
	
		    var dataInput = document.createElement("input");
		    dataInput.setAttribute("name", "data");
		    dataInput.setAttribute("value", JSON.stringify(tobj));
		    postForm.appendChild(dataInput);

		    var typeInput = document.createElement("input");
		    typeInput.setAttribute("name", "type");
		    typeInput.setAttribute("value", type);
		    postForm.appendChild(typeInput);
	
		    var tokenInput = document.createElement("input");
		    tokenInput.setAttribute("name", "_token");
		    tokenInput.setAttribute("value", token);
		    postForm.appendChild(tokenInput);
	
		    document.body.appendChild(postForm);
		    postForm.submit();
		    document.body.removeChild(postForm);
		 }
	}
	else
	{
		alert('课程名称不能为空');
	}
}

function courseEdtAlert(token) {
	var data = new Array();
	
	$('.coursecol').each(function(){
		var checked = $(this).children('td.courseedtcheck').children('input.coursecheck').prop('checked');
		if(checked == true && $(this).children('td.course').children('input').val() != undefined)
		{
			data.push(getCourseData(this));
		}
	});
	
	dataPost('/admin/courseedt', JSON.stringify(data), token, '确定要修改课程信息?');
}

function courseDelAlert(token) {
	var data = new Array();
	
	$('.coursecol').each(function(){
		var checked = $(this).children('td.courseedtcheck').children('input.coursecheck').prop('checked');
		if(checked == true && $(this).children('td.course').children('input').val() != undefined)
		{
			data.push(getCourseId(this));
		}
	});
	
	dataPost('/admin/coursedel', JSON.stringify(data), token, '确定要删除选中课程?');
}

function roomAddAlert(token) {

	var tobj = new Object(); 
	tobj.name = $('#raddname').val();
	tobj.roomtype = $('#raddtype').val();
	tobj.addr = $('#raddaddr').val();
	tobj.status = $('#raddstatus').val();
	tobj.user = $('#radduser').val();
	tobj.owner = $('#raddowner').val();
	
	if($.trim(tobj.name).length > 0)
	{
		dataPost('/admin/roomadd', JSON.stringify(tobj), token, '确定要添加 "'+tobj.name+'"?');
	}
	else
	{
		alert('教室名称不能为空');
	}
}

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

function getCourseId(tr)
{
	var tobj = new Object();
	tobj.id = $(tr).children('td.courseid').text();
	tobj.sn = $(tr).children('td.coursesn').text();
	
	return tobj;
}

function getCourseData(tr)
{
	var tobj = new Object();
	tobj.id = $(tr).children('td.courseid').text();
	tobj.sn = $(tr).children('td.coursesn').text(); 
	tobj.course = $(tr).children('td.course').children('input').val();
	tobj.room = $(tr).children('td.courseroom').children('select').val();
	tobj.time = $(tr).children('td.coursetime').children('input').val();
	tobj.cycle = $(tr).children('td.coursecycle').children('select').val();
	tobj.term = $(tr).children('td.courseterm').children('select').val();
	tobj.teacher = $(tr).children('td.courseteacher').children('select').val();
	
	return tobj;
}

function dataPost(target, data, token, alert) {

  if(confirm(alert)) {
    var postForm = document.createElement("form");
    postForm.method="post";
    postForm.action = target;

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

function loadUser(id) {
  loadUserGrade(id);

  $(".divcontent").removeClass("active");
  $(".divcontent").addClass("hidden");
  $("#userdiv"+id).removeClass("hidden");
  $("#userdiv"+id).addClass("active");
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

function deviceRemoveAreaAlert(id, devsn, roomsn, token)
{
  if(confirm("确定要要将该设备从列表中移除?\n\n序列号="+devsn)) {
    var postForm = document.createElement("form");
    postForm.method="post";
    postForm.action = "admin/devmvarea";

    var tokenInput = document.createElement("input");
    tokenInput.setAttribute("name", "_token");
    tokenInput.setAttribute("value", token);
    postForm.appendChild(tokenInput);

    var idInput = document.createElement("input");
    idInput.setAttribute("name", "id");
    idInput.setAttribute("value", id);
    postForm.appendChild(idInput);

    var tabposInput = document.createElement("input");
    tabposInput.setAttribute("name", "roomsn");
    tabposInput.setAttribute("value", roomsn);

    postForm.appendChild(tabposInput);
    document.body.appendChild(postForm);
    postForm.submit();
    document.body.removeChild(postForm);
  }
}

function deviceEditAlert(id, token, roomsn = null) {
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

	if(roomsn != null)
	{
		var roomsnInput = document.createElement("input");
		roomsnInput.setAttribute("name", "roomsn");
		roomsnInput.setAttribute("value", roomsn);
		postForm.appendChild(roomsnInput);
	}

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