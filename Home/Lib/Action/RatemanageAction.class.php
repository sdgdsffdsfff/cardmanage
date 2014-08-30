<?php

/* * ************************************************************************************
 * **  文件：RatemanageAction.class.php
 * **  说明：费率管理
 * **  日期：2014-04-15
 * *********************************************************************************** */

//CountcarddataAction 控制类继承统一入口加载类 CommonAction
class RatemanageAction extends CommonAction {

    function index() {
        #数据统计是统计全部的
        if (isset($_GET['accountid'])) {
            $accountid = $_GET['accountid'];
        } else {
            $accountid = -1;
        }
        $this->assign('timer', $this->getTime());
        $carddata = $this->getratedata($accountid);
    }

    #获取费率数据

    function getratedata($accountid) {
        if ($accountid != -1) {
            $this->assign('accountid', $accountid);
        }
        $fee_model = M('fee');
        $account_model = M('account');
        $id = $account_model->where('ownid = 0')->getfield('id');
        $feedata = $fee_model->order('id asc')->where('ownid=' . $id)->select();
        $feedata = $this->format($feedata);
        $this->assign('feedata', $feedata);
        $defaultfeedata = $fee_model->where("starttime='0000'and endtime='0000' and ownid =" . $id)->select();
        $accountdata = $account_model->getfield('id,loginname,power');
        $this->assign('accountdata', $accountdata);
        $this->assign('defaultfeedata', $defaultfeedata);
        $this->assign('id', $id);
        $this->display();
    }

    #根据代理商id查询

    function qubyacc() {
        $accountid = $_GET['id'];
        $fee_model = M('fee');
        $account_model = M('account');
        $accountdata = $account_model->getfield('id,loginname,power');
        $this->assign('accountdata', $accountdata);
        if ($accountid == 0) {
            $feedata = $fee_model->select();
        } else {
            $where = 'ownid=' . $accountid;
            $feedata = $fee_model->where($where)->select();
        }
        $id = $account_model->where('ownid = 0')->getfield('id');
        $this->assign('id', $id);
        $defaultfeedata = $fee_model->where("starttime='0000'and endtime='0000' and ownid=" . $accountid)->select();
        $feedata = $this->format($feedata);
        $this->assign('defaultfeedata', $defaultfeedata);
        $this->assign('feedata', $feedata);
        $this->assign('timer', $this->getTime());
        $this->assign('ownid', $accountid);
        $this->display();
    }

    #跳转到添加费率

    function add() {
        $this->assign('ownid', $_GET['ownid']);
        $account_model = M('account');
        $loginname = $account_model->where('id=' . $_GET['ownid'])->getfield('loginname');
        $this->assign('loginname', $loginname);
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    #添加费率

    function addrate() {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
            #修为数字
            /* $data['status']="success";
              $data['message']=$_POST['ownid'];
              $this->ajaxReturn($data,'json'); */
            $starttime = $_POST['starttime'];
            $starttimehour = intval(substr($starttime, 0, 2));
            $starttimemin = substr($starttime, 2);
            $stoptime = $_POST['stoptime'];
            $stoptimehour = intval(substr($stoptime, 0, 2));
            $stoptimemin = substr($stoptime, 2);
            $fee = trim($_POST['rate']);
            $remark = trim($_POST['remark']);
            if ($stoptimehour < $starttimehour) {
                $stoptimehour+=24;
            }
            $stoptime = $stoptimehour . $stoptimemin;
            $starttime = $starttimehour . $starttimemin;
            $stoptime = str_pad($stoptime, 4, 0, STR_PAD_LEFT);
            $starttime = str_pad($starttime, 4, 0, STR_PAD_LEFT);

            $fee_model = M('fee');
            //$sataus=$this->checktime($starttime,$stoptime);

            if (!empty($remark)) {
                $feedata['remark'] = $remark;
            } else {
                $feedata['remark'] = "";
            }

            $feedata['starttime'] = $starttime;
            $feedata['endtime'] = $stoptime;
            $feedata['fee'] = $fee;
            $feedata['ownid'] = intval($_POST['ownid']);
            $addstatus = $fee_model->add($feedata);
            $account_model = M('account');
            $loginname = $account_model->where('id=' . $_POST['ownid'])->getfield('loginname');

            $operdetail = '管理员' . $_SESSION['loginname'] . '为代理商' . $loginname . '添加费率:' . $starttime . '到' . $stoptime . '费率：' . $fee . "元";
            $opertype = '添加费率';
            $this->addlog($operdetail, $opertype);

            if ($addstatus) {
                $data['status'] = "success";
                $data['message'] = "添加成功。";
            } else {
                $data['status'] = "failed";
                $data['message'] = "添加失败。";
            }

            $this->ajaxReturn($data, 'json');
        }
    }

