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
        return $this->id2name($info,$cate_id,$tag_id);
    }
    
    
    
    //把cate_id和tag_ids换成cate名字、tag链接
    function id2name($info,$cate_id=0,$tag_id=0){
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
            $info[$k]['tag_names']='';
            $current_tag_name='';
            if(!empty($v['tag_ids'])){
               $current_tag_id_list=explode(',',$v['tag_ids']); //dump($current_tag_id_list);die();
                   foreach($current_tag_id_list as $current_tag_id){
                       if(array_key_exists($current_tag_id,$tag_list)){
                           $current_tag_name=$tag_list[$current_tag_id];
                           $info[$k]['tag_name_links'] .= "<a class=tag href='/admin/Oligo/showlist/tag_id/".$current_tag_id."'>".$current_tag_name."</a>";
                           $info[$k]['tag_names'] .= $current_tag_name . ',';
                       }
                   }
               //$info[$k]['tag_name_links']=$tag_list[$v['tag_ids']];
            }
            
            $info[$k]['tag_names'] =rtrim($info[$k]['tag_names'] , ",");
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
    
    
    
    //获取某id的完整数据
    function getDetail($uid,$oligo_id,$withDel=false){
            //debug($withDel);
    	//获得某oligo详细数据，1.cate和2.tag标准化
        $info_raw = $this->where('`condition`>0 and oligo_uid='.$uid)->select($oligo_id);
        $arr_all = $this->id2name($info_raw);
        $info = $arr_all[0][0];//一维数组
        
        //3.file怎么办?
        $file_ids=$info['file_ids'];
        //debug($file_ids);//string(9) "1,2,3,4,5"
        
        //分解file_ids
        $file_links=''; 
        if(!empty($file_ids)){
            $current_file_id_list=explode(',',$file_ids); 
            $file_data=M('File')->where('`condition`>0 and oligo_uid='.$uid)->select($file_ids); 
            $i=1;
            
            foreach($file_data as $file){
//            	debug($file);
                if($withDel==true){
                	//添加删除按钮
                	$file_links .='<span>附件'.($i++).': <a href="/Public/'.$file['file_path'].'">'.$file['file_name'].'</a>
						&nbsp;&nbsp;<a href="javascript:void(0);" onclick="del_file_btn(this,'.$file['file_id'].')">删除</a>
						<br /></span>';
                }else{
                    $file_links .= '附件'.($i++).': <a href="/Public/'.$file['file_path'].'">'.$file['file_name'].'</a><br>';
                }
            }
        }
        if($file_links==''){
            $file_links='【没有附件】<br>';
        }
	    
        $info['file_links']=$file_links;
        
        //4.palce:
        //4.1盒子信息
        $box_info=M('Box')->where('`condition`>0 and box_uid='.$uid)->find($info['box_id']);
        $info['box_id']=$box_info['box_id'];
        $info['box_name']=$box_info['box_name'];
        $info['box_place']=$box_info['box_place'];
        
        //4.2从box查询fridge
        $box_fr_id=$box_info['box_fr_id'];
        $fr_info=M('Fridge')->where('`condition`>0')->find($box_fr_id);
        $info['fr_id']=$fr_info['fr_id'];
        $info['fr_name']=$fr_info['fr_name'];
        
        //debug($info);
        return $info;
    }

}