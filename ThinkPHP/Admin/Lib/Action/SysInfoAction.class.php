<?php
/**************************************************************************************
 ***  文件：SysInfoAction.class.php
 ***  说明：网站信息配置管理类
 ***  作者：小卢
 ***  日期：2012-08-12
 *************************************************************************************/

// SysInfoAction控制类继承加载类CommonAction
class SysInfoAction extends CommonAction {


	/***************************************
     *** 函数名：show
     *** 参数：  无
     *** 功能 ： 显示网站配置信息
	 ****************************************/
	function show(){
		
		//获取网站信息
		$webInfo=M('webinfo');
		$webInfo_data=$webInfo->find();
		$this->assign('webInfo',$webInfo_data);
		
		//获取服务器标识的字符串
		$sysos=$_SERVER["SERVER_SOFTWARE"];
		$this->assign('sysos',$sysos);
		
		//获取服务器版本信息
		$sysversion=PHP_VERSION;
		$this->assign('sysversion',$sysversion);
		
		//获取数据库版本信息
		$mysqlinfo=mysql_get_server_info();
		$this->assign('mysqlinfo',$mysqlinfo);
		
		//从服务器中获取GD库的信息
		if(function_exists("gd_info")){
		$gd=gd_info();
		$gdinfo=$gd['GD Version'];
		}else{
			$gdinfo='未知';
		}
		$this->assign('gdinfo',$gdinfo);
		
		//从GD库中查看是否支持FreeType字体
		$freetype=$gd["FreeType Support"]?"支持":"不支持";
		$this->assign('freetype',$freetype);
		
		//从php配置文件中获取是否可以远程文件获取
		$allowurl=ini_get("allow_url_fopen")?"支持":"不支持";
		$this->assign('allowurl',$allowurl);
		
		//从PHP配置文件中获取文件的最大上传限制
		$max_upload=ini_get("file_uploads")?ini_get("upload_max_filesize"):"Disabled";
		$this->assign('max_upload',$max_upload);
		
		//从php配置文件中获取脚本的最大执行时间
		$max_ex_time=ini_get("max_execution_time")."秒";
		$this->assign('max_ex_time',$max_ex_time);
		
		$this->assign('timer',$this->getTime());
		$this->display();
	}
	
	/***************************************
     *** 函数名：set
     *** 参数：  无
     *** 功能 ： 设置网站信息的显示界面
	 ****************************************/	
	function set(){
		$webInfo=M('webinfo');
		$webInfo_data=$webInfo->find();
		$this->assign('webInfo',$webInfo_data);
		$this->assign('timer',$this->getTime());
		$this->display();
	}
	
	/***************************************
     *** 函数名：update
     *** 参数：  无
     *** 功能 ： 更新设置后的网站信息的方法
	 ****************************************/	
	function update(){
		$webInfo=M('webinfo');

		//$webInfo->create();
		//print_r($_POST);
		//exit();
		//$_POST['id']=1;   

		if($webInfo->where('id=0')->save($_POST)){

		$this->success("设置成功！");

		}else{

		$this->assign('message','设置失败！');
		$this->error();

		}
	}
	

}
?>