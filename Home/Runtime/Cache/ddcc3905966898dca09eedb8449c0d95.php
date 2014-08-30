<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>管理平台</title>
<meta name="Author" content="赵兴壮" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css">

<script src="__PUBLIC__/js/common.js"></script>
<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>


<script type="text/javascript">
			   				
						   	
					   function checkfield()
					   {	
					   	    //alert('dsadas');
					   	    if($('#bindtel').val()!=""){

					   	    		var str=$('#bindtel').val();
					   	    	    var regPartton=/1[3-8]+\d{9}/;
					   	    	     var regPartton1=/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/;
					        	  if(!(regPartton.test(str)||(regPartton1.test(str)))){
										alert("手机号码格式不正确！");
										$('#bindtel').focus();
										return false;
									}
						  }
						  

						  if($('#cardpwd').val() != "")
						  {
							  	 var pwd= $('#cardpwd').val();
							     if(pwd.length!=6)
							     {
							     	alert("密码长度为六位");
							     	$('#cardpwd').focus();
							        return false;
							     }
							     if(isNaN(pwd)){
							         alert("密码请输入数字!");
							     $('#cardpwd').focus();
							     return false;
							    }	    
						  }
							ajaxupdate();
					   }

				    function ajaxupdate()
				    {

						  $.post("__APP__/Querycard/updatecard",
						  	{cardid:$('#cardid').val(),cardpwd:$('#cardpwd').val(),bindtel:$('#bindtel').val(),money:$('#money').val(),remark:$('#remark').val(),status:$('#status option:selected').val()},
						    function(data){
						    
						    if (data['status']=="success") {
						    	alert(data['message']);
						    }else if (data['status']=="failed") 
						    {
						    	alert(data['message']);
						    }
						    else
						    {
							    $('#msg').html(data['status']);
							    //console.log(data);
							    var string="";

							    for (var key in data['message']) {
									    string=string+"<tr><td>"+data['message'][key]+"</td></tr>";
									}
							    $('#statustable').html(string);
						    }
						  },
						   "json");//这里返回的类型有：json,html,xml,text
						}

				   

    	</script>

</head>

