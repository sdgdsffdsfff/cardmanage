<?php
/**************************************************************************************
 ***  QuerybillrecordAction.class.php
 ***  说明：电话查询查询
 ***  日期：2012-08-12
 *************************************************************************************/

// CountcarddataAction 控制类继承统一入口加载类 CommonAction
class QuerybillrecordAction extends CommonAction {
	function index() {
		// 据统计是统计全部的
		$this->assign ( 'timer', $this->getTime () );
		$bill_model = M ( 'billrecord' );
		import ( 'ORG.Util.Page' );
		$header = "条用户账单信息";
		$pagesize = 16;
		$count = $bill_model->where ( 'userid=' . $_SESSION ['userid'] )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, $pagesize ); // 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig ( 'header', $header );
		$Page->setConfig ( 'prev', '上一页' );
		$Page->setConfig ( 'next', '下一页' );
		$Page->setConfig ( 'theme', '共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%' );
		$show = $Page->show (); // 分页显示输出
		$billdata = $bill_model->where ( 'userid=' . $_SESSION ['userid'] )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		$billdata = $this->formatbillfield ( $billdata );
		$sumtime = $bill_model->where ( 'userid=' . $_SESSION ['userid'] )->sum ( 'duration' );
		$sumcost = $bill_model->where ( 'userid=' . $_SESSION ['userid'] )->sum ( 'cost' );
		$this->assign ( 'sumtime', $sumtime );
		$this->assign ( 'sumcost', $sumcost );
		$this->assign ( 'billdata', $billdata ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ();
	}
	
	// 式化时间
	function formatbillfield($data) {
		
		// print_r($data);
		foreach ( $data as $key => $perdata ) {
			if (! empty ( $perdata ['starttime'] )) {
				
				$data [$key] ['starttime'] = date ( "Y-m-d H:i:s", $perdata ['starttime'] );
			}
			
			if (! empty ( $perdata ['endtime'] )) {
				$data [$key] ['endtime'] = date ( "Y-m-d H:i:s", $perdata ['endtime'] );
			}
		}
		
		return $data;
	}
	
