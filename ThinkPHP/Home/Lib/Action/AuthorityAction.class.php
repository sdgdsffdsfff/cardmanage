<?php
/**************************************************************************************
 ***  文件：AuthorityAction.class.php
 ***  说明：代理商权限管理类
 ***  日期：2012-08-12
 *************************************************************************************/

//AuthorityAction控制类继承统一入口加载类CommonAction
class AuthorityAction extends  CommonAction {

      #添加用户
	function addaccount()
	{

		if(!$this->chk_delspau())
		{
		    //跳转到错误页面
	    	$this->assign('message','您暂无此添加用户权限');
			  $this->error();
	    }

    $this->assign('timer',$this->getTime());
		$this->assign();
		$this->display();	    
	}



	function addaccountdata()
	{
		#验证用户权限
		if(!$this->chk_delspau())
		{
		    //跳转到错误页面
	    	$this->assign('message','您暂无此添加用户权限');
		  	$this->error();
	    }
         $this->validatorfield($_POST);    
         $account_model=M('account');

         //还应该检查用户添加的权限是不是该用户有  防止攻击

         //还需要验证事实不是已经有此用户名
         $chkdata=$account_model->where('loginname='.$_POST['loginname'])->getfield('id');
		 if (!empty($chkdata)) {	 	
	 	   //跳转到错误页面
	    	$this->assign('message','用户用户名已存在');
			  $this->error();
		 }      
        //post 传递过来的值解析为权限数组然后添加
          $array=array(
            	'up_bindtel',
            	'up_cardpwd',
            	'up_userexpirydate',
            	'man_cardstatus',
            	'up_cardmoney',
            	'chk_billrecord',
            	'count_data',
            	'transfer_card');
           $authoritydata=array();
           $authorityarr = $_POST['authority'];
           foreach ($array as  $value) {
                     if (in_array($value,$authorityarr)) 
                     	$authoritydata[$value]=1; 
                     else             
                        $authoritydata[$value]=0;          
           }

         //添加其他代理商的代理商id
         //$accountdata代理商数据
  		 $accountdata['loginname']=trim($_POST['loginname']);
  		 $accountdata['loginpwd']=trim($_POST['loginpwd']).md5('timelesszhuang'.trim($_POST['loginname']));
  		 $accountdata['status']=trim($_POST['status']);
  		 $accountdata['tele']=trim($_POST['tele']);
  		 $accountdata['remark']=trim($_POST['remark']);	 

  		 //由此确定
  		 $accountdata['power']=$_SESSION['power']+1;
  		 $accountdata['ownid'] = $_SESSION['accountid'];


          //事务处理开始
         $tranDb = new Model();  
         $tranDb->startTrans();  
    
        $statusAc = $tranDb->table('cb_account')->add($accountdata);  
        $accountid = $tranDb->table('cb_account')->where('loginname='.$_POST['loginname'])->getfield('id');
        $authoritydata['accountid'] = $accountid;    
        $statusAp = $tranDb->table('cb_power')->add($authoritydata);

        if($statusAc && $statusAp)  
        {  
            $tranDb->commit();  
            $operdetail='用户'.$_SESSION['loginname'].'添加代理商'.$accountdata['loginname'];
            $this->addlog($operdetail,'添加用户');
            $this->assign('message','添加用户成功！');
            $this->success();
        }  
        else   
        {  
            $tranDb->rollback();     
            $operdetail='用户'.$_SESSION['loginname'].'添加代理商'.$accountdata['loginname'].'失败';
            $this->addlog($operdetail,'添加用户');
            $this->assign('message','添加用户失败！请重试');
            $this->success();
        }  

	}

   
    #验证字段
    function validatorfield($userdata)
    {
    	if(empty($userdata['loginname']))
    	{
    		//跳转到错误页面
	    	$this->assign('message','用户用户名不可为空');
			$this->error();
    	}
        if(empty($userdata['loginpwd']))
        {
            //跳转到错误页面
	    	$this->assign('message','密码不可为空');
			$this->error();
        }
        if (empty($userdata['tele'])) {
            //跳转到错误页面
	    	$this->assign('message','手机号码不可为空');
			$this->error();
        }
         
        if (empty($userdata['authority'])) {
            //跳转到错误页面
	    	$this->assign('message','请选择用户权限');
			$this->error();
        }
    }



