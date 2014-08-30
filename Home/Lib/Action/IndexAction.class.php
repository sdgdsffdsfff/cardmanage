<?php
/**************************************************************************************
 ***  文件：IndexAction.class.php
 ***  说明：后台管理首页显示类
 ***  日期：2012-08-12
 *************************************************************************************/

//IndexAction控制类继承统一入口加载类CommonAction
class IndexAction extends  CommonAction {

	/***************************************
     *** 函数名：index
     *** 参数：无
     *** 功能 ：后台管理首页的显示
	 ****************************************/
	function index(){
		$this->display();	
	}

    /***************************************
     *** 函数名：top
     *** 参数：无
     *** 功能 ：头部的显示
	 ****************************************/
	function top(){
		$account=M('account');
		$this->assign('balance',$account->where('id='.$_SESSION['accountid'])->getField('balance'));
		$this->display();
	}

	/***************************************
     *** 函数名：menu
     *** 参数：无
     *** 功能 ：左边菜单栏显示
	 ****************************************/		
	function menu(){
		
		# 代理商查询实现 
	    # 除二级代理商都可根据代理商选择卡信息
	    if($_SESSION['power']!=3)
	    {
	        $accountdata=$this->getaccountdata();
	        $this->assign('accountdata',$accountdata);
	    } 
	    $this->display();
	}

	/***************************************
     *** 函数名：main
     *** 参数：无
     *** 功能 ：主管理框架的显示
	****************************************/
	function main(){
		$this->assign('timer',$this->getTime());
		$this->display();
	}		

	/***************************************
     *** 函数名：bottom
     *** 参数：无
     *** 功能 ：底部界面显示
	****************************************/
	function bottom(){   
		$this->assign('date',date('Y-m-d'));
		$this->display();
	}

  #获取代理商id跟名字 查询时候使用
  function getaccountdata()
  {
     $account_model=M('account');
     return  $account_model->where('ownid='.$_SESSION['accountid'])->getfield('id,loginname',true); 
  }
	//

  function regetaccountdata()
  {

  	if($this->isAjax()){
		  	 $account_model=M('account');
		     $accountdata=$account_model->where('ownid='.$_SESSION['accountid'])->getfield('id,loginname',true); 
		     $optiondata='<option value="0">全部</option>';
		     foreach ($accountdata as $key => $value)
		      {
					$optiondata=$optiondata.'<option value="'.$key.'">'.$value.'1</option>';												
			  }
	    	        $data['status']='data';
			        $data['message']=$optiondata;
			        $this->ajaxReturn($data,'json');
     }
  }
}
?>