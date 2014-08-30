<?php
/**************************************************************************************
 ***  文件：QuerycardAction.class.php
 ***  说明：卡查询
 ***  日期：2012-08-12
 *************************************************************************************/

//CountcarddataAction 控制类继承统一入口加载类 CommonAction
class QuerycardAction extends  CommonAction {


  function index()
  {
    #数据统计是统计全部的
    $carddata=$this->getcarddata();
    $this->assign('carddata',$carddata);
    $this->assign('timer',$this->getTime());  
    $this->display();
    //上一页  下一页实现！  
       
  }

  function getcarddata()
  {
  	$carddata=array();
  	//总代理商直接查询全部卡信息
  	$card_model=M('cards');
  	if ($_SESSION['power']==1) {
  	 $carddata=$card_model->select();
  	}
  	//二级代理直接查询自己的
  	else if ($_SESSION['power']==3) {
  		$ownid=$_SESSION['accountid'];
  		$carddata=$card_model->where('ownid='.$ownid)->select();
  	}
  	//一级代理的  
  	else
  	{

  		//先查询还没有下发的
  		$ownid=$_SESSION['accountid'];
  		$carddata=$card_model->where('ownid='.$ownid)->select();
  		$account_model=M('account');
  		$accountidarr=$account_model->where('ownid='.$ownid)->getfield('id',true);
  		//print_r($accountidarr);
  		//exit();
  		$array=array();
  		foreach($accountidarr as $key => $value) {
  			$percarddata=$card_model->where('ownid='.$value)->select();
  			if (!empty($percarddata)){
  				//$array[$key]=$percarddata;
  				$array=array_merge($percarddata,$array);
  			}
  		}

  		$carddata=array_merge($array,$carddata);
  		echo '<pre>';
  		print_r($carddata);	
  		echo '<pre/>';
  		exit();
  	}
  	return $carddata;
  }

}

