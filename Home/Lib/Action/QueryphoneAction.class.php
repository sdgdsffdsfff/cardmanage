<?php
/**************************************************************************************
 ***  文件：QueryphoneAction.class.php
 ***  说明：根据电话查询用户
 ***  日期：2014-04-12
 *************************************************************************************/

//CountcarddataAction 控制类继承统一入口加载类 CommonAction
class QueryphoneAction extends  CommonAction {

  function index()
  {
    #数据统计是统计全部的
    $carddata=$this->getphonedata();    
    $this->assign('timer',$this->getTime());  
  }

  function getphonedata()
  {  

  		$user_model=M('users');
  		$postdata=$_POST;
  		$bindtel=$postdata['bindtel'];	
      //分页信息
      $pagesize=17;
      $header="条用户信息";
  		if (!empty($bindtel)) 
  		{
             
             $phonenum=$bindtel;
             $_SESSION['phonenum']=$bindtel;

      }else
      {
            $phonenum=$_SESSION['phonenum'];
      }

        //$phonenumarr = $user_model->where($data)->order('id desc')->getfield('phonenum',true); 
        if ($_SESSION['power']==1) {

    	        	if (!empty($phonenum)) {

                  //改成分页的  
    	        		//$sql="select * from cb_users where phonenum like '%".$phonenum."%'"; //全查出来
                                
                  import('ORG.Util.Page');
                  $str='%'.$phonenum.'%';

                  $where['phonenum']=array('like',$str);      
                  $count      = $user_model->where($where)->count();// 查询满足要求的总记录数
                  $Page       = new Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
                  $Page->setConfig('header',$header);
                  $Page->setConfig('prev','上一页');
                  $Page->setConfig('next','下一页');
                  $Page->setConfig('theme','共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');    
                  $show       = $Page->show();// 分页显示输出
                  // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
                  $userdata = $user_model->where($where)->order('registedate')->limit($Page->firstRow.','.$Page->listRows)->select();
                  //$this->assign('list',$list);// 赋值数据集
                  $this->assign('page',$show);// 赋值分页输出
                  
    	        	}
    	        	else
    	        	{

    	        		//$sql="select * from cb_users";
                  import('ORG.Util.Page');              
                  $where['phonenum']=array('like',$str);      
                  $count      = $user_model->count();// 查询满足要求的总记录数
                  $Page       = new Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
                  $Page->setConfig('header',$header);
                  $Page->setConfig('prev','上一页');
                  $Page->setConfig('next','下一页');
                  $Page->setConfig('theme','共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');    
                  $show       = $Page->show();// 分页显示输出
                  // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
                  $userdata = $user_model->order('registedate')->limit($Page->firstRow.','.$Page->listRows)->select();
                  //$this->assign('list',$list);// 赋值数据集
                  $this->assign('page',$show);// 赋值分页输出
    	        	}                                   	
            }    
            else
            {			
              // $sql="select * from cb_users where '".$phonenum."' in (select bindtel from cb_cards where ownid=".$_SESSION['accountid']." or subownid=".$_SESSION['accountid'].") and phonenum='".$phonenum."'";
  			      //$sql="select * from cb_users where '".$phonenum."'  in (select bindtel from cb_cards where ownid=".$_SESSION['accountid']." or subownid=".$_SESSION['accountid'].") and phonenum='".$phonenum."'";
  			       
                  import('ORG.Util.Page');              
                  $sql="select count('id') from cb_users where phonenum in( select bindtel from cb_cards where bindtel like '%".$phonenum."%'  and cb_cards.ownid=".$_SESSION['accountid']." or cb_cards.subownid=".$_SESSION['accountid'].")";
                  $arr= $user_model->query($sql);       
                  $count  =$arr[0]['count']; 

                  $Page       = new Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
                  $Page->setConfig('header',$header);
                  $Page->setConfig('prev','上一页');
                  $Page->setConfig('next','下一页');
                  $Page->setConfig('theme','共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');    
                  $show       = $Page->show();// 分页显示输出
                  // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
                  $sql="select id,phonenum,state,banlance,lastusetime,registedate,expirydate from cb_users where phonenum in( select bindtel from cb_cards where bindtel like '%".$phonenum."%'  and cb_cards.ownid=".$_SESSION['accountid']." or cb_cards.subownid=".$_SESSION['accountid'].")";
                  $sql=$sql." limit ".$Page->listRows." offset ".$Page->firstRow;
                  $userdata = $user_model->query($sql);

                  $this->assign('page',$show);// 赋值分页输出

            }
            
        $userdata = $this->formatarrfield($userdata);
        $this->assign("userdata",$userdata);
        $this->display();
       
  }


