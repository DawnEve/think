<?php
namespace Admin\Controller;
use Admin\Common\AdminController;

class AuthController extends AdminController {
	//显示角色列表
    public function showlist(){
    	//从属关系使用order全路径表示 
        $auth_info=M('Auth')->order('auth_path')->select();
        
        //缩进关系，提现从属关系
        
        
        //dump($role_info);
        $this->assign('auth_info',$auth_info);
        $this->assign('auth_info_num',count($auth_info));
        $this->display();
    }
}