<?php
/**************************************************************************************
 ***  文件：PublicAction.class.php
 ***  说明：后台登录公有类
 ***  作者：小卢
 ***  日期：2012-08-12
 *************************************************************************************/

class PublicAction extends Action{
	
	
	/***************************************
     *** 函数名：_initialize
     *** 参数：无
     *** 功能 ：实现Action类初始化的方法
	 ****************************************/	
	function _initialize(){
       
	   //对所有网页输出文本格式控制位utf8
        header("Content-Type:text/html; charset=utf-8");
	}

	/***************************************
     *** 函数名：verify
     *** 参数：无
     *** 功能 ：实现验证码的方法
	 ****************************************/		
	function verify(){
	    
		//导入验证码类
		import('ORG.Util.Image');
		
		//输出产生验证码
		Image::buildImageVerify();
	}
	  
}
?>