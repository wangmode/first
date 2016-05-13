<?php
namespace Admin\Controller;
use Common\Controller\FirstController;
class LoginController extends FirstController {
	public function _initialize(){parent::_initialize ();}
	public function index()
	{
		$admin_mod = M('Admin');
		if (IS_POST) {
			$return=array('status'=>0,'msg'=>'');
			$username = I('post.username');
			$password = I('post.password');
			if (!$username || !$password) {$this->error('用户名或密码不能为空');}

			$map = array();
			$checkmobile=session('checkmobile');
			$map['username'] = $username;
			$map["status"] = array('gt', 0);
			$admin_info = $admin_mod->where($map)->field(true)->find();		//调取管理员信息
			//使用用户名、密码和状态的方式进行认证
			if (empty($admin_info)) {
				$this->error('该账户不存在');
			} else {
				$checkpassword = creatpwd($password, $admin_info['salt']);
				if ($checkpassword != $admin_info['password']) {
					$this->error('密码错误');
				}
				$admin_info['admin_info_auth_sign'] = data_auth_sign($admin_info);
				session('admin_info', $admin_info);
				$uid=$userdata['id'] = $admin_info['id'];
				$userdata['login_count'] = array('exp', 'login_count+1');
				$userdata['last_login_time'] = NOW_TIME;
				$userdata['last_login_ip'] = get_client_ip(1);
				$admin_mod->save($userdata);
				$this->success('登录成功', U('Index/index'));
			}
		}else{
			$this->display();
		}

	}
	//退出登录
	public function logout()
	{
		$admin_info = session('admin_info');
		if (isset($admin_info)) {
			session('admin_info', null);
			$this->success('退出登录成功！', U('Login/index'));
		} else {
			$this->error('已经退出登录！');
		}
	}
}
