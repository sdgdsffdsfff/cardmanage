<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>管理平台</title>
<meta name="Author" content="" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
<style type="text/css">
dl{width:600px;margin:20px auto;border:1px dashed #ccc;}
dl dd{margin:20px auto;width:300px;}
input.text{border:1px solid #ccc;height:25px;line-height:25px;}
input.submit{border:1px solid #ccc;cursor:pointer;padding:3px 5px;margin-left:50px;}
</style>
<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>
</head>
<body>
<div id="main">
	<div class="head-dark-box">
		<div class="tit">内容管理&gt;代理充值</div>	
		<form action="" method="post">	
		<dl>
			<dd>充值账户：<?php echo ($data["loginname"]); ?></dd>
			<dd>当前余额：<?php echo ($data["balance"]); ?></dd>
			<dd>冲值金额：<input type="text" name="balance" value="" class="text"/></dd>
			<dd><input type="submit" name="send" value="提交" class="submit"/>  <a href="<?php echo U('updateaccount');?>">返回代理商列表</a></dd>	
		</dl>
		</form>
	</div>
</div>
</body>
</html>