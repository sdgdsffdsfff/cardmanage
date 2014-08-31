<?php

/* * ************************************************************************************
 * **  ContactmanageAction.class.php
 * **  说明：电话查询查询
 * **  日期：2014-05-12
 * *********************************************************************************** */
include './Public/Classes/PHPExcel/IOFactory.php';

// CountcarddataAction 控制类继承统一入口加载类 CommonAction
class CalltransfernumAction extends CommonAction {

    function index() {
        import('ORG.Util.Page');
        $model = M('test', "cb_", 'DB_CONFIG2');
        $where = ' ';
        if ($this->isPost()) { // 搜索
            $where .= 'WHERE ';
            $starttime = strtotime($_POST ['starttime']);
            $endtime = strtotime($_POST ['endtime']);
            $where .= 'num like \'%' . $_POST ['num'] . '%\'';
            if (isset($_POST ['starttime']) && !empty($_POST ['starttime']))
                $where .= ' AND addtime >' . $starttime;
            if (isset($_POST ['endtime']) && !empty($_POST ['endtime']))
                $where .= ' AND addtime <' . $endtime;
        }
        $count = $model->query('select count(*) from cb_numberpool' . $where);
        $count = $count [0] ['count'];
        $header = "条呼转信息";
        $pagesize = 17;
        $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header', $header);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('theme', '共有%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');
        $show = $Page->show(); // 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $sql = "select * from cb_numberpool " . $where;
        $sql = $sql . " limit " . $Page->listRows . " offset " . $Page->firstRow;
        $data = $model->query($sql);
        // $Page->firstRow$Page->listRows
        // $this->assign('list',$list);// 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('timer', $this->getTime());
        $this->assign('transfernumdata', $data);
        $this->display();
    }

    public function batchDel() {
        if ($this->isAjax()) {
            $check = $_POST ['check'];
            $numberpool = M('numberpool', "cb_", 'DB_CONFIG2');
            $numberpool->where(array(
                        'num' => array(
                            'in',
                            implode(',', $check)
                        )
                    ))->delete() ? $this->ajaxReturn(array(
                                'status' => 'succ',
                                'info' => '删除成功！'
                            )) : $this->ajaxReturn(array(
                                'status' => 'error',
                                'info' => '删除失败！'
                            ));
        }
    }

    // 删除用户操作
    function delete() {
        if ($this->isAjax()) {
            $model = M('numberpool', "cb_", 'DB_CONFIG2');
            $sqlstr = "delete from cb_numberpool where num = '" . $_POST ['id'] . "'";
            $status = $model->execute($sqlstr);
            if ($status) {
                $data ['status'] = 'success';
                $data ['message'] = '删除呼转号码成功。';
            } else {
                $data ['status'] = 'success';
                $data ['message'] = '删除互转号码失败。';
            }
            $this->ajaxReturn($data);
        }
    }

    // 跳转到添加
    function add() {
        $this->display();
    }

    function check_telnum($post) {
        $telnum = $post ['calltransfernum'];
        $b1 = (preg_match("/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/i", $telnum)) ? TRUE : FALSE;
        $b2 = (preg_match("/^(1[358]{1}[0-9]{9})$/i", $telnum)) ? TRUE : FALSE;
        return $b1 || $b2;
    }

    function checkcalltransfernum($calltransfernum) {
        $model = M('numberpool', "cb_", 'DB_CONFIG2');
        $sqlstr = "selct count(*) from cb_numberpool where num = '" . $calltransfernum . "'";
        $status = $model->query($sqlstr);
        if (!empty($adddata)) {
            $data ['status'] = "failed";
            $data ['message'] = "添加失败。该常用联系人已存在！";
            $this->ajaxReturn($data);
        }
    }

    // 批量导入常用联系人
    function bulkadd() {
        $this->display();
    }

