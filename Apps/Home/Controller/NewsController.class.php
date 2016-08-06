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
		MyDump( $user->scope()->select() );//SELECT * FROM `think_news` ORDER BY `add_time` DESC LIMIT 2 [ RunTime:0.0440s ]
	}
	
	function scope2(){
		echo '<hr>namespace:',__namespace__;
		echo '<hr>class:',__class__;
		echo '<hr>method:',__method__;
		
		$user=D('news');
		//MyDump( $user->scope()->select() );//SELECT * FROM `think_news` [ RunTime:0.0010s ]
		//MyDump( $user->scope('sql1')->select() );//SELECT * FROM `think_news` WHERE ( id>1 ) [ RunTime:0.0140s ]
		MyDump( $user->sql2()->select() );//SELECT * FROM `think_news` ORDER BY `add_time` DESC LIMIT 2 [ RunTime:0.0440s ]
	}
	
	//数组形式的数据
	function view1(){
		$data['name']='Dawn';
		$data['email']='JimmyMall@163.com';
		
		$this->assign('user',$data);
		$this->display();
	}
	
   //对象形式的数据
    function view2(){
        $user=new \stdClass();
        $user->name = 'Dawn';
        $user->email = 'JimmyMall@163.com';
        
        $this->assign('user',$user);
        $this->display();
    }
    function view4(){
        $this->assign("staus",0);
        $this->display();
    }
    
    function view5(){
        echo '##5##';
        $this->display();
    }
    
    function view6(){
    	//仅在视图中使用布局
        echo '#6#';
        $this->display();
    }
    
    function view7(){
    	//在控制器中使用布局
        layout(true);
    	//layout('News/base');
        $this->display();
    }
    
    function tag(){
    	$this->assign('name',2);
        $this->display();
    }
    
    function volist2(){
    	$user=M('News');
        $data=$user->select();
        $this->assign('data',$data);
        $this->display();
    }
}


//http://tp.dawneve.cc/index.php/home/User/index

/*
http://tp.dawneve.cc/news/scope



//使用域名动态解析后
http://tp.dawneve.cc/index.php?c=user
http://tp.dawneve.cc/home/user/login/var/value

*/
