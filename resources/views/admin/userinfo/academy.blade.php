<div id="academybody">
<div class="table-responsive">
  <table class="table table-striped" style="min-width: 600px;">
    <thead>
      <tr>
        <th>id</th>
        <th>学院</th>
        <th>院长</th>
        <th>教师</th>
        <th>说明</th>
        <th>创建时间</th>
        <th><a href="javascript:loadContent('academybody', 'admin?action=userinfo/addacademy');">添加</a></th>
        <th><input type="checkbox" class="academiescheckall"></th>
      </tr>
    </thead>
    <tbody id="academiestbody">
    @for($index=0; $index < count($academies); $index++)
      <tr>
        <td>{{ $academies[$index]->academy }}</td>
        <td>{{ $academies[$index]->val }}</td>
        <td>{{ $academies[$index]->academyteacher }}</td>
        <td>{{ $academies[$index]->otherteacher }}</td>
        <td>{{ $academies[$index]->text }}</td>
        <td>{{ $academies[$index]->updated_at }}</td>
        <td><a href="javascript:loadContent('academybody', 'admin?action=userinfo/academyedt&id={{ $academies[$index]->id }}');">修改</a></td>
        <th><input type="checkbox" class="academycheck" eleid="{{ $academies[$index]->id }}"></th>
      </tr>
    @endfor
    </tbody>
  </table>
  <div class="academiesedt hidden" style="float: right;">
    <a href="javascript:academiesDelAlert('{{ csrf_token() }}');" class="btn btn-danger" role="button">删除</a>
  </div>
</div>
</div>
