<?php

/* * ************************************************************************************
 * **  文件：QuerycardAction.class.php
 * **  说明：卡查询
 * **  日期：2012-08-12
 * *********************************************************************************** */

//CountcarddataAction 控制类继承统一入口加载类 CommonAction
include './Public/Classes/PHPExcel/IOFactory.php';

class QuerycardAction extends CommonAction {

    function index() {
        #数据统计是统计全部的
        $carddata = $this->getcarddata();
        $this->assign('carddata', $carddata);
        $this->assign('timer', $this->getTime());
    }

    function getcarddata() {

        $carddata = array();
        $postdata = $_POST;
        if (!empty($_POST)) {

            if (!empty($postdata['cardnum'])) {
                $data['cardnum'] = array('like', $postdata['cardnum'] . '%');
            } else if ($postdata['cardnum'] != null) {
                $data['cardnum'] = array('like', '0%');
            }
            if (!empty($postdata['bindtel'])) {
                $data['bindtel'] = array('like', $postdata['bindtel'] . '%');
            }
            if (!empty($postdata['money'])) {
                $data['money'] = $postdata['money'];
            } else if ($postdata['money'] != null) {
                $data['money'] = array('like', '0%');
            }

            if (!empty($postdata['createtime'])) {
                $date = intval(strtotime($postdata['createtime'])) + 86400;
                $data['createtime'] = array('between', array(strtotime($postdata['createtime']), $date));
            }


            #子代理商权限
            if (!empty($postdata['accountid'])) {
                if ($_POST['accountid'] != 0) {
                    //总代理商查询一级代理商通过ownid   一级代理商通过subownid   二级代理商无法使用此权限
                    if ($_SESSION['power'] == 1) {
                        $data['ownid'] = $postdata['accountid'];
                    } else {
                        $data['subownid'] = $postdata['accountid'];
                    }
                }
            }
            if ($postdata['cardstatus'] != 4) {
                $data['status'] = $postdata['cardstatus'];
            }
            $_SESSION['data'] = $data;
        } else {
            $data = $_SESSION['data'];
        }

        //实例化对象

        $pagesize = 17;
        import('ORG.Util.Page'); // 导入分页类
        $card_model = M('cards');
        if ($_SESSION['power'] == 1) {
            $count = $card_model->where($data)->count(); // 查询满足要求的总记录数
            $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('header', '张卡');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('theme', '共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');
            $show = $Page->show(); // 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性

            $list = $card_model->where($data)->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
            $idlist = $card_model->where($data)->order('id desc')->getfield('id', true);
            $this->assign('idlist', serialize($idlist));
            $list = $this->getaccountloginname($list);
            $list = $this->formatfield($list);
            $this->assign('list', $list); // 赋值数据集
            $this->assign('page', $show); // 赋值分页输出
            $this->display(); // 输出模板
        }

        //一级代理的卡  
        else if ($_SESSION['power'] == 2) {
            $ownid = $_SESSION['accountid'];
            if (!empty($_POST)) {
                $data['ownid'] = $ownid;
                $_SESSION['data']['ownid'] = $ownid;
            }

            $count = $card_model->where($data)->count(); // 查询满足要求的总记录数
            $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('header', '张卡');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('theme', '共查询出%totalRow% %header%   第%nowPage%页 | 共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end%   %downPage%');
            $show = $Page->show(); // 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性

            $list = $card_model->where($data)->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
            $idlist = $card_model->where($data)->order('id desc')->getfield('id', true);
            $this->assign('idlist', serialize($idlist));
            $list = $this->getaccountloginname($list);
            $list = $this->formatfield($list);
            $this->assign('list', $list); // 赋值数据集
            $this->assign('page', $show); // 赋值分页输出
            $this->display(); // 输出模板
        }
        //二级代理的卡
        else {
            $ownid = $_SESSION['accountid'];
            if (!empty($_POST)) {
                $data['subownid'] = $ownid;
                $_SESSION['data']['subownid'] = $ownid;
            }

            $count = $card_model->where($data)->count(); // 查询满足要求的总记录数
            $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('header', '张卡');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('theme', '共查询出%totalRow% %header%   第%nowPage%页 | 共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end%   %downPage%');
            $show = $Page->show(); // 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性

            $list = $card_model->where($data)->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
            $idlist = $card_model->where($data)->order('id desc')->getfield('id', true);
            $this->assign('idlist', serialize($idlist));
            $list = $this->getaccountloginname($list);
            $list = $this->formatfield($list);
            $this->assign('list', $list); // 赋值数据集
            $this->assign('page', $show); // 赋值分页输出
            $this->display(); // 输出模板
        }
    }

