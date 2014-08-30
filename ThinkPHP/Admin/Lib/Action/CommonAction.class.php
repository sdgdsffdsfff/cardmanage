<?php
/**************************************************************************************
 ***  文件：CommonAction.class.php
 ***  说明：控制器统一加载入口验证类
 ***  作者：
 ***  日期：2012-08-12
 *************************************************************************************/

 class CommonAction extends Action {

	/******************************************
     *** 函数名：_initialize
     *** 参数：  无
     *** 功能 ： 所有控制器类的初始化方法的定义
	 ******************************************/	   
    function _initialize(){
   
        //对所有网页输出文本格式控制位utf8
        header("Content-Type:text/html; charset=utf-8");
	    
		//启用session会话判断验证管理员是否已经登陆
	 	if(!(isset($_SESSION['isLogin']) && $_SESSION['isLogin']==true)){    
			// 如果没有session则进行登录
			$this->redirect('Login/index');
		}	
    }
   
     
	/******************************************
     *** 函数名：getTime
     *** 参数：  无
     *** 功能 ： 返回脚本执行时间的方法
	 ******************************************/
    function getTime(){
   
	   //计算脚本开始时间到结束微秒时间
	   list ($usec, $sec) = explode(" ", microtime());
	   
	   //返回脚本执行时间
	   return (float) $usec + (float) $sec-time();
	}
   
  
}
   
?>