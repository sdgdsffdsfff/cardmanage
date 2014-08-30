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


				
<table rules="all" id="MyGridView" style="border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:70%;border-collapse:collapse;" cellpadding="3" cellspacing="0" align="Center" border="1">
		
		<tbody>
		<tr style="background-color:#E5E5E5;font-weight:bold;height:15px;">
			<th scope="col">帐号</th><th scope="col">电话</th><th scope="col">注册时间</th><th scope="col">余额</th><th scope="col">状态</th><th scope="col">开通方式</th><th scope="col">代理商</th><th scope="col">查看</th><th scope="col">操作</th>
		</tr>
			
	    <tr style="height:25px;" align="center">
			<td align="center" width="100px">222373</td>
			<td style="width:100px;" align="center">1590921787</td>
			<td style="width:100px;" align="center">2014-01-01</td>
			<td style="width:80px;" align="center">280.0000</td>
			<td style="width:80px;" align="center">打开</td>
			<td style="width:80px;" align="center">电话</td>
			<td style="width:80px;" align="center">8001</td>
			<td style="width:160px;"><a href="">充值记录</a>&nbsp;<a href="">通话详单</a></td><td><a href="">修改</a></td>
		</tr>
			
		<tr style="background-color:#E5E5E5;height:15px;" align="right">	
			<td colspan="9">
					<table border="0" style="font:12px Verdana,Arial,Helvetica,sans-serif;">
						<tbody><tr>
							<td><span>1</span></td><td><a href="javascript:__doPostBack('MyGridView','Page$2')">2</a></td><td><a href="javascript:__doPostBack('MyGridView','Page$3')">3</a></td><td><a href="javascript:__doPostBack('MyGridView','Page$4')">4</a></td><td><a href="javascript:__doPostBack('MyGridView','Page$5')">5</a></td><td><a href="javascript:__doPostBack('MyGridView','Page$6')">6</a></td><td><a href="javascript:__doPostBack('MyGridView','Page$7')">7</a></td><td><a href="javascript:__doPostBack('MyGridView','Page$8')">8</a></td><td><a href="javascript:__doPostBack('MyGridView','Page$9')">9</a></td><td><a href="javascript:__doPostBack('MyGridView','Page$10')">10</a></td><td><a href="javascript:__doPostBack('MyGridView','Page$11')">...</a></td>
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