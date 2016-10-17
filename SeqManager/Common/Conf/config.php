<?php
return array(
    //页面调试开关
    //'SHOW_PAGE_TRACE' => true,
    
    //URL模式
    'URL_MODEL'=>2,

	//'配置项'=>'配置值'
	//PDO连接方式是默认的，已经无法设置了。http://www.kancloud.cn/manual/thinkphp/1731
    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'think', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PARAMS' =>  array(), // 数据库连接参数
    //'DB_PREFIX' => 'seq_', // 数据库表前缀 
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    
    //文件保存地址
    //'WJL_FILE_ROOT_PATH'=>'./Public/',
    //'WJL_FILE_SAVE_PATH'=>'Uploads/',
);