<?php
/**************************************************************************************
 ***  文件：TransfercardAction.class.php
 ***  说明：注意卡到代理商
 ***  日期：2012-08-12
 *************************************************************************************/

//TransfercardAction控制类继承统一入口加载类CommonAction
class TransfercardAction extends  CommonAction {


  function index()
  {
    //还需要初始化
    $account_model=M('account');
    $accountdata=$account_model->where('ownid='.$_SESSION['accountid'])->getfield('id,loginname',true);
    //print_r($accountdata);
    $this->assign('accountdata',$accountdata);
    $this->assign('timer',$this->getTime());  
    $this->display();
  }

  function transfer()
  { 
    $this->assign('timer',$this->getTime());  
    $this->display();
  }

  //卡号下发代理商时候要验证卡的状态 是不是未激活
  #查看卡状态是不是未激活状态  防止下发已激活已使用已锁定状态的卡片
  #ajax 返回值 $data['status']="状态";
  #            $data['message']="具体信息"；

  function checkcardstatus()
  {

      //开始验证账号卡状态   判断是不是数字

      $param=$_POST;

      $startcardnum=$param['startcardnum'];
      $stopcardnum=$param['stopcardnum'];

      //还得加判断$startcardnum 比$stopcardnum小

      $card_model=M('cards');
      //如果是总管理员 判断卡ownid 是不是都为0；
      $carddata=$card_model->where('cardnum>='.$startcardnum.' and cardnum<='.$stopcardnum)->getfield('id,cardnum,ownid,status',true); 
     
      if(empty($carddata))
      {
          $data['status']="failed";
          $data['message']="";
          $this->ajaxReturn($data,'json');
      }

      //开始判断ownid
      $cardownidstatus= $this->checkownid($carddata);
      if (!empty($cardownidstatus)) {   
           $data['status']="该账号段中含有已下发账号";  
           $data['message']= $cardownidstatus;
           //返回前台信息 卡号段中有卡号已经下发 
           $this->ajaxReturn($data,'json');
      }
      else   
      {
            $cardstatus=$this->checkstatus($carddata);
            
            #数据没有问题时候执行
            if (empty($cardstatus)) {

              #卡号下发代理商状态
               $status = $this->transfercard($_POST);
               if ($status){
                 $data['status']="success";
                 $data['message']="";
               }
               $this->ajaxReturn($data,'json'); 
            }
            else
             $data['status']="该账号段中账号状态有问题";
             $data['message']=$cardstatus;
             $this->ajaxReturn($data,'json');
      }
  }  


   function  transfercard($param)
   {
      $startcardnum = $param['startcardnum'];
      $stopcardnum = $param['stopcardnum'];
      //更新这个段内的ownid为 $param['accountid']
      $ownid = $param['accountid'];
      $card_model = M('cards');
      $data['ownid'] = $ownid;
      $updatestatus=$card_model->where('cardnum>='.$startcardnum.'and cardnum<='.$stopcardnum)->save($data);
      if ($updatestatus) 
      {
        #success
        return true;

      }
      else
      {
        #failed
        return false;        
        
      }
   } 


    #验证该卡号段卡号状态  已使用  已锁定 排除掉 
    function  checkstatus($carddata)
    {
      $status=array();
      foreach ($carddata as $value) {

          if(($value['status']!=0)&&($value['status']!=1))
          {
             switch ($value['status']) {
               case 2:
                  $status[$value['id']]='卡号：'.$value['cardnum']."状态：已使用";
                break;
               default:
                  $status[$value['id']]='卡号：'.$value['cardnum']."状态：已锁定";
                 break;
             }
          }
      }
      return $status;
    }



    #验证卡号段是不是该代理商拥有的
    function checkownid($carddata)
    {
      $status=array();
      $power=$_SESSION['power'];
      $oldownid=$_SESSION['accountid'];

      #总管理员 手下的没下发的ownid 只能是0   
      if($power==1){

          foreach ($carddata as $value) {
                  if(!$value['ownid']==0)
                  {
                    $status[$value['id']]="卡号".$value['cardnum']."已经下发代理商";
                  }
            }
      }

      //验证是ownid不属于一级代理商
      else{

          foreach ($carddata as $value) {

                 if($value['ownid']!=$oldownid)
                    {
                      //一种情况是该卡号已经下发   另一种情况是该卡号段不属于该用户。
                      $status[$value['id']]="卡号".$value['cardnum']."已经下发代理商或该卡号您无权限下发代理商";
                    }             
            }
      }
      return $status;
    }

}

