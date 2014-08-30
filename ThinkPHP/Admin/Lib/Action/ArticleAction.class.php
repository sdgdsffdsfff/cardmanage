<?php
/**************************************************************************************
 ***  文件：Article.class.php
 ***  说明：后台文章操作管理类
 ***  作者：小卢
 ***  日期：2012-08-12
 *************************************************************************************/

//ArticleAction控制类继承统一入口加载类CommonAction
class ArticleAction extends CommonAction {

   /***************************************
     *** 函数名：index
     *** 参数：无
     *** 功能 ：文章管理首页界面的显示
	****************************************/	
   
	function index(){	
		$cat=M('cat');
		$cat_data=$cat->select();
		$this->assign('cat',$cat_data);
		if($_GET['colId']){
		$article=D('article');
		$article_data=$article->where("catId=".$_GET['colId'])->select();
		$this->assign('colId',$_GET['colId']);
		$this->assign('article',$article_data);
		}elseif($cat_data){
		$cat_first=$cat->find();
		$article=D('article');
		$article_data=$article->where("catId=".$cat_first["colId"])->select();
		$this->assign('colId',$cat_first["colId"]);
		$this->assign('article',$article_data);
		}
		$this->assign('timer',$this->getTime());
		$this->display();
	}
	

    /***************************************
     *** 函数名：add
     *** 参数：无
     *** 功能 ：添加文章界面的显示
	****************************************/	
   

	function add(){

		$cat=M('cat');
		$data=$cat->select();
		if(empty($data)){
		$this->assign('message','请先添加栏目！');
		$this->error();
		}else{
		$this->assign('cat',$data);
		}
		//分配当前时间
		$this->assign('postTime',time());
		
		//分配kindedit
		$this->assign('editor','<textarea id="editor_id" name="content" style="width:900px;height:700px; ">内容</textarea>');
		$this->assign('timer',$this->getTime());
		$this->display();
	}
		
		
   /***************************************
     *** 函数名：insert
     *** 参数：无
     *** 功能 ：插入添加文章的方法
	****************************************/	
	
	function insert(){
		
		print_r($_POST);
		exit();
		//$article=D('article');
		$_POST['postTime']=strtotime($_POST['postTime']);
		$_POST['content'] = stripslashes($_POST['content']);
		
		if(!$_POST['title']){
		$this->assign('message','文章标题不能为空！');
		$this->error();
		}
		if(!$_POST['postTime']){
		$this->assign('message','提交时间不能为空！');
		$this->error();
		}
		if(!$_POST['author']){
		$this->assign('message','文章作者不能为空！');
		$this->error();
		}
		if(!$_POST['content']){
		$this->assign('message','文章内容不能为空！');
		$this->error();
	    }
		$article->create();
		if($article->add()){
		$this->success('添加文章成功！');
		}else{
		$this->error('添加文章失败！');
		}
	}
	

   /***************************************
     *** 函数名：mod
     *** 参数：无
     *** 功能 ：对修改文章界面的显示
	****************************************/

	function mod(){
		$cat=M('cat');
		$cat_data=$cat->select();
		$this->assign('cat',$cat_data);
		$article=D('article');
		$article_data=$article->where("id=".$_GET['id'])->find();
		$this->assign('article',$article_data);
		//htmlspecialchars($article_data["content"]);//这里不用内容转义
		$this->assign('editor','<textarea id="editor_id" name="content" style="width:900px;height:700px; ">'.$article_data["content"].'</textarea>');
		$this->assign('timer',$this->getTime());
		$this->display();		
	}
		
		
   /***************************************
     *** 函数名：update
     *** 参数：无
     *** 功能 ：更新修改后文章的方法
	****************************************/	
	
	function update(){
    	if(!$_POST['title']){
		$this->assign('message','文章标题不能为空！');
		$this->error();
		}
		if(!$_POST['postTime']){
		$this->assign('message','提交时间不能为空！');
		$this->error();
		}
		if(!$_POST['author']){
		$this->assign('message','文章作者不能为空！');
		$this->error();
		}
		if(!$_POST['content']){
		$this->assign('message','文章内容不能为空！');
		$this->error();
		}
		$article=D('article');
		$article->create();
		if($article->save()){
		$this->success("修改成功！");
		}else{
		$this->error("修改失败！");
		}
    }
	
	
   /***************************************
     *** 函数名：del
     *** 参数：无
     *** 功能 ：删除文章的方法
	****************************************/	
	
	function del(){
		$article=D('article');
		if($article->where('id='.$_GET['id'])->delete()){
		$this->success("删除成功！");
		}else{
		$this->error("删除失败！");
		}
	}


}
?>