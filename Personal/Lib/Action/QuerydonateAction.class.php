<?php

/**************************************************************************************
 ***  QuerydonateAction.class.php
 ***  说明：卡查询
 ***  日期：2014-04-12
 *************************************************************************************/
class QuerydonateAction extends CommonAction {
	function index() {
		// print_r($_SESSION);
		// exit();
		$donate_model = M ( 'donate' );
		import ( 'ORG.Util.Page' );
		$pagesize = 17;
		$count = $donate_model->where ( 'userid=' . $_SESSION ['userid'] )->count (); // 查询满足要求的总记录数
		$Page = new Page ( $count, $pagesize ); // 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig ( 'header', '条赠送金额信息' );
		$Page->setConfig ( 'prev', '上一页' );
		$Page->setConfig ( 'next', '下一页' );
		$Page->setConfig ( 'theme', '共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%' );
		$show = $Page->show (); // 分页显示输出
		                       // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $donate_model->where ( 'userid=' . $_SESSION ['userid'] )->order ( 'id desc' )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		
		$list = $this->formatfield ( $list );
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display ();
	}
	function formatfield($list) {
		// print_r($list);
		foreach ( $list as $key => $value ) {
			$list [$key] ['dotime'] = date ( 'Y-m-d H:i:s', $value ['dotime'] );
		}
		return $list;
	}
}

?>
