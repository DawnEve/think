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
        echo 'Group-index;';
    }
    
}
