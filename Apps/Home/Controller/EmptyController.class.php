<?php 
namespace Home\Controller;
use Think\Controller;

/**
 * 空控制器
 * Enter description here ...
 * @author admin
 *
 */
class EmptyController extends Controller{
    function index(){
        $name=CONTROLLER_NAME;//获取控制器名字
        $this->city($name);//调用本类的city方法
    }
    
    //受保护的方法
    protected function city($name){
        echo '当前城市： ' . $name;
    }
}