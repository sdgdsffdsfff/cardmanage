<?php

/* * ************************************************************************************
 * **  DatastatisticAction.class.php
 * **  说明：账号设置
 * **  日期：2014-04-13
 * *********************************************************************************** */

class AmountAction extends CommonAction {

    public function index() {
        $account = M('account');
        $this->assign('account', $account->where('ownid=1')->order('id ASC')->getField('id,loginname'));
        import('ORG.Util.Page');
        $amount = M('amount_setting');
        $where = array();
        // 搜索
        $accountid = $this->_get('accountid');
        if (!empty($accountid))
            $where ['accountid'] = $accountid;
        $this->assign('accountid', $accountid);
        $count = $amount->field('id')->where($where)->count();
        $page = new Page($count, 15);
        $this->assign('list', $amount->order('id ASC')->where($where)->limit($page->firstRow . ',' . $page->listRows)->select());
        $this->assign('page', $page->show());
        $this->display();
    }

    public function add() {
        $account = M('account');
        $this->assign('account', $account->where('ownid=1')->order('id ASC')->getField('id,loginname'));
        if ($this->isPost()) { // 提交新增
            $amount = M('amount_setting');
            $data = $amount->create();
            $data ['expiry'] = strtotime($data ['expiry']);
            $amount->add($data) ? $this->success('', U('index')) : $this->error();
            exit();
        }
        $this->display();
    }

    public function update() {
        $account = M('account');
        $this->assign('account', $account->where('ownid=1')->order('id ASC')->getField('id,loginname'));
        $id = $this->_get('id');
        $amount = M('amount_setting');
        if ($this->isPost()) { // 提交修改
            $data = $amount->create();
            $data ['expiry'] = strtotime($data ['expiry']);
            $amount->where('id=' . $id)->save($data) ? $this->success('', U('index')) : $this->error();
            exit();
        }
        $detail = $amount->where('id=' . $id)->find();
        $this->assign('detail', $detail);
        $this->display();
        exit();
    }

    public function del() {
        $id = $this->_get('id');
        $amount = M('amount_setting');
        $amount->where('id=' . $id)->delete() ? $this->success('', U('index')) : $this->error();
        exit();
    }

}
