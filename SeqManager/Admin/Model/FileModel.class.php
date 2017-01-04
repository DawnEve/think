<?php
namespace Admin\Model;
use Think\Model;

class FileModel extends Model {
	//彻底删除文件
    function ajaxDelete($id,$uid=0){
        //1.查询数据表，删除文件
        if($uid=0){
            $user=session('user');
            $uid=$user['mg_id'];
        }
        $data=$this->where('`condition`>0 and file_uid='.$uid)->find($id);
        
        $file_path=$data['file_path'];
        $src='/Public/'.$file_path;
        //echo '<img src='.$src.'>';
        
        $rs1= unlink('.'.$src);
        
        if(!$rs1){
            return array(0,'unlink删除文件出错！');
        }else{
    	   //2.删除数据表file记录信息
            $rs2=$this->delete($id);
            if(!$rs2){
                return array(0,'删除file数据表出错！'.$this->getError());
            }else{
    	       //3.更新数据表seq或oligo数据表中file_ids中的相关信息
                
                //唯一正确的出口
            	return array(1, $id);
            }
        }
    	
        return array(0,'删除文件出错！请刷新重试~~~~~~~~~~~~~~');
    }
    
    //放到回收站
    function ajaxDel($id,$uid=0){
       //1.把file表的condition改为0；
       //放到回收站
       $rs=$this->save(array(
            'file_id'=>$id,
            'file_mod_time'=>time(),
            'condition'=>0,//0 进入回收站
       ));
       //2.判断结果是否返回1 or 0
       if($rs>0){
            return array(1, $rs);
       }else{
            return array(0,'删除file数据表出错！'.$this->getError());
       }
    }
    
    
    //文件是否存在
    private function my_file_exists($url,$my_root='./Public/'){
        $file_path_real=$my_root . $url;
        if(file_exists($file_path_real)){
           return true;
        }
        return false;
    }
    
    
    //获取文件详细信息
    function getDetail($id,$uid=0){
    	//获取$uid
        if($uid==0){
            $user=session('user');
            $uid=$user['mg_id'];
        }
    	
        //1.获取数据
        $data=$this->where('`condition`>0 and file_uid='.$uid.' and file_id='.$id)->select();
        if(count($data)<1){
        	myBtn_back();
            echo ('该文件不存在，或者在回收站中。');
            exit();
        }
                
    	//2.检测该文件是否存在
    	$data[0]['isExist']=$this->my_file_exists($data[0]['file_path']);
    	
        //3.分类、标签数据
        $data=$this->id2name($data);
        //die();
        $data=$data[0];
        //debug($data);
        
    	//4.返回数据表和是否存在的数据
    	return $data[0];
    }
    
    
    //把cate_id和tag_ids换成cate名字、tag链接
    private function id2name($info,$cate_id=0,$tag_id=0){
        //改造cate_id
        $cate_list=getList('cate'); 
        //改造tag_ids
        $tag_list=getList('tag');
        //循环改造
        foreach($info as $k=>$v){ //dump($info);
            //$cate_id=$data['cate_id'];
        	if(!empty($v['cate_id'])){
                $info[$k]['cate_name']=$cate_list[$v['cate_id']];
        	}else{
	            $info[$k]['cate_name']='';
	            $info[$k]['cate_id']=0;
        	}
            //debug($info);
            //分裂tag_ids
            $info[$k]['tag_name_links']='';
            $info[$k]['tag_names']='';
            $current_tag_name='';
            if(!empty($v['tag_ids'])){
               $current_tag_id_list=explode(',',$v['tag_ids']); //dump($current_tag_id_list);die();
                   foreach($current_tag_id_list as $current_tag_id){
                       if(array_key_exists($current_tag_id,$tag_list)){
                           $current_tag_name=$tag_list[$current_tag_id];
                           $info[$k]['tag_name_links'] .= "<a class=tag href='/Admin/File/showlist/by/tag/id/".$current_tag_id."'>".$current_tag_name."</a>";
                           $info[$k]['tag_names'] .= $current_tag_name . ',';
                       }
                   }
               //$info[$k]['tag_name_links']=$tag_list[$v['tag_ids']];
            }else{
                $info[$k]['tag_ids'] = '';
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
        //debug($hint_text);
        //返回结果 数组
        //return $info;
        return array($info,$hint_text);
    }
    
    
    function getData($by,$id,$uid=0){
    	//uid
        if($uid==0){
	    	$user=session('user');
	        $uid=$user['mg_id'];
        }
        
        //如果没有by
        if($by=='' or $id==0){
	        $info = $this
	            ->where('`condition`>0 and file_uid='.$uid)  
	            ->select();
	        return $this->id2name($info);
        }elseif($by=='cate'){ //debug($id);
            $info = $this
                ->where('`condition`>0 and file_uid='.$uid.' and cate_id='.$id)  
                ->select();
            return $this->id2name($info,$id);
        }elseif($by=='tag'){
            $info = $this
                ->where('`condition`>0 and file_uid='.$uid.' and tag_ids REGEXP "(^|,)'.$id.'($|,)"')  
                ->select();
                //tag_ids REGEXP '(^|,)5($|,)';
            return $this->id2name($info,0,$id);
        }
    }
}