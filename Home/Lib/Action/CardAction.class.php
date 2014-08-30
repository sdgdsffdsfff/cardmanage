<?php
class CardAction extends  CommonAction {
	public function index(){
		$amount=M('amount_setting');
		$amount=$amount->order('amount ASC')->getField('amount',true);
		$this->assign('amount',$amount);
		$rule=M('card_generate_rule');
		$id=$_SESSION['accountid'];
		$info=$rule->where('account_id='.$id)->find();
		if(!$info) exit('<p style="color:#666;padding:10px;font-size:10pt;">暂无制卡权限，请联系上级管理员！</p>');
		$info['amount']=unserialize($info['amount']);
		$this->assign('info',$info);
		$this->display();
	}
	
	public function add(){
		if($this->isAjax()){
			$start=$this->_post('start','intval');
			$end=$this->_post('end','intval');
			$numlen=8-strlen($_POST['card_prefix']);
			if($end<$start) $this->ajaxReturn(array('status'=>'error','message'=>'结束账号不得小于起始账号！'));
			if(strlen($end)>$numlen || strlen($start)>$numlen) $this->ajaxReturn(array('status'=>'error','message'=>'起始账号或者结束账号都不得大于'.$numlen.'位！'));
			$cardnum_start=$_POST['card_prefix'].str_pad($start,$numlen,'0',STR_PAD_LEFT);
			$cardnum_end=$_POST['card_prefix'].str_pad($end,$numlen,'0',STR_PAD_LEFT);
			$cards=M('cards');
			$carddata=$cards->field('id')->where("cardnum>=$cardnum_start AND cardnum<=$cardnum_end")->find();		
			if(!empty($carddata))
			{		
				$data['status']="error";
				$data['message']="该号码段内已有卡，请查证后再试！";
				$this->ajaxReturn($data,'json');
			}
			$count=$cardnum_end-$cardnum_start+1;
			$total=$count*$_POST['amount'];
			$validityday=intval(trim($_POST['validityday']));
			$expirydate= strtotime(trim($_POST['expirydate']));
			$this->produce($cardnum_start,$cardnum_end,$_POST['amount'],$validityday,$expirydate,$total);
		}
	}

	
	
	function produce($startcardnum,$stopcardnum,$money,$validityday,$expirydate,$total)
	{
		$account=M('account');
		$balance=$account->where('id='.$_SESSION['accountid'])->getField('balance');
		if($total>$balance){
			$this->ajaxReturn(array('status'=>'error','message'=>'您的当前余额为'.$balance.',余额已不足！'));
		}
		$sql='SELECT callback_generate_card('.$startcardnum.','.$stopcardnum.','.$money.','.$validityday.','.$expirydate.','.$_SESSION['accountid'].')';
		$card_model=M('cards');
		$status=$card_model->query($sql);
		if ($status[0]['callback_generate_card']=="SUCCESS") {
			//写日志
			$operdetail="管理员".$_SESSION['loginname']."生成卡号从".$startcardnum."到".$stopcardnum."每张金额：".$money."元,总金额".$total.'元。';
			$opertype="生成卡";
			$this->addlog($operdetail,$opertype);
			//扣款
			$account->where('id='.$_SESSION['accountid'])->setDec('balance',$total);
			//返回提示信息
			$data['message']="生成卡号".$startcardnum."到".$stopcardnum."金额为".$money."成功！";
			$data['status']='success';
			$this->ajaxReturn($data,'json');
		}
		else if ($status[0]['callback_generate_card']=="error") {
	
			$operdetail="管理员".$_SESSION['loginname']."生成卡号从".$startcardnum."到".$stopcardnum."每张金额：".$money."失败，原因未知。";
			$opertype="生成卡";
			$this->addlog($operdetail,$opertype);
			$data['message']="生成卡号".$startcardnum."到".$stopcardnum."金额为".$money."失败！";
			$data['status']='error';
			$this->ajaxReturn($data,'json');
		}
		else
		{
			$data['message']='原因未知';
			$data['status']='error';
			$this->ajaxReturn($data,'json');
		}
	
		 
	}
	
	public function ajaxGet(){
		if($this->isAjax()){
			$amount=$this->_post('amount');
			$amountSetting=M('amount_setting');
			$info=$amountSetting->field('days,expiry')->where(array('amount'=>$amount,'accountid'=>session('accountid')))->find();
			$info['expiry']=date('Y-m-d',$info['expiry']);
			exit(json_encode($info));
		}
	}
	
}

?>