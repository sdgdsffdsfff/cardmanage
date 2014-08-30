<?php

/* * ************************************************************************************
 * **  文件：changepwdAction.class.php
 * **  说明：代理商权限管理类
 * **  日期：2012-08-12
 * *********************************************************************************** */

//AuthorityAction控制类继承统一入口加载类CommonAction
class ChangepwdAction extends CommonAction {

    function index() {
        $this->display();
    }

    function changepwd() {

        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            $user_model = M("users");
            $data['loginpwd'] = $_POST['pwd'];
            $oldpwd = $_POST['oldpwd'];



            $userdata = $user_model->where('id=' . $_SESSION['userid'])->select();

            /*
              $data['status']='success';
              $data['message']=$oldpwd.$userdata[0]['loginpwd'];
              $this->ajaxReturn($data,'json'); */


            if (empty($userdata) || $userdata[0]['loginpwd'] != $oldpwd) {
                $data['status'] = 'failed';
                $data['message'] = '原密码错误';
                $this->ajaxReturn($data, 'json');
            }

            $status = $user_model->where('id=' . $_SESSION['userid'])->save($data);

            if ($status) {
                $data['status'] = 'success';
                $data['message'] = '密码修改成功';
            } else {
                $data['status'] = 'success';
                $data['message'] = '密码修改失败,请重试';
            }
        }

        $this->ajaxReturn($data);
    }

}

?>