<?php if (!defined('THINK_PATH')) exit();?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>管理平台</title>
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
						
						
					</ul>
			</div>
			<div class="right_user">
				<b>欢迎您</b><span class="red_font">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (session('loginname')); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>管理员&nbsp;&nbsp; <?php if($_SESSION['power'] == 2): ?>您的制卡余额为：<?php echo ($balance); endif; ?>　<a href="__APP__/Login/logout" target="_top"><img border=0 src="__PUBLIC__/images/exit3.gif"></a>
				
			</div>
		</div>
	</body>
</html>