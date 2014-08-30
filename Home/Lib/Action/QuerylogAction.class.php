<?php
/**************************************************************************************
 ***  文件：QuerylogAction.class.php
 ***  说明：电话查询查询
 ***  日期：2012-08-12
 *************************************************************************************/


class QuerylogAction extends  CommonAction {

  function index()  
  {    
  		$account=M('account');
	  	$nav=$this->infinite($account->field('id,loginname,ownid')->order('id ASC')->select(),$_SESSION['accountid']);
	  	$this->assign('nav',$nav);
      if ($_SESSION['power']==1) 
      { 
        $log_model=M('log');
        import('ORG.Util.Page');
        $header = "条操作日志";
        $pagesize = 16;
        $count  = $log_model->count();// 查询满足要求的总记录数
        //print_r($count);
        $Page   = new Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header',$header);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('theme','共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');    
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $logdata=$log_model->order('opertime desc')->limit($Page->firstRow.','.$Page->listRows)->select(); 
        //print_r($logdata);     
      }
      else
      {
        $log_model=M('log');
        import('ORG.Util.Page');
        $header = "条操作日志";
        $pagesize = 16;
        $count  = $log_model->where('accountid='.$_SESSION['accountid'])->count();// 查询满足要求的总记录数
        //print_r($count);
        $Page   = new Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header',$header);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('theme','共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');    
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $logdata=$log_model->order('opertime desc')->where('accountid='.$_SESSION['accountid'])->limit($Page->firstRow.','.$Page->listRows)->select(); 
      }
       

        $logdata = $this->formatfield($logdata);
        $this->assign('logdata',$logdata); //赋值数据集
        $this->assign('page',$show);    //赋值分页输出
        $this->display();

  }
  
  private function infinite($allacount,$ownid=0,$level=1){
  	$arr=array();
  	foreach ($allacount as $k=>$v){
  		if($v['ownid']==$ownid){
  			$v['level']=$level;
  			$arr[]=$v;
  			$arr=array_merge($arr,$this->infinite($allacount,$v['id'],$level+1));
  		}
  	}
  	return $arr;
  }
  

  function querylogbytime()
  {
          import('ORG.Util.Page');		
          $log_model=M('log');    
			    $where='';
          if($this->isPost() || isset($_REQUEST['starttime'])){
          	$starttime=trim($_REQUEST['starttime']);
          	$endtime=trim($_REQUEST['endtime']);
          	$where="opertime>='".$starttime."' and opertime<='".$endtime."'";
          	$account=M('account');
          	$nav=$this->infinite($account->field('id,loginname,ownid')->order('id ASC')->select(),$_REQUEST['accountid']);
          	$ids=$_REQUEST['accountid'].',';
          	foreach ($nav as $k=>$v){
          		$ids.=$v['id'].',';
          	}
          	$ids=rtrim($ids,',');
          	$where.=' AND accountid in('.$ids.')';
          }       

          $pagesize = 16;
          $count  = $log_model->where($where)->count();// 查询满足要求的总记录数
          //print_r($count);
          $Page   = new Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
          $logdata = $log_model->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
          $nav=$this->infinite($account->field('id,loginname,ownid')->order('id ASC')->select(),$_SESSION['accountid']);
          $this->assign('nav',$nav);
          $logdata = $this->formatfield($logdata);
          $this->assign('logdata',$logdata); //赋值数据集
          $this->assign('page',$Page->show());    //赋值分页输出
          $this->display('index');
  }


 function formatfield($data)
   {   
      $accountdata=$this->getaccountname();
      foreach ($data as $key => $perdata) {   
            $data[$key]['accountid']=$accountdata[$perdata['accountid']];    
      }
      return $data;
   }


 function getaccountname()
   {
    $account_model=M('account');
    return $account_model->getfield('id,loginname',true);    
   }


}


