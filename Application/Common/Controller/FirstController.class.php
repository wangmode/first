<?php
// +----------------------------------------------------------------------
// | 公共基础控制器
// +----------------------------------------------------------------------
// | ThinkOAO （Online And Offline）
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.thinkoao.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaogg <xiaogg@sina.cn>
// +----------------------------------------------------------------------
namespace Common\Controller;
use Think\Controller;
class FirstController extends Controller {
	public function _initialize(){
		header("content-Type: text/html; charset=utf-8");
		$this->config=S('DB_CONFIG_DATA');/* 读取数据库中的配置 */
		if(empty($this->config)){$this->config = api('Config/lists');S('DB_CONFIG_DATA',$this->config);}C($this->config); //添加配置
		$this->TEMPLATE_PATH=__ROOT__.substr(APP_PATH,1).C('DEFAULT_MODULE').'/'.C('DEFAULT_V_LAYER').'/';
	}


    /**
     * 通用分页列表数据集获取方法
     *
     *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
     *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model   模型名或模型实例
     * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     *
     * @param array        $base    基本的查询条件
     * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
     * @return array|false
     * 返回数据集
     */
    public function lists ($model,$where=array(),$order='',$base = '',$field=true,$pagesize='',$return='list',$pageconfig='',$pagetype=''){
        $options    =   array();
        $REQUEST    =   (array)I('request.');
        if(is_string($model)){$model  =   M($model);}
        $OPT        =   new \ReflectionProperty($model,'options');
        $OPT->setAccessible(true);
        $pk         =   $model->getPk();
        if($order===null){//order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif( $order==='' && empty($options['order']) && !empty($pk) ){
            $options['order'] = $pk.' desc';
        }elseif($order){$options['order'] = $order;}
        unset($REQUEST['_order'],$REQUEST['_field']);
        $options['where'] = array_filter(array_merge( (array)$base,(array)$where ),function($val){
            if($val===''||$val===null){return false;}else{return true;}
        });
        unset($REQUEST['_order'],$REQUEST['_field'],$options['where']['_order'],$options['where']['_field']);
        $pp= C('VAR_PAGE');if(empty($pp))$pp='p';
        if(!empty($options['where'][$pp]))unset($options['where'][$pp]);
        if(!empty($options['where']['__hash__']))unset($options['where']['__hash__']);
        if( empty($options['where'])){unset($options['where']);}
        $options      =   array_merge( (array)$OPT->getValue($model), $options );
        $result['_total']=$total        =   !empty($options['where'])?$model->where($options['where'])->count():$model->count();
        if($pagesize)$listRows = intval($pagesize);
        else{$listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;}
        if($total>=$listRows){
            if(!empty($REQUEST['__hash__']))unset($REQUEST['__hash__']);if(!empty($REQUEST['search']))unset($REQUEST['search']);
        $page = new \Common\Vendor\Page($total, $listRows, $REQUEST);
        if(defined('PAGE_CONFIG') && empty($pageconfig))$pageconfig=PAGE_CONFIG;
        if(empty($pageconfig))$pageconfig='%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%';
        $page->setConfig('theme',$pageconfig);
        if($pagetype==1){$page->prevshow=true;$page->nextshow=true;$page->setConfig('prev',L('PAGE_PREV'));$page->setConfig('next',L('PAGE_NEXT'));}
        $result['_page']=$p =$page->show();$this->assign('_page', $p? $p: '');
        $options['limit'] = $page->firstRow.','.$page->listRows;
        }else{
            $options['limit'] ='0,'.$listRows;$this->assign('_page','');
        }$this->assign('_total',$total);
        $model->setProperty('options',$options);
        $result['list']=$model->alias("OAO__")->field($field)->select();
        return $return?$result[$return]:$result;
    }
}


?>
