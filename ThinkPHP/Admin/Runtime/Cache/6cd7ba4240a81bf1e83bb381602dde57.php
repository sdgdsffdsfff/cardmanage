<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <title>管理平台</title>
		<meta name="Author" content="小卢" />
		<link rel="stylesheet" type="text/css" href="/MyCMS/Admin/Tpl/resource/css/style.css" >
		<script src="/MyCMS/Admin/Tpl/resource/js/common.js"></script>
	</head>
	<body>
		<div id="main">
		    
			
		  <div class='head-dark-box'>
					<div class='tit'>系统管理>友情链接管理>管理友情连接</div>
				</div>	
						<div class='tip-msg'>
								  提示: 请选择链接并操作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
			
			
			
		    <form  name="Form" method="post"  >
			<div class="msg-box">
				<ul class="viewmess">
					<li class="dark-row">
						<span class="list_width width_font">网站名称</span>
						<span class="list_width width_font" style="width:200px">网站地址</span>
						<span class="list_width width_font">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;操&nbsp;&nbsp;作</span>
					</li>
				        <?php foreach($link as $value){ ?>
						<li class="light-row" style="padding-top:2px; padding-bottom:2px">
							<span class="list_width"><a href="__APP__/Flink/mod/id/<?php echo $value["id"]; ?>"><?php echo $value["webName"]; ?></a></span>
							<span class="list_width" style="width:200px"><a href="__APP__/Flink/mod/id/<?php echo $value["id"]; ?>">&nbsp;<?php echo $value["url"]; ?></a></span>			
							<span class="list_width" style="width:160px;">
						
							【<a href="__APP__/Flink/mod/id/<?php echo $value["id"]; ?>">修改</a>】
							【<a onclick="return confirm('确定要删除友情链接<?php echo $value["$webName"]; ?>吗？')" href="__APP__/Flink/del/id/<?php echo $value["id"]; ?>">删除</a>】
							</span>
						</li>
					<?php }if(!$link){ ?>
						<li class="light-row">
							<?php echo '没有添加任何友情链接'; ?>
						</li>
					<?php } ?>
				
					<li class="dark-row">
						
						<span class="right">
						<?php echo ($page); ?>
						</span>
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