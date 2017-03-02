<!DOCTYPE html>
<html dir="ltr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0">
	<title>{{ trans('message.description') }}</title>
		<!-- Start css3menu.com HEAD section -->
	<link rel="stylesheet" href="/menubar/1_files/css3menu1/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
	<!-- End css3menu.com HEAD section -->

	
</head>
<body ontouchstart="" style="background-color:#EBEBEB">
<!-- Start css3menu.com BODY section -->
<input type="checkbox" id="css3menu-switcher" class="c3m-switch-input">
<ul id="css3menu1" class="topmenu">
	<li class="switch"><label onclick="" for="css3menu-switcher"></label></li>
	<li class="topfirst"><a href="/" style="height:19px;line-height:19px;">{{ trans('message.appname').' | '.trans('message.landplanting') }}</a></li>
	<li class="topmenu"><a href="#" style="height:19px;line-height:19px;"><span><img src="/menubar/1_files/css3menu1/find.png" alt=""/>北斗服务系统</span></a>
	<ul>
		<li class="subfirst"><a href="#"><span>收割设备</span></a>
		<ul>
			<li class="subfirst"><a href="/landplanting/mbpos/{{ config('menubar.mbpos')[0] }}/pos">设备定位</a></li>
			<li><a href="/landplanting/mbpos/{{ config('menubar.mbpos')[0] }}/ctrl">设备控制</a></li>
		</ul></li>
		<li><a href="#"><span>耕种设备</span></a>
		<ul>
			<li class="subfirst"><a href="/landplanting/mbpos/{{ config('menubar.mbpos')[1] }}/pos">设备定位</a></li>
			<li><a href="/landplanting/mbpos/{{ config('menubar.mbpos')[1] }}/ctrl">设备控制</a></li>
		</ul></li>
	</ul></li>
	<li class="topmenu"><a href="#" style="height:19px;line-height:19px;"><span><img src="/menubar/1_files/css3menu1/info.png" alt=""/>农业生产过程管理系统</span></a>
	<ul>
		<li class="subfirst"><a href="/landplanting/mbargprg/{{ config('menubar.mbargprg')[0] }}">精准收获</a></li>
		<li><a href="/landplanting/mbargprg/{{ config('menubar.mbargprg')[1] }}">农情调度监测</a></li>
		<li><a href="/landplanting/mbargprg/{{ config('menubar.mbargprg')[2] }}">水肥一体化</a></li>
		<li><a href="/landplanting/mbargprg/{{ config('menubar.mbargprg')[3] }}">精量播种</a></li>
		<li><a href="/landplanting/mbargprg/{{ config('menubar.mbargprg')[4] }}">养分管理</a></li>
		<li><a href="/landplanting/mbargprg/{{ config('menubar.mbargprg')[5] }}">病虫害防控</a></li>
	</ul></li>
	<li class="toplast"><a href="#" style="height:19px;line-height:19px;"><span><img src="/menubar/1_files/css3menu1/favour.png" alt=""/>精细管理及公共服务系统</span></a>
	<ul>
		<li class="subfirst"><a href="/landplanting/mbser/{{ config('menubar.mbser')[0] }}">农业生产管理系统</a></li>
		<li><a href="/landplanting/mbser/{{ config('menubar.mbser')[1] }}">农机协同作业系统</a></li>
		<li><a href="/landplanting/mbser/{{ config('menubar.mbser')[2] }}">农情监测与决策</a></li>
	</ul></li>
</ul><p class="_css3m"><a href="http://css3menu.com/">dhtml menu</a> by Css3Menu.com</p>
<!-- End css3menu.com BODY section -->

</body>
</html>
