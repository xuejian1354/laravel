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
  if(pos == 1) {
    $(".nav-li-gw").removeClass("active");
    $(".table-gw").addClass("hidden");
    $(".nav-li-dev").addClass("active");
    $(".table-dev").removeClass("hidden");
  }
  else {
    $(".nav-li-dev").removeClass("active");
    $(".table-dev").addClass("hidden");
    $(".nav-li-gw").addClass("active");
    $(".table-gw").removeClass("hidden");
  }
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
