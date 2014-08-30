<?php if (!defined('THINK_PATH')) exit();?>
<html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="小卢" />
		<link rel="stylesheet" type="text/css" href="/MyCMS/Admin/Tpl/resource/css/style.css" >
		<script src="/MyCMS/Admin/Tpl/resource/js/common.js"></script>
	</head>
	<body>
		<div id="main">
		 <div class='head-dark-box'>
					<div class='tit'>用户管理>账号管理>管理用户</div>
				</div>	
						<div class='tip-msg'>
								  提示: 管理用户 
						</div>
						
						<div class="msg-box">
							<ul class="viewmess">
								<li class="light-row">
								 
									<span class="col_width width_font">用户名</span>
									<span class="col_width width_font">邮&nbsp;&nbsp;箱</span>
									<span class="col_width width_font">操&nbsp;&nbsp;作</span>
								</li>
							
							
							
								<?php foreach($user as $value){?>
									
								    <li class="dark-row" style="padding-top:2px; padding-bottom:2px">
									<span class="col_width ">	<a href="__APP__/Admin/modUser/id/<?php echo $value["id"]; ?>"><?php echo $value["name"] ?></a></span>
                                    <span class="col_width "><a href="__APP__/Admin/modUser/id/<?php echo $value["id"]; ?>"><?php echo $value["email"] ?>&nbsp;</a></span>
									<span class="col_width ">	<a href="__APP__/Admin/modUser/id/<?php echo $value["id"]; ?>">修改</a>/<a onclick="return confirm('你确定要删除   <?php echo $value["name"]; ?> 用户以及其下所有信息吗?')" href="__APP__/Admin/delUser/id/<?php echo $value["id"]; ?>">删除</a></span>
									</li>
									
								<?php }if($user==NULL){ echo '<td colspan="3">没有用户</td>'; } ?>
								 
								<li class="light-row">
								
								</li>
							
							</ul>	
						</div>
								<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
</div>
						
	</body>
</html>