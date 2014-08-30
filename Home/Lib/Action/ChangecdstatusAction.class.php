<?php

/* * ************************************************************************************
 * **  ChangecdstatusAction.class.php
 * **  说明：卡状态修改
 * **  日期：2014-04-15
 * *********************************************************************************** */

//CountcarddataAction 控制类继承统一入口加载类 CommonAction
class ChangecdstatusAction extends CommonAction {

    function index() {
        $this->assign('carddata', $carddata);
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    function changecdstatus() {
        //验证用户权限
        if (!$this->chk_auth('man_cardstatus')) {
            $data['status'] = "failed";
            $data['message'] = "您没有该权限";
            $this->ajaxReturn($data, 'json');
        }
        $param = $_POST;
        $startcardnum = $param['startcardnum'];
        $stopcardnum = $param['stopcardnum'];
        $type = $param['type'];

        /*
          $data['status']='success';
          $data['message']=$type;
          $this->ajaxReturn($data,'json');
         */

        $card_model = M('cards');
        //如果是总管理员 判断卡ownid 是不是都为0；
        $sql = 'select cardnum from cb_cards where length(cardnum) = 8 order by cardnum desc limit 1';
        $maxcardarr = $card_model->query($sql);
        $maxcardnum = intval($maxcardarr[0]['cardnum']);
        $startcardnum = trim(intval($startcardnum));
        $stopcardnum = trim(intval($stopcardnum));
        if ($startcardnum > $maxcardnum) {
            $data['status'] = 'failed';
            $data['message'] = "起始号码大于最大卡号，请查证！";
            $this->ajaxReturn($data, 'json');
        }
        if ($stopcardnum > $maxcardnum) {
            $data['status'] = 'failed';
            $data['message'] = "结束号码大于最大卡号，请查证！";
            $this->ajaxReturn($data, 'json');
        }

        $sql = "select id,cardnum,ownid,subownid,status from cb_cards where cardnum >= trim(to_char(" . $startcardnum . ",'00000000')) and cardnum <= trim(to_char(" . $stopcardnum . ", '00000000')) and length(cardnum) = 8";
        $carddata = $card_model->query($sql);

        if (empty($carddata)) {
            $data['status'] = "failed";
            $data['message'] = "此号段内没有卡，请查证后再试。";
            $this->ajaxReturn($data, 'json');
        }
        //开始判断是不是该卡号段属于该代理商的
        $cardownidstatus = $this->checkownid($carddata);
        if (!empty($cardownidstatus)) {
            $data['status'] = "该账号卡段中有不属于您的卡！请查证！";
            $data['message'] = $cardownidstatus;
            //返回前台信息 卡号段中有卡号已经下发
            $this->ajaxReturn($data, 'json');
        }

        //验证该卡号段是不是含有已使用的卡号
        $cardstatus = $this->checkcardstatus($carddata);

        if (!empty($cardstatus)) {
            $data['status'] = "该账号卡段中有已使用的卡！请查证！";
            $data['message'] = $cardstatus;
            //返回前台信息 卡号段中有卡号已经下发
            $this->ajaxReturn($data, 'json');
        }

        //还要比较  开始结束大小值
        //验证卡号  是不是该代理商的
        //要验证该卡号段事实不是自己的  还有用户有没有该权限
        //验证是不是有卡已使用过 使用的不能激活
        //更新数据库
        //1为打开 2为锁定

        if ($type == 1) {

            /*
              $data['status']=1;
              //同时把开通方式设置为网站
              $data['openway']=2;
              //激活时间设置为当前时间时间戳类型
              $data['opentime']=time();
             */

            $sql = "UPDATE cb_cards SET  status=1 ,openway=2,opentime=" . time() . "  where cardnum >= trim(to_char(" . $startcardnum . ",'00000000')) and cardnum <= trim(to_char(" . $stopcardnum . ", '00000000')) and length(cardnum) = 8";
            //返回受影响的条数
            $status = $card_model->execute($sql);

            //$status = $card_model->where('cardnum>='.$startcardnum.'and cardnum<='.$stopcardnum)->save($data);
        } else if ($type == 2) {
            $data['status'] = 3;
            //锁定时间设置为当前时间时间戳类型
            $data['locktime'] = time();

            $sql = "UPDATE cb_cards SET  status=3,locktime=" . time() . "  where cardnum >= trim(to_char(" . $startcardnum . ",'00000000')) and cardnum <= trim(to_char(" . $stopcardnum . ", '00000000')) and length(cardnum) = 8";
            //返回受影响的条数
            $status = $card_model->execute($sql);
            //$status = $card_model->where('cardnum>='.$startcardnum.'and cardnum<='.$stopcardnum)->save($data);
        }

        if (!$status) {
            $data['status'] = 'failed';
            $data['message'] = '操作失败！';
            //返回前台信息 卡号段中有卡号已经下发
            $this->ajaxReturn($data, 'json');
        } else {

            if ($type == 1) {
                $data['message'] = '激活成功';
                $mes = "激活";
            } else {
                $data['message'] = '锁定成功';
                $mes = "锁定";
            }

            $operdetail = "管理员" . $_SESSION['loginname'] . "把从" . $startcardnum . "到" . $stopcardnum . "的卡修改状态为" . $mes;
            $opertype = "修改卡状态";
            $this->addlog($operdetail, $opertype);
            $data['status'] = 'success';
            $this->ajaxReturn($data, "json");
        }
    }

    # 检查是不是有卡已使用

    function checkcardstatus($carddata) {
        foreach ($carddata as $value) {

            if ($value['status'] == 2) {
                $status[$value['id']] = "卡号" . $value['cardnum'] . "已使用不能进行操作";
            }
        }
        return $status;
    }

    #验证该卡号是不是属于该代理商

    function checkownid($carddata) {
        $status = array();
        $power = $_SESSION['power'];
        $oldownid = $_SESSION['accountid'];

        #总管理员 全部可以打开
        //ownid是不是一级代理商的
        if ($power == 2) {
            foreach ($carddata as $value) {
                if ($value['ownid'] != $oldownid) {
                    $status[$value['id']] = "卡号" . $value['cardnum'] . "不属于您";
                }
            }
        }

        #subownid二级代理商
        else if ($power == 3) {
            foreach ($carddata as $value) {
                if ($value['subownid'] != $oldownid) {
                    $status[$value['id']] = "卡号" . $value['cardnum'] . "不属于您";
                }
            }
        }
        return $status;
    }

}
