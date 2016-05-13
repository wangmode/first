<?php
// +----------------------------------------------------------------------
// | 基础控制器
// +----------------------------------------------------------------------
// | ThinkOAO （Online And Offline）
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.thinkoao.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaogg <xiaogg@sina.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\FirstController;
class BaseController extends FirstController {
	public function _initialize(){
		parent::_initialize ();
		define('UID',is_login());
		$info = M('Admin')->where('id='.UID)->find();
		$this->assign($info);
        if( !UID && !in_array(CONTROLLER_NAME,C('NOT_AUTH_MODULE'))){redirect(__ROOT__.'/index.php?s=/Admin/Login/index.html');}// 还没登录 跳转到登录页面     
	}
	/**
     * 权限检测
     * @param string  $rule    检测的规则
     * @param string  $mode    check模式
     * @return boolean
     */
    final protected function checkRule($rule, $type='', $mode='url'){
        if(IS_ROOT){return true;}static $Auth=null;//超级管理员允许访问任何页面
        if (!$Auth){$Auth=new \Common\Vendor\Auth();}
        if(!$Auth->check($rule,UID,$type,$mode)){return false;}
        return true;
    }
    public function jumpresult($result){
        if($result!==false){$this->success(L('DO_OK'));}else{$this->error(L('DO_ERROR'));}
    }
    public function add() {//公共添加
		$model = D (CONTROLLER_NAME);$pk=ucfirst($model->getPk ());$id = intval(I($model->getPk ()));
		if($id){$do='getBy'.$pk;$vo = $model->$do ( $id );$this->assign ( 'info', $vo );}	
		$this->display ('edit');
	}
	public function insert() {//公共插入
		$model = D (CONTROLLER_NAME);if (false === $model->create ()) {$this->error ( $model->getError () );}
		$id = $model->add();
		if ($id !==false) {
		  if(in_array(CONTROLLER_NAME,$this->cache_model)){savecache(CONTROLLER_NAME);}
			if($_POST['isajax'])$this->assign('dialog','1');
			$jumpUrl = $_POST['forward'] ? $_POST['forward'] : U(CONTROLLER_NAME.'/index');
			$this->assign ( 'jumpUrl',$jumpUrl );
			$this->success (L('ADD_OK'));
		} else {$this->error (L('ADD_ERROR').': '.$model->getDbError());}
	}
	public function edit() {//公共编辑
		$model = D (CONTROLLER_NAME);
		$pk=ucfirst($model->getPk ());
		$id = intval(I($model->getPk ()));
		if(empty($id))   $this->error(L('do_empty'));
		$do='getBy'.$pk;
		$vo = $model->field(true)->$do ($id);
		$this->assign ($vo);$this->assign ('info',$vo);
		$this->display ();
	}
 /**
     * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
     *
     * @param string $model 模型名称,供M函数使用的参数
     * @param array  $data  修改的数据
     * @param array  $where 查询时的where()方法的参数
     * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     */
    public function update ( $model='' ,$data='', $where='1' , $msg='' ){
		if(!$model)$model=CONTROLLER_NAME;$mod=D($model);
		if(!$data)$data=$mod->create();
		$jumpUrl = I('forward') ? I('forward') : U(CONTROLLER_NAME.'/index');
        $id    = array_unique((array)I('id',0));
        $id    = is_array($id) ? implode(',',$id) : $id;
        $where = $where=='1'?array('id' => array('in', $id )):array_merge( array('id' => array('in', $id )),(array)$where);
        $msg   = array_merge( array('success'=>L('edit_ok'), 'error'=>L('edit_error'), 'url'=>$jumpUrl ,'ajax'=>IS_AJAX) , (array)$msg );
        $res=$mod->where($where)->save($data);
        if( $res!==false ) {$this->updateborrow($id);
		  if(in_array(CONTROLLER_NAME,$this->cache_model)){savecache(CONTROLLER_NAME);}
            $this->success($msg['success'],$msg['url'],$msg['ajax']);
        }else{$this->error($msg['error'],$msg['url'],$msg['ajax']);}
    }
	public function view() {//公共查看
		$model = D (CONTROLLER_NAME);
		$pk=ucfirst($model->getPk ());
		$id = intval(I($model->getPk ()));
		if(empty($id))   $this->error(L('do_empty'));
		$do='getBy'.$pk;
		if(!empty($request))$this->assign ('views',serialize($request));
		$vo = $model->field(true)->$do($id);
        $this->assign($vo);
		$this->display ();
	}
	public function index($model='') {//公共首页
		$map=I('param.');if(!$model)$model=CONTROLLER_NAME;
        $list = $this->lists($model,$map);
        $this->assign('list', $list);
        $this->display();
    }
	public function delete(){//公共删除
		$mod=D(CONTROLLER_NAME);
		$id=I('id');        
		if (isset($id) && is_array($id)) {
			$ids = implode(',', $id);
			$result=$mod->delete($ids);
		} else {
			$id = intval($id);
			$result=$mod->delete($id);
		}
		if($result!==false){$this->updateborrow($id);
		  if(in_array(CONTROLLER_NAME,$this->cache_model)){savecache(CONTROLLER_NAME);}
			$this->success(L('DO_OK'));
		}else{$this->error(L('DO_ERROR'));}
	}
	public function status(){//公共状态
		$mod = D(CONTROLLER_NAME);
		$id     = intval(I('id'));
		$type   = trim(I('type'));
		$values = $mod->where('id='.$id)->field($type)->find();
        $data[$type]=($values[$type]+1)%2;
        $res=$mod->where('id='.$id)->save($data);$this->updateborrow($id);
		if(in_array(CONTROLLER_NAME,$this->cache_model)){savecache(CONTROLLER_NAME);}
		$this->ajaxReturn($data[$type]);
	}
    public function sort(){//公共排序
		$model = D (CONTROLLER_NAME);$pk = $model->getPk ();        
		$sorts = I('post.sort');
		if(!is_array($sorts))$this->error(L('PARAM_ERROR'));
		foreach ($sorts as $id=>$sort){
			$model->save(array($pk=>$id,'sort'=>intval($sort)));$this->updateborrow($id);
		}
		if(in_array(CONTROLLER_NAME,$this->cache_model)) savecache(CONTROLLER_NAME);
		$jumpUrl = I('forward')?I('forward'):U(CONTROLLER_NAME.'/index');        
		$this->assign("jumpUrl",$jumpUrl);
		$this->success(L('do_ok'));
	}

}
?>
