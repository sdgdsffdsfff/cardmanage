<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>管理平台</title>
<meta name="Author" content="" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
<style type="text/css">
table{background:#000;width:90%;margin:20px auto;}
table tr{height:25px;line-height:25px;}
table td,table th{text-align:center;background:#e5e5e5;}
table td{background:#fff;}
table th{background:#eee;}
.operate{width:90%;margin:20px auto;margin-bottom:0;}
dl dd{margin:20px 0;}
input.text{border:1px solid #ccc;height:25px;line-height:25px;}
input.submit{border:1px solid #ccc;cursor:pointer;padding:3px 5px;margin-left:50px;}

.page{text-align:center;}
.page a{margin:0 3px;padding:2px 3px;border:1px solid #ccc;}
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
		<div class="tit">内容管理&gt;代理商制卡设置</div>	
		<form method="get" action="">
		<input name="g" value="Home" type="hidden"/>
		<input name="m" value="authority" type="hidden"/>
		<input name="a" value="cardset" type="hidden"/>
		<div class="operate">
			代理商账号：<input type="text" name="loginname" value=""/> <input type="submit" value="搜索" name="send"/>
			</br>
			</br>
			<input type="button" value="新增 " onclick="location.href='<?php echo U('cardset_add');?>'"/>
		</div>
		
		</form>
		
		<table rules="all" id="table" style="margin-top:0;border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:90%;border-collapse:collapse;" cellpadding="3" cellspacing="0" align="Center" border="1">
			<tr style="background-color:#E5E5E5;font-weight:bold;height:15px;"><th>代理商账号</th><th>面额类型</th><th>卡号前缀</th><th>备注</th><th>操作</th></tr>
			<?php if(is_array($list)): foreach($list as $key=>$vo): if($vo['account_id']): ?><tr><td><?php echo ($vo["loginname"]); ?></td><td><?php echo ($vo["amount"]); ?></td><td><?php echo ($vo["card_prefix"]); ?></td><td><?php echo ($vo["remark"]); ?></td><td><a href="<?php echo U('cardset_update?id='.$vo['id']);?>">编辑</a> | <a href="<?php echo U('cardset_del?id='.$vo['id']);?>">删除</a></td></tr><?php endif; endforeach; endif; ?>
		</table>
		<div class="page"><?php echo ($page); ?></div>
	</div>
</div>
</body>
</html>