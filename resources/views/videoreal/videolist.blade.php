<div id="videolist">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">视频列表</h3>
      <div class="box-tools pull-right">
        <a id='vaddopt' href="/videoreal/camadd" type="button" class="btn btn-box-tool hidden"><i class="fa fa-plus"></i></a>
        <button id='vsetopt' type="button" class="btn btn-box-tool" onclick="javascript:videolistSetting();"><i class="fa fa-cog"></i></button>
      </div>
    </div>
    <div class="box-body">
      <ul class="products-list product-list-in-box">
      @foreach($video_files as $index => $video_file)
        <li id="vitem{{ $video_file['id'] }}" class="item">
          <div class="product-img">
            <a href="javascript:refreshVideo('{{ $video_file['type'] }}', '{{ $video_file['id'] }}', '{{ $video_file['url'] }}')"><img src="/bower_components/AdminLTE/dist/img/default-50x50.gif" alt="Product Image"></a>
          </div>
          <div class="product-info video{{ $video_file['type'] }}">
            <br><a id="{{ $video_file['id'] }}" href="javascript:refreshVideo('{{ $video_file['type'] }}', '{{ $video_file['id'] }}', '{{ $video_file['url'] }}')" class="product-description">{{ $video_file['name'] }}</a>
          </div>
        </li>
      @endforeach
      @if(isset($index))
      @while(++$index < $pagetag->getRow())
        <li class="item" style="height: 71px;"></li>
      @endwhile
      @endif
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
          <a href="javascript:updateDevListPost('videolist', '{{ $pagetag->start-1 }}')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>
      @for($index=$pagetag->start; $index < $pagetag->end; $index++)
        @if($pagetag->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="javascript:updateDevListPost('videolist', '{{ $index }}')">{{ $index }}</a>
        </li>
      @endfor
      @if($pagetag->end == $pagetag->getPageSize() + 1)
        <li class="hidden disabled">
      @else
        <li>
      @endif
          <a href="javascript:updateDevListPost('videolist', '{{ $pagetag->end }}')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
        </li>
      </ul>
    @endif
    </div>
  </div>
</div>