<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title>信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv='Refresh' content='3;URL=<?php echo ($jumpurl); ?>'>
<style>
html, body{margin:0; padding:0; border:0 none;font:14px Tahoma,Verdana;line-height:150%;background:white}
a{text-decoration:none; color:#174B73; border-bottom:1px dashed gray}
a:hover{color:#F60; border-bottom:1px dashed gray}
div.message{margin:10% auto 0px auto;clear:both;padding:5px;border:1px solid silver; text-align:center; width:45%}
span.wait{color:red;font-weight:bold}
span.error{color:red;font-weight:bold}
span.success{color:red;font-weight:bold}
div.msg{margin:20px 0px}
</style>
</head>
<body>
<div class="message">
	<div class="msg">
	<span class="success"><?php echo ($msgTitle); echo ($message); ?></span>	
	</div>
	<div class="tip">
		页面将在 <span class="wait">3</span> 秒后自动跳转，如果不想等待请点击 <a href="<?php echo ($jumpurl); ?>">这里</a> 跳转
	</div>
</div>
</body>
</html>