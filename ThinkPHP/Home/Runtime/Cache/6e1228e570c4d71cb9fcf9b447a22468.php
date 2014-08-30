<?php if (!defined('THINK_PATH')) exit();?>﻿	
	<html>
	<head>
		<title>管理平台</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		<script src="__PUBLIC__/js/common.js"></script>
		
	</head>

	<body>
	<div id='main'>
				<div class='head-dark-box'>
					<div class='tit'>MyCMS信息发布平台后台管理首页</div>
				</div>	
						<div class='tip-msg'>
						<?php
 echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>
								  相关说明
						</div>
					<div class='msg-box'>
						<div class="mar">
						<p><span class="red_font">MyCMS信息发布平台为小卢，赵兴壮设计编写,目前版本为1.0 beta. </span></p>
						<ul>主要特点有: 
						    <li class="mess">使用开源PHP框架：ThinkPHP3.0 遵循Apache2开源协议</li>	
						    <li class="mess">使用《细说PHP》源码中的开源CMS后台模版</li>	
							<li class="mess">使用流行脚本语言PHP编写，搭配性能稳定的MySQL数据库. </li>
							<li class="mess">使用fck编辑器，发布文件排版像使用WORD一样简单. </li>
							<li class="mess">使用XHTML+CSS技术,遵循WEB标准技术. </li>
							<li class="mess">采用ThinkPHP3.0内置模板引擎,页面缓存技术. </li>
							<li class="mess">采用完全的PHP5面向对象设计. </li>
                            <li class="mess">内容采用一级导航分类.</li>	
                            <li class="mess">具有文件上传下载功能.</li>	
							<li class="mess">更多内容请联系作者.</li>	
                            <li class="mess">版权所有Copyright © 2012-2013</li>							
						</ul>	
						</div>	
					</div>
		    </div>
			
			<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
</div>

			
			
	</body>
	</html>