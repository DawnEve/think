<?php
return array(
	//'配置项'=>'配置值'
	
	//关闭字段缓存
	//'DB_FIELDS_CACHE'=>false,

	//页面调试开关
	'SHOW_PAGE_TRACE' => true,
	
	//PDO连接方式是默认的，已经无法设置了。http://www.kancloud.cn/manual/thinkphp/1731
	//数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '127.0.0.1', // 服务器地址
	'DB_NAME'   => 'think', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PARAMS' =>  array(), // 数据库连接参数
	'DB_PREFIX' => 'think_', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
 
 
	
	
	//修改键值对名称：模块m、控制器c、操作a
	//VAR_MODULE只能在应用配置文件中设置,其他参数可以则也可以在模块配置中设置 
	//'VAR_MODULE'=>'mm',
	//'VAR_CONTROLLER'=>'cc',
	//'VAR_ACTION'=>'aa',
);