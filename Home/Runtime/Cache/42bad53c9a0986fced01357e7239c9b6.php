<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>管理平台</title>
<meta name="Author" content="" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
<style type="text/css">
table{background:#ccc;width:80%;margin:20px auto;}
table tr{height:30px;line-height:30px;}
table td,table th{text-align:center;background:#fff;}
table th{background:#eee;}
.operate{width:800px;border:1px solid #ccc;padding:10px;margin:50px auto;}
select{border:1px solid #ccc;padding:5px 3px;}
</style>
<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>
<script>
$(function(){
	//ajax提交
	$("#submit").click(function(){
		$.post('<?php echo U('add');?>',$('form[name=card]').serialize(),function(data){
			if(data.status=='error'){
				alert(data.message);
			}else{
				alert(data.message);
			}
			
		});
	});
	$("#amount").change(function(){
		var amount=$(this).val();
		if(amount>0){
			$.post('<?php echo U('ajaxGet');?>',{amount:amount},function(data){
				$("#days").val(data.days);
				$("#expiry").val(data.expiry);
				$("input[name=validityday]").val(data.days);
				$("input[name=expirydate]").val(data.expiry);
			},'json');
		}else{
			$("#days").val('');
			$("#expiry").val('');
		}
	});
});
</script>
</head>
<body>
<div id="main">
	<div class="head-dark-box">
		<div class="tit">内容管理&gt;代理商制卡</div>
		<form name="card" action="">
		<input type="hidden" name="card_prefix" value="<?php echo ($info["card_prefix"]); ?>"/>
		<input type="hidden" name="validityday" value="<?php echo ($info["validityday"]); ?>"/>
		<input type="hidden" name="expirydate" value="<?php echo ($info["expirydate"]); ?>"/>
		<div class="operate">
			<p>
			您的制卡前缀：<?php echo ($info["card_prefix"]); ?>， 起始账号为：<?php echo str_pad('',8-strlen($info['card_prefix']),'0',STR_PAD_LEFT);?>， 结束账号：<?php echo str_pad('',8-strlen($info['card_prefix']),'9',STR_PAD_LEFT);?> <br/>
			起始账号：<input name="start" value="" /> 结束账号：<input name="end" value="" /><br/> 
			　　金额：<select name="amount" id="amount">
				<option value="0">请选择制卡金额</option>
				<?php if(is_array($info['amount'])): foreach($info['amount'] as $key=>$v): if(in_array($v,$amount)): ?><option value="<?php echo ($v); ?>"><?php echo ($v); ?></option><?php endif; endforeach; endif; ?>
				</select> <br/>　有效期：<input type="text" value="" id="days" disabled/>天  <br/>充值期限：<input type="text" id="expiry" value="" disabled/>
			</p>
			<p><input value="生成账号卡" type="button" id="submit"/></p>
		</div>
		</form>
	</div>
</div>
</body>
</html>