<?php
/**************************************************************************************
 ***  文件：CommonAction.class.php
 ***  说明：控制器统一加载入口验证类
 ***  作者：
 ***  日期：2014-04-15
 *************************************************************************************/
class CommonAction extends Action {
	
	/**
	 * ****************************************
	 * ** 函数名：_initialize
	 * ** 参数： 无
	 * ** 功能 ： 所有控制器类的初始化方法的定义
	 * ****************************************
	 */
	function _initialize() {
		
		// 对所有网页输出文本格式控制位utf8
		header ( "Content-Type:text/html; charset=utf-8" );
		// 启用session会话判断验证管理员是否已经登陆
		if (! (isset ( $_SESSION ['is_Login'] ) && $_SESSION ['is_Login'] == true)) {
			// 如果没有session则进行登录
			$this->redirect ( 'Login/index' );
		}
	}
	
	/**
	 * ****************************************
	 * ** 函数名：getTime
	 * ** 参数： 无
	 * ** 功能 ： 返回脚本执行时间的方法
	 * ****************************************
	 */
	function getTime() {
		
		// 计算脚本开始时间到结束微秒时间
		list ( $usec, $sec ) = explode ( " ", microtime () );
		// 返回脚本执行时间
		return ( float ) $usec + ( float ) $sec - time ();
	}
	
	/**
	 * ****************************************
	 * ** 函数名：addlog
	 * ** 参数： 操作明细 操作类型
	 * ** 功能 ： 添加log文件到数据库
	 * ****************************************
	 */
	function addlog($operdetail, $opertype) {
		$data ['clientip'] = $this->getclientip ();
		// 用户登录之后accountid
		$data ['accountid'] = $_SESSION ['accountid'];
		$data ['opertime'] = date ( 'Y-m-d H:i:s' );
		$data ['opertype'] = $opertype;
		$data ['detail'] = $operdetail;
		$logmodel = M ( 'log' );
		// print_r($data);
		$logmodel->add ( $data );
		// exit();
	}
	
	/**
	 * **************获取IP********************
	 */
	function getclientip() {
		if (! empty ( $_SERVER ['HTTP_CLIENT_IP'] ))
			$ip = $_SERVER ['HTTP_CLIENT_IP'];
		else if (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ))
			$ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER ['REMOTE_ADDR'];
		return $ip;
	}
	
	/*
	 * 验证用户是不是有该项权限$authoritytype表示权限类型
	 */
	function chk_auth($authoritytype) {
		if ($_SESSION ['authority'] [$authoritytype] == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	/*
	 * 验证代理商的级别 二级代理商不能下发卡 不能管理代理商 check——dealershipauthority
	 */
	function chk_delspau() {
		if (($_SESSION ['power'] != 3) && (! empty ( $_SESSION ['power'] ))) {
			return true;
		} else {
			return false;
		}
	}
}

?>