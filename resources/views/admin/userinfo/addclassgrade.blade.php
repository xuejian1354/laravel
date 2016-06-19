<div style="padding: 20px;">
  <form method="POST" action="{{ url('/admin/addclassgrade') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <label style="margin-top: 10px; margin-right: 10px;">班级</label>
    <input name="val" type="text" class="form-control">
    <label style="margin-top: 10px; margin-right: 10px;">学院</label>
    <select name="academy" class="form-control">
    @foreach($academies as $academy)
      <option>{{ $academy->val }}</option>
    @endforeach
    </select>
    <label style="margin-top: 10px; margin-right: 10px;">班主任</label>
    <select name="classteacher" class="form-control">
    @foreach($users as $user)
      @if($user->grade <= 2)
        <option>{{ $user->name }}</option>
      @endif
    @endforeach
    </select>
    <label style="margin-top: 10px; margin-right: 10px;">辅导员</label>
    <select name="assistant" class="form-control">
    @foreach($users as $user)
      @if($user->grade <= 3)
        <option>{{ $user->name }}</option>
      @endif
    @endforeach
    </select>
    <label style="margin-top: 10px; margin-right: 10px;">班长</label>
    <select name="leader" class="form-control">
    @foreach($users as $user)
      @if($user->grade == 3)
        <option>{{ $user->name }}</option>
      @endif
    @endforeach
    </select>
    <label style="margin-top: 10px;">说明</label>
    <textarea name="text" rows="12" class="form-control"></textarea>
    <div style="margin-top: 10px;">
      <button type="submit" class="btn btn-primary">添加</button>
      <a href="/admin?action=userinfo&tabpos=2" class="btn btn-info">返回</a>
    </div>
  </form>
</div>
