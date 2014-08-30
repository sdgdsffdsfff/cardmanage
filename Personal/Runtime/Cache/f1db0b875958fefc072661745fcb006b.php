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
								var fromtel=$('#fromtel').val();
								var calledtel=$('#calledtel').val();

								$('#calledtelmsg').html("");

								//alert(pwd2);
								if (calledtel==null||calledtel=="") {
									
									$('#calledtel').focus();
									//alert("新密码不能为空");
									$('#calledtelmsg').html("被叫号码不能为空!");
									 return false;
								}
								else
								{
									 //return false;
						        	 var str=$('#calledtel').val();
						        	 //alert($("#telemsg").html());
						        	 // $('#telemsg').innerHTML="手机号码不能为空！";
						        	 var regPartton=/1[3-8]+\d{9}/;
						        	 var regPartton1=/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/;
						        	 if(!(regPartton.test(str)||regPartton1.test(str))){
											$('#calledtelmsg').html("手机号码格式不正确！");
											
											return false;
										}else{
											$('#calledtelmsg').html("");
										}
								}							  
                                ajaxcall();
							}

					function ajaxcall(){

						  $.post(
						  	"__APP__/Makeappo/call",

						  	{fromtel:$("#fromtel").val(),calledtel:$('#calledtel').val()},

						    function(data){
						    
						    if (data['status']=="success") {

						    	alert(data['message']);

						    	//console.log(data['message']);

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
		<div id="main">

		    <div class='head-dark-box'>
					<div class='tit'>内容管理>充值卡充值></div>
			</div>	


		  <table width="400" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B5C7DE" style="font:12px Verdana, Arial, Helvetica, sans-serif">
            <tbody><tr>
                <td align="center" bgcolor="#E5E5E5" class="STYLE2" colspan="2" height="30">
                    网上拨打电话</td>
            </tr>
            <tr>
                <td width="100" height="25" align="right" bgcolor="#FFFFFF">
                    <span style="font-size: 9pt">回呼号码：</span></td>
                <td bgcolor="#FFFFFF">
                  <input name="fromtel" type="text"   value="<?php echo $phonenum; ?>" maxlength="13" disabled id="fromtel" onkeypress="javascript:return event.keyCode&gt;=48&amp;&amp;event.keyCode&lt;=57;" style="font-size:9pt;width:130px;">
                    <font color="red">*</font>
                </td>
            </tr>

            <tr>
                <td width="100" height="25" align="right" bgcolor="#FFFFFF" valign="top">
                    <span style="font-size: 9pt">
                        <br>
                        被叫号码：</span></td>
                <td bgcolor="#FFFFFF">
                    <input name="calledtel" type="text"  maxlength="200" id="calledtel"  style="font-size:9pt;width:130px;"><span style="color:red;" id="calledtelmsg"></span></td>
            </tr>
           
            <tr>
                <td height="30" colspan="2" align="center" bgcolor="#FFFFFF">
                    &nbsp;
                    <input type="submit" name="Button2" value="立即呼叫" id="Button2" onclick="checkfield()" style="color:#284E98;background-color:White;border-color:#507CD1;border-width:1px;border-style:Solid;font-family:Verdana;font-size:9pt;height:22px;">
                    &nbsp;
                    &nbsp;
                    &nbsp;
              </td>
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