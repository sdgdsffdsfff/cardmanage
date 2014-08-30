<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
			
	    <link type="text/css" href="__PUBLIC__/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
        <link type="text/css" href="__PUBLIC__/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
	    <script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="__PUBLIC__/js/jquery-ui-1.8.17.custom.min.js"></script>
		<script type="text/javascript" src="__PUBLIC__/js/jquery-ui-timepicker-addon.js"></script>
	    <script type="text/javascript" src="__PUBLIC__/js/jquery-ui-timepicker-zh-CN.js"></script>
		<style type="text/css">
				#ui-datepicker-div
				{
					width:50%;
					position:absolute;
					left:0px;
				}
		</style>
		<script type="text/javascript">
  
					$(document).ready(function(){

							/*
							$(".ui_timepicker").datetimepicker({
					            //showOn: "button",
					            //buttonImage: "./css/images/icon_calendar.gif",
					            //buttonImageOnly: true,
					            showSecond: true,
					            timeFormat: 'hh:mm:ss',
					            stepHour: 1,
					            stepMinute: 1,
					            stepSecond: 1
					        })*/

						   $('#query').click(					   	
				   				function(){
				   					ajaxupdate();
				   				}
						   	);

				    function ajaxupdate(){

						  $.post("__APP__/Queryphone/querybillbytime",
						  	{starttime:$('#starttime').val(),endtime:$('#endtime').val(),userid:$('#userid').val()},
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
					<div class='tit'>内容管理>账号查询>通话清单查询</div>
			</div>	
				<?php
 $userdata=$userdata[0]; $firstday = date('Y-m-01 00:00:00', time()); $nowtime=date('Y-m-d H:i:m',time()); ?>
            
  

    <table style="margin-top:5px;font: 12px Verdana,Arial,Helvetica,sans-serif" cellpadding="0" cellspacing="1" align="center" bgcolor="#B5C7DE" border="0" width="80%">
          <tbody><tr>
            <td class="STYLE2" align="left" bgcolor="#E5E5E5" height="25">&nbsp;通话清单查询：</td>
          </tr>
          <tr bgcolor="gainsboro">
            <td style="height: 25px" align="center" bgcolor="#ffffff" height="25">&nbsp;起始时间：
                <input type="text" name="starttime" id="starttime" class="ui_timepicker" value="<?php echo $firstday;?>">
                <input type="hidden" name="userid" id="userid" value="<?php echo $userid;?>" >
                
            &nbsp; 截止时间:
              <input type="text" name="endtime" id="endtime" class="ui_timepicker" value="<?php echo $nowtime;?>">

                <input name="query" value="查询" id="query" type="submit"> 
                <input name="Button2" value="返回" id="Button2" onclick="history.back(-1);" type="button">       
            &nbsp;&nbsp;&nbsp; </td>
          </tr>
        </tbody>
   </table>
  <br/><br/><br/>

  <table rules="all" id="table" style=" font: 12px Verdana,Arial,Helvetica,sans-serif; width:80%;border-collapse:collapse;" cellpadding="3" cellspacing="0" border="1" align="center">
            <tbody>
            <tr style="background-color:#E5E5E5;font-weight:normal;height:18px;">
                <th scope="col">编号</th>
                <th scope="col">主叫号码</th>
                <th scope="col">被叫号码</th>
                <th scope="col">开始时间</th>
                <th scope="col">结束时间</th>
                <th scope="col">时长/秒</th>
                <th scope="col">费用</th>
            </tr>
            
                <?php
 foreach ($billdata as $key => $pervalue) { echo '<tr style="color:Black;background-color:White;height:18px;" align="center">'; echo '<td style="width:35px;" align="center">'.$pervalue['id'].'</td>
                                <td style="width:100px;">'.$pervalue['callernum'].'</td>
                                <td style="width:100px;">'.$pervalue['callednum'].'</td>
                                <td style="width:100px;" >'.$pervalue['starttime'].'</td>
                                <td style="width:100px">'.$pervalue['endtime'].'</td>
                                <td style="width:60px;">'.$pervalue['duration'].'</td>
                                <td style="width:60px;">'.$pervalue['cost'].'</td></tr>'; } ?>  
       
            
            <tr style="color:Black;background-color:White;height:18px;" align="center">
                
                <td style="width:100px;" colspan="5" align="right" >总计</td>
                
                <td style="width:60px;"><?php echo $sumtime;?></td>
                <td style="width:60px;"><?php  echo $sumcost;?></td>
            </tr>
        </tbody>
     </table>
    


<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

















		
	 </div>
		
		<br/><br/><br/><br/><br/>
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>

	</body>
</html>