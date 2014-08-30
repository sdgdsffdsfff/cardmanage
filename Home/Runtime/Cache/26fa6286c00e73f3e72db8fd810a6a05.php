<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >	
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	
		<script type="text/javascript">

					function checkfield(){
						  
						  $('#msg').html('');
						  $('#statustable').html('');

						  if($('#starttime').val() == ""){

							
						    $('#msg').html("请输入起始时间!");
						    $('#starttime').focus;
						    return false;
						  }
						  else
						  {
						  	if(isNaN($('#starttime').val())){
							     $('#msg').html("起始账号请输入数字!");
							     $('#starttime').focus;
							     return false;
						    }
					
						  	var starttime=$('#starttime').val();
						  	if (starttime.length!=4) 
						  		{
						  		   $('#msg').html("请输入正确的起始时间!");
						           $('#starttime').focus;
						           return false;			 
						  		}
						  }

						  
						  if($('#stoptime').val() == ""){
						    $('#msg').html("请输入结束时间");
						    $('#stoptime').focus;
						    return false;
						  } 
						  else
						  {
						  	if(isNaN($('#stoptime').val())){
							     $('#msg').html("结束账号请输入数字!");
							     $('#stoptime').focus;
							     return false;
						    }
						  	var stoptime=$('#stoptime').val();
						  	if (stoptime.length!=4) 
						  		{
						  		   $('#msg').html("请输入正确的起始时间!");
						           $('#stoptime').focus;
						           return false;			 
						  		}
						  }

						  if($('#money').val() == ""){
						    $('#msg').html("请输入费率");
						    $('#money').focus;
						    return false;
						  }
						   ajaxcardcheck();
						}


						function ajaxcardcheck(){

						  $.post("__APP__/Ratemanage/addrate",
						  	{ ownid:$('#ownid').val(),starttime:$('#starttime').val(),stoptime:$('#stoptime').val(),rate:$('#rate').val(),remark:$('#remark').val()},
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
					<div class='tit'>内容管理>费率管理>费率添加</div>
			</div>	
        
            <br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table style="margin-top:0px;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="80%">
                                  <tbody>
                                    <tr><td colspan="2" bgcolor="#f4f4f4">代理商：<?php echo $loginname;?></td></tr>
                                    <tr>
                                        <td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4">
                                            &nbsp;费率添加 (0700表示7点)
                                            <input type="hidden" id="ownid" value="<?php echo $ownid;?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:700px; height: 25px" align="left" bgcolor="#ffffff">
 
                                            起始时刻：<input name="starttime" maxlength="20" id="starttime" style="width:80px;" type="text">
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                          
                                            结束时刻：<input name="stoptime" maxlength="20" id="stoptime" style="width:80px;" type="text">
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                             费率<input name="rate" maxlength="20" id="rate" style="width:80px;" type="text">元
                                              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                             备注：<input name="remark" id="remark" style="width:80px;" type="text">         
                                          
										  </td>
										  
                                        <td style="height: 25px" align="left" bgcolor="#ffffff">
                                           
                                            <input name="submit" value="添加" id="submit" style="width:60px;" onclick="return checkfield()" type="submit">
                                            <input name="Button2" value="返回" id="Button2" onclick="window.location.href='__APP__/Ratemanage/qubyacc?id=<?php echo $ownid;?>'" style="width:60px;" type="button">

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