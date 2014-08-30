<?php

/* * ************************************************************************************
 * **  文件：UpuserexpirydateAction.class.php
 * **  说明：修改用户有效期  只要该用户使用过该代理商下的卡  就赋予他权力修改用户有效期  
 * **  日期：2014-4-15
 * *********************************************************************************** */

// CountcarddataAction 控制类继承统一入口加载类 CommonAction
class UpuserexpirydateAction extends CommonAction {

    function index() {
        // 数据统计是统计全部的
        $carddata = $this->getphonedata();
    }

    function getphonedata() {
        $user_model = M('users');
        $card_model = M('cards');

        if ($_SESSION ['power'] == 1) {
            $sql = "select * from cb_users where phonenum in (select bindtel from cb_cards)"; // 全查出来
        } else if ($_SESSION ['power'] == 2) {
            $sql = "select * from cb_users where phonenum in (select bindtel from cb_cards where ownid=" . $_SESSION ['accountid'] . ")";
        }   // 二级代理商
        else {
            $sql = "select * from cb_users where phonenum in (select bindtel from cb_cards where subownid=" . $_SESSION ['accountid'] . ")";
        }

        $userdata = $user_model->query($sql);
        $userdata = $this->formatarrfield($userdata);
        $this->assign('timer', $this->getTime());
        $this->assign("userdata", $userdata);
        $this->display();
    }

