<?php
/**************************************************************************************
 ***  鏂囦欢锛欰uthorityAction.class.php
 ***  璇存槑锛氫唬鐞嗗晢鏉冮檺绠＄悊绫�
 ***  鏃ユ湡锛�014-04-15
 *************************************************************************************/

//AuthorityAction鎺у埗绫荤户鎵跨粺涓�叆鍙ｅ姞杞界被CommonAction
class AuthorityAction extends  CommonAction {
	//鍏呭�
	public function balance(){
		$account=M('account');
		$id=$this->_get('id');
		$where='id='.$id;
		if($this->isPost()){//鍏呭�
			$logs=array();
			$logs['oldbanlance']=$account->where($where)->getField('balance');
			if($account->where($where)->setInc('balance',$this->_post('balance'))){
				//鍐欏厖鍊兼棩蹇�
				$chargLog=M('charge_log');
				$logs['newbanlance']=$account->where($where)->getField('balance');
				$logs['addbanlance']=$this->_post('balance');
				$logs['addtime']=time();
				$logs['accountid']=$id;
				$chargLog->add($logs);
				$this->success();
			}else{
				$this->error();
			}
			exit;
		}
		$this->assign('data',$account->field('loginname,balance')->where($where)->find());
		$this->display();
	}

	public function cardset(){
		$rule=M('card_generate_rule');
		$where='';
		if(isset($_GET['loginname']) || !empty($_GET['loginname'])){//鎼滅礌
			$where="c.loginname like '%{$_GET['loginname']}%'";			
		}
		$count=$rule->table('cb_card_generate_rule r')->field('r.id')->join('cb_account c ON c.id=r.account_id')->where($where)->count();
		import('ORG.Util.Page');
		$Page=new Page($count,10);
		$list=$rule->table('cb_card_generate_rule r')->field('r.*,c.loginname')->order('r.id ASC')->join('cb_account c ON c.id=r.account_id')->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($list as $k=>$v){
			$list[$k]['amount']=implode(',', unserialize($list[$k]['amount']));
		}
		$this->assign('list',$list);
		$this->assign('page',$Page->show());// 璧嬪�鍒嗛〉杈撳嚭
		$this->display();
	}
	//浠ｇ悊鍟嗗埗鍗¤缃�鏂板
	public function cardset_add(){
		$account=M('account');
		$this->assign('account',$account->where('ownid=1')->order('id ASC')->getField('id,loginname'));
		$rule=M('card_generate_rule');
		if($this->_post()){//鏂板
			$data=$rule->create();
			if($rule->where('account_id='.$data['account_id'])->getField('id')){
				$this->error('浠ｇ悊鍟嗚处鍙峰凡瀛樺湪锛�);
				exit;
			}
			$data['amount']=empty($data['amount'])?'':serialize($data['amount']);
			$rule->add($data)?$this->success('',U('cardset')):$this->error().$rule->getDbError();
			exit;
		}
		$this->display();
	}
	//浠ｇ悊鍟嗗埗鍗¤缃�淇敼
	public function cardset_update(){
		$account=M('account');
		$this->assign('account',$account->where('ownid=1')->order('id ASC')->getField('id,loginname'));
		$id=$this->_get('id','intval');
		$where='id='.$id;
		$rule=M('card_generate_rule');
		$info=$rule->where($where)->find();
		$info['amount']=unserialize($info['amount']);
		$this->assign('info',$info);
		//闈㈤
		$setting=M('amount_setting');
		$list=$setting->where('accountid='.$info['account_id'])->order('amount ASC')->select();	
		$this->assign('amount',$list);
		if($this->_post()){//淇敼
			$data=$rule->create();
			$data['amount']=serialize($data['amount']);
			$rule->where($where)->save($data)?$this->success('',U('cardset')):$this->error();
			exit;
		}
		$this->display();
	}
	//浠ｇ悊鍟嗗埗鍗¤缃�鍒犻櫎
	public function cardset_del(){
		$rule=M('card_generate_rule');
		$id=$this->_get('id','intval');
		$where='id='.$id;
		$rule->where($where)->delete()?$this->success('',U('cardset')):$this->error();
		exit;
	}
	
	//ajax鑾峰彇鍒跺崱閲戦
	public function ajaxAmount(){
		if($this->isAjax()){
			$accountid=$this->_get('accountid','intval');
			$str='銆��鍒跺崱閲戦锛�;
			$setting=M('amount_setting');
			$list=$setting->where('accountid='.$accountid)->order('amount ASC')->select();
			if(!$list) exit($str.'璇峰厛璁剧疆鍏跺搴旂殑鍗￠潰鍊硷紒');
			foreach ($list as $k=>$v){
				$str.="<input type=\"checkbox\" name=\"amount[]\" value=\"{$v['amount']}\"/> {$v['amount']}(鏈夋晥鏈燂細".$v['days']."澶�鍏呭�鏈熼檺锛�.date('Y-m-d H:i:s',$v['expiry']).") ";
			}
			exit($str);
		}
	}
      #娣诲姞鐢ㄦ埛
	function addaccount()
	{

		if(!$this->chk_delspau())
		{
		    //璺宠浆鍒伴敊璇〉闈�
	    	$this->assign('message','鎮ㄦ殏鏃犳娣诲姞鐢ㄦ埛鏉冮檺');
			  $this->error();
	    }

    $this->assign('timer',$this->getTime());
		$this->assign();
		$this->display();	    
	}


