<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>管理平台</title>
<meta name="Author" content="" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css">
<style type="text/css">
table td,table th {
	text-align: center;
}
</style>
<script src="__PUBLIC__/js/common.js"></script>
<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tc.min.js"></script>
<link type="text/css" href="__PUBLIC__/css/jquery-ui-1.8.17.custom.css"
	rel="stylesheet" />
<link type="text/css"
	href="__PUBLIC__/css/jquery-ui-timepicker-addon.css" rel="stylesheet" />
<script type="text/javascript"
	src="__PUBLIC__/js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript"
	src="__PUBLIC__/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"
	src="__PUBLIC__/js/jquery-ui-timepicker-zh-CN.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/tc.min.js"></script>
<script type="text/javascript">
		$(function(){
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
			//全选
			$('input[name=checkall]').click(function(){
				if(this.checked){
					$('input[class=check]').attr('checked',true);
				}else{
					$('input[class=check]').attr('checked',false);
				}				
			});
			
			
			//批量删除
			$("#del").click(function(){
				if(window.confirm('你确定要删除吗？')){
					$.post('<?php echo U('batchDel');?>',$("form[name=list]").serialize(),function(data){				
						if(data.status=='succ'){
							alert('删除成功！');
							location.href=location.href;
						}else{
							alert('删除失败！');
						}				
					},'json');		
				}			
			});
		});

					function ajaxdelete(id){

                          //alert(id);                        
						  $.post("__APP__/Blackcallednum/delete",
						  	{id:id},
						    function(data){
						    
						    if (data['status']=="success") {
						    	alert(data['message']);
						    	$('#tr'+id).remove();

						    }else if (data['status']=="failed") 
						    {
						    	alert(data['message']);
						    }				    
						  },
						   "json"); //这里返回的类型有：json,html,xml,text
                          
						}

		</script>
</head>
<body>
	<div id="main">
		<div class="head-dark-box">
			<div class="tit">内容管理&gt;黑名单管理</div>
			<?php
 $userdata=$userdata[0]; $firstday = date('Y-m-01 00:00:00', time()); $nowtime=date('Y-m-d H:i:m',time()); ?>
		</div>
		<br />
		<br />
		<br />
		<form name="list" action="" method="post">
			<table rules="all" id="MyGridView"
				style="border-color: Black; border-width: 1px; border-style: solid; font-size: 10pt; height: 10px; width: 80%; border-collapse: collapse;"
				cellpadding="3" cellspacing="0" align="Center" border="1">
				<tbody>

					<tr>
						<td colspan="5"><a href="__APP__/Blackcallednum/add">添加黑名单</a>
							<a href="__APP__/Blackcallednum/bulkadd">/批量导入黑名单</a>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ 导出黑名单 <a
							href="__APP__/Blackcallednum/download?id=1">【文本文档】</a> <a
							href="__APP__/Blackcallednum/download?id=2">【EXCEL】</a></td>
					</tr>
					<tr>
						<td colspan="5">号码：<input type="text" name="num" value="" />
							起始时间：<input type="text" name="starttime" id="starttime"
							class="ui_timepicker" value="<?php echo $firstday;?>">
							截止时间：<input type="text" name="endtime" id="endtime"
							class="ui_timepicker" value="<?php echo $nowtime?>"> <input
							type="submit" name="send" value="搜索" /></td>
					</tr>
					<tr
						style="background-color: #E5E5E5; font-weight: bold; height: 15px;">
						<th scope="col" style="width: 20%;" align="center">全选<input
							type="checkbox" name="checkall" value="all" /></th>
						<th scope="col" style="width: 20%">编号</th>
						<th scope="col">号码</th>
						<th scope="col">添加时间</th>
						<th scope="col">操作</th>
					</tr>

					<?php  $key=1; foreach ($blacklistdata as $pervalue) { echo '<tr id="tr'.$pervalue['id'].'">
<td><input type="checkbox" name="check[]" class="check" value="'.$pervalue['id'].'"/></td>
			  		    		  <td >'.$key.'</td><td>'.$pervalue['areacode'].'</td>
									<td>'.date('Y-m-d H:i:s',$pervalue['addtime']).'</td>
			  		              <td align="center">
			  		              <a id="lock" style="cursor:pointer" onclick="ajaxdelete('.$pervalue['id'].')" >删除</a>
			  		              </td>
			  		         </tr>'; $key++; } ?>


					<tr>
						<td>操作:<a href="javascript:void(0)" id="del"
							style="color: #f60">批量删除</a></td>
						<td colspan="4" align="center" style=""><?php echo ($page); ?></td>
					</tr>

				</tbody>
			</table>
		</form>
		<br />
		<br />
		<br />
		<br />
		<br />
		<div id="timer">
			<p>
				<span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</p>
		</div>
</body>
</html>