<?php
// +----------------------------------------------------------------------
// | UniSoft [ WE Can Do Everything ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.wanghome.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 汪之厌胃<WangMode@163.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\FirstController;
class ConfigController extends FirstController {
    public function _initialize() {
        parent::_initialize();
        $this->model = D('Config');
    }
    public function index(){
	$info = M('Config')->select();
	$this->assign($info);
    $this->display();
	}
    //配置列表
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
    //添加配置
	public function add(){
        if(IS_POST){
            $data = $this->model->create();
            if($data){
                if($this->model->add()){
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($this->model->getError());
            }
        }else{
            $grouplist=strtoarray(C('CONFIG_GROUP_LIST'));
            $grouplist[0]='隐藏';
    		$this->assign('TYPE_LIST',strtoarray(C('CONFIG_TYPE_LIST')));
    		$this->assign('GROUP_LIST',$grouplist);
    		$this->assign('info',null);
    		$this->display('edit');
        }
	}
    //编辑配置
    public function edit(){
        if(IS_POST){
            $data = $this->model->create();
            if($data){
                if($this->model->save()){
                    $this->success('更新成功');
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($this->model->getError());
            }
        }else{
            $id = I('id');
            $info = $this->model->field(true)->find($id);
            print_r($info);
            $grouplist=strtoarray(C('CONFIG_GROUP_LIST'));
            $grouplist[0]='隐藏';
    		$this->assign('TYPE_LIST',strtoarray(C('CONFIG_TYPE_LIST')));
    		$this->assign('GROUP_LIST',$grouplist);
    		$this->assign($info);
    		$this->display('edit');
        }
    }

}
