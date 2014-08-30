<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>
		<script type="text/javascript">

				    function ajaxlock(id){
                          //alert(id);
						  $.post("__APP__/Querycard/lockcard",
						  	{cardid:id},
						    function(data){
						    
						    if (data['status']=="success") {
						    	alert(data['message']);
						    	$('#status'+id).html('已锁定');	

						    	var str='<a href="__APP__/Querycard/updatecarddata?id='+id+'">修改</a>/<a onclick="ajaxopen('+id+')">激活</a>';
						    	$('#td'+id).html(str);	
						    	
	
						    }else if (data['status']=="failed") 
						    {
						    	alert(data['message']);
						    	
						    }

						    
						  },
						   "json");//这里返回的类型有：json,html,xml,text
						}

				   function ajaxopen(id){
                          //alert(id);

						  $.post("__APP__/Querycard/opencard",
						  	{cardid:id},
						    function(data){
						    
						    if (data['status']=="success") {
						    	alert(data['message']);

						    	$('#status'+id).html('已激活');
						    	$('#openway'+id).html('网站');
						    	var str='<a  href="__APP__/Querycard/updatecarddata?id='+id+'">修改</a>/<a  style="cursor:pointer" onclick="ajaxlock('+id+')">锁定</a>';
						    	$('#td'+id).html(str);	
						    	
						    }else if (data['status']=="failed") 
						    {
						    	alert(data['message']);
						    }
						  },
						   "json");//这里返回的类型有：json,html,xml,text

						}
				   
				   function ajaxdel(id){

						  $.post("__APP__/Querycard/delcard",
						  	{cardid:id},
						    function(data){
						  		id='#tr'+id;
						    if (data['status']=="success") {
						    		$(id).remove();
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
					<div class='tit'>内容管理>账号卡查询>修改卡信息</div>
			</div>	
				
<table rules="all" id="MyGridView" style="border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:90%;border-collapse:collapse;" cellpadding="3" cellspacing="0" align="Center" border="1">
		
		<tbody>
		<tr style="background-color:#E5E5E5;font-weight:bold;height:15px;">
			<th scope="col">卡号</th>
			<th scope="col">密码</th>
			<th scope="col">电话</th>
			<th scope="col">注册时间</th>
			<th scope="col">充值期限</th>
			<th scope="col">有效期</th>
			<th scope="col">余额</th>
			<th scope="col">状态</th>
			<th scope="col">开通方式</th>
			<th scope="col">代理商</th>	
			<th scope="col">操作</th>
		</tr>
			 
	         <?php
 if (!empty($list)) { foreach ($list as $key => $cardvalue) { echo '<tr id="tr'.$cardvalue['id'].'" style="height:25px;" align="center"><td align="center" width="100px">'.$cardvalue['cardnum'].'</td>
	         	 	     		<td style="width:70px;" align="center">'.$cardvalue['cardpwd'].'</td>
								<td style="width:110px;" align="center">'.$cardvalue['bindtel'].'</td>
								<td style="width:110px;" align="center">'.$cardvalue['createtime'].'</td>  
								<td style="width:110px;" align="center">'.date("Y/m/d",$cardvalue['expirydate']).'</td> 
								<td style="width:60px;" align="center">'.$cardvalue['validityday'].'天</td>
								<td style="width:60px;" align="center">'.$cardvalue['money'].'</td>
								<td style="width:60px;"  id="status'.$cardvalue['id'].'" align="center">'.$cardvalue['status'].'</td>
								<td style="width:60px;"  id="openway'.$cardvalue['id'].'" align="center">'.$cardvalue['openway'].'</td>
								<td style="width:90px;"  align="center">'.$cardvalue['ownid'].'</td>
								
								<td id="td'.$cardvalue['id'].'"><a href="__APP__/Querycard/updatecarddata?id='.$cardvalue['id'].'">修改</a>'; if ($cardvalue['status']=="已激活") { echo '/<a id="lock" style="cursor:pointer" onclick="ajaxlock('.$cardvalue['id'].')" >锁定</a>'; } else if ($cardvalue['status']=="已锁定") { echo '/<a id="open" style="cursor:pointer" onclick="ajaxopen('.$cardvalue['id'].')">激活</a>'; } else if ($cardvalue['status']=="未激活") { echo '/<a id="open"  style="cursor:pointer" onclick="ajaxopen('.$cardvalue['id'].')">激活</a>'; } if($_SESSION['power']==1) { echo '/<a id="del"  style="cursor:pointer" onclick="ajaxdel('.$cardvalue['id'].')">删除</a>'; } echo '</td></tr>'; } }else { echo '<tr> <td colspan="8" align="center" style="color:red;"> 没有符合您要找的账号卡信息</td></tr>'; } ?>
			
		<tr style="background-color:#E5E5E5;height:15px;" align="center">	
			<td colspan="11">
					
						<?php  if (!empty($list)) { echo $page; } ?>				
						
			</td>
		</tr>
	</tbody>
</table>
		
	 </div>
		
		<br/><br/><br/><br/><br/>
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>

	</body>
</html>