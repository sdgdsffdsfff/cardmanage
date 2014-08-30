<?php if (!defined('THINK_PATH')) exit();?>
<html>
<head>
<title>管理员登录</title>
	<meta name="Author" content="">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
	<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	
	<script src="__PUBLIC__/js/common.js"></script>
	<script type="text/javascript">

					
               $(function(){
        				var isIE11 = !!(navigator.userAgent.match(/Trident/) && navigator.userAgent.match(/rv:11/));	
               	            if (isIE11) {
               	            	 $('#alert').html("您的IE浏览器版本为IE11,页面显示可能会出现问题。<br/>请点击浏览器右上角设置>选择兼容性视图设置>选择添加。或<br/><br><a href='__APP__/Ie/index'>查看设置兼容性视图实例</a>");  
               	            };
	               	
               });

               
              

	</script>
</head>

<body class="center">
<div id="login-box">
<div id="main">
	<div class="head-dark-box">
		&nbsp;<b>管理员登录</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($erro); ?>
	</div>
	<div class="not-display">
		<span></span>	
	</div>
	<form action="__APP__/Login/islogin" method="post" id="login-form" >
		<ul>	
			<li class="dark-row">
				<span class="list_width">用户名</span>
				<input class="text-box" size="15" name="n" type="text">
			</li>
			<li class="light-row">
				<span class="list_width">密&nbsp;&nbsp;&nbsp;码</span>
				<input class="text-box" size="15" name="p" type="password">
			</li>
			
			<li class="dark-row">
				<span class="list_width">验证码</span>
				<input class="text-box" size="7" name="verify" type="text" >
				<img src='__APP__/Public/verify' onclick="this.src='__APP__/Public/verify/'+Math.random()" ><br>
				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;看不清？点击图片更换</span>
			</li>			
 			<li class="light-row">
				<span class="list_width">&nbsp;</span>
				<input class="button" value="登录系统" type="submit" name="sub"  id="sub">
			</li>
		</ul>
	</form>
</div>

<div id="alert"  style="color:red"></div>

</div>

</body>
</html>