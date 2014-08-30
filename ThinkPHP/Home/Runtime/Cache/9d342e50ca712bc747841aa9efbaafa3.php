<?php if (!defined('THINK_PATH')) exit();?>
<html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	

		<script>
					//表单验证实现
		</script>

	</head>
	
	<body>

		<div id="main">
		    <div class='head-dark-box'>
					<div class='tit'>账号管理>代理商管理>代理商修改</div>
			</div>	
				  
		     <div>

		<form id="form1" action="updateacc" method="post" name="form1">
			<table  id="addacctable"  style="width:60%;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc">

				<tbody>
					<tr>
					<?php
 ?>
						<td  colspan="4" align="left" bgcolor="#f4f4f4" height="25">
						<b>&nbsp;</b><strong>修改代理商</strong></td>
					</tr>
					<tr>
						<td    class="lefttd" align="center" bgcolor="#f4f4f4" height="25" width="10%">
						帐号</td>
						<td  colspan="3" align="left" bgcolor="#ffffff" height="25" width="35%">
						&nbsp;<input name="loginname" readonly maxlength="20" id="loginname" style="width:100px;" value="<?php echo $accountdata[0]['loginname']?>" type="text">（不能全为数字）</td>

						<input type="hidden" value="<?php echo $accountdata[0]['id']?>" name='id'>
						
					</tr>
					<tr>
						<td class="lefttd" align="center" bgcolor="#f4f4f4" height="25">
							密码
						</td>
						<td align="left" bgcolor="#ffffff" height="25">
							&nbsp;<input name="loginpwd" id="loginpwd" value="<?php echo $accountdata[0]['loginpwd']?>" style="width:100px;" type="text"></td>			
					</tr>
					<tr>
						
						<td class="lefttd" align="center" bgcolor="#f4f4f4" height="25">
						联系电话</td>
						<td  colspan="3" align="left" bgcolor="#ffffff" height="25">
							&nbsp;<input name="tele" id="tele" value="<?php echo $accountdata[0]['tele']?>" style="width:100px;" type="text">
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
									
									<?php
 if($accountdata[0]['status']==1) { echo '<td>
												<input id="Status2" name="status" value="2" type="radio">
												<label for="Status2">锁定</label>
												</td>
												<td>
												<input id="Status1" name="status" value="1" checked="checked" type="radio">
												<label for="Status1">开通</label>
												</td>'; } else { echo '<td>
												<input id="Status2" name="status" checked="checked" value="2" type="radio">
												<label for="Status2">锁定</label>
												</td>
												<td>
												<input id="Status1" name="status" value="1"  type="radio">
												<label for="Status1">开通</label>
												</td>'; } ?>

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
 $power=$powerdata[0]; $authority=$_SESSION['authority']; ?>


						<span style="display:inline-block;width:120px;">

						  <?php
 if ($authority['up_bindtel']==1) { if ($power['up_bindtel']==1) echo '<input id="CheckBox1" name="authority[]" checked value="up_bindtel" type="checkbox"><label for="CheckBox1">修改绑定电话</label></span>'; else echo '<input id="CheckBox1" name="authority[]" value="up_bindtel" type="checkbox"><label for="CheckBox1">修改绑定电话</label></span>'; } if ($authority['up_cardpwd']==1) { if ($power['up_cardpwd']==1) echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox2" name="authority[]" checked value="up_cardpwd" type="checkbox"><label for="CheckBox2">修改帐号卡密码</label>
											  </span>'; else echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox2" name="authority[]"  value="up_cardpwd" type="checkbox"><label for="CheckBox2">
											  修改帐号卡密码</label>
											  </span>'; } if ($authority['up_userexpirydate']==1) { if ($power['up_userexpirydate']==1) echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox3" name="authority[]" checked value="up_userexpirydate" type="checkbox"><label for="CheckBox3">修改账号有效期</label>
											  </span>'; else echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox3" name="authority[]"  value="up_userexpirydate" type="checkbox"><label for="CheckBox3">
											 修改账号有效期</label>
											  </span>'; } if ($authority['man_accstatus']==1) { if ($power['man_accstatus']==1) echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox4" name="authority[]" checked value="man_accstatus" type="checkbox"><label for="CheckBox4">帐号卡状态管理</label>
											  </span>'; else echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox4" name="authority[]"  value="man_accstatus" type="checkbox"><label for="CheckBox4">
											  帐号卡状态管理</label>
											  </span>'; } if ($authority['up_cardmoney']==1) { if ($power['up_cardmoney']==1) echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox5" name="authority[]" checked value="up_cardmoney" type="checkbox"><label for="CheckBox5">修改账号金额</label>
											  </span>'; else echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox5" name="authority[]"  value="up_cardmoney" type="checkbox"><label for="CheckBox5">
											  修改账号金额</label>
											  </span>'; } echo '<br/>'; if ($authority['up_rechcdpwd']==1) { if ($power['up_rechcdpwd']==1) echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox6" name="authority[]" checked value="up_rechcdpwd" type="checkbox"><label for="CheckBox6">重置充值卡密码</label>
											  </span>'; else echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox6" name="authority[]"  value="up_rechcdpwd" type="checkbox"><label for="CheckBox6">
											  重置充值卡密码</label>
											  </span>'; } if ($authority['man_rechcdstatus']==1) { if ($power['man_rechcdstatus']==1) echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox7" name="authority[]" checked value="man_rechcdstatus" type="checkbox"><label for="CheckBox7">充值卡状态管理</label>
											  </span>'; else echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox7" name="authority[]"  value="man_rechcdstatus" type="checkbox"><label for="CheckBox7">
											  充值卡状态管理</label>
											  </span>'; } if ($authority['chk_billrecord']==1) { if ($power['chk_billrecord']==1) echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox8" name="authority[]" checked value="chk_billrecord" type="checkbox"><label for="CheckBox8">查看用户话单</label>
											  </span>'; else echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox8" name="authority[]"  value="chk_billrecord" type="checkbox"><label for="CheckBox8">
											  查看用户话单</label>
											  </span>'; } if ($authority['count_data']==1) { if ($power['count_data']==1) echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox9" name="authority[]" checked value="count_data" type="checkbox"><label for="CheckBox9">数据统计</label>
											  </span>'; else echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox9" name="authority[]"  value="count_data" type="checkbox"><label for="CheckBox9">
											  数据统计</label>
											  </span>'; } if ($authority['transfer_card']==1) { if ($power['transfer_card']==1) echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox10" name="authority[]" checked value="transfer_card" type="checkbox"><label for="CheckBox10">转移卡到代理商</label>
											  </span>'; else echo '<span style="display:inline-block;width:120px;">
											  <input id="CheckBox10" name="authority[]"  value="transfer_card" type="checkbox"><label for="CheckBox10">
											  转移卡到代理商</label>
											  </span>'; } ?>

								

					
					</td>
				</tr>
				<tr>
					<td colspan="4" style="height: 25px" align="center" bgcolor="#ffffff">
					<input name="Button1" value="修改" id="Button1" style="width:60px;" type="submit">&nbsp;				
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