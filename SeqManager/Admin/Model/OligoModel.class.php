<?php
namespace Admin\Model;
use Think\Model;

class OligoModel extends Model {

    function getData($uid,$cate_id,$tag_id){
        if($cate_id>0){
            $info=$this
               ->where('`condition`>0 and oligo_uid='.$uid.' and cate_id='.$cate_id)
               ->select(); 
        }elseif($tag_id>0){
        	//tag的bug已经fiexed，求助 http://tieba.baidu.com/p/4790195093
        	//mysql语句，tag_ids要匹配带有5的，不能是55
        	//比如可以是 = 5 =5,6 =2,3,5  =3,4,5,6,7 这几种情况，不能是=3,55,60
            $info=$this
//               ->where('`condition`>0 and oligo_uid='.$uid.' and tag_ids = '.$tag_id .' or tag_ids like "%'.$tag_id.'%"')
               ->where('`condition`>0 and oligo_uid='.$uid.' and tag_ids REGEXP "(^|,)'.$tag_id .'($|,)"')
               ->select(); 
        }elseif($cate_id==0 and $tag_id==0){
            $info=$this
                ->where('`condition`>0 and oligo_uid='.$uid)
                ->select(); 
        }
        
        //返回结果
        return $this->id2name($info);
    }
    
    
    
    //把cate_id和tag_ids换成cate名字、tag链接
    function id2name($info){
    //改造cate_id
        $cate_list=getList('cate');
        //改造tag_ids
        $tag_list=getList('tag');
        //循环改造
        foreach($info as $k=>$v){
            //$cate_id=$data['cate_id'];
            $info[$k]['cate_name']=$cate_list[$v['cate_id']];
            
            //分裂tag_ids
            $info[$k]['tag_name_links']='';
            $current_tag_name='';
            if(!empty($v['tag_ids'])){
               $current_tag_id_list=explode(',',$v['tag_ids']); //dump($current_tag_id_list);die();
                   foreach($current_tag_id_list as $current_tag_id){
                       if(array_key_exists($current_tag_id,$tag_list)){
                           $current_tag_name=$tag_list[$current_tag_id];
                           $info[$k]['tag_name_links'] .= "<a class=tag href='/admin/Oligo/showlist/tag_id/".$current_tag_id."'>".$current_tag_name."</a>";
                       }
                   }
               //$info[$k]['tag_name_links']=$tag_list[$v['tag_ids']];
            }
        }
        
        //产生类别提示语
        $hint_text='';
        if($cate_id>0){
            $cate_name=$cate_list[$cate_id];
            $hint_text='分类['.$cate_name.']';
        }elseif($tag_id>0){
            $tag_name=$tag_list[$tag_id];
            $hint_text='标签['.$tag_name.']';
        }
        
        //返回结果 数组
        return array($info,$hint_text);
    }

}