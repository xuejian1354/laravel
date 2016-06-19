<div>
  @if($user->privilege > 3)
  @include('admin.userclassgrade.classopt')
  @endif
</div>
@include('admin.userclassgrade.classjs')