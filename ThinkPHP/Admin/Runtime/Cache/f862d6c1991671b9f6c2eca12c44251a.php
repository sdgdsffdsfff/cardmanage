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
					<div class='tit'>内容管理>栏目设置>栏目管理</div>
				</div>	
						<div class='tip-msg'>
								  提示: 栏目分类 
						</div>
						
						<div class="msg-box">
							<ul class="viewmess">
								<li class="dark-row">
								 
									<span class="col_width width_font">栏目名称</span>
									<span class="col_width width_font">描&nbsp;&nbsp;述</span>
									<span class="col_width width_font">操&nbsp;&nbsp;作</span>
								</li>
							
							
							
								<?php foreach($cat as $value){?>
									
								   <li class="light-row" style="padding-top:2px; padding-bottom:2px">
								   <span class="col_width ">	<a href="__APP__/Cat/mod/colId/<?php echo $value["colId"]; ?>"><?php echo $value["colTitle"] ?></a></span>
                                   <span class="col_width "><a href="__APP__/Cat/mod/colId/<?php echo $value["colId"]; ?>"><?php echo $value["description"] ?>&nbsp;</a></span>
								   <span class="col_width ">	<a href="__APP__/Cat/mod/colId/<?php echo $value["colId"]; ?>">修改</a>/<a onclick="return confirm('你确定要删除   <?php echo $value["colTitle"]; ?>  栏目以及其下所有信息吗?')" href="__APP__/Cat/del/colId/<?php echo $value["colId"]; ?>">删除</a></span>
								   </li>
								
								<?php }if($cat==NULL){ echo '<td colspan="3">没有分类</td>'; } ?>
								 
								<li class="dark-row">
								<span class="right"><?php echo ($page); ?></span>
								</li>
							
							</ul>	
						</div>
								<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
</div>
						
	</body>
</html>