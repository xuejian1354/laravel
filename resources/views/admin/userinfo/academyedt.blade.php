<div style="padding: 20px;">
  <form method="POST" action="{{ url('/admin/academyedt') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $academy->id }}">
    <label style="margin-top: 10px; margin-right: 10px;">学院</label>
    <input name="val" type="text" class="form-control" value="{{ $academy->val }}">
    <label style="margin-top: 10px; margin-right: 10px;">院长</label>
    <select name="academyteacher" class="form-control">
    @foreach($users as $user)
      @if($academy->academyteacher == $user->name)
        <option selected="selected">{{ $user->name }}</option>
      @else
        <option>{{ $user->name }}</option>
      @endif
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
    <span id="otherteacherspan">{{ $academy->otherteachers }}</span>
    <br>
    <input id="otherteachersinput" name="otherteachers" type="text" class="form-control hidden" value="{{ $academy->otherteachers }}">
    <label style="margin-top: 10px;">说明</label>
    <textarea name="text" rows="12" class="form-control">{{ $academy->text }}</textarea>
    <div style="margin-top: 10px;">
      <button type="submit" class="btn btn-primary">修改</button>
      <a href="admin?action=userinfo&tabpos=1" class="btn btn-info">返回</a>
    </div>
  </form>
</div>
