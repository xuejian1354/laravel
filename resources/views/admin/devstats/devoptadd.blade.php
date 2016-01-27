<div class="modal fade" role="dialog" id="devOptAddModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
        <h3 id="devOptAddHeader"></h3>
      </div>
      <div id="devOptAddBody" class="modal-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>动作</th>
              <th>数据</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input id="devAddAction" type="text"></td>
              <td><input id="devAddData" type="text"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button onclick="javascript:deviceOptAdd('{{ csrf_token() }}');" type="button" class="btn btn-primary" data-dismiss="modal">保存</button>
        <button type="button" class="btn" data-dismiss="modal">取消</button>
      </div>
    </div>
  </div>
</div>