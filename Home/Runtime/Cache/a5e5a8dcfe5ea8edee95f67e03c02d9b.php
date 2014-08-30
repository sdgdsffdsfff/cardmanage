<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
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
					        });
					
				        $('#query').click(					   	
			   				function(){
			   					ajaxquery();
			   				}
					   	);
                        /*
				    function ajaxquery(){ 
                           
						  $.post("__APP__/Querylog/querylogbytime",
						  	{starttime:$('#starttime').val(),endtime:$('#endtime').val(),accountid:$("#accountid").val()},
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
                            	    //alert(data['message']);
                                    $('#logdata').html('');
                                    $('#logdata').html(data['message']);
                            }
						  },
						   "json");//这里返回的类型有：json,html,xml,text
						}*/
						});
					
	    </script>
	</head>
	
	<body>
		<div id="main">

		    <div class='head-dark-box'>
					<div class='tit'>内容管理>数据查询>操作日志</div>
			</div>	

				<?php
 $firstday = date('Y-m-01 00:00:00', time()); $nowtime=date('Y-m-d H:i:m',time()); ?>

<form method="post" action="<?php echo U('querylogbytime');?>">
    <table style="margin-top:5px;font: 12px Verdana,Arial,Helvetica,sans-serif" cellpadding="0" cellspacing="1" align="center" bgcolor="#B5C7DE" border="0" width="80%">
          <tbody>
           <tr>
            <td class="STYLE2" align="left" bgcolor="#E5E5E5" height="25">&nbsp;日志查询：</td>
           </tr>
           <tr bgcolor="gainsboro">
            <td style="height: 25px" align="center" bgcolor="#ffffff" height="25">&nbsp;
            	账号：<select name="accountid" id="accountid">
            	    <option value="<?php echo (session('accountid')); ?>"><?php echo (session('loginname')); ?></option>
            		<?php if(is_array($nav)): foreach($nav as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo str_repeat('　',$vo['level']); echo ($vo["loginname"]); ?></option><?php endforeach; endif; ?>
            		</select>
            	开始时间：
                <input type="text" name="starttime" id="starttime" class="ui_timepicker" value="<?php echo $firstday;?>">
                <input type="hidden" name="userid" id="userid" value="<?php echo $userid;?>" >
                
            &nbsp; 截止时间:
                <input type="text" name="endtime" id="endtime" class="ui_timepicker" value="<?php echo $nowtime?>">	

                <input name="query" value="查询" id="query" type="submit"> 
                     
            &nbsp;&nbsp;&nbsp; </td>
          </tr>
        </tbody>
 </table>
</form>
  <br/> <br/> <br/> 
				

    <table cellspacing="0" cellpadding="3" align="Center" rules="all" border="1"  style="border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:90%;border-collapse:collapse;">
		<tbody id="logdata"><tr style="background-color:#E5E5E5;height:15px;">
			<th scope="col">编号</th><th scope="col">帐号</th><th scope="col">操作时间</th><th scope="col">客户端IP</th><th scope="col">操作类别</th><th scope="col">具体操作</th>
		</tr>

		<?php  foreach ($logdata as $key => $value) { echo '<tr align="center" style="height:25px;">
			       <td style="width:30px;">'.$key.'</td><td style="width:80px;">'.$value['accountid'].'</td><td style="width:180px;">'.$value['opertime'].'</td><td style="width:100px;">'.$value['clientip'].'</td><td style="width:100px;">'.$value['opertype'].'</td><td class="txtalignRight" align="left">
			           '.$value['detail'].'</td></tr>'; } ?>
		<tr align="center" style="height:25px;">
			<td colspan="6"><?php echo $page?></td>
		</tr>
			</tbody></table></td>
		</tr>
	</tbody></table>
















		
	 </div>
		
		<br/><br/><br/><br/><br/>
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>

	</body>
</html>