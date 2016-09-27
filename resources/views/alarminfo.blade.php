@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="ion ion-ios-volume-high"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">消息量</span>
        <span class="info-box-number">{{ $pagetag->getAllcols() }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: {{ $alarminforate }}%"></div>
        </div>
        <span class="progress-description">更新率 {{ $alarminforate }} %</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    @include('alarminfo.alarmlist')
  </div>
  <div class="col-md-4">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">留言板</h3>
      </div>
      <div class="box-body">
        <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
          <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
          <ul class="fc-color-picker" id="color-chooser">
            <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
            <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
          </ul>
        </div>
        <!-- /btn-group -->
        <div class="input-group">
          <input id="new-event" type="text" class="form-control" placeholder="Alarminfo">
          <div class="input-group-btn">
            <button id="add-new-event" type="button" class="btn btn-primary btn-flat">添加</button>
          </div>
          <!-- /btn-group -->
        </div>
        <!-- /input-group -->
      </div>
    </div>
    <div class="box box-solid">
      <div class="box-header with-border">
        <h4 class="box-title">留言信息</h4>
        <!-- i class="pull-right ion ion-trash-a"></i -->
      </div>
      <div class="box-body">
        @include('alarminfo.msglist')
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /. box -->
  </div>
  <!-- /.col -->
</div>
@endsection

@section('conscript')
<script>
function updateDevListPost(hid, pg) {
  $.post('/'+'{{ $request->path() }}',
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
</script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {
        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }

    //ini_events($('#external-events div.external-event'));

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });

    $("#add-new-event").click(function (e) {
    	$.post('/'+'{{ $request->path() }}',
    	  { _token:'{{ csrf_token() }}', 
      	    way:'msgadd', color:currColor, 
      	    content:$("#new-event").val() },
    	  function(data, status) {
    		if(status != 'success') {
    		  alert("Status: " + status);
    		}
    		else {
    		  $('#msglist').html(data);
    		}
    	  }
    	);
      /*e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event); */

      //Add draggable funtionality
      //ini_events(event);

      //Remove event from text input
      //$("#new-event").val("");
    });
  });
</script>
@endsection

@extends('admin.dashboard')