  #更新密码使用

  function updatephone()
  {
     $user_model=M('users');
     $id=$_GET['id'];
     $userdata=$user_model->where('id='.$id)->select();
     $userdata=$this->formatfield($userdata);
     $this->assign('userdata',$userdata);
     $this->assign('timer',$this->getTime()); 
     //print_r($_SESSION);
     $this->display();

  }

   #ajax 更新数据的实现
   function updatephonedata()
   {
      if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){

          
            $id=$_POST['userid'];
            $data['loginpwd']=$_POST['loginpwd'];
            $data['remark']=trim($_POST['remark']); 
            $data['loginname']=$data['phonenum']=trim($_POST['bindtel']);
            if (!$_POST['banlance']=="") {
                $data['banlance']=trim($_POST['banlance']);
            }
			$data['state']=$_POST['state'];
            $data['expirydate']=strtotime(trim($_POST['expirydate']));
            $user_model=M('users');
			//手机号码不得重复
			if($user_model->where("phonenum='{$data['phonenum']}' AND id!='$id'")->getField('id')){
				$this->ajaxReturn(array('status'=>'failed','message'=>'电话号码已存在！'));
			}
            //$loginname=$user_model->where('id='.$id)->getfield('loginname');     
            $userinfo=$user_model->where('id='.$id)->find();               
            $status=$user_model->where('id='.$id)->save($data);
            if ($status) {
                    //操作日志
                    //$operdetail="管理员".$_SESSION['loginname']."把用户".$loginname."的有效期修改为".$_POST['expirydate']."密码修改为：".$_POST['loginpwd']."金额修改为：".$_POST['banlance']."备注：".$_POST['remark'];
            		$operdetail="管理员".$_SESSION['loginname']."对用户".$userinfo['loginname'].'进行了如下操作：';//有效期修改为".$_POST['expirydate']."修改密码,金额修改为：".$_POST['banlance']."备注：".$_POST['remark'];
               		//修改了手机号
               		if($userinfo['phonenum']!=$data['phonenum']) {
               			$operdetail.='　手机号码从'.$userinfo['phonenum'].'变为'.$data['phonenum'];
               			$cards=M('cards');
               			$cards->where("bindtel='{$userinfo['phonenum']}'")->setField('bindtel', $data['phonenum']);
               		}
                    //修改状态
               		if($userinfo['state']!=$data['state']) $operdetail.='　是否禁用改为'.($data['state']?'否':'是');
                    //修改密码
               		if($userinfo['loginpwd']!=$data['loginpwd']) $operdetail.='　密码从'.$userinfo['loginpwd'].'变为'.$data['loginpwd'];
                    //修改余额
               		if($userinfo['banlance']!=$data['banlance']) $operdetail.='　余额从'.$userinfo['banlance'].'变为'.$data['banlance'];
                    //截止日期
               		if(date('Y-m-d',trim($userinfo['expirydate']))!=date('Y-m-d',trim($data['expirydate']))) $operdetail.='　截止日期从'.date('Y-m-d',$userinfo['expirydate']).'变为'.date('Y-m-d',$data['expirydate']);
                    //备注
               		if($userinfo['remark']!=$data['remark']) $operdetail.='　备注从'.$userinfo['remark'].'变为'.$data['remark'];
               		$opertype="修改用户信息"; 
                    $data['status']="success";
                    $data['message']="修改成功"; 
            }
            else
            {     $operdetail="管理员".$_SESSION['loginname']."把用户".$userinfo['loginname']."的信息失败。";
                  $opertype="修改用户信息";      
                  $data['status']="failed";
                  $data['message']="修改失败";
            }
        } 
      $this->addlog($operdetail,$opertype);
      $this->ajaxReturn($data,"json");

   }


   #账单查询
   function  querybillrecord()
   {   
       $id= $_GET['id'];
       if (!empty($id)) {
            $billrecord_model=M('billrecord');
            $billdata= $billrecord_model->where('userid='.$id)->select();
            $sumtime = $billrecord_model->where('userid='.$id)->sum('duration');
            $sumcost = $billrecord_model->where('userid='.$id)->sum('cost');
            //print_r($sumcost);
            //print_r($sumtime);
            // exit();
            $this->assign('userid',$id);
            $this->assign('sumtime',$sumtime);
            $this->assign('sumcost',$sumcost);
            $billdata=$this->formatbillfield($billdata);
            $this->assign('billdata',$billdata);
            $this->display();
       }
    }



   #充值查询
   function queryrechargemsg()
   {
        //echo $_GET['id'];
        //exit();
        if($_SERVER['REQUEST_METHOD']=="GET")
        {
          $phonenum=$_GET['phonenum'];
          $card_model=M('cards');
          #查询属于该用户的且状态为使用的
          $chargedata=$card_model->where('bindtel='.$phonenum.'and status=2')->getfield('id,money,cardnum,filltime',true);
          $summoney=$card_model->where('bindtel='.$phonenum.'and status=2')->sum('money');

          $this->assign('summoney',$summoney);
          $this->assign('phonenum',$phonenum);
          $chargedata=$this->formatrechagefield($chargedata);
          //print_r($chargedata);
          //exit();
          $this->assign('chargedata',$chargedata);
          $this->display();
        }
   }


   function formatrechagefield($data)
   {
      foreach ($data as $key => $perdata) {
           if (!empty($perdata['filltime'])) {

             $data[$key]['filltime']=date("Y-m-d H:i:s",$perdata['filltime']);
           }
      }
       //print_r($data);
       //exit();
       return $data;
   }


   #格式化时间
   function formatbillfield($data)
   {

        //print_r($data);
        foreach ($data as $key => $perdata) {
           if (!empty($perdata['starttime'])) {

             $data[$key]['starttime']=date("Y-m-d H:i:s",$perdata['starttime']);
           }

           if (!empty($perdata['endtime'])) {
            $data[$key]['endtime']=date("Y-m-d H:i:s",$perdata['endtime']);
           }
      }

      return $data;
   }


  #把单个时间时间格式化
  function formatfield($data)
  {
       //print_r($data);
       if (!empty($data[0]['lastusetime'])) {

         $data[0]['lastusetime']=date("Y-m-d H:i:s",$data[0]['lastusetime']);
       }

       if (!empty( $data[0]['registedate'])) {
        $data[0]['registedate']=date("Y-m-d H:i:s",$data[0]['registedate']);
       }

       if (!empty($data[0]['expirydate'])) {
         $data[0]['expirydate']=date("Y-m-d",$data[0]['expirydate']);
       }

       //print_r($data);
       //exit();
      return $data;
  }
  
  function formatarrfield($userdata)
  {
      
       
       foreach ($userdata as $key => $data) {
           if (!empty($data['lastusetime'])) {

             $userdata[$key]['lastusetime']=date("Y/m/d ",$data['lastusetime']);
           }

           if (!empty( $data['registedate'])) {
            $userdata[$key]['registedate']=date("Y/m/d ",$data['registedate']);
           }

           if (!empty($data['expirydate'])) {
             $userdata[$key]['expirydate']=date("Y/m/d ",$data['expirydate']);
           }
      }

      return $userdata;
  }


    #根据时间查询充值记录
    function queryrechargebytime()
    {
         if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){

            $starttime=$_POST['starttime'];
            $endtime=$_POST['endtime'];
            $phonenum=$_POST['phonenum'];

            $starttime=intval(strtotime($starttime));
            $endtime=intval(strtotime($endtime));

            $card_model=M('cards');
            $chargedata=$card_model->where('filltime>='.$starttime.'and filltime<='.$endtime.'and bindtel='.$phonenum.'and status=2')->getfield('id,money,cardnum,filltime',true);
            $summoney = $card_model->where('filltime>='.$starttime.'and filltime<='.$endtime.'and bindtel='.$phonenum.'and status=2')->sum('money');
          

            if ($chargedata!=false) {

              $chargedata=$this->formatrechagefield($chargedata);
              $data['status']="data";

              $str='<tbody>
            <tr style="background-color:#E5E5E5;font-weight:normal;height:18px;">
                <th scope="col">编号</th>
                <th scope="col">卡号</th>
                <th scope="col">充值时间</th>
                <th scope="col">金额</th>
            </tr>';
              foreach ($chargedata as $key => $pervalue) {

                            $str= $str.'<tr style="color:Black;background-color:White;height:18px;" align="center">';
                            $str= $str.'<td style="width:35px;" align="center">'.$pervalue['id'].'</td>
                                <td style="width:100px;">'.$pervalue['cardnum'].'</td>
                                <td style="width:100px;">'.$pervalue['filltime'].'</td>
                                <td style="width:100px;" >'.$pervalue['money'].'元</td>
                                </tr>';
                   }

                  $str=$str.'<tr style="color:Black;background-color:White;height:18px;" align="center">         
                <td style="width:100px;" colspan="3" align="right" >总计</td>             
                <td style="width:60px;">'.$summoney.'元</td>
                 </tr></tbody>';

                  $data['message']=$str;
            }
            else
            {
              $data['status']='failed';
              $data['message']="该时间段该用户没有充值记录";
            }
        }
        /*
      $data['status']='success';
      $data['message']=$_POST['userid'];*/
      $this->ajaxReturn($data,"json");
    }





     #根据时间查询账单
   
    function  querybillbytime()
    {

      if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){

            $starttime=$_POST['starttime'];
            $endtime=$_POST['endtime'];
            $userid=$_POST['userid'];

            $starttime=intval(strtotime($starttime));
            $endtime=intval(strtotime($endtime));

            $billrecord_model=M('billrecord');
            $billdata=$billrecord_model->where('starttime>='.$starttime.'and endtime<='.$endtime.'and userid='.$userid)->select();
            $sumtime = $billrecord_model->where('starttime>='.$starttime.'and endtime<='.$endtime.'and userid='.$userid)->sum('duration');
            $sumcost = $billrecord_model->where('starttime>='.$starttime.'and endtime<='.$endtime.'and userid='.$userid)->sum('cost');

            if ($billdata!=false) {

              $billdata=$this->formatbillfield($billdata);
              $data['status']="data";
              $str='<tbody><tr style="background-color:#E5E5E5;font-weight:normal;height:18px;">
                <th scope="col">编号</th>
                <th scope="col">主叫号码</th>
                <th scope="col">被叫号码</th>
                <th scope="col">开始时间</th>
                <th scope="col">结束时间</th>
                <th scope="col">时长/秒</th>
                <th scope="col">费用/元</th>
                </tr>';
              foreach ($billdata as $key => $pervalue) {

                            $str= $str.'<tr style="color:Black;background-color:White;height:18px;" align="center">';
                            $str= $str.'<td style="width:35px;" align="center">'.$pervalue['id'].'</td>
                                <td style="width:100px;">'.$pervalue['callernum'].'</td>
                                <td style="width:100px;">'.$pervalue['callednum'].'</td>
                                <td style="width:100px;" >'.$pervalue['starttime'].'</td>
                                <td style="width:100px">'.$pervalue['endtime'].'</td>
                                <td style="width:60px;">'.$pervalue['duration'].'</td>
                                <td style="width:60px;">'.$pervalue['cost'].'</td></tr>';
                   }

                  $str=$str.'<tr style="color:Black;background-color:White;height:18px;" align="center">               
                <td style="width:100px;" colspan="5" align="right" >总计</td>         
                <td style="width:60px;">'.$sumtime.'</td>
                <td style="width:60px;">'.$sumcost.'</td>
                </tr>
                </tbody>';

                  $data['message']=$str;
            }
            else
            {
              $data['status']='failed';
              $data['message']="该时间段该用户没有通话记录";
            }



        }

        /*
      $data['status']='success';
      $data['message']=$_POST['userid'];*/
      $this->ajaxReturn($data,"json");

    }
    public function donate(){//赠送查询
    	$userid=$this->_get('userid','intval');
    	$donate=M('Donate');
    	$where="userid='$userid'";
    	if($this->isPost()){//搜索
    		$starttime=strtotime($_POST['starttime']);
    		$endtime=strtotime($_POST['endtime']);
			$where.=" AND dotime>$starttime AND dotime<$endtime";
    	}
    	$this->assign('data',$donate->where('userid='.$userid)->order('dotime DESC')->where($where)->select());
    	$this->display();
    }

   }


