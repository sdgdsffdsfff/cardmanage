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
								  可以根据网站的需要，对系统现有的配置进行调整.
						</div>
			
			
			<div class="msg-box">
				<form method="post" action="__APP__/SysInfo/update">
				<ul class="viewmess">
			
			                <li class="dark-row">
							<span class="col_width">网站标题:  &nbsp;&nbsp;</span>
							<input type="text" class="text-box" name="webTitle" maxlength="30" size="20" value="<?php echo ($webInfo["webTitle"]); ?>" >
							</li>		
							<li class="light-row"><span class="col_width">网站描述:  &nbsp;&nbsp;</span>
							<textarea class="text-box" name="msg" cols="30" rows="5" maxlength="200" ><?php echo ($webInfo["msg"]); ?></textarea>
							</li>
							<li class="dark-row"><span class="col_width">邮&nbsp;&nbsp;&nbsp;&nbsp;箱:  &nbsp;&nbsp;</span>
							<input type="text" class="text-box" name="email" maxlength="60" size="20" value="<?php echo ($webInfo["email"]); ?>" >
							</li>
							<li class="dark-row"><span class="col_width">网站关键字(用于SEO优化): </span>
							<input type="text" class="text-box" name="keyword" maxlength="60" size="20" value="<?php echo ($webInfo["keyword"]); ?>" >
							&nbsp;&nbsp;&nbsp;&nbsp;多个请用;隔开
							</li>
							
							<li class="light-row"><span class="col_width">电&nbsp;&nbsp;&nbsp;&nbsp;话:  &nbsp;&nbsp;</span>
							<input type="text" class="text-box" name="tel" maxlength="15" size="20" value="<?php echo ($webInfo["tel"]); ?>" >
							</li>
							<li class="dark-row"><span class="col_width">地&nbsp;&nbsp;&nbsp;&nbsp;址:  &nbsp;&nbsp;</span>
							<input type="text" class="text-box" name="adss" maxlength="50" size="20" value="<?php echo ($webInfo["adss"]); ?>" >
							</li>
				            <li class="light-row">
						<span class="col_width">&nbsp;  </span>
						<input type="submit" class="button" value="重 置">&nbsp;&nbsp;
						
					</li>
				</ul>
				</form>
			</div>
		</div>
		
				<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
</div>
	</body>
</html>