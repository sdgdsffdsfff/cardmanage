<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<title>管理平台</title>
		<meta name="Author" content="赵兴壮" />
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" >
		<script src="__PUBLIC__/js/common.js"></script>
		<script src="__PUBLIC__/js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="__PUBLIC__/js/tc.min.js"></script>
		<script type="text/javascript">

					function ajaxdelete(id){

                          //alert(id);                        
						  $.post("__APP__/Ratemanage/delete",
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
						   "json");//这里返回的类型有：json,html,xml,text
                          
						}

		</script>
</head>
<body>
<div id="main">
<div class="head-dark-box">
					<div class="tit">内容管理&gt;赠送管理&gt;赠送管理</div>
			</div>
			<br/><br/><br/>

<table rules="all" id="MyGridView" style="border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:90%;border-collapse:collapse;" cellpadding="3" cellspacing="0" align="Center" border="1">
	<tbody>

		<tr>
			<!--<td colspan="5" >
							
					<a href="__APP__/Donatemoney/donate">赠送</a>						
			</td>	--> 
		</tr>
		<tr style="background-color:#E5E5E5;font-weight:bold;height:15px;">
			<th scope="col">编号</th>
			
			<th scope="col">金额</th>
			<th scope="col">赠送时间</th>
			<th scope="col">备注</th>
		</tr>


	 
		   <?php  if (!empty($list)) { foreach ($list as $key => $pervalue) { $key=$key+1; echo '<tr id="tr'.$pervalue['id'].'">
			  		    		  <td>'.$key.'</td>
			  		              <td>'.$pervalue['money'].'</td>
			  		              <td>'.$pervalue['dotime'].'</td>
			  		              <td>'.$pervalue['remark'].'</td></tr>'; } }else { echo '<tr><td colspan="4">没有查询到赠送记录</td></tr>'; } ?>
			  


		 

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