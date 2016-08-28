<?php 
namespace Home\Controller;
use Think\Controller;

class GroupController extends Controller{
    //空操作
    function _empty(){
        echo 'This page is NOT found!<hr />';
        echo 'Controller: ' . CONTROLLER_NAME;
    }
    
    //首页
	function index(){
        echo 'Group-index;<hr>';
        
        //打印出所有配置项
        dump(C());
    }
    
    //重定向到操作
    function go(){
        $this->redirect('Group/index','id=1&name=wjl',3,'跳转中...');
    }
    
}