<body>
	<div id="main">

		<div class='head-dark-box'>
			<div class='tit'>内容管理>账号卡查询>账号卡信息</div>
		</div>
		<?php
 $carddata=$carddata[0]; ?>
		<table
			style="margin-top: 0px; font: 12px Verdana, Arial, Helvetica, sans-serif;"
			cellspacing="1" align="center" bgcolor="#cccccc" width="70%">
			<tbody>
				<tr>
					<td colspan="4" style="height: 25px" align="left" bgcolor="#f4f4f4">
						&nbsp;帐号卡资料修改</td>
				</tr>
				<tr>
					<input type="hidden" id="cardid"
						value="<?php echo $carddata['id'];?>">
					<td style="height: 25px" align="center" bgcolor="#f4f4f4"
						width="25%">&nbsp;帐号</td>
					<td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
						&nbsp;<input name="TxtAccount"
						value="<?php  echo $carddata['cardnum'];?>" maxlength="20"
						id="TxtAccount" disabled="disabled" style="width: 120px;"
						type="text">
					</td>
					<td style="height: 25px" align="center" bgcolor="#f4f4f4"
						width="25%">&nbsp;电话号码</td>
					<td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
						&nbsp;<input name="bindtel"
						value="<?php  echo $carddata['bindtel'];?>"<?php if ($_SESSION['authority']['up_bindtel']==0) { echo 'disabled'; } ?>
						maxlength="15" id="bindtel" style="width:120px;" type="text">
					</td>
				</tr>
				<tr>
					<td style="height: 25px" align="center" bgcolor="#f4f4f4"
						width="25%">&nbsp;密码</td>
					<td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
						&nbsp;<input name="cardpwd"<?php if ($_SESSION['power']==2 || $_SESSION['power']==3) echo 'disabled'; ?> value="<?php  echo $carddata['cardpwd'];?>"
						<?php  if ($_SESSION['authority']['up_cardpwd']!=1) { echo 'disabled'; } ?> maxlength="6" id="cardpwd" style="width:120px;"
						type="text">
					</td>
					<td style="height: 25px" align="center" bgcolor="#f4f4f4"
						width="25%">&nbsp;余额</td>
					<td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
						&nbsp;<input name="money" value="<?php echo $carddata['money'];?>"
						maxlength="8" id="money" style="width: 120px;" type="text"<?php
 if ($_SESSION['authority']['up_cardmoney']==0 || strlen($carddata['cardnum']) == 6) { echo 'disabled'; } ?> >
					</td>
				</tr>
				<tr>
					<td style="height: 25px" align="center" bgcolor="#f4f4f4"
						width="25%">&nbsp;开通时间</td>
					<td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
						&nbsp;<?php  echo $carddata['opentime'];?>
					</td>
					<td style="height: 25px" align="center" bgcolor="#f4f4f4"
						width="25%">&nbsp;锁定时间</td>
					<td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
						<?php echo $carddata['locktime'];?>
					</td>
				</tr>

				<tr>
					<td style="height: 25px" align="center" bgcolor="#f4f4f4"
						width="25%">充值时间</td>
					<td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
						&nbsp;<span id="TxtApplyDate"> <?php  echo $carddata['filltime'];?>
					</span>
					</td>
					<td style="height: 25px" align="center" bgcolor="#f4f4f4"
						width="25%">状态</td>
					<td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
						&nbsp;<span id="TxtApplyDate"> <?php  ?> <?php
 if ($_SESSION['authority']['man_cardstatus']==1) { echo '<select id="status" style="width:110px;" name="cardstatus">'; if($_SESSION['power']==2 || $_SESSION['power']==3){ switch ($carddata['status']) { case 0: echo '<option value="0" selected>未激活</option>
														    <option value="1">已激活</option>'; break; case 1: echo '<option value="1"selected>已激活</option>'; break; case 2: echo '<option value="2"selected>已使用</option>'; break; default: echo '<option value="3" selected>已锁定</option>'; break; } }else{ switch ($carddata['status']) { case 0: echo '<option value="0" selected>未激活</option>
														    <option value="1">已激活</option>
														    <option value="2">已使用</option>
														    <option value="3">已锁定</option>'; break; case 1: echo '<option value="0" >未激活</option>
														    <option value="1"selected>已激活</option>
														    <option value="2">已使用</option>
														    <option value="3">已锁定</option>'; break; case 2: echo '<option value="0" >未激活</option>
														    <option value="1">已激活</option>
														    <option value="2"selected>已使用</option>
														    <option value="3">已锁定</option>'; break; default: echo '<option value="0" >未激活</option>
														    <option value="1">已激活</option>
														    <option value="2">已使用</option>
														    <option value="3" selected>已锁定</option>'; break; } } echo '</select>'; } else { echo '<select id="status" style="width:110px;" name="cardstatus" disabled>'; switch ($carddata['status']) { case 0: echo '<option value="0" selected>未激活</option>
														    <option value="1">已激活</option>
														    <option value="2">已使用</option>
														    <option value="3">已锁定</option>'; break; case 1: echo '<option value="0" >未激活</option>
														    <option value="1"selected>已激活</option>
														    <option value="2">已使用</option>
														    <option value="3">已锁定</option>'; break; case 2: echo '<option value="0" >未激活</option>
														    <option value="1">已激活</option>
														    <option value="2"selected>已使用</option>
														    <option value="3">已锁定</option>'; break; default: echo '<option value="0" >未激活</option>
														    <option value="1">已激活</option>
														    <option value="2">已使用</option>
														    <option value="3" selected>已锁定</option>'; break; } echo '</select>'; } ?>

					</span>
					</td>
				</tr>

				<tr>
					<td align="center" bgcolor="#f4f4f4" width="25%" colspan="1">备注</td>
					<td bgcolor="#ffffff" colspan="3"><textarea name="remark"
							id="remark" style="width: 100%; height: 150px">
							<?php echo trim($carddata['remark']);?>
						</textarea></td>
				</tr>
				<tr>
					<td colspan="4" style="height: 25px" align="center"
						bgcolor="#f4f4f4"><input name="update" value="修改" id="update"
						onclick="return checkfield()" style="width: 56px;" type="submit">&nbsp;
						<!--<input name="Button5" value="返回" id="Button5" style="width:56px;" onclick="history.back(-1);" type="submit">-->
						<input name="Button5" value="返回" id="Button5" style="width: 56px;"
						onclick="window.location.href='__APP__/upcardpwd/index'"
						type="button"></td>
				</tr>
			</tbody>
		</table>
		<br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br />
		<br />


	</div>

	<br />
	<br />
	<br />
	<br />
	<br />
	<div id="timer">
		<p>
			<span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</p>
	</div>

</body>
</html>