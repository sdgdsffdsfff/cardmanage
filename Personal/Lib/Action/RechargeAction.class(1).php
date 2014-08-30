<?php

/* * ************************************************************************************
 * **  文件：RechargeAction.class.php
 * **  说明：代理商权限管理类
 * **  日期：2012-08-12
 * *********************************************************************************** */

//AuthorityAction控制类继承统一入口加载类CommonAction
class RechargeAction extends CommonAction {

    function index() {
        $user_model = M('users');
        $phonenum = $user_model->where('id=' . $_SESSION['userid'])->getfield('phonenum');
        $this->assign('phonenum', $phonenum);
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    #充值

    function recharge() {

        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            $cardpwd = trim($_POST['cardpwd']);
            $cardnum = trim($_POST['cardnum']);
            $user_model = M('users');
            $rechargetel = $user_model->where('id=' . $_SESSION['userid'])->getfield('phonenum');

            # 还要判断卡的状态是不是已经激活  是不是已经使用是不是属于该用户根据绑定电话跟该用户电话比较 
            $status = $this->checkcardstatus($cardnum, $rechargetel);
            # 修改充值时间是不是已经修改了   还有充值号码是不是已经添加？？？？？？

            if ($status) {
                $sql = "SELECT callback_opencard_oper('" . $cardnum . "','" . $cardpwd . "','" . $rechargetel . "',2)";
                $card_model = M('cards');
                $status = $card_model->query($sql);
            }

            if ($status[0]['callback_opencard_oper'] == 't') {


                $data['message'] = '使用充值卡' . $cardnum . '充值成功。';
                $data['status'] = 'success';
                $this->ajaxReturn($data, 'json');
            } else if ($status[0]['callback_opencard_oper'] == '-1') {

                $data['message'] = '使用充值卡' . $cardnum . '充值失败，卡号或密码不正确请重试。';
                $data['status'] = 'failed';
                $this->ajaxReturn($data, 'json');
            } else if ($status[0]['callback_opencard_oper'] == '-2') {
                $data['message'] = '使用充值卡' . $cardnum . '充值失败，该卡未激活或状态不正确。';
                $data['status'] = 'failed';
                $this->ajaxReturn($data, 'json');
            } else if ($status[0]['callback_opencard_oper'] == '-3') {
                $data['message'] = '使用充值卡' . $cardnum . '充值失败，该卡已过期。';
                $data['status'] = 'failed';
                $this->ajaxReturn($data, 'json');
            }
        }


        $this->ajaxReturn($data);
    }

    #判断卡是不是属于该用户是不是已经使用

    function checkcardstatus($cardnum, $rechargetel) {

        /*
          $data['status']="success";
          $data['message']=$cardnum.$rechargetel;
          $this->ajaxReturn($data,'json');
         */


        $card_model = M('cards');
        $carddata = $card_model->where("cardnum='" . $cardnum . "'")->select();

        /*
          $data['status']="success";
          $data['message']=$carddata[0]['bindtel'];
          $this->ajaxReturn($data,'json');
         */
        /*
          if($carddata[0]['bindtel']!=$rechargetel)
          {
          $data['message']='该卡号不属于您，请联系代理商。';
          $data['status']='failed';
          $this->ajaxReturn($data,'json');
          }
         */

        if ($carddata[0]['status'] != 1) {
            switch ($carddata[0]['status']) {
                case 0:
                    $mes = "未激活";
                    break;
                case 2:
                    $mes = "已使用";
                    break;
                default:
                    $mes = "已锁定";
                    break;
            }

            $data['message'] = '该卡状态为' . $mes . '，请联系代理商。';
            $data['status'] = 'failed';
            $this->ajaxReturn($data, 'json');
        }

        return true;
    }

}

?>