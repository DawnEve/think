<?php
namespace Admin\Controller;
use Think\Controller;

class ManagerController extends Controller {
    public function index(){
        //首页显示主控界面
        $user = session('user');
        if(!empty($user)){
            //echo ' | <a href="'.U('logout').'">logout</a>';
            //dump($user);
            $this->display();
        }else{
            redirect('login');
        }
    }
    
    //头部
    function head(){
        $this->display('head');
    }
    
    //左侧
    function left(){
        $this->display('left');
    }
    
    //右侧
    function right(){
        $this->display('right');
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
       		   //从Model中验证登录
       		   $name=I('username');
               $psw=I('password');
               $rs=D('Manager')->checkNamePsw($name,$psw);
               if(false === $rs){
               	   $this->error('用户名或密码错误！');
                   //$this->display();
               }else{
	               //写入session
	               session('user',$rs);
	               //跳转到后台首页
	               redirect('index');
               }
       		}else{
       	        //3.否则显示登录页面
       		   $this->display();
       		}
       	}
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
    
    function test(){
        echo md5('123456');
    }
}
