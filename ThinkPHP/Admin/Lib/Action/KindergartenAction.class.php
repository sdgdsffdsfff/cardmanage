<?php

class KindergartenAction extends CommonAction {

	function index(){
		$Kindergarten=M('kindergarten');
		$this->assign('kindergartendata',$Kindergarten->order('id desc')->getfield('id,name,desc,entertime',true));
		//print_r($Kindergarten->order('id desc')->getfield('id,name,desc,enterTime',true));
		$this->assign('timer',$this->getTime());
		$this->display();
	}

	function add()
	{	
		$this->assign('postTime',time());	
		//分配kindedit
		$this->assign('editor','<textarea id="editor_id" name="introduction" style="width:900px;height:700px; ">幼儿园简介</textarea>');
		$this->assign('timer',$this->getTime());
		$this->display();
	}

	function insert()
	{
		
		$Kindergarten=D('Kindergarten');
        
		$_POST['entertime']=strtotime($_POST['entertime']);
		$_POST['introduction'] = stripslashes($_POST['introduction']);

		if(empty($_POST['name']))
		{
		$this->assign('message','幼儿园名称不能为空！');
		$this->error();
		}

		if(empty($_POST['entertime']))
		{
		$this->assign('message','幼儿园入驻时间不能为空！');
		$this->error();
			
		}

		if(empty($_POST['introduction']))
		{
		$this->assign('message','幼儿园简介不能为空！');
		$this->error();		
		}

		if(empty($_POST['desc']))
		{
		$this->assign('message','幼儿园描述不能为空！');
		$this->error();	
		}

		if(empty($_POST['website']))
		{
		$this->assign('message','幼儿园网址不能为空！');
		$this->error();
		}

		if($Kindergarten->add($_POST)){
		$this->success('添加幼儿园信息成功');
		}else{
			$this->assign('message','添加信息失败');
		    $this->error();
		}
	}

  function mod()
  { 
  	//echo $_GET['id'];
  	if(empty($_GET['id']))
  	{
  			$this->assign('message','文章修改失败');
		    $this->error();
  	}
    $Kindergarten=D('Kindergarten');
    $Kindergartendata=$Kindergarten->where('id='.$_GET['id'])->select();
    //print_r($Kindergartendata);
  	$this->assign('kindergartendata',$Kindergartendata);
    $this->assign('editor','<textarea id="editor_id" name="introduction" style="width:900px;height:700px; ">'.$Kindergartendata[0]['introduction'].'</textarea>');
	$this->assign('timer',$this->getTime());
	$this->display();
  }



   function  update()
   {

        
		$Kindergarten=D('Kindergarten');
		$_POST['entertime']=strtotime($_POST['entertime']);
		$_POST['introduction'] = stripslashes($_POST['introduction']);       

		if(empty($_POST['name']))
		{
		$this->assign('message','幼儿园名称不能为空！');
		$this->error();
		}

		if(empty($_POST['entertime']))
		{
		$this->assign('message','幼儿园入驻时间不能为空！');
		$this->error();
			
		}

		if(empty($_POST['introduction']))
		{
		$this->assign('message','幼儿园简介不能为空！');
		$this->error();		
		}

		if(empty($_POST['desc']))
		{
		$this->assign('message','幼儿园描述不能为空！');
		$this->error();	
		}


		if(empty($_POST['website']))
		{
		$this->assign('message','幼儿园网址不能为空！');
		$this->error();
		}	

		if($Kindergarten->where("id=".$_POST['id'])->data($_POST)->save()){
		$this->success('更新幼儿园信息成功');
		}else{
			$this->assign('message','更新幼儿园信息失败,您没有更改幼儿园信息');
		    $this->error();
		}
		
   } 

   	public function del()
   	{
   		$kindergarten=M('kindergarten');
   		if($kindergarten->where('id='.$_GET['id'])->delete())
   		{
   			$this->success("幼儿园信息删除成功");
   		}
   		else
   		{
   			$this->error("删除失败！");
   		}	
   	}
   	
}
	
	