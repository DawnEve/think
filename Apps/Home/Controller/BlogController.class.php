<?php
namespace Home\Controller;
use Think\Controller;

class BlogController extends Controller {
    public function index(){
		echo 'BlogController->index';
		
		//D('User'); //实例化UserModel
		//D('User','Logic'); //实例化UserLogic
	}
	public function test(){
	   //echo 'user->test method.';
	   echo U("Blog/index") . '<hr>';
	   
       // redirect(U("Blog/index"),3,'3s后跳转到首页' );
	   $this->redirect("index",array('id'=>2),3,'3s后跳转到首页' );
	   
	   //$this->display();
	}
	
	//url生成
	function login(){
		//C('URL_MODEL', 0);
		echo C('URL_MODEL') . ' - ';
	    echo U('User/login');
	    //0 - /index.php?m=&c=user&a=login
	    //1 - /index.php/user/login.html
	    //2 - /user/login.html
	    //3 - /index.php?s=/user/login.html
	}
	
	//页面模板
	function page(){
	   $this->display();
	}
	
	function man(){
	   //echo '123';
	   R('Admin/User/number');
	}
	
	//实例化Event控制器
	function getData(){
	   $u=A('User','Event');
	   $u->hi();
	}
	
	function data(){
	   //$t=new \Home\Model\BlogModel();//Home\Model\BlogModel  $t->output()
	   //$t=M();//Think\Model
	   //$t=M('Blog');//Think\Model
	   //$t=D();//Think\Model
	   $t=D('Blog');//Home\Model\BlogModel  $t->output()
	   dump($t);
	}
	
	//自我验证
	function auth(){
		echo '123';
	    B('Home\Behavior\AuthCheck');
	}
}