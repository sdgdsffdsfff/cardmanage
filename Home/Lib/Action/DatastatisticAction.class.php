<?php

/* * ************************************************************************************
 * **  DatastatisticAction.class.php
 * **  说明：数据统计
 * **  日期：2014-04-15
 * *********************************************************************************** */

class DatastatisticAction extends CommonAction {

    function index() {
#数据统计是统计全部的
        $card_model = M('cards');
        $user_model = M('users');
        $bill_model = M('billrecord');
        if ($_SESSION['power'] == 1) {
#生成充值卡数
            $sumcard = $card_model->count();
#生成充值卡金额
            $summoney = $card_model->sum('money');
#已使用充值卡数
            $sumusedcard = $card_model->where("status=2")->count();
#冲入金额
            $sumusedmoney = $card_model->where('status=2')->sum('money');
#消费金额等于账单里面cost;
// echo $sumuser;
//exit();
            $sumopencard = $card_model->where('status=1')->count();
            $sumlockcard = $card_model->where('status=3')->count();
            $sumcost = $bill_model->sum('cost');
            $this->assign('summoney', $summoney);
            $this->assign('sumcost', $sumcost);
        } else if ($_SESSION['power'] == 2) {
            $sumcard = $card_model->where('ownid=' . $_SESSION['accountid'])->count();
            $sumusedcard = $card_model->where("status=2 and ownid=" . $_SESSION['accountid'])->count();
#冲入金额
            $sumusedmoney = $card_model->where("status=2 and ownid=" . $_SESSION['accountid'])->sum('money');
            $sumopencard = $card_model->where('status=1 and ownid=' . $_SESSION['accountid'])->count();
            $sumlockcard = $card_model->where('status=3 and ownid=' . $_SESSION['accountid'])->count();
        } else {
            $sumcard = $card_model->where('subownid=' . $_SESSION['accountid'])->count();
            $sumusedcard = $card_model->where("status=2 and subownid=" . $_SESSION['accountid'])->count();
#冲入金额
            $sumusedmoney = $card_model->where("status=2 and subownid=" . $_SESSION['accountid'])->sum('money');
            $sumopencard = $card_model->where('status=1 and subownid=' . $_SESSION['accountid'])->count();
            $sumlockcard = $card_model->where('status=3 and subownid=' . $_SESSION['accountid'])->count();
        }
        if ($_SESSION['power'] != 3) {
            $accountdata = $this->getaccountdata();
            $this->assign('accountdata', $accountdata);
        }
        $this->assign('sumcard', $sumcard);
        $this->assign('sumopencard', $sumopencard);
        $this->assign('sumlockcard', $sumlockcard);
        $this->assign('sumusedcard', $sumusedcard);
        $this->assign('sumusedmoney', $sumusedmoney);
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    function getaccountdata() {
        $account_model = M('account');
        return $account_model->where('ownid=' . $_SESSION['accountid'])->getfield('id,loginname', true);
    }

    function querycard() {
        if ($this->isAjax()) {
            $card_model = M('cards');
            if ($_SESSION['power'] == 1) {
                $starttime = $_POST['starttime'];
                $endtime = $_POST['endtime'];
                $starttime = intval(strtotime($starttime));
                $endtime = intval(strtotime($endtime));
                $where = " AND createtime>$starttime AND createtime<$endtime";
                if ($_POST['accountid'] != 0) {
                    $sumcard = $card_model->where("ownid='{$_POST['accountid']}'" . $where)->count();
                    $sumusedcard = $card_model->where("status=2 and ownid=" . $_POST['accountid'] . $where)->count();
                    $sumopencard = $card_model->where('status=1 and ownid=' . $_POST['accountid'] . $where)->count();
                    $sumlockcard = $card_model->where('status=3 and ownid=' . $_POST['accountid'] . $where)->count();
                } else {
                    $sumcard = $card_model->count("createtime>$starttime AND createtime<$endtime");
                    $sumusedcard = $card_model->where("status=2" . $where)->count();
                    $sumopencard = $card_model->where('status=1' . $where)->count();
                    $sumlockcard = $card_model->where('status=3' . $where)->count();
                }
            } else {
                if ($_POST['accountid'] != 0) {
# code...
                    $sumcard = $card_model->where('subownid=' . $_POST['accountid'])->count();
                    $sumusedcard = $card_model->where("status=2 and subownid=" . $_POST['accountid'])->count();
                    $sumopencard = $card_model->where('status=1 and subownid=' . $_POST['accountid'])->count();
                    $sumlockcard = $card_model->where('status=3 and subownid=' . $_POST['accountid'])->count();
                } else {
                    $sumcard = $card_model->where('ownid=' . $_SESSION['accountid'])->count();
                    $sumusedcard = $card_model->where("status=2 and ownid=" . $_SESSION['accountid'])->count();
                    $sumopencard = $card_model->where('status=1 and ownid=' . $_SESSION['accountid'])->count();
                    $sumlockcard = $card_model->where('status=3 and ownid=' . $_SESSION['accountid'])->count();
                }
            }

            $data['status'] = 'data';
            $data['message'] = '<tr>
                    <td colspan="4" align="left" bgcolor="#f4f4f4" height="25">
                        &nbsp;<span id="Title">统计结果:</span></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#f4f4f4" height="30">
                      总卡数</td>
                  <td align="left" bgcolor="#ffffff" height="25">
                      &nbsp;<span id="Label6" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumcard . '</span>
                      张</td>
                  <td align="center" bgcolor="#f4f4f4" height="25">
                      已开通卡数</td>
                  <td bgcolor="#ffffff">
                      &nbsp;
                      <span id="Label7" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumopencard . '</span>
                      张</td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#f4f4f4" height="30">
                        已锁定卡数</td>
                    <td align="left" bgcolor="#ffffff" height="25">
                        &nbsp;<span id="Label6" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumlockcard . '</span>
                        张</td>
                    <td align="center" bgcolor="#f4f4f4" height="25">
                        已使用卡数</td>
                    <td bgcolor="#ffffff">
                        &nbsp;
                        <span id="Label7" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumusedcard . '</span>
                        张</td>
                </tr>
                <tr>
                    <td colspan="4" style="height: 25px" align="center" bgcolor="#ffffff">
                    </td>
                </tr>';
            $this->ajaxReturn($data, 'json');
        }
    }

#ajax 数据查询实现

    function statistic() {
        if ($this->isAjax()) {
            $card_model = M('cards');
            $user_model = M('users');
            $bill_model = M('billrecord');
            $starttime = $_POST['starttime'];
            $endtime = $_POST['endtime'];
            $starttime = intval(strtotime($starttime));
            $endtime = intval(strtotime($endtime));

            if ($_SESSION['power'] == 1) {

#生成充值卡数
                $sumcard = $card_model->where('createtime>=' . $starttime . 'and createtime<=' . $endtime)->count();
#生成充值卡金额
                $summoney = $card_model->where('createtime>=' . $starttime . 'and createtime<=' . $endtime)->sum('money');
#已使用充值卡数
                $sumusedcard = $card_model->where('createtime>=' . $starttime . 'and createtime<=' . $endtime . 'and status=2')->count();
#冲入金额
                $sumusedmoney = $card_model->where('createtime>=' . $starttime . 'and createtime<=' . $endtime . 'and status=2')->sum('money');
#消费金额产寻
                $sumcost = $bill_model->where('starttime>=' . $starttime . 'and endtime<=' . $endtime)->sum('cost');
                if (!empty($sumcard)) {
                    $data['status'] = 'data';
                    $data['message'] = '<tbody>
                            <tr>
                                <td colspan="4" align="left" bgcolor="#f4f4f4" height="25">
                                    &nbsp;<span id="Title"><font color="blue"></font><font color="blue"></font>统计结果如下：</span></td>
                            </tr>
                            <tr>
                                <td align="center" bgcolor="#f4f4f4" height="30">
                                    生成充值卡数</td>
                                <td align="left" bgcolor="#ffffff" height="25">
                                    &nbsp;<span id="Label3" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumcard . '</span>
                                    张</td>
                                <td align="center" bgcolor="#f4f4f4" height="25">
                                    生成充值金额</td>
                                <td bgcolor="#ffffff">
                                    &nbsp;
                                    <span id="Label4" class="txtalignRight" style="display:inline-block;width:100px;">' . $summoney . '</span>
                                    元</td>
                            </tr>
                            <tr>
                                <td align="center" bgcolor="#f4f4f4" height="30">
                                    使用充值卡数</td>
                                <td align="left" bgcolor="#ffffff" height="25">
                                    &nbsp;<span id="Label6" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumusedcard . '</span>
                                    张</td>
                                <td align="center" bgcolor="#f4f4f4" height="25">
                                    充值金额</td>
                                <td bgcolor="#ffffff">
                                    &nbsp;
                                    <span id="Label7" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumusedmoney . '</span>
                                    元</td>
                            </tr>
                              <tr>
                                <td align="center" bgcolor="#f4f4f4" height="30">
                                    消费金额</td>
                                <td align="left" bgcolor="#ffffff" height="25">
                                    &nbsp;<span id="Label5" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumcost . '</span>
                                    元</td>
                                <td align="center" bgcolor="#f4f4f4" height="30" width="20%">
                                    </td>
                                <td align="left" bgcolor="#ffffff" height="25" width="30%">
                                    &nbsp;<span id="Label1" class="txtalignRight" style="display:inline-block;width:100px;"></span>
                                 </td>

                                 <!--
                                <td align="center" bgcolor="#f4f4f4" height="25" width="20%">
                                    注册金额</td>
                                <td bgcolor="#ffffff">
                                    &nbsp;
                                    <span id="Label2" class="txtalignRight" style="display:inline-block;width:100px;">0</span>
                                    元</td>-->         
                              </tr>
                              <tr>
                                <td colspan="4" style="height: 25px" align="center" bgcolor="#ffffff">
                                </td>
                            </tr>
                          </tbody>';
                } else {
                    $data['status'] = 'failed';
                    $data['message'] = "此时间段内没有统计数据";
                }
            } else if ($_SESSION['power'] == 2) {
                $sumusedcard = $card_model->where('status=2 and ownid=' . $_SESSION['accountid'] . 'and createtime>=' . $starttime . 'and createtime<=' . $endtime)->count();
#冲入金额
                $sumusedmoney = $card_model->where('status=2 and ownid=' . $_SESSION['accountid'] . 'and createtime>=' . $starttime . 'and createtime<=' . $endtime)->sum('money');



                $data['status'] = 'data';
                $data['message'] = '<tbody>
                            <tr>
                                <td colspan="4" align="left" bgcolor="#f4f4f4" height="25">
                                    &nbsp;<span id="Title"><font color="blue"></font><font color="blue"></font>统计结果如下：</span></td>
                            </tr>
                            <tr>
                            <td align="center" bgcolor="#f4f4f4" height="30">
                                使用充值卡数</td>
                            <td align="left" bgcolor="#ffffff" height="25">
                                &nbsp;<span id="Label6" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumusedcard . '</span>
                                张</td>
                            <td align="center" bgcolor="#f4f4f4" height="25">
                                充值金额</td>
                            <td bgcolor="#ffffff">
                                &nbsp;
                                <span id="Label7" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumusedmoney . '</span>
                                元</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="height: 25px" align="center" bgcolor="#ffffff">
                                </td>
                            </tr>
                          </tbody>';
            } else {
                $sumusedcard = $card_model->where('status=2 and subownid=' . $_SESSION['accountid'] . 'and createtime>=' . $starttime . 'and createtime<=' . $endtime)->count();
#冲入金额
                $sumusedmoney = $card_model->where("status=2 and subownid=" . $_SESSION['accountid'] . 'and createtime>=' . $starttime . 'and createtime<=' . $endtime)->sum('money');

                $data['status'] = 'data';
                $data['message'] = '<tbody>
                            <tr>
                                <td colspan="4" align="left" bgcolor="#f4f4f4" height="25">
                                    &nbsp;<span id="Title"><font color="blue"></font><font color="blue"></font>统计结果如下：</span></td>
                            </tr>
                            <tr>
                            <td align="center" bgcolor="#f4f4f4" height="30">
                                使用充值卡数</td>
                            <td align="left" bgcolor="#ffffff" height="25">
                                &nbsp;<span id="Label6" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumusedcard . '</span>
                                张</td>
                            <td align="center" bgcolor="#f4f4f4" height="25">
                                充值金额</td>
                            <td bgcolor="#ffffff">
                                &nbsp;
                                <span id="Label7" class="txtalignRight" style="display:inline-block;width:100px;">' . $sumusedmoney . '</span>
                                元</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="height: 25px" align="center" bgcolor="#ffffff">
                                </td>
                            </tr>
                          </tbody>';
            }
            $this->ajaxReturn($data, 'json');
        }
    }

}
