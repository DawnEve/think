<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class RoleController extends AdminController {
	//显示角色列表
    public function showlist(){
        $role_info=M('Role')->select();
        /*
         array(2) {
  [0] => array(4) {
    ["role_id"] => string(1) "1"
    ["role_name"] => string(6) "老板"
    ["role_auth_ids"] => string(7) "1,4,5,6"
    ["role_auth_ac"] => string(35) "Goods-showlist,Goods-add,Goods-cate"
  }
  [1] => array(4) {
    ["role_id"] => string(1) "2"
    ["role_name"] => string(6) "员工"
    ["role_auth_ids"] => string(8) "2,3,8,11"
    ["role_auth_ac"] => string(30) "Order-showlist,Advert-showlist"
  }
}
         * */
        //echo 'Role-showlist';
        //dump($role_info);
        $this->assign('role_info',$role_info);
        $this->assign('role_info_num',count($role_info));
        $this->display();
    }
    
    //显示角色的权限
    function distribute($role_id){
    	//0.1如果是提交数据
    	if(!empty($_POST)){
    	   //0.2调用模型中的方法，保存权限
    	   $role=D('Role');
    	   $rs=$role->saveAuth(I('auth_id'),$role_id);
    	   if($rs===true){
    	       //跳转到上一页
    	       redirect('showlist',1,'修改成功！');
    	   }else{
    	       exit($rs);
    	   }
    	}
    	
        //1.根据role_id查询对应的角色名字；
        $rinfo=D('Role')->getByRole_id($role_id);
        $this->assign('role_name', $rinfo['role_name']);
        
        //2.查询全部的权限信息，放入模板显示并进行权限分配。
        $p_auth_info=M('Auth')->where("auth_level = 0")->select();//顶级权限
        $c_auth_info=M('Auth')->where("auth_level = 1")->select();//次级权限
            
        //3.显示
        //dump($c_auth_info);
        $this->assign('p_auth_info',$p_auth_info);
        $this->assign('c_auth_info',$c_auth_info);
        $this->display();
        /*
array(10) {
  [0] => array(7) {
    ["auth_id"] => string(1) "4"
    ["auth_name"] => string(12) "商品列表"
    ["auth_pid"] => string(1) "1"
    ["auth_c"] => string(5) "Goods"
    ["auth_a"] => string(8) "showlist"
    ["auth_path"] => string(3) "1-4"
    ["auth_level"] => string(1) "1"
  }
         * */
    }
    
}

/*
array(1) {
  ["user"] => array(4) {
    ["mg_id"] => string(1) "1"
    ["mg_name"] => string(5) "admin"
    ["mg_time"] => string(10) "1473501831"
    ["mg_role_id"] => string(1) "1"
  }
}
 * */