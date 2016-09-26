@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="ion ion-ios-volume-high"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">消息量</span>
        <span class="info-box-number">{{ $pagetag->getAllcols() }}</span>
        <div class="progress">
          <div class="progress-bar" style="width: {{ $alarminforate }}"></div>
        </div>
        <span class="progress-description">更新率 {{ $alarminforate }}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    <!-- Alarminfo LIST -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">报警信息</h3>
        <div class="box-tools pull-right">
          <div class="has-feedback">
            <input type="text" class="form-control input-sm" placeholder="Search Alarminfo">
              <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
            <tbody>
            @foreach($alarminfos as $index => $alarminfo)
            <tr>
              <td><input type="checkbox"></td>
              @if($alarminfo->action == 'up')
              <td class="mailbox-star"><span class="bg-green"><i class="ion-ios-upload-outline" style="margin: 2px;"></i></span></td>
              @elseif($alarminfo->action == 'down')
              <td class="mailbox-star"><span class="bg-light-blue"><i class="ion-ios-download-outline" style="margin: 2px;"></i></span></td>
              @elseif($alarminfo->action == 'cmp')
              <td class="mailbox-star"><span class="bg-orange"><i class="ion-navicon" style="margin: 2px;"></i></span></td>
              @else
              <td class="mailbox-star"><span class="bg-red"><i class="ion-ios-close-outline" style="margin: 2px;"></i></span></td>
              @endif
              <td class="mailbox-name"><span><a>{{ $alarminfo->rel_devname->name }}</a></span></td>
              <td class="mailbox-subject">{{ $alarminfo->content }}</td>
              <td class="mailbox-date">{{ \App\Http\Controllers\ComputeController::getTimeFlag($alarminfo->updated_at) }}</td>
            </tr>
            @endforeach
            @if(count($alarminfos) > 0)
            @while(++$index < $pagetag->getRow())
            <tr><td height="39"></td></tr>
            @endwhile
            @endif
            </tbody>
          </table>
          <!-- /.table -->
        </div>
        <!-- /.mail-box-messages -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer no-padding">
        <div class="mailbox-controls">
        <!-- Check all button -->
          <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
          </div>
          <div class="pull-right">
            <span>{{ $pagetag->col_start.'-'.$pagetag->col_end.'/'.$pagetag->getAllcols() }}</span>
            <div class="btn-group">
              <a type="button" class="btn btn-default btn-sm" href="{{ $pagetag->getPage()<=1?'#':'/'.$request->path().'?page='.($pagetag->getPage()-1) }}"><i class="fa fa-chevron-left"></i></a>
              <a type="button" class="btn btn-default btn-sm" href="{{ $pagetag->getPage()>=$pagetag->getPageSize()?'#':'/'.$request->path().'?page='.($pagetag->getPage()+1) }}"><i class="fa fa-chevron-right"></i></a>
            </div>
            <!-- /.btn-group -->
          </div>
          <!-- /.pull-right -->
        </div>
      </div>
    </div>
    <!-- /.box -->
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
        <!-- the events -->
        <div id="external-events">
          <div class="external-event bg-green">20号记得设置灌溉</div>
          <div class="external-event bg-yellow">不要频繁的操作阀门开头</div>
          <div class="external-event bg-aqua">温度超出阈值，但可忽略</div>
          <div class="external-event bg-light-blue">注意大棚1温湿度的变化</div>
          <div class="external-event bg-red">大棚1开启灌溉后要记得关闭</div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /. box -->
  </div>
  <!-- /.col -->
</div>
@endsection

@section('conscript')
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
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      //ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });
  });
</script>
@endsection

@extends('admin.dashboard')