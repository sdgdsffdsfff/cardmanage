<?php
/**************************************************************************************
 ***  说明：后台管理员管理类
 ***  作者：小卢
 ***  日期：2012-08-12
 *************************************************************************************/
 
class AdminAction extends CommonAction {


 /*      function adminSet(){
	     $admin=D('admin');
		$admin_data->where("name='".$_SESSION['admin']."'")->find();
		$this->assign('admin',$admin_data);
		$this->assign('timer',$this->getTime()); 
		$this->display();
	    
	}
	function updateAdmin(){
	    if(!$_POST['name']){
		$this->assign('message','管理员名不能为空！');
		$this->error();
		}
		if($_POST['pwd']!=$_POST['repwd']){
		$this->assign('message','重复密码不正确！');
		$this->error();
		}
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
		
		$admin=D('admin');
		$data['name']=$_POST['name'];
		$data['pwd']=md5($_POST['pwd']);
		$data['email']=$_POST['email']; 
		if($admin->where("name='".$_SESSION['admin']."'")->save($data)){
		$this->success('设置成功！');
		}else{
		$this->assign('timer',$this->getTime());
		$this->error();
		}
		
	}
	
	function indexUser(){
	
	$user=D('user');
	$user_data=$user->select();
	$this->assign('user',$user_data);
	
	$this->assign('timer',$this->getTime());
	$this->display();
	}
	function addUser(){
	
	$this->assign('timer',$this->getTime());
	$this->display();
	}  
	function modUser(){
	
	$user=M('user');
	$user_data=$user->find();
	$this->assign('user',$user_data);
	$this->assign('timer',$this->getTime());
	$this->display();
	}
	function insertUser(){
	
	    if(!$_POST['name']){
		$this->assign('message','用户名不能为空！');
		$this->error();
		}
		if($_POST['pwd']!=$_POST['repwd']){
		$this->assign('message','重复密码不正确！');
		$this->error();
		}
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
		
		$user=D('user');
		$data['name']=$_POST['name'];
		$data['pwd']=md5($_POST['pwd']);
		$data['email']=$_POST['email']; 
		if($user->add($data)){
		$this->success('用户添加成功！');
		}else{
		$this->assign('message','用户添加失败！');
		$this->error();
		}
	
	}
	function updateUser(){
		
		if(!$_POST['name']){
		$this->assign('message','用户名不能为空！');
		$this->error();
		}
		if($_POST['pwd']!=$_POST['repwd']){
		$this->assign('message','重复密码不正确！');
		$this->error();
		}
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
		
		$user=D('user');
		$data['name']=$_POST['name'];
		$data['pwd']=md5($_POST['pwd']);
		$data['email']=$_POST['email']; 
		if($user->where("id='".$_POST['id']."'")->save($data)){
		$this->success('设置成功！');
		}else{
		$this->assign('message','设置失败！');
		$this->error();
		}
	}
	function delUser(){
		
        $user=M('user');		
		if($user->where('id='.$_GET['id'])->delete()){
			$this->success("删除用户成功！");
		}else{
			$this->assign('message','删除用户失败！');
			$this->error();
		} */

	}


?>