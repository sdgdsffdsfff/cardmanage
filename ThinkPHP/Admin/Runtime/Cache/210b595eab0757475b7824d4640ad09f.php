<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>管理平台</title>
		<meta name="Author" content="小卢" />
	
		<link rel="stylesheet" type="text/css" href="/MyCMS/Admin/Tpl/resource/css/style.css" >
	</head>
	<body>
		<div id="main">
			
			<div class='head-dark-box'>
					<div class='tit'>系统管理>常规设置>系统信息</div>
				</div>	
						<div class='tip-msg'>
								  以下为系统的基本配置信息.
						</div>
			
			
			<div class="msg-box">
				<ul class="viewmess">
				
				<li class="light-row">
				<span class="col_width">网站名：<?php echo ($webInfo["webTitle"]); ?></span>
				</li>
				
				<li class="dark-row">
				<span class="col_width">服务器信息：<?php echo ($sysos); ?></span>
				</li>
				<li class="light-row">
				<span class="col_width">PHP版本：<?php echo ($sysversion); ?></span>
				</li>
				<li class="dark-row">
				<span class="col_width">MySQL版本：<?php echo ($mysqlinfo); ?></span>
				</li>
				<li class="light-row">
				<span class="col_width">GD库版本：<?php echo ($gdinfo); ?></span>
				</li>
				<li class="dark-row">
				<span class="col_width">FreeType字体：<?php echo ($freetype); ?></span>
				</li>
				<li class="light-row">
				<span class="col_width">远程文件获取：<?php echo ($allowurl); ?></span>
				</li>
				<li class="dark-row">
				<span class="col_width">文件上传最大限制：<?php echo ($max_upload); ?></span>
				</li>
				<li class="light-row">
				<span class="col_width">脚本最大执行时间：<?php echo ($max_ex_time); ?></span>
				</li>
				</ul>		
			</div>
		</div>
		
				<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
</div>
	</body>
</html>