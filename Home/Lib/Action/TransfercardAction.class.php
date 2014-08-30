<?php

/* * ************************************************************************************
 * **  文件：TransfercardAction.class.php
 * **  说明：转移卡到代理商
 * **  日期：2014-04-15
 * *********************************************************************************** */

// TransfercardAction控制类继承统一入口加载类CommonAction
class TransfercardAction extends CommonAction {

    function index() {
        // 还需要初始化
        $account_model = M('account');
        $accountdata = $account_model->where('ownid=' . $_SESSION ['accountid'])->getfield('id,loginname', true);
        // print_r($accountdata);
        $this->assign('accountdata', $accountdata);
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    function transfer() {
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    // 卡号下发代理商时候要验证卡的状态 是不是未激活
    // 查看卡状态是不是未激活状态 防止下发已激活已使用已锁定状态的卡片
    // ajax 返回值 $data['status']="状态";
    // $data['message']="具体信息"；
    function checkcardstatus() {

        // 开始验证账号卡状态 判断是不是数字
        $param = $_POST;
        $startcardnum = $param ['startcardnum'];
        $stopcardnum = $param ['stopcardnum'];
        if (strlen($startcardnum) != 8) {
            $data ['status'] = 'failed';
            $data ['message'] = "起始号码必须为全8位卡号！";
            $this->ajaxReturn($data, 'json');
        }
        if (strlen($stopcardnum) != 8) {
            $data ['status'] = 'failed';
            $data ['message'] = "结束号码必须为全8位卡号！";
            $this->ajaxReturn($data, 'json');
        }
        // 还得加判断$startcardnum 比$stopcardnum小

        $card_model = M('cards');
        // 如果是总管理员 判断卡ownid 是不是都为0；

        $sql = 'select MAX(cardnum) from cb_cards';

        $maxcardarr = $card_model->query($sql);

        $maxcardnum = intval($maxcardarr [0] ['max']);
        ;
        $startcardnum = trim(intval($startcardnum));
        $stopcardnum = trim(intval($stopcardnum));

        if ($startcardnum > $stopcardnum) {
            $data ['status'] = 'failed';
            $data ['message'] = "起始号码大于结束号码";
            $this->ajaxReturn($data, 'json');
        }

        if ($startcardnum > $maxcardnum) {
            $data ['status'] = 'failed';
            $data ['message'] = "起始号码大于最大卡号，请查证！";
            $this->ajaxReturn($data, 'json');
        }

        if ($stopcardnum > $maxcardnum) {
            $data ['status'] = 'failed';
            $data ['message'] = "结束号码大于最大卡号，请查证！";
            $this->ajaxReturn($data, 'json');
        }

        $sql = "select id,cardnum,ownid,subownid,status from cb_cards where cardnum >= trim(to_char(" . $startcardnum . ",'00000000')) and cardnum <= trim(to_char(" . $stopcardnum . ", '00000000')) and length(cardnum) = 8";
        $carddata = $card_model->query($sql);

        if (empty($carddata)) {

            $data ['status'] = "failed";
            $data ['message'] = "该号码段内没有卡";
            $this->ajaxReturn($data, 'json');
        }

        // 开始判断ownid
        $cardownidstatus = $this->checkownid($carddata);

        if (!empty($cardownidstatus)) {
            $data ['status'] = "该账号段中含有已下发账号";
            $data ['message'] = $cardownidstatus;
            // 返回前台信息 卡号段中有卡号已经下发
            $this->ajaxReturn($data, 'json');
        } else {
            $cardstatus = $this->checkstatus($carddata);
            // 数据没有问题时候执行
            if (empty($cardstatus)) {

                // 卡号下发代理商状态
                $status = $this->transfercard($_POST);
                if ($status) {

                    $operdetail = "管理员" . $_SESSION ['loginname'] . "把从" . $startcardnum . "到" . $stopcardnum . "的卡下发给代理商";
                    $opertype = "卡号下发代理商";
                    $this->addlog($operdetail, $opertype);
                    $data ['status'] = "success";
                    $data ['message'] = "卡号下发代理商成功";
                }
                $this->ajaxReturn($data, 'json');
            } else {
                $data ['status'] = "该账号段中账号状态有问题";
                $data ['message'] = $cardstatus;
                $this->ajaxReturn($data, 'json');
            }
        }
    }

    function transfercard($param) {
        $startcardnum = $param ['startcardnum'];
        $stopcardnum = $param ['stopcardnum'];
        // 更新这个段内的ownid为 $param['accountid']
        $ownid = $param ['accountid'];
        if (empty($ownid)) {

            $data ['status'] = "failed";
            $data ['message'] = "您还没有下级代理商，请先添加。";
            $this->ajaxReturn($data, 'json');
        }

        $card_model = M('cards');
        $power = $_SESSION ['power'];
        $startcardnum = trim(intval($startcardnum));
        $stopcardnum = trim(intval($stopcardnum));
        if ($power == 1) {
            $sql = "UPDATE cb_cards SET  ownid=" . $ownid . "  where cardnum >= trim(to_char(" . $startcardnum . ",'00000000')) and cardnum <= trim(to_char(" . $stopcardnum . ", '00000000')) and length(cardnum) = 8";
            // 返回受影响的条数
            $updatestatus = $card_model->execute($sql);
        } else if ($power == 2) {
            $sql = "UPDATE cb_cards SET  subownid=" . $ownid . "  where cardnum >= trim(to_char(" . $startcardnum . ",'00000000')) and cardnum <= trim(to_char(" . $stopcardnum . ", '00000000'))  and length(cardnum) = 8";
            $updatestatus = $card_model->execute($sql);
        } else {
            return false;
        }

        if ($updatestatus) {
            // success

            return true;
        } else {
            // failed
            return false;
        }
    }

    // 验证该卡号段卡号状态 已使用 已锁定 排除掉
    function checkstatus($carddata) {
        $status = array();
        foreach ($carddata as $value) {

            if (($value ['status'] != 0) && ($value ['status'] != 1)) {
                switch ($value ['status']) {
                    case 2 :
                        $status [$value ['id']] = '卡号：' . $value ['cardnum'] . "状态：已使用";
                        break;
                    default :
                        $status [$value ['id']] = '卡号：' . $value ['cardnum'] . "状态：已锁定";
                        break;
                }
            }
        }
        return $status;
    }

    // 验证卡号段是不是该代理商拥有的
    function checkownid($carddata) {
        $status = array();
        $power = $_SESSION ['power'];
        $oldownid = $_SESSION ['accountid'];
        // 总管理员 手下的没下发的ownid 只能是0

        if ($power == 1) {

            foreach ($carddata as $value) {
                if (!$value ['ownid'] == 0) {
                    // 总管理员查询ownid就可
                    // $accountname= $this->queryaccountname($value['ownid']);
                    $accountdata = $this->queryaccountname();
                    $accountname = $accountdata [$value ['ownid']];
                    $status [$value ['id']] = "卡号" . $value ['cardnum'] . "已经下发代理商(" . $accountname . ")";
                }
            }
        }

        // ownid是不是一级代理商的
        else if ($power == 2) {
            foreach ($carddata as $value) {

                if ($value ['ownid'] != $oldownid) {

                    $status [$value ['id']] = "卡号" . $value ['cardnum'] . "不属于您，请联系管理员";
                } else {
                    if ($value ['subownid'] != 0) {

                        $status [$value ['id']] = "卡号" . $value ['cardnum'] . "已经下发代理商";
                    }
                }
            }
        }
        return $status;
    }

    function queryaccountname() {
        $account_model = M('account');
        $accountdata = $account_model->getfield('id,loginname', true);
        return $accountdata;
    }

}
