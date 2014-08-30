<?php
/**************************************************************************************
 ***  文件：CatAction.class.php
 ***  说明：后台文章分类操作管理类
 ***  作者：小卢
 ***  日期：2012-08-12
 *************************************************************************************/
 
//ArticleAction控制类继承统一入口加载类CommonAction
class CatAction extends CommonAction {
			
   /***************************************
     *** 函数名：index
     *** 参数：无
     *** 功能 ：文章栏目分类首页管理界面的显示
	****************************************/		
	
	function index(){
	
	    // 实例化cat对象
		$cat = D('cat'); 
		
		// 导入分页类
		import('ORG.Util.Page');
		
		// 查询满足要求的总记录数
		$count      = $cat->count();
		
		// 实例化分页类 传入总记录数和每页显示的记录数
		$Page       = new Page($count,5);
		
		// 分页显示输出
		$show       = $Page->show();
		
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $cat->limit($Page->firstRow.','.$Page->listRows)->select();
		
		// 赋值数据集
		$this->assign('cat',$list);
		
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
     *** 功能 ：添加栏目界面的显示
	****************************************/	
	
	function add(){
		$this->assign('timer',$this->getTime());
		$this->display();
	}
	
	
   /***************************************
     *** 函数名：insert
     *** 参数：无
     *** 功能 ：添加栏目处理的方法
	****************************************/	
	
	function insert(){
		$cat=D('cat');
		$cat->create();
		if($_POST['colTitle']){
			if($cat->add()){
			$this->success('添加栏目成功！');
			}else{
			$this->assign('message','添加栏目失败！');
			$this->error();
			}
		}else{
			$this->assign('message','栏目标题不能为空！');
			$this->error();
		}
	}
	
	
   /***************************************
     *** 函数名：mod
     *** 参数：无
     *** 功能 ：修改栏目界面的显示
	****************************************/	
	
	function mod(){
		$cat=D('cat');
		$data=$cat->find($_GET['colId']);			
		$this->assign('cat',$data);
		$this->assign('timer',$this->getTime());
		$this->display();
	}
	
	/***************************************
     *** 函数名：update
     *** 参数：无
     *** 功能 ：更新文章栏目的方法
	****************************************/	
	
	function update(){
		if($_POST['colTitle']){
		 $cat=D('cat');
		 $cat->create();
			if($cat->save()){
			$this->success("修改成功！");
			}else{
			$this->assign('message','修改失败！');
			$this->error();
			}
		}else{
		$this->assign('message','栏目标题不能为空！');
		$this->error();
		}	 
	}
	
	/***************************************
     *** 函数名：del
     *** 参数：无
     *** 功能 ：删除栏目的方法
	****************************************/	
	
	function del(){
		$cat=D('cat');
		$article=M('article');
		if($article->where('catId='.$_GET['colId'])->select()){
			if($cat->where('colId='.$_GET['colId'])->delete()&&$article->where('catId='.$_GET['colId'])->delete()){
			$this->success("栏目及所属文章删除成功！");
			}else{
			$this->assign('message','删除失败！');
			$this->error();
			}
		}else{
			if($cat->where('colId='.$_GET['colId'])->delete()){ 								
			$this->success("栏目删除成功！");
			}else{
			$this->assign('message','删除失败！');
			$this->error();
			}
		} 
	}
	
	
 }
?>