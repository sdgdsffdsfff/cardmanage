<?php if (!defined('THINK_PATH')) exit();?>﻿
<html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="小卢" />
		<meta name="Keywords" content="php,lampbrother" />
		<link rel="stylesheet" type="text/css" href="/MyCMS/Admin/Tpl/resource/css/style.css" >
		<script src="/MyCMS/Admin/Tpl/resource/js/common.js"></script>
	</head>
	<body>
		<div id="main">
		 <div class='head-dark-box'>
					<div class='tit'>内容管理>顶级栏目管理>添加栏目</div>
				</div>	
						<div class='tip-msg'>
								  提示: 带<span class="red_font">*</span>的项目为必填信息. 
						</div>
		<form action="__APP__/Cat/insert" method="post">
		   
			<div class="msg-box">
				<ul class="viewmess">
				
					<li class="light-row">
						<span class="col_width">栏目名称<span class="red_font">*</span></span>
						<input type="text" class="text-box" name="colTitle" maxlength="30" size="20" >
					</li>
					<li class="dark-row">
						<span class="col_width" style="margin-top:30px">栏目描述</span>
						<textarea class="text-box" name="description" cols="30" rows="5"></textarea>
					</li>
					

					<li class="light-row">
						<span class="col_width">&nbsp;  </span>
						<input type="submit" class="button" value="添加">&nbsp;&nbsp;
						<input type="reset" class="button" value="重 置">
					</li>
				</ul>	
			</div>
                    </form>	
		</div>
		
				<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
</div>
	</body>
</html>