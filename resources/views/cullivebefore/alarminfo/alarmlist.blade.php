<div id="alarmlist">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">报警信息</h3>
      <!-- div class="box-tools pull-right">
        <div class="has-feedback">
          <input type="text" class="form-control input-sm" placeholder="Search Alarminfo">
            <span class="glyphicon glyphicon-search form-control-feedback"></span>
          </div>
        </div -->
      </div>
      <div class="box-body no-padding">
        <div class="table-responsive mailbox-messages">
          <table class="table table-hover table-striped">
          <tbody>
          @foreach($alarminfos as $index => $alarminfo)
          <tr>
            <td><input class="alarmcheck" type="checkbox" sn="{{ $alarminfo->sn }}"></td>
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
      </div>
    </div>
    <div class="box-footer no-padding">
      <div class="mailbox-controls">
        <button type="button" class="btn btn-default btn-sm checkbox-toggle" onclick="javascrpt:checkAllAlarminfos();"><i class="fa fa-square-o"></i></button>
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-sm" onclick="javascript:delDevsCheck();"><i class="fa fa-trash-o"></i></button>
          <button type="button" class="btn btn-default btn-sm" onclick="javascript:updateDevListPost('/{{ $request->path() }}', 'alarmlist', '{{ $pagetag->getPage() }}', '{{ csrf_token() }}');"><i class="fa fa-refresh"></i></button>
        </div>
        <div class="pull-right">
          <span>{{ $pagetag->col_start.'-'.$pagetag->col_end.'/'.$pagetag->getAllcols() }}</span>
          <div class="btn-group">
            <a type="button" class="btn btn-default btn-sm" href="{{ $pagetag->getPage()<=1?'#':'javascript:updateDevListPost(\'/'.($request->path()).'\', \'alarmlist\', \''.($pagetag->getPage()-1).'\', \''.(csrf_token()).'\')' }}"><i class="fa fa-chevron-left"></i></a>
            <a type="button" class="btn btn-default btn-sm" href="{{ $pagetag->getPage()>=$pagetag->getPageSize()?'#':'javascript:updateDevListPost(\'/'.($request->path()).'\', \'alarmlist\', \''.($pagetag->getPage()+1).'\', \''.(csrf_token()).'\')' }}"><i class="fa fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>