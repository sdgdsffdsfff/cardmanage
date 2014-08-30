<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="" />
		<link rel="stylesheet" type="text/css" href="/MyCMS/Admin/Tpl/resource/css/style.css" >
		<script src="/MyCMS/Admin/Tpl/resource/js/common.js"></script>
	</head>
	
	<body>
		<div id="main">
		   <div class='head-dark-box'>
					<div class='tit'>入驻幼儿园管理>添加幼儿园信息>管理幼儿园信息</div>
				</div>	
						
			<div class="msg-box">
				<ul class="viewmess">
					
							
					<li class="dark-row">
						<span class="list_width width_font">幼儿园名</span>
						<span class="list_width width_font">简介</span>
						<span class="list_width width_font">入驻时间</span>
						<span class="list_width width_font">操&nbsp;&nbsp;作</span>
					</li>
					    <?php if(!empty($kindergartendata)){ ?>
				        <?php foreach($kindergartendata as $key => $value){ ?>
						<li class="light-row" style="padding-top:2px; padding-bottom:2px">

							<span class="list_width"><input type="checkbox" name="del[]" value="<?php echo $value["id"]; ?>">

							<a href="__APP__/kindergarten/mod/id/<?php echo $value["id"]; ?>" ><?php echo $value["name"]; ?></a>

							</span>

							<span class="list_width"><?php echo $value["name"]; ?></span>

							<span class="list_width"><?php echo date("Y-m-d H:i:s",$value["entertime"]); ?></span>
				
							<span class="list_width" style="width:160px;">
				
							<a href="__APP__/Kindergarten/mod/id/<?php echo $value["id"]; ?>">【修改】</a>
		
		        			【<a onclick="return confirm('确定要删除<?php echo $value["name"]; ?>吗？')" href="__APP__/Kindergarten/del/id/<?php echo $value["id"]; ?>">删除</a>】
							</span>
						</li>
					     <?php } ?>
						 
						 <?php  }else{ ?>
						<li class="light-row">
							<?php echo "本页没有文章"; ?>
						</li>
					<?php } ?>
				
					<li class="dark-row">
						<span class="col_width" style="margin-left:15px;width:240px"> 
							<a href="javascript:select()">全选</a>/<a href="javascript:fanselect()">反选</a>/<a href="javascript:noselect()">全不选</a>&nbsp;&nbsp;选中项: 
							<input  name="dels" type="image" title="删除暂不支持多选项" onClick="return confirm('你确定要删除选中选项吗?')"  src="/MyCMS/Admin/Tpl/resource/images/delete.gif">&nbsp;&nbsp;
						 </span> 
					</li>
				</ul>	
			</div>
                    
		</div>
		
									<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
</div>
	</body>
</html>