@section('content')
	  <div class="row">
	  
	    <!-- Left col -->
        <div class="col-md-8">
          <!-- TABLE: Real Video -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $video_file }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="embed-responsive embed-responsive-4by3">
                <video class="embed-responsive-item" allowfullscreen controls autoplay>
  				  <source src="{{ '/video/'.$video_file }}" type="video/mp4">
				</video>
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
	  
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Bordered Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Task</th>
                  <th>Progress</th>
                  <th style="width: 40px">Label</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Update</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-red">55%</span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Clean</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-yellow">70%</span></td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>Cron</td>
                  <td>
                    <div class="progress progress-xs progress-striped active">
                      <div class="progress-bar progress-bar-primary" style="width: 60%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-light-blue">60%</span></td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>Fix</td>
                  <td>
                    <div class="progress progress-xs progress-striped active">
                      <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-green">90%</span></td>
                </tr>
                <tr>
                  <td>5.</td>
                  <td>Hello</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-red">55%</span></td>
                </tr>
                <tr>
                  <td>6.</td>
                  <td>Class</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-yellow">70%</span></td>
                </tr>
                <tr>
                  <td>7.</td>
                  <td>goto</td>
                  <td>
                    <div class="progress progress-xs progress-striped active">
                      <div class="progress-bar progress-bar-primary" style="width: 60%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-light-blue">60%</span></td>
                </tr>
                <tr>
                  <td>8.</td>
                  <td>World</td>
                  <td>
                    <div class="progress progress-xs progress-striped active">
                      <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-green">90%</span></td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
              </ul>
            </div>
          </div>
          <!-- /.box -->
        </div>
        
      </div>
@endsection

@section('conscript')
@endsection

@extends('admin.dashboard')
