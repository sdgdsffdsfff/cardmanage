<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="" />
        <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
        
        <script src="__PUBLIC__/js/common.js"></script>
            
        <link type="text/css" href="__PUBLIC__/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
        <link type="text/css" href="__PUBLIC__/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
        <script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.2.js"></script>
        <script type="text/javascript" src="__PUBLIC__/js/jquery-ui-1.8.17.custom.min.js"></script>
        <script type="text/javascript" src="__PUBLIC__/js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="__PUBLIC__/js/jquery-ui-timepicker-zh-CN.js"></script>	


		<script type="text/javascript">

              
					$(document).ready(function(){

						  $(".ui_timepicker").datetimepicker({
                                showSecond: false,
                                showMinute: false,
                                showHour: false,
                                showTime:false,
                                timeFormat: 'hh:mm:ss',
                                stepHour: 1,
                                stepMinute: 1,
                                stepSecond: 1
                            })


						   $('#update').click(					   	
				   				function(){
                                    if(!checkfield())
                                    {
                                        return false;
                                    }
				   					ajaxupdate();
                                    
				   				}
						   	);

                    function checkfield()
                        {
                                if($('#loginpwd').val() != "")
                                  {
                                         var pwd= $('#loginpwd').val();
                                         if(pwd.length!=6)
                                         {
                                            alert("密码长度为六位");
                                            $('#loginpwd').focus;
                                            return false;
                                         }
                                         if(isNaN(pwd)){
                                             alert("密码请输入数字!");
                                         $('#loginpwd').focus;
                                         return false;
                                        }       
                                  }
                            return true;

                        } 

				    function ajaxupdate(){
						  $.post("__APP__/Queryphone/updatephonedata",
						  	{userid:$('#userid').val(),loginpwd:$('#loginpwd').val(),remark:$('#remark').val(),banlance:$('#money').val(),expirydate:$('#expirydate').val(),state:$("input[name=state]:checked").val(),bindtel:$('#bindtel').val()},
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

				   });

    	</script>

	</head>
	
	<body>
		<div id="main">

		    <div class='head-dark-box'>
					<div class='tit'>内容管理>账号查询>用户资料修改</div>
			</div>	
				<?php
 $userdata=$userdata[0]; ?>
<table style="margin-top:0px; font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center" bgcolor="#cccccc" width="70%">
                <tbody><tr>
                    <td colspan="4" style="height: 25px" align="left" bgcolor="#f4f4f4">
                        &nbsp;用户资料修改</td>
                </tr>
                <tr> <input type="hidden" id="userid" value="<?php echo $userdata['id'];?>">
                    <td style="height: 25px" align="center" bgcolor="#f4f4f4" width="25%">
                        &nbsp;电话号码</td>
                    <td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
                        &nbsp;<input name="bindtel" value="<?php  echo $userdata['phonenum'];?>" <?php if($_SESSION['authority']['up_bindtel']==0) echo 'disabled="disabled"' ?> maxlength="15" id="bindtel"  style="width:120px;" type="text"></td>
                     <td bgcolor="#ffffff"  align="center">
                     	是否禁用
                     </td>
                     <td bgcolor="#ffffff" >
                     	<?php if($_SESSION['authority']['man_cardstatus'] == 1): ?><input type="radio" <?php  if($userdata['state']==0) echo 'checked="checked"';?>name="state" value="0"/>是 <input type="radio" name="state" value="1" <?php  if($userdata['state']==1) echo 'checked="checked"';?>/>否<?php endif; ?>
                     </td>
                </tr>
                <tr>
                    <td style="height: 25px" align="center" bgcolor="#f4f4f4" width="25%">
                        &nbsp;密码</td>
                    <td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">

                        &nbsp;<input name="loginpwd" value="<?php  echo $userdata['loginpwd'];?>"  maxlength="6" id="loginpwd"  style="width:120px;" type="text"                         <?php  if ($_SESSION['authority']['up_cardpwd']==0) { echo 'disabled="disabled"'; } ?> ></td>
					
                    <td style="height: 25px" align="center" bgcolor="#f4f4f4" width="25%">
                        &nbsp;余额</td>

                    <td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">

                        &nbsp;<input name="money" value="<?php echo $userdata['banlance'];?>"
                        <?php  if ($_SESSION['authority']['up_cardmoney']==0) { echo 'disabled="disabled"'; } ?> 
                 

                        maxlength="8" id="money" style="width:120px;" type="text" >零填写0.00</td>
                </tr>
                 <tr>
                    <td style="height: 25px" align="center" bgcolor="#f4f4f4" width="25%">
                        &nbsp;最后使用时间</td>
                    <td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
                        &nbsp;<?php  echo $userdata['lastusetime'];?></td>
                    <td style="height: 25px" align="center" bgcolor="#f4f4f4" width="25%">
                        &nbsp;注册时间</td>
                    <td style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
                        <?php echo $userdata['registedate'];?></td>
                </tr>

                <tr>
                    <td style="height: 25px" align="center" bgcolor="#f4f4f4" width="25%">
                        截止日期</td>
                    <td colspan="3" style="height: 25px" align="left" bgcolor="#ffffff" width="25%">
                        
	                     <span id="TxtApplyDate">    
	                        <input type="text" name="expirydate"  id="expirydate" value="<?php  echo $userdata['expirydate'];?>"                     <?php  if ($_SESSION['authority']['up_userexpirydate']==0) { echo 'disabled="disabled"'; } ?> class="ui_timepicker">         
	                     </span>
                     </td>
                </tr>                                 

                <tr>
                  　　<td  align="center" bgcolor="#f4f4f4" width="25%" colspan="1">备注</td>
                      <td bgcolor="#ffffff"  colspan="3"> 
							<textarea name="remark" id="remark" style="width:100%;height:150px"><?php echo $userdata['remark'];?></textarea>
                      </td>
                </tr>
                <tr>
                    <td colspan="4" style="height: 25px" align="center" bgcolor="#f4f4f4">
                        <input name="update" value="修改" id="update"  style="width:56px;" type="submit">&nbsp;
                        <!--<input name="Button5" value="返回" id="Button5" style="width:56px;" onclick="history.back(-1);" type="submit">-->
                        <input name="Button5" value="返回" id="Button5" style="width:56px;" onclick="window.location.href='__APP__/queryphone/index'" type="button"></td>
                </tr>
            </tbody></table>
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

		
	 </div>
		
		<br/><br/><br/><br/><br/>
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>

	</body>
</html>