<div>
  <h3>1. 教室使用</h3>
  @include('admin.userclassgrade.classstatus')
  @if($user->privilege > 3)
  <h3 style="margin-top: 20px;">2. 智能操作</h3>
  @include('admin.userclassgrade.classopt')
  @endif
</div>
@include('admin.userclassgrade.classjs')