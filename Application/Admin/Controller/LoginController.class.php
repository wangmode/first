<?php
namespace Admin\Controller;
use Common\Controller\FirstController;
class LoginController extends FirstController {
	public function _initialize(){parent::_initialize ();}
    public function index(){
		
      $this->display();
	}

}
