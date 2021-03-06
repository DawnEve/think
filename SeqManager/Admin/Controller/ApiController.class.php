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
    ["mg_name"] => string(9) "王某某"
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
    function search(){
    	if(IS_AJAX){//判读是否为post提交过了
    		//获取数据
	        $data_send=array(
	          'by'=>I('by'),
	          'in'=>I('in'),
	          'wd'=>trim(I('wd')),
	        );
	        //防止没有关键词
	        if($data_send['wd']==''){
	           $this->ajaxReturn(array(0,"请填写关键词！"));
	        }
	        
	        //获取数据
	        $data=A('Search','Logic')->getData($data_send);
	        //$data=$data_send;
	        
	        //返回结果
	        $this->ajaxReturn($data);
	        //$this->ajaxReturn($data_send);
    	}
      
//        $this->ajaxReturn(M('cate')->select());
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
    
    
    //Seq/add()中ajax请求获取引物信息
    function oligo($method,$id,$uid=0){
        if($uid==0){ $user=session('user'); $uid=$user['mg_id']; }
    
        
        if(IS_AJAX){//判读是否为post提交过了
           /*$data=array(
            'method'=>I('method'),
            'id'=>I('id'),
           );*/
          //$data_send=$data;
        
          //获取引物id/名字、序列
          if(I('method')=='get'){
          	 $md=D('Oligo');
             $data=$md
                ->field('oligo_id, oligo_name, oligo_sequence')
                ->where('`condition`>0 and oligo_uid='.$uid.' and oligo_id='.$id)
                ->select();
             $data=$data[0];
             //$this->ajaxReturn($data);
             $data['oligo_sequence']=nl2br($data['oligo_sequence']);
             
             if(count($data)>0){
                $rs=array(1,$data);
             }else{
                $rs=array(0,'获取引物数据出错！'.$md->getError());
             }
             //json返回
             $this->ajaxReturn($rs);
          }
        }
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
          
          $this->ajaxReturn(M($tb_name)->select());
        }
    }
    
    
    //从Seq/add等中由fr_id获取该用户的盒子信息
    function box($uid=0){
        if($uid==0){ $user=session('user'); $uid=$user['mg_id']; }
        if(IS_AJAX){//判读是否为post提交过了
        	//
/*          $data=array(
                'username'=>I('username'),
                'content'=>I('content'),
                'time'=>time()  
            );
            $data_send=$data;*/
        	$fr_id=I('fr_id');
        	
        	$md=D('Box');
             $data=$md
                ->field('box_id, box_name')
                ->where('`condition`>0 and box_uid='.$uid.' and box_fr_id='.$fr_id)
                ->select();
    
            $this->ajaxReturn($data);
        }
    }
    
    
    
}