<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	

		<script>
				
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

						  $.post("__APP__/Ratemanage/updatedefaultrate",
						  	{starttime:$('#starttime').val(),stoptime:$('#stoptime').val(),rate:$('#rate').val(),remark:$('#remark').val(),id:$('#id').val()},

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
					<div class='tit'>内容管理>费率管理>修改复式费率</div>
			</div>	
<!--action="__APP__/Transfercard/transfer"-->
          <br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table style="margin-top:0px;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="50%">
                                  <tbody>
                                     <tr>
                                        <td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4">
                                            &nbsp;修改复式费率
                                            <input type="hidden" id="id"  name="id" value="<?php echo $ratedata[0]['id']?>">
                                        </td>
                                     </tr>
                                    <tr >
                                        <td align="center" style="height:25px" align="left" bgcolor="#ffffff">

                  &nbsp; &nbsp; &nbsp;  前&nbsp; &nbsp;
                         <input name="starttime" maxlength="20" id="starttime" style="width:80px;" type="text" value="<?php  echo $ratedata[0]['starttime'];?>">
                                            &nbsp; &nbsp;秒 &nbsp; &nbsp;
                         <input name="stoptime" maxlength="20" id="stoptime" style="width:80px;" type="text" value="<?php  echo $ratedata[0]['endtime']?>">
                                            &nbsp; &nbsp;元 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
	                                        <td align="center" rowspan="2" style="height: 25px"  bgcolor="#ffffff" align="left">   
	                                            <input name="submit" value="修改复式费率"  id="submit" style="height:22px;" onclick="return checkfield()" type="submit">
	                                            <input name="Button2" value="返回" id="Button2" onclick="window.location.href='__APP__/Ratemanage/index'" style="width:60px;" type="button">
												<span style="color:red" id="msg"></span>
										   </td>
                                    </tr>
                                    <tr >
                                        <td align="center"  height: 25px" align="left" bgcolor="#ffffff">
 
                         &nbsp; &nbsp; &nbsp; 后&nbsp; &nbsp;
                         <input name="starttime" maxlength="20" id="starttime" style="width:80px;" type="text" value="<?php  echo $ratedata[0]['starttime'];?>">
                                            &nbsp; &nbsp;秒 &nbsp; &nbsp;
                                          
                         <input name="stoptime" align="center"  maxlength="20" id="stoptime" style="width:80px;" type="text" value="<?php  echo $ratedata[0]['endtime']?>">
                                            &nbsp; &nbsp;元 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
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