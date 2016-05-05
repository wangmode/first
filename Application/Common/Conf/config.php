<?php
// +----------------------------------------------------------------------
// | UniSoft [ WE Can Do Everything ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.wanghome.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 汪之厌胃<WangMode@163.com>
// +----------------------------------------------------------------------
return array (
		// '配置项'=>'配置值'
		'DB_TYPE' => 'mysql',
		'DB_HOST' => 'localhost',
		'DB_NAME' => 'p2p',
		'DB_USER' => 'root',
		'DB_PWD' => 'root',
		'DB_PORT' => 3306,
		'DB_PREFIX' => 'thinkoao_',
		'TMPL_ACTION_ERROR'     =>  THINK_PATH.'View/Public/error.html', // 默认错误跳转对应的模板文件
    	'TMPL_ACTION_SUCCESS'   =>  THINK_PATH.'View/Public/success.html', // 默认成功跳转对应的模板文件
    	'TMPL_EXCEPTION_FILE'   =>  THINK_PATH.'View/Public/exception.html',// 异常页面的模板文件
);
