<!DOCTYPE html>
<html dir="ltr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0">
	<title>{{ trans('message.description') }}</title>
		<!-- Start css3menu.com HEAD section -->
	<link rel="stylesheet" href="/menubar/3_files/css3menu1/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
	<!-- End css3menu.com HEAD section -->

	
</head>
<body ontouchstart="" style="background-color:#EBEBEB">
<!-- Start css3menu.com BODY section -->
<input type="checkbox" id="css3menu-switcher" class="c3m-switch-input">
<ul id="css3menu1" class="topmenu">
	<li class="switch"><label onclick="" for="css3menu-switcher"></label></li>
	<li class="topfirst"><a href="/">{{ trans('message.appname').' | '.trans('message.farmbreeding') }}</a></li>
	<li class="topmenu"><a href="#" style="height:15px;line-height:15px;"><span>环境控制检测系统</span></a>
	<ul>
		<li class="subfirst"><a href="/farmbreeding/mbenvdetect/{{ config('menubar.mbenvdetect')[0] }}">圈舍自动化控制系统</a></li>
		<li><a href="/farmbreeding/mbenvdetect/{{ config('menubar.mbenvdetect')[1] }}">环境检测</a></li>
	</ul></li>
	<li class="topmenu"><a href="#" style="height:15px;line-height:15px;"><span>数字化精准饲喂管理系统</span></a>
	<ul>
		<li class="subfirst"><a href="/farmbreeding/mbfeedctrl/{{ config('menubar.mbfeedctrl')[0] }}">精准饲喂和分级管理</a></li>
		<li><a href="/farmbreeding/mbfeedctrl/{{ config('menubar.mbfeedctrl')[1] }}">发情检测</a></li>
		<li><a href="/farmbreeding/mbfeedctrl/{{ config('menubar.mbfeedctrl')[2] }}">自动饮水</a></li>
		<li><a href="/farmbreeding/mbfeedctrl/{{ config('menubar.mbfeedctrl')[3] }}">精准上料</a></li>
		<li><a href="/farmbreeding/mbfeedctrl/{{ config('menubar.mbfeedctrl')[4] }}">自动称重</a></li>
		<li><a href="/farmbreeding/mbfeedctrl/{{ config('menubar.mbfeedctrl')[5] }}">电子识别</a></li>
	</ul></li>
	<li class="topmenu"><a href="#" style="height:15px;line-height:15px;"><span>机械化自动产品收集系统</span></a>
	<ul>
		<li class="subfirst"><a href="/farmbreeding/mbprocollect/{{ config('menubar.mbprocollect')[0] }}">包装设备</a></li>
		<li><a href="/farmbreeding/mbprocollect/{{ config('menubar.mbprocollect')[1] }}">自动挤奶</a></li>
		<li><a href="/farmbreeding/mbprocollect/{{ config('menubar.mbprocollect')[2] }}">自动收集</a></li>
	</ul></li>
	<li class="topmenu"><a href="#" style="height:15px;line-height:15px;"><span>无害化粪污处理系统</span></a>
	<ul>
		<li class="subfirst"><a href="/farmbreeding/mbdunghandler/{{ config('menubar.mbdunghandler')[0] }}">传送带自动清粪</a></li>
		<li><a href="/farmbreeding/mbdunghandler/{{ config('menubar.mbdunghandler')[1] }}">刮粪板</a></li>
		<li><a href="/farmbreeding/mbdunghandler/{{ config('menubar.mbdunghandler')[2] }}">改造漏缝地板</a></li>
		<li><a href="/farmbreeding/mbdunghandler/{{ config('menubar.mbdunghandler')[3] }}">节水养殖</a></li>
	</ul></li>
	<li class="toplast"><a href="#" style="height:15px;line-height:15px;"><span>清洗收集系统</span></a>
	<ul>
		<li class="subfirst"><a href="/farmbreeding/mbclean/{{ config('menubar.mbclean')[0] }}">粪污无害化处理</a></li>
		<li><a href="/farmbreeding/mbclean/{{ config('menubar.mbclean')[1] }}">粪肥田间储存池</a></li>
		<li><a href="/farmbreeding/mbclean/{{ config('menubar.mbclean')[2] }}">好养处理池</a></li>
		<li><a href="/farmbreeding/mbclean/{{ config('menubar.mbclean')[3] }}">沼气收集池</a></li>
		<li><a href="/farmbreeding/mbclean/{{ config('menubar.mbclean')[4] }}">粪便厌氧发酵池</a></li>
	</ul></li>
</ul><p class="_css3m"><a href="http://css3menu.com/">dhtml menu</a> by Css3Menu.com</p>
<!-- End css3menu.com BODY section -->

</body>
</html>
