<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	

		<script>
				
					function checkfield(){
						  
						  if($('#startcardnum').val() == ""){
							
						    $('#msg').html("请输入起始账号!");
						    $('#startcardnum').focus;
						    return false;
						  }
						  
						  if($('#stopcardnum').val() == ""){
						    $('#msg').html("请输入结束账号");
						    $('#stopcardnum').focus;
						    return false;
						  }
						   ajaxcardcheck();
						}


						function ajaxcardcheck(){

						  $.post("__APP__/Transfercard/checkcardstatus",
						  	{startcardnum:$('#startcardnum').val(),stopcardnum:$('#stopcardnum').val(),accountid:$('#accountid').val()},

						  function(data){
						    
						    if (data['status']=="success") {
						    	alert("卡号下发成功");
						    }else if (data['status']=="failed") 
						    {
						    	alert("该号码段内没有卡");
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
					<div class='tit'>内容管理>账号卡管理>卡号下发代理商</div>
			</div>	
<!--action="__APP__/Transfercard/transfer"-->

							<table style="margin-top:0px;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="85%">
                                  <tbody>
                                    <tr>
                                        <td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4">
                                            &nbsp;帐号下发
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
                                            <input name="submit" value="划归" id="submit" style="height:22px;" onclick="return checkfield()" type="submit">到代理商：
	                                       
	                                        <select name="accountid" id="accountid">											
												<?php
 foreach ($accountdata as $key => $value) { echo '<option value="'.$key.'">'.$value.'</option>'; } ?>													
											</select>
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