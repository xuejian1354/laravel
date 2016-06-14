<div>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="nav-li nav-li1"><a href="javascript:loadUser(1);">公告</a></li>
    <li role="presentation" class="nav-li nav-li2"><a href="javascript:loadUser(2);">院系</a></li>
    <li role="presentation" class="nav-li nav-li3"><a href="javascript:loadUser(3);">班级</a></li>
    <li role="presentation" class="nav-li nav-li4"><a href="javascript:loadUser(4);">报告</a></li>
  </ul>
  <div id="userdiv1" class="divcontent hidden">
    @include('admin.userinfo.notice')
  </div>
  <div id="userdiv2" class="divcontent hidden">
    @include('admin.userinfo.academy')
  </div>
  <div id="userdiv3" class="divcontent hidden">
    @include('admin.userinfo.classgrade')
  </div>
  <div id="userdiv4" class="divcontent hidden">
    @include('admin.userinfo.report')
  </div>
</div>
<script type="text/javascript">
  loadUser({{ $grades[isset($_GET['tabpos'])&&$_GET['tabpos']<4?$_GET['tabpos']:'0']->grade }});
</script>
