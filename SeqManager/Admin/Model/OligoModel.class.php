<?php
namespace Admin\Model;
use Think\Model;

class OligoModel extends Model {

    function getData($uid,$cate_id,$tag_id){
    	
        if($cate_id==0){
            $info=$this
                ->where('`condition`>0 and oligo_uid='.$uid)
                ->select(); 
        }else{
            $info=$this
               ->where('`condition`>0 and oligo_uid='.$uid.' and cate_id='.$cate_id)
               ->select(); 
        }
    	
        //改造cate_id
        $cate_list=getList('cate');
        foreach($info as $k=>$v){
	        //$cate_id=$data['cate_id'];
	        $info[$k]['cate_name']=$cate_list[$v['cate_id']];
	        //改造tag_ids
        }
        
        //产生类别提示语
        $hint_text='';
        if($cate_id>0){
        	$cate_name=$cate_list[$cate_id];
            $hint_text='分类['.$cate_name.']';
        }
        
        return array($info,$hint_text);
    }

}