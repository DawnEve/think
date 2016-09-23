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
    
    //ajax返回数据表数据
    function cate(){
    	if(IS_AJAX){//判读是否为post提交过了
	       $data=array(
	        'username'=>I('username'),
	        'content'=>I('content'),
	        'time'=>time()  
	       );
	      $data_send=$data;
    	}
      
        $this->ajaxReturn(M('cate')->select());
    }
    
    
    //ajax返回数据表数据
    function __call($tb_name,$xx){
    	if(IS_AJAX){//判读是否为post提交过了
	       $data=array(
	        'username'=>I('username'),
	        'content'=>I('content'),
	        'time'=>time()  
	       );
	      $data_send=$data;
    	}
      
        $this->ajaxReturn(M($tb_name)->select());
    }
    
    //Oligo/upd()中ajax删除文件
    function file($method,$id){
        if(IS_AJAX){//判读是否为post提交过了
           $data=array(
            'method'=>I('method'),
            'id'=>I('id'),
           );
          //$data_send=$data;
        
          //删除文件
          if($data['method']=='del'){
	         $rs=D('File')->ajaxDel($id);
	         $this->ajaxReturn($rs);
          }
        }
    }
    
}