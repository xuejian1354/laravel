@section('content')
<!-- Info boxes -->
      <div class="row">
      @foreach($areaboxes as $areabox)
        @if($areabox->column == 4)
        <div class="col-md-3 col-sm-6 col-xs-12">
        @elseif($areabox->column == 3)
        <div class="col-md-4 col-sm-6 col-xs-12">
        @elseif($areabox->column == 2)
        <div class="col-md-6 col-sm-6 col-xs-12">
        @elseif($areabox->column == 1)
        <div class="col-md-12 col-sm-12 col-xs-12">
        @else
        <div class="col-md-4 col-sm-6 col-xs-12">
        @endif
          <div class="info-box">
            <span class="info-box-icon {{ $areabox->color_class }}"><i class="fa {{ $areabox->icon_class }}"></i></span>

            <div class="info-box-content">
              <span class="info-box-number">{{ $areabox->title }}</span>
              <p class="info-box-text">
              @foreach($areabox->contents as $areaboxcontent)
                {{ $areaboxcontent->key }}{{ $areaboxcontent->key && $areaboxcontent->val?'：':''}}{{ $areaboxcontent->val }}<br>
              @endforeach
              </p>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      @endforeach
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <span class="box-title">控制设备</span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>序列号</th>
                    <th>名称</th>
                    <th>状态</th>
                    <th>操作</th>
                    <th>时间</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($devices as $index => $device)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    <td><a href="#">{{ $device->sn }}</a></td>
                    <td><i class="{{ $device->rel_type->img }}"><span>&nbsp;&nbsp;{{ $device->name }}</span></td>
                    <td>{!! $device->data==null?'<span class="label label-danger">离线</span>':'<span class="label label-success">'.$device->data.'</span>' !!}</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-info"><b>开</b></button>
                        <button type="button" class="btn btn-xs btn-default"><b>关</b></button>
                      </div>
                    </td>
                    @if(strcmp(date('Y', time()), date('Y', strtotime($device->updated_at))) != 0)
                    <td>{{ date('Y年', strtotime($device->updated_at)) }}</td>
                    @elseif(strcmp(date('m-d', time()-(1*24*60*60)), date('m-d', strtotime($device->updated_at))) == 0)
                    <td>昨天</td>
                    @elseif(strcmp(date('m-d', time()), date('m-d', strtotime($device->updated_at))) != 0)
                    <td>{{ date('n月j日', strtotime($device->updated_at)) }}</td>
                    @else
                    <td>{{ date('H:i:s', strtotime($device->updated_at)) }}</td>
                    @endif
                  </tr>
                  @endforeach
                  @while(++$index < $pagetag->getRow())
                  <tr><td height="37"></td></tr>
                  @endwhile
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- box-footer -->
            <div class="box-footer clearfix">
              @if($pagetag->isavaliable())
              <ul class="pagination pagination-sm no-margin">
                @if($pagetag->start == 1)
                <li class="hidden disabled">
                @else
                <li>
                @endif
                  <a href="{{ '/'.$request->path().'?page='.($pagetag->start-1) }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                </li>
                @for($index=$pagetag->start; $index < $pagetag->end; $index++)
                  @if($pagetag->getPage() == $index)
                  <li class="active">
                  @else
                  <li>
                  @endif
                    <a href="{{ '/'.$request->path().'?page='.$index }}">{{ $index }}</a>
                  </li>
                @endfor
                @if($pagetag->end == $pagetag->getPageSize() + 1)
                <li class="hidden disabled">
                @else
                <li>
                @endif
                  <a href="{{ '/'.$request->path().'?page='.$pagetag->end }}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                </li>
              </ul>
              @endif
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">视频</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="pad">
                <div class="embed-responsive embed-responsive-4by3">
                    <video class="embed-responsive-item" allowfullscreen controls loop>
  				      <source src="{{ '/video/'.$video_file }}" type="video/mp4">
				    </video>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">统计信息</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                  <p class="text-center">
                    <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">TOTAL REVENUE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                    <h5 class="description-header">$10,390.90</h5>
                    <span class="description-text">TOTAL COST</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                    <h5 class="description-header">$24,813.53</h5>
                    <span class="description-text">TOTAL PROFIT</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                    <h5 class="description-header">1200</h5>
                    <span class="description-text">GOAL COMPLETIONS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
            
            <div class="box box-success">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">操作记录</h3>

              <div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Status">
                <div class="btn-group" data-toggle="btn-toggle">
                  <button type="button" class="btn btn-default btn-sm active"><i class="fa fa-square text-green"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-square text-red"></i></button>
                </div>
              </div>
            </div>
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;"><div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto; height: 250px;">
              <!-- chat item -->
              <div class="item">
                <img src="/bower_components/AdminLTE/dist/img/user4-128x128.jpg" alt="user image" class="online">

                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 2:15</small>
                    Mike Doe
                  </a>
                  I would like to meet you to discuss the latest news about
                  the arrival of the new theme. They say it is going to be one the
                  best themes on the market
                </p>
                <div class="attachment">
                  <h4>Attachments:</h4>

                  <p class="filename">
                    Theme-thumbnail-image.jpg
                  </p>

                  <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-sm btn-flat">Open</button>
                  </div>
                </div>
                <!-- /.attachment -->
              </div>
              <!-- /.item -->
              <!-- chat item -->
              <div class="item">
                <img src="/bower_components/AdminLTE/dist/img/user3-128x128.jpg" alt="user image" class="offline">

                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:15</small>
                    Alexander Pierce
                  </a>
                  I would like to meet you to discuss the latest news about
                  the arrival of the new theme. They say it is going to be one the
                  best themes on the market
                </p>
              </div>
              <!-- /.item -->
              <!-- chat item -->
              <div class="item">
                <img src="/bower_components/AdminLTE/dist/img/user2-160x160.jpg" alt="user image" class="offline">

                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> 5:30</small>
                    Susan Doe
                  </a>
                  I would like to meet you to discuss the latest news about
                  the arrival of the new theme. They say it is going to be one the
                  best themes on the market
                </p>
              </div>
              <!-- /.item -->
            </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 184.911px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
            <!-- /.chat -->
            <div class="box-footer">
              <div class="input-group">
                <input class="form-control" placeholder="Type message...">

                <div class="input-group-btn">
                  <button type="button" class="btn btn-success"><i class="fa fa-plus"></i></button>
                </div>
              </div>
            </div>
          </div>
            
          </div>
          <!-- /.box -->
          
          <div class="col-md-4">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">位置</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                  <div class="pad">
                    <!-- Map will be created here -->
                    <div id="world-map-markers" style="height: 325px;"></div>
                  </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          
          
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">使用情况</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <!-- /.footer -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        
        </div>
@endsection

@section('conscript')
<!-- Sparkline -->
<script src="/bower_components/AdminLTE/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="/bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="/bower_components/AdminLTE/plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/bower_components/AdminLTE/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/bower_components/AdminLTE/dist/js/demo.js"></script>
@endsection

@extends('admin.dashboard')