	#删除用户  只是把其状态改成锁定
	function deleteaccount() 
	{		
		//分配变量
		if(!$this->chk_delspau())
		{
		    //跳转到错误页面
	    	$this->assign('message','您暂无删除用户权限');
			  $this->error();
	 }

		$account_model=M('account');
		//不可以跨级删除用户  但如果上级用户被删除  下一级用户也应该相应被删除
		$accountdata=$account_model->where('ownid='.$_SESSION['accountid'])->select();
		$this->assign('timer',$this->getTime());		
		$this->assign('accountdata',$accountdata);
		$this->display();
	}


   function deleteaccdata()
   {
   		#验证用户权限
		if(!$this->chk_delspau())
		{
		    //跳转到错误页面
	    	$this->assign('message','您暂无删除用户权限');
			  $this->error();
	   }

     //还要验证要删除的用户是不是改代理商下级代理商
	   $accountid=$_GET['id'];

     /*
      //事务处理开始
      $tranDb = new Model();  
      $tranDb->startTrans();  
      $statusDa = $tranDb->table('cb_account')->where('id='.$accountid)->delete();   
      $statusDp = $tranDb->table('cb_power')->where('accountid='.$accountid)->delete();    

       /*if ($_SESSION['power']==1) {
          
          $idarr = $tranDb->table('cb_account')->where('ownid='.$accountid)->getfield('id',true);   
          print_r($idarr); 
          foreach ($idarr as $key => $id) {

             $statusDparr[$key] = $tranDb->table('cb_power')->where('accountid='.$id)->delete();
             $statusDaarr[$key] = $tranDb->table('cb_account')->where('id='.$id)->delete();                    
            
            }         
       }
     
       //$statusDperp = $this->chkstatus($statusDparr);
       //$statusDpera = $this->chkstatus($statusDaarr);
       //exit();
      if($statusDa && $statusDp)  
      {  
          $tranDb->commit(); 
          echo '1'.$statusDp.'2'.$statusDa; 
          $operdetail='用户'.$_SESSION['loginname'].'添加代理商'.$accountdata['loginname'];
          $this->addlog($operdetail,'添加用户');
          $this->assign('message','删除代理商成功！');
          $this->success();
      }  
      else   
      {  
          $tranDb->rollback();  
          echo '1'.$statusDp.'2'.$statusDa;    
          $operdetail='用户'.$_SESSION['loginname'].'删除代理商'.$accountdata['loginname'].'失败';
          $this->addlog($operdetail,'添加用户');
          $this->assign('message','删除代理商失败！请重试');
          $this->error();
      }  
    */

      //事务不支持   有点风险。。。。。。
	   $account_model=M('account');
	   $power_model=M('power');
     $status=$account_model->where('id='.$accountid)->delete();
     $power_model->where('accountid='.$accountid)->delete();
      			
      //echo $accountid;			
      //总管理员同时删除下级代理商
       if (!$status) {
       	     $this->assign('message','删除用户失败');
			       $this->error();
       }

       if ($_SESSION['power']==1) {
          
       	  $idarr = $account_model->where('ownid='.$accountid)->getfield('id',true);
       	  //print_r($idarr);
          foreach ($idarr as $key => $id) {

            	$power_model->where('accountid='.$id)->delete();
       	      $account_model->where('id='.$id)->delete();           
            }         
       }


       if($status)
       {
       	   	$this->assign('message','删除用户成功');
			      $this->success();
       } 
   }


   /*
   # 查看删除用户账号状态 事务时用的  返回删除成功或失败   
   function  chkstatus($arr)
   {

        echo '<pre>';
        print_r($arr);
        echo '</pre>';

   }
   */



	#更新用户
	function  updateaccount()
	{
		#验证用户权限
		if(!$this->chk_delspau())
		{
		    //跳转到错误页面
	    	$this->assign('message','您暂无删除用户权限');
			  $this->error();
	  }


    $account_model=M('account');
		//不可以跨级删除用户  但如果上级用户被删除  下一级用户也应该相应被删除
		$accountdata=$account_model->where('ownid='.$_SESSION['accountid'])->select();
		$this->assign('timer',$this->getTime());		
		$this->assign('accountdata',$accountdata);
		$this->display();
	}


