<?php
namespace Admin\Logic;
use Think\Controller;


class SearchLogic extends Controller{
    //
    function getData($info,$uid=0){
    	//获取搜索指标
    	$by=$info['by'];
    	$in=$info['in'];
    	$wd=$info['wd'];
    	
    	//验证uid
        if($uid==0){ 
        	$user=session('user'); 
        	$uid=$user['mg_id'];
            if(empty($uid)){
                die('Invalid ajax.');
            }
        }
    	
    	//实例化数据库
    	$md=M($in);
    	$data=array();
    	       $data=$md
    	           ->where('`condition`>0 AND '.$in.'_uid='.$uid)
    	           ->select();
    	if($by=='cate'){
    	   //1.1从cate表cate_name字段中搜索该关键词对应的cate_id(s)[condition uid]
    	       		
    	   //1.2用cate_id(s)从seq/oligo/file中搜索cate_id=该值的条目，并返回
    		
    		
    	}elseif($by=='tag'){
    	   //2.1从tag表tag_name字段中搜索该关键词对应的tag_id(s)[condition uid]
           
            
           //2.2用tag_id(s)从seq/oligo/file中搜索tag_id=该值的条目，并返回
    	   
    		
    		
    	}elseif($by=='keyword'){
    	   //3.0从seq/oligo/file中搜索name或note匹配keyword的条目，并返回。
    	
    	}else{
    	   $data=array(
    	       '没有数据'
    	   );
    	}
    	
    	//$data
        return $info;
    }
    
}