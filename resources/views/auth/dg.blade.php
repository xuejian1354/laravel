<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="dgsrc/css/DigitalAgriculture.css" />
<title>数字农业 | 畜禽养殖 | Login</title>
<head>
</head>
<body>
<div class="conten">
 <div class="bk">
   
 	<div class="header">畜禽养殖系统</div>
 	<div class="clear"></div>
    <div class="bkheader"><img src="dgsrc/images/logobk.png"></div>
    <div class="body">

    	<div class="left"><img src="dgsrc/images/bkicon.png">
          <div class="Picturelist">
     <div class="line1"> 
     <div class="header1"><img src="dgsrc/images/Safety.png"><p class="text"> 食品安全</p></div> 
   <div class="header1"><img src="dgsrc/images/product.png"><p class="text"> 产品溯源</p></div> 
   <div class="header1"><img src="dgsrc/images/Electricity.png"><p class="text">农村电商</p></div> 
     <div class="clear"></div>
      </div>
 
<div class="line1"> 
     <div class="header1"><img src="dgsrc/images/sightseeing.png"><p class="text"> 旅游观光</p></div> 
   <div class="header1"><img src="dgsrc/images/expert.png"><p class="text"> 农业专家</p></div> 
   <div class="header1"><img src="dgsrc/images/Safety.png"><p class="text"> 食品安全</p></div> 
     <div class="clear"></div>
      </div>
      <div class="line1"> 
     <div class="header1"><img src="dgsrc/images/Safety.png"><p class="text"> 食品安全</p></div> 
   <div class="header1"><img src="dgsrc/images/Safety.png"><p class="text"> 食品安全</p></div> 
   <div class="header1"><img src="dgsrc/images/Safety.png"><p class="text"> 食品安全</p></div> 
     <div class="clear"></div>
      </div>
      </div>
   
        
        
        
        </div>





        <div class="right">
        <div class="title"><p class="lgtitle">畜禽养殖系统</p> <p class="smtitle">专业农业智能管理系统</p></div>
        
        
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
	      {{ csrf_field() }}
          <div class="accountnumber">
            <img src="dgsrc/images/lo.png">
            <input id="email" type="email" type="text" placeholder="Email" name="email" value="{{ old('email') }}" class="text"/>
          </div>
		  @if ($errors->has('email'))
          <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif
          <div class="password">
            <img src="dgsrc/images/pass.png">
            <input id="password" type="password" type="text" placeholder="Password" name="password" class="text"/>
          </div>
          @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif         
         <div class="login"><img src="dgsrc/images/chexbox.png">记录密码</div>
         <div class="registered"><a href="#">忘记密码？</a></div>
           <button class="logininer" type="submit"><a>登录</a></button>
         </div>
       </form>
    </div>
<div class="foot">
 	版权所有
 </div>
 </div>
 
  </div>
 
</body>
</html>