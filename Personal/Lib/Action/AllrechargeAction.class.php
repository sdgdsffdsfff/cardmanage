<?php
/**************************************************************************************
 ***  文件：RechargeAction.class.php
 *************************************************************************************/


class AllrechargeAction extends  Action {

          function index()
          {
            $this->assign('timer',$this->getTime());
            $this->display();
          }

          
          #充值
          function recharge()
          {
                if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
                       $rechargetel = trim($_POST['rechargetel']);
                       $cardpwd = trim($_POST['cardpwd']);
                       $cardnum = trim($_POST['cardnum']);
                       $user_model=M('users');

                       $status=$this->checkcardtype($cardnum, $rechargetel);
                       if ($status) {
                       	  $status=$this->checkcardstatus($cardnum,$rechargetel);
                       }
                       	 	
                       if($status) {
                            if (strlen($cardnum)==8) {
                              $sql = "SELECT callback_opencard_oper('" . $cardnum . "','" . $cardpwd . "','" . $rechargetel . "',2)";
                            }
                            else {
                              $sql = "SELECT callback_opencard_oper_by('" . $cardnum . "','" . $cardpwd . "','" . $rechargetel . "',2)";
                            }
                            $card_model = M ( 'cards' );
                            $status = $card_model->query ($sql);
                        }
                          

                          if (strlen($cardnum)==8) {
                              $status=$status [0] ['callback_opencard_oper'];
                          }
                          else
                          {
                            $status=$status [0] ['callback_opencard_oper_by'];
                          }

                          if ( $status == 't') {
                            
                            $data ['message'] = '使用充值卡' . $cardnum . '充值成功。';
                            $data ['status'] = 'success';
                            $this->ajaxReturn ( $data, 'json' );
                          } else if ($status == '-1') {
                            
                            $data ['message'] = '使用充值卡' . $cardnum . '充值失败，卡号或密码不正确请重试。';
                            $data ['status'] = 'failed';
                            $this->ajaxReturn ( $data, 'json' );
                          } else if ($status == '-2') {
                            $data ['message'] = '使用充值卡' . $cardnum . '充值失败，该卡未激活或状态不正确。';
                            $data ['status'] = 'failed';
                            $this->ajaxReturn ( $data, 'json' );
                          } else if ($status  == '-3') {
                            $data ['message'] = '使用充值卡' . $cardnum . '充值失败，该卡已过期。';
                            $data ['status'] = 'failed';
                            $this->ajaxReturn ( $data, 'json' );
                          }                       
                }
               $this->ajaxReturn($data);                   
          }
			   
          
          #判断卡是不是已经使用
          function checkcardstatus($cardnum,$rechargetel)
          {
             $card_model=M('cards');
             $carddata=$card_model->where("cardnum='".$cardnum."'")->select();
             if ($carddata[0]['status']!=1) {
                  switch ($carddata[0]['status']) {
                    case 0:
                            $mes="未激活";                      
                      break;
                    case 2:
                            $mes="已使用";                      
                      break;    
                    default:
                            $mes="已锁定";     
                      break;
                  }
                  $data['message']='该卡状态为'.$mes.'，请联系代理商。';
                  $data['status']='failed';
                  $this->ajaxReturn($data,'json'); 
             }
             return true;
          }
          

          function checkcardtype($cardnum,$rechargetel)
          {
          	$cardlen=strlen($cardnum);
          	$user_model=M('users');
          	$where['phonenum']=$rechargetel;
          	$limitflag=$user_model->where($where)->getField('limitflag');
          	if($limitflag==0)
          	{   #流量卡
          		if ($cardlen!=8) {
          	       $data['message']="您要充值的卡为流量卡，请使用流量卡充值。";
	          	   $data['status']='failed';
	          	   $this->ajaxReturn($data,'json');
          		}
          		return true;    
          	}
          	else
          	{   
          		#期限卡
          		if ($cardlen!=6) {
          			$data['message']="您要充值的卡为期限卡，请使用期限卡充值。";
          			$data['status']='failed';
          			$this->ajaxReturn($data,'json');
          		}
          		return true;
          	}
          }     
          
          
   function getTime(){  
     list ($usec, $sec) = explode(" ", microtime());     
     return (float) $usec + (float) $sec-time();
  }

}

?>