<?php
namespace Admin\Model;
use Think\Model;

class AuthModel extends Model {
	function saveAuth(){
		/*
		 array(6) {
  ["auth_name"] => string(2) "sd"
  ["auth_pid"] => string(1) "1"
  ["auth_c"] => string(2) "sf"
  ["auth_a"] => string(3) "sdf"
  ["auth_path"] => string(3) "sdf"
  ["auth_level"] => string(3) "sdf"
}
		 * */
        //目标：生成auth_path和auth_level
        //1.insert产生记录
        //收集和保存数据
        $data=$this->create();
        $new_id=$this->add();
        
        //2.update这两个条目
        //2.1若pid是顶级权限，则全路径就是当前
        if(0==$data['auth_pid']){
            $auth_path=$new_id;
            $auth_level=0;//顶级
        }else{
        	//2.2否则，获取父级全路径-当前id
        	$pinfo=$this->find($data['auth_pid']);
            $auth_path= $pinfo['auth_path'].'-'. $new_id;
            //计算-的个数-1
            $auth_level=count(explode('-',$auth_path))-1;
        }
        //2.3更新数据
        $dt=array(
            'auth_id'=>$new_id,
            'auth_path'=>$auth_path,
            'auth_level'=>$auth_level,
        );
        return $this->save($dt);
	}


           
           
}