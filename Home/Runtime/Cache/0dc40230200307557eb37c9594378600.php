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
               "json");//这里返回的类型有：json,html,xml,text
                          
            }

    </script>
</head>
<body>
<div id="main">
<div class="head-dark-box">
          <div class="tit">内容管理&gt;黑名单查询</div>
      </div>
      <br/><br/><br/>

<table rules="all" id="MyGridView" style="border-color:Black;border-width:1px;border-style:solid;font-size:10pt;height:10px;width:50%;border-collapse:collapse;" cellpadding="3" cellspacing="0" align="Center" border="1">
  <tbody>

  
    <tr style="background-color:#E5E5E5;font-weight:bold;height:15px;">
      <th scope="col" style="width:20%">编号</th>
      <th scope="col">号码</th>
      <th scope="col">操作</th>
    </tr>

       <?php  $key=1; foreach ($blacklistdata as $pervalue) { echo '<tr id="tr'.$pervalue['id'].'">
                      <td >'.$key.'</td><td>'.$pervalue['areacode'].'</td>
                          <td align="center">
                          <a id="lock" style="cursor:pointer"  onclick="ajaxdelete('.$pervalue['id'].')" >删除</a>
                          </td>
                     </tr>'; $key++; } ?>
        

     <tr>
                 <td colspan="5" align="center" style=""><?php echo ($page); ?></td>
         </tr>

    </tbody>
</table>

    <br/><br/><br/><br/><br/>
  <div id="timer">
  <p><span class="exetime">当前脚本执行用时</span><span class="red_font"><?php echo ($timer); ?></span>秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p> 
    </div>

</body>
</html>