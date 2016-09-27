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
    	$prefix=$in;
    	
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
    	       /*$data=$md
    	           ->where('`condition`>0 AND '.$prefix.'_uid='.$uid)
    	           ->select();*/
    	if($by=='cate'){
    	   //1.1从cate表cate_name字段中搜索该关键词对应的cate_id(s)[condition uid]
    	   $cate_list=M('cate')
    	       ->field('cate_id,cate_name')
    	       ->where('`condition`>0 and cate_uid='.$uid.' and cate_name like "%'.$wd.'%"')
    	       ->select();
    	   $cate_id_list=array();
    	   foreach($cate_list as $k=>$v){
    	       $cate_id_list[]= $v['cate_id'];
    	   }
    	   //1.1.5cate_id数组变字符串
    	   $cate_id_str='"'.implode($cate_id_list,'","').'"';
    	   //1.2用cate_id(s)从seq/oligo/file中搜索cate_id=该值的条目，并返回
           $data=$md
               ->where('`condition`>0 AND '.$prefix.'_uid='.$uid.
                   ' and cate_id in('.$cate_id_str.')')
               ->select();
    	}elseif($by=='tag'){
    	   //2.1从tag表tag_name字段中搜索该关键词对应的tag_id(s)[condition uid]
           $tag_list=M('tag')->field('tag_id,tag_name')
                //
                ->where('`condition`>0 and tag_uid='.$uid.' and tag_name like "%'.$wd.'%"')
                ->select();
           //拼接sql语句
           $sql_str='';
           foreach($tag_list as $k=>$v){
                $sql_str .= " or tag_ids REGEXP '(^|,)".$v['tag_id']."($|,)'";
           }
           $sql_str=ltrim($sql_str,' or');
           $sql = 'select * from wjl_'.$in.' where `condition`>0 AND '.$prefix.'_uid='.$uid;
           $sql .= ' and ('.$sql_str .')';
           
           //2.2用tag_id(s)从seq/oligo/file中搜索tag_id=该值的条目，并返回
    	   $data=$md->query($sql);
    		
    		
    	}elseif($by=='keyword'){
    	   //3.0从seq/oligo/file中搜索name或note匹配keyword的条目，并返回。
    		if($wd==''){
    		  $data=$md 
    		      ->where('`condition`>0 AND '.$prefix.'_uid='.$uid)
    		      ->select();
    		}else{
	    	   $data=$md
	    	       ->where('`condition`>0 AND '.$prefix.'_uid='.$uid.
	    	          ' and ('.$prefix.'_name like "%'.$wd.'%" or '.$prefix.'_note like "%'.$wd.'%")')
	    	       ->select();
    		}
    	}else{
    	   $data=array(
    	       '没有数据'
    	   );
    	}
    	
    	//$data
        return $data;
    }
    
}