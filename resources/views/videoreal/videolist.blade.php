<div id="videolist">
  <div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">视频列表</h3></div>
    <div class="box-body">
      <ul class="products-list product-list-in-box">
      @foreach($video_files as $index => $video_file)
        <li class="item">
          <div class="product-img">
            <a href="javascript:refreshVideo('{{ $video_file['type'] }}', '{{ $video_file['type'] == 'm3u8' ? $video_file['url'] : $video_file['name'] }}')"><img src="/bower_components/AdminLTE/dist/img/default-50x50.gif" alt="Product Image"></a>
          </div>
          <div class="product-info">
            <br><a href="javascript:refreshVideo('{{ $video_file['type'] }}', '{{ $video_file['type'] == 'm3u8' ? $video_file['url'] : $video_file['name'] }}')" class="product-description">{{ $video_file['name'] }}</a>
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