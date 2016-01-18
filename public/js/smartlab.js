$(document).ready(function() {
  $(".nav-tabs .nav-li").click(function() {
    $(".nav-tabs .active").removeClass("active");
    $(this).addClass("active");
  });
})

function loadUserInfo(id) {
  $(".nav-li"+id).addClass("active");
  $(".targ").addClass("hidden");
  $(".targlist"+id).removeClass("hidden");
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

