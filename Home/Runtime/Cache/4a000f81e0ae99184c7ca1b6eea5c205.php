<?php if (!defined('THINK_PATH')) exit();?><html>
<head>

<title>MyCMS管理平台</title>
<meta name="Author" content="" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css">
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.2.js"></script>
<script src="__PUBLIC__/js/common.js" charset="utf-8"></script>
<link type="text/css" href="__PUBLIC__/css/jquery-ui-1.8.17.custom.css"
	rel="stylesheet" />
<link type="text/css"
	href="__PUBLIC__/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.2.js"></script>
<script type="text/javascript"
	src="__PUBLIC__/js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript"
	src="__PUBLIC__/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"
	src="__PUBLIC__/js/jquery-ui-timepicker-zh-CN.js"></script>

<script type="text/javascript">
	$(function() {
		
		resizemenu();
		$("#Button3").click(function() {

			$('#querycardform').attr("action", "__APP__/Querycard/download");

		});

		$('#Button2').click(function() {

			$('#querycardform').attr("action", "__APP__/Querycard/index");

		});

        
		$('#Button1').click(function(){
			 
             if (window.confirm('您确定要删除该条件下的卡数据?')) {
             	 if (window.confirm("您确定要删除数据？删除后数据将无法修复，请谨慎操作！")) {
             	 	 $('#querycardform').attr("action", "__APP__/Querycard/delete");	
             	 }
             	 else
             	 {
             	 	return false;
             	 }
             }
             else
             {
             	return false;
             }			
		});
       

	});
	
	function resizemenu()
	{
		var height = document.body.clientHeight;
		
		if (height<650) {	
			$('#menulist').css('height', '400px');
		}
		else
		{
			$('#menulist').css('height', '700px');
		}
	}

	
	function switchmenu(menutitle, menulist, num) {
		var mTitleObj = document.getElementById(menutitle);
		var tlist = document.getElementById("menulist");
		var mlist = tlist.getElementsByTagName("div");

		switch (num) {
		case 0:

			mTitleObj.innerText = "修改密码";
			$("#menu0").css("color", "red");
			$("#menu1").css("color", "black");
			$("#menu2").css("color", "black");
			break;

		case 1:

			mTitleObj.innerText = "内容管理";
			$("#menu0").css("color", "black");
			$("#menu1").css("color", "red");
			$("#menu2").css("color", "black");
			break;
		case 2:

			mTitleObj.innerText = "用户管理";
			$("#menu0").css("color", "black");
			$("#menu1").css("color", "black");
			$("#menu2").css("color", "red");
			break;
		}

		for ( var i = 0; i < mlist.length; i++) {
			if (i == num) {
				mlist[num].style.display = "block";
			} else {
				mlist[i].style.display = "none";
			}
		}
		showScroll(tlist);
	}
</script>
</head>

