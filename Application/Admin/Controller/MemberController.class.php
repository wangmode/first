<?php
namespace Admin\Controller;
use Think\Controller;
class MemberController extends Controller {
    public function index(){
      $member = M('member')->select();
      $this->assign('list',$member);
      $this->display();
	}

  public function edit(){
    $id = I('id');

    $member = D('Member');
    if(IS_POST){
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

    }



    // if ($id) {
    //   $info = M('Member')->where('uid='.$id)->find();
    // }
    // $this->assign($info);
    $this->display();
  }
}
