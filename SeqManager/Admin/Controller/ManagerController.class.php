<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class ManagerController extends AdminController {
	//首页 【已经不需要了[useless]】
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
    	$user = session('user');
    	if(1==$user['mg_id']){
    		$role_name='超级管理员';
    	}else{
	    	$role_id = $user['mg_role_id'];
	    	$role_name=M('Role')->where('role_id='.$role_id)->getField('role_name');
    	}
    	$user_new=M('Manager')->find($user['mg_id']);
    	
    	//dump($role_name);
    	//dump(session('user'));
    	$this->assign('role_name',$role_name);
    	$this->assign('user',$user_new);
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
        redirect('login',0,'退出成功！');
    }

    //列表
    function showlist(){
        $mg_info=M('Manager')->select();
        $this->assign('mg_info',$mg_info);
        
        //查询全部角色信息
        $role_arr=D('Role')->getRoleArr();
        $this->assign('role_arr',$role_arr);
        //dump($role_arr[1]);
        
        $this->assign('mg_info_num',count($mg_info));
       /*
        array(3) {
  [0] => array(5) {
    ["mg_id"] => string(1) "1"
    ["mg_name"] => string(5) "admin"
    ["mg_pwd"] => string(32) "e10adc3949ba59abbe56e057f20f883e"
    ["mg_time"] => string(10) "1473501831"
    ["mg_role_id"] => string(1) "1"
  }
        * */
        $this->display();
    }
    
    //修改用户的角色信息等
    function upd($mg_id){
    	//1.如果是post提交，则在模型中保存数据
    	if(!empty($_POST)){
    	   $rs=D('Manager')->upd($mg_id);
    	   if(true === $rs){
    	       $this->success('成功',U('showlist'));
    	   }else{
    	       $this->error('失败！'.$rs,U('showlist'));
    	   }
    	   die();
    	}
    	
    	
    	
    	//2.获取该管理员信息
        $mg_info=M('Manager')->find($mg_id);
        /*
         array(5) {
  ["mg_id"] => string(1) "2"
  ["mg_name"] => string(3) "tom"
  ["mg_pwd"] => string(32) "e10adc3949ba59abbe56e057f20f883e"
  ["mg_time"] => string(10) "1473500231"
  ["mg_role_id"] => string(1) "2"
}
         * */
        $this->assign('mg_info',$mg_info);
        
        //3.查询全部角色信息
        $role_arr=D('Role')->getRoleArr();
        $this->assign('role_arr',$role_arr);
        
        $this->display();
    }
    
    
    //添加管理员
    function add(){
        //1.如果是post提交，则在模型中插入数据
        if(!empty($_POST)){
            $rs=D('Manager')->addManager();
           
           if($rs>0){
               $this->success('成功',U('showlist'));
           }else{
               $this->error('失败！'.$mg->getError() ,U('showlist'));
           }
           die();
        }
        
        //2.查询全部角色信息
        $role_arr=D('Role')->getRoleArr();
        $this->assign('role_arr',$role_arr);
        
        $this->display();
    }
    
    //删除数据
    function del($mg_id){
        if(1==$mg_id){
            $this->error('不允许删除【超级管理员】！',U('showlist'));
            exit();
        }
        //
       $mg=M('Manager');
       $rs=$mg->delete($mg_id);
       if($rs>0){
            $this->success('成功',U('showlist'));
       }else{
            $this->error('失败',U('showlist'));
       }
    }
    
    //重置密码
    function resetPwd($mg_id){
        getName();
        echo $mg_id;
    }
    
    /**
     * 重置自己的密码
     * 
     * */
    function resetMyPwd(){
        $user=session('user');
    	//0.1如果是post提交，
    	if(empty($user['mg_id'])){
    	   $this->error('请登录后操作！',U('login'));
    	   die();
    	}
    	if(!empty($_POST)){
    	    $mg=M('Manager');
	        $pwd_in_db=$mg->where('mg_id='.$user['mg_id'])->getField('mg_pwd');
	        $old_mg_pwd=md5(I('old_mg_pwd'));//旧密码
	        $mg_pwd=md5(I('mg_pwd'));//新密码
	        //1.验证旧密码输入是正确的
	        if($old_mg_pwd == $pwd_in_db){
	          //2.更新新密码 
	           $_POST['mg_id']=$user['mg_id'];
	           $_POST['mg_pwd']=$mg_pwd;
	           $_POST['mg_mod_time']=time();
	           $mg->create();
	           
	           if($mg->save()){
	               $this->success('密码修改成功！',U('right'));
	           }else{
	               $this->error('密码修改失败-.-'.$mg->getError(),U('right'));
	           }
	           die();
	        }else{
	           $this->error('输入的旧密码不正确！请重试。',U());
	        }
	        die();
    	}else{
    	   $this->display();
    	}
    	
    	
        
        /*
         array(1) {
  ["user"] => array(6) {
    ["mg_id"] => string(1) "5"
    ["mg_name"] => string(9) "王军亮"
    ["mg_role_id"] => string(1) "2"
    ["mg_time"] => string(10) "1473822134"
    ["mg_mod_time"] => string(10) "1474010238"
    ["condition"] => string(1) "1"
  }
}
         * */

        

        
    }
}
