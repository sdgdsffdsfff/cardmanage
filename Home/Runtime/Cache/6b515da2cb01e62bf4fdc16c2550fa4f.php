<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	

		<script>
				
				
					function checkfield(){
						  
						/*
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
						  }*/

						   ajaxadd();

						}


						function ajaxadd(){
							//alert('sdadsa');

						  $.post("__APP__/Opencard/addblack",
						  	{cname:$('#cname').val(),telenum:$('#telenum').val()},
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
					<div class='tit'>内容管理>开户黑名单管理>批量导入</div>
			</div>	
       <!--action="__APP__/Transfercard/transfer"-->
          <br/><br/><br/><br/><br/><br/><br/><br/><br/>
          <form method="post" action="__APP__/Opencard/upfile" enctype="multipart/form-data">
							<table style="margin-top:0px;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="80%">
                                  <tbody>
                                    <tr>
                                        <td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4">
                                            &nbsp;批量开户黑名单号码                         
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:500px; height: 25px" align="left" bgcolor="#ffffff">
 
                                           &nbsp; &nbsp; &nbsp;  请选择文件EXCEL/txt文件:&nbsp; &nbsp; &nbsp; <input type='file' name='file'/>
                                             &nbsp; &nbsp; 
                                          
                                             
                                          
										  </td>
										  
                                        <td style="height: 25px" align="left" bgcolor="#ffffff">

                                           <input type='submit'value='导入开户黑名单' id='submitbutton'/>
                                             
                                            <input name="back" value="返回" id="back" onclick="window.location.href='__APP__/Opencard/index'" type="button">

											<span style="color:red" id="msg"></span>
										                                        
									   </td>
                                    </tr>
                                </tbody>
                              </table>
                             </form>	
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