<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		
		<title>MyCMS管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		<script src="__PUBLIC__/js/common.js" charset="utf-8"></script>


		<script type="text/javascript">

				function switchmenu(menutitle, menulist, num){	
					var mTitleObj=document.getElementById(menutitle);
					var tlist=document.getElementById("menulist");
					var mlist=tlist.getElementsByTagName("div");
					//alert(mTitleObj.innerText);
					
					switch(num){
						case 0: mTitleObj.innerText ="系统管理"; break;
						case 1: mTitleObj.innerText ="内容管理"; break;
						case 2: mTitleObj.innerText ="用户管理"; break;
					}

					for(var i=0; i<mlist.length; i++){
						if(i==num){
							mlist[num].style.display="block";
						}else {
							mlist[i].style.display="none";
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
													<li class="opt">
														<a href="main" onclick="switchmenu('optionmenu','menulist',0)" target="main">
														<img onmouseover="cimg(this, '__PUBLIC__/images/system_h.gif')" onmouseout="cimg(this, '__PUBLIC__/images/system_d.gif')" border="0" src="__PUBLIC__/images/system_d.gif"><br/>
														 系统管理</a>
													</li>
													<li class="opt">
														<a href="main" onclick="switchmenu('optionmenu','menulist',1)" target="main">
														<img onmouseover="cimg(this, '__PUBLIC__/images/article_h.gif')" onmouseout="cimg(this, '__PUBLIC__/images/article_d.gif')" border="0" src="__PUBLIC__/images/article_d.gif"><br/>
														内容管理</a>
													</li>
													<li class="opt">	
														 <a href="main" onclick="switchmenu('optionmenu','menulist',2)" target="main">
														 <img onmouseover="cimg(this, '__PUBLIC__/images/user_h.gif')" onmouseout="cimg(this, '__PUBLIC__/images/user_d.gif')" border="0" src="__PUBLIC__/images/user_d.gif"><br/>
														 账号管理</a>
													</li>
												</ul>
									 </div>
						</div>


			<div class="nav"> </div>
			<div class="option">

				<div id="optionmenu" class="menutitle">管理选项</div>


				<div id="menulist" class="content"> 

                                    <!-------------------------第一块选项---------------------------------------->

                                    <!-------------------------以后添加---------------------------------------------->

							    	<div >					
									<h4 onclick="domenu(this, 'list1')" class="tit">--常规设置--</h4>
									<ul id="list1">
										<li><a class="list" href="__APP__/SysInfo/show" target="main" method=post>系统信息</a></li>
									    <li><a class="list" href="__APP__/SysInfo/set"  target="main" method=post>系统设置</a> </li> 
									</ul>
									<!--
									<h4 onclick="domenu(this, 'list2')" class="tit">--友情链接管理--</h4>
									<ul id="list2">
										<li><a class="list" href="__APP__/Flink/add" target="main">添加友情链接</a></li>
										<li><a class="list" href="__APP__/Flink/index" target="main">管理友情链接</a></li>
									</ul>-->
								   </div>
						

                              <!--- ------------------------第二块-------------------------------->
							  <div style="display:block">							   			
	     							<h4 onclick="domenu(this, 'list21')" class="tit">--账号卡管理--</h4>
									<ul id="list21">
										<li><a class="list" href="__APP__/Cat/add" target="main" title="修改账号卡绑定电话 密码 状态 有效期  通话详单 余额">管理账号卡资料</a></li>
											

										<?php
 if(($_SESSION['power']!=3)&&($_SESSION['authority']['transfer_card']==1)) { echo '<li><a class="list" href="__APP__/Transfercard/index" target="main">卡号下发代理商</a></li>'; } ?>	
										

									</ul>
									


								 <h4 onclick="domenu(this, 'list22')" class="tit">--账号卡管理--</h4>
									<ul id="list22">
									       <?php
 if($_SESSION['authority']['man_cardstatus']==1){ echo '<li><a class="list" href="__APP__/Cat/index" target="main">修改账号卡状态</a></li>'; } if($_SESSION['authority']['up_cardpwd']==1) { echo '<li><a class="list" href="__APP__/Cat/index" target="main">重置账号卡密码</a></li>'; } ?>									       		        
									</ul>

								<h4 onclick="domenu(this, 'list23')" class="tit">--数据查询--</h4>
									<ul id="list23">

					                 <?php
 if ($_SESSION['authority']['count_data']==1) { echo '<li><a class="list"  href="__APP__/Article/index"  target="main">数据统计</a></li>'; } ?>
							  					

						  <!--form表单---------->
								<form  action="__APP__/Querycard/index"  method="post"    name="" target="main">							         	

										<table width="100%" border="0"  align="center"  cellspacing="1" cellpadding="0" style="margin:5px;font:12px Verdana,Arial,Helvetica,sans-serif;">
												<tbody>
														<tr>
															<td colspan="2" align="center"  height="25px">
															帐号卡查询</td>
														</tr>
														<tr>
															<td align="center"  height="25px">
															 帐号
															 </td>
															<td align="center"  height="25px"><input name="schAccount" id="schAccount" style="width:110px;" type="text"></td>
														</tr>
														<tr>
															<td align="center"  height="25px"> 
															    电话
															</td>
															<td align="center"  height="25px">
															   <input name="schMobile" id="schMobile" style="width:110px;" type="text">
															</td>
														</tr>
														<tr>
															<td align="center"  height="25">
															状态</td>
															<td align="center"  height="25">

																<select name="schState" id="schState" style="width:110px;">
																<option value="">全部</option>
																<option value="0">未激活</option>
																<option value="1">已激活</option>
																<option value="2">已使用</option>
																<option value="4">已锁定</option>
																</select>
																</td>
														</tr>
														<tr>
															<td align="center"  height="25">
															金额</td>
															<td align="center"  height="25">
														<input name="schBalance" id="schBalance" style="width:110px;" type="text"></td>
														</tr>
														<tr style="display: none;" id="tr3">
															<td align="center"  height="25">
															</td>
															<td align="center"  height="25">
															</td>
														</tr>
														<tr>
															<td colspan="2" align="center"  height="25">
															<input name="Button2" value="查询" id="Button2" style="width:56px;" type="submit"></td>
														</tr>
												</tbody>
										</table>
					 		 </form>

								</ul>
								</div>

								
								<!--- ------------------------第三块-------------------------------->

								<div>
									
									<!--现在还没有用-->
									<h4 onclick="domenu(this, 'list31')" class="tit">--账号管理--</h4>
									<ul id="list31">
										<?php
 if($_SESSION['authority']['up_userexpirydate']==1) { echo '<li><a class="list" href="__APP__/Cat/index" target="main">修改账号有效期</a></li>'; } ?>
									

									<!--   还没有定下来的   -->
							    	<li><a class="list" href="__APP__/Admin/adminSet" target="main">管理员设置</a></li> 
									<li><a class="list" href="__APP__/Admin/addUser" target="main">添加用户</a></li>
									<li><a class="list" href="__APP__/Admin/indexUser" target="main">管理用户</a></li>
									</ul>

									<h4 onclick="domenu(this, 'list33')" class="tit">--代理商管理--</h4>
									<?php
 if($_SESSION['power']!=3) { echo '
													  <ul id="list33">
															<li><a class="list"  href="__APP__/Authority/updateaccount" target="main">代理商修改</a></li>
															<li><a class="list"  href="__APP__/Authority/addaccount"  target="main">代理商添加</a></li>
															<li><a class="list"  href="__APP__/Authority/deleteaccount"  target="main">代理商删除</a></li>		
													  </ul>'; } ?>

			

									<h4 onclick="domenu(this, 'list32')" class="tit">--本账号管理--</h4>
									<ul id="list32">
							    	<li><a class="list" href="__APP__/Admin/adminSet" target="main">修改密码</a></li> 
									</ul>

								</div>


					<script>
						//switchmenu('optionmenu','menulist',0);
					</script>				
			</div>

			

		</div>
	</body>
</html>