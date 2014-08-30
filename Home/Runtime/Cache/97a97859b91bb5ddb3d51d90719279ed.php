<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	

		<script>
					
					function checkfield()
					{	
						 //alert('dsadas');
						      var tele = $('#tele').val();


					   	       if($('#tele').val() == "")
					   	       {
					   	       	      alert("手机号码不能为空！");
					   	       	      return false;
					   	       }
					   	       else
					   	       {

					   	    		var str=$('#tele').val();
					   	    	    var regPartton=/1[3-8]+\d{9}/;
					   	    	    var regPartton1=/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/;
					        	    if(!(regPartton.test(str)||regPartton1.test(str)))
					        	    {
										alert("联系电话格式不正确！");
										$('#tele').focus();
										return false;
									}
								}

								if ($('#loginname').val=="") {

											alert("代理商名不能为空");
											return false;
								}

								if ($('#loginpwd').val=="") {

											alert("密码不能为空");
											return false;
								}
								else
								{
									 var pwd=$('#loginpwd').val();
									 if(pwd.length<6)
									 {
									 	 alert("密码过于简单，请更换密码");
									 	 return false;
									 }
								}

								if ($('#authority').val=="") {
										alert("用户名不能为空");
										return false;
								}
					}

		</script>

	</head>
	
	<body>

		<div id="main">
		    <div class='head-dark-box'>
					<div class='tit'>账号管理>代理商管理>添加代理商</div>
			</div>	
				  
		     <div>

		<form id="form1" action="addaccountdata" method="post" name="form1">
			<table  id="addacctable"  style="width:60%;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc">

				<tbody>
					<tr>
						<td  colspan="4" align="left" bgcolor="#f4f4f4" height="25">
						<b>&nbsp;</b><strong>添加代理商</strong></td>
					</tr>
					<tr>
						<td    class="lefttd" align="center" bgcolor="#f4f4f4" height="25" width="10%">
						帐号</td>
						<td  colspan="3" align="left" bgcolor="#ffffff" height="25" width="35%">
						&nbsp;<input name="loginname" maxlength="20" id="loginname" style="width:100px;" type="text"></td>
						
					</tr>
					<tr>
						<td class="lefttd" align="center" bgcolor="#f4f4f4" height="25">
							密码
						</td>
						<td align="left" bgcolor="#ffffff" height="25">
							&nbsp;<input name="loginpwd" id="loginpwd" style="width:100px;" type="text"></td>			
					</tr>
					<tr>
						
						<td class="lefttd" align="center" bgcolor="#f4f4f4" height="25">
						联系电话</td>
						<td  colspan="3" align="left" bgcolor="#ffffff" height="25">
							&nbsp;<input name="tele" id="tele" style="width:100px;" type="text">
						</td>
					</tr>
					<tr>
						<td class="lefttd" align="center" bgcolor="#f4f4f4" height="25">
						状态
						</td>
						<td colspan="3" bgcolor="#ffffff">
							<table id="Status" style="width:110px; font: 12px Verdana,Arial,Helvetica,sans-serif;" border="0">
								<tbody>
								<tr>
									<td>
									<input id="Status2" name="status" value="2" type="radio"><label for="Status2">锁定</label></td>
									<td>
									<input id="Status1" name="status" value="1" checked="checked" type="radio"><label for="Status1">开通</label>
									</td>
							    </tr>
						       </tbody>
						  </table>
					  </td>		
					</tr>
				<tr>
					<td class="lefttd" align="center" bgcolor="#f4f4f4" height="80">
					操作权限
					</td>
					<td colspan="3" bgcolor="#ffffff">

					
					<?php
 if ($_SESSION['authority']['up_bindtel']==1) { echo '<span style="display:inline-block;width:120px;">
		                         <input id="CheckBox1" name="authority[]" value="up_bindtel" type="checkbox"><label for="CheckBox1">修改绑定电话</label>
		                         </span>'; } if ($_SESSION['authority']['up_cardpwd']==1) { echo '<span style="display:inline-block;width:120px;">
								  <input id="CheckBox2" name="authority[]" value="up_cardpwd" type="checkbox"><label for="CheckBox2">修改帐号卡密码</label>
								  </span>'; } if ($_SESSION['authority']['man_cardstatus']==1) { echo '<span style="display:inline-block;width:120px;">
								<input id="CheckBox4" name="authority[]" value="man_cardstatus"type="checkbox"><label for="CheckBox4">帐号卡状态管理</label>
								</span>'; } if ($_SESSION['authority']['up_userexpirydate']==1) { echo '<span style="display:inline-block;width:120px;">
								<input id="CheckBox3" name="authority[]" value="up_userexpirydate" type="checkbox"><label for="CheckBox3">修改帐号有效期</label></span>'; } if ($_SESSION['authority']['up_cardmoney']==1) { echo '<span style="display:inline-block;width:120px;">
								<input id="CheckBox5" name="authority[]" value="up_cardmoney"type="checkbox"><label for="CheckBox5">修改帐号金额</label>
								</span>'; } echo '<br>'; if ($_SESSION['authority']['chk_billrecord']==1) { echo '<span style="display:inline-block;width:120px;">
							<input id="CheckBox10" name="authority[]" value="chk_billrecord"type="checkbox"><label for="CheckBox10">查看用户话单</label>
							</span>'; } if ($_SESSION['authority']['count_data']==1) { echo '<span style="display:inline-block;width:120px;">
							<input id="CheckBox11" name="authority[]" value="count_data"type="checkbox"><label for="CheckBox11">数据统计</label>
							</span>'; } if ($_SESSION['authority']['transfer_card']==1) { echo '<span style="display:inline-block;width:120px;">
							<input id="CheckBox12" name="authority[]" value="transfer_card"type="checkbox"><label for="CheckBox12">转移卡到代理商</label>
		     				</span>'; } ?>
					
					</td>
				</tr>
				<tr>
			    	<td class="lefttd" align="center" bgcolor="#f4f4f4" height="80">
					  备注:
					</td>
					<td colspan="3" bgcolor="#ffffff">	
								<textarea name="remark"  style="width:100%;height:130px"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="4" style="height: 25px" align="center" bgcolor="#ffffff">
					<input name="Button1" value="添加" id="Button1"  onclick="return checkfield() " style="width:60px;" type="submit">&nbsp;				
					</td>
				</tr>
				</tbody>
			</table>
		</form>


		     </div>
		</div>





		
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>
	</body>
</html>