<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		
		<title>MyCMS管理平台</title>
		<meta name="Author" content="" />
		<link rel="stylesheet" type="text/css" href="/MyCMS/Admin/Tpl/resource/css/style.css" >
		<script src="/MyCMS/Admin/Tpl/resource/js/common.js"></script>
	</head>

	<body>
		<div id="menu">
			<div class="option">
				<div class="menutitle">【管理选项】</div>
				<div class="content">
					<ul>
						<li class="opt">
							<a href="main" onclick="switchmenu('optionmenu','menulist',0)" target="main">
							<img onmouseover="cimg(this, '/MyCMS/Admin/Tpl/resource/images/system_h.gif')" onmouseout="cimg(this, '/MyCMS/Admin/Tpl/resource/images/system_d.gif')" border="0" src="/MyCMS/Admin/Tpl/resource/images/system_d.gif"><br>
							 系统管理</a></a>
						</li>
						<li class="opt">
							<a href="main" onclick="switchmenu('optionmenu','menulist',1)" target="main">
							<img onmouseover="cimg(this, '/MyCMS/Admin/Tpl/resource/images/article_h.gif')" onmouseout="cimg(this, '/MyCMS/Admin/Tpl/resource/images/article_d.gif')" border="0" src="/MyCMS/Admin/Tpl/resource/images/article_d.gif"><br>
							内容管理</a>
						</li>
						<li class="opt">	
							 <a href="main" onclick="switchmenu('optionmenu','menulist',2)" target="main">
							 <img onmouseover="cimg(this, '/MyCMS/Admin/Tpl/resource/images/user_h.gif')" onmouseout="cimg(this, '/MyCMS/Admin/Tpl/resource/images/user_d.gif')" border="0" src="/MyCMS/Admin/Tpl/resource/images/user_d.gif"><br>
							 用户管理</a>
						</li>
					</ul>
				 </div>
			</div>
			<div class="nav"> </div>
			<div class="option">
				<div id="optionmenu" class="menutitle">【系统管理】</div>
				<div id="menulist" class="content"> 
				    	<div style="display:block">					
						<h4 onclick="domenu(this, 'list1')" class="tit">--常规设置--</h4>
						<ul id="list1">
							<li><a class="list" href="__APP__/SysInfo/show" target="main" method=post>系统信息</a></li>
						    <li><a class="list" href="__APP__/SysInfo/set"  target="main" method=post>系统设置</a> </li> 
						</ul>
						<h4 onclick="domenu(this, 'list2')" class="tit">--友情链接管理--</h4>
						<ul id="list2">
							<li><a class="list" href="__APP__/Flink/add" target="main">添加友情链接</a></li>
							<li><a class="list" href="__APP__/Flink/index" target="main">管理友情链接</a></li>
						</ul>
					</div>

					<div>
					   
					
						<h4 onclick="domenu(this, 'list21')" class="tit">--栏目设置--</h4>
						<ul id="list21">
							<li><a class="list" href="__APP__/Cat/add" target="main">添加栏目</a></li>
							<li><a class="list" href="__APP__/Cat/index" target="main">管理栏目</a></li>
						</ul>

						<h4 onclick="domenu(this, 'list22')" class="tit">--文章管理--</h4>
						<ul id="list23">
							<li><a class="list"  href="__APP__/Article/add" target="main">添加文章</a></li>
							<li><a class="list"  href="__APP__/Article/index"  target="main">管理文章</a></li>				
						</ul>
						

						<h4 onclick="domenu(this, 'list22')" class="tit">--产品信息管理--</h4>
						<ul id="list23">
							<li><a class="list"  href="__APP__/Product/add" target="main">添加产品信息</a></li>
							<li><a class="list"  href="__APP__/Product/index"  target="main">更新产品信息</a></li>
							
						</ul>


						<h4 onclick="domenu(this, 'list22')" class="tit">--入住幼儿园管理--</h4>
						<ul id="list23">
							<li><a class="list"  href="__APP__/Kindergarten/add" target="main">添加幼儿园信息</a></li>
							<li><a class="list"  href="__APP__/Kindergarten/index"  target="main">管理幼儿园信息</a></li>
							
						</ul>
	
				
					</div>


					<div>
						<h4 onclick="domenu(this, 'list31')" class="tit">--账号管理--</h4>
						<ul id="list31">
				    	<li><a class="list" href="__APP__/Admin/adminSet" target="main">管理员设置</a></li> 
						<li><a class="list" href="__APP__/Admin/addUser" target="main">添加用户</a></li>
						<li><a class="list" href="__APP__/Admin/indexUser" target="main">管理用户</a></li>
						</ul>
					</div>

					<script>
						switchmenu('optionmenu','menulist',0);
					</script>
				</div>
			</div>
		</div>
	</body>
</html>