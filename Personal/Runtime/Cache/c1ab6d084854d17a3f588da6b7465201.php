<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	


		<script type="text/javascript">

							function checkfield()
							{   
								var rechargetel=$('#rechargetel').val();
								var cardnum=$('#cardnum').val();	
								var cardpwd=$('#cardpwd').val();
								$('#rechargetelmsg').html("");
								$('#cardnummsg').html("");
								$('#cardpwdmsg').html("");

								//alert(pwd2);

								//alert(newpwd);

								if (cardnum==null||cardnum=="") {
									
									$('#cardnum').focus();
									//alert("新密码不能为空");
									$('#cardnummsg').html("充值卡号码不能为空!");
									 return false;
								}
								else
								{
									if(cardnum.length!=8&&cardnum.length!=6)
									{
										$('#cardnummsg').html("充值卡号为八位或六位。");
										return false;
									}

								}

								if (cardpwd==null||cardpwd=="") {
									
									$('#cardpwd').focus();
									//alert("新密码不能为空");
									$('#cardpwdmsg').html("卡密码不能为空!");
									 return false;
								}
								else
								{
									if(cardpwd.length!=6)
									{
										$('#cardpwdmsg').html("卡密码为六位。");
										return false;

									}

								}

								if (rechargetel==null||rechargetel=="") {
									
									$('#cardpwd').focus();
									//alert("新密码不能为空");
									$('#cardpwdmsg').html("卡密码不能为空!");
									 return false;
								}
								else
								{
									 var regPartton=/1[3-8]+\d{9}/;
						   	    	 var regPartton1=/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/;
									
									if(rechargetel.length!=11)
									{
										$('#rechargetelmsg').html("手机号码为11位。");
										return false;
									}
									else if(!(regPartton.test(rechargetel)||(regPartton1.test(rechargetel))))
									{  					        	     
											alert("手机号码格式不正确！");
											$('#rechargetelmsg').html("手机号码格式不正确！");
											return false;
									}

								}


								
								
                                 ajaxcardcheck();
							}

					function ajaxcardcheck(){

						  $.post(
						  	"__APP__/Allrecharge/recharge",

						  	{rechargetel:$("#rechargetel").val(),cardnum:$('#cardnum').val(),cardpwd:$('#cardpwd').val()},

						    function(data){
						    
						    if (data['status']=="success") {

						    	alert(data['message']);
						    	//console.log(data['message']);
						    	window.parent.frames[1].location.reload();

						    }else if (data['status']=="failed") 
						    {
						    	alert(data['message']);

						    }
						  },
						   "json");//这里返回的类型有：json,html,xml,text


						}
				



		</script>
	</head>
	
	<body>
		<div id="main" width="60%">

		    <div class='head-dark-box'>
					<div class='tit'>充值卡充值></div>
			</div>	
			
			<table cellpadding="0" cellspacing="1" align="center" bgcolor="#B5C7DE" border="0" width="500px" style="font:12px Verdana, Arial, Helvetica, sans-serif">
		         <tbody>
		            <tr>
		                <td colspan="2" align="center" bgcolor="#E5E5E5" height="30">
		                    <span style="font-size: 10pt;"><strong>充值卡充值</strong></span></td>
		            </tr>
		            <tr>
		                <td align="right" bgcolor="#FFFFFF" height="25" width="100">
		                    <span style="font-size: 9pt">被充值号码：</span></td>
		                <td align="left" bgcolor="#FFFFFF">
		              &nbsp;&nbsp;&nbsp;<input name="rechargetel"  id="rechargetel"  maxlength="12"   style="width:133px;" type="text" value="<?php echo $phonenum; ?>"> <span id="rechargetelmsg" style="color:red;"></span></td>

		            </tr>
		            <tr>
		                <td align="right" bgcolor="#FFFFFF" height="25"><span style="font-size: 9pt">充值卡号码：</span></td>
		                <td align="left" bgcolor="#FFFFFF">
		              &nbsp;&nbsp;&nbsp;<input name="cardnum" maxlength="18" id="cardnum"  style="width:133px;" type="text"><span id="cardnummsg" style="color:red;"></span></td>
		            </tr>
		            <tr>
		                <td align="right" bgcolor="#FFFFFF" height="25">
		                    <span style="font-size: 9pt">充值卡密码：</span></td>
		                <td align="left" bgcolor="#FFFFFF">
		               &nbsp;&nbsp;&nbsp;<input name="cardpwd" maxlength="18" id="cardpwd"  style="width:133px;" type="password"><span id="cardpwdmsg" style="color:red;"></span></td>
		            </tr>
		            <tr>
		                <td colspan="2" align="center" bgcolor="#FFFFFF" height="30">
		              <input name="Button2" value="充值" id="Button2" style="color:#284E98;background-color:White;border-color:#507CD1;border-width:1px;border-style:Solid;font-size:9pt;" onclick="checkfield()" type="button">
						&nbsp;&nbsp;&nbsp;&nbsp;
		              <input name="Button2" value="返回" id="Button2" style="color:#284E98;background-color:White;border-color:#507CD1;border-width:1px;border-style:Solid;font-size:9pt;" onclick="window.location.href='__APP__/Login/index'" type="button"></td>
		            </tr>
		      </tbody>
		    </table>


				

	         <br/><br/><br/>
	       </div>
		
		<br/><br/><br/><br/><br/>
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>

	</body>
</html>