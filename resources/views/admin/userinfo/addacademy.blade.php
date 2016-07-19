<div style="padding: 20px;">
  <form method="POST" action="{{ url('/admin/addacademy') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <label style="margin-top: 10px; margin-right: 10px;">学院</label>
    <input name="val" type="text" class="form-control">
    <label style="margin-top: 10px; margin-right: 10px;">院长</label>
    <select name="academyteacher" class="form-control">
    @foreach($users as $user)
      <option>{{ $user->name }}</option>
    @endforeach
    </select>
    <label style="margin-top: 10px; margin-right: 10px;">教师</label>
    <select id="otherteacher" class="form-control" onchange="javascript:otherTeachersChange();">
    @foreach($users as $user)
      @if($user->grade == 2)
        <option>{{ $user->name }}</option>
      @endif
    @endforeach
      <option selected="selected">清除...</option>
    </select>
    <br>
    <span id="otherteacherspan"></span>
    <br>
    <input id="otherteachersinput" name="otherteachers" type="text" class="form-control hidden">
    <label style="margin-top: 10px;">说明</label>
    <textarea name="text" rows="12" class="form-control"></textarea>
    <div style="margin-top: 10px;">
      <button type="submit" class="btn btn-primary">添加</button>
      <a href="/admin?action=userinfo&tabpos=1" class="btn btn-info">返回</a>
    </div>
  </form>
</div>
