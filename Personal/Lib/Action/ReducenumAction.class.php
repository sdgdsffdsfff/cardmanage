<?php

/* * ************************************************************************************
 * **  文件：ReducenumAction.class.php
 * **  说明：缩位拨号
 * **  日期：2012-08-12
 * *********************************************************************************** */

// AuthorityAction控制类继承统一入口加载类CommonAction
class ReducenumAction extends CommonAction {

    function index() {
        $shortnum_model = M('shortnum');
        $shortnumdata = $shortnum_model->where('userid=' . $_SESSION ['userid'])->select();
        // print_r($shortnumdata);
        // exit();
        $this->assign('shortnumdata', $shortnumdata);
        $this->display();
    }

    function update() {
        $shortnum_model = M('shortnum');
        $numdata = $shortnum_model->where('id=' . $_GET ['id'])->select();
        $this->assign('numdata', $numdata);
        $this->display();
    }

    // 值
    function updateshortnum() {
        if (isset($_SERVER ["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER ["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            $shortnum = trim($_POST ['shortnum']);
            /*
             * $data['status']="success"; $data['message']=strlen($shortnum); $this->ajaxReturn($data,"json");
             */
            if (strlen($shortnum) > 4) {

                $data ['status'] = "success";
                $data ['message'] = "缩位号限制为四位请重试";
                $this->ajaxReturn($data, "json");
            }

            $remark = trim($_POST ['remark']);
            $id = $_POST ['id'];
            $shortnum_model = M('shortnum');
            $phonenum = $_POST ['phonenum'];

            /*
             * $data['message']= '为手机号码'.$phonenum.'设置缩位拨号'.$shortnum.'成功'; $data['status']='success'; $this->ajaxReturn($data,'json');
             */
            // 是不是该所谓号码已使用

            $this->checkupdatedata($shortnum, $phonenum, $id, $remark);

            $data ['userid'] = $_SESSION ['userid'];
            $data ['shortnum'] = $shortnum;
            $data ['remark'] = $remark;
            $status = $shortnum_model->where('id=' . $id)->save($data);
            if ($status) {
                $data ['message'] = '为手机号码' . $phonenum . '修改缩位拨号' . $shortnum . '成功';
                $data ['status'] = 'success';
                $this->ajaxReturn($data, 'json');
            } else {

                $data ['message'] = '为手机号码' . $phonenum . '修改缩位拨号' . $shortnum . '失败';
                $data ['status'] = 'failed';
                $this->ajaxReturn($data, 'json');
            }
        }
    }

    // 断卡是不是属于该用户是不是已经使用 添加用户时候使用
    function checkupdatedata($shortnum, $phonenum, $id, $remark) {
        $shortnum_model = M('shortnum');
        $checkdata = $shortnum_model->where('id=' . $id)->select();
        $data = $checkdata [0];

        if ($data ['shortnum'] == $shortnum && $data ['phonenum'] == $phonenum && $data ['remark'] == $remark) {
            $data ['message'] = '您没有修改缩位拨号数据';
            $data ['status'] = 'failed';
            $this->ajaxReturn($data, 'json');
        } else if ($data ['remark'] != $remark) {
            return true;
        } else if ($data ['shortnum'] != $shortnum) {
            $numdata = $shortnum_model->where("shortnum='" . $shortnum . "'and userid=" . $_SESSION ['userid'])->select();
            if (empty($numdata)) {
                return true;
            } else {
                $data ['status'] = "success";
                $data ['message'] = "修改缩位拨号失败，您已为手机号码" . $numdata [0] ['phonenum'] . "设置缩位号码" . $shortnum;
                $this->ajaxReturn($data, 'json');
            }
        }
    }

    // 加缩位拨号
    function add() {
        $this->display();
    }

    // 加缩位拨号
    function addshortnum() {
        if (isset($_SERVER ["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER ["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            $shortnum = trim($_POST ['shortnum']);
            $remark = trim($_POST ['remark']);
            $phonenum = trim($_POST ['phonenum']);
            $shortnum_model = M('shortnum');
            $this->checkshortnum($shortnum, $phonenum, $_SESSION ['userid']);
            $data ['userid'] = $_SESSION ['userid'];
            $data ['shortnum'] = $shortnum;
            $data ['remark'] = $remark;
            $data ['phonenum'] = $phonenum;
            $status = $shortnum_model->add($data);
            if ($status) {
                $data ['message'] = '为手机号码' . $phonenum . '设置缩位拨号' . $shortnum . '成功';
                $data ['status'] = 'success';
                $this->ajaxReturn($data, 'json');
            } else {
                $data ['message'] = '为手机号码' . $phonenum . '设置缩位拨号' . $shortnum . '失败';
                $data ['status'] = 'failed';
                $this->ajaxReturn($data, 'json');
            }
        }
    }

    // 证是不是该手机号码已经有
    function checkshortnum($shortnum, $phonenum, $userid) {
        $shortnum_model = M('shortnum');
        $numdata = $shortnum_model->where("shortnum='" . $shortnum . "'and userid=" . $userid)->select();
        if (!empty($numdata)) {
            $data ['status'] = "success";
            $data ['message'] = "添加缩位拨号失败,您已为手机号码" . $numdata [0] ['phonenum'] . "设置缩位号码" . $shortnum;
            $this->ajaxReturn($data, 'json');
        }

        $numdata1 = $shortnum_model->where("phonenum='" . $phonenum . "'and userid=" . $userid)->select();

        if (!empty($numdata1)) {
            $data ['status'] = "success";
            $data ['message'] = "添加缩位拨号失败,您已为手机号码" . $numdata1 [0] ['phonenum'] . "设置缩位号码" . $numdata1 [0] ['shortnum'] . "请选择修改手机号码。";
            $this->ajaxReturn($data, 'json');
        }
    }

    // 除缩位拨号
    function deleteshortnum() {
        if (isset($_SERVER ["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER ["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {
            $id = $_POST ['id'];
            $shortnum_model = M('shortnum');
            $deletestatus = $shortnum_model->where('id=' . $id)->delete();
            if ($deletestatus) {
                $data ['status'] = "success";
                $data ['message'] = "删除缩位拨号成功";
                $this->ajaxReturn($data, 'json');
            } else {
                $data ['status'] = "failed";
                $data ['message'] = "删除缩位拨号失败";
                $this->ajaxReturn($data, 'json');
            }
        }
    }

}

?>