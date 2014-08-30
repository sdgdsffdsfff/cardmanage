<?php

/* * ************************************************************************************
 * **  文件：IndexAction.class.php
 * **  说明：后台管理首页显示类
 * **  日期：2012-08-12
 * *********************************************************************************** */

// IndexAction控制类继承统一入口加载类CommonAction
class IndexAction extends CommonAction {

    /**
     * *************************************
     * ** 函数名：index
     * ** 参数：无
     * ** 功能 ：后台管理首页的显示
     * **************************************
     */
    function index() {
        $this->display();
    }

    /**
     * *************************************
     * ** 函数名：top
     * ** 参数：无
     * ** 功能 ：头部的显示
     * **************************************
     */
    function top() {
        $this->display();
    }

    /**
     * *************************************
     * ** 函数名：menu
     * ** 参数：无
     * ** 功能 ：左边菜单栏显示
     * **************************************
     */
    function menu() {
        $user_model = M('users');
        $donate_model = M('donate');
        $userdata = $user_model->where('id=' . $_SESSION ['userid'])->select();
        $sumdonatemoney = $donate_model->where('userid=' . $_SESSION ['userid'])->sum('money');
        $this->assign('sumdonatemoney', $sumdonatemoney);
        $this->assign('userdata', $this->formatfield($userdata));
        $this->display();
    }

    /**
     * *************************************
     * ** 函数名：main
     * ** 参数：无
     * ** 功能 ：主管理框架的显示
     * **************************************
     */
    function main() {
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    /**
     * *************************************
     * ** 函数名：bottom
     * ** 参数：无
     * ** 功能 ：底部界面显示
     * **************************************
     */
    function bottom() {
        $this->assign('date', date('Y-m-d'));
        $this->display();
    }

    // 取代理商id跟名字 查询时候使用
    // 单个时间时间格式化
    function formatfield($data) {
        // print_r($data);
        if (!empty($data [0] ['lastusetime'])) {

            $data [0] ['lastusetime'] = date("Y/m/d ", $data [0] ['lastusetime']);
        }

        if (!empty($data [0] ['registedate'])) {
            $data [0] ['registedate'] = date("Y/m/d ", $data [0] ['registedate']);
        }

        if (!empty($data [0] ['expirydate'])) {
            $data [0] ['expirydate'] = date("Y/m/d", $data [0] ['expirydate']);
        }

        // print_r($data);
        // exit();
        return $data;
    }

    //
}

?>