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
						  $.post("__APP__/Contactmanage/delete",
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
					<div class="tit">内容管理&gt;联系人管理</div>
			</div>
			<br/><br/><br/>

<table rules="all" id="MyGridView" style="border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:90%;border-collapse:collapse;" cellpadding="3" cellspacing="0" align="Center" border="1">
	<tbody>

		<tr>
			<td colspan="5" >
					
						<a href="__APP__/Contactmanage/add">添加联系人</a> 		
						<a href="__APP__/Contactmanage/bulkadd">批量导入联系人</a>	
				
			</td>	
		</tr>
		<tr style="background-color:#E5E5E5;font-weight:bold;height:15px;">
			<th scope="col">编号</th>
			<th scope="col">联系人</th>
			<th scope="col">号码</th>
			<th scope="col">管理</th>
		</tr>
		
	 
		   <?php  foreach ($contactdata as $key => $pervalue) { $key=$key+1; echo '<tr id="tr'.$pervalue['id'].'">
			  		    		  <td >'.$key.'</td><td>'.$pervalue['cname'].'</td>
			  		              <td>'.$pervalue['telnum'].'</td>
			  		              <td align="center">
			  		              <a href="__APP__/Contactmanage/update?id='.$pervalue['id'].'">修改/</a>
			  		              <a id="lock"  onclick="ajaxdelete('.$pervalue['id'].')" >删除</a>
			  		              </td>
			  		         </tr>'; } ?>
		<tr>
			<td colspan="5">
				 添加联系人结果
			</td>
		</tr>     
                
         

		</tbody>
</table>

            <table id="statustable" style="color:red; font: 12px Verdana,Arial,Helvetica,sans-serif;" cellspacing="1" align="center"  width="60%">
				           
               <?php  foreach ($addresult as $key => $value) { echo '<tr><td colspan="5" align="center" style="color:red;">'.$value.'</td></tr>'; } foreach ($checkresult as $key => $value) { echo '<tr><td colspan="5" align="center" style="color:red;">'.$value.'</td></tr>'; } ?>
                 
			</table>


    <br/><br/><br/><br/><br/>
	<div id="timer">
	<p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>	
    </div>

</body>
</html>