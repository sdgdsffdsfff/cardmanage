<?php
/**************************************************************************************
 ***  文件：LoginAction.class.php
 ***  说明：后台登录处理类
 ***  作者：赵兴壮
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
			 $account_model=M("account");

			 //取出提交数据
			 $admin['loginname']=$_POST['n'];
			 
			 $admin['loginpwd']=$_POST['p'].md5('timelesszhuang'.$_POST['n']);	
			 
			 //echo $admin['loginpwd'];
			 //exit();

			 //对管理员查询		
			 $userdata=$account_model->where("loginname='".$admin['loginname']."' and loginpwd='".$admin['loginpwd']."'")->limit(1)->select(); 



			if(!empty($userdata)){

				//echo $data[0]['status'];
				//exit();

					if($userdata[0]['status']=="2"){				
				           $this->assign('erro',"<font color=red>您的账号已被锁定请联系管理员</>");
				           $this->addlog("登陆",$admin['loginname']."用户尝试登陆已锁定账号",$userdata[0]['id']);
				           //exit();
			               $this->display('index');
						}else
						{
							$power_model=M('power');
							 //获取用户权限
							$powerdata = $power_model->where('accountid='.$userdata[0]['id'])->limit(1)->select();	

							//print_r($powerdata);
							//exit();

							//代理商级别写进session中
							$_SESSION['power']=$userdata[0]['power'];
							$_SESSION['accountid']=$userdata[0]['id'];
							$authority= $powerdata[0];   //解析成数组
							$_SESSION['is_Login']=true;
							$_SESSION['loginname']=$userdata[0]['loginname'];		
							$_SESSION['power']=$userdata[0]['power'];//权限
						    $_SESSION['authority']=$authority;
							redirect('../Index/index');		
						}	
						
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









