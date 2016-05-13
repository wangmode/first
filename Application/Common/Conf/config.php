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
		'TAGLIB_LOAD'           =>  true, // 是否使用内置标签库之外的其它标签库，默认自动检测
   		'TAGLIB_BUILD_IN'       =>  'cx', // 内置标签库名称(标签使用不必指定标签库名称),以逗号分隔
		'APP_AUTOLOAD_PATH'         =>'@.TagLib', 注意
);
