<?php
namespace Home\Controller;
use Think\Controller;
class NewsController extends Controller {
    public function index(){
		echo 'news->index(): ';
		echo time();
		dump( $_GET);
		
	}
	
	function archive(){
		echo 'news->archive(): ';
		dump( $_GET);
		
		$this->show();
	}

	function read($id){
		echo 'news->read(): ';
		echo $id;//http://tp.dawneve.cc/news/22   22
		dump( $_GET);
	}
	
	function scope(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=D('news');
		//MyDump( $user->scope()->select() );//SELECT * FROM `think_news` [ RunTime:0.0010s ]
		//MyDump( $user->scope('sql1')->select() );//SELECT * FROM `think_news` WHERE ( id>1 ) [ RunTime:0.0140s ]
		MyDump( $user->scope('sql2')->select() );//SELECT * FROM `think_news` ORDER BY `add_time` DESC LIMIT 2 [ RunTime:0.0440s ]
	}
	
	
}

//http://tp.dawneve.cc/index.php/home/User/index

/*
http://tp.dawneve.cc/news/scope



//使用域名动态解析后
http://tp.dawneve.cc/index.php?c=user
http://tp.dawneve.cc/home/user/login/var/value

*/
