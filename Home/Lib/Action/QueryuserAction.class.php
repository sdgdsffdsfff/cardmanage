<?php
/**************************************************************************************
 ***  文件：QueryuserAction.class.php
 ***  说明：用户查询
 ***  日期：2014-04-15
 *************************************************************************************/

// CountcarddataAction 控制类继承统一入口加载类 CommonAction
class QueryuserAction extends CommonAction {
	function index() {
		// print_r($_SESSION);
		// exit();
		if (isset ( $_GET ['id'] )) {
			$id = $_GET ['id'];
			$_SESSION ['userid'] = $id;
		} else {
			$id = $_session ['userid'];
		}
		
		// 1代表 已过期 2代表 本月过期 3代表 3个月未使用
		$user_model = M ( 'users' );
		
		if ($id == 1) {
			// code...
			$where = "expirydate<=" . time ();
		} else if ($id == 2) {
			
			// 本月过期
			$time = strtotime ( date ( 'Y-m-01 00:00:00' ), time () );
			$where = "expirydate>=" . $time . "and expirydate<=" . time ();
		} else if ($id == 3) {
			$time = time () - 90 * 24 * 60 * 60;
			$where = "lastusetime<=" . $time;
		} else {
			$where = "banlance<='0' and limitflag = 0";
		}
		
		import ( 'ORG.Util.Page' );
		
		if ($_SESSION ['power'] == 1) {
			
			$header = "条用户信息";
			$count = $user_model->where ( $where )->count (); // 查询满足要求的总记录数
			$Page = new Page ( $count, $pagesize ); // 实例化分页类 传入总记录数和每页显示的记录数
			$Page->setConfig ( 'header', $header );
			$Page->setConfig ( 'prev', '上一页' );
			$Page->setConfig ( 'next', '下一页' );
			$Page->setConfig ( 'theme', '共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%' );
			$show = $Page->show (); // 分页显示输出
			$userdata = $user_model->where ( $where )->order ( 'registedate' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
			
			$this->assign ( 'page', $show ); // 赋值分页输出
		} else {
			
			$sql = "select * from cb_users where phonenum in (select bindtel from cb_cards where ownid=" . $_SESSION ['accountid'] . " or subownid=" . $_SESSION ['accountid'] . ") and " . $where;
			$userdata = $user_model->query ( $sql );
		}
		
		$userdata = $this->formatarrfield ( $userdata );
		$this->assign ( "userdata", $userdata );
		$this->assign ( 'timer', $this->getTime () );
		$this->display ();
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
}


