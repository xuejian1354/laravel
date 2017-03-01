@section('usermanage')
<div class="container-fluid spark-screen">
  <div class="row">
    <section class="content">
      <div class="callout callout-info">
        <h4>功能提示！</h4>
        <p>此处用于查看、设置、删除用户，并对用户活动状态是否有效进行激活</p>
      </div>
      @include('cullive.modellist.userlist')
    </section>
  </div>
</div>
@show