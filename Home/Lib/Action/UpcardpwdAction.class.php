<?php

/* * ************************************************************************************
 * **  UpcardpwdAction.class.php
 * **  说明：修改账号卡密码
 * **  日期：2014-04-12
 * *********************************************************************************** */

//CountcarddataAction 控制类继承统一入口加载类 CommonAction
class UpcardpwdAction extends CommonAction {

    function index() {
        #数据统计是统计全部的

        $carddata = $this->getcarddata();

        //$this->assign('carddata',$carddata);
        $this->assign('timer', $this->getTime());
        //$this->display();
    }

    function getcarddata() {
        if (!$this->chk_auth('up_cardpwd')) {
            //跳转到错误页面
            $this->assign('message', '您暂无修改账号密码权限');
            $this->error();
        }

        $carddata = array();
        $pagesize = 17;
        import('ORG.Util.Page'); // 导入分页类
        $card_model = M('cards');
        if ($_SESSION['power'] == 1) {
            $count = $card_model->count(); // 查询满足要求的总记录数
            $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('header', '张卡');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('theme', '共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');
            $show = $Page->show(); // 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性

            $list = $card_model->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();

            $list = $this->getaccountloginname($list);
            $list = $this->formatfield($list);
            $this->assign('list', $list); // 赋值数据集
            $this->assign('page', $show); // 赋值分页输出
            $this->display(); // 输出模板
        }
        //一级代理的卡   
        else if ($_SESSION['power'] == 2) {

            $data['ownid'] = $_SESSION['accountid'];
            $count = $card_model->where($data)->count(); // 查询满足要求的总记录数
            $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('header', '张卡');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('theme', '共查询出%totalRow% %header%   第%nowPage%页 | 共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end%   %downPage%');
            $show = $Page->show(); // 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性

            $list = $card_model->where($data)->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
            $list = $this->getaccountloginname($list);
            $list = $this->formatfield($list);
            $this->assign('list', $list); // 赋值数据集
            $this->assign('page', $show); // 赋值分页输出
            $this->display(); // 输出模板
        }
        //二级代理的卡
        else {
            $ownid = $_SESSION['accountid'];
            $data['subownid'] = $ownid;
            $count = $card_model->where($data)->count(); // 查询满足要求的总记录数
            $Page = new Page($count, $pagesize); // 实例化分页类 传入总记录数和每页显示的记录数
            $Page->setConfig('header', '张卡');
            $Page->setConfig('prev', '上一页');
            $Page->setConfig('next', '下一页');
            $Page->setConfig('theme', '共查询出%totalRow% %header%   第%nowPage%页 | 共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end%   %downPage%');
            $show = $Page->show(); // 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性

            $list = $card_model->where($data)->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
            $list = $this->getaccountloginname($list);
            $list = $this->formatfield($list);
            $this->assign('list', $list); // 赋值数据集
            $this->assign('page', $show); // 赋值分页输出
            $this->display(); // 输出模板
        }
    }

    #获取代理商名

    function getaccountloginname($data) {
        $carddata = $data;
        $account_model = M('account');
        $accountdata = $account_model->getfield('id,loginname', true);
        /* echo '<pre>';
          print_r($accountdata);
         */
        foreach ($data as $key => $value) {
            // print_r($value); 

            if ($value['ownid'] != 0) {
                if ($value['subownid'] != 0) {
                    //把ownid赋值为代理商名
                    $carddata[$key]['ownid'] = $accountdata[$value['subownid']];
                } else {
                    $carddata[$key]['ownid'] = $accountdata[$value['ownid']];
                }
            } else {
                $carddata[$key]['ownid'] = $_SESSION['loginname'];
            }
        }
        return $carddata;
    }

    #格式化字符串   如状态  时间处理

    function formatfield($data) {
        $carddata = $data;
        //卡状态修改
        foreach ($data as $key => $pervalue) {

            #卡状态
            switch ($pervalue['status']) {
                case 0:
                    $carddata[$key]['status'] = '未激活';
                    break;
                case 1:
                    $carddata[$key]['status'] = '已激活';
                    break;
                case 2:
                    $carddata[$key]['status'] = '已使用';
                    break;
                default:
                    $carddata[$key]['status'] = '已锁定';
                    break;
            }
            #卡时间注册时间
            $carddata[$key]['createtime'] = date("Y/m/d ", $carddata[$key]['createtime']); //H:i:s
            #开通方式格式化
            switch ($pervalue['openway']) {
                case 1:
                    $carddata[$key]['openway'] = "电话";
                    break;
                case 2:
                    $carddata[$key]['openway'] = "网站";
                    break;
                case 3:
                    $carddata[$key]['openway'] = "微信";
                    break;
                case 4:
                    $carddata[$key]['openway'] = "短信";
                default:
                    $carddata[$key]['openway'] = '';
                    break;
            }
        }

        return $carddata;
    }

    function updatecardpwd() {

        if (!$this->chk_auth('up_cardpwd')) {
            //跳转到错误页面
            $this->assign('message', '您暂无修改账号密码权限');
            $this->error();
        }

        $cardid = $_GET['id'];
        $card_model = M('cards');
        $carddata = $card_model->where('id=' . $cardid)->select();
        $carddata = $this->formatfield($carddata);
        $this->assign('carddata', $carddata);
        $this->assign('timer', $this->getTime());
        $this->display();
    }

    #更新实现

    function updatecard() {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            $data['money'] = $_POST['money'];
            $id = $_POST['cardid'];
            $data['cardpwd'] = $_POST['cardpwd'];
            $data['remark'] = trim($_POST['remark']);
            $data['bindtel'] = $_POST['bindtel'];
            $card_model = M('cards');
            $status = $card_model->where('id=' . $id)->save($data);

            if ($status) {


                $data['status'] = "success";
                $data['message'] = "修改成功";
            } else {
                $data['status'] = "failed";
                $data['message'] = "修改失败";
            }
        }

        $this->ajaxReturn($data, 'json');
    }

}