	// 据时间查询账单
	function querybill() {
		if (isset ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) && strtolower ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) == "xmlhttprequest") {
			
			$starttime = $_POST ['starttime'];
			$endtime = $_POST ['endtime'];
			$userid = $_SESSION ['userid'];
			$starttime = intval ( strtotime ( $starttime ) );
			$endtime = intval ( strtotime ( $endtime ) );
			$callednum = trim ( $_POST ['callednum'] );
			
			if (! empty ( $starttime ) && ! empty ( $endtime ) && ! empty ( $callednum )) {
				
				// $where='starttime>='.$starttime.'and endtime<='.$endtime.'and userid='.$userid.' and callednum='.$callednum;
				
				// $where='starttime>='.$starttime.'and endtime<='.$endtime.'and userid='.$userid.' and callednum like'.$callednum;
				$where = "starttime>=" . $starttime . "and endtime<=" . $endtime . "and userid=" . $userid . "and callednum like '%" . $callednum . "%'";
			} else if (! empty ( $starttime ) && ! empty ( $endtime ) && empty ( $callednum )) {
				$where = 'starttime>=' . $starttime . 'and endtime<=' . $endtime . 'and userid=' . $userid;
			} elseif (! empty ( $starttime ) && empty ( $endtime ) && ! empty ( $callednum )) {
				$where = "starttime>=" . $starttime . "and userid=" . $userid . "and callednum like '%" . $callednum . "%'";
			} elseif (empty ( $starttime ) && ! empty ( $endtime ) && ! empty ( $callednum )) {
				$where = "endtime<=" . $endtime . "and userid=" . $userid . "and callednum like '%" . $callednum . "%'";
			} elseif (empty ( $starttime ) && empty ( $endtime ) && empty ( $callednum )) {
				$where = "callednum like '%%' and userid=" . $userid;
			}
			
			$billrecord_model = M ( 'billrecord' );
			$billdata = $billrecord_model->where ( $where )->select ();
			$sumtime = $billrecord_model->where ( $where )->sum ( 'duration' );
			$sumcost = $billrecord_model->where ( $where )->sum ( 'cost' );
			
			if ($billdata != false) {
				
				$billdata = $this->formatbillfield ( $billdata );
				$data ['status'] = "data";
				$str = '<tbody><tr style="background-color:#E5E5E5;font-weight:normal;height:18px;">
                <th scope="col">编号</th>
                <th scope="col">主叫号码</th>
                <th scope="col">被叫号码</th>
                <th scope="col">开始时间</th>
                <th scope="col">结束时间</th>
                <th scope="col">时长/秒</th>
                <th scope="col">费用/元</th>
                </tr>';
				foreach ( $billdata as $key => $pervalue ) {
					
					$str = $str . '<tr style="color:Black;background-color:White;height:18px;" align="center">';
					$str = $str . '<td style="width:35px;" align="center">' . $pervalue ['id'] . '</td>
                                <td style="width:100px;">' . $pervalue ['callernum'] . '</td>
                                <td style="width:100px;">' . $pervalue ['callednum'] . '</td>
                                <td style="width:100px;" >' . $pervalue ['starttime'] . '</td>
                                <td style="width:100px">' . $pervalue ['endtime'] . '</td>
                                <td style="width:60px;">' . $pervalue ['duration'] . '</td>
                                <td style="width:60px;">' . $pervalue ['cost'] . '</td></tr>';
				}
				
				$str = $str . '<tr style="color:Black;background-color:White;height:18px;" align="center">               
                <td style="width:100px;" colspan="5" align="right" >总计</td>         
                <td style="width:60px;">' . $sumtime . '</td>
                <td style="width:60px;">' . $sumcost . '</td>
                </tr>
                </tbody>';
				
				$data ['message'] = $str;
			} else {
				$data ['status'] = 'failed';
				$data ['message'] = "该查询条件下没有通话记录";
			}
		}
		
		/*
		 * $data['status']='success'; $data['message']=$_POST['userid'];
		 */
		
		$this->ajaxReturn ( $data, "json" );
	}
	function getphonedata() {
		$user_model = M ( 'users' );
		$postdata = $_POST;
		$bindtel = $postdata ['bindtel'];
		// 分页信息
		$pagesize = "";
		$header = "条用户信息";
		if (! empty ( $bindtel )) {
			
			$phonenum = $bindtel;
			$_SESSION ['phonenum'] = $bindtel;
		} else {
			$phonenum = $_SESSION ['phonenum'];
		}
		
		// $phonenumarr = $user_model->where($data)->order('id desc')->getfield('phonenum',true);
		if ($_SESSION ['power'] == 1) {
			
			if (! empty ( $phonenum )) {
				
				// 改成分页的
				// $sql="select * from cb_users where phonenum like '%".$phonenum."%'"; //全查出来
				
				import ( 'ORG.Util.Page' );
				$str = '%' . $phonenum . '%';
				
				$where ['phonenum'] = array (
						'like',
						$str 
				);
				$count = $user_model->where ( $where )->count (); // 查询满足要求的总记录数
				$Page = new Page ( $count, $pagesize ); // 实例化分页类 传入总记录数和每页显示的记录数
				$Page->setConfig ( 'header', $header );
				$Page->setConfig ( 'prev', '上一页' );
				$Page->setConfig ( 'next', '下一页' );
				$Page->setConfig ( 'theme', '共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%' );
				$show = $Page->show (); // 分页显示输出
				                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
				$userdata = $user_model->where ( $where )->order ( 'registedate' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
				// $this->assign('list',$list);// 赋值数据集
				$this->assign ( 'page', $show ); // 赋值分页输出
			} else {
				
				// $sql="select * from cb_users";
				import ( 'ORG.Util.Page' );
				$where ['phonenum'] = array (
						'like',
						$str 
				);
				$count = $user_model->count (); // 查询满足要求的总记录数
				$Page = new Page ( $count, $pagesize ); // 实例化分页类 传入总记录数和每页显示的记录数
				$Page->setConfig ( 'header', $header );
				$Page->setConfig ( 'prev', '上一页' );
				$Page->setConfig ( 'next', '下一页' );
				$Page->setConfig ( 'theme', '共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%' );
				$show = $Page->show (); // 分页显示输出
				                             // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
				$userdata = $user_model->order ( 'registedate' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
				// $this->assign('list',$list);// 赋值数据集
				$this->assign ( 'page', $show ); // 赋值分页输出
			}
		} else {
			// $sql="select * from cb_users where '".$phonenum."' in (select bindtel from cb_cards where ownid=".$_SESSION['accountid']." or subownid=".$_SESSION['accountid'].") and phonenum='".$phonenum."'";
			// $sql="select * from cb_users where '".$phonenum."' in (select bindtel from cb_cards where ownid=".$_SESSION['accountid']." or subownid=".$_SESSION['accountid'].") and phonenum='".$phonenum."'";
			
			$sql = "select id,phonenum,banlance,lastusetime,registedate,expirydate from cb_users where phonenum in( select bindtel from cb_cards where bindtel like '%" . $phonenum . "%'  and cb_cards.ownid=" . $_SESSION ['accountid'] . " or cb_cards.subownid=" . $_SESSION ['accountid'] . ")";
		}
		
		// $userdata = $user_model->query($sql);
		// print_r($userdata);
		// exit();
		$userdata = $this->formatarrfield ( $userdata );
		$this->assign ( "userdata", $userdata );
		$this->display ();
	}
	
	// 新密码使用
	function updatephone() {
		$user_model = M ( 'users' );
		$id = $_GET ['id'];
		$userdata = $user_model->where ( 'id=' . $id )->select ();
		$userdata = $this->formatfield ( $userdata );
		$this->assign ( 'userdata', $userdata );
		$this->assign ( 'timer', $this->getTime () );
		$this->display ();
	}
	
	// jax 更新数据的实现
	function updatephonedata() {
		if (isset ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) && strtolower ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) == "xmlhttprequest") {
			
			$id = $_POST ['userid'];
			$data ['loginpwd'] = $_POST ['loginpwd'];
			$data ['remark'] = $_POST ['remark'];
			$user_model = M ( 'users' );
			$status = $user_model->where ( 'id=' . $id )->save ( $data );
			
			if ($status) {
				$data ['status'] = "success";
				$data ['message'] = "修改成功";
			} else {
				$data ['status'] = "failed";
				$data ['message'] = "修改失败";
			}
		}
		
		/*
		 * $data['status']='success'; $data['message']=$_POST['userid'];
		 */
		$this->ajaxReturn ( $data, "json" );
	}
	
	// 单查询
	function querybillrecord() {
		$id = $_GET ['id'];
		if (! empty ( $id )) {
			$billrecord_model = M ( 'billrecord' );
			$billdata = $billrecord_model->where ( 'userid=' . $id )->select ();
			$sumtime = $billrecord_model->where ( 'userid=' . $id )->sum ( 'duration' );
			$sumcost = $billrecord_model->where ( 'userid=' . $id )->sum ( 'cost' );
			// print_r($sumcost);
			// print_r($sumtime);
			// exit();
			$this->assign ( 'userid', $id );
			$this->assign ( 'sumtime', $sumtime );
			$this->assign ( 'sumcost', $sumcost );
			$billdata = $this->formatbillfield ( $billdata );
			$this->assign ( 'billdata', $billdata );
			$this->display ();
		}
	}
	
	// 值查询
	function queryrechargemsg() {
		// echo $_GET['id'];
		// exit();
		if ($_SERVER ['REQUEST_METHOD'] == "GET") {
			$phonenum = $_GET ['phonenum'];
			$card_model = M ( 'cards' );
			// 询属于该用户的且状态为使用的
			$chargedata = $card_model->where ( 'bindtel=' . $phonenum . 'and status=2' )->getfield ( 'id,money,cardnum,filltime', true );
			$summoney = $card_model->where ( 'bindtel=' . $phonenum . 'and status=2' )->sum ( 'money' );
			$this->assign ( 'summoney', $summoney );
			$this->assign ( 'phonenum', $phonenum );
			$chargedata = $this->formatrechagefield ( $chargedata );
			$this->assign ( 'chargedata', $chargedata );
			$this->display ();
		}
	}
	function formatrechagefield($data) {
		foreach ( $data as $key => $perdata ) {
			if (! empty ( $perdata ['filltime'] )) {
				
				$data [$key] ['filltime'] = date ( "Y-m-d H:i:s", $perdata ['filltime'] );
			}
		}
		return $data;
	}
	
	// 单个时间时间格式化
	function formatfield($data) {
		// print_r($data);
		if (! empty ( $data [0] ['lastusetime'] )) {
			
			$data [0] ['lastusetime'] = date ( "Y-m-d H:i:s", $data [0] ['lastusetime'] );
		}
		
		if (! empty ( $data [0] ['registedate'] )) {
			$data [0] ['registedate'] = date ( "Y-m-d H:i:s", $data [0] ['registedate'] );
		}
		
		if (! empty ( $data [0] ['expirydate'] )) {
			$data [0] ['expirydate'] = date ( "Y-m-d H:i:s", $data [0] ['expirydate'] );
		}
		
		// print_r($data);
		// exit();
		return $data;
	}
	function formatarrfield($userdata) {
		foreach ( $userdata as $key => $data ) {
			if (! empty ( $data ['lastusetime'] )) {
				
				$userdata [$key] ['lastusetime'] = date ( "Y/m/d ", $data ['lastusetime'] );
			}
			
			if (! empty ( $data ['registedate'] )) {
				$userdata [$key] ['registedate'] = date ( "Y/m/d ", $data ['registedate'] );
			}
			
			if (! empty ( $data ['expirydate'] )) {
				$userdata [$key] ['expirydate'] = date ( "Y/m/d ", $data ['expirydate'] );
			}
		}
		
		return $userdata;
	}
	
	// 据时间查询充值记录
	function queryrechargebytime() {
		if (isset ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) && strtolower ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) == "xmlhttprequest") {
			
			$starttime = $_POST ['starttime'];
			$endtime = $_POST ['endtime'];
			$phonenum = $_POST ['phonenum'];
			
			$starttime = intval ( strtotime ( $starttime ) );
			$endtime = intval ( strtotime ( $endtime ) );
			
			$card_model = M ( 'cards' );
			$chargedata = $card_model->where ( 'bindtel=' . $phonenum . 'and status=2' )->getfield ( 'id,money,cardnum,filltime', true );
			$summoney = $card_model->where ( 'bindtel=' . $phonenum . 'and status=2' )->sum ( 'money' );
			
			if ($chargedata != false) {
				
				$chargedata = $this->formatrechagefield ( $chargedata );
				$data ['status'] = "data";
				
				$str = '<tbody>
            <tr style="background-color:#E5E5E5;font-weight:normal;height:18px;">
                <th scope="col">编号</th>
                <th scope="col">卡号</th>
                <th scope="col">充值时间</th>
                <th scope="col">金额</th>
            </tr>';
				foreach ( $chargedata as $key => $pervalue ) {
					
					$str = $str . '<tr style="color:Black;background-color:White;height:18px;" align="center">';
					$str = $str . '<td style="width:35px;" align="center">' . $pervalue ['id'] . '</td>
                                <td style="width:100px;">' . $pervalue ['cardnum'] . '</td>
                                <td style="width:100px;">' . $pervalue ['filltime'] . '</td>
                                <td style="width:100px;" >' . $pervalue ['money'] . '元</td>
                                </tr>';
				}
				
				$str = $str . '<tr style="color:Black;background-color:White;height:18px;" align="center">         
                <td style="width:100px;" colspan="3" align="right" >总计</td>             
                <td style="width:60px;">' . $summoney . '元</td>
                 </tr></tbody>';
				
				$data ['message'] = $str;
			} else {
				$data ['status'] = 'failed';
				$data ['message'] = "该时间段该用户没有充值记录";
			}
		}
		/*
		 * $data['status']='success'; $data['message']=$_POST['userid'];
		 */
		$this->ajaxReturn ( $data, "json" );
	}
}


