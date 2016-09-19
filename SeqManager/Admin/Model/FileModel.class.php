<?php
namespace Admin\Model;
use Think\Model;

class FileModel extends Model {
    function ajaxDel($id,$uid=0){
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
}