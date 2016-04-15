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

//生成密码
function creatpwd($pwd, $str = ''){
  if(!$str){$str = randStr;}
  $password = md5($pwd.$str);
  return $password;
}

/**
 * 生成随机字符串
 * @return String
 */
function randStr($length = 6,$chars = 'abcdefghijkmnpqrstuvwxyz123456789'){$randStr = str_shuffle($chars.$chars);return substr($randStr, 0, $length);}
