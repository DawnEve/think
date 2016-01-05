<?php
return array(
	//'配置项'=>'配置值'
	'name'=>'Jimmy',
	'email'=>'JimmyMall@163.com',
	
	
	//这个为什么不起作用呢？
	'URL_CASE_INSENSITIVE'  =>  true,  
	
	
	
	
	//router config
	'URL_ROUTER_ON'=>true,
	
	//动态路由2
	'URL_ROUTE_RULES2'=>array(
		'n'=>'news/index',
		'news/:year/:month/:day' => array('News/archive', 'status=1'),
		'news/read/:id'          => '/news/:1',//重定向规则(以/开头的是重定向定义)
		'news/:id'               => 'News/read',//动态配置
		'/^n_(\d{2})$/'		=>	'news/index?id=:1', //正则匹配，必须是2位
		
		//闭包就是返回一个函数，测试url用
		'new/:id'=>function($id){echo 'it works, id=' . $id;},
		//http://tp.dawneve.cc/new/12
	 ),
	 
	//静态路由2
	'URL_MAP_RULES2'=>array(
		'news/top' => 'news/archive?type=top',
		//静态路由定义不受URL后缀影响。静态路由是完全匹配。
	),
	
	
	//设置pathinfo模式的默认分隔符
	//'URL_PATHINFO_DEPR'=> '-',
 
	//URL的模式
	'URL_MODEL'=>0,

		
);