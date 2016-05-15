<?php
// +----------------------------------------------------------------------
// | 系统公共函数库
// +----------------------------------------------------------------------
// | foreveryoung （永远年轻，永远热泪盈眶）
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://foreveryoung.xin All rights reserved.
// +----------------------------------------------------------------------
// | Author: WangMode <WangMode@163.cn>
// +----------------------------------------------------------------------

//Unisoft常量定义
const UniSoft_CACHE_MODEL ='Area';
//生成密码
function creatpwd($pwd, $str = ''){
  if(!$str){$str = randStr;}
  $password = md5($pwd.$str);
  return $password;
}

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 */
function is_login($admin = '1'){
    $loginarr=array('member_info','admin_info');
    $authname = $loginarr[$admin];
    $user = session($authname);
    if (empty($user)) {return 0;} else {
        return $user[$authname . '_auth_sign'] == data_auth_sign($user) ? $user['id'] : 0;
    }
}

/**
 * 生成随机字符串
 * @return String
 */
function randStr($length = 6,$chars = 'abcdefghijkmnpqrstuvwxyz123456789'){$randStr = str_shuffle($chars.$chars);return substr($randStr, 0, $length);}



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
     function lists ($model,$where=array(),$order='',$base = '',$field=true,$pagesize='',$return='list',$pageconfig='',$pagetype=''){
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



    /**
* 字符串转换为数组 用于 tag
*/
function strtoarray($str,$type='key'){
    if(is_array($str))return $str;
    if(empty($str))return false;
    $array=array();$typekey='key';
    if(str_exists($str,'typeid_'))
	{
		$typeid=floor(strtr($str,array('typeid_'=>'','temp_'=>'')));
        if(str_exists($str,'temp_')){$type='temp';}
        if($typeid)$array=gettypeson($typeid,$type);
	}
    if(!$array){
        $str=str_replace(PHP_EOL,',',$str);
        $strarr=array_map('trim',explode(',', $str));
        $array =array_values(array_filter($strarr));
    }
    foreach ($array as $k=> $v) {
        if (strpos($v, '|')) {$varr = explode('|', $v);
            $return[$varr[0]] = str_exists($varr[1],'LAN_')?L(str_replace('LAN_','',$varr[1])):$varr[1];
        }else{
           if(strpos($v,':')){$varr = explode(':', $v);
                $return[$varr[0]] = str_exists($varr[1],'LAN_')?L(str_replace('LAN_','',$varr[1])):$varr[1];
           }else{$arrkey=$typekey=='key'?$k:$v;
                $return[$arrkey] =str_exists($v,'LAN_')?L(str_replace('LAN_','',$v)):$v;}
       }
    }return $return;
}


/**
 * 调用系统的API接口方法（静态方法）
 * api('User/getName','id=5'); 调用公共模块的User接口的getName方法
 * api('Admin/User/getName','id=5');  调用Admin模块的User接口
 * @param  string  $name 格式 [模块名]/接口名/方法名
 * @param  array|string  $vars 参数
 */
function api($name, $vars = array()){
    $array = explode('/', $name);
    $method = array_pop($array);
    $classname = array_pop($array);
    $module = $array ? array_pop($array) : 'Common';
    $callback = $module . '\\Api\\' . $classname . 'Api::'.$method;
    if (is_string($vars)) {parse_str($vars, $vars);}
    return call_user_func_array($callback, $vars);
}

/**
 * 查询字符是否存在于某字符串
 *
 * @param $haystack 字符串
 * @param $needle 要查找的字符
 * @return bool
 */
function str_exists($haystack, $needle){return !(strpos($haystack, $needle) === FALSE);}


/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 */
function data_auth_sign($data){
    //数据类型检测
    if (!is_array($data)) {$data = (array )$data;}
    unset($data['admin_info_auth_sign'],$data['member_info_auth_sign']);
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

//获取缓存
function getcache($name=''){
    if(empty($name))return false;
    $cachedata=F($name);
    if($cachedata)return $cachedata;
    else{return savecache($name,1);}
}//保存缓存
function savecache($name = '', $type = ''){    
	$cache_model=explode(',',UniSoft_CACHE_MODEL);//后台缓存模型
	if(!in_array($name,$cache_model))return false;
    if(!defined('RUNTIME_FILE'))define('RUNTIME_FILE',APP_PATH.'Runtime/');    
    if(file_exists(RUNTIME_FILE.'common~runtime.php'))unlink(RUNTIME_FILE.'common~runtime.php');
    $Model = M($name);$list=$data= array();
    $allpas=array('BorrowCategory','ArticleCat');    
    if ($name == 'User')
	{
		$list = $Model->where("status=1")->field(true)->select();		
		foreach ($list as $v){unset($v['password']);$data[$v['id']] = $v;}F($name, $data);
	}else if (in_array($name,array('Payment','Oauth')))
	{
		$list = $Model->where("status=1")->field(true)->select();
		foreach ($list as $v){$data[$v['code']] = $v;}F($name, $data);
	}else if ($name == 'AuthRule')
	{
       $list = $Model->field(true)->order('sort,id desc')->select();
       foreach ($list as $key => $val){$data[$val['id']] = $val;}F($name, $data);
       $AdminGroup = M('AuthGroup')->where('status=1')->field('id,rules')->select();
       foreach ($AdminGroup as $groupValue) {
				$ruleCache = F("admin_rule_".$groupValue['id']."");
				if (empty($ruleCache)){if(empty($groupValue['rules']))$groupValue['rules']=0;
				$ruleData = $Model->where("id IN(".$groupValue['rules'].")  AND status=1")->order('sort,id desc')->getField('id,name,title,show_status,type,condition,pid,sort');
				F("admin_rule_".$groupValue['id'],$ruleData);
                }unset($ruleCache);
	   }unset($AdminGroup);
	}
    else
	{
       $allfields=$Model->getDbFields();
	   $pkid = $Model->getPk();
       $order='';
       if(in_array('sort',$allfields))$order.='sort,';
       $order.=$name=="Area"?$pkid:$pkid.' desc';
	   $list = $Model->field($allfields)->order($order)->select();
	   foreach ($list as $key => $val)
	   {
	   	   $data[$val[$pkid]] = $val;
           if(in_array($name,$allpas)){
            $data[$val[$pkid]]['allparent']=getallparent($val[$pkid],'',$name);
            $data[$val[$pkid]]['allson']=getallson($val[$pkid],$name);
           }
	   }F($name, $data);
	}
    if(!empty($type)){unset($list);return $data;}
	else{unset($list,$data);return true;}
}
