<div style="padding: 20px;">
  <form method="POST" action="{{ url('/admin/newsedts') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if(isset($returnurl))
    <input type="hidden" name="returnurl" value="{{ $returnurl }}">
    @endif
    @if(isset($adminflag) && $adminflag == 1)
    <input type="hidden" name="adminflag" value="1">
    @endif
    @for($index=0; $index < count($news); $index++)
      @if((!isset($hasowner) || $hasowner == false) && count($news) > 1)
      <h3
      @if($index > 0)
        style="margin-top: 30px;"
      @endif
      >{{ $index+1 }}</h3>
      @endif
      <label>标题</label>
      <input name="title{{ $news[$index]->id }}" type="text" class="form-control" value="{{ $news[$index]->title }}">
      <label style="margin-top: 10px;">副标题</label>
      <textarea name="subtitle{{ $news[$index]->id }}" rows="2" class="form-control">{{ $news[$index]->subtitle }}</textarea>
      
      @if(!isset($hasowner) || $hasowner == false)
      <label style="margin-top: 10px; margin-right: 10px;">发布者</label>
      <select name="newsowner{{ $news[$index]->id }}">
      @foreach($users as $user)
        @if($user->name == $news[$index]->owner)
        <option selected="selected">{{ $user->name }}</option>
        @else
        <option>{{ $user->name }}</option>
        @endif
      @endforeach
      </select><br>
      @else
        <input type="hidden" name="newsowner{{ $news[$index]->id }}" value="{{ $optuser->name }}">
        <input type="hidden" name="optid{{ $news[$index]->id }}" value="{{ $optuser->id }}">
      @endif
      
      <label style="margin-top: 10px; margin-right: 10px;">允许访问</label>
      <select id="newsallowgrade{{ $news[$index]->id }}" name="allowgrade{{ $news[$index]->id }}" onchange="javascript:newsAllowChange('{{ $news[$index]->id }}');">
      @foreach($idgrades as $idgrade)
        <option
        @if($news[$index]->allowgrade == $idgrade->idgrade)
          selected = "selected"
        @endif
        >{{ $idgrade->val }}</option>
      @endforeach
      </select>
      <label class="nallow{{ $news[$index]->id }} nallowacdemy{{ $news[$index]->id }}
      @if($news[$index]->allowgrade != 2)
        hidden
      @endif
      " style="margin-left: 30px; margin-right: 10px;">院系</label>
      <select id="newsallowacademy{{ $news[$index]->id }}" class="nallow{{ $news[$index]->id }} nallowacdemy{{ $news[$index]->id }}
      @if($news[$index]->allowgrade != 2)
        hidden
      @endif
      " onchange="javascript:newsAllowSelect(1, {{ $news[$index]->id }});">
      @foreach($academies as $academy)
        <option
        @if($news[$index]->visitor == $academy->academy)
          selected = "selected"
        @endif
        >{{ $academy->val }}</option>
      @endforeach
      </select>
      <label class="nallow{{ $news[$index]->id }} nallowclassgrade{{ $news[$index]->id }}
      @if($news[$index]->allowgrade != 3 && $news[$index]->allowgrade != 4)
        hidden
      @endif
      " style="margin-left: 30px; margin-right: 10px;">班级</label>
      <select id="newsallowclassgrade{{ $news[$index]->id }}" class="nallow{{ $news[$index]->id }} nallowclassgrade{{ $news[$index]->id }}
      @if($news[$index]->allowgrade != 3 && $news[$index]->allowgrade != 4)
        hidden
      @endif
      " onchange="javascript:newsAllowSelect(2, {{ $news[$index]->id }});">
      @foreach($classgrades as $classgrade)
        <option
        @if($news[$index]->visitor == $classgrade->classgrade)
          selected = "selected"
        @endif
        >{{ $classgrade->val }}</option>
      @endforeach
      </select>
      <label class="nallow{{ $news[$index]->id }} nallowuser{{ $news[$index]->id }}
      @if($news[$index]->allowgrade != 5)
        hidden
      @endif
      " style="margin-left: 30px; margin-right: 10px;">指定用户</label>
      <select id="newsallowuser{{ $news[$index]->id }}" class="nallow{{ $news[$index]->id }} nallowuser{{ $news[$index]->id }}
      @if($news[$index]->allowgrade != 5)
        hidden
      @endif
      " onchange="javascript:newsAllowSelect(3, {{ $news[$index]->id }});">
      @foreach($users as $user)
        <option
        @if($news[$index]->visitor == $user->name)
          selected = "selected"
        @endif
        >{{ $user->name }}</option>
      @endforeach
      </select>
      <br>
      <span id="newsallowspan{{ $news[$index]->id }}">
      @if(isset($news[$index]->visitortext))
        {{ $news[$index]->allowtext.','.$news[$index]->visitortext}}
      @else
        {{ $news[$index]->allowtext}}
      @endif
      </span>
      <input id="newsallowinput{{ $news[$index]->id }}" name="visitor{{ $news[$index]->id }}" type="text" class="form-control hidden"
      @if(isset($news[$index]->visitortext))
        value="{{ $news[$index]->visitortext}}"
      @else
        value="{{ $news[$index]->allowtext}}"
      @endif
      >
      <br>
      <label style="margin-top: 10px;">内容</label>
      <textarea name="text{{ $news[$index]->id }}" rows="12" class="form-control">{{ $news[$index]->text }}</textarea>
    @endfor
      <input id="newsids" name="newsids" type="text" class="form-control hidden" value="{{ $eleids }}">
      <div style="margin-top: 10px;">
        <button type="submit" class="btn btn-primary">修改</button>
        @if(isset($returnurl))
        <a href="javascript:loadContent('activitycontent', '{{ $returnurl }}&iscontent=1');" class="btn btn-info">返回</a>
        @else
        <a href="/admin?action=userinfo&tabpos=0" class="btn btn-info">返回</a>
        @endif
      </div>
  </form>
</div>