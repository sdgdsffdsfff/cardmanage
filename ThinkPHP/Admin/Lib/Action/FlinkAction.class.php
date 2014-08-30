<?php 
/**************************************************************************************
 ***  文件：FlinkAction.class.php
 ***  说明：后台友情链接管理类
 ***  作者：小卢
 ***  日期：2012-08-12
 *************************************************************************************/

// FlinkAction控制类继承统一入口加载类CommonAction
class FlinkAction extends CommonAction{

	
	/***************************************
     *** 函数名：index
     *** 参数：无
     *** 功能 ：后台友情链接管理首页的显示
	 ****************************************/	
	function index(){
	
		// 实例化cat对象
		$link = M('link'); 
		
		// 导入分页类
		import('ORG.Util.Page');
		
		// 查询满足要求的总记录数
		$count      = $link->count();
		
		// 实例化分页类 传入总记录数和每页显示的记录数
		$Page       = new Page($count,5);
		
		// 分页显示输出
		$show       = $Page->show();
		
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $link->limit($Page->firstRow.','.$Page->listRows)->select();
		
		// 赋值数据集
		$this->assign('link',$list);
		
		// 赋值分页输出
		$this->assign('page',$show);
		
		//赋值脚本运行时间
		$this->assign('timer',$this->getTime());
		
		// 输出模板	
		$this->display();	
	}

	/***************************************
     *** 函数名：add
     *** 参数：无
     *** 功能 ：添加友情链接界面的显示
	 ****************************************/
	 
	function add(){
		$this->assign('timer',$this->getTime());
		$this->display();
	}
	
	/***************************************
     *** 函数名：mod
     *** 参数：无
     *** 功能 ：修改友情链接界面的显示
	 ****************************************/	
	function mod(){
		$link=M('link');
		$data=$link->find($_GET['id']);			
		$this->assign('link',$data);
		$this->assign('timer',$this->getTime());
		$this->display();
	}

	/***************************************
     *** 函数名：del
     *** 参数：无
     *** 功能 ：删除友情链接的处理方法
	 ****************************************/
	function del(){
		$link=M('link');
		if($link->where("id='".$_GET['id']."'")->delete()){
		$this->success('链接删除成功！');
		}else{
		$this->assign('message','链接删除失败！');
		$this->display();
		}
	}
	
	/***************************************
     *** 函数名：insert
     *** 参数：无
     *** 功能 ：插入友情链接的处理方法
	 ****************************************/
	function insert(){
		if(!$_POST['webName']){
		$this->assign('message','网站标题不能为空！');
		$this->error();
		}
		if(!$_POST['url']){
		$this->assign('message','网站地址不能为空！');
		$this->error();
		}
		$link=M('link');
		$link->create();
			
		if($link->add()){
		$this->success('添加链接成功！');
		}else{
		$this->assign('message','添加链接失败！');
		$this->error();
		}
	}

	/***************************************
     *** 函数名：update
     *** 参数：  无
     *** 功能 ： 更新修改后的友情链接的方法
	 ****************************************/
	function update(){
		if(!$_POST['webName']){
		$this->assign('message','网站标题不能为空！');
		$this->error();
		}
		if(!$_POST['url']){
		$this->assign('message','网站地址不能为空！');
		$this->error();
		}
		$link=M('link');
		$link->create();
			
		if($link->save()){
		$this->success('修改链接成功！');
		}else{
		$this->assign('message','修改链接失败！');
		$this->error();
		}
	}

	
}
?>