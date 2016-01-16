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