    // 导入实现
    function upfile() {
        $exceluptypes = array(
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
        $txtuptypes = array(
            'text/plain'
        );

        $destination_folder = './Public/file/';
        if ($_SERVER ['REQUEST_METHOD'] == 'POST') {   // 是否是post上传的文件
            if (!is_uploaded_file($_FILES ["file"] [tmp_name])) {
            //是否存在文件
                $this->assign('msgTitle', '文件不存在');
                $this->assign('message', '请重试');
                $this->assign('jumpurl', '__APP__/Calltransfernum/bulkadd');
                $this->display('jump');
                exit();
            } else {
                $file = $_FILES ["file"];
                if (!(in_array($file ["type"], $exceluptypes) || in_array($file ['type'], $txtuptypes))) {
                //检查文件类型
                    $this->assign('msgTitle', '文件类型不符!仅可以上传EXCEL和TXT文本文档类型文件');
                    $this->assign('message', '请重试');
                    $this->assign('jumpurl', '__APP__/Calltransfernum/bulkadd');
                    $this->display('jump');
                    exit();
                }
                if (!file_exists($destination_folder)) {
                    mkdir($destination_folder);
                }
                $filename = $file ["tmp_name"]; // 获取临时文件的名称 如果要是租服务器的话要改临时文件夹路径
                $oldfilename = $_FILES ["file"] ['name']; // 获取原来的excel文件名含有后缀 $pinfo=pathinfo($oldfilename);
                $pinfo = pathinfo($oldfilename);
                $ftype = $pinfo ['extension']; // 获取文件的后缀名
                $date = date('YmdGHis');
                $newfilename = $date . '.' . $ftype; // 新的文件路径
                $destination = $destination_folder . $newfilename; // 新excel路径
                if ($ftype == "txt") {
                    $type = 1;
                } else {
                    $type = 2;
                }
                if (file_exists($destination)) {
                    $this->assign('msgTitle', '同名文件已经存在了');
                    $this->assign('message', '请重试');
                    $this->assign('jumpurl', '__APP__/Calltransfernum/bulkadd');
                    $this->display('jump');
                    exit();
                }
                if (!move_uploaded_file($filename, $destination)) {
                    $this->assign('msgTitle', '常用联系人导入出错请查看文件目录是否已满');
                    $this->assign('message', '请重试');
                    $this->assign('jumpurl', '__APP__/Calltransfernum/bulkadd');
                    $this->display('jump');
                    exit();
                }
                $this->adddata($destination, $type); // 把excel中的文件导入数据库
            }
        }
    }

    function adddata($destination_folder, $type) {
        // 修改权限
        chmod($destination_folder, 0777);
        if ($type != 1) {
            $objPHPExcel = PHPExcel_IOFactory::load($destination_folder);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            foreach ($sheetData as $key => $value) {
                $data [] = $value ['A'];
            }
        } else {
            $content = file_get_contents($destination_folder);
            $array = explode("\r\n", $content);
            $data = array();
            foreach ($array as $key => $value) {
                $data [] = $value;
            }
        }
        $data = $this->checkfield($data);
        $checkresult = $data [1];
        $addresult = $this->bulkadddata($data [0]);
        import('ORG.Util.Page');
        $model = M('test', "cb_", 'DB_CONFIG2');
        $count = $model->query('select count(*) from cb_numberpool');
        $count = $count [0] ['count'];
        $header = "条呼转信息";
        $pagesize = 17;
        $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header', $header);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('theme', '共有%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');
        $show = $Page->show(); // 分页显示输出
        $sql = "select * from cb_numberpool";
        $sql = $sql . " limit " . $Page->listRows . " offset " . $Page->firstRow;
        $data = $model->query($sql);
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('timer', $this->getTime());
        $this->assign('transfernumdata', $data);
        $this->assign('timer', $this->getTime());
        $this->assign('addresult', $addresult);
        $this->assign('checkresult', $checkresult);
        $this->display();
    }

    function bulkadddata($data) {
        $model = M('test', "cb_", 'DB_CONFIG2');
        $addresult = array();
        foreach ($data as $key => $value) {
            if ($value != '' && $value != null) {
                $time = time();
                $sqlstr = "insert into cb_numberpool values('" . $value . "','$time')";
                $status = $model->execute($sqlstr);
                if (!$status) {
                    $addresult [$key] = "呼转号码" . $value . "添加失败";
                } else {
                    $addresult [$key] = "呼转号码" . $value . "添加成功";
                }
            }
        }
        return $addresult;
    }

    // 验证手机号码格式
    // 还需要验证是不是该批数据里面含有重复
    function checkfield($data) {
        $data1 = $this->getallnum();
        $contactdata = $data;
        foreach ($data1 as $key => $value) {
            $numdata [$key] = $value ['num'];
        }
        $data1 = $numdata;
        $numarr = array();
        foreach ($data as $key => $value) {
            if (in_array($value, $data1)) {
                $returndata [$key] = "呼转号码" . $value . "已存在，请查证。";
                unset($contactdata [$key]);
                continue;
            }
            if (!in_array($value, $numarr)) {
                $numarr [$key] = $value;
            } else {
                $returndata [$key] = "呼转号码" . $value . "在该文件中重复，请查证。";
                unset($contactdata [$key]);
            }
        }
        $resultdata [0] = $contactdata;
        $resultdata [1] = $returndata;
        return $resultdata;
    }

    function check_telnum1($telnum) {
        $b1 = (preg_match("/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/i", $telnum)) ? TRUE : FALSE;
        $b2 = (preg_match("/^(1[358]{1}[0-9]{9})$/i", $telnum)) ? TRUE : FALSE;
        return $b1 || $b2;
    }

    // 获取用户
    function getallnum() {
        $model = M('test', "cb_", 'DB_CONFIG2');
        $data = $model->query('select * from cb_numberpool');
        return $data;
    }

    // 下载
    function download() {
        $model = M('test', "cb_", 'DB_CONFIG2');
        $numdata = $model->query('select * from cb_numberpool');

        $id = $_GET ['id'];
        if ($id == 1) {
            $file_name = $this->formfile($numdata, 1);
        } else {
            $file_name = $this->formfile($numdata, 2);
        }
        $file_name = iconv("utf-8", "gb2312", $file_name);
        // $file_sub_path=$_SERVER['DOCUMENT_ROOT']."cardmanage/Public/downfile/";
        $file_sub_path = "./Public/file/";
        $file_path = $file_sub_path . $file_name;
        $fp = fopen($file_path, "r");
        $file_size = filesize($file_path);
        // 下载文件需要用到的头
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:" . $file_size);
        Header("Content-Disposition: attachment; filename=" . "呼转号码" . $file_name);
        $buffer = 1024;
        $file_count = 0;
        while (!feof($fp) && $file_count < $file_size) {
            $file_con = fread($fp, $buffer);
            $file_count += $buffer;
            echo $file_con;
        }
        fclose($fp);
        exit();
    }
    
    function formfile($numdata, $type) {
        $destination_folder = './Public/file/';
        if ($type == 1) {
            // txt文件
            $date = date('Y-m-d');
            $newfilename = $date . '.txt'; // 新的文件路径
            $destination = $destination_folder . $newfilename; // 新excel路径
            $fp_write = fopen($destination, "w");
            chmod($destination, 0777);
            foreach ($numdata as $key => $value) {
                $stringdata = $value ['num'] . "\r\n";
                fwrite($fp_write, $stringdata);
            }
            fclose($fp_write);
            return $newfilename;
        } else {
            $date = date('YmdGHis');
            $newfilename = $date . '.txt'; // 新的文件路径
            $destination = $destination_folder . $newfilename; // 新excel路径
            $objExcel = new PHPExcel ();
            $objExcel->getProperties()->setCreator("广州山基公司");
            $objExcel->getProperties()->setLastModifiedBy("");
            $objExcel->getProperties()->setTitle("呼转号码");
            $objExcel->getProperties()->setSubject("呼转号码");
            $objExcel->getProperties()->setDescription("呼转号码");
            $objExcel->getProperties()->setKeywords("呼转号码");
            $objExcel->getProperties()->setCategory("呼转号码");
            $objExcel->setActiveSheetIndex(0);
            $i = 0;
            foreach ($numdata as $key => $value) {
                $u1 = $i + 1;
                $objExcel->getActiveSheet()->setCellValue('a' . $u1, "{$value["num"]}");
                $i ++;
            }
            // 高置列的宽度
            $objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $objExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
            $objExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objExcel->getProperties()->getTitle() . '&RPage &P of &N');   
            $objExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $objExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $objExcel->setActiveSheetIndex(0);
            $timestamp = time();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="呼转号码' . date('Y-m-d') . '.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
            $objWriter->save('php://output');
            exit();
        }
    }

