<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	

		<script>
				
					function checkfield(type){
						  
						  $('#msg').html('');
						  $('#statustable').html('');

						  if($('#startcardnum').val() == ""){
							
						    $('#msg').html("请输入起始账号!");
						    $('#startcardnum').focus();
						    return false;
						  }
						  
						  if($('#stopcardnum').val() == ""){
						    $('#msg').html("请输入结束账号");
						    $('#stopcardnum').focus();
						    return false;
						  }
						  if(isNaN($('#startcardnum').val())){
						     $('#msg').html("起始账号请输入数字!");
						     $('#startcardnum').focus();
						     return false;
						  }
						  if(isNaN($('#stopcardnum').val())){
						     $('#msg').html("结束账号请输入数字!");
						     $('#startcardnum').focus();
						     return false;
						  }
						   ajaxcardcheck(type);
						}


						function ajaxcardcheck(type){
							//alert('dsadsa');
							//alert(type);
						  $.post("__APP__/Changecdstatus/changecdstatus",
						  	{startcardnum:$('#startcardnum').val(),stopcardnum:$('#stopcardnum').val(),type:type},

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
							    alert("操作失败");
						    }
						  },
						   "json");//这里返回的类型有：json,html,xml,text
						}
				

		</script>

	</head>
	
	<body>
		<div id="main">

		    <div class='head-dark-box'>
					<div class='tit'>内容管理>账号卡管理>批量修改流量卡状态</div>
			</div>	
<!--action="__APP__/Transfercard/transfer"-->
                           <br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table style="margin-top:0px;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="85%">
                                  <tbody>
                                    <tr>
                                        <td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4">
                                            &nbsp;流量卡状态修改
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:350px; height: 25px" align="left" bgcolor="#ffffff">
 
                                            起始帐号：<input name="startcardnum" maxlength="20" id="startcardnum" style="width:80px;" type="text">
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                          
                                            结束帐号：<input name="stopcardnum" maxlength="20" id="stopcardnum" style="width:80px;" type="text">
                                       
										  </td>
                                        <td style="height: 25px" align="left" bgcolor="#ffffff">
                                            将该号段的卡
                                            <input name="submit" value="激活" id="submit1" style="height:22px;" onclick="return checkfield(1)" type="submit">
	                                        <input name="submit" value="锁定" id="submit2" style="height:22px;" onclick="return checkfield(2)" type="submit">
											<span style="color:red" id="msg"></span>										                                        
									   </td>
                                    </tr>
                                </tbody>
                              </table>
				  <br/><br/>

				  <div> 
				        <table id="statustable" style="color:red; font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center"  width="60%">
				           

				        </table><br/><br/><br/>
				  </div>

		</div>
		<br/><br/><br/><br/><br/>
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>

	</body>
</html>