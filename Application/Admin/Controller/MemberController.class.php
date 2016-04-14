<?php
namespace Admin\Controller;
use Think\Controller;
class MemberController extends Controller {
    public function index(){
      $member = M('member')->select();
      $this->assign('list',$member);
      $this->display();
	}
}
