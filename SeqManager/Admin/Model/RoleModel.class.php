<?php
namespace Admin\Model;
use Think\Model;

class RoleModel extends Model {
	//
	function saveAuth($auth_id_arr,$role_id){
		//接收到一维数组，代表当前权限信息
		$auth_ids=implode(',', $auth_id_arr);//数组2字符串
		//2.根据id查询具体 控制器-操作方法 名字
		$auth_info=D('Auth')->select($auth_ids);
		//拼装控制器-方法
		$auth_ac='';
		foreach($auth_info as $k){
		   if(''!=$k['auth_c']){
		       $auth_ac .= $k['auth_c'] .'-'. $k['auth_a'].',';
		   }
		}
		$auth_ac=rtrim($auth_ac,',');//删除最后一个逗号
	   //执行更新操作
	   $data=array(
	       'role_id'=>$role_id,
	       'role_auth_ids'=>$auth_ids,
	       'role_auth_ac'=>$auth_ac,
	   );
	   if($this->save($data)){
	       return true;
	   }else{
	       return $this->getError();
	   }
	}

}