    function download() {
        $carddata = array();
        $postdata = $_POST;
        if (!empty($_POST)) {


            if (!empty($postdata['cardnum'])) {
                $data['cardnum'] = array('like', $postdata['cardnum'] . '%');
            }

            if (!empty($postdata['money'])) {
                $data['money'] = $postdata['money'];
            }

            if (!empty($postdata['createtime'])) {
                $date = intval(strtotime($postdata['createtime'])) + 86400;
                $data['createtime'] = array('between', array(strtotime($postdata['createtime']), $date));
            }
            #子代理商权限
            if (!empty($postdata['accountid'])) {
                if ($_POST['accountid'] != 0) {
                    //总代理商查询一级代理商通过ownid   一级代理商通过subownid   二级代理商无法使用此权限
                    if ($_SESSION['power'] == 1) {
                        $data['ownid'] = $postdata['accountid'];
                    } else {
                        $data['subownid'] = $postdata['accountid'];
                    }
                }
            }
            if ($postdata['cardstatus'] != 4) {
                $data['status'] = $postdata['cardstatus'];
            }
        }

        $card_model = M('cards');
        if ($_SESSION['power'] == 1) {
            $list = $card_model->where($data)->order('cardnum ASC')->select();
            $list = $this->getaccountloginname($list);
            $list = $this->formatfield($list);
        }
        //一级代理的卡      
        else if ($_SESSION['power'] == 2) {
            $ownid = $_SESSION['accountid'];
            if (!empty($_POST)) {
                $data['ownid'] = $ownid;
            }
            $list = $card_model->where($data)->order('cardnum ASC')->select();
            $card_model->getLastSql();
            $list = $this->getaccountloginname($list);
            $list = $this->formatfield($list);
        }
        //二级代理的卡
        else {
            $ownid = $_SESSION['accountid'];
            if (!empty($_POST)) {
                $data['subownid'] = $ownid;
            }
            $list = $card_model->where($data)->order('cardnum ASC')->select();
            $list = $this->getaccountloginname($list);
            $list = $this->formatfield($list);
        }

        $this->export_txt($list);
    }

    function export_txt($data) {
        $file_name = iconv('utf-8', 'gbk', '账号卡信息') . date('Y-m-d', time()) . '.txt';
        $i = 1;
        $row = "序号\t卡号\t卡密码\t生成日期\t有效期(天)\t充值期限\t金额\r\n";
        foreach ($data as $key => $value) {
            $row .= "$i\t{$value['cardnum']}\t{$value['cardpwd']}\t{$value['createtime']}\t{$value['validityday']}\t" . date('Y-m-d', $value['expirydate']) . "\t{$value['money']}\r\n";
            $i++;
        }
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        //Header("Accept-Length: ".filesize($file_dir . $file_name));
        Header("Content-Disposition: attachment; filename=" . $file_name);
        // 输出文件内容
        echo $row;
        exit();
        //}
    }

    function fianldownload($data) {
        //print_r($data);
        //exit;
        $objExcel = new PHPExcel();
        $objExcel->getProperties()->setCreator("广州山基公司");
        $objExcel->getProperties()->setLastModifiedBy("");
        $objExcel->getProperties()->setTitle("账号卡信息");
        $objExcel->getProperties()->setSubject("账号卡信息");
        $objExcel->getProperties()->setDescription("账号卡信息");
        $objExcel->getProperties()->setKeywords("账号卡信息");
        $objExcel->getProperties()->setCategory("账号卡信息");
        $objExcel->setActiveSheetIndex(0);
        $objExcel->getActiveSheet()->setCellValue('a1', '序号');
        $objExcel->getActiveSheet()->setCellValue('b1', '卡号');
        $objExcel->getActiveSheet()->setCellValue('c1', '卡密码');
        $objExcel->getActiveSheet()->setCellValue('d1', '生成日期');
        $objExcel->getActiveSheet()->setCellValue('e1', '有效期(天)');
        $objExcel->getActiveSheet()->setCellValue('f1', '充值期限');
        $objExcel->getActiveSheet()->setCellValue('g1', '金额');

        $i = 0;
        foreach ($data as $key => $value) {
            $u1 = $i + 2;
            $objExcel->getActiveSheet()->setCellValue('a' . $u1, $i + 1);
            $objExcel->getActiveSheet()->setCellValue('b' . $u1, "" . $value["cardnum"] . "\r");
            $objExcel->getActiveSheet()->setCellValue('c' . $u1, $value["cardpwd"]);
            $objExcel->getActiveSheet()->setCellValue('d' . $u1, $value["createtime"]);
            $objExcel->getActiveSheet()->setCellValue('e' . $u1, $value["validityday"]);
            $objExcel->getActiveSheet()->setCellValue('f' . $u1, date('Y-m-d', $value["expirydate"]));
            $objExcel->getActiveSheet()->setCellValue('g' . $u1, $value["money"]);
            $i++;
        }

        // 高置列的宽度  
        $objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);

