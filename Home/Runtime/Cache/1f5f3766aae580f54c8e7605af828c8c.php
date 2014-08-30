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

						/*  
				 $('#query').click(					   	
				   		function(){
				   			ajaxquery();
				   		  }
					);
					
				    function ajaxquery(){

				    	  

						  $.post("__APP__/Donatemoney/query",
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
                            	    //alert(data['message']);
                                    $('#table').html('');
                                    $('#table').html(data['message']);
                            }
						  },
						   "json");//这里返回的类型有：json,html,xml,text
						}
*/
				   });
					

    	</script>


</head>
<body>
<div id="main">
<div class="head-dark-box">
					<div class="tit">内容管理&gt;赠送管理&gt;赠送管理</div>
			</div>


				<?php
 $firstday = date('Y-m-01 00:00:00', time()); $nowtime=date('Y-m-d H:i:m',time()); ?>


	<form method="get" action="__ROOT__/">
	<input type="hidden" name="m" value="Donatemoney"/>
	<input type="hidden" name="a" value="query"/>
	<table style="margin-top:5px;font: 12px Verdana,Arial,Helvetica,sans-serif" cellpadding="0" cellspacing="1" align="center" bgcolor="#B5C7DE" border="0" width="80%">
          <tbody><tr>
            <td class="STYLE2" align="left" bgcolor="#E5E5E5" height="25">&nbsp;赠送查询：</td>
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
   </form>
  <br/><br/><br/>

<table rules="all" id="table" style="border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:90%;border-collapse:collapse;" cellpadding="3" cellspacing="0" align="Center" border="1">
	<tbody>

		<tr>
			<!--<td colspan="5" >
							
					<a href="__APP__/Donatemoney/donate">赠送</a>						
			</td>	--> 
		</tr>
		<tr style="background-color:#E5E5E5;font-weight:bold;height:15px;">
			<th scope="col">编号</th>
			<th scope="col">用户</th>
			<th scope="col">金额</th>
			<th scope="col">赠送时间</th>
			<th scope="col">备注</th>
		</tr>


	 
		   <?php  if (!empty($list)) { foreach ($list as $key => $pervalue) { $key=$key+1; echo '<tr id="tr'.$pervalue['id'].'">
			  		    		  <td>'.$key.'</td><td>'.$pervalue['userid'].'</td>
			  		              <td>'.$pervalue['money'].'</td>
			  		              <td>'.$pervalue['dotime'].'</td>
			  		              <td>'.$pervalue['remark'].'</td></tr>'; } }else { echo '<tr><td colspan="5">没有查询到赠送记录</td></tr>'; } ?>
			  


		 

		 <tr>
                 <td colspan="5" align="center" ><?php echo ($page); ?></td>
         </tr>

		</tbody>
</table>



    <br/><br/><br/><br/><br/>
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>

</body>
</html>