<body>
	<div id="menu">
		<div class="option">


			<div class="menutitle">【管理选项】</div>
			<div class="content">
				<ul>


					<li class="opt"><a
						onclick="switchmenu('optionmenu','menulist',1)" target="main">
							<img onmouseover="cimg(this, '__PUBLIC__/images/article_h.gif')"
							onmouseout="cimg(this, '__PUBLIC__/images/article_d.gif')"
							border="0" src="__PUBLIC__/images/article_d.gif"><br /> <span
							id="menu1" style="color: red">内容管理</span>
					</a></li>
					<li class="opt"><a
						onclick="switchmenu('optionmenu','menulist',2)" target="main">
							<img onmouseover="cimg(this, '__PUBLIC__/images/user_h.gif')"
							onmouseout="cimg(this, '__PUBLIC__/images/user_d.gif')"
							border="0" src="__PUBLIC__/images/user_d.gif"><br /> <span
							id="menu2">账号管理</span>
					</a></li>

					<li class="opt"><a href="__APP__/changepwd/index"
						onclick="switchmenu('optionmenu','menulist',0)" target="main">

							<img onmouseover="cimg(this, '__PUBLIC__/images/system_h.gif')"
							onmouseout="cimg(this, '__PUBLIC__/images/system_d.gif')"
							border="0" src="__PUBLIC__/images/system_d.gif"> <br /> <span
							id="menu0">修改密码</span>
					</a></li>

				</ul>
			</div>
		</div>


		<div class="nav"></div>
		<div class="option">

			<div id="optionmenu" class="menutitle">管理选项</div>


			<div id="menulist" class="content">

				<!-------------------------第一块选项---------------------------------------->

				<!-------------------------以后添加---------------------------------------------->


				<div>
					<h4 onclick="domenu(this, 'list1')" class="tit">--修改密码--</h4>
					<ul id="list1">
						<li><a class="list" href="__APP__/changepwd/index"
							target="main">修改密码</a></li>
					</ul>
				</div>

				<!--- ------------------------第二块-------------------------------->
				<div style="display: block">

					<?php
 if (($_SESSION['power']==1)||(($_SESSION['power']!=3)&&($_SESSION['authority']['transfer_card']==1))||($_SESSION['power']==2)) { echo '<h4 onclick="domenu(this, \'list21\')" class="tit">--账号卡管理--</h4>
									<ul id="list21" >'; } if ($_SESSION['power']==1) { echo '<li><a class="list" href="__APP__/ProducecardBy/index" target="main">批量生成期限卡</a></li>'; echo '<li><a class="list" href="__APP__/Producecard/index" target="main">批量生成流量卡</a></li>'; } ?>

					<?php
 if(($_SESSION['power']!=3)&&($_SESSION['authority']['transfer_card']==1)) { echo '<li><a class="list" href="__APP__/Transfercard/index" target="main">卡号下发代理商</a></li>'; } if(($_SESSION['power']==2)) { echo '<li><a class="list" href="__APP__/Card/index" target="main">   代理商制卡</a></li>'; } ?>

					</ul>
					<?php if($_SESSION['power'] == 1): ?><h4 onclick="domenu(this, 'list299')" class="tit">--代理商制卡管理--</h4>

					<ul id="list299">
						<li><a class="list"
							href="__APP__/card/index.php?m=amount&a=index" target="main">卡面值管理</a></li>
						<li><a class="list" href="__APP__/Authority/cardset"
							target="main">代理商制卡设置</a></li>
					</ul><?php endif; ?>
					<?php  if ($_SESSION['authority']['man_cardstatus']!=0||$_SESSION['power']==2) { echo '<h4 onclick="domenu(this, \'list22\')" class="tit">--账号卡管理--</h4>
									              <ul id="list22" >'; } if ($_SESSION['power']==1) { echo '<li><a class="list" href="__APP__/ChangecdstatusBy/index" target="main">批量修改期限卡状态</a></li>'; echo '<li><a class="list" href="__APP__/Changecdstatus/index" target="main">批量修改流量卡状态</a></li>'; } else if($_SESSION['power']==2){ echo '<li><a class="list" href="__APP__/Changecdstatus/index" target="main">批量修改流量卡状态</a></li>'; } ?>
					</ul>
					<?php
 if ($_SESSION['power']==1) { echo '<h4 onclick="domenu(this, \'list24\')" class="tit">--费率管理--</h4>
													<ul id="list24" >'; echo '<li><a class="list"  href="__APP__/Ratemanage/index"  target="main">费率管理</a></li>'; } ?>
					</ul>

					<h4 onclick="domenu(this, 'list25')" class="tit">--赠送金额查询--</h4>
					<ul id="list25">
						<li><a class="list" href="__APP__/Donatemoney/index"
							target="main">赠送金额查询</a></li>
					</ul>

					         <?php
 if ($_SESSION['authority']['count_data']==1||$_SESSION['power']==1) { echo '<h4 onclick="domenu(this, \'list23\')" class="tit">--数据查询--</h4>
									          <ul id="list23">'; } if ($_SESSION['authority']['count_data']==1) { echo '<li><a class="list"  href="__APP__/Datastatistic/index"  target="main">数据统计</a></li>'; } ?>

					<li><a class="list" href="__APP__/Querylog/index"
						target="main">操作日志</a></li>
					<?php
 if ($_SESSION['power']==1) { echo '<li><a class="list" href="__APP__/queryfilllog/index"  target="main">充值日志</a></li>'; } ?>
					</ul>
					<br>


					<hr size=2
						style="color: blue; border-style: dotted; width: 490px; color: #CCC">
					<!--form表单---------->
					<form action="__APP__/Querycard/index" method="post"
						id="querycardform" name="" target="main">

						<table width="90%" border="0" align="center" cellspacing="1"
							cellpadding="0"
							style="margin: 5px; font: 12px Verdana, Arial, Helvetica, sans-serif;">
							<tbody>
								<tr>
									<td colspan="2" align="center" height="25px">帐号卡查询</td>
								</tr>
								<tr>
									<td align="center" height="25px">卡号</td>
									<td align="center" height="25px"><input name="cardnum"
										id="cardnum" style="width: 110px;" type="text"></td>
								</tr>
								<tr>
									<td align="center" height="25px">电话号</td>
									<td align="center" height="25px"><input name="bindtel"
										id="bindtel" style="width: 110px;" type="text"></td>
								</tr>
								<tr>
									<td align="center" height="25">状态</td>
									<td align="center" height="25"><select name="cardstatus"
										id="cardstatus" style="width: 110px;">
											<option value="4">全部</option>
											<option value="0">未激活</option>
											<option value="1">已激活</option>
											<option value="2">已使用</option>
											<option value="3">已锁定</option>
									</select></td>
								</tr>
								<tr>
									<td align="center" height="25">金额</td>
									<td align="center" height="25"><input name="money"
										id="money" style="width: 110px;" type="text"></td>
								</tr>
								<tr>
									<td align="center" height="25">
										<?php
 if ($_SESSION['power']!=3) { echo '
																				
																				代理商
																				</td>
																				<td align="center"  height="25">
																				<select name="accountid" id="accountid" style="width:110px;">
																				<option value="0">全部</option>
																				'; foreach ($accountdata as $key => $value) { echo '<option value="'.$key.'">'.$value.'</option>'; } echo '</select>'; } ?>
									</td>
								</tr>
								<tr>
									<td align="center" height="25">生成日期:</td>
									<td align="center" height="25"><input name="createtime"
										id="createtime" style="width: 110px;" type="text"></td>
								</tr>
								<tr>
									<td colspan="2">日期格式： &nbsp;<?php echo date('Y-m-d',time());?>
									</td>

								</tr>
								<tr>
									<td colspan="2" align="center" height="25">
									 <input name="Button2" value="查询" id="Button2" style="width: 40px;" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;
									 <input name="Button3" value="导出" id="Button3" style="width: 40px;" type="submit">
									 
									 
									 
									 
									</td>
								</tr>
							</tbody>
						</table>
					</form>
					<br/>
			        <br/>
				</div>



				<!--- ------------------------第三块-------------------------------->

				<div>

					<!--现在还没有用-->
					<!--
									<h4 onclick="domenu(this, 'list31')" class="tit">--账号管理--</h4>
									<ul id="list31" >
										
									</ul>-->


					<?php
 if($_SESSION['power']!=3) { echo '<h4 onclick="domenu(this, \'list33\')" class="tit">--代理商管理--</h4>
													  <ul id="list33">
															<li><a class="list"  href="__APP__/Authority/addaccount"  target="main">代理商添加</a></li>
															<li><a class="list"  href="__APP__/Authority/updateaccount" target="main">代理商管理</a></li>
															<li><a class="list"  href="__APP__/ChargeLog/index" target="main">充值记录管理</a></li>'; echo '</ul>'; } ?>

					<h4 onclick="domenu(this, 'list42')" class="tit">--账号资料管理--</h4>
					<ul id="list42">
						<li><a class="list" href="__APP__/Queryuser/index?id=1"
							target="main"> 已过期账号</a></li>
						<li><a class="list" href="__APP__/Queryuser/index?id=2"
							target="main">本月过期账号</a></li>
						<li><a class="list" href="__APP__/Queryuser/index?id=3"
							target="main">三个月未用的账号</a></li>
						<li><a class="list" href="__APP__/Queryuser/index?id=4"
							target="main">余额为零的账号</a></li>
					</ul>

					<?php  if($_SESSION['power']==1) { echo '<h4 onclick="domenu(this, \'list43\')" class="tit">--呼转号码管理--</h4>
											  <ul id="list43">
										         <li><a class="list" href="__APP__/Calltransfernum/index" target="main">呼转号码管理</a></li> 
										         
											  </ul>'; } ?>

					<?php  if($_SESSION['power']==1) { echo '<h4 onclick="domenu(this, \'list44\')" class="tit">--黑名单管理--</h4>
											  <ul id="list44">
										         <li><a class="list" href="__APP__/Blackcallednum/index" target="main">被叫黑名单管理</a></li> 
 												<li><a class="list" href="__APP__/Opencard/index" target="main">开户黑名单管理</a></li> 
											  </ul>'; } ?>

					<br />

					<hr size=2
						style="color: blue; border-style: dotted; width: 490px; color: #CCC">

					<form action="__APP__/Queryphone/index" method="post" name=""
						target="main">

						<table width="100%" border="0" align="center" cellspacing="1"
							cellpadding="0"
							style="margin: 5px; font: 12px Verdana, Arial, Helvetica, sans-serif;">
							<tbody>
								<tr>
									<td colspan="2" align="center" height="25px">电话查询</td>
								</tr>

								<tr>
									<td align="center" height="25px">电话</td>
									<td align="center" height="25px"><input name="bindtel"
										id="bindtel" style="width: 110px;" type="text"></td>
								</tr>


								<tr>
									<td colspan="2" align="center" height="25"><input
										name="Button2" value="查询" id="Button2" style="width: 56px;"
										type="submit"></td>
								</tr>
							</tbody>
						</table>
					</form>
					<hr size=2
						style="color: blue; border-style: dotted; width: 490px; color: #CCC">
				</div>

			</div>


			<script>
				//switchmenu('optionmenu','menulist',0);
			</script>
		</div>



	</div>
</body>
</html>