	#初始化数据修改 
	function  updateaccdata()
	{		
		#验证用户权限
		if(!$this->chk_delspau())
		{
		    //跳转到错误页面
	    	$this->assign('message','您暂无删除用户权限');
			$this->error();
	    }

	    //还要判断是不是该代理商下一级的代理商

		$id=$_GET['id'];
		$account_model=M('account');
		$power_model=M('power');
	  $accountdata= $account_model->where('id='.$id)->select();
		$powerdata=$power_model->where('accountid='.$id)->select();
    $accountdata[0]['loginpwd'] = $loginpwd=substr($accountdata[0]['loginpwd'],0,-32);
		$this->assign('accountdata',$accountdata);
		$this->assign('powerdata',$powerdata);
		$this->display();
	}


	#数据修改到数据库  
	#注意要把相应的子代理商权限修改了; 
	function  updateacc()
	{
	   
		#验证用户权限
		if(!$this->chk_delspau())
		{
		    //跳转到错误页面
	    	$this->assign('message','您暂无此添加用户权限');
			  $this->error();
	    }

         $this->validatorfield($_POST);    
         $account_model=M('account');
         $power_model=M('power');

         //修改之前的权限
         $powerdata=$power_model->where('accountid='.$_POST['id'])->select();

         $array=array(
            	'up_bindtel',
            	'up_cardpwd',
            	'up_userexpirydate',
            	'man_accstatus',
            	'up_cardmoney',
            	'up_rechcdpwd',
            	'man_rechcdstatus',
            	'chk_billrecord',
            	'count_data',
            	'transfer_card');
           //权限修改之后的权限
           $authoritydata=array();
           $authorityarr = $_POST['authority'];
           foreach ($array as  $value) {
                     if (in_array($value,$authorityarr)) 
                     	$authoritydata[$value]=1; 
                     else             
                        $authoritydata[$value]=0;          
           }

       //验证权限是否更改
       //$reauthoritydata直接作为数据更新到power数据库
       $reauthoritydata = $this->validatorauthority($powerdata,$authoritydata,$array);

  		 $accountdata['loginname']=trim($_POST['loginname']);
  		 $accountdata['loginpwd']=trim($_POST['loginpwd']).md5('timelesszhuang'.trim($_POST['loginname']));
  		 $accountdata['status']=trim($_POST['status']);
  		 $accountdata['tele']=trim($_POST['tele']);
  		 $accountdata['remark']="备注信息";	 

  		 //由此确定
  		 $accountdata['power']=$_SESSION['power']+1;
  		 $accountdata['ownid'] = $_SESSION['accountid'];

       $account_model=M('account');

       $up_accstatus=$account_model->where('id='.$_POST['id'])->save($accountdata); 

       $up_powersataus=true;
         if (!empty($reauthoritydata)) {
           $up_powersataus=$power_model->where('accountid='.$_POST['id'])->save($reauthoritydata); 
         }

        /*同事把其他用户的信息也改正*/











         if (!($up_accstatus&&$up_powersataus)) {
         	//跳转到错误页面
         	$operdetail='用户'.$_SESSION['loginname'].'尝试修改代理商'.$accountdata['loginname'].'信息，但失败。';
         	$this->addlog($operdetail,'修改用户信息');
	    	  $this->assign('message','修改用户信息失败，请重试！');
			    $this->error();
         }
         else
         {
	        //需要建立一个实现operdetail的函数。
	        //$operdetail='用户'.$_SESSION['loginname'].'修改代理商'.$accountdata['loginname'];
 	   		  //$this->addlog($operdetail,'修改用户信息');
 	        $this->assign('message','添加用户成功！');
			    $this->success();		      
         }
	}


	#比较权限是否已经更改
  #修改之前权限 修改之后的权限 

	function validatorauthority($powerdata,$authoritydata,$array)
	{
		$reauthoritydata=array();
		foreach ($array as $value) {
			if($powerdata[0][$value]!=$authoritydata[$value])
			$reauthoritydata[$value]=$authoritydata[$value];
		}
     return $reauthoritydata;
	}

}

?>