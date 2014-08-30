<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>管理平台</title>
<meta name="Author" content="" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
<style type="text/css">

dl dd{margin:20px 0;}
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
	//ajax选择
	$("#select").change(function(){
		var id=$(this).val();
		if(id>0){
			$("#amount_setting").load('<?php echo U('ajaxAmount');?>&accountid='+id);
		}
	});
});
</script>
	       
</head>
<body>
<div id="main">
	<div class="head-dark-box">
		<div class="tit">内容管理&gt;新增代理商制卡设置</div>	
		<form action="" method="post">	
		<dl>
			<dd>　　　代理商：<select name="account_id" id="select">
				<option value="0">请选择一个代理商</option>
				<?php if(is_array($account)): foreach($account as $k=>$vo): ?><option value="<?php echo ($k); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
			</select></dd>
			<dd id="amount_setting">　　制卡金额：请先选择一个代理商
			</dd>
			<dd>　　卡号前缀：<input type="text" name="card_prefix"/></dd>
			<dd>　　　　备注：<textarea name="remark" style="font-size:12px;width:300px;height:100px;border:1px solid #ccc;"></textarea></dd>
			<dd><input type="submit" name="send" value="提交" class="submit"/><input type='button' onclick="javascript:history.back(-1);"   value="返回" class="submit"/> </dd>	
		</dl>
		</form>
	</div>
</div>
</body>
</html>