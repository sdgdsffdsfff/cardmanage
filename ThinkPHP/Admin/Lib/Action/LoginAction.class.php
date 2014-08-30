<?php
/**************************************************************************************
 ***  文件：LoginAction.class.php
 ***  说明：后台登录处理类
 ***  作者：小卢
 ***  日期：2012-08-12
 *************************************************************************************/

// FlinkAction控制类继承加载类PublicAction
class LoginAction extends PublicAction {
    
	/***************************************
     *** 函数名：index
     *** 参数：  无
     *** 功能 ： 登录界面的显示
	 ****************************************/	
	function index(){
		$this->display();	
	}
	
	/***************************************
     *** 函数名：isLogin
     *** 参数：  无
     *** 功能 ： 进行登录验证的方法
	 ****************************************/	
	function isLogin(){
	   	   
	   //判断用户名和密码是否为空
		if($_POST['n']=="" || $_POST['p']==""){
			
			//提示错误信息
			$this->assign('erro',"<font color=red>用户名密码不能为空！</>",login);
			$this->display(index);
			
			//判断验证码是否正确
		}else if($_SESSION['verify'] != md5($_POST['verify'])) {
		
			//提示错误信息
			$this->assign('erro',"<font color=red>验证码错误！</>",login);
			$this->display(index);
		}else{
						
			 //实例化管理员数据表模型					
			 $admin_data=M("admin");
			
			//取出提交数据
			 $admin['name']=$_POST['n'];
			 $admin['pwd']=md5($_POST['p']);
			 
			 //对管理员查询					 
			 $data=$admin_data->where("name='".$admin['name']."'  AND pwd='".$admin['pwd']."'")->select();
			 
			//判断是否为管理员		
			if($data){
				
				//添加session数组
				$_SESSION['isLogin']=true;
				$_SESSION['admin']=$admin['name'];
				
				//跳转到管理主页
				redirect('/MyCMS/admin.php/Index/index');
				
			}else{
			   
			   //否则提示错误
			   $this->assign('erro',"<font color=red>用户登录账号或密码错误！</>");
			   $this->display('index');
			}
		}
	   	  
	}
	
	/***************************************
     *** 函数名：Logout
     *** 参数：  无
     *** 功能 ： 退出登录处理方法
	 ****************************************/	
	
    function logout(){
	   
	    //清空当前的session
	    session(null);
	   
	    // 销毁当前session
	    session('[destroy]');
	   
	    // 进行跳转
	    header('Content-Type:text/html;charset=utf-8');
	    $this->redirect('Login/index');
	     
	}
	
	
	
 
}

?>









