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
           showSecond: true,
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
		<div class="tit">内容管理&gt;修改代理商制卡设置</div>	
		<form action="" method="post">	
		<dl>
			<dd>　　　　代理商： <?php echo ($account[$info['account_id']]); ?></dd>
			<dd>　　　制卡金额：
				<?php if(is_array($amount)): foreach($amount as $key=>$v): ?><input type="checkbox" name="amount[]"  <?php if(in_array($v['amount'],$info['amount'])): ?>checked="checked"<?php endif; ?> value="<?php echo ($v['amount']); ?>"/> <?php echo ($v['amount']); ?>(有效期：<?php echo ($v['days']); ?>天 充值期限：<?php echo date('Y-m-d H:i:s',$v['expiry']);?>)<?php endforeach; endif; ?>
			</dd>
			<dd>　　卡号前缀：<input type="text" name="card_prefix" value="<?php echo ($info['card_prefix']); ?>"/></dd>
			<dd>　　　　备注：<textarea name="remark"><?php echo ($info['remark']); ?></textarea></dd>
			<dd><input type="submit" name="send" value="提交" class="submit"/>  <input type='button' onclick="javascript:history.back(-1);"   value="返回" class="submit"/></dd>	
		</dl>
		</form>
	</div>
</div>
</body>
</html>