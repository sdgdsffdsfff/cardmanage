<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>管理平台</title>
<meta name="Author" content="" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
<style type="text/css">
body{font-size:10pt;}
table{background:#000;width:90%;margin:20px auto;}
table tr{height:25px;line-height:25px;}
table td,table th{text-align:center;background:#e5e5e5;}
table td{background:#fff;}
table th{background:#eee;}
.page{text-align:center;}
.page a{padding:3px 5px;border:1px solid #ccc;margin:0 5px;}
</style>
<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>
</head>
<body>
<div id="main">
	<div class="head-dark-box">
		<div class="tit">内容管理&gt;卡面额管理</div>
		<p style="width:90%;margin:0 auto;margin-top:10px;"><input type="button" value="新增卡面额" onclick="location.href='<?php echo U('add');?>'"/></p>
		<form method="get" action="" name="Form" style="width:90%;margin:0 auto;">
		<input type="hidden" name="m" value="<?php echo (MODULE_NAME); ?>"/>
		<input type="hidden" name="a" value="<?php echo (ACTION_NAME); ?>"/>
		账号： <select name="accountid"  onchange="window.location='__APP__/Amount/index?accountid='+document.Form.accountid.options[selectedIndex].value">
		        <option value="0">全部</option>
                <?php  foreach($account as $key=>$value) { if($key==$accountid){ echo "<option value=".$key." selected>".$value."</option>"; } else { echo "<option value=".$key.">".$value."</option>"; } } ?>

				<!--
				
           		<?php if(is_array($account)): foreach($account as $k=>$v): ?><option value="<?php echo ($k); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>
           		-->
           	</select>	
        
		</form>
		<table rules="all" id="table" style="border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:90%;border-collapse:collapse;" cellpadding="3" cellspacing="0" align="Center" border="1">
			<tr style="background-color:#E5E5E5;font-weight:bold;height:15px;"><th>账户</th><th>卡面额</th><th>充值期限</th><th>有效期(天)</th><th>卡备注</th><th>操作</th></tr>
			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr><td><?php echo ($account[$vo[accountid]]); ?></td><td><?php echo ($vo["amount"]); ?></td><td><?php echo date('Y-m-d H:i:s',$vo[expiry]);?></td><td><?php echo ($vo["days"]); ?></td><td><?php echo ($vo["remark"]); ?></td><td><a href="<?php echo U('update?id='.$vo['id']);?>">修改</a> | <a href="<?php echo U('del?id='.$vo['id']);?>">删除</a></td></tr><?php endforeach; endif; ?>
		</table>
		<div class="page" style="width:90%;margin:0 auto;"><?php echo ($page); ?></div>
	</div>
</div>
</body>
</html>