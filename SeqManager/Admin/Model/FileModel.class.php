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
    
    //回收站
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
}