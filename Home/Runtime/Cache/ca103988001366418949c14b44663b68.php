<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>	

	</head>
	
	<body>
		<div id="main">

		    <div class='head-dark-box'>
					<div class='tit'>内容管理>账号卡查询>账号卡信息</div>
			</div>	
				
<table rules="all" id="MyGridView" style="border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:75%;border-collapse:collapse;" cellpadding="3" cellspacing="0" align="Center" border="1">
		
		<tbody>
		<tr style="background-color:#E5E5E5;font-weight:bold;height:15px;">
			<th scope="col">电话</th>
			<th scope="col">余额</th>
			<th scope="col">最后使用时间</th>
			<th scope="col">注册日期</th>
			<th scope="col">有效期</th>
			<th scope="col">查看</th>
			<th scope="col">操作</th>	
		
		</tr>
			   
	         <?php
 if (!empty($userdata)) { foreach ($userdata as $key => $cardvalue) { echo '<tr style="height:25px;" align="center"><td align="center" width="100px">'.$cardvalue['phonenum'].'</td>
								<td style="width:110px;" align="center">'.$cardvalue['banlance'].'</td>
								<td style="width:110px;"  align="center">'.$cardvalue['lastusetime'].'</td>
								<td style="width:110px;" align="center">'.$cardvalue['registedate'].'</td>
								<td style="width:90px;"  align="center">'.$cardvalue['expirydate'].'</td>
								<td style="width:150px;"  align="center">
								    <a href="__APP__/Queryphone/querybillrecord?id='.$cardvalue['id'].'">账单查询</a>/
								    <a href="__APP__/Queryphone/queryrechargemsg?phonenum='.$cardvalue['phonenum'].'&id='.$cardvalue['id'].'">充值查询</a>
							    </td>				
								<td><a href="__APP__/Queryphone/updatephone?id='.$cardvalue['id'].'">修改</a></td></tr>'; } }else { echo '<tr> <td colspan="7" align="center" style="color:red;"> 没有符合您要找的账号卡信息</td></tr>'; } ?>
			
		<tr style="background-color:#E5E5E5;height:15px;" align="right">	
			<td colspan="9">
					<table border="0" style="font:12px Verdana,Arial,Helvetica,sans-serif;">
						<tbody>
						<tr>
						    <td colspan="7" align="center"> 
							<?php echo ($page); ?>
				            </td>
						
						</tr>
					</tbody>
				</table>
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