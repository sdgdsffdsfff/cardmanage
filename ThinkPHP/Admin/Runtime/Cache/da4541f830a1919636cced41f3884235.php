<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	    <title>管理平台</title>
		<meta name="Author" content="小卢" />
		<link rel="stylesheet" type="text/css" href="/MyCMS/Admin/Tpl/resource/css/style.css" >
		<script src="/MyCMS/Admin/Tpl/resource/js/common.js"></script>
	</head>
	<body>
		<div id="main">
		    <div class='head-dark-box'>
					<div class='tit'>系统管理>链接管理>添加链接</div>
				</div>	
						<div class='tip-msg'>
								  提示: 请选择栏目目录并操作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注意：红色<span class="red_font">*</span>为必填信息
						</div>
			
			<div class="msg-box">
			
			     	<form name="Form" action="__APP__/Flink/insert" method="post" >
			    
				<ul class="viewmess">
					
					<li class="light-row">
						<span class="col_width">网站名称<span class="red_font">*</span></span>
						 <input type="text" class="text-box" name="webName" maxlength="30" size="20" >
					</li>
					<li class="dark-row">
						<span class="col_width">地&nbsp;&nbsp;址<span class="red_font">*</span></span>
							<input type="text" class="text-box" name="url" maxlength="60" size="40" > &nbsp; 例如：http://www.mydefine.net
					
					</li>
				

						
					<li class="light-row">
						<span class="col_width" style="margin-top:30px">网站描述</span>
						<textarea class="text-box" name="msg" cols="30" rows="5"></textarea>
					</li>
				

					<li class="dark-row">
						<span class="col_width">&nbsp;  </span>
						<input type="submit" class="button" value="添加">&nbsp;&nbsp;
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