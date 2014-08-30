<?php

/* * ************************************************************************************
 * **  文件：RechargeAction.class.php
 * **  说明：代理商权限管理类
 * **  日期：2012-08-12
 * *********************************************************************************** */

// AuthorityAction控制类继承统一入口加载类CommonAction
class MakeappoAction extends CommonAction {

    function index() {
        $user_model = M('users');
        $phonenum = $user_model->where('id=' . $_SESSION ['userid'])->getfield('phonenum');
        $this->assign('phonenum', $phonenum);
        $this->display();
    }

    // 上预约
    function call() {
        $fromtel = trim($_POST ['fromtel']);
        $calledtel = trim($_POST ['calledtel']);
        // 初始化
        //
		$url = "http://127.0.0.1:8088/hotline/requestaction/?action=createcall&loginname=" . $_SESSION ['loginname'] . "&loginpwd=" . $_SESSION ['loginpwd'] . "&calleenum=" . $calledtel;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        $returndata = curl_exec($ch);

        /*
         * $data['status']="success"; $data['message']=$output; $this->ajaxReturn($data,'json');
         */

        // 设置选项，包括URL

        /*
         * $data['status']="success"; $data['message']=$output; $this->ajaxReturn($data,'json');
         */

        switch ($returndata) {
            case '1' :
                $data ['message'] = "已成功发起电话预约";
                break;
            case '-1' :
                $data ['message'] = "您输入的号码有误。请查证后再拨。";
                break;
            case '-2' :
                $data ['message'] = "没有这个用户，请查证。";
                break;
            case '-3' :
                $data ['message'] = "对不起，您已被加入黑名单。";
                break;
            case '-4' :
                $data ['message'] = "您请求的用户被加入黑名单。";
                break;
            case '-5' :
                $data ['message'] = "您的账号已过有效期。";
                break;
            case '-6' :
                $data ['message'] = "您的余额不足，请充值后再拨打。";
            default :
                $data ['message'] = "拨打失败，原因未知，请联系管理员。";
                break;
        }

        $data ['status'] = "success";

        $this->ajaxReturn($data, 'json');
    }

}

?>