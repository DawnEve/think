<?php
namespace Admin\Controller;
use Think\Controller;

class ManagerController extends Controller {
    public function index(){
        //首页显示主控界面
        
        if($user = session('user')){
            //echo ' | <a href="'.U('logout').'">logout</a>';
            dump($user);
            $this->display();
        }else{
            redirect('login');
        }
        
    }
    
    //登录页面
    function login(){
    	//1.如果已经登录，则跳转。
       	$user=session('user');
       	if(!empty($user)){
       	    redirect('index',1);
       	}else{
    	   //2.否则看是否是登录post，如果是，则验证，
       		if(!empty($_POST)){
       		   $usr=I('username');
               $psw=I('password');
               session('user',array($usr, $psw));
               //echo '登录成功';
               redirect('index');
       		}else{
       	   //3.否则显示登录页面
       		   $this->display();
       		}
       	}
    	//echo '已经登录';
    }
    
    //退出
    function logout(){
        session(null);
        redirect('login',1,'退出成功！');
    }

    
    //空方法
    function _empty(){
        echo 'Invalid!';
    }
}
