<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
  @include('cullive.layouts.partials.htmlheader')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-blue sidebar-mini">
<div id="app">
  <div class="wrapper">

  @include('cullive.layouts.partials.mainheader')

  @include('cullive.layouts.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div id="contentwrap" class="content-wrapper">
    @include('cullive.layouts.content')
  </div><!-- /.content-wrapper -->

  @include('cullive.layouts.partials.footer')

</div><!-- ./wrapper -->
</div>
@section('scripts')
  @include('cullive.layouts.partials.scripts')
@show
</body>
</html>
