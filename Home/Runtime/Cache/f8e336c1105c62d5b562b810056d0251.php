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
					<div class='tit'>内容管理>费率管理>默认费率</div>
			</div>	
<!--action="__APP__/Transfercard/transfer"-->
          <br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table style="margin-top:0px;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="75%">
                                  <tbody>
                                    <tr><td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4">代理商:<?php echo $loginname;?></td></tr>
                                    <tr>
                                        <td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4">
                                            &nbsp;默认费率（0700表示7点）
                                            <input type="hidden" id="id"  name="id" value="<?php echo $defaultratedata[0]['id']?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:70%; height: 25px" align="left" bgcolor="#ffffff">
 
                                            <input name="starttime" maxlength="20" id="starttime" style="width:80px;" type="hidden" value="<?php  echo $defaultratedata[0]['starttime'];?>" readonly >
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                          
                                            <input name="stoptime" maxlength="20" id="stoptime" style="width:80px;" type="hidden" value="<?php  echo $defaultratedata[0]['endtime']?>" readonly>
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                             费率<input name="rate" maxlength="20" id="rate" style="width:80px;" type="text"  value="<?php echo $defaultratedata[0]['fee'];?>">元
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                             备注：<input name="remark" id="remark" style="width:80px;" type="text" value="<?php echo $defaultratedata[0]['remark']?>">
                                               
										  </td>
										  
	                                        <td style="width:30%"  bgcolor="#ffffff" align="left">
	                                             
	                                            <input name="submit" value="修改默认费率" id="submit" style="height:22px;" onclick="return checkfield()" type="submit">
	                                            <input name="Button2" value="返回" id="Button2" onclick="window.location.href='__APP__/Ratemanage/qubyacc?id=<?php echo $defaultratedata[0]['ownid'];?>'" style="width:60px;height:22px;" type="button">
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