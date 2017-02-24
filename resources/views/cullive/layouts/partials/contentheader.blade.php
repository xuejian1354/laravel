<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    {{ $dashconfig['header'][$curreq]['menu'] }}
    <small>{{ $dashconfig['header'][$curreq]['desp'] }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>dashboard</a></li>
    <li class="active">{{ $dashconfig['header'][$curreq]['action'] }}</li>
  </ol>
</section>