<?php
/**************************************************************************************
 ***  DonatemoneyAction.class.php
 ***  说明：卡查询
 ***  日期：2012-08-12
 *************************************************************************************/

//DonatemoneyAction 控制类继承统一入口加载类 CommonAction
class DonatemoneyAction extends  CommonAction {


    function index(){
    	 import('ORG.Util.Page');

    	$pagesize=17;
    	$donate_model=M('donate');
	    	if ($_SESSION['power']==1) 
	    	{
			        $count    = $donate_model->where($data)->count();// 查询满足要求的总记录数
			        $Page     = new Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
			        $Page->setConfig('header','条赠送金额信息');
			        $Page->setConfig('prev','上一页');
			        $Page->setConfig('next','下一页');
			        $Page->setConfig('theme','共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%'); 
			        $show = $Page->show();// 分页显示输出
			        //进行分页数据查询 注意limit方法的参数要使用Page类的属性			        
			        $list = $donate_model->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();     		       
			        $list=$this->getusername($list);
			        $list=$this->formatfield($list);
			        $this->assign('list',$list);  // 赋值数据集
			        $this->assign('page',$show);  // 赋值分页输出
			        $this->display();             // 输出模板

		    }else
		    {
		    	  //$_SESSION['accountid']=19;
                  $sql="select count(id) from cb_donate where userid in (select id from cb_users where phonenum in(select bindtel from cb_cards where subownid =".$_SESSION['accountid']." or ownid=".$_SESSION['accountid']."))";
                  $arr= $donate_model->query($sql);       
                  $count =$arr[0]['count']; 
                  $Page = new Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
                  $Page->setConfig('header',$header);
                  $Page->setConfig('prev','上一页');
                  $Page->setConfig('next','下一页');
                  $Page->setConfig('theme','共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');    
                  $show       = $Page->show();// 分页显示输出
                  // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
                  $sql="select * from cb_donate where userid in (select id from cb_users where phonenum in(select bindtel from cb_cards where subownid =".$_SESSION['accountid']." or ownid=".$_SESSION['accountid']."))";
                 
                  $sql=$sql." limit ".$Page->listRows." offset ".$Page->firstRow;      
				  $list = $donate_model->query($sql);
				  $list=$this->getusername($list);
				  $list=$this->formatfield($list);
				  $this->assign('list',$list);  // 赋值数据集
				  $this->assign('page',$show);  // 赋值分页输出	               
				  $this->display();    
		    }

    }

     function getusername($list)
     {           
     	     //print_r($list); 
     	     //echo '<pre>';
     	     //print_r($list);
     	     $user_model = M('users');
     	     $userarray = $user_model->getfield('id,loginname',true);
     	     foreach ($list as $key => $value) {

     	     	        $list[$key]['userid']=$userarray[$value['userid']];	  
     	     }
     	     //print_r($list);
             //exit(); 
             return $list;
     }

     function formatfield($list)
     {

     	  foreach ($list as $key => $value)
     	  {
     	  	   $list[$key]['dotime']=date('Y-m-d H:i:s' ,$value['dotime']);  	          
     	  }

     	  //print_r($list);
     	  //exit();
     	  return $list;
     }



     function query()
     {
      		import('ORG.Util.Page'); 	  
            $starttime=$_GET['starttime'];
            $endtime=$_GET['endtime'];
            $starttime=intval(strtotime($starttime));
            $endtime=intval(strtotime($endtime));
    	    $donate_model=M('donate');
    	    $where='dotime>='.$starttime.'and dotime<='.$endtime;
	    	if ($_SESSION['power']==1) 
	    	{      
	    			$count=$donate_model->where($where)->count();// 查询满足要求的总记录数
	    			$Page = new Page($count,17);
			        $list = $donate_model->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();     	      
			        $list=$this->getusername($list);
			        $list=$this->formatfield($list);
			        $show=$Page->show();

		    }else
		    {
			    	$sql="select count(id) from cb_donate where userid in (select id from cb_users where phonenum in(select bindtel from cb_cards where subownid =".$_SESSION['accountid']." or ownid=".$_SESSION['accountid']."))";
			    	$arr= $donate_model->query($sql);
			    	$count =$arr[0]['count'];		
			    	$Page = new Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
                    $sql="select * from cb_donate where userid in (select id from cb_users where phonenum in(select bindtel from cb_cards where subownid =".$_SESSION['accountid']." or ownid=".$_SESSION['accountid'].")) and ".$where;        
                    $sql=$sql." limit ".$Page->listRows." offset ".$Page->firstRow;
                    $list = $donate_model->query($sql);
					$list=$this->getusername($list);
					$list=$this->formatfield($list);
					$show=$Page->show();
							  
		    }
		    $this->assign('list',$list);  // 赋值数据集
		    $this->assign('page',$show);  // 赋值分页输出
		    $this->display('index');             // 输出模板

     }

}