    function querynum() {
        import('ORG.Util.Page');
        $model = M('test', "cb_", 'DB_CONFIG2');
        if (empty($_POST ['num'])) {
            $count = $model->query('select count(*) from cb_numberpool');
            $count = $count [0] ['count'];
            $header = "条呼转信息";
            $pagesize = 17;
            $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('header', $header);
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('theme', '共有%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');
            $show = $Page->show(); // 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $sql = "select * from cb_numberpool";
            $sql = $sql . " limit " . $Page->listRows . " offset " . $Page->firstRow;
            $data = $model->query($sql);
        } else {
            $num = trim($_POST ['num']);
            $count = $model->query("select count(*) from cb_numberpool where num like'%" . $num . "%'");
            $count = $count [0] ['count'];
            $header = "条呼转信息";
            $pagesize = 17;
            $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('header', $header);
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('theme', '共有%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');
            $show = $Page->show(); // 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $sql = "select * from cb_numberpool where num like'%" . $num . "%'";
            // echo $sql;
            // exit();
            $sql = $sql . " limit " . $Page->listRows . " offset " . $Page->firstRow;
            $data = $model->query($sql);
        }
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('timer', $this->getTime());
        $this->assign('transfernumdata', $data);
        $this->assign('timer', $this->getTime());
        $this->display();
    }
}
