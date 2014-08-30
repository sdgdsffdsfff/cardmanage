<?php

class ChargeLogAction extends CommonAction {

    function index() {
        $account = M('account');
        $this->assign('account', $account->where('ownid=1')->order('id ASC')->getField('id,loginname'));
        $filllog_model = M('charge_log');
        import('ORG.Util.Page');
        $header = "条操作充值日志";
        $pagesize = 14;
        $log_model = M('charge_log');
        $where = '';
        if ($this->isPost() || isset($_REQUEST['starttime'])) {
            $starttime = strtotime(trim($_REQUEST['starttime']));
            $endtime = strtotime(trim($_REQUEST['endtime']));
            $where = "addtime>=" . $starttime . " and addtime<=" . $endtime;
            if (isset($_REQUEST['accountid']) && !empty($_REQUEST['accountid']))
                $where.=" AND accountid = '{$_REQUEST['accountid']}'";
        }

        $count = $filllog_model->where($where)->count(); // 查询满足要求的总记录数
        $Page = new Page($count, $pagesize); //实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('header', $header);
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('theme', '共查询出%totalRow%%header% 第%nowPage%页|共%totalPage% 页 %upPage%  %first% %prePage% %linkPage% %nextPage% %end% %downPage%');
        $show = $Page->show();       // 分页显示输出
        $logdata = $filllog_model->order('addtime desc')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $logdata = $this->formatfield($logdata);
        $this->assign('logdata', $logdata); //赋值数据集
        $this->assign('page', $show);       //赋值分页输出
        $this->display();
    }

    function querylogbytime() {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest") {

            import('ORG.Util.Page');
            $starttime = strtotime(trim($_POST['starttime']));
            $endtime = strtotime(trim($_POST['endtime']));

            $log_model = M('charge_log');
            $where = "addtime>=" . $starttime . " and addtime<=" . $endtime;
            if (isset($_POST['cardno']) && !empty($_POST['cardno']))
                $where.=" AND cardno like '%{$_POST['cardno']}%'";
            if (isset($_POST['phonenum']) && !empty($_POST['phonenum']))
                $where.=" AND phonenum like '%{$_POST['phonenum']}%'";
            $logdata = $log_model->where($where)->select();
            $logdata = $this->formatfield($logdata);

            if (!empty($logdata)) {
                $logmessage = '
             <tr style="background-color:#E5E5E5;height:15px;">
              <th scope="col">编号</th><th scope="col">用户</th><th scope="col">原金额</th><th scope="col">充值后金额</th><th scope="col">原有效期</th><th scope="col">现有效期</th><th scope="col">充值时间</th><th>手机号</th>
            </tr>';

                foreach ($logdata as $key => $value) {
                    $logmessage = $logmessage . '<tr align="center" style="height:25px;">
             <td style="width:30px;">' . $key . '</td><td style="width:80px;">' . $value['userid'] . '</td><td style="width:180px;">' . $value['oldbanlance'] . '</td><td style="width:100px;">' . $value['newbanlance'] . '</td><td>' . date('Y-m-d H:i:s', $value['oldexpirydate']) . '</td><td class="txtalignRight" align="left">
                 ' . date('Y-m-d H:i:s', $value['newexpirydate']) . '</td><td>' . date('Y-m-d H:i:s', $value['filldate']) . '</td><td>' . $value['phonenum'] . '</td></tr>';
                }
            } else {
                $logmessage = $logmessage . '<tr align="center" style="height:25px;">
                 <td colspan="6">没有查询到数据</td></tr>';
            }
            $data['status'] = "data";
            $data['message'] = $logmessage;
            $this->ajaxreturn($data, 'json');
        }
    }

    function formatfield($data) {

        $userdata = $this->getusername();
        foreach ($data as $key => $perdata) {
            $data[$key]['userid'] = $userdata[$perdata['userid']];
        }
        return $data;
    }

    function getusername() {
        $user_model = M('users');
        $data = $user_model->getfield('id,loginname', true);
        return $data;
    }

}
