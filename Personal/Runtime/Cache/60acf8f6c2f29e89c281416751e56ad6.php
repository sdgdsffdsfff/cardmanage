<?php if (!defined('THINK_PATH')) exit();?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>用户个人账号管理</title>
		<meta name="Author" content="" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
	</head>


	<body>
		<div id="top">
			<div class="left">
				<a herf="index.php"><img  border="0" src="__PUBLIC__/images/logo.gif"></a>
			</div>
	
			<div class="right_tool">
					<ul>		
					<?php
 if($_SESSION['limitflag']==0) { $type="流量卡用户"; } else { $type="期限卡用户"; } ?>
					</ul>
 			<div class="right_user">
				<b>欢迎您</b><span class="red_font">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (session('loginname')); ?>&nbsp;&nbsp;<?php echo $type; ?>&nbsp;&nbsp;</span>&nbsp;&nbsp;<a href="__APP__/Login/logout" target="_top"><img border=0 src="__PUBLIC__/images/exit3.gif"></a>
				
			</div>
		</div>
	</body>
	
 </html>