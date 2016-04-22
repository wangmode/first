<?php
/*
 * return array(
 * //'配置项'=>'配置值'
 * //database config
 * 'DB_TYPE' => 'mysql',
 * 'DB_HOST' => 'localhost',
 * 'DB_NAME' => 'shop_maker_h5',
 * 'DB_USER' => 'root',
 * 'DB_PWD' => '123',
 * 'DB_PORT' => 3306,
 * 'DB_PREFIX' => 'anl_'
 * );
 */
return array (
		// '配置项'=>'配置值'
		// database config
		'DB_TYPE' => 'mysql',
		//'DB_HOST' => '106.3.38.6',
		 'DB_HOST' => 'localhost',
		'DB_NAME' => 'p2p',
		'DB_USER' => 'root',
		//'DB_PWD' => 'bq4DC10Q',
		 'DB_PWD' => 'root',
		'DB_PORT' => 3306,
		'DB_PREFIX' => 'thinkoao_',
		'email' => array (
				'SMTP_HOST' => 'smtp.sina.cn', // SMTP服务器
				'SMTP_PORT' => '465', // SMTP服务器端口
				'SMTP_USER' => '13311176096@sina.cn', // SMTP服务器用户名
				'SMTP_PASS' => 'jsyh123654', // SMTP服务器密码
				'FROM_EMAIL' => '13311176096@sina.cn', // 发件人EMAIL
				'FROM_NAME' => '京尚易和', // 发件人名称
				'REPLY_EMAIL' => '', // 回复EMAIL（留空则为发件人EMAIL）
				'REPLY_NAME' => ''
		) // 回复名称（留空则为发件人名称）
		,
		'max_compile_num'=>'3',//最多同时编译app数
		'max_compile_time_limit'=>'5',
		'path' => array (//编译时的请求路径和apk/ipa存放路径
				'android_compile_host' => '192.168.1.11',
				'android_compile_port' => '8011',
				'android_compile_url' => '/index.php/Admin/MakeApp',
				'android_bin_path' => 'http://192.168.1.11:8011/Public/bin/',
				'android_upload' => 'http://www.appk6.com/Load/RetrieveApk',
				'ios_compile_host'=>'192.168.1.12',
				'ios_compile_port'=>'2560',
				'ios_upload'=>'http://www.appk6.com/Load/RetrieveIpa',
				'store_path'=>'./Public/bin/'
		),
		'SRCpath' => '/Public/Anole_Admin/public_html/Uploads/',
		'AgentSRCpath' => '/Public/Anole_Admin/public_html/Uploads/sources/Agents/',
		'normal' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ`1234567890~!@#$%^&*()_+{}[]:"<>?/|',
		// 支付宝配置
		// 支付宝配置
		'alipay_config' => array (
				// 合作身份者id，以2088开头的16位纯数字
				'partner' => '2088411391486456',
				// 安全检验码，以数字和字母组成的32位字符
				'key' => 'bn3v0rz2o00xewbj87msldj08sa43xux', // 这里是你在成功申请支付宝接口后获取到的Key
				                                           // 签名方式 不需修改
				'sign_type' => strtoupper ( 'MD5' ),
				'input_charset' => strtolower ( 'utf-8' ),
				// ca证书路径地址，用于curl中ssl校验
				// 请保证cacert.pem文件在当前文件夹目录中
				'cacert' => getcwd () . '\core\Library\Vendor\Alipay\cacert.pem',
				// 访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
				'transport' => 'http',
				// 收款支付宝账号，一般情况下收款账号就是签约账号
				'seller_email' => 'a76096@163.com'
		),
		'alipay' => array (
				// 这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
				'seller_email' => 'a76096@163.com',
				// 这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
				'notify_url' => 'http://'.$_SERVER['SERVER_NAME'].'/Alipay/notifyurl',
				// 这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
				'return_url' => 'http://'.$_SERVER['SERVER_NAME'].'?s=Alipay/returnurl',
				// 支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
				'successpage' => 'Alipay/index?ordtype=payed',
				// 支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
				'errorpage' => 'Alipay/index?ordtype=unpay'
		),
		'max_compile_limit'=>3//每天最多生成次数限制
);