    // 更新密码使用
    function updatephone() {
        $user_model = M('users');
        $id = $_GET ['id'];
        $userdata = $user_model->where('id=' . $id)->select();
        $userdata = $this->formatfield($userdata);
        $this->assign('userdata', $userdata);
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    // ajax 更新数据的实现
    function updatephonedata() {
        if (isset($_SERVER ["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER ["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            $id = $_POST ['userid'];
            $data ['expirydate'] = strtotime($_POST ['expirydate']);
            // $data['remark']=$_POST['remark'];
            $user_model = M('users');
            $status = $user_model->where('id=' . $id)->save($data);

            $loginname = $user_model->where('id=' . $id)->getfield('loginname');
            // 操作日志
            $operdetail = "管理员" . $_SESSION ['loginname'] . "把" . $loginname . "的有效期修改为" . $_POST ['expirydate'];
            $opertype = "修改用户信息";
            $this->addlog($operdetail, $opertype);

            if ($status) {
                $data ['status'] = "success";
                $data ['message'] = "修改成功";
            } else {
                $data ['status'] = "failed";
                $data ['message'] = "修改失败";
            }
        }

        $this->ajaxReturn($data, "json");
    }

    // 把单个时间时间格式化
    function formatfield($data) {
        // print_r($data);
        if (!empty($data [0] ['lastusetime'])) {

            $data [0] ['lastusetime'] = date("Y-m-d H:i:s", $data [0] ['lastusetime']);
        }

        if (!empty($data [0] ['registedate'])) {
            $data [0] ['registedate'] = date("Y-m-d H:i:s", $data [0] ['registedate']);
        }

        if (!empty($data [0] ['expirydate'])) {
            $data [0] ['expirydate'] = date("Y-m-d H:i:s", $data [0] ['expirydate']);
        }

        return $data;
    }

    function formatarrfield($userdata) {
        foreach ($userdata as $key => $data) {

            if (!empty($data ['lastusetime'])) {

                $userdata [$key] ['lastusetime'] = date("Y/m/d ", $data ['lastusetime']);
            }

            if (!empty($data ['registedate'])) {
                $userdata [$key] ['registedate'] = date("Y/m/d ", $data ['registedate']);
            }

            if (!empty($data ['expirydate'])) {
                $userdata [$key] ['expirydate'] = date("Y/m/d ", $data ['expirydate']);
            }
        }
        return $userdata;
    }

    // 根据时间查询充值记录
    function queryrechargebytime() {
        if ($this->isAjax()) {
            $starttime = $_POST ['starttime'];
            $endtime = $_POST ['endtime'];
            $phonenum = $_POST ['phonenum'];

            $starttime = intval(strtotime($starttime));
            $endtime = intval(strtotime($endtime));

            $card_model = M('cards');
            $chargedata = $card_model->where('bindtel=' . $phonenum . 'and status=2')->getfield('id,money,cardnum,filltime', true);
            $summoney = $card_model->where('bindtel=' . $phonenum . 'and status=2')->sum('money');

            if ($chargedata != false) {

                $chargedata = $this->formatrechagefield($chargedata);
                $data ['status'] = "data";

                $str = '<tbody>
            <tr style="background-color:#E5E5E5;font-weight:normal;height:18px;">
                <th scope="col">编号</th>
                <th scope="col">卡号</th>
                <th scope="col">充值时间</th>
                <th scope="col">金额</th>
            </tr>';
                foreach ($chargedata as $key => $pervalue) {

                    $str = $str . '<tr style="color:Black;background-color:White;height:18px;" align="center">';
                    $str = $str . '<td style="width:35px;" align="center">' . $pervalue ['id'] . '</td>
                                <td style="width:100px;">' . $pervalue ['cardnum'] . '</td>
                                <td style="width:100px;">' . $pervalue ['filltime'] . '</td>
                                <td style="width:100px;" >' . $pervalue ['money'] . '元</td>
                                </tr>';
                }

                $str = $str . '<tr style="color:Black;background-color:White;height:18px;" align="center">         
                <td style="width:100px;" colspan="3" align="right" >总计</td>             
                <td style="width:60px;">' . $summoney . '元</td>
                 </tr></tbody>';

                $data ['message'] = $str;
            } else {
                $data ['status'] = 'failed';
                $data ['message'] = "该时间段该用户没有充值记录";
            }
        }

        $this->ajaxReturn($data, "json");
    }

    // 根据时间查询账单
    function querybillbytime() {
        if ($this->isAjax()) {
            $starttime = $_POST ['starttime'];
            $endtime = $_POST ['endtime'];
            $userid = $_POST ['userid'];
            $starttime = intval(strtotime($starttime));
            $endtime = intval(strtotime($endtime));
            $billrecord_model = M('billrecord');
            $billdata = $billrecord_model->where('starttime>=' . $starttime . 'and endtime<=' . $endtime . 'and userid=' . $userid)->select();
            $sumtime = $billrecord_model->where('starttime>=' . $starttime . 'and endtime<=' . $endtime . 'and userid=' . $userid)->sum('duration');
            $sumcost = $billrecord_model->where('starttime>=' . $starttime . 'and endtime<=' . $endtime . 'and userid=' . $userid)->sum('cost');
            if ($billdata != false) {
                $billdata = $this->formatbillfield($billdata);
                $data ['status'] = "data";
                $str = '<tbody><tr style="background-color:#E5E5E5;font-weight:normal;height:18px;">
                <th scope="col">编号</th>
                <th scope="col">主叫号码</th>
                <th scope="col">被叫号码</th>
                <th scope="col">开始时间</th>
                <th scope="col">结束时间</th>
                <th scope="col">时长/秒</th>
                <th scope="col">费用</th>
                </tr>';
                foreach ($billdata as $key => $pervalue) {

                    $str = $str . '<tr style="color:Black;background-color:White;height:18px;" align="center">';
                    $str = $str . '<td style="width:35px;" align="center">' . $pervalue ['id'] . '</td>
                                <td style="width:100px;">' . $pervalue ['callernum'] . '</td>
                                <td style="width:100px;">' . $pervalue ['callednum'] . '</td>
                                <td style="width:100px;" >' . $pervalue ['starttime'] . '</td>
                                <td style="width:100px">' . $pervalue ['endtime'] . '</td>
                                <td style="width:60px;">' . $pervalue ['duration'] . '</td>
                                <td style="width:60px;">' . $pervalue ['cost'] . '</td></tr>';
                }
                $str = $str . '<tr style="color:Black;background-color:White;height:18px;" align="center">               
                <td style="width:100px;" colspan="5" align="right" >总计</td>         
                <td style="width:60px;">' . $sumtime . '</td>
                <td style="width:60px;">' . $sumcost . '</td>
                </tr>
                </tbody>';
                $data ['message'] = $str;
            } else {
                $data ['status'] = 'failed';
                $data ['message'] = "该时间段该用户没有通话记录";
            }
        }
        $this->ajaxReturn($data, "json");
    }

}
