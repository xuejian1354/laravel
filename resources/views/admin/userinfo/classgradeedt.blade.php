<div style="padding: 20px;">
  <form method="POST" action="{{ url('/admin/classgradeedt') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $classgrade->id }}">
    <label style="margin-top: 10px; margin-right: 10px;">班级</label>
    <input name="val" type="text" class="form-control" value="{{ $classgrade->val }}">
    <label style="margin-top: 10px; margin-right: 10px;">学院</label>
    <select name="academy" class="form-control">
    @foreach($academies as $academy)
      @if($academy->academy == $classgrade->academy)
        <option selected="selected">{{ $academy->val }}</option>
      @else
        <option>{{ $academy->val }}</option>
      @endif
    @endforeach
    </select>
    <label style="margin-top: 10px; margin-right: 10px;">班主任</label>
    <select name="classteacher" class="form-control">
    @foreach($users as $user)
      @if($user->grade <= 2)
        @if($classgrade->classteacher == $user->name)
          <option selected="selected">{{ $user->name }}</option>
        @else
          <option>{{ $user->name }}</option>
        @endif
      @endif
    @endforeach
    </select>
    <label style="margin-top: 10px; margin-right: 10px;">辅导员</label>
    <select name="assistant" class="form-control">
    @foreach($users as $user)
      @if($user->grade <= 3)
        @if($classgrade->assistant == $user->name)
          <option selected="selected">{{ $user->name }}</option>
        @else
          <option>{{ $user->name }}</option>
        @endif
      @endif
    @endforeach
    </select>
    <label style="margin-top: 10px; margin-right: 10px;">班长</label>
    <select name="leader" class="form-control">
    @foreach($users as $user)
      @if($user->grade == 3)
        @if($classgrade->leader == $user->name)
          <option selected="selected">{{ $user->name }}</option>
        @else
          <option>{{ $user->name }}</option>
        @endif
      @endif
    @endforeach
    </select>
    <label style="margin-top: 10px;">说明</label>
    <textarea name="text" rows="12" class="form-control">{{ $classgrade->text }}</textarea>
    <div style="margin-top: 10px;">
      <button type="submit" class="btn btn-primary">修改</button>
      <a href="/admin?action=userinfo&tabpos=2" class="btn btn-info">返回</a>
    </div>
  </form>
</div>
