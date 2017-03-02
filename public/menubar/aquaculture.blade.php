<!DOCTYPE html>
<html dir="ltr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0">
	<title>{{ trans('message.description') }}</title>
		<!-- Start css3menu.com HEAD section -->
	<link rel="stylesheet" href="/menubar/4_files/css3menu1/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
	<!-- End css3menu.com HEAD section -->

	
</head>
<body ontouchstart="" style="background-color:#EBEBEB">
<!-- Start css3menu.com BODY section -->
<input type="checkbox" id="css3menu-switcher" class="c3m-switch-input">
<ul id="css3menu1" class="topmenu">
	<li class="switch"><label onclick="" for="css3menu-switcher"></label></li>
	<li class="topfirst"><a href="/">{{ trans('message.appname').' | '.trans('message.aquaculture') }}</a></li>
	<li class="topmenu"><a href="#" style="height:15px;line-height:15px;"><span>在线监测系统</span></a>
	<ul>
		<li class="subfirst"><a href="/aquaculture/mbondetect/{{ config('menubar.mbondetect')[0] }}">自动检测控制</a></li>
		<li><a href="/aquaculture/mbondetect/{{ config('menubar.mbondetect')[1] }}">视频检测</a></li>
		<li><a href="/aquaculture/mbondetect/{{ config('menubar.mbondetect')[2] }}">气象站</a></li>
		<li><a href="/aquaculture/mbondetect/{{ config('menubar.mbondetect')[3] }}">水质检测</a></li>
	</ul></li>
	<li class="topmenu"><a href="#" style="height:15px;line-height:15px;"><span>生产过程管理系统</span></a>
	<ul>
		<li class="subfirst"><a href="/aquaculture/mbgressmanage/{{ config('menubar.mbgressmanage')[0] }}">水下机器人</a></li>
		<li><a href="/aquaculture/mbgressmanage/{{ config('menubar.mbgressmanage')[1] }}">水循环</a></li>
		<li><a href="/aquaculture/mbgressmanage/{{ config('menubar.mbgressmanage')[2] }}">地质改良</a></li>
		<li><a href="/aquaculture/mbgressmanage/{{ config('menubar.mbgressmanage')[3] }}">饲料投喂</a></li>
		<li><a href="/aquaculture/mbgressmanage/{{ config('menubar.mbgressmanage')[4] }}">自动增氧机</a></li>
		<li><a href="/aquaculture/mbgressmanage/{{ config('menubar.mbgressmanage')[5] }}">生产运营管理系统</a></li>
		<li><a href="/aquaculture/mbgressmanage/{{ config('menubar.mbgressmanage')[6] }}">便携式生产移动管理</a></li>
	</ul></li>
	<li class="topmenu"><a href="#" style="height:15px;line-height:15px;"><span>综合管理保障系统</span></a>
	<ul>
		<li class="subfirst"><a href="/aquaculture/mbcommanage/{{ config('menubar.mbcommanage')[0] }}">质量安全追溯系统</a></li>
		<li><a href="/aquaculture/mbcommanage/{{ config('menubar.mbcommanage')[1] }}">鱼病远程诊断系统</a></li>
		<li><a href="/aquaculture/mbcommanage/{{ config('menubar.mbcommanage')[2] }}">水产养殖环境遥感监测系统</a></li>
		<li><a href="/aquaculture/mbcommanage/{{ config('menubar.mbcommanage')[3] }}">病害检测</a></li>
		<li><a href="/aquaculture/mbcommanage/{{ config('menubar.mbcommanage')[4] }}">品质与药残检测</a></li>
		<li><a href="/aquaculture/mbcommanage/{{ config('menubar.mbcommanage')[5] }}">水质检测</a></li>
	</ul></li>
	<li class="toplast"><a href="#" style="height:15px;line-height:15px;"><span>公共服务系统</span></a>
	<ul>
		<li class="subfirst"><a href="/aquaculture/mbpubser/{{ config('menubar.mbpubser')[0] }}">养殖鱼情精准服务系统</a></li>
		<li><a href="/aquaculture/mbpubser/{{ config('menubar.mbpubser')[1] }}">疫情灾情预警系统</a></li>
		<li><a href="/aquaculture/mbpubser/{{ config('menubar.mbpubser')[2] }}">公共信息资源库</a></li>
	</ul></li>
</ul><p class="_css3m"><a href="http://css3menu.com/">dhtml menu</a> by Css3Menu.com</p>
<!-- End css3menu.com BODY section -->

</body>
</html>
