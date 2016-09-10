<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义运行时目录
define('RUNTIME_PATH','./Runtime/');

// 绑定Admin模块到当前入口文件================?//默认绑定的是Home模块。
//define('BIND_MODULE','Admin');
//绑定模块名到入口文件
//define('BIND_MODULE', 'GK');//在application文件夹下建立admin模块


// 定义应用目录
//define('APP_PATH','./Apps/');
define('APP_PATH','./'); //当前文件夹下创建应用

//设置字符集，防止乱码
header("Content-type: text/html; charset=utf-8");



//定义一些系统常量,模板中使用
$site_url='http://'.$_SERVER['SERVER_NAME'].'/';//string(22) "http://seq.dawneve.cc/"
define('CSS_URL',$site_url . 'Public/Admin/css/');
define('IMG_URL',$site_url . 'Public/Admin/img/');
 







// 引入ThinkPHP入口文件
require '../ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单