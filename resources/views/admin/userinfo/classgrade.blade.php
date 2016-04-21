<div id="classgradebody">
<div class="table-responsive">
  <table class="table table-striped" style="min-width: 600px;">
    <thead>
      <tr>
        <th>id</th>
        <th>班级</th>
        <th>学院</th>
        <th>班主任</th>
        <th>辅导员</th>
        <th>班长</th>
        <th>说明</th>
        <th>创建时间</th>
        <th><a href="javascript:loadContent('classgradebody', 'admin?action=userinfo/addclassgradebody');">添加</a></th>
        <th><input type="checkbox" class="classgradecheckall"></th>
      </tr>
    </thead>
    <tbody id="classgradetbody">
    @for($index=0; $index < count($classgrades); $index++)
      <tr>
        <td>{{ $classgrades[$index]->classgrade }}</td>
        <td>{{ $classgrades[$index]->val }}</td>
        <td>{{ $classgrades[$index]->academystr }}</td>
        <td>{{ $classgrades[$index]->classteacher }}</td>
        <td>{{ $classgrades[$index]->assistant }}</td>
        <td>{{ $classgrades[$index]->leader }}</td>
        <td>{{ $classgrades[$index]->text }}</td>
        <td>{{ $classgrades[$index]->updated_at }}</td>
        <td><a href="javascript:loadContent('classgradebody', 'admin?action=userinfo/classgradeedt&id={{ $classgrades[$index]->id }}');">修改</a></td>
        <th><input type="checkbox" class="classgradecheck" eleid="{{ $classgrades[$index]->id }}"></th>
      </tr>
    @endfor
    </tbody>
  </table>
  <div class="classgradeedt hidden" style="float: right;">
    <a href="javascript:classgradeDelAlert('{{ csrf_token() }}');" class="btn btn-danger" role="button">删除</a>
  </div>
</div>
</div>
