<div id="videolist">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">视频列表</h3>
      <div class="box-tools pull-right">
        <a id='vaddopt' href="{{ config('cullivebefore.mainrouter') }}/videoreal/camadd" title="添加" type="button" class="btn btn-box-tool hidden"><i class="fa fa-plus"></i></a>
        @if(\App\Model\Globalval::getVal('matrix') == 'raspberrypi')
        @if($edtypes == 'mp4')
        <button id='vhistory' type="button" title="返回" class="btn btn-box-tool" onclick="javascript:videoRecordListSetting(1);"><i class="fa fa-long-arrow-left"></i></button>
        @else
        <button id='vhistory' type="button" title="记录" class="btn btn-box-tool" onclick="javascript:videoRecordListSetting(0);"><i class="fa fa-history"></i></button>
        @endif
        @endif
        <button id='vsetopt' type="button" title="设置" class="btn btn-box-tool" onclick="javascript:videolistSetting();"><i class="fa fa-cog"></i></button>
      </div>
    </div>
    <div class="box-body">
      <ul class="products-list product-list-in-box">
      @foreach($video_files as $index => $video_file)
        <li id="vitem{{ $video_file['id'] }}" class="item">
          <div class="product-img">
            <a id="proimg{{ $video_file['id'] }}" href="javascript:refreshVideo('{{ $video_file['type'] }}', '{{ $video_file['id'] }}', '{{ $video_file['url'] }}')"><img src="/adminlte/dist/img/default-50x50.gif" alt="Product Image"></a>
          </div>
          <div id="video{{ $video_file['id'] }}" class="product-info video{{ $video_file['type'] }}">
            <a id="{{ $video_file['id'] }}" href="javascript:refreshVideo('{{ $video_file['type'] }}', '{{ $video_file['id'] }}', '{{ $video_file['url'] }}')" class="product-description" style="margin: 15px 0;">{{ $video_file['name'] }}</a>
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
          <a href="javascript:updateVideoListPost('{{ config('cullivebefore.mainrouter').'/'.$request->path() }}', 'videolist', '{{ $edtypes }}', '{{ $pagetag->start-1 }}', '{{ csrf_token() }}')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>
      @for($index=$pagetag->start; $index < $pagetag->end; $index++)
        @if($pagetag->getPage() == $index)
        <li class="active">
        @else
        <li>
        @endif
          <a href="javascript:updateVideoListPost('{{ config('cullivebefore.mainrouter').'/'.$request->path() }}', 'videolist', '{{ $edtypes }}', '{{ $index }}', '{{ csrf_token() }}')">{{ $index }}</a>
        </li>
      @endfor
      @if($pagetag->end == $pagetag->getPageSize() + 1)
        <li class="hidden disabled">
      @else
        <li>
      @endif
          <a href="javascript:updateVideoListPost('{{ config('cullivebefore.mainrouter').'/'.$request->path() }}', 'videolist', '{{ $edtypes }}', '{{ $pagetag->end }}', '{{ csrf_token() }}')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
        </li>
      </ul>
    @endif
    </div>
  </div>
</div>