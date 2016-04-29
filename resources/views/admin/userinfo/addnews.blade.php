<div style="padding: 20px;">
  <form method="POST" action="{{ url('/admin/addnews') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if(isset($returnurl))
      <input type="hidden" name="returnurl" value="{{ $returnurl }}">
    @endif
    <label>标题</label>
    <input name="title" type="text" class="form-control" placeholder="必填">
    <label style="margin-top: 10px;">副标题</label>
    <textarea name="subtitle" rows="2" class="form-control" placeholder="对内容的简短说明"></textarea>
    @if(!isset($hasowner) || $hasowner == false)
      <label style="margin-top: 10px; margin-right: 10px;">发布者</label>
      <select name="newsowner">
      @foreach($users as $user)
        @if($user->sn == Auth::user()->sn)
        <option selected="selected">{{ $user->name }}</option>
        @else
        <option>{{ $user->name }}</option>
        @endif
      @endforeach
      </select><br>
    @else
      <input type="hidden" name="optid" value="{{ $optuser->id }}">
      <input type="hidden" name="newsowner" value="{{ $optuser->name }}">
    @endif
    <label style="margin-top: 10px; margin-right: 10px;">允许访问</label>
    <select id="newsallowgrade" name="allowgrade" onchange="javascript:newsAllowChange();">
    @foreach($idgrades as $idgrade)
      <option>{{ $idgrade->val }}</option>
    @endforeach
    </select>
    <label class="nallow nallowacdemy hidden" style="margin-left: 30px; margin-right: 10px;">院系</label>
    <select id="newsallowacademy" class="nallow nallowacdemy hidden" onchange="javascript:newsAllowSelect(1);">
    @foreach($academies as $academy)
      <option>{{ $academy->val }}</option>
    @endforeach
    </select>
    <label class="nallow nallowclassgrade hidden" style="margin-left: 30px; margin-right: 10px;">班级</label>
    <select id="newsallowclassgrade" class="nallow nallowclassgrade hidden" onchange="javascript:newsAllowSelect(2);">
    @foreach($classgrades as $classgrade)
      <option>{{ $classgrade->val }}</option>
    @endforeach
    </select>
    <label class="nallow nallowuser hidden" style="margin-left: 30px; margin-right: 10px;">指定用户</label>
    <select id="newsallowuser" class="nallow nallowuser hidden" onchange="javascript:newsAllowSelect(3);">
    @foreach($users as $user)
      <option>{{ $user->name }}</option>
    @endforeach
    </select>
    <br>
    <span id="newsallowspan">全校</span>
    <input id="newsallowinput" name="visitor" type="text" class="form-control hidden" value="全校">
    <br>
    <label style="margin-top: 10px;">内容</label>
    <textarea name="text" rows="12" class="form-control"></textarea>
    <div style="margin-top: 10px;">
      <button type="submit" class="btn btn-primary">添加</button>
      @if(isset($returnurl))
      <a href="{{ $returnurl }}" class="btn btn-info">返回</a>
      @else
      <a href="admin?action=userinfo&tabpos=0" class="btn btn-info">返回</a>
      @endif
    </div>
  </form>
</div>
