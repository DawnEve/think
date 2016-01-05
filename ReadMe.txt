

2015-12-23 23:07:10
m主要对数据库操作，也多用于处理接口，
c控制器，控制逻辑，将v返回的数据做逻辑判断，去调用m


MySql手册速查：http://c.biancheng.net/cpp/html/1456.html


--------------------------------
11:54 2015/12/24
开始学习tp手册：

官方文档：http://document.thinkphp.cn/manual_3_2.html
看云文档：http://www.kancloud.cn/manual/thinkphp/1682
===========================

快速入门：http://www.kancloud.cn/thinkphp/thinkphp_quickstart

===========================
基础
===========================
1.目录结构：
	新知识点：
		|- 命名空间。	基于命名空间的自动加载类如何实现？
		|- 函数引用传参&。	common下的函数
		|- 那些地方区分大小写？配置文件都被thinkPHP转为小写
		|- 4种URL模式。
		|- 模板引擎标签库如何实现？
		|- 语言包是一些常见错误的提醒。怎么灵活配置？
	
# 目录结构
	├─Library/目录下有22个class文件。都是namespace Think;
		下有12个文件夹。都是namespace Think;	

		namespace Think\Cache\Driver;
		use Think\Cache;
	
	├─Library/Behavior目录下有18个行为类。
	├─Library/Org目录下有2个文件夹：Net和Util
	├─Library/Vendor    第三方类库目录。其中smarty。
	
	├─Mode 框架应用模式目录 4个文件，3个文件夹。
		    // 配置文件这么合并的，后者覆盖前者：
			'config'    =>  array(
				THINK_PATH.'Conf/convention.php',   // 系统惯例配置
				CONF_PATH.'config'.CONF_EXT,      // 应用公共配置
			),

	 ├─Tpl 系统模板目录

# 入口文件定义
	新知识点：
		|- 模版缓存怎么生成？
		|- 多层的MVC机制是什么？
		
	自动加载类（没看懂）：think.class.php的148行：public static function autoload($class)
	
	-----------------------------
	>>npp的目录树预览插件：
	是用了explorer这个插件，下载地址:http://sourceforge.net/projects/npp-plugins/files/
	-----------------------------

# 控制器
	新知识点：
	|- Think/Controler下的$this->view是什么？
		call_user_func(array(&$o, $method));是什么意思？
		
	控制器类的命名方式是：控制器名（驼峰法，首字母大写）+Controller

# 命名规范
http://www.kancloud.cn/manual/thinkphp/1687

	建议：
		遵循框架的命名规范和目录规范；
		开发过程中尽量开启调试模式，及早发现问题；
		多看看日志文件，查找隐患问题；
			--日志文件的位置：F:\xampp\htdocs\think\Runtime\Logs\Home
		养成使用I函数获取输入变量的好习惯；
		更新或者环境改变后遇到问题首要问题是清空Runtime目录；

		F:\xampp\htdocs\think\Apps\myClass\curl函数

		
		
===========================
配置
===========================
# 多种配置
	|- 怎么用数组存取的配置文件呢？
	
	支持惯例配置、公共配置、模块配置、调试配置和动态配置。
	在ThinkPHP中，一般来说应用的配置文件是自动加载的，加载的顺序是：
		惯例配置->应用配置->模式配置->调试配置->状态配置->模块配置->扩展配置->动态配置

# 动态配置
	仅对当前读取有效。


===========================
架构
===========================
# 模块化设计
	一个完整的ThinkPHP应用基于模块/控制器/操作设计，并且，如果有需要的话，可以支持多入口文件和多级控制器。

	模块化设计的思想下面模块是最重要的部分，模块其实是一个包含配置文件、函数文件和MVC文件（目录）的集合。


	// 绑定Admin模块到当前入口文件================????????这是啥意思？
	define('BIND_MODULE','Admin');

	// 定义应用目录
	define('APP_PATH','./Apps/');

	//http://serverName/index.php/模块/控制器/操作