    function format($feedata) {
        $account_model = M('account');
        //id跟 loginname数组
        $data = $account_model->getfield('id,loginname');
        foreach ($feedata as $key => $value) {
            $feedata[$key]['loginname'] = $data[$value['ownid']];
        }
        return $feedata;
    }

    #跳转到默认费率管理

    function defaultrate() {
        $fee_model = M('fee');
        $default = $fee_model->where("starttime='0000'and endtime='0000' and ownid=" . $_GET['ownid'])->limit(1)->select();
        if (empty($default)) {
            $feedata['starttime'] = '0000';
            $feedata['endtime'] = '0000';
            $feedata['fee'] = 0;
            $feedata['ownid'] = intval($_GET['ownid']);
            $id = $fee_model->add($feedata);
            $this->assign('id', $id);
        }

        $default = $fee_model->where("starttime='0000'and endtime='0000' and ownid=" . $_GET['ownid'])->limit(1)->select();
        $this->assign('defaultratedata', $default);
        $account_model = M('account');
        $loginname = $account_model->where('id=' . $_GET['ownid'])->getfield('loginname');
        $this->assign('loginname', $loginname);
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    #添加默认费率

    function updatedefaultrate() {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            #修为数字
            $starttime = $_POST['starttime'];
            $starttimehour = intval(substr($starttime, 0, 2));
            $starttimemin = substr($starttime, 2);
            $stoptime = $_POST['stoptime'];
            $stoptimehour = intval(substr($stoptime, 0, 2));
            $stoptimemin = substr($stoptime, 2);
            $fee = trim($_POST['rate']);
            $id = $_POST['id'];
            $remark = trim($_POST['remark']);
            if ($stoptimehour < $starttimehour) {
                $stoptimehour+=24;
            }

            $stoptime = $stoptimehour . $stoptimemin;
            $starttime = $starttimehour . $starttimemin;
            $stoptime = str_pad($stoptime, 4, 0, STR_PAD_LEFT);
            $starttime = str_pad($starttime, 4, 0, STR_PAD_LEFT);

            $fee_model = M('fee');
            //$sataus=$this->checktime($starttime,$stoptime);

            $feedata['remark'] = $remark;
            $feedata['starttime'] = $starttime;
            $feedata['endtime'] = $stoptime;
            $feedata['fee'] = $fee;
            $updatestatus = $fee_model->where('id=' . $id)->save($feedata);
            $operdetail = '管理员' . $_SESSION['loginname'] . '修改费率:' . $starttime . '到' . $stoptime . '费率：' . $fee . "元";
            $opertype = '修改费率';
            $this->addlog($operdetail, $opertype);

            if ($updatestatus) {

                $data['status'] = "success";
                $data['message'] = "修改成功。";
            } else {
                $data['status'] = "failed";
                $data['message'] = "修改失败。";
            }
            $this->ajaxReturn($data, 'json');
        }
    }

    #更新用户费率初始化

    function updateratedata() {
        $id = $_GET['id'];
        $ownid = $_GET['ownid'];
        $account_model = M('account');
        $loginname = $account_model->where('id=' . $ownid)->getfield('loginname');
        $this->assign('loginname', $loginname);
        $fee_model = M('fee');
        $feedata = $fee_model->where('id=' . $id)->select();
        $this->assign('ratedata', $feedata);
        $this->display();
    }

    #删除用户操作

    function delete() {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
            $fee_model = M('fee');
            $status = $fee_model->where('id=' . $_POST['id'])->delete();
            if ($status) {
                $data['status'] = 'success';
                $data['message'] = '删除费率成功。';
            } else {
                $data['status'] = 'success';
                $data['message'] = '删除费率失败。';
            }

            $this->ajaxReturn($data);
        }
    }

}
