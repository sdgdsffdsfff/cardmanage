<?php if (!defined('THINK_PATH')) exit();?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>管理平台</title>
		<meta name="Author" content="小卢" />
		<link rel="stylesheet" type="text/css" href="/MyCMS/Admin/Tpl/resource/css/style.css" >
	</head>

	<body>
		<div id="top">
			<div class="left">
				<a herf="index.php"><img  border="0" src="/MyCMS/Admin/Tpl/resource/images/logo.gif"></a>
			</div>

		
			<div class="right_tool">
					<ul>
						<li><a href="__ROOT__/index.php" target="_top"><img border=0 src="/MyCMS/Admin/Tpl/resource/images/exit4.gif"></a></li>
						<li><a href="__APP__/Login/logout" target="_top"><img border=0 src="/MyCMS/Admin/Tpl/resource/images/exit3.gif"></a></li>
					</ul>
			</div>
			<div class="right_user">
				<b>欢迎您</b><span class="red_font">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (session('admin')); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>管理员&nbsp;&nbsp;
				
			</div>
		</div>
	</body>
</html>