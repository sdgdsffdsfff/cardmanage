<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	

		<script>
				
					function checkfield(){
						  
						   ajaxupdate();

						}


					function ajaxupdate(){

						  $.post("__APP__/Contactmanage/updatecontact",
						  	{telenum:$('#telenum').val(),id:$('#id').val()},

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
					<div class='tit'>内容管理>费率管理>添加默认费率</div>
			</div>	
<!--action="__APP__/Transfercard/transfer"-->
          <br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table style="margin-top:0px;font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="80%">
                                  <tbody>
                                     <tr>
                                        <td colspan="2" style="height: 25px" align="left" bgcolor="#f4f4f4">
                                            &nbsp;常用联系人修改
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:400px; height: 25px" align="left" bgcolor="#ffffff">
 
                                            联系人：<input name="cname" maxlength="20" id="cname" value="<?php echo $contactdata[0]['cname']?>" style="width:80px;" type="text" disabled >
                                            <input type="hidden" id="id" value="<?php echo $contactdata[0]['id']?>">
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                          
                                            联系电话：<input name="telenum" maxlength="40" id="telenum" value="<?php echo $contactdata[0]['telnum']?>" style="width:100px;" type="text">
                                             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                          
										  </td>
										  
                                        <td style="height: 25px" align="left" bgcolor="#ffffff">

                                            <input name="submit" value="修改" id="submit" style="height:22px;" onclick="return checkfield()" type="submit">
                                            <input name="back" value="返回" id="back" onclick="window.location.href='__APP__/Contactmanage/index'" type="button">

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