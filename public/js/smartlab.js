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
})

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