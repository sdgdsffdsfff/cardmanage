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

						   $('#query').click(					   	
				   				function(){
				   					ajaxupdate();
				   				}
						   	);

               $('#querydealership').click(function(){

                      ajaxquery();         
                  
               })



         function ajaxquery()
               {
               $.post("__APP__/Datastatistic/querycard",
                {accountid:$('#accountid').val(),starttime:$('#starttime1').val(),endtime:$('#endtime1').val()},
                function(data){

                            if (data['status']=="data") 
                            {  
                                    $('#dealershipcard').html(data['message']);
                            }
              },
               "json");//这里返回的类型有：json,html,xml,text
               }


				    function ajaxupdate(){

						  $.post("__APP__/Datastatistic/statistic",
						  	{starttime:$('#starttime').val(),endtime:$('#endtime').val()},
						    function(data){
						    
						    if (data['status']=="success") {
						    	alert(data['message']);
                                //console.log(data['message']);
						    }else if (data['status']=="failed") 
						    {
						    	alert(data['message']);
                    $('#table').html('');
						    }
                            else if (data['status']=="data") 
                            {
                                    $('#table').html('');
                                    $('#table').html(data['message']);
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
					<div class='tit'>内容管理>数据统计>数据统计</div>
			</div>	
				<?php
 $userdata=$userdata[0]; $firstday = date('Y-m-01 00:00:00', time()); $nowtime=date('Y-m-d H:i:m',time()); ?>
            
  

    <table style="margin-top:5px;font: 12px Verdana,Arial,Helvetica,sans-serif" cellpadding="0" cellspacing="1" align="center" bgcolor="#B5C7DE" border="0" width="80%">
          <tbody><tr>
            <td class="STYLE2" align="left" bgcolor="#E5E5E5" height="25">&nbsp;数据统计：</td>
          </tr>
          <tr bgcolor="gainsboro">
            <td style="height: 25px" align="center" bgcolor="#ffffff" height="25">&nbsp;起始时间：
                <input type="text" name="starttime" id="starttime" class="ui_timepicker" value="<?php echo $firstday;?>">
                <input type="hidden" name="userid" id="userid" value="<?php echo $userid;?>" >
                
            &nbsp; 截止时间:
              <input type="text" name="endtime" id="endtime" class="ui_timepicker" value="<?php echo $nowtime?>">

                <input name="query" value="统计" id="query" type="submit"> 
                     
            &nbsp;&nbsp;&nbsp; </td>
          </tr>
        </tbody>
   </table>
  <br/><br/><br/>

<table id="table" style="font: 12px Verdana,Arial,Helvetica,sans-serif;width:80%" cellspacing="1" align="center" bgcolor="#cccccc" >
                <tbody>
                <tr>
                    <td colspan="4" align="left" bgcolor="#f4f4f4" height="25">
                        &nbsp;<span id="Title"><font color="blue"></font><font color="blue"></font>统计结果如下：</span></td>
                </tr>


               <?php
 if ($_SESSION['power']==1) { echo '<tr>
                    <td align="center" bgcolor="#f4f4f4" height="30">
                        生成充值卡数</td>
                    <td align="left" bgcolor="#ffffff" height="25">
                        &nbsp;<span id="Label3" class="txtalignRight" style="display:inline-block;width:100px;">'. $sumcard.'</span>
                        张</td>
                    <td align="center" bgcolor="#f4f4f4" height="25">
                        生成充值金额</td>
                    <td bgcolor="#ffffff">
                        &nbsp;
                        <span id="Label4" class="txtalignRight" style="display:inline-block;width:100px;">'.$summoney.'</span>
                        元</td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#f4f4f4" height="30">
                        使用充值卡数</td>
                    <td align="left" bgcolor="#ffffff" height="25">
                        &nbsp;<span id="Label6" class="txtalignRight" style="display:inline-block;width:100px;">'. $sumusedcard.'</span>
                        张</td>
                    <td align="center" bgcolor="#f4f4f4" height="25">
                        充值金额</td>
                    <td bgcolor="#ffffff">
                        &nbsp;
                        <span id="Label7" class="txtalignRight" style="display:inline-block;width:100px;">'.$sumusedmoney.'</span>
                        元</td>
                </tr>
                  <tr>
                  	<td align="center" bgcolor="#f4f4f4" height="30">
                        消费金额</td>
                    <td align="left" bgcolor="#ffffff" height="25">
                        &nbsp;<span id="Label5" class="txtalignRight" style="display:inline-block;width:100px;">'. $sumcost.'</span>
                        元</td>
                    <td align="center" bgcolor="#f4f4f4" height="30" width="20%">
                        </td>
                    <td align="left" bgcolor="#ffffff" height="25" width="30%">
                        &nbsp;<span id="Label1" class="txtalignRight" style="display:inline-block;width:100px;"></span>
                     </td>

                     <!--
                    <td align="center" bgcolor="#f4f4f4" height="25" width="20%">
                        注册金额</td>
                    <td bgcolor="#ffffff">
                        &nbsp;
                        <span id="Label2" class="txtalignRight" style="display:inline-block;width:100px;">0</span>
                        元</td>-->         
                  </tr>'; }else { echo '<tr>
				                    <td align="center" bgcolor="#f4f4f4" height="30">
				                        使用充值卡数</td>
				                    <td align="left" bgcolor="#ffffff" height="25">
				                        &nbsp;<span id="Label6" class="txtalignRight" style="display:inline-block;width:100px;">'. $sumusedcard.'</span>
				                        张</td>
				                    <td align="center" bgcolor="#f4f4f4" height="25">
				                        充值金额</td>
				                    <td bgcolor="#ffffff">
				                        &nbsp;
				                        <span id="Label7" class="txtalignRight" style="display:inline-block;width:100px;">'.$sumusedmoney.'</span>
				                        元</td>
				                    </tr>'; } ?>
                
                <tr>
                    <td colspan="4" style="height: 25px" align="center" bgcolor="#ffffff">
                    </td>
                </tr>
              </tbody>
            </table>
    
<br/><br/>

<?php
 if ($_SESSION['power']!=3) { echo '<table style="margin-top:5px;font: 12px Verdana,Arial,Helvetica,sans-serif" cellpadding="0" cellspacing="1" align="center" bgcolor="#B5C7DE" border="0" width="80%">
          <tbody>
            <tr>
              <td class="STYLE2" align="left" bgcolor="#E5E5E5" height="25">&nbsp;代理商数据统计：</td>
            </tr>
          <tr bgcolor="gainsboro">
            <td style="height: 25px" align="center" bgcolor="#ffffff" height="25">'; } if ($_SESSION['power']!=3) { echo '
                                        
                                        请选择代理商 : 
                                        <select name="accountid" id="accountid" style="width:110px;">
                                        <option value="0">全部</option>
                                        '; foreach ($accountdata as $key => $value) { echo '<option value="'.$key.'">'.$value.'</option>'; } echo '</select>'; } echo ' 开始时间: <input type="text" name="starttime" id="starttime1" class="ui_timepicker" value="'.$firstday.'">'; echo ' 截止时间:
              								<input type="text" name="endtime" id="endtime1" class="ui_timepicker" value="'.$nowtime.'">'; if ($_SESSION['power']!=3) { echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="query" value="统计" id="querydealership" type="submit"> 
                                              &nbsp;&nbsp;&nbsp; </td>
                                            </tr>
                                          </tbody>
                                     </table>'; } ?>
                                   
<br/>

<?php
 if ($_SESSION['power']!=3) { echo '<table id="table" style="font: 12px Verdana,Arial,Helvetica,sans-serif;width:80%" cellspacing="1" align="center" bgcolor="#cccccc" >
                <tbody id="dealershipcard">
                <tr>
                    <td colspan="4" align="left" bgcolor="#f4f4f4" height="25">
                        &nbsp;<span id="Title">统计结果:</span></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#f4f4f4" height="30">
                      总卡数</td>
                  <td align="left" bgcolor="#ffffff" height="25">
                      &nbsp;<span id="Label6" class="txtalignRight" style="display:inline-block;width:100px;">'. $sumcard.'</span>
                      张</td>
                  <td align="center" bgcolor="#f4f4f4" height="25">
                      已开通卡数</td>
                  <td bgcolor="#ffffff">
                      &nbsp;
                      <span id="Label7" class="txtalignRight" style="display:inline-block;width:100px;">'.$sumopencard.'</span>
                      张</td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#f4f4f4" height="30">
                        已锁定卡数</td>
                    <td align="left" bgcolor="#ffffff" height="25">
                        &nbsp;<span id="Label6" class="txtalignRight" style="display:inline-block;width:100px;">'. $sumlockcard.'</span>
                        张</td>
                    <td align="center" bgcolor="#f4f4f4" height="25">
                        已使用卡数</td>
                    <td bgcolor="#ffffff">
                        &nbsp;
                        <span id="Label7" class="txtalignRight" style="display:inline-block;width:100px;">'.$sumusedcard.'</span>
                        张</td>
                </tr>

                <tr>
                    <td colspan="4" style="height: 25px" align="center" bgcolor="#ffffff">
                    </td>
                </tr>
              </tbody>
      </table>'; } ?>


<br/><br/>
		
	 </div>
		
		<br/><br/><br/><br/><br/>
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>

	</body>
</html>