	function addaccountdata()
	{
		#楠岃瘉鐢ㄦ埛鏉冮檺
		if(!$this->chk_delspau())
		{
		    //璺宠浆鍒伴敊璇〉闈�
	    	$this->assign('message','鎮ㄦ殏鏃犳娣诲姞鐢ㄦ埛鏉冮檺');
		  	$this->error();
	    }
         $this->validatorfield($_POST);    
         $account_model=M('account');
         //杩樺簲璇ユ鏌ョ敤鎴锋坊鍔犵殑鏉冮檺鏄笉鏄鐢ㄦ埛鏈�
         //杩橀渶瑕侀獙璇佷簨瀹炰笉鏄凡缁忔湁姝ょ敤鎴峰悕
         $chkdata=$account_model->where("loginname='".$_POST['loginname']."'")->getfield('id');
		 if (!empty($chkdata)) {	 	
	 	   //璺宠浆鍒伴敊璇〉闈�
        $operdetail='鐢ㄦ埛'.$_SESSION['loginname'].'娣诲姞浠ｇ悊鍟�.$_POST['loginname'].'澶辫触锛屽師鍥狅細璇ヤ唬鐞嗗晢宸插瓨鍦�;
        $this->addlog($operdetail,'娣诲姞浠ｇ悊鍟�);
	    	$this->assign('message','鐢ㄦ埛鐢ㄦ埛鍚嶅凡瀛樺湪');
			  $this->error();
		 }      
        //post 浼犻�杩囨潵鐨勫�瑙ｆ瀽涓烘潈闄愭暟缁勭劧鍚庢坊鍔�
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

         //娣诲姞鍏朵粬浠ｇ悊鍟嗙殑浠ｇ悊鍟唅d
         //$accountdata浠ｇ悊鍟嗘暟鎹�
      
       $status=$this->check_telnum($_POST['tele']);
       if (!$status) {
            $this->assign('message','鎵嬫満鍙风爜鏍煎紡涓嶆纭紒');
            $this->error();
       }
       $accountdata['tele']=trim($_POST['tele']);
  		 $accountdata['loginname']=trim($_POST['loginname']);
  		 $accountdata['loginpwd']=md5(trim($_POST['loginpwd']));
  		 $accountdata['status']=trim($_POST['status']);		
  		 $accountdata['remark']=trim($_POST['remark']);	 
  		 $accountdata['power']=$_SESSION['power']+1;
  		 $accountdata['ownid'] = $_SESSION['accountid'];
       $account_model=M('account');
       $power_model=M('power');
       $accstatus=$account_model->add($accountdata);
       $accountid=$account_model->where("loginname='".$_POST['loginname']."'")->getField('id');
       $authoritydata['accountid'] = $accountid;  
       $powerstatus=$power_model->add($authoritydata);
       if($accstatus && $powerstatusAp)  
        {           
            $au="";
          foreach ($array as  $value) {
                     if (in_array($value,$authorityarr)) 

                             $au=$au."/1"; 
                     else             
                             $au=$au."/0";          
           }
           if ($_POST['status']==1) {
             # code...
              $status="寮��";
           }
           else
           {
              $status="閿佸畾";
           }      
            $operdetail="绠＄悊鍛�.$_SESSION['loginname']."娣诲姞鐢ㄦ埛".$_POST['loginname']."鎴愬姛銆傛潈闄愪负".$au."鐘舵�锛�.$status;
            $opertype="娣诲姞浠ｇ悊鍟�;
            $this->addlog($operdetail,$opertype);
            $this->assign('message','娣诲姞浠ｇ悊鍟嗘垚鍔燂紒');
            $this->assign('jumpUrl','__APP__/Authority/updateaccount');
            $this->assign('waitSecond',1);
            $this->success();
            //鎿嶄綔鏃ュ織             
        }  
        else   
        {       
            $operdetail='鐢ㄦ埛'.$_SESSION['loginname'].'娣诲姞浠ｇ悊鍟�.$accountdata['loginname'].'澶辫触';
            $this->addlog($operdetail,'娣诲姞浠ｇ悊鍟�);
            $this->assign('message','娣诲姞浠ｇ悊鍟嗗け璐ワ紒璇烽噸璇�);
            $this->assign('jumpUrl','__APP__/Authority/updateaccount');
            $this->assign('waitSecond',1);          
            $this->success();
        }  

	}
     #楠岃瘉鎵嬫満鍙风爜
     function check_telnum($telnum)
     {
            $b1 = (preg_match("/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/i",$telnum))?TRUE:FALSE;
            $b2 = (preg_match("/^(1[358]{1}[0-9]{9})$/i",$telnum))?TRUE:FALSE;
            return $b1 || $b2;
     }
   
    #楠岃瘉瀛楁
    function validatorfield($userdata)
    {
    	if(empty($userdata['loginname']))
    	{
    		//璺宠浆鍒伴敊璇〉闈�
	    	$this->assign('message','鐢ㄦ埛鐢ㄦ埛鍚嶄笉鍙负绌�);
			$this->error();
    	}
        if(empty($userdata['loginpwd']))
        {
            //璺宠浆鍒伴敊璇〉闈�
	    	$this->assign('message','瀵嗙爜涓嶅彲涓虹┖');
			$this->error();
        }
        if (empty($userdata['tele'])) {
            //璺宠浆鍒伴敊璇〉闈�
	    	$this->assign('message','鎵嬫満鍙风爜涓嶅彲涓虹┖');
			$this->error();
        }
         
        if (empty($userdata['authority'])) {
            //璺宠浆鍒伴敊璇〉闈�
	    	$this->assign('message','璇烽�鎷╃敤鎴锋潈闄�);
			  $this->error();
        }
    }



	#鍒犻櫎鐢ㄦ埛  鍙槸鎶婂叾鐘舵�鏀规垚閿佸畾
	function deleteaccount() 
	{		
		//鍒嗛厤鍙橀噺
		if(!$this->chk_delspau())
		{
		    //璺宠浆鍒伴敊璇〉闈�
	    	$this->assign('message','鎮ㄦ殏鏃犲垹闄ょ敤鎴锋潈闄�);
			  $this->error();
	 }
		$account_model=M('account');
		//涓嶅彲浠ヨ法绾у垹闄ょ敤鎴� 浣嗗鏋滀笂绾х敤鎴疯鍒犻櫎  涓嬩竴绾х敤鎴蜂篃搴旇鐩稿簲琚垹闄�
		$accountdata=$account_model->where('ownid='.$_SESSION['accountid'])->select();   
		$this->assign('timer',$this->getTime());		
		$this->assign('accountdata',$accountdata);
		$this->display();
	}




   function deleteaccdata()
   {
   	 #楠岃瘉鐢ㄦ埛鏉冮檺
    if($this->isAjax()){      
		if(!$this->chk_delspau())
		{
        $data['status']="failed";
        $data['message']="鎮ㄦ殏鏃犲垹闄ょ敤鎴锋潈闄�;
        $this->ajaxReturn($data,'json');
	   }
     //杩樿楠岃瘉瑕佸垹闄ょ殑鐢ㄦ埛鏄笉鏄敼浠ｇ悊鍟嗕笅绾т唬鐞嗗晢
	   $accountid=$_POST['id'];
	   $account_model=M('account');
	   $power_model=M('power');
     $data['status']=2;
     $status=$account_model->where('id='.$accountid)->save($data);
     $loginname=$account_model->where('id='.$accountid)->getfield('loginname');
      if (!$status) {
            $operdetail="绠＄悊鍛�.$_SESSION['loginname']."閿佸畾鐢ㄦ埛".$loginname."澶辫触";
            $opertype="閿佸畾浠ｇ悊鍟�;
            $this->addlog($operdetail,$opertype); 
            $data['status']="failed";
            $data['message']="鐢ㄦ埛鐘舵�閿佸畾澶辫触";
            $this->ajaxReturn($data,'json');
       }     

       if ($_SESSION['power']==1) {  
       	  $idarr = $account_model->where('ownid='.$accountid)->getfield('id',true);
          foreach ($idarr as $key => $id) {         
       	      $account_model->where('id='.$id)->save($data);           
            }         
       }
       if($status)
       {    
            $operdetail="绠＄悊鍛�.$_SESSION['loginname']."閿佸畾鐢ㄦ埛".$loginname."浠ュ強涓嬬骇浠ｇ悊鍟嗘垚鍔�;
            $opertype="閿佸畾浠ｇ悊鍟�;
            $this->addlog($operdetail,$opertype); 
            $data['status']="success";
            $data['message']="鐢ㄦ埛鐘舵�閿佸畾鎴愬姛";
            $this->ajaxReturn($data,'json');
       } 
     }
   }



   function openaccdata()
   {
       if($this->isAjax()){
         $accountid=$this->__get('id');
         $account_model=M('account');
         $power_model=M('power');
         $data['status']=1;
         $status=$account_model->where('id='.$accountid)->save($data);
         if ($status) {   
             $operdetail="绠＄悊鍛�.$_SESSION['loginname']."閿佸畾鐢ㄦ埛".$loginname."鎴愬姛";
             $opertype="寮��浠ｇ悊鍟�;
             $this->addlog($operdetail,$opertype); 
             $data['status']="success";
             $data['message']="鐢ㄦ埛鐘舵�鎵撳紑鎴愬姛";
             $this->ajaxReturn($data,'json');
         }
         else
         {
             $operdetail="绠＄悊鍛�.$_SESSION['loginname']."閿佸畾鐢ㄦ埛".$loginname."澶辫触";
             $opertype="寮��浠ｇ悊鍟�;
             $this->addlog($operdetail,$opertype); 
             $data['status']="success";
             $data['message']="鐢ㄦ埛鐘舵�鎵撳紑澶辫触";
             $this->ajaxReturn($data,'json');
         }                
       }
   }


   /*
   # 鏌ョ湅鍒犻櫎鐢ㄦ埛璐﹀彿鐘舵� 浜嬪姟鏃剁敤鐨� 杩斿洖鍒犻櫎鎴愬姛鎴栧け璐�  
   function  chkstatus($arr)
   {

        echo '<pre>';
        print_r($arr);
        echo '</pre>';
   }
   */



	#鏇存柊鐢ㄦ埛
	function  updateaccount()
	{
		#楠岃瘉鐢ㄦ埛鏉冮檺
		if(!$this->chk_delspau())
		{
		    //璺宠浆鍒伴敊璇〉闈�
	    	$this->assign('message','鎮ㄦ殏鏃犲垹闄ょ敤鎴锋潈闄�);
			  $this->error();
	  }


    $account_model=M('account');
		//涓嶅彲浠ヨ法绾у垹闄ょ敤鎴� 浣嗗鏋滀笂绾х敤鎴疯鍒犻櫎  涓嬩竴绾х敤鎴蜂篃搴旇鐩稿簲琚垹闄�
		//$accountdata=$account_model->where()->select();
    import('ORG.Util.Page'); // 瀵煎叆鍒嗛〉绫�
    $count    = $account_model->where('ownid='.$_SESSION['accountid'])->count();// 鏌ヨ婊¤冻瑕佹眰鐨勬�璁板綍鏁�
    $Page     = new Page($count,$pagesize);// 瀹炰緥鍖栧垎椤电被 浼犲叆鎬昏褰曟暟鍜屾瘡椤垫樉绀虹殑璁板綍鏁�
    $Page->setConfig('header','涓唬鐞嗗晢');
    $Page->setConfig('prev','涓婁竴椤�);
    $Page->setConfig('next','涓嬩竴椤�);
    $Page->setConfig('theme','涓嬪睘%totalRow%%header% 绗�nowPage%椤祙鍏�totalPage% 椤�%upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%'); 
    $show = $Page->show();// 鍒嗛〉鏄剧ず杈撳嚭
    // 杩涜鍒嗛〉鏁版嵁鏌ヨ 娉ㄦ剰limit鏂规硶鐨勫弬鏁拌浣跨敤Page绫荤殑灞炴�   
    $accountdata = $account_model->where('ownid='.$_SESSION['accountid'])->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();     

    $this->assign('page',$show);// 璧嬪�鍒嗛〉杈撳嚭
		$this->assign('timer',$this->getTime());		
		$this->assign('accountdata',$accountdata);
		$this->display();
	}


	#鍒濆鍖栨暟鎹慨鏀�
	function  updateaccdata()
	{		
		#楠岃瘉鐢ㄦ埛鏉冮檺
		if(!$this->chk_delspau())
		{
		    //璺宠浆鍒伴敊璇〉闈�
	     $this->assign('message','鎮ㄦ殏鏃犱慨鏀圭敤鎴锋潈闄�);
			 $this->error();
	  }

	    //杩樿鍒ゆ柇鏄笉鏄浠ｇ悊鍟嗕笅涓�骇鐨勪唬鐞嗗晢

		$id=$_GET['id'];
		$account_model=M('account');
		$power_model=M('power');
	  $accountdata= $account_model->where('id='.$id)->select();
		$powerdata=$power_model->where('accountid='.$id)->select();
    #瀵嗙爜榛樿涓虹┖ 
		$this->assign('accountdata',$accountdata);
		$this->assign('powerdata',$powerdata);
		$this->display();
	}


	#鏁版嵁淇敼鍒版暟鎹簱  
	#娉ㄦ剰瑕佹妸鐩稿簲鐨勫瓙浠ｇ悊鍟嗘潈闄愪慨鏀逛簡; 
	function  updateacc()
	{
	   
		#楠岃瘉鐢ㄦ埛鏉冮檺
		if(!$this->chk_delspau())
		{
		    //璺宠浆鍒伴敊璇〉闈�
	    	$this->assign('message','鎮ㄦ殏鏃犱慨鏀圭敤鎴锋潈闄�);
			  $this->error();
	    }

         $this->validatorupdatefield($_POST);    
         $account_model=M('account');
         $power_model=M('power');

         //淇敼涔嬪墠鐨勬潈闄�
         $powerdata=$power_model->where('accountid='.$_POST['id'])->select();

         $accountdata=$account_model->where('id='.$_POST['id'])->select();

     $array=array(
              'up_bindtel',
              'up_cardpwd',
              'up_userexpirydate',
              'man_cardstatus',
              'up_cardmoney',
              'chk_billrecord',
              'count_data',
              'transfer_card');
           //鏉冮檺淇敼涔嬪悗鐨勬潈闄�
           $authoritydata=array();
           $authorityarr = $_POST['authority'];
           foreach ($array as  $value) {
                  if (in_array($value,$authorityarr)) 
                     	$authoritydata[$value]=1; 
                     else             
                        $authoritydata[$value]=0;          
           }


       //楠岃瘉鏉冮檺鏄惁鏇存敼
       //$reauthoritydata鐩存帴浣滀负鏁版嵁鏇存柊鍒皃ower鏁版嵁搴�
       $reauthoritydata = $this->validatorauthority($powerdata,$authoritydata,$array);
       $status=$this->check_telnum($_POST['tele']);
       if (!$status) {

         $this->assign('message','鎵嬫満鍙风爜鏍煎紡涓嶆纭紒');
         $this->error();
               
       }

  		 $accountdata['loginname']=trim($_POST['loginname']);
       $loginpwd = trim($_POST['loginpwd']);
       if (!empty($loginpwd)) {
            $accountdata['loginpwd']=md5($loginpwd);
       }
  		 $accountdata['status']=trim($_POST['status']);
  		 $accountdata['tele']=trim($_POST['tele']);
  		 $accountdata['remark']=trim($_POST['remark']);	 

  		 //鐢辨纭畾
  		 $accountdata['power']=$_SESSION['power']+1;
  		 $accountdata['ownid'] = $_SESSION['accountid'];

       $account_model=M('account');

       $up_accstatus=$account_model->where('id='.$_POST['id'])->save($accountdata); 

       $up_powersataus=true;
         if (!empty($reauthoritydata)) {
           $up_powersataus=$power_model->where('accountid='.$_POST['id'])->save($reauthoritydata); 
       }


       /*绠＄悊鍛樻妸涓�骇浠ｇ悊鍟嗘潈闄愬噺灏戝悓鏃舵妸浜岀骇浠ｇ悊鍟嗙殑鏉冮檺涔熷噺灏�/
       if($_SESSION['power']==1) 
       {
            //楠岃瘉涓�骇浠ｇ悊鍟嗗噺灏戠殑鏉冮檺  鐒跺悗鍑忓皯浜岀骇浠ｇ悊鍟嗘潈闄�
            //$powerdata   $authoritydata   $array
            //浜岀骇浠ｇ悊鍟嗗簲璇ュ噺灏戠殑鏉冮檺
            $subauthoritydata= $this->validatorsubauthority($powerdata,$authoritydata,$array);
          if (!empty($subauthoritydata)) {
                  $ownid=$_POST['id'];
                  $accountidarr = $account_model->where('ownid='.$ownid)->getfield('id',true);
                  if (!empty($accountidarr)){

                         $power_model->where(array('accountid'=>array('in',$accountidarr)))->save($subauthoritydata);          
                  }        
            }
            //鏌ヨ鍑鸿浠ｇ悊鍟嗕笅闈㈢殑浠ｇ悊鍟唅d  鐒跺悗鎶�power鏉冮檺淇敼    
       


    
        //淇敼涔嬪悗鐨勬潈闄�
        $au="";
        foreach ($array as  $value) {
                     if (in_array($value,$authorityarr)) 
                             $au=$au."/1"; 
                     else             
                             $au=$au."/0";          
           }
           if ($_POST['status']==1) {
              $status="寮��";
           }
           else
           { 
            $status="閿佸畾";
           }
       }  
       if(!($up_accstatus&&$up_powersataus)) 
       {
         	//璺宠浆鍒伴敊璇〉闈�
         	$operdetail='绠＄悊鍛�.$_SESSION['loginname'].'灏濊瘯淇敼浠ｇ悊鍟�.$accountdata['loginname'].'淇℃伅锛屼絾澶辫触銆�;
         	$this->addlog($operdetail,'淇敼鐢ㄦ埛淇℃伅');
	    	  $this->assign('message','淇敼鐢ㄦ埛淇℃伅澶辫触锛岃閲嶈瘯锛�);
          $this->assign('jumpUrl','__APP__/Authority/updateaccount');
          $this->assign('waitSecond',1);        
			    $this->error();
         }
         else
         {

    	        
    	        $operdetail='绠＄悊鍛�.$_SESSION['loginname'].'淇敼浠ｇ悊鍟�.$accountdata['loginname'].'淇℃伅锛屾潈闄愭洿鏀逛负'.$au."鐘舵�锛�.$status;
              if (!empty($_POST['loginpwd'])) {
                  $operdetail=$operdetail."&nbsp;  瀵嗙爜淇敼涓猴細".$_POST['loginpwd'];  
              }
     	   		  $this->addlog($operdetail,'淇敼鐢ㄦ埛淇℃伅');


     	        $this->assign('message','淇敼鐢ㄦ埛鎴愬姛锛�);
              $this->assign('jumpUrl','__APP__/Authority/updateaccount');
              $this->assign('waitSecond',1);  
    			    $this->success();		     

         }
	}


      #楠岃瘉瀛楁
    function validatorupdatefield($userdata)
    {
      if(empty($userdata['loginname']))
      {
        //璺宠浆鍒伴敊璇〉闈�
        $this->assign('message','鐢ㄦ埛鐢ㄦ埛鍚嶄笉鍙负绌�);
        $this->error();
      }
        if (empty($userdata['tele'])) {
            //璺宠浆鍒伴敊璇〉闈�
        $this->assign('message','鎵嬫満鍙风爜涓嶅彲涓虹┖');
        $this->error();
        }
         
        if (empty($userdata['authority'])) {
            //璺宠浆鍒伴敊璇〉闈�
        $this->assign('message','璇烽�鎷╃敤鎴锋潈闄�);
        $this->error();
        }
    }



	#姣旇緝鏉冮檺鏄惁宸茬粡鏇存敼
  #淇敼涔嬪墠鏉冮檺 淇敼涔嬪悗鐨勬潈闄�
	function validatorauthority($powerdata,$authoritydata,$array)
	{
		$reauthoritydata=array();
		foreach ($array as $value) {
			if($powerdata[0][$value]!=$authoritydata[$value])
			$reauthoritydata[$value]=$authoritydata[$value];
		}
     return $reauthoritydata;
	}


  #楠岃瘉浜岀骇浠ｇ悊鍟嗛渶瑕佸噺灏戠殑鏉冮檺
  #淇敼涔嬪墠鏉冮檺 淇敼涔嬪悗鐨勬潈闄�
  function validatorsubauthority($powerdata,$authoritydata,$array)
  {
      //print_r($powerdata);
      $reauthoritydata=array();
      foreach ($array as $value)
      {
        if(($powerdata[0][$value]==1)&&($authoritydata[$value]==0))
        $reauthoritydata[$value]=0;
      }
      //print_r($reauthoritydata);
      return $reauthoritydata;

  }

}

?>