<?php
/**************************************************************************************
 ***  ContactmanageAction.class.php
 ***  说明：电话查询查询
 ***  日期：2012-08-12
 *************************************************************************************/
include './Public/Classes/PHPExcel/IOFactory.php';
// CountcarddataAction 控制类继承统一入口加载类 CommonAction
class ContactmanageAction extends CommonAction {
	function index() {
		$contact_model = M ( 'contact' );
		$contactdata = $contact_model->where ( "userid=" . $_SESSION ['userid'] )->select ();
		// print_r($contactdata);
		// exit();
		// print_r($_SESSION);
		
		$this->assign ( 'timer', $this->getTime () );
		$this->assign ( 'contactdata', $contactdata );
		$this->display ();
	}
	
	// 除用户操作
	function delete() {
		if (isset ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) && strtolower ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) == "xmlhttprequest") {
			
			$contact_model = M ( 'contact' );
			$status = $contact_model->where ( 'id=' . $_POST ['id'] )->delete ();
			
			if ($status) {
				
				$data ['status'] = 'success';
				$data ['message'] = '删除常用联系人成功。';
			} else {
				$data ['status'] = 'success';
				$data ['message'] = '删除常用联系人失败。';
			}
			$this->ajaxReturn ( $data );
		}
	}
	
	// 转到添加
	function add() {
		$this->display ();
	}
	
	// 常用联系人
	function addcontact() {
		if (isset ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) && strtolower ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) == "xmlhttprequest") {
			
			$contact_model = M ( 'contact' );
			$telstatus = $this->check_telnum ( $_POST );
			
			if (empty ( $_POST ['cname'] )) {
				$data ['status'] = "failed";
				$data ['message'] = "添加失败。联系人不为空！";
				$this->ajaxReturn ( $data );
			}
			
			if (! $telstatus) {
				// code..
				$data ['status'] = 'failed';
				$data ['message'] = "联系电话格式不正确";
				$this->ajaxReturn ( $data, 'json' );
			}
			
			$this->checkcname ( $_POST ['cname'] );
			$contactdata ['telnum'] = trim ( $_POST ['telenum'] );
			$contactdata ['cname'] = trim ( $_POST ['cname'] );
			$contactdata ['userid'] = $_SESSION ['userid'];
			$addstatus = $contact_model->add ( $contactdata );
			
			if ($addstatus) {
				
				$data ['status'] = "success";
				$data ['message'] = "添加成功。";
			} else {
				$data ['status'] = "failed";
				$data ['message'] = "添加失败。";
			}
			
			$this->ajaxReturn ( $data, 'json' );
		}
	}
	function check_telnum($post) {
		$telnum = $post ['telenum'];
		$b1 = (preg_match ( "/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/i", $telnum )) ? TRUE : FALSE;
		$b2 = (preg_match ( "/^(1[358]{1}[0-9]{9})$/i", $telnum )) ? TRUE : FALSE;
		return $b1 || $b2;
	}
	function checkcname($cname) {
		$contact_model = M ( 'contact' );
		$adddata = $contact_model->where ( 'cname=' . $cname )->select ();
		
		if (! empty ( $adddata )) {
			$data ['status'] = "failed";
			$data ['message'] = "添加失败。该常用联系人已存在！";
			$this->ajaxReturn ( $data );
		}
	}
	
	// 始化
	function update() {
		$id = $_GET ['id'];
		$contact_model = M ( 'contact' );
		$contactdata = $contact_model->where ( 'id=' . $id )->select ();
		$this->assign ( 'contactdata', $contactdata );
		$this->display ();
	}
	function updatecontact() {
		if (isset ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) && strtolower ( $_SERVER ["HTTP_X_REQUESTED_WITH"] ) == "xmlhttprequest") {
			
			$contact_model = M ( 'contact' );
			$telstatus = $this->check_telnum ( $_POST );
			$id = $_POST ['id'];
			
			if (! $telstatus) {
				// code..
				$data ['status'] = 'failed';
				$data ['message'] = "联系电话格式不正确";
				$this->ajaxReturn ( $data, 'json' );
			}
			
			$contactdata ['telnum'] = trim ( $_POST ['telenum'] );
			
			$addstatus = $contact_model->where ( 'id=' . $id )->save ( $contactdata );
			
			if ($addstatus) {
				
				$data ['status'] = "success";
				$data ['message'] = "修改成功。";
			} else {
				$data ['status'] = "failed";
				$data ['message'] = "修改失败。";
			}
			
			$this->ajaxReturn ( $data, 'json' );
		}
	}
	
	// 量导入常用联系人
	function bulkadd() {
		$this->display ();
	}
	
	// 入实现
	function upfile() {
		$exceluptypes = array (
				'application/vnd.ms-excel',
				'application/vnd.ms-excel',
				'application/vnd.ms-excel',
				'application/x-excel',
				'application/vnd.ms-excel',
				'application/vnd.ms-excel',
				'application/vnd.ms-excel',
				'application/vnd.ms-excel',
				'application/kset' 
		);
		$txtuptypes = array (
				'text/plain' 
		);
		
		$destination_folder = './Public/file/';
		if ($_SERVER ['REQUEST_METHOD'] == 'POST') 		// 是否是post上传的文件
		{
			if (! is_uploaded_file ( $_FILES ["file"] [tmp_name] ))
                //是否存在文件
                {

				$this->assign ( 'msgTitle', '文件不存在' );
				$this->assign ( 'message', '请重试' );
				$this->assign ( 'jumpurl', '__APP__/Contactmanage/bulkadd' );
				$this->display ( 'jump' );
				exit ();
			} else {
				$file = $_FILES ["file"];
				if (! (in_array ( $file ["type"], $exceluptypes ) || in_array ( $file ['type'], $txtuptypes )))
                    //检查文件类型
                      {

					$this->assign ( 'msgTitle', '文件类型不符!仅可以上传EXCEL和TXT文本文档类型文件' );
					$this->assign ( 'message', '请重试' );
					$this->assign ( 'jumpurl', '__APP__/Contactmanage/bulkadd' );
					$this->display ( 'jump' );
					exit ();
				}
				
				if (! file_exists ( $destination_folder )) {
					mkdir ( $destination_folder );
				}
				
				$filename = $file ["tmp_name"]; // 获取临时文件的名称 如果要是租服务器的话要改临时文件夹路径
				$oldfilename = $_FILES ["file"] ['name']; // 获取原来的excel文件名含有后缀 $pinfo=pathinfo($oldfilename);
				$pinfo = pathinfo ( $oldfilename );
				$ftype = $pinfo ['extension']; // 获取文件的后缀名
				$date = date ( 'YmdGHis' );
				$newfilename = $date . '.' . $ftype; // 新的文件路径
				$destination = $destination_folder . $newfilename; // 新excel路径
				
				if ($ftype == "txt") {
					$type = 1;
				} else {
					$type = 2;
				}
				
				if (file_exists ( $destination )) {
					$this->assign ( 'msgTitle', '同名文件已经存在了' );
					$this->assign ( 'message', '请重试' );
					$this->assign ( 'jumpurl', '__APP__/Contactmanage/bulkadd' );
					$this->display ( 'jump' );
					exit ();
				}
				
				if (! move_uploaded_file ( $filename, $destination )) {
					$this->assign ( 'msgTitle', '常用联系人导入出错请查看文件目录是否已满' );
					$this->assign ( 'message', '请重试' );
					$this->assign ( 'jumpurl', '__APP__/Contactmanage/bulkadd' );
					$this->display ( 'jump' );
					exit ();
				}
				$this->adddata ( $destination, $type ); // 把excel中的文件导入数据库
			}
		}
	}
	
	// dddata
	function adddata($destination_folder, $type) {
		// 修改权限
		chmod ( $destination_folder, 0777 );
		if ($type != 1) {
			$objPHPExcel = PHPExcel_IOFactory::load ( $destination_folder );
			$sheetData = $objPHPExcel->getActiveSheet ()->toArray ( null, true, true, true );
			
			foreach ( $sheetData as $key => $value ) {
				$data [$key] ['cname'] = $value ['A'];
				$data [$key] ['telnum'] = $value ['B'];
			}
			/*
			 * print_r($data); exit();
			 */
		} else {
			$content = file_get_contents ( $destination_folder );
			// echo $content;
			$array = explode ( "\r\n", $content );
			foreach ( $array as $key => $value ) {
				$array [$key] = mb_convert_encoding ( $value, "UTF-8", "GBK" );
			}
			// echo '<pre>';
			// print_r($array);
			// exit();
			$data = array ();
			foreach ( $array as $key => $value ) {
				
				// $data[$key]['cname']=
				$perarray = explode ( " ", $value );
				$data [$key] ['cname'] = $perarray [0];
				$data [$key] ['telnum'] = $perarray [1];
			}
		}
		
		$data = $this->checkfield ( $data );
		$checkresult = $data [1];
		$addresult = $this->bulkadddata ( $data [0] );
		$contact_model = M ( 'contact' );
		$contactdata = $contact_model->where ( "userid=" . $_SESSION ['userid'] )->select ();
		$this->assign ( 'timer', $this->getTime () );
		$this->assign ( 'contactdata', $contactdata );
		$this->assign ( 'addresult', $addresult );
		$this->assign ( 'checkresult', $checkresult );
		$this->display ();
	}
	function bulkadddata($data) {
		$contact_model = M ( 'contact' );
		$addresult = array ();
		foreach ( $data as $key => $value ) {
			$value ['userid'] = $_SESSION ['userid'];
			$status = $contact_model->add ( $value );
			if (! $status) {
				
				$addresult [$key] = "常用联系人" . $value ['cname'] . "添加失败";
			} else {
				$addresult [$key] = "常用联系人" . $value ['cname'] . "手机号码" . $value ['telnum'] . "添加成功";
			}
		}
		
		return $addresult;
	}
	
	// 证手机号码格式
	
	// 还需要验证是不是该批数据里面含有重复
	function checkfield($data) {
		$data1 = $this->getallcontact ();
		$contactdata = $data;
		$cnamearr = array ();
		foreach ( $data as $key => $value ) {
			
			$status = $this->check_telnum1 ( $value ['telnum'] );
			if (! $status) {
				$returndata [$key] = "常用联系人" . $value ['cname'] . "的手机号码不正确，请查证后再添加。";
				unset ( $contactdata [$key] );
			}
			
			if (in_array ( $value ['cname'], $data1 )) {
				$returndata [$key] = "常用联系人" . $value ['cname'] . "已存在，请尝试其他联系人姓名。";
				unset ( $contactdata [$key] );
			}
			
			if (! in_array ( $value ['cname'], $cnamearr )) {
				$cnamearr [$key] = $value ['cname'];
			} else {
				$returndata ['$key'] = "常用联系人" . $value ['cname'] . "重复，请检查并修改重复常用联系人姓名。";
				unset ( $contactdata [$key] );
			}
		}
		$resultdata [0] = $contactdata;
		$resultdata [1] = $returndata;
		return $resultdata;
	}
	function check_telnum1($telnum) {
		$b1 = (preg_match ( "/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/i", $telnum )) ? TRUE : FALSE;
		$b2 = (preg_match ( "/^(1[358]{1}[0-9]{9})$/i", $telnum )) ? TRUE : FALSE;
		return $b1 || $b2;
	}
	
	// 取用户
	function getallcontact() {
		$contact_model = M ( 'contact' );
		return $contact_model->where ( 'userid=' . $_SESSION ['userid'] )->getfield ( 'cname', true );
	}
	
	// 载
	function download() {
		$id = $_GET ['id'];
		$file_name = "批量添加联系人实例文档.";
		if ($id == 1) {
			// txt
			$file_name = $file_name . "txt";
		} else {
			$file_name = $file_name . "xls";
		}
		$file_name = iconv ( "utf-8", "gb2312", $file_name );
		// $file_sub_path=$_SERVER['DOCUMENT_ROOT']."cardmanage/Public/downfile/";
		$file_sub_path = "./Public/downfile/";
		$file_path = $file_sub_path . $file_name;
		$fp = fopen ( $file_path, "r" );
		$file_size = filesize ( $file_path );
		// 下载文件需要用到的头
		Header ( "Content-type: application/octet-stream" );
		Header ( "Accept-Ranges: bytes" );
		Header ( "Accept-Length:" . $file_size );
		Header ( "Content-Disposition: attachment; filename=" . $file_name );
		$buffer = 1024;
		$file_count = 0;
		while ( ! feof ( $fp ) && $file_count < $file_size ) {
			$file_con = fread ( $fp, $buffer );
			$file_count += $buffer;
			echo $file_con;
		}
		fclose ( $fp );
		exit ();
	}
}


