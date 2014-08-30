<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="小卢" />
		<link rel="stylesheet" type="text/css" href="/MyCMS/Admin/Tpl/resource/css/style.css" >
		<script src="/MyCMS/Admin/Tpl/resource/js/common.js"></script>
		
			
			<script charset="utf-8" src="/MyCMS/Public/editor/kindeditor.js"></script>
			<script charset="utf-8" src="/MyCMS/Public/editor/lang/zh_CN.js"></script>
			<script>
					var editor;
					KindEditor.ready(function(K) {
							editor = K.create('#editor_id');
					});
			</script>			
		
	</head>
	
	<body>
		<div id="main">
		    <div class='head-dark-box'>
				<div class='tit'>内容管理>入驻幼儿园管理>添加幼儿园信息</div>
			</div>	
						<div class='tip-msg'>
								  提示: 带"<span class="red_font">*</span>"的项目为必填内容。
						</div>
		  
		  
		    <form name="Kindergartenmessage" method="post" action="__APP__/Kindergarten/insert">
			
			
			<div class="msg-box">
				<ul class="viewmess">
						
					<li class="light-row">
						<span class="col_width">幼儿园名&nbsp;<span class="red_font">*</span></span>
						<input type="text" class="text-box" name="name" size="15"  maxlength="20">
					</li>

					<li class="dark-row">
						<span class="col_width">幼儿园描述&nbsp;<span class="red_font">*</span></span>
  						<input type="text" class="text-box" name="desc" size="30" maxlength="40">
	
					</li>
					<li class="light-row">
						<span class="col_width">入驻时间&nbsp;<span class="red_font">*</span></span>
						<input type="text" class="text-box" name="entertime" size="30" value="<?php echo (date('Y-m-d H:i:s',$postTime)); ?>">&nbsp;&nbsp;如自己更改请注意格式.
					</li>
									
                    <li class="light-row">
						<span class="col_width">幼儿园网址&nbsp;</span>
						<input type="text" class="text-box" name="website" size="25"  maxlength="20">
					</li>

					<li style="margin:0px; padding:0px">
						<br>
						<?php echo ($editor); ?>
						
					</li>
	
					<li class="dark-row">
						<span class="col_width">&nbsp;  </span>
						<input type="submit" class="button"  value="添加">&nbsp;&nbsp;
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