        $objExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
        $objExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // 设置页方向和规模  
        $objExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objExcel->setActiveSheetIndex(0);
        $timestamp = time();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . iconv('utf-8', 'gbk', '账号卡信息') . date('Y-m-d', $timestamp) . '.xls"');
        header('Cache-Control: no-cache');
        $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    #获取代理商名

    function getaccountloginname($data) {
        $carddata = $data;
        $account_model = M('account');
        $accountdata = $account_model->getfield('id,loginname', true);
        /* echo '<pre>';
          print_r($accountdata);
         */
        foreach ($data as $key => $value) {
            // print_r($value); 

            if ($value['ownid'] != 0) {

                if ($value['subownid'] != 0) {

                    //把ownid赋值为代理商名
                    $carddata[$key]['ownid'] = $accountdata[$value['subownid']];
                } else {
                    $carddata[$key]['ownid'] = $accountdata[$value['ownid']];
                }
            } else {
                $carddata[$key]['ownid'] = $_SESSION['loginname'];
            }
        }
        return $carddata;
    }

    #格式化字符串   如状态  时间处理

    function formatfield($data) {
        $carddata = $data;
        //卡状态修改
        foreach ($data as $key => $pervalue) {

            #卡状态
            switch ($pervalue['status']) {
                case 0:
                    $carddata[$key]['status'] = '未激活';
                    break;
                case 1:
                    $carddata[$key]['status'] = '已激活';
                    break;
                case 2:
                    $carddata[$key]['status'] = '已使用';
                    break;
                default:
                    $carddata[$key]['status'] = '已锁定';
                    break;
            }
            #卡时间注册时间
            $carddata[$key]['createtime'] = date("Y/m/d ", $carddata[$key]['createtime']); //H:i:s
            #开通方式格式化
            switch ($pervalue['openway']) {
                case 1:
                    $carddata[$key]['openway'] = "电话";
                    break;
                case 2:
                    $carddata[$key]['openway'] = "网站";
                    break;
                case 3:
                    $carddata[$key]['openway'] = "微信";
                    break;
                case 4:
                    $carddata[$key]['openway'] = '短信';
                    break;
                default:
                    $carddata[$key]['openway'] = "";
                    break;
            }
        }

        return $carddata;
    }

    #格式化字符串   如状态  时间处理

    function formatfield1($data) {
        $carddata = $data;
        //卡状态修改
        foreach ($data as $key => $pervalue) {

            #卡时间注册时间


            if (!empty($carddata[$key]['createtime'])) {

                $carddata[$key]['createtime'] = date("Y/m/d ", $carddata[$key]['createtime']); //H:i:s
            }

            if (!empty($carddata[$key]['opentime'])) {

                $carddata[$key]['opentime'] = date("Y-m-d H:i:s", $carddata[$key]['opentime']);
            }

            if (!empty($carddata[$key]['locktime'])) {

                $carddata[$key]['locktime'] = date("Y-m-d H:i:s", $carddata[$key]['locktime']);
            }

            if (!empty($carddata[$key]['filltime'])) {

                $carddata[$key]['filltime'] = date("Y-m-d H:i:s", $carddata[$key]['filltime']);
            }




            #开通方式格式化
            switch ($pervalue['openway']) {
                case 1:
                    $carddata[$key]['openway'] = "电话";
                    break;
                case 2:
                    $carddata[$key]['openway'] = "网站";
                    break;
                case 3:
                    $carddata[$key]['openway'] = "微信";
                    break;
                case 4:
                    $carddata[$key]['openway'] = '短信';
                    break;
                default:
                    $carddata[$key]['openway'] = "";
                    break;
            }
        }

        return $carddata;
    }

    #更新数据实现变量分配

    function updatecarddata() {
        // print_r($_GET);
        // exit();
        $cardid = $_GET['id'];
        $card_model = M('cards');
        $carddata = $card_model->where('id=' . $cardid)->select();
        $carddata = $this->formatfield1($carddata);
        $this->assign('carddata', $carddata);
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    #更新实现

    function updatecard() {

        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            if (!empty($_POST['bindtel'])) {
                $status = $this->check_telnum($_POST['bindtel']);

                if (!$status) {
                    $data['status'] = "failed";
                    $data['message'] = "手机号码格式不正确";
                    $this->ajaxReturn($data, 'json');
                }
            }

            $data['money'] = $_POST['money'];
            $id = intval($_POST['cardid']);
            $data['cardpwd'] = $_POST['cardpwd'];
            $data['remark'] = trim($_POST['remark']);
            $data['bindtel'] = $_POST['bindtel'];
            $data['status'] = $_POST['status'];
            $card_model = M('cards');
            $old = $card_model->where('id=' . $id)->find();
            $status = $card_model->where('id=' . $id)->save($data);

            if ($status) {


                $carddata = $card_model->where('id=' . $id)->select();
                $operdetail = '管理员' . $_SESSION['loginname'] . '对卡' . $carddata[0]['cardnum'] . '做了以下操作:';
                if ($data['cardpwd'] != $old['cardpwd']) {
                    $operdetail.='密码由' . $old['cardpwd'] . '修改为' . $data['cardpwd'];
                }
                if ($data['bindtel'] != $old['bindtel']) {
                    $operdetail.='绑定电话由' . $old['bindtel'] . '修改为' . $data['bindtel'];
                }
                $status = array('未激活', '已激活', '已使用', '已绑定');
                if ($data['status'] != $old['status']) {
                    $operdetail.='状态由' . $status[$old['status']] . '修改为' . $status[$data['status']];
                }
                if ($data['remark'] != $old['remark']) {
                    $operdetail.='备注由' . $old['remark'] . '修改为' . $data['remark'];
                }
                $opertype = '修改卡信息';
                $this->addlog($operdetail, $opertype);

                $data['status'] = "success";
                $data['message'] = "修改成功";
            } else {
                $data['status'] = "failed";
                $data['message'] = "修改失败";
            }
        }

        $this->ajaxReturn($data, 'json');
    }

    function check_telnum($telnum) {
        $b1 = (preg_match("/^(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)$/i", $telnum)) ? TRUE : FALSE;
        $b2 = (preg_match("/^(1[358]{1}[0-9]{9})$/i", $telnum)) ? TRUE : FALSE;
        return $b1 || $b2;
    }

    #lockcard

    function lockcard() {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {



            $card_model = M('cards');
            $card_model = M('cards');
            $cardstatus = $card_model->where('id=' . $_POST['cardid'])->getfield('status');
            if ($cardstatus == 2) {
                $data['status'] = "failed";
                $data['message'] = "锁定失败，该卡号已使用";
                $this->ajaxReturn($data, 'json');
            }
            $data['status'] = 3;
            $data['locktime'] = time();
            $status = $card_model->where('id=' . $_POST['cardid'])->save($data);
            if ($status) {

                $carddata = $card_model->where('id=' . $_POST['cardid'])->select();
                $operdetail = '管理员' . $_SESSION['loginname'] . '把' . $carddata[0]['cardnum'] . '的状态修改为锁定';

                $opertype = '修改卡状态';
                $this->addlog($operdetail, $opertype);

                $data['status'] = "success";
                $data['message'] = "锁定成功";
            } else {
                $data['status'] = "failed";
                $data['message'] = "锁定失败";
            }

            $this->ajaxReturn($data, 'json');
        }
    }

    #lockcard

    function opencard() {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            //验证该卡的状态
            $card_model = M('cards');
            $cardstatus = $card_model->where('id=' . $_POST['cardid'])->getfield('status');
            if ($cardstatus == 2) {
                $data['status'] = "failed";
                $data['message'] = "激活失败，该卡号已使用";
                $this->ajaxReturn($data, 'json');
            }

            $data['status'] = 1;
            $data['openway'] = 2;
            $data['opentime'] = time();
            $status = $card_model->where('id=' . $_POST['cardid'])->save($data);

            if ($status) {
                $carddata = $card_model->where('id=' . $_POST['cardid'])->select();
                $operdetail = '管理员' . $_SESSION['loginname'] . '把' . $carddata[0]['cardnum'] . '的状态修改为激活';
                $opertype = '修改卡状态';
                $this->addlog($operdetail, $opertype);
                $data['status'] = "success";
                $data['message'] = "激活成功";
            } else {
                $data['status'] = "failed";
                $data['message'] = "激活失败";
            }
            $this->ajaxReturn($data, 'json');
        }
    }

    function delcard() {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            $card_model = M('cards');
            $cardstatus = $card_model->where('id=' . $_POST['cardid'])->delete();
            if ($cardstatus) {
                $data['status'] = "success";
                $data['message'] = "刪除成功";
            } else {
                $data['status'] = "failed";
                $data['message'] = "刪除失败";
            }
            $this->ajaxReturn($data, 'json');
        }
    }

    public function batchDel() {
        if ($this->isAjax()) {
            $check = $_POST['check'];
            $blacklist = M('cards');
            $blacklist->where(array('id' => array('in', implode(',', $check))))->delete() ? $this->ajaxReturn(array('status' => 'succ', 'info' => '删除成功！')) : $this->ajaxReturn(array('status' => 'error', 'info' => '删除失败！'));
        }
    }

    public function delete() {
        $list = unserialize($_POST['idlist']);
        $card_model = M('cards');
        if ($card_model->where(array('id' => array('in', implode(',', $list))))->delete()) {

            $this->display();
        } else {

            $this->display();
        }
    }

}
