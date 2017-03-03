@section('content')
<section class="content">
  <div class="callout callout-info">
    <h4>功能提示！</h4>
    <p>此处用于查看、设置、删除用户，并对用户活动状态是否有效进行激活</p>
  </div>
  @include(config('cullivebefore.mainrouter').'.curinfo.userlist')
</section>
@endsection

@section('conscript')
<script>
function updateUserListPost(hid, pg) {
  $.post('/{{ $request->path() }}',
    { _token:'{{ csrf_token() }}', way:hid, page:pg },
	function(data, status) {
	  if(status != 'success') {
		alert("Status: " + status);
	  }
	  else {
		$('#'+hid).html(data);
	  }
    }
  );
}

function licheckAll() {
  var clicks = $(".checkbox-toggle").data('clicks');
  if (clicks) {
    $(".fa", ".checkbox-toggle").removeClass("fa-check-square-o").addClass('fa-square-o');
    $('.licheck').prop('checked', false);
  } else {
    $(".fa", ".checkbox-toggle").removeClass("fa-square-o").addClass('fa-check-square-o');
    $('.licheck').prop('checked', true);
  }
  $(".checkbox-toggle").data("clicks", !clicks);
}

function delChoiceUser() {
  var usersns = new Array();
  $('.licheck').each(function() {
    if($(this).prop('checked')) {
      var usersn = $(this).parent().parent().find('.usersn').text();
      usersns.push(usersn);
    }
  });

  if(usersns.length == 0) {
    alert('未选择要删除的用户');
    return;
  }

  if(!confirm('确定删除所选的用户？')) {
	  return;
  }

  var arrStr = JSON.stringify(usersns);

  $.post('/{{ $request->path() }}',
    { _token:'{{ csrf_token() }}', way:'userdel', usersns:arrStr },
	function(data, status) {
      if(status != 'success') {
        alert("Status: " + status);
      }
      else {
    	  $('#userlist').html(data);
      }
    });
}

function activeForUser(sn) {
  $.post('/{{ $request->path() }}', 
    { _token:'{{ csrf_token() }}', way:'useractive', usersn:sn },
    function(data, status) {
      if(status != 'success') {
    	alert("Status: " + status);
      }
      else {
        if(data == 1) {
          $('#tdact'+sn).html('可用');
        }
        else {
           alert('未找到该用户');
        }
      }
    }
  );
}

function SetUserGrade(sn) {
  var grade = $('#usergrade'+sn+' option:selected').val();
  $.post('/{{ $request->path() }}', 
    { _token:'{{ csrf_token() }}', way:'usergrade', usersn:sn, usergrade:grade },
    function(data, status) {
      if(status != 'success') {
    	alert("Status: " + status);
      }
      else {
        if(data == 1) {
        }
        else {
           alert('未找到该用户');
        }
      }
    }
  );
}
</script>
@endsection

@extends(config('cullivebefore.mainrouter').'.admin.dashboard')