<?php

/* * ************************************************************************************
 * **  文件：changepwdAction.class.php
 * **  说明：修改密码
 * **  日期：2014-04-15
 * *********************************************************************************** */

//AuthorityAction控制类继承统一入口加载类CommonAction
class ChangepwdAction extends CommonAction {

    function index() {
        $this->display();
    }

    function changepwd() {

        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            $account_model = M("account");
            $accountdata['loginpwd'] = md5($_POST['pwd']);
            $oldpwd = md5($_POST['oldpwd']);

            $carddata = $account_model->where('id=' . $_SESSION['accountid'])->select();
            if (empty($carddata) || $carddata[0]['loginpwd'] != $oldpwd) {
                $data['status'] = 'failed';
                $data['message'] = '原密码错误';
                $this->ajaxReturn($data, 'json');
            }

            $status = $account_model->where('id=' . $_SESSION['accountid'])->save($accountdata);

            if ($status) {
                //操作日志
                $operdetail = "管理员" . $_SESSION['loginname'] . "修改自己密码";
                $opertype = "修改密码";
                $this->addlog($operdetail, $opertype);
                $data['status'] = 'success';
                $data['message'] = '密码修改成功';
            } else {
                $data['status'] = 'success';
                $data['message'] = '密码修改失败,请重试';
            }
        }

        $this->ajaxReturn($data, 'json');
    }

}

?>