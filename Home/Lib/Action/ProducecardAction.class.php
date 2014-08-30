<?php

/* * ************************************************************************************
 * **  文件：ProducecardAction.class.php
 * **  说明：生成卡
 * **  日期：2012-08-12
 * *********************************************************************************** */

//TransfercardAction控制类继承统一入口加载类CommonAction
class ProducecardAction extends CommonAction {

    function index() {
        //还需要初始化
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    //卡号下发代理商时候要验证卡的状态 是不是未激活
    #查看卡状态是不是未激活状态  防止下发已激活已使用已锁定状态的卡片
    #ajax 返回值 $data['status']="状态";
    #            $data['message']="具体信息"；

    function producecard() {

        //开始验证账号卡状态   判断是不是数字
        $param = $_POST;
        $startcardnum = $param['startcardnum'];
        $stopcardnum = $param['stopcardnum'];
        $money = $param['money'];
        $validityday = intval(trim($param['validityday']));
        $expirydate = $param['expirydate'];
        $expirydate = intval(trim(strtotime($expirydate)));

        //还得加判断$startcardnum 比$stopcardnum小

        $card_model = M('cards');

        $startcardnum = trim(intval($startcardnum));
        $stopcardnum = trim(intval($stopcardnum));
        $money = trim(intval($money));

        if ($startcardnum > $stopcardnum) {
            $data['status'] = 'failed';
            $data['message'] = "起始号码大于结束号码";
            $this->ajaxReturn($data, 'json');
        }

        $sql = "select id,cardnum,ownid,subownid,status from cb_cards where cardnum >= trim(to_char(" . $startcardnum . ",'00000000')) and cardnum <= trim(to_char(" . $stopcardnum . ", '00000000'))";
        $carddata = $card_model->query($sql);

        if (!empty($carddata)) {

            //操作日志
            $operdetail = "管理员" . $_SESSION['loginname'] . "生成卡号从" . $startcardnum . "到" . $stopcardnum . "每张金额：" . $money . "元失败，" . "原因：该卡号段内已经含有卡。";
            $opertype = "生成卡";
            $this->addlog($operdetail, $opertype);

            $data['status'] = "failed";
            $data['message'] = "该号码段内已有卡，请查证后再试！";
            $this->ajaxReturn($data, 'json');
        }
        $this->produce($startcardnum, $stopcardnum, $money, $validityday, $expirydate);
    }

    function produce($startcardnum, $stopcardnum, $money, $validityday, $expirydate) {
        $sql = 'SELECT callback_generate_card(' . $startcardnum . ',' . $stopcardnum . ',' . $money . ',' . $validityday . ',' . $expirydate . ', ' . $_SESSION['accountid'] . ')';
        $card_model = M('cards');
        $status = $card_model->query($sql);
        if ($status[0]['callback_generate_card'] == "SUCCESS") {

            $operdetail = "管理员" . $_SESSION['loginname'] . "生成卡号从" . $startcardnum . "到" . $stopcardnum . "每张金额：" . $money . "元";
            $opertype = "生成卡";
            $this->addlog($operdetail, $opertype);

            $data['message'] = "生成卡号" . $startcardnum . "到" . $stopcardnum . "金额为" . $money . "成功！";
            $data['status'] = 'success';
            $this->ajaxReturn($data, 'json');
        } else if ($status[0]['callback_generate_card'] == "FAILED") {

            $operdetail = "管理员" . $_SESSION['loginname'] . "生成卡号从" . $startcardnum . "到" . $stopcardnum . "每张金额：" . $money . "失败，原因未知。";
            $opertype = "生成卡";
            $this->addlog($operdetail, $opertype);
            $data['message'] = "生成卡号" . $startcardnum . "到" . $stopcardnum . "金额为" . $money . "失败！";
            $data['status'] = 'failed';
            $this->ajaxReturn($data, 'json');
        } else {
            $data['message'] = '原因未知';
            $data['status'] = 'failed';
            $this->ajaxReturn($data, 'json');
        }
    }

}
