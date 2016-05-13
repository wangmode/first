<?php
namespace Admin\Controller;
use Think\Controller;
class MemberController extends BaseController {
    public function index(){
      $member = M('member')->order('reg_time desc')->select();
      $this->assign('list',$member);
      $this->display();
	}
 public function add(){
     if(IS_POST){
         $member_mod = M('Member');
         $postdata=I('post.');
         if (!isset($postdata['username']) || ($postdata['username'] == '')) {
             $this->error('用户名不能为空');
         }
         if ($postdata['password'] != $postdata['repassword']) {
             $this->error('两次输入的密码不相同');
         }
         $result = $member_mod->where("username='" . $postdata['username'] . "'")->count();
         if ($result) {
             $this->error('会员' . $postdata['username'] . '已经存在');
         }
         unset($postdata['repassword']);
         $postdata['salt'] = randStr();
         $postdata['password'] = creatpwd($_POST['password'], 'young'.$postdata['salt']);
         $postdata['reg_time'] = $postdata['last_login'] = time();
         $postdata['reg_ip'] = $postdata['last_ip'] = get_client_ip(1);
         $member_mod->create($postdata);
         $result = $member_mod->add();
         unset($postdata);
         if ($result) {
             $this->success('添加成功', '', '', 'add');
         } else {
             $this->error('添加失败');
         }
     }else{
         $this->display('edit');
     }
 }
  public function edit(){
    $id = I('id');
    $member = D('Member');
    if(IS_POST){
      $this->error('两次密码输入不一致');
      $postdata = I('post.');
      $count = $member->where('id!=' . $id . ' and username=' . $postdata['username'])->count();
      if($count>0){
        $this->error('用户名已经存在！');
        if($postdata['password']){
          if($postdata['password']!==$postdata['repassword']);{
            $this->error('两次密码输入不一致');
          }
          $salt = $member->where('id='.$id)->getField('salt');
          $postdata['password'] = creatpwd($postdata['password'],'young'.$salt);
        }else{
          unset($postdata['password']);
        }
      }

  }else{
        $info = M('Member')->where('id='.$id)->find();
  }
    $this->assign($info);
    $this->display();
  }
}
