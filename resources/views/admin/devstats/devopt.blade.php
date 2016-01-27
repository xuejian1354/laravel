<div class="modal fade" role="dialog" id="devOptModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
        <h3 id="devOptHeader"></h3>
      </div>
      <div id="devOptBody" class="modal-body table-responsive">
        <table class="table table-striped" style="min-width: 320px;">
          <thead>
            <tr>
              <th>#</th>
              <th>动作</th>
              <th>数据</th>
              <th><button id="optAddDev" onclick="javascript:deviceOptAddDialog();" type="button" class="btn btn-info btn-sm" role="button" data-dismiss="modal" data-target="#devOptAddModal" data-toggle="modal" style="float: right;">添加</button></th>
            </tr>
          </thead>
          <tbody id="devtbody">
            @for($index=0; $index < count($devcmds); $index++)
              <tr class="devOptArgs {{ 'devOptArg'.$devcmds[$index]->dev_type }} hidden"
                @if($devcmds[$index]->index % 2 == 0)
                  style="background-color: #ffffff;"
                @else
                  style="background-color: #f9f9f9;"
                @endif
              >
                @if($devcmds[$index]->index == 1)
                  <td>{{ $devcmds[$index]->index }}</td>
                  <td><input id="{{ 'actionDefault'.$devcmds[$index]->dev_type }}" type="text" value="{{ $devcmds[$index]->action }}" style="width: 60px;"></td>
                  <td><input id="{{ 'dataDefault'.$devcmds[$index]->dev_type }}" type="text" value="{{ $devcmds[$index]->data }}" style="width: 60px;"></td>
                @else
                  <td>{{ $devcmds[$index]->index }}</td>
                  <td id="{{ 'devOptAction'.$index }}">{{ $devcmds[$index]->action }}</td>
                  <td id="{{ 'devOptData'.$index }}">{{ $devcmds[$index]->data }}</td>
                @endif
                <td style="min-width: 111px;">
                  <button onclick="javascript:deviceOptDel('{{ $devcmds[$index]->id }}', '{{ csrf_token() }}');" type="button" class="btn btn-danger" role="button" data-dismiss="modal" style="float: right;">删除</button>
                  <button onclick="javascript:deviceOptSend('{{ $devcmds[$index]->index }}', '{{ $index }}', '{{ $devcmds[$index]->dev_type }}', '{{ csrf_token() }}');" type="button" class="btn btn-primary" role="button" data-dismiss="modal" style="float: right; margin-right: 5px;">发送</button>
                </td>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">取消</button>
      </div>
    </div>
  </div>
</div>