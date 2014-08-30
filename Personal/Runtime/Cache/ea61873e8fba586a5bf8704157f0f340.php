<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	

		<script>
				
					function checkfield(){
						 
						  if($('#shortnum').val() == ""){
							
						    $('#shortnum').focus();
						    alert("缩位号不能为空");
						    return false;
						  }		
						   if($('#phonenum').val() == ""){
							
						    $('#phonenum').focus();
						    alert("手机号不能为空");
						    return false;
						  }	
						  else
						  {
						  	//return false;
						        	 var str=$('#phonenum').val();
						        	 //alert($("#telemsg").html());
						        	 // $('#telemsg').innerHTML="手机号码不能为空！";
						        	 var regPartton=/1[3-8]+\d{9}/;
						        	 var regPartton1=/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/;
						        	 if(!(regPartton.test(str)||regPartton1.test(str))){
											alert("原手机号码格式不正确！");				
											return false;
										}

						  }

						  if(isNaN($('#shortnum').val())){
						     $('#msg').html("起始账号请输入数字!");
						     $('#shortnum').focus();
						     return false;
						  }

						   ajaxcheck();

						}


						function ajaxcheck(){

						  $.post("__APP__/Reducenum/addshortnum",

						  	{shortnum:$('#shortnum').val(),remark:$('#remark').val(),phonenum:$('#phonenum').val()},

						  function(data){

						    if (data['status']=="success") {
						    	alert(data['message']);

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
					<div class='tit'>内容管理>缩位拨号>添加缩位拨号</div>
			</div>	
<!--action="__APP__/Transfercard/transfer"-->
          <br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table style="margin-top:0px;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="80%">
                                  <tbody>
                                     <tr>
                                        <td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4">
                                            &nbsp;修改缩位拨号
                                            
                                        </td>
                                     </tr>
                                    <tr>
                                        <td style="width:700px; height: 25px" align="left" bgcolor="#ffffff">
 
                                            原号码：<input  maxlength="20"  style="width:80px;" type="text" id="phonenum" name="phonenum">
                                             
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                          
                                            缩位号码：<input name="shortnum" maxlength="20" id="shortnum" style="width:80px;" type="text">
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                             
                                             备注：<input name="remark" id="remark" style="width:80px;" type="text">                                           
										  </td>
										  
	                                        <td style="height: 25px"  bgcolor="#ffffff" align="left">
	                                            
	                                            <input name="submit" value="添加缩位拨号" id="submit" style="height:22px;" onclick="checkfield()" type="button">
	                                          <input name="Button5" value="返回" id="Button5" style="width:56px;" onclick="window.location.href='__APP__/Reducenum/index'" type="button">

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