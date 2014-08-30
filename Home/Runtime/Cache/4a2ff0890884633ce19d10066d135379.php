<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>
		<link type="text/css" href="__PUBLIC__/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
		<link type="text/css" href="__PUBLIC__/css/jquery-ui-timepicker-addon.css" rel="stylesheet"/>
		<script type="text/javascript" src="__PUBLIC__/js/jquery-ui-1.8.17.custom.min.js"></script>
		<script type="text/javascript" src="__PUBLIC__/js/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="__PUBLIC__/js/jquery-ui-timepicker-zh-CN.js"></script>

		<script>
			$(document).ready(function() {

				$(".ui_timepicker").datetimepicker({
	                            showSecond: false,
					            showMinute: false,
					            showHour: false,
					            showTime:false,
					            timeFormat: 'hh:mm:ss',
					            stepHour: 1,
					            stepMinute: 1,
					            stepSecond: 1
				})
			});


			function checkfield() {

				$('#msg').html('');
				$('#statustable').html('');

				if ($('#startcardnum').val() == "") {

					$('#msg').html("请输入起始账号!");
					$('#startcardnum').focus();
					return false;
				}

				if ($('#stopcardnum').val() == "") {
					$('#msg').html("请输入结束账号");
					$('#stopcardnum').focus();
					return false;
				}

				if ($('#validityday').val() == "") {
					$('#msg').html("请输入有效期");
					$('#money').focus();
					return false;
				}

				if ($('#expirydate').val() == "") {
					$('#msg').html("请输入充值期限");
					$('#money').focus();
					return false;
				}

				if (isNaN($('#startcardnum').val())) {
					$('#msg').html("起始账号请输入数字!");
					$('#startcardnum').focus();
					return false;
				}
				if (isNaN($('#stopcardnum').val())) {
					$('#msg').html("结束账号请输入数字!");
					$('#startcardnum').focus();
					return false;
				}
				if (isNaN($('#validityday').val())) {
					$('#msg').html("有效期请输入数字!");
					$('#validityday').focus();
					return false;
				}

				ajaxcardcheck();
			}

			function ajaxcardcheck() {

				$.post("__APP__/ProducecardBy/producecard_by", {
					startcardnum : $('#startcardnum').val(),
					stopcardnum : $('#stopcardnum').val(),
					validityday : $('#validityday').val(),
					expirydate : $('#expirydate').val()
				}, function(data) {

					if (data['status'] == "success") {

						alert(data['message']);

					} else if (data['status'] == "failed") {
						alert(data['message']);
					} else {
						$('#msg').html(data['status']);
						//console.log(data);
						var string = "";

						for (var key in data['message']) {
							string = string + "<tr><td>" + data['message'][key] + "</td></tr>";
						}
						$('#statustable').html(string);
					}
				}, "json");
				//这里返回的类型有：json,html,xml,text
			}

		</script>

	</head>

	<body>
		<div id="main">

			<div class='head-dark-box'>
				<div class='tit'>
					内容管理>账号卡管理>批量生成期限卡
				</div>
			</div>
			<!--action="__APP__/Transfercard/transfer"-->
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<table style="margin-top:0px;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="98%">
				<tbody>
					<tr>
						<td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4"> &nbsp;生成期限卡 </td>
					</tr>
					<tr >
						<td style="width:65%;height:25px;" align="left" bgcolor="#ffffff">起始帐号：
						<input name="startcardnum" maxlength="20" id="startcardnum" style="width:50px;" type="text">
						&nbsp;&nbsp;

						结束帐号：
						<input name="stopcardnum" maxlength="20" id="stopcardnum" style="width:50px;" type="text">
						&nbsp; &nbsp;
						有效期:
						<input name="money" maxlength="20" id="validityday" style="width:28px;" type="text">
						天
						&nbsp; &nbsp;
						充值期限:
						<input name="money" maxlength="20" id="expirydate" class="ui_timepicker" style="width:75px;" type="text">
						&nbsp; </td>
						<td style="height: 25px" align="left" bgcolor="#ffffff">
						<input name="submit" value="生成账号卡" id="submit" style="height:22px;" onClick="return checkfield()" type="submit"><span  style="color:red;" id="msg"></span>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="left" bgcolor="#ffffff" style="width:90%; height: 25px;color:red"><span  id="msg">说明：期限卡为一种在有效期内任意使用的一种卡类型，无使用金额限制。卡号固定长度为6位，区别于固定长度为8位流量卡。</span></td>
					</tr>
				</tbody>
			</table>
			<p>
				&nbsp;
			</p>
			<p>
				<br/>
				<br/>

			</p>
			<div>
				<table id="statustable" style="color:red; font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center"  width="60%">

				</table>
				<br/>
				<br/>
				<br/>
			</div>

		</div>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<div id="timer">
			<p>
				<span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</p>
		</div>

	</body>
</html>