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
<link type="text/css" href="__PUBLIC__/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
<link type="text/css" href="__PUBLIC__/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tc.min.js"></script>
<script type="text/javascript">
		$(function(){
			$(".ui_timepicker").datetimepicker({
	                            showSecond: false,
					            showMinute: false,
					            showHour: false,
					            showTime:false,
					            timeFormat: 'hh:mm:ss',
					            stepHour: 1,
					            stepMinute: 1,
					            stepSecond: 1
	        });
		});
</script>
</head>
<body>
<div id="main">
	<div class="head-dark-box">
		<div class="tit">内容管理&gt;新增卡面额</div>	
		<form action="" method="post">	
		<dl>
	        <dd>　　账号： <select name="accountid">
           		<?php if(is_array($account)): foreach($account as $k=>$v): ?><option value="<?php echo ($k); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>
           	</select>
           	</dd>
			<dd>　卡面额：<input type="text" name="amount" value="" class="text"/></dd>
			<dd>　有效期：<input type="text" name="days" value="" class="text"/> 天</dd>
			<dd>充值期限：<input type="text" name="expiry" value="" class="text ui_timepicker"/></dd>
			<dd>　卡备注：<input type="text" name="remark" value="" class="text"/></dd>
			<dd><input type="submit" name="send" value="提交" class="submit"/>  <a href="<?php echo U('index');?>">返回面额列表</a></dd>	
		</dl>
		</form>
	</div>
</div>
</body>
</html>