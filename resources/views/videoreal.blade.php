@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 id="vtitle" class="box-title">{{ $video_rand }}</h3>
      </div>
      <div class="box-body">
        <div class="embed-responsive embed-responsive-4by3">
          <video id="vplay" class="embed-responsive-item" allowfullscreen controls autoplay>
  		    <source src="{{ '/video/'.$video_rand }}" type="video/mp4">
	      </video>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border"><h3 class="box-title">视频列表</h3></div>
      <div class="box-body">
        <ul class="products-list product-list-in-box">
        @foreach($video_files as $index => $video_file)
          <li class="item">
            <div class="product-img">
              <a href="javascript:refreshVideo('{{ $video_file }}')"><img src="/bower_components/AdminLTE/dist/img/default-50x50.gif" alt="Product Image"></a>
            </div>
            <div class="product-info">
              <br><a href="javascript:refreshVideo('{{ $video_file }}')" class="product-description">{{ $video_file }}</a>
            </div>
          </li>
        @endforeach
        @while(++$index < $pagetag->getRow())
          <li class="item" style="height: 71px;"></li>
        @endwhile
        </ul>
      </div>
      <div class="box-footer">
      @if($pagetag->isavaliable())
        <ul class="pagination pagination-sm no-margin pull-right">
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
    </div>
  </div>  
</div>
@endsection

@section('conscript')
<script>
function refreshVideo(name) {
	$('#vtitle').text(name);
	$('#vplay source').attr('src','/video/'+name);
	$('#vplay').load();
}
</script>
@endsection

@extends('admin.dashboard')
