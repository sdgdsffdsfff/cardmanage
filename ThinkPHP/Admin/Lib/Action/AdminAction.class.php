<?php
/**************************************************************************************
 ***  文件：AdminAction.class.php
 ***  说明：后台管理员管理类
 ***  作者：小卢
 ***  日期：2012-08-12
 *************************************************************************************/
 
//AdminAction控制类继承统一入口加载类CommonAction
class AdminAction extends CommonAction {

  
   /***************************************
     *** 函数名：adminSet
     *** 参数：无
     *** 功能 ：管理员信息设置界面的显示
	****************************************/	
   
   function adminSet(){
	
	    //实例化admin表的数据模型
	    $admin=D('admin');
		
		//查询当前管理员数据
	 	$admin_data=$admin->where("name='".$_SESSION['admin']."'")->find();
		
		//向模版分配管理员信息
		$this->assign('admin',$admin_data);
		
		//脚本运行时间
		$this->assign('timer',$this->getTime());  
		
		//模版显示输出
		$this->display();
	    
	}

	
    /***************************************
     *** 函数名：updateAdmin
     *** 参数：无
     *** 功能 ：更新管理员信息
	****************************************/	
	
	function updateAdmin(){
	
	    //判断传递的管理员名字为空则提示错误
	    if(!$_POST['name']){
		
		//设置错误提示信息
		$this->assign('message','管理员名不能为空！');
		
		//显示错误提示模版
		$this->error();
		}
		
		//同上判断密码
		if($_POST['pwd']!=$_POST['repwd']){
		$this->assign('message','重复密码不正确！');
		$this->error();
		}
		//同上判断邮箱
		if(!$_POST['email']){
		$this->assign('message','邮箱不能为空！');
		$this->error();
		}else{
		    
		//对邮箱格式进行匹配匹配判断是否为邮箱地址
		$pattern="/^([a-zA-Z0-9_-])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+([.a-zA-Z0-9_-]+[a-zA-Z0-9_-])+[a-zA-Z0-9_-]$/";
		if(!preg_match($pattern,$_POST['email'])){
		$this->assign('message','邮箱格式不正确！');
		$this->error();
		}
		}
		
		//实例化admin模型
		$admin=D('admin');
		
		//设置更新的admin记录的数据
		$data['name']=$_POST['name'];
		$data['pwd']=md5($_POST['pwd']);
		$data['email']=$_POST['email'];
        
        //进行更新并判断是否更新成功		
		if($admin->where("name='".$_SESSION['admin']."'")->save($data)){
		$this->success('设置成功！');
		}else{
		$this->assign('message','设置失败！');
		$this->error();
		}
		
	}
	
	
    /***************************************
     *** 函数名：indexUser
     *** 参数：无
     *** 功能 ：用户管理的首页用户信息列表
	****************************************/	
	
	function indexUser(){
	
		//实例化user用户模型
		$user=M('user');
		
		//获取所以用户信息
		$user_data=$user->select();
		
		//分配用户信息数据
		$this->assign('user',$user_data);
		
		//分配脚本运行时间
		$this->assign('timer',$this->getTime());
		
		//输出模版
		$this->display();
	}
	
	
    /***************************************
     *** 函数名：addUser
     *** 参数：无
     *** 功能 ：添加用户的界面显示
	****************************************/	
	
	function addUser(){
	
		//分配脚本运行时间
		$this->assign('timer',$this->getTime());
		
		//输出模版
		$this->display();
	
	}  
	
   /******************************************
     *** 函数名：modUser
     *** 参数：无
     *** 功能 ：管理员修改用户账户信息界面显示
	******************************************/	
	
	
	function modUser(){
	    
		//实例化user用户模型
		$user=M('user');
		
		//查询出当前要修改的用户的账户信息
		$user_data=$user->where("id='".$_GET['id']."'")->find();
		
		//分配要查询的用户信息
		$this->assign('user',$user_data);
		
		//分配脚本运行时间
		$this->assign('timer',$this->getTime());
		
		//模版输出
		$this->display();
	}
	
    /***************************************
     *** 函数名：insertUser
     *** 参数：无
     *** 功能 ：插入添加的新用户
	****************************************/	
	
	function insertUser(){
	
	    //判断提交的用户名是否为空
	    if(!$_POST['name']){
		$this->assign('message','用户名不能为空！');
		$this->error();
		}
		
		//判断密码是否为空
		if($_POST['pwd']!=$_POST['repwd']){
		$this->assign('message','重复密码不正确！');
		$this->error();
		}
		
		//判断邮箱是否为空
		if(!$_POST['email']){
		$this->assign('message','邮箱不能为空！');
		$this->error();
		}else{
			$pattern="/^([a-zA-Z0-9_-])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+([.a-zA-Z0-9_-]+[a-zA-Z0-9_-])+[a-zA-Z0-9_-]$/";
			if(!preg_match($pattern,$_POST['email'])){
			$this->assign('message','邮箱格式不正确！');
			$this->error();
			}
		}
		
		//实例化user模型类
		$user=M('user');
		
		//设置插入的新用户的账户信息数据
		$data['name']=$_POST['name'];
		$data['pwd']=md5($_POST['pwd']);
		$data['email']=$_POST['email']; 
		
		//插入数据并判读
		if($user->add($data)){
		$this->success('用户添加成功！');
		}else{
		$this->assign('message','用户添加失败！');
		$this->error();
		}
	
	}
	
   /***************************************
     *** 函数名：updateUser
     *** 参数：无
     *** 功能：更新用户账户信息的方法
	****************************************/		
	function updateUser(){
		
		//判断用户名是否为空
		if(!$_POST['name']){
		$this->assign('message','用户名不能为空！');
		$this->error();
		}
		
		//判读密码是否为空
		if($_POST['pwd']!=$_POST['repwd']){
		$this->assign('message','重复密码不正确！');
		$this->error();
		}
		
		//判断邮箱是否为空
		if(!$_POST['email']){
		$this->assign('message','邮箱不能为空！');
		$this->error();
		}else{
		
		//使用正则判断邮箱格式
		$pattern="/^([a-zA-Z0-9_-])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+([.a-zA-Z0-9_-]+[a-zA-Z0-9_-])+[a-zA-Z0-9_-]$/";
		if(!preg_match($pattern,$_POST['email'])){
		$this->assign('message','邮箱格式不正确！');
		$this->error();
		}
		}
		
		//实例化用户模型
		$user=M('user');
		
		//设置更新的新用户的账户信息数据
		$data['name']=$_POST['name'];
		$data['pwd']=md5($_POST['pwd']);
		$data['email']=$_POST['email'];

        //更新用户数据		
		if($user->where("id='".$_POST['id']."'")->save($data)){
		$this->success('设置成功！');
		}else{
		$this->assign('message','设置失败！');
		$this->error();
		}
	}
	
	/******************************************************************
     *** 函数名：delUser
     *** 参数：无
     *** 功能 ：删除用户账户的方法
	 *** 备注：这里并没有删除被删除用户除用户账户信息表的所有其他信息
	******************************************************************/	
	
	function delUser(){
		
		//实例化user模型
        $user=M('user');
        
        //对用户账户进行删除		
		if($user->where('id='.$_GET['id'])->delete()){
			$this->success("删除用户成功！");
		}else{
			$this->assign('message','删除用户失败！');
			$this->error();
		}  
 
	}

}
?>