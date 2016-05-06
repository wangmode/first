<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\FirstController;
class SettingController extends FirstController {
    public function _initialize() {
        parent::_initialize();
    }
    public function index(){
	$info = M('Config')->select();
	$this->assign($info);
    $this->display();
	}

	public function config() {
        $list = strtoarray(C('CONFIG_TYPE_LIST'));
        /* 查询条件初始化 */
        $map = array();$getdata=I('param.');
        //$map  = array('status' => 1);
        if(!empty($getdata['group']))$map['group']   =   $getdata['group'];
        if(!empty($getdata['name'])){
        $whereor['name']=array('like','%'.$getdata['name'].'%');
        $whereor['title']=array('like','%'.$getdata['name'].'%');
        $whereor['value']=array('like','%'.$getdata['name'].'%');
        $whereor['extra']=array('like','%'.$getdata['name'].'%');
        $whereor['remark']=array('like','%'.$getdata['name'].'%');
        $whereor['_logic'] = 'or';
        $map['_complex'] = $whereor;
    }
    //$list = $this->lists('Config', $map,'sort,id');
	$list = M('Config')->select();
    $this->assign('group_id',I('get.group',0));
    $this->assign('list', $list);
    $this->assign($getdata);
	$this->display();

	}
	
	public function add(){
		$grouplist=strtoarray(C('CONFIG_GROUP_LIST'));
        $grouplist[0]='隐藏';
		$this->assign('TYPE_LIST',strtoarray(C('CONFIG_TYPE_LIST')));
		$this->assign('GROUP_LIST',$grouplist);
		$this->assign('info',null);
		$this->display();
	}
}
