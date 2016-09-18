<?php
namespace Admin\Controller;
use Think\Controller;

class ApiController extends Controller {
	//检查是否登录
    public function _initialize(){
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
    	$user=session('user');
    	if(!empty($user) && !empty($user['mg_id'])){
    	}else{
    		die('Invalid!');
        }
        
    }
    
    //TODO
    function __call($a,$b){
    	dump($a);
    	dump($b);
    	dump($_GET);
    	dump($_POST);
    	//$this->ajaxReturn($data);
        //$this->ajaxReturn(M('Cate')->select());
    }
    
}