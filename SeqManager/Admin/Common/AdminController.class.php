<?php
namespace Admin\Common;
use Think\Controller;

class AdminController extends Controller {
    public function _initialize(){
        //1.如果是超级管理员，直接返回
        $user=session('user');
        $uid=$user['mg_id']; 
        if(1==$uid) return;
    	//2.当前控制器和操作方法
        $name = CONTROLLER_NAME.'-'.ACTION_NAME; 
        //如果是登陆页，也直接返回
        if(in_array($name, array(
            'Manager-login',
            'Manager-index',
            'Manager-head',
            'Manager-left',
            'Manager-right',
            'Manager-logout',
            'Manager-resetMyPwd',
        ))) return;
        
        //3.否则，进行验证
        $sql='select role_auth_ac from wjl_manager as a, wjl_role as b 
            where a.mg_role_id=b.role_id and a.mg_id='.$uid;
        $auths=M()->query($sql);
        //当前url是否在权限内
        $rs=in_array($name,explode(',',$auths[0]['role_auth_ac']));
        //如果没有权限，则报错并跳转
        if(!$rs){
            //$this->error('没有权限访问该url',U('Manager/index'));
            $name = CONTROLLER_NAME.'/'.ACTION_NAME;
            die("没有权限访问该页面[$name].");
        }
    }
    
    function _empty(){
        echo CONTROLLER_NAME.'/'.ACTION_NAME . ' is Invalid! Please contace 王军亮 for help.';
    }
}