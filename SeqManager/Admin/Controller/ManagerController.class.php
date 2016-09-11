<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class ManagerController extends AdminController {
	//首页
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
    	$this->assign('user',session('user'));
        $this->display('head');
    }
    
    //左侧
    function left(){
    	//1.根据角色mg_id获得role_id;
    	$user=session('user');
    	$mg_id=$user['mg_id'];
    	$mg_role_id=$user['mg_role_id'];
    	/*
array(4) {
  ["mg_id"] => string(1) "2"
  ["mg_name"] => string(3) "tom"
  ["mg_time"] => string(1) "0"
  ["mg_role_id"] => string(1) "2"
}
    	 * */
    	//2.由role_id获取role_auth_ids
    	$auth_info=M('Role')->where(array('role_id'=>$mg_role_id))->select();
    	$role_auth_ids=$auth_info[0]['role_auth_ids'];
    	//dump($role_auth_ids);//string(8) "2,3,8,11"
        //3.根据$role_auth_ids查询具体权限
    	//3.5如果是超级管理员(admin)，则获取所有权限
    	if(1==$mg_id){
	        $p_auth_info=M('Auth')->where("auth_level = 0")->select();//顶级权限
	        $c_auth_info=M('Auth')->where("auth_level = 1")->select();//次级权限
    	}else{
	        $p_auth_info=M('Auth')->where("auth_level = 0 and auth_id in ($role_auth_ids)")->select();//顶级权限
	        $c_auth_info=M('Auth')->where("auth_level = 1 and auth_id in ($role_auth_ids)")->select();//次级权限
    	}
    	//dump($p_auth_info);
    	//dump($c_auth_info);
    	/*
 array(4) {
  [0] => array(7) {
    ["auth_id"] => string(1) "2"
    ["auth_name"] => string(12) "订单管理"
    ["auth_pid"] => string(1) "0"
    ["auth_c"] => string(0) ""
    ["auth_a"] => string(0) ""
    ["auth_path"] => string(1) "2"
    ["auth_level"] => string(1) "0"
  }
    	 * */
        
    	//显示模板
    	$this->assign('p_auth_info',$p_auth_info);
    	$this->assign('c_auth_info',$c_auth_info);
    	$this->display('left');
    }
    
    //右侧
    function right(){
    	//$uid = session('user')['mg_id'];
    	//$user=M('manager')->find($uid);
    	//dump($user);
    	dump(session('user'));
    	$this->assign('user',session('user'));
        $this->display('right');
    }
    
    /*
array(4) {
  ["mg_id"] => string(1) "2"
  ["mg_name"] => string(3) "tom"
  ["mg_time"] => string(1) "0"
  ["mg_role_id"] => string(1) "2"
}
     * */
    
    
    
    //登录页面
    function login(){
    	//1.如果已经登录，则跳转。
       	$user=session('user');
       	if(!empty($user)){
       	    redirect('index');
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
        echo 'Invalid Action!';
    }
    
    function test(){
        //echo md5('admin');
        //echo time();
        echo get_client_ip();//202.196.120.202
    }
}