# URL模式
	|- .htaccess文件里面的重写规则？

	http://tp.dawneve.cc/home/user/login/var/value

# 多层MVC
http://www.kancloud.cn/manual/thinkphp/1698
	默认的模型层是Model，我们也可以更改设置，例如
	对模型层的分层划分是很灵活的，开发人员可以根据项目的需要自由定义和增加模型分层，

	视图（View）层：
		-- 视图层由模板和模板引擎组成，在模板中可以直接使用PHP代码
		-- 默认的视图层是View目录，我们可以调整设置如下：
			'DEFAULT_V_LAYER'       =>  'Mobile', // 默认的视图层名称更改为Mobile
			视图的位置：
				UserController->read
				模板存在:./Apps/Home/View/User/read.html

	控制器（Controller）层
		访问控制器 Home/Controller/UserController.class.php 定义如下：
		
		事件控制器 Home/Event/UserEvent.class.php 定义如下：
		而 UserEvent负责内部的事件响应，并且只能在内部调用：
		http://www.kancloud.cn/manual/thinkphp/1698
			Home\Event\UserEvent Object
				//实例化一个UserEvent对象。只能内部调用。
				$a=A('User','Event');
				$a->hi();
				echo '<pre>';
				print_r($a);
				
		用户只需要定义视图，在没有C的情况下也能自动识别。??????
			http://tp.dawneve.cc/index.php?c=blog&a=list		
				
# CBD模式
	ThinkPHP引入了全新的CBD（核心Core+行为Behavior+驱动Driver）架构模式
	
	Driver（驱动）：在新版的扩展里面，已经取消了引擎扩展和模式扩展，改成配置不同的应用模式即可。
	Behavior（行为）：
		除了这些系统内置标签之外，开发人员还可以在应用中添加自己的应用标签，在任何需要拦截的位置添加如下代码即可：
		而标签位置类似于AOP概念中的“切面”，行为都是围绕这个“切面”来进行编程。

		核心行为： 核心行为位于 ThinkPHP/Behavior/ 目录下面
		行为定义：



	//-----------------------------------
	call_user_func(array(&$o, $method));
	http://tieba.baidu.com/p/4231187056?pid=81178002953
	//-----------------------------------
	写入文件时怎么设置编码格式？
	//$fp = @fopen("Log.html", "w"); //记录捕获到的页面源码
	$fp = @fopen("Log.html", "w, ccs=<utf-8>");//保持utf-8格式
	
	fwrite($fp,'some text here'); 
	fclose($fp);
	//-----------------------------------

===========================
路由
===========================
# 路由规则

1.去掉index.php
	需要使用.htaccess文件。
	
2.去掉模块名：
原来：http://tp.dawneve.cc/Home/news/year
希望：http://tp.dawneve.cc/news/year
在系统惯例设置，改两处修改：
	'MODULE_ALLOW_LIST'      =>  array('Home','Admin'),//允许的模块，加上这一句和默认模块才能访问。
	'DEFAULT_MODULE'        =>  'Home',  // 默认模块


3.设置静态路由：
	http://tp.dawneve.cc/u
	
	//router config
	'URL_ROUTER_ON'=>true,
	'URL_ROUTE_RULES'=>array(
		'u'=>'user/index',
	}

	在视图中常量：{$Think.get.id}

	路由规则：'news/:year/:month/:day' => array('News/archive', 'status=1'),
	url: http://tp.dawneve.cc/news/2015/12/20
	视图中：{$Think.get.year}年{$Think.get.month}月{$Think.get.day}日


	静态路由：http://tp.dawneve.cc/news/top.shtml
	'URL_MAP_RULES'=>array(
		'news/top' => 'news/archive?type=top',
		//静态路由定义不受URL后缀影响。静态路由是完全匹配。
	),


	
===========================
视图
===========================
ThinkPHP中的视图主要就是指模板文件和模板引擎

