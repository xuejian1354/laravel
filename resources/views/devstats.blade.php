@section('content')
	  <div class="row">
	  
	    <!-- Left col -->
        <div class="col-md-8">
          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">设备</h3>
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
                    <td>{{ $device->name }}</td>
                    <td><span class="label label-success">在线</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
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
          
          <div class="box box-default">
            <div class="box-header with-border">
              <i class="fa fa-warning"></i>

              <h3 class="box-title">Alerts</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info"></i> Alert!</h4>
                Info alert preview. This alert is dismissable.
              </div>
              <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                Warning alert preview. This alert is dismissable.
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          
          
        </div>
        <!-- /.col -->
	  
        <div class="col-md-4">
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <img class="img-circle" src="/bower_components/AdminLTE/dist/img/user1-128x128.jpg" alt="User Image">
                <span class="username"><a href="#">Jonathan Burke Jr.</a></span>
                <span class="description">Shared publicly - 7:30 PM Today</span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Mark as read">
                  <i class="fa fa-circle-o"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block;">
              <img class="img-responsive pad" src="/bower_components/AdminLTE/dist/img/photo2.png" alt="Photo">

              <p>I took this photo this morning. What do you guys think?</p>
              <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
              <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
              <span class="pull-right text-muted">127 likes - 3 comments</span>
            </div>
            <!-- /.box-body -->
            <div class="box-footer box-comments" style="display: block;">
              <div class="box-comment">
                <!-- User image -->
                <img class="img-circle img-sm" src="/bower_components/AdminLTE/dist/img/user3-128x128.jpg" alt="User Image">

                <div class="comment-text">
                      <span class="username">
                        Maria Gonzales
                        <span class="text-muted pull-right">8:03 PM Today</span>
                      </span><!-- /.username -->
                  It is a long established fact that a reader will be distracted
                  by the readable content of a page when looking at its layout.
                </div>
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
              <div class="box-comment">
                <!-- User image -->
                <img class="img-circle img-sm" src="/bower_components/AdminLTE/dist/img/user4-128x128.jpg" alt="User Image">

                <div class="comment-text">
                      <span class="username">
                        Luna Stark
                        <span class="text-muted pull-right">8:03 PM Today</span>
                      </span><!-- /.username -->
                  It is a long established fact that a reader will be distracted
                  by the readable content of a page when looking at its layout.
                </div>
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
            </div>
            <!-- /.box-footer -->
            <div class="box-footer" style="display: block;">
              <form action="#" method="post">
                <img class="img-responsive img-circle img-sm" src="/bower_components/AdminLTE/dist/img/user4-128x128.jpg" alt="Alt Text">
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                  <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                </div>
              </form>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        
      </div>
@endsection

@section('conscript')
@endsection

@extends('admin